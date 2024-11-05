<?php
namespace App\Http\Requests;

use App\Models\User;
use App\Rules\NoSequentialCharactersRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class ChangePasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[0-9]/', // Ít nhất một chữ số
                'regex:/[A-Z]/', // Ít nhất một ký tự viết hoa
                'regex:/[a-z]/', // Ít nhất một ký tự viết thường
                'regex:/[@$!%*?&#]/', // Ít nhất một ký tự đặc biệt
                function ($attribute, $value, $fail) {
                    $user = User::find($this->id);
                    if (Hash::check($value, $user->password)) {
                        $fail('Mật khẩu mới không được trùng mật khẩu hiện tại.');
                    }
                },
                new NoSequentialCharactersRule, // Custom rule để kiểm tra ký tự liên tục
            ],
        ];
    }
    
    public function messages()
    {
        return [
            'password.different' => 'Mật khẩu mới không được trùng mật khẩu hiện tại.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.regex' => 'Mật khẩu phải chứa ít nhất một chữ số, một ký tự viết hoa, một ký tự viết thường, và một ký tự đặc biệt.',
        ];
    }
}
