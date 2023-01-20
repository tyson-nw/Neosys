<?php

namespace App\Tools;

use Illuminate\Support\Str;

class AnchorTagParser{
    public function __invoke(string|null $string) : string|null{
        if(empty($string)){
            return $string;
        }

        $out = [];

        preg_match_all("/\[\[\#([A-z \d|]*)\]\]/", $string,$out);
        for($n=0 ; isset($out[1][$n]) ; $n++){
            if(str_contains($out[1][$n], "|" )){
                $text = explode ("|", $out[1][$n]);
                $string = str_replace($out[0][$n], "<a href='#content-".Str::slug($text[0])."' card='{$text[0]}'>{$text[1]}</a>",$string);
            }else{
                $slug = Str::slug($out[1][$n]);
                $string = str_replace($out[0][$n], "<a href='#content-{$slug}' card='{$out[1][$n]}'>{$out[1][$n]}</a>",$string);
            }
            
        }
        return $string;
    }

}