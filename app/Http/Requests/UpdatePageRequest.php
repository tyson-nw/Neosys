<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\Page;
class UpdatePageRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Bouncer::can('update_page');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $old = Page::findOrFail($this->id);

        return [
            'title' => [
                'required',
                'max:255',
                'min:3',
                //Rule::unique('pages','title')->ignore($this->slug, $old->title),
            ],
            'slug' =>[ 
                //Rule::unique('pages')->ignore($this->slug, $old->slug)
            ],
            'license' => [],
            'content' => ['required','min:3'],
        ];
    }

    protected function prepareForValidation(){
        $this->merge([
            'slug' => Str::slug($this->title),
        ]);
    }
}
