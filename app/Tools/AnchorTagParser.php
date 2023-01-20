<?php

namespace App\Tools;

use Illuminate\Support\Str;

class AnchorTagParser{
    public $source;

    public function __construct($source = NULL){
        $this->source = $source;
    }

    public function __invoke(string|null $string) : string|null{
        if(empty($string)){
            return $string;
        }

        $out = [];
        $placeholder = "";
        if(isset($this->source)){
            $placeholder = $this->source."/";
        }
        preg_match_all("/\[\[\#([A-z \d|]*)\]\]/", $string,$out);
        for($n=0 ; isset($out[1][$n]) ; $n++){
            if(str_contains($out[1][$n], "|" )){
                $text = explode ("|", $out[1][$n]);
                $string = str_replace($out[0][$n], "<a href='#content-".Str::slug($text[0])."' card='{$placeholder}". Str::slug($text[0])."'>{$text[1]}</a>",$string);
            }else{
                $slug = Str::slug($out[1][$n]);
                $string = str_replace($out[0][$n], "<a href='#content-{$slug}' card='{$placeholder}{$slug}'>{$out[1][$n]}</a>",$string);
            }
            
        }
        return $string;
    }

}