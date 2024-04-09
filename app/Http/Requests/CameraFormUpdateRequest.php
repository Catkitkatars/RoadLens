<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CameraFormUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'country' => 'required|numeric|between:1,15',
            'region' => 'required|numeric|between:1,85',
            'type' => 'required|numeric|between:1,7',
            'model' => 'required|numeric|between:1,7',
            'camera_latitude' => 'required|numeric|between:-90,90',
            'camera_longitude' => 'required|numeric|between:-180,180',
            'target_latitude' => 'required|numeric|between:-90,90',
            'target_longitude' => 'required|numeric|between:-180,180',
            'direction' => 'required|numeric|between:0,359',
            'distance' => 'required|numeric',
            'angle' => 'required|numeric',
            'car_speed' => 'required|numeric|between:0,250',
            'truck_speed' => 'required|numeric|between:0,250',
            'source' => 'required|string',
            'isDeleted' => 'required|in:0,1',
            'ASC' => 'nullable|array',
            'ASC.ulid' => 'nullable|ulid',
            'ASC.speed' => 'nullable|numeric|min:10',
            'isASC' => 'numeric',
            'flags' => 'nullable|array',
            'flags.*' => 'nullable|numeric|in:1,2,3,4,5,6,7,8,9,10',
        ];
    }
}
