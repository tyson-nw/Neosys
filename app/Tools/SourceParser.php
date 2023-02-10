<?php

namespace App\Tools;

use Illuminate\Support\Str;
use App\Models\Spell;
use App\Models\Source;
use App\Models\Glossary;
use App\Models\Archetype;
use App\Models\Monster;

class SourceParser {
    public $license;
    public $source;
    public $directory;

    public function  __construct(string $directory){
        $this->directory = base_path()."/sources/{$directory}";
        if(!file_exists($this->directory."/{$directory}.md")){
            dd("File does not exist",$this->directory."{$directory}.md");
        }
        if(is_dir($this->directory)){
            $this->source = $directory;
            $this->license = file_get_contents($this->directory ."/License");
        }else{
            dd("File not a directory",$this->directory);
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
            if($element =="#"){
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
            }elseif($element == "-"){

            
                $first = array_shift($exploded);
                if($first == "**Cantrip**"){
                    $current_spell['tier'] = '[[#Cantrip]]';
                    $current_spell['archetypes'] = trim(json_encode(explode(",", implode( " ", $exploded))));
                }elseif($first == "**Tier"){
                    $current_spell['tier'] = trim(array_shift($exploded),"*");
                    $current_spell['archetypes'] = trim(json_encode(explode(",", implode( " ", $exploded))));
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

    public function parseGlossary(){
        
        if(!file_exists($this->directory. "/Glossary.md")){
            return FALSE;
        }

        $file = fopen($this->directory . "/Glossary.md", 'r');
        $line= fgets($file);
        $current_card = [];
        do{
            if(str_contains($line[0], "#")){
                
                if(empty($current_card)){
                    $current_card['title'] = $line;
                }else{
                    $current_card['title'] = trim($current_card['title']);
                    $current_card['content'] = trim($current_card['content']);
                    Glossary::create($current_card);

                    $current_card = [];
                }
                $current_card['license'] = $this->license;
                $current_card['source'] = $this->source;
                $current_card['source_slug'] = STR::slug($this->source);
                $current_card['title'] = trim($line,"# ");
                $current_card['slug'] = STR::slug($current_card['title']);
                //$current_card['content'] = $line;
                $current_card['content'] = "";
            }else{
                $current_card['content'] .= $line ;
            }
        }while(($line = fgets($file)) !== FALSE);

        $current_card['title'] = trim($current_card['title']);
        $current_card['content'] = trim($current_card['content']);

        $curr = Glossary::create($current_card);

        return TRUE;
    }

    public function parseMonsters(){
        if(!file_exists($this->directory. "/Monsters.md")){
            return FALSE;
        }

        $file = fopen($this->directory . "/Monsters.md", 'r');
        $line= fgets($file);
        $current_monster = [];
        do{
            if(str_contains($line[0], "#")){
                if(empty($current_monster)){
                    $current_monster['title'] = trim($line, "# ");
                }else{
                    $current_monster['title'] = trim($current_monster['title'], "# ");
                    $current_monster['content'] = trim($current_monster['content']);
                    Monster::create($current_monster);

                    $current_monster = [];
                }
                $current_monster['license'] = $this->license;
                $current_monster['source'] = $this->source;
                $current_monster['source_slug'] = STR::slug($this->source);
                $current_monster['title'] = trim($line,"# ");
                $current_monster['slug'] = STR::slug($current_monster['title']);
                $current_monster['content'] = "";
            }else{
                $current_monster['content'] .= $line;
            }
        }while(($line = fgets($file)) !== FALSE);
        Monster::create($current_monster);

        return TRUE;
    }

    public function parseArchetypes(){

        if(!is_dir($this->directory. "/Archetypes")){
            return FALSE;
        }

        $files = glob($this->directory . "/Archetypes/*.md");
 
        foreach($files as $filename){
            $file = fopen($filename, 'r');
            $line = fgets($file);
            $current_archetype = [];
            $current_archetype['content'] = '';
            $current_archetype['title'] = basename($filename, ".md");
            $current_archetype['slug'] = STR::slug($current_archetype['title']);
            $current_archetype['license'] = $this->license;
            $current_archetype['source'] = $this->source;
            $current_archetype['source_slug'] = STR::slug($current_archetype['source']);

            do{
                $current_archetype['content'].= $line;
            }while(($line = fgets($file)) !== FALSE);
            Archetype::create($current_archetype);
        }
        

        
    }
}