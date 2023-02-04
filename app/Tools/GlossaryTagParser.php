<?php

namespace App\Tools;

class GlossaryTagParser{

    public function __invoke(string|null $string, string|null $source = NULL) : string|null{
        if(empty($string)){
            return $string;
        }

        $out = [];

        preg_match_all("/\[\[\#([A-z \d]*)\]\]/", $string,$out);
        for($n=0 ; isset($out[1][$n]) ; $n++){
            $string = str_replace($out[0][$n], "<a href='#' card='" . $source ."/". $out[1][$n]. "'>" . $out[1][$n] . "</a>",$string);
        }
        return $string;
    }

}