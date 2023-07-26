<?php

namespace App\Http\Requests\Posts;

use App\Builder\ReturnMessage;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StorePostsRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:255|unique:posts',
            'post' => 'required',
        ];
    }
    /**
     *
     * @return array
     */
    public function failedValidation(Validator $validator)
    {
        $errors = [];
        $messages = $validator->errors()->messages();

        foreach ($messages as $m) {
            array_push($errors, $m[0]);
        }

        throw new HttpResponseException(
            ReturnMessage::message(
                true,
                'Something went wrong',
                'Erro in request',
                null,
                $errors,
                400
            )
        );
    }
}
