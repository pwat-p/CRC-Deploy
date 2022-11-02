<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RepairOrderPostRequest extends FormRequest
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
        return [
            'registration' => ['required', 'min:3', 'without_spaces'],
            'color' => ['required'],
            'model' => ['required'],
            'vin' => ['required', 'regex:/^[A-Z0-9 ]+$/', 'size:17'],
            'current_distance' => ['required', 'numeric'],
            'latest_distance' => ['required', 'numeric'],
            'car_image' => ['mimes:jpg,png', 'max:8192']
        ];
    }

    public function messages()
    {
        return [
            'registration.required' => 'กรุณาระบุเลขทะเบียน',
            'registration.without_spaces' => 'เลขทะเบียนต้องไม่มีช่องว่าง',
            'registration.min' => 'เลขทะเบียนไม่ถูกต้อง',
            'color.required' => 'กรุณาระบุสีรถยนต์',
            'vin.required' => 'กรุณาระบุเลขตัวถัง',
            'vin.regex' => 'รูปแบบหมายเลขถัง (VIN)ไม่ถูกต้อง',
            'vin.size' => 'หมายเลขถัง (VIN) ต้องมี 17 ตัวอักษร',
            'model.required' => 'กรุณาระบุรุ่นรถยนต์',
            'current_distance.required' => 'กรุณาระบุระยะทางปัจจุบัน',
            'current_distance.numeric' => 'ระยะทางปัจจุบันไม่ถูกต้อง',
            'latest_distance.required' => 'กรุณาระบุระยะทางล่าสุด',
            'latest_distance.numeric' => 'ระยะทางล่าสุดไม่ถูกต้อง',
            'car_image.mimes' => 'รูปแบบไฟล์รูปไม่ถูกต้อง',
            'car_image.max' => 'ไฟล์มีขนาดใหญ่เกิน 8MB'
        ];
    }
}
