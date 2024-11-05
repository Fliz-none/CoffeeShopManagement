<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class TableController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if (isset($request->key)) {
            $objs = Table::query()->where('company_id', Auth::user()->company_id);
            switch ($request->key) {
                case 'list':
                    return response()->json($objs->get(), 200);
                case 'select2':
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
                $tables = Table::select('*')->where('company_id', Auth::user()->company_id)->orderBy('id', 'desc');
                return DataTables::of($tables)
                    ->addColumn('checkboxes', function ($obj) {
                        return '<input class="form-check-input choice" type="checkbox" name="choices[]" value="' . $obj->id . '">';
                    })
                    ->editColumn('code', function ($obj) {
                        return '<a class="btn btn-link text-decoration-none text-start text-primary btn-update-table" data-id="' . $obj->id . '"><b>' . $obj->code . '</b></a>';
                    })
                    ->editColumn('name', function ($obj) {
                        return '<a class="btn btn-link text-decoration-none text-start text-primary btn-update-table" data-id="' . $obj->id . '"><b>' . $obj->name . '</b></a>';
                    })
                    ->editColumn('status', function ($obj) {
                        return $obj->statusStr;
                    })
                    ->addColumn('action', function ($obj) {
                        return '
                        <form method="post" action="' . route('admin.table.remove') . '" class="save-form">
                            <input type="hidden" name="choices[]" value="' . $obj->id . '"/>
                            <button type="submit" class="btn btn-link text-decoration-none btn-remove cursor-pointer">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>';
                    })
                    ->rawColumns(['checkboxes', 'code', 'name', 'status', 'action'])
                    ->make(true);
            } else {
                $pageName = 'Quản lý bàn';
                return view('admin.table', compact('pageName'));
            }
        }
    }

    public function create(Request $request)
    {

        $rules = [
            'name' => ['required', 'string', 'min:3', 'max:125']
        ];

        $messages = [
            'name.required' => 'Tên không được để trống',
            'name.min' => 'Tên phải có ít nhất 3 ký tự',
            'name.max' => 'Tên chứa tối đa 125 ký tự',
            'name.string' => 'Kiểu dữ liệu không hợp lệ',
        ];

        $request->validate($rules, $messages);

        $table = new Table([
            'name' => $request->name,
            'company_id' => Auth::user()->company_id,
            'note' => $request->note,
        ]);
        $table->save();
        cache()->forget('tables');
        $response = array(
            'status' => 'success',
            'msg' => 'Đã tạo ' . $table->name
        );

        return response()->json($response, 200);
    }


    public function update(Request $request)
    {
        $table = Table::find($request->id);

        $rules = [
            'name' => ['required', 'string', 'min:3', 'max:125']
        ];

        $messages = [
            'name.required' => 'Tên không được để trống',
            'name.min' => 'Tên phải có ít nhất 3 ký tự',
            'name.max' => 'Tên chứa tối đa 125 ký tự',
            'name.string' => 'Kiểu dữ liệu không hợp lệ',
        ];

        $request->validate($rules, $messages);
        if ($table) {
            $table->name = $request->name;
            $table->note = $request->note;
            $table->company_id = Auth::user()->company_id;
            $table->save();

            cache()->forget('tables');
            return response()->json([
                'status' => 'success',
                'msg' => 'Đã cập nhật thành công bàn ' . $table->name,
            ], 200);
        } else {
            return response()->json([
                'status' => 'danger',
                'msg' => 'Không tìm thấy bàn để cập nhật.',
            ], 404);
        }
    }


    public function remove(Request $request)
    {
        $tables = [];
        foreach ($request->choices as $key => $id) {
            $table = Table::find($id);
            if ($table->status != 1 && $table->status != 2) {
                $table->delete();
            } else {
                $response = array(
                    'status' => 'danger',
                    'title' => 'Bàn đang hoạt động không thể xóa',
                );
                return response()->json($response, 200);
            }
            cache()->forget('tables');
            array_push($tables, $table->name);
        }
        $response = array(
            'status' => 'success',
            'title' => 'Đã xóa bàn ' . implode(', ', $tables)
        );
        return response()->json($response, 200);
    }
}
