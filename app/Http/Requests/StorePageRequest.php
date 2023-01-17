<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StorePageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Bouncer::can('store_page');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required','max:255','min:3','unique:pages,title'],
            'slug' => [ 'unique:pages,slug'],
            'content' => ['required','min:3'],
        ];
    }

    protected function prepareForValidation(){
        $this->merge([
            'slug' => Str::slug($this->title),
        ]);
    }
}
