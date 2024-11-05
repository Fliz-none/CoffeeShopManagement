<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer; // Thay đổi model từ Table thành Customer
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if (isset($request->key)) {
            $objs = Customer::query()->where('company_id', Auth::user()->company_id);
            switch ($request->key) {
                case 'list':
                    return response()->json($objs->get(), 200);

                case 'search':
                    $acc_str = 'data-name="' . $request->q . '"';
                    $result = $objs
                        ->where('id', 'LIKE', '' . $request->q . '%')
                        ->orWhere('name', 'LIKE', '%' . $request->q . '%')
                        ->orWhere('phone', 'LIKE', '%' . $request->q . '%')
                        ->take(20)->get()->map(function ($obj) {
                            $text = $obj->name . ($obj->phone ? ' - ' . $obj->phone : '');
                            return '<li class="list-group-item border border-0 pb-0 text-center">
                                        <button class="btn btn-link text-decoration-none fw-bold me-1 btn-select-customer" id="customer-' . $obj->id . '" data-id="' . $obj->id . '" data-name="' . $obj->name.'">' .$text. '</button>
                                    </li>';
                        });
                        // ->push('<li class="list-group-item border border-0 pb-0">
                        //             <button class="btn btn-link text-decoration-none w-100 btn-create-customer" ' . $acc_str . '>
                        //                 Tạo mới với SĐT: ' . $request->q . '
                        //             </button>');
                    break;
                default:
                    $obj = $objs->find($request->key);
                    if ($obj) {
                        $result = $obj;
                    } else {
                        abort(404);
                    }
                    break;
            }
            return response()->json($result, 200);
        } else {
            if ($request->ajax()) {
                $customers = Customer::select('*')->where('company_id', Auth::user()->company_id)->orderBy('id', 'desc');
                return DataTables::of($customers)
                    ->addColumn('checkboxes', function ($obj) {
                        return '<input class="form-check-input choice" type="checkbox" name="choices[]" value="' . $obj->id . '">';
                    })
                    ->addColumn('code', function ($obj) {
                        return '<a class="btn btn-link text-decoration-none text-start text-primary btn-update-customer" data-id="' . $obj->id . '"><b>' . $obj->code . '</b></a>';
                    })
                    ->editColumn('name', function ($obj) {
                        return '<a class="btn btn-link text-decoration-none text-start text-primary btn-update-customer" data-id="' . $obj->id . '"><b>' . $obj->name . '</b></a>';
                    })
                    ->editColumn('status', function ($obj) {
                        return $obj->statusStr; // Giả sử bạn có thuộc tính này trong model Customer
                    })
                    ->addColumn('action', function ($obj) {
                        return '
                        <form method="post" action="' . route('admin.customer.remove') . '" class="save-form">
                            <input type="hidden" name="choices[]" value="' . $obj->id . '"/>
                            <button type="submit" class="btn btn-link text-decoration-none btn-remove cursor-pointer">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>';
                    })
                    ->rawColumns(['checkboxes', 'code', 'name', 'status', 'action'])
                    ->make(true);
            } else {
                $pageName = 'Quản lý khách hàng'; // Cập nhật tên trang
                return view('admin.customer', compact('pageName'));
            }
        }
    }

    public function create(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'min:3', 'max:125'],
            'phone' => ['nullable', 'numeric', 'digits:10', 'regex:/^0[0-9]{9,10}$/', 'unique:customers'],
            // Thêm các quy tắc cho trường khác nếu cần
        ];

        $messages = [
            'name.required' => 'Tên không được để trống',
            'name.min' => 'Tên phải có ít nhất 3 ký tự',
            'name.max' => 'Tên chứa tối đa 125 ký tự',
            'name.string' => 'Kiểu dữ liệu không hợp lệ',
        ];

        $request->validate($rules, $messages);

        $customer = new Customer([ // Thay đổi từ Table thành Customer
            'name' => $request->name,
            'phone' =>$request->phone,
            'level' =>$request->level,
            'company_id' => Auth::user()->company_id,
        ]);
        $customer->save();
        cache()->forget('customers'); // Cập nhật cache

        return response()->json(['status' => 'success', 'msg' => 'Đã tạo ' . $customer->name], 200);
    }

    public function update(Request $request)
    {
        $customer = Customer::find($request->id);

        $rules = [
            'name' => ['required', 'string', 'min:3', 'max:125'],
            // Thêm các quy tắc cho trường khác nếu cần
        ];

        $messages = [
            'name.required' => 'Tên không được để trống',
            'name.min' => 'Tên phải có ít nhất 3 ký tự',
            'name.max' => 'Tên chứa tối đa 125 ký tự',
            'name.string' => 'Kiểu dữ liệu không hợp lệ',
        ];

        $request->validate($rules, $messages);

        if ($customer) {
            $customer->name = $request->name;
            $customer->phone = $request->phone;
            $customer->company_id = Auth::user()->company_id;
            $customer->level = $request->level; // Gán level từ request
            $customer->save();

            cache()->forget('customers'); // Cập nhật cache
            return response()->json([
                'status' => 'success',
                'msg' => 'Đã cập nhật thành công khách hàng ' . $customer->name
            ], 200);
        } else {
            return response()->json(['status' => 'danger', 'msg' => 'Không tìm thấy khách hàng để cập nhật.'], 404);
        }
    }

    public function remove(Request $request)
    {
        $customers = [];
        foreach ($request->choices as $key => $id) {
            $customer = Customer::find($id);
            // Logic xóa khách hàng
            $customer->delete();
            cache()->forget('customers'); // Cập nhật cache
            array_push($customers, $customer->name);
        }
        return response()->json(['status' => 'success', 'title' => 'Đã xóa khách hàng ' . implode(', ', $customers)], 200);
    }
}
