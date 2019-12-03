<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HalfDesignSetInfoRequest extends FormRequest
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
            'crowding' => 'required|integer|min: 1',
            'date' => 'required|date',
            'price' => 'required|integer|min: 1',
            'category_id' => 'required|integer',
            'title' => 'required|min:6',
            'description' => 'required|min:10',
            'mainimg' => 'required',
            "subimg" => 'required|array',
            "size" => 'required|array',
            'productID' => 'required| integer'
        ];
    }
}
