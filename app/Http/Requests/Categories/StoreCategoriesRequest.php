<?php

namespace App\Http\Requests\Categories;

use App\Builder\ReturnMessage;
use App\Rules\Categories\CategoryIdNumberOrNull;
use App\Rules\Categories\PostExist;
use App\Rules\Categories\PostExit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreCategoriesRequest extends FormRequest
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
            'name' => 'required|unique:categories|min:5|max:255',
            'category_id' => [new CategoryIdNumberOrNull, new PostExist],
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
