<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Closure;
use Illuminate\Validation\Rules\File;

class BookPostRequest extends FormRequest
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
            'image' => ['nullable',File::image()->min('1kb')
                                                ->max('10mb')],
            'name' => 'required|unique:books,title|max:255',
            'authors' => 'required|max:255',
            'quantity' => 'required|numeric|min:10',
            'hotItem' => 'required|boolean',
            'category' => 'exists:categories,category_id',
            'price' => function(string $attribute, mixed $value, Closure $fail){
                if($value < 1500){
                    $fail("The {$attribute} must be greater than 1500");
                }
            },
        ];
    }


    public function attributes(): array
    {
        return [
            'name' => 'Title of book',
        ];
    }
}
