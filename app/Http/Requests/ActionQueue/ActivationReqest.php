<?php

namespace App\Http\Requests\ActionQueue;

use App\Model\Subscription;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ActivationReqest extends FormRequest
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
            'id' => 'required',
            'phone_number' => [
                function ($attribute, $value, $fail) {
                    $number = preg_replace('/[^\dxX]/', '', $value);
                    $count = Subscription::where($attribute, $number)
                        ->where('status', '!=', 'closed')
                        ->count();
                    if ($count) {
                        return $fail("This number {$value} is already in use");
                    }
                }
            ]
        ];
    }
}
