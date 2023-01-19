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
        return [
            'title' => ['required',
                'max:255',
                'min:3',
                Rule::unique('spells')->ignore($this->title, 'title'),
            ],
            'slug' => [ 
                Rule::unique('spells')->ignore($this->slug, 'slug'),
            ],
            'license' => [],
            'tier' => ['required'],
            'classes'=> ['json'],
            'casting_time' => ['required'],
            'target' => ['required'],
            'defense' => [],
            'duration' => [],
            'concentration' => ['boolean'],
            'details' => ['required'],
            'higher_cast' => [],
        ];
    }

    protected function prepareForValidation(){
        $this->merge([
            'slug' => Str::slug($this->title),
        ]);

        $this->merge(['classes'=> collect(explode(",",$this->classes))->toJson()]);

        if(isset($this->concentration)){
            $this->merge(['concentration'=>TRUE]);
        }
    }
}
