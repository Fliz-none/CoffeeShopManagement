<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class SettingController extends Controller
{
    const NAME = 'Cài đặt';

    public function __construct()
    {
        parent::__construct();
        if ($this->user === null) {
            $this->user = Auth::user();
        }
        $this->middleware(['admin', 'auth']);
    }

    /**
     * Show the application setting.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $pageName = self::NAME;
        $settings = Auth::user()->company;
        $banks = Http::get('https://api.vietqr.io/v2/banks')->json();
        return view('admin.settings', compact('pageName', 'settings', 'banks'));
    }

    public function updateSetting($key, $value)
    {
        $settings = Setting::pluck('value', 'key');
        if (array_key_exists($key, $settings->toArray())) {
            if ($value != $settings[$key]) {
                Setting::where('key', $key)->update([
                    'value' => $value,
                    'company_id' => $this->user->company_id
                ]);
            }
        } else {
            Setting::create(['key' => $key, 'value' => $value]);
        }
        cache()->forget('settings');
    }

    public function updateImage(Request $request)
    {
        try {
            $company = Company::find(Auth::user()->company_id);
            $company->update(['favicon' => $request->favicon]);
            $company->update(['logo_horizon' => $request->logo_horizon]);
            $company->update(['logo_square' => $request->logo_square]);
            $company->update(['logo_horizon_bw' => $request->logo_horizon_bw]);
            $company->update(['logo_square_bw' => $request->logo_square_bw]);
            $company->save();
            $response = [
                'status' => 'success',
                'msg' => 'Cập nhật hình ảnh thành công'
            ];
        } catch (\Throwable $th) {
            $response = [
                'status' => 'error',
                'msg' => 'Đã có lỗi xảy ra. Vui lòng thử lại sau!'
            ];
        }
        return redirect()->back()->with('response', $response);
    }

    public static function setEnv(array $values)
    {
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);
        if (count($values) > 0) {
            foreach ($values as $envKey => $envValue) {
                $keyPosition = strpos($str, "{$envKey}=");
                $endOfLinePosition = strpos($str, "\n", $keyPosition);
                $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
                // If key does not exist, add it
                if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                    $str .= "{$envKey}='{$envValue}'\n";
                } else {
                    $str = str_replace($oldLine, "{$envKey}='{$envValue}'", $str);
                }
            }
        }
        $str = substr($str, 0, -1);
        $str .= "\n";
        if (!file_put_contents($envFile, $str)) {
            return false;
        }
        return true;
    }

    public function updateEmail(Request $request)
    {
        try {
            $this->setEnv(array(
                'APP_NAME' => $request->app_name,
                'MAIL_DRIVER' => $request->mail_driver,
                'MAIL_HOST' => $request->mail_host,
                'MAIL_PORT' => $request->mail_port,
                'MAIL_USERNAME' => $request->mail_username,
                'MAIL_PASSWORD' => $request->mail_password,
                'MAIL_ENCRYPTION' => $request->mail_encryption,
                'MAIL_FROM_ADDRESS' => $request->mail_from_address,
            ));
            $response = [
                'status' => 'success',
                'msg' => 'Đã lưu thiết lập gửi mail'
            ];
        } catch (\Throwable $th) {
            $response = [
                'status' => 'error',
                'msg' => 'Đã có lỗi xảy ra. Vui lòng thử lại sau!'
            ];
        }
        return redirect()->back()->with('response', $response);
    }

    public function updateCompany(Request $request)
    {
        $rules = [
            'company_name' => ['nullable', 'string', 'min:2', 'max:125'],
            'company_address' => 'string|nullable',
            'company_website' => 'string|required',
            'company_phone' => ['nullable', 'numeric', 'digits:10', 'regex:/^(0|\+84)(\s|\.)?((3[2-9])|(5[689])|(7[06-9])|(8[1-689])|(9[0-46-9]))(\d)(\s|\.)?(\d{3})(\s|\.)?(\d{3})$/'],
            'company_email' => ['nullable', 'string', 'min:5', 'email', 'max:125'],
            'company_tax_id' => 'numeric|nullable',
            'company_tax_meta' => ['nullable', 'string', 'min:2', 'max:125'],
        ];
        $request->validate($rules);
        try {
            $company = Company::find(Auth::user()->company_id);
            $company->update(['name', $request->company_name]);
            $company->update(['address', $request->company_address]);
            $company->update(['website', $request->company_website]);
            $company->update(['phone', $request->company_phone]);
            $company->update(['email', $request->company_email]);
            $company->update(['tax_id', $request->company_tax_id]);
            $company->save();
            $response = [
                'status' => 'success',
                'msg' => 'Đã lưu cài đặt công ty'
            ];
        } catch (\Throwable $th) {
            $response = [
                'status' => 'error',
                'msg' => 'Đã có lỗi xảy ra. Vui lòng thử lại sau!'
            ];
        }
        return redirect()->back()->with('response', $response);
    }

    public function updatePay(Request $request)
    {
        $request->validate([
            'bank_ids' => 'required|array',
            'bank_numbers' => 'required|array',
            'bank_accounts' => 'required|array',
            'bank_ids.*' => 'required',
            'bank_accounts.*' => 'required|string|max:255',
            'bank_numbers.*' => 'required|numeric',
        ], [
            'bank_ids.required' => 'Vui lòng chọn ít nhất một ngân hàng.',
            'bank_ids.array' => 'Danh sách ngân hàng không hợp lệ.',
            'bank_numbers.required' => 'Vui lòng nhập ít nhất một số tài khoản.',
            'bank_numbers.array' => 'Danh sách số tài khoản không hợp lệ.',
            'bank_accounts.required' => 'Vui lòng nhập ít nhất một tên tài khoản.',
            'bank_accounts.array' => 'Danh sách tên tài khoản không hợp lệ.',

            'bank_ids.*.required' => 'Vui lòng chọn một ngân hàng.',
            'bank_accounts.*.required' => 'Vui lòng nhập tên tài khoản.',
            'bank_accounts.*.string' => 'Tên tài khoản phải là chuỗi ký tự.',
            'bank_accounts.*.max' => 'Tên tài khoản không được vượt quá 255 ký tự.',
            'bank_numbers.*.required' => 'Vui lòng nhập số tài khoản.',
            'bank_numbers.*.numeric' => 'Số tài khoản phải là số.',
        ]);
        try {
            $accounts = [];
            foreach ($request->bank_ids as $i => $value) {
                $accounts[] = [
                    'bank_id' => $value,
                    'bank_name' => $request->bank_names[$i],
                    'bank_account' => $request->bank_accounts[$i],
                    'bank_number' => $request->bank_numbers[$i],
                ];
            }
            $company = Company::find(Auth::user()->company_id);
            $company->update(['bank_info' => json_encode($accounts)]);
            $company->save();
            $response = [
                'status' => 'success',
                'msg' => 'Đã lưu cài đặt thanh toán'
            ];
        } catch (\Throwable $th) {
            $response = [
                'status' => 'error',
                'msg' => 'Đã có lỗi xảy ra. Vui lòng thử lại sau!'
            ];
        }
        return redirect()->back()->with('response', $response);
    }

}
