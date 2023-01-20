<?php

namespace App\Tools;

class CardTagParser{
    public function __invoke(string $string) : string{
        $out = [];
        preg_match_all("/\[\[\#([A-z]*)\]\]/", $string,$out);
        for($n=0 ; isset($out[1][$n]) ; $n++){
            $string = str_replace($out[0][$n], "<a href='#' card='{$out[1][$n]}'>{$out[1][$n]}</a>",$string);
        }
        return $string;
    }

}