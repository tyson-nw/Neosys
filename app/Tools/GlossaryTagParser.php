<?php

namespace App\Tools;

use Illuminate\Support\Str;

class GlossaryTagParser{

    public function __invoke(string|null $string, string|null $source = NULL) : string|null{
        if(empty($string)){
            return $string;
        }

        $out = [];

        preg_match_all("/\[\[\#([A-z \-\d\'|]*)\]\]/", $string,$out);
        for($n=0 ; isset($out[1][$n]) ; $n++){
            $string = str_replace($out[0][$n], "<a href='/glossary/#content-" . STR::slug($out[1][$n]) ."' card='" . $source ."/". STR::slug($out[1][$n]) . "'>" . $out[1][$n] . "</a>",$string);
        }
        return $string;
    }

}