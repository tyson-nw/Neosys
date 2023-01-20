<?php

namespace App\Tools;

use Illuminate\Support\Str;
use App\Models\Spell;
use App\Models\Source;

class SourceParser {
    public $license;
    public $source;
    public $directory;

    public function  __construct(string $directory){
        $this->directory = database_path()."/sources/{$directory}";
        if(!file_exists($this->directory."/{$directory}.md")){
            dd($this->directory."{$directory}.md");
        }
        if(is_dir($this->directory)){
            $this->source = $directory;
            $this->license = file_get_contents($this->directory ."/License");
        }else{
            dd($this->directory);
        }
        
    }

    public function parseSource(){
        if(!file_exists($this->directory."/{$this->source}.md")){
            return FALSE;
        }
        $source['title'] = $this->source;
        $source['slug']=Str::slug($this->source);
        $source['license'] = $this->license;
        $source['content'] = file_get_contents($this->directory."/{$this->source}.md");
        Source::create($source);
        return true;
    }

    public function parseSpells(){
        if(!file_exists($this->directory. "/Spells.md")){
            return FALSE;
        }

        $file = fopen($this->directory . "/Spells.md", 'r');
    
            
        $spells = [];
        $current_spell = [];
        while (($line = fgets($file)) !== FALSE){
            $exploded = explode(" ",$line);

            $element = array_shift($exploded);
            if($element =="##"){
                if(!empty($current_spell)){
                    if(str_contains($current_spell['details'][count($current_spell['details'])-1], "[[#Tier]]")){
                        $current_spell['higher_cast'] = array_pop($current_spell['details']);
                        
                    }
                    $current_spell['details'] = implode("\n", $current_spell['details']);

                    Spell::create($current_spell);
                }
                
                $current_spell = [];
                $current_spell['title'] = trim(implode(" ",$exploded));
                $current_spell['slug'] = Str::slug($current_spell['title']);
                $current_spell['license'] = $this->license;
                $current_spell['source'] = $this->source;
            }elseif($element == "*"){

            
                $first = array_shift($exploded);
                if($first == "**Cantrip**"){
                    $current_spell['tier'] = '[[#Cantrip]]';
                    $current_spell['classes'] = trim(json_encode(explode(",", implode( " ", $exploded))));
                }elseif($first == "**Tier"){
                    $current_spell['tier'] = trim(array_shift($exploded),"*");
                    $current_spell['classes'] = trim(json_encode(explode(",", implode( " ", $exploded))));
                }
                elseif($first =="**Casting"){
                    array_shift($exploded);
                    $current_spell['casting_time'] = trim(json_encode(explode(",", implode( " ", $exploded))));
                }
                elseif($first == "**Target**"){
                    $target = explode(", ", trim(implode(" ",$exploded)));
                    
                    $current_spell['target'] = $target[0];
                    $defenses = ["[[#Body]]","[[#Mind]]","[[#React]]","[[#Deflect]]"];
                    if(in_array($target[count($target)-1],$defenses)){
                        $current_spell['defense'] = array_pop($target);
                    }
                    $current_spell['target'] = trim(json_encode(explode(",", implode( " ", $target))));
                }
                elseif($first == "**Duration**"){
                    $target = explode(", ", trim(implode(" ",$exploded)));
                    
                    $current_spell['duration'] = $target[0];
                    if(isset($target[1])){
                        $current_spell['concentration'] = TRUE;
                    }
                }
                
            }
            elseif($element !== "#"){ 
                if(trim($element) != ""){
                    array_unshift($exploded, $element);
                    $current_spell['details'][] = trim(implode(" ",$exploded));
                }
            }
        }
        if(str_contains($current_spell['details'][count($current_spell['details'])-1], "[[#Tier]]")){
            $current_spell['higher_cast'] = array_pop($current_spell['details']);
            
        }
        $current_spell['details'] = implode("\n", $current_spell['details']);
        Spell::create($current_spell);
        return TRUE;
    }
}