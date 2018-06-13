<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CommentRequest extends Request
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
            'body'      =>'required',          
        ];
    }

    public function messages()
{
    return [
        'body.required' => 'Adding a :attribute is required',
        'body.comment' => ':attribute is invalid'
    ];
}

    public function attributes()
{
    return[
        'body' => 'comment', //This will replace any instance of 'username' in validation messages with 'email'
        //'anyinput' => 'Nice Name',
    ];

}
}
