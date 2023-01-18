<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\Spell;

class StoreSpellRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Bouncer::can('create_spell');
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
            'slug' => [ 'unique:spells,slug'],
            'license' => [],
            'tier' => ['required'],
            'classes'=> ['json'],
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

        $this->classes = collect(explode(",",$this->classes))->toJson();
        dd(Str::isJson($this->classes));
    }
}