<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class CustomerUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        Log::info($this);
        return [
            'name' => ['required'],
            'address' => ['required'],
            // 'email' => "email|unique:customers,email,". $user->id,
            'email' => ['required','email',Rule::unique('customers','email')->ignore($this['id'])],
            'tel' => ['required','regex:/(0)[0-9]{9}/'],
            'line_id' => ['required']
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'กรุณาระบุชื่อ',
            'address.required' => 'กรุณาระบุที่อยู่',
            'email.required' => 'กรุณาระบุ email',
            'email.email' => 'รูปแบบ email ไม่ถูกต้อง',
            'email.unique' => 'อีเมลนี้ถูกใช้ไปแล้ว',
            'tel.required' => 'กรุณาระบุเบอร์โทรศัพท์',
            'tel.regex' => 'รูปแบบเบอร์โทรศัพท์ไม่ถูกต้อง',
            'line_id.required' => 'กรุณาระบุ line id'
        ];
    }
}
