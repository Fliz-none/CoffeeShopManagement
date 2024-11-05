<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CompanyController extends Controller
{
    const NAME = 'công ty',
        RULES = [
            'name' => ['required', 'string', 'max:255'],
            'deadline' => ['required', 'date', 'after_or_equal:today'],
            'contract_total' => ['required', 'numeric', 'min:0'],
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'numeric', 'digits:10', 'regex:/^0[0-9]{9,10}$/'],
            'email' => ['required', 'email', 'max:255'],
            'tax_id' => ['required', 'string', 'min:8', 'max:12'],
            'has_website' => ['nullable'],
            'has_shop' => ['nullable'],
            'has_warehouse' => ['nullable'],
            'has_clinic' => ['nullable'],
            'has_attendance' => ['nullable'],
            'has_beauty' => ['nullable'],
            'has_booking' => ['nullable'],
            'note' => ['nullable', 'string', 'max:1000'],
        ],
        MESSAGES = [
            'name.required' => 'Vui lòng nhập tên.',
            'name.string' => 'Tên không hợp lệ.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',

            'deadline.required' => 'Vui lòng nhập ngày hạn.',
            'deadline.date' => 'Ngày hạn không hợp lệ.',
            'deadline.after_or_equal' => 'Ngày hạn phải là hôm nay hoặc sau đó.',

            'contract_total.required' => 'Vui lòng nhập tổng số tiền hợp đồng.',
            'contract_total.numeric' => 'Tổng số tiền phải là số.',
            'contract_total.min' => 'Tổng số tiền không được nhỏ hơn 0.',

            'address.required' => 'Vui lòng nhập địa chỉ.',
            'address.string' => 'Địa chỉ không hợp lệ.',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',

            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.regex' => 'Số điện thoại không hợp lệ.',
            'phone.min' => 'Số điện thoại phải có ít nhất 10 chữ số.',
            'phone.max' => 'Số điện thoại không được vượt quá 15 chữ số.',
            'phone.unique' => 'Số điện thoại đã có công ty sử dụng.',

            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'email.max' => 'Email không được vượt quá 255 ký tự.',

            'tax_id.required' => 'Vui lòng nhập mã số thuế.',
            'tax_id.string' => 'Mã số thuế không hợp lệ.',
            'tax_id.min' => 'Mã số thuế phải có ít nhất 8 ký tự.',
            'tax_id.max' => 'Mã số thuế không được vượt quá 12 ký tự.',

            'note.string' => 'Ghi chú không hợp lệ.',
            'note.max' => 'Ghi chú không được vượt quá 1000 ký tự.',
        ];
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        parent::__construct();
        if ($this->user === null) {
            $this->user = Auth::user();
        }
        $this->middleware(['auth']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if (isset($request->key)) {
            $objs = Company::query();
            switch ($request->key) {
                default:
                    $obj = $objs->with('user')->find($request->key);
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
                $companys = Company::query();
                return DataTables::of($companys)
                    ->editColumn('code', function ($obj) {
                        if (!empty($this->user->can(User::READ_COMPANIES))) {
                            $code = '<a class="btn btn-link text-decoration-none fw-bold text-start btn-update-company" data-id="' . $obj->id . '">' . $obj->code . '</a>';
                        } else {
                            $code = '<span class="fw-bold">' . $obj->code . '</span>';
                        }
                        return $code . '<br/><small class="text-nowrap">' . $obj->created_at->format('d/m/Y H:i') . '</small>';
                    })
                    ->filterColumn('code', function ($query, $keyword) {
                        $array = explode('/', $keyword);
                        $query->when(count($array) > 1, function ($query) use ($keyword, $array) {
                            $date = (count($array) == 3 ? $array[2] : date('Y')) . '-' . str_pad($array[1], 2, "0", STR_PAD_LEFT) . '-' . str_pad($array[0], 2, "0", STR_PAD_LEFT);
                            $query->whereDate('created_at', $date);
                        });
                        $query->when(count($array) == 1, function ($query) use ($keyword) {
                            $query->where('companys.id', $keyword);
                        });
                    })
                    ->orderColumn('code', function ($query, $order) {
                        $query->orderBy('id', $order);
                    })
                    ->editColumn('name', function ($obj) {
                        if ($this->user->can(User::UPDATE_COMPANY)) {
                            return '<a class="btn btn-link text-decoration-none text-start btn-update-company" data-id="' . $obj->id . '">' . $obj->name . '</a>';
                        } else {
                            return $obj->name;
                        }
                    })
                    ->filterColumn('name', function ($query, $keyword) {
                        $query->where('name', 'like', "%" . $keyword . "%")
                            ->orWhere('email', 'like', "%{$keyword}%");
                    })
                    ->editColumn('address', function ($obj) {
                        return $obj->address;
                    })
                    ->editColumn('domain', function ($obj) {
                        return '<a href="' . $obj->domain . '">' . $obj->domain . '</a>';
                    })
                    ->editColumn('phone', function ($obj) {
                        return '<span>' . $obj->phone . '</span><br/><small>' . $obj->email . '</small>';
                    })
                    ->editColumn('status', function ($obj) {
                        return '<span class="badge bg-' . ($obj->status ? 'success' : 'danger') . '">' . $obj->statusStr . '</span>';
                    })
                    ->editColumn('deadline', function ($obj) {
                        return \Carbon\Carbon::parse($obj->deadline)->format('d/m/Y');
                    })
                    ->addColumn('action', function ($obj) {
                        $str = '<div class="d-flex justify-content-end">';
                        if ($this->user->can(User::UPDATE_USER)) {
                            $str .= '<form method="post" action="' . route('admin.company.login') . '" class="save-form">
                                        <input type="hidden" name="company_id" value="' . $obj->id . '"/>
                                        <button type="submit" class="btn btn-link text-decoration-none btn-company-login cursor-pointer">
                                            <i class="bi bi-box-arrow-in-right"></i>
                                        </button>
                                    </form>';
                        }
                        return $str . '</div>';
                    })
                    ->rawColumns([
                        'code',
                        'name',
                        'domain',
                        'phone',
                        'status',
                        'action'
                    ])->make(true);
            } else {
                $pageName = 'Quản lý ' . self::NAME;
                return view('admin.companies', compact('pageName'));
            }
        }
    }

    public function create(Request $request)
    {

        if (!empty($this->user->can(User::CREATE_COMPANY))) {
            DB::beginTransaction();
            try {
                $company = Company::create([
                    'name' => $request->input('name'),
                    'user_id' => $request->input('user_id'),
                    'deadline' => $request->input('deadline'),
                    'contract_total' => $request->input('contract_total'),
                    'address' => $request->input('address'),
                    'domain' => $request->input('domain'),
                    'phone' => $request->input('phone'),
                    'email' => $request->input('email'),
                    'tax_id' => $request->input('tax_id'),
                    'has_website' => $request->has('has_website'),
                    'has_shop' => $request->has('has_shop'),
                    'has_warehouse' => $request->has('has_warehouse'),
                    'has_clinic' => $request->has('has_clinic'),
                    'has_attendance' => $request->has('has_attendance'),
                    'has_beauty' => $request->has('has_beauty'),
                    'has_booking' => $request->has('has_booking'),
                    'status' => $request->has('status'),
                    'note' => $request->input('note'),
                ]);

                LogController::create("tạo", self::NAME, $company->code);
                //Thêm vào settings
                $settings = [
                    [1, 'logo_square', null],
                    [2, 'logo_horizon', null],
                    [3, 'logo_square_bw', null],
                    [4, 'logo_horizon_bw', null],
                    [5, 'favicon', null],
                    [6, 'company_name', $company->name],
                    [7, 'company_address', $company->address],
                    [8, 'company_website', $company->website],
                    [9, 'company_brandname', null],
                    [10, 'company_hotline', null],
                    [11, 'company_phone', $company->phone],
                    [12, 'company_email', $company->email],
                    [13, 'company_tax_id', $company->tax_id],
                    [14, 'company_tax_meta', null],
                    [15, 'social_facebook', null],
                    [16, 'social_zalo', null],
                    [17, 'social_youtube', null],
                    [18, 'social_tiktok', null],
                    [19, 'social_telegram', null],
                    [20, 'contact_map', null],
                    [21, 'head_code', null],
                    [22, 'bodytop_code', null],
                    [23, 'bodybottom_code', null],
                    [24, 'priority_interface', null],
                    [25, 'bank_info', null],
                    [26, 'print_invoice', null],
                    [27, 'symptom_group', null],
                    [28, 'allow_expired_sale', '1'],
                    [29, 'expired_notification_before', '60'],
                ];

                foreach ($settings as $key => $setting) {
                    DB::table('settings')->insert([
                        'company_id' => $company->id,
                        'key' => $setting[1],
                        'value' => $setting[2],
                    ]);
                }

                DB::commit();
                $response = [
                    'status' => 'success',
                    'msg' => 'Đã tạo ' . self::NAME . ' ' . $company->code,
                ];
            } catch (\Exception $e) {
                return response()->json(['errors' => ['error' => ['Đã xảy ra lỗi: ' . $e->getMessage()]]], 422);
            }
        } else {
            return response()->json(['errors' => ['role' => ['Thao tác chưa được cấp quyền!']]], 422);
        }
        return response()->json($response, 200);
    }

    public function update(Request $request)
    {
        $request->validate(self::RULES, self::MESSAGES);

        if (!empty($this->user->can(User::UPDATE_COMPANY))) {
            if ($request->has('id')) {
                DB::beginTransaction();
                try {
                    $company = Company::find($request->id);
                    if ($company) {
                        $company->update([
                            'name' => $request->input('name'),
                            'deadline' => $request->input('deadline'),
                            'user_id' => $request->input('user_id'),
                            'contract_total' => $request->input('contract_total'),
                            'address' => $request->input('address'),
                            'domain' => $request->input('domain'),
                            'phone' => $request->input('phone'),
                            'email' => $request->input('email'),
                            'tax_id' => $request->input('tax_id'),
                            'has_shop' => $request->has('has_shop'),
                            'has_revenue' => $request->has('has_revenue'),
                            'has_log' => $request->has('has_log'),
                            'has_attendance' => $request->has('has_attendance'),
                            'has_account' => $request->has('has_account'),
                            'note' => $request->input('note'),
                            'status' => $request->has('status'),
                        ]);
                        LogController::create('sửa', self::NAME, $company->id);

                        $settings = [
                            'company_name' => $company->name,
                            'company_address' => $company->address,
                            'company_website' => $company->website,
                            'company_phone' => $company->phone,
                            'company_email' => $company->email,
                            'company_tax_id' => $company->tax_id,
                        ];

                        foreach ($settings as $key => $value) {
                            DB::table('settings')
                                ->where('company_id', $company->id)
                                ->where('key', $key)
                                ->update(['value' => $value]);
                        }

                        DB::commit();
                        cache()->forget('settings');
                        $response = [
                            'status' => 'success',
                            'msg' => 'Đã cập nhật ' . self::NAME . ' ' . $company->code,
                        ];
                    } else {
                        DB::rollBack();
                        $response = array(
                            'status' => 'danger',
                            'msg' => 'Đã có lỗi xảy ra, vui lòng tải lại trang và thử lại!'
                        );
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    Controller::resetAutoIncrement('companies');
                    Controller::resetAutoIncrement('settings');
                    Controller::resetAutoIncrement('logs');
                    return response()->json(['errors' => ['error' => ['Đã xảy ra lỗi: ' . $e->getMessage()]]], 422);
                }
            } else {
                $response = array(
                    'status' => 'danger',
                    'msg' => 'Đã có lỗi xảy ra, vui lòng tải lại trang và thử lại!'
                );
            }
        } else {
            return response()->json(['errors' => ['role' => ['Thao tác chưa được cấp quyền!']]], 422);
        }

        return response()->json($response, 200);
    }


    public function remove(Request $request)
    {
        $names = [];
        foreach ($request->choices as $key => $id) {
            $company = Company::find($id);
            $company->delete();
            array_push($names, $company->name);
            LogController::create("xóa", self::NAME, $company->id);
        }
        return response()->json([
            'status' => 'success',
            'msg' => 'Đã xóa ' . self::NAME . ' ' . $company->code,
        ], 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'company_id' => ['required', 'exists:companies,id'],
        ], [
            'company_id.required' => 'Vui lòng chọn công ty.',
            'company_id.exists' => 'Công ty không tồn tại.',
        ]);

        $company = Company::find($request->company_id);

        if (!$company) {
            return response()->json(['error' => 'Đã có lỗi xảy ra vui lòng thử lại sau.'], 403);
        }

        $user = $this->user;
        if ($user->company_id != $request->company_id) {
            $user->company_id = $request->company_id;
            $user->save();
            LogController::create('đổi công ty từ ID ' . $user->company_id . ' sang ' . $request->company_id, 'user', $user->id);
            cache()->forget('roles');
            cache()->forget('animals');
            cache()->forget('attributes');
            cache()->forget('dealers');
            cache()->forget('cashiers');
            cache()->forget('warehouses');
            cache()->forget('branches');
            cache()->forget('categories');
            cache()->forget('catalogues');
            cache()->forget('settings');
            cache()->forget('services');
            cache()->forget('symptoms');
            cache()->forget('diseases');
            cache()->forget('medicines');
            return response()->json([
                'status' => 'success',
                'msg' => 'Đã đổi ' . self::NAME . ' thành công ' . $company->name,
            ], 200);
        } else {
            return response()->json([
                'status' => 'success',
                'msg' => 'Bạn đã ở công ty này',
            ], 200);
        }
    }
}
