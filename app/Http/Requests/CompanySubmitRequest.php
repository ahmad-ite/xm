<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanySubmitRequest extends FormRequest
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
            'symbol' => 'required||exists:companies,symbol',
            'start_date' => 'required|date_format:m/d/Y|before_or_equal:end_date|before_or_equal:today',
            'end_date' => 'required|date_format:m/d/Y|after_or_equal:start_date|before_or_equal:today',
            'email' => 'required|email' //email:rfc,dns
        ];
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'symbol.required' => 'Symbol is required',
            'symbol.exists' => 'Company Symbol is not listed',
            'start_date.required'  => 'Start date is required',
            'start_date.date_format'  => 'Invalid start date format,recomended {m/d/Y}',
            'start_date.before_or_equal'  => 'Start date must be less or equal than End Date, less or equal than current
            date',

            'end_date.required'  => 'End date is required',
            'end_date.date_format'  => 'Invalid end date format,recomended {m/d/Y}',
            'end_date.before_or_equal'  => 'End date must be less or equal than current
            date',
            'end_date.after_or_equal'  => 'End date must be greater or equal than Start Date',
            'email.required'  => 'Email is required',
            'email.email'  => 'Invalid Email',

        ];
    }
}
