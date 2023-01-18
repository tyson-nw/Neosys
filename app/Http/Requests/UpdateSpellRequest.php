<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\Spell;

class UpdateSpellRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Bouncer::can('update_spell');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $old = Spell::findOrFail($this->id);

        return [
            'title' => ['required',
                'max:255',
                'min:3',
                Rule::unique('pages','title')->ignore($this->slug, $old->title),
            ],
            'slug' => [ 
                Rule::unique('pages')->ignore($this->slug, $old->slug)
            ],
            'license' => [],
            'tier' => ['required'],
            'casting_time' => ['required'],
            'target' => ['required'],
            'defense' => [],
            'details' => ['required'],
            'higher_cast' => [],
        ];
    }

    protected function prepareForValidation(){
        $this->merge([
            'slug' => Str::slug($this->title),
        ]);
    }
}
