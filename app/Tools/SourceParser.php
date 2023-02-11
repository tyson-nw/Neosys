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
            if(file_exists($this->directory ."/License")){
                $this->license = file_get_contents($this->directory ."/License");
            }else{
                $this->license = "Copyright Double Crescent Productions";
            }
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

    public function dropSource(){
        return Source::where('title', $this->source)->forceDelete();
    }


    public function parseSpells(){
        if(!file_exists($this->directory. "/Spells.md")){
            return FALSE;
        }

        $file = fopen($this->directory . "/Spells.md", 'r');

        $preg = "/\[\[\#([A-z \-\d\'|]*)\]\]/";
        while (($line = fgets($file)) !== FALSE){
            $out = [];
            
            if(mb_substr($line, 0, 1) == "#"){ //if title row
                if(isset($current_spell)){
                    
                    Spell::create($current_spell);

                }
                $current_spell = [];
                $current_spell['title'] = mb_substr($line, strpos($line, " ")+1 );
                $current_spell['slug'] = Str::slug($current_spell['title']);
                $current_spell['license'] = $this->license;
                $current_spell['source'] = $this->source;
                $current_spell['details'] = "";
            }elseif(mb_substr($line, 0, 1) == "-"){
                
                if(str_contains( $line,"- **Cantrip**")){
                    $current_spell['tier'] = 'Cantrip';
                    $out = [];
                    preg_match_all($preg, $line,$out);
                    $current_spell['archetypes'] = json_encode($out[1], TRUE);
                }
                if(str_contains($line, "- **Tier")){
                    $out = [];
                    preg_match("/\d/", $line, $out);
                    $current_spell['tier'] = $out[0];
                    $out = [];
                    preg_match_all($preg, $line,$out);
                    $current_spell['archetypes'] = json_encode($out[1], TRUE);
                }
                if(str_contains($line, "- **Casting Time**")){
                    $out = [];
                    preg_match_all($preg, $line,$out);
                    $current_spell['casting_time'] = json_encode($out[1], TRUE);
                }
                if(str_contains($line, "- **Target**")){
                    $ex = explode("-",$line);
                    $targets = explode(',', array_pop($ex));
                    if(str_contains($line,"Mind")){
                        $current_spell['defense'] = "Mind";
                        array_pop($targets);
                    }
                    if(str_contains($line,"Body")){
                        $current_spell['defense'] = "Body";
                        array_pop($targets);
                    }
                    if(str_contains($line,"React")){
                        $current_spell['defense'] = "React";
                        array_pop($targets);
                    }
                    if(str_contains($line,"Deflect")){
                        $current_spell['defense'] = "Deflect";
                        array_pop($targets);
                    }
                    $current_spell['target'] = json_encode($targets, TRUE);
                    
                }
                if(str_contains($line, "- **Duration**")){
                    $ex = explode("-",$line);
                    $duration = trim(array_pop($ex));
                    
                    if(str_contains( $duration, "Concentration")){
                        $current_spell['concentration'] = TRUE;
                        $ex = explode(",",$duration);
                        array_pop($ex);
                        $duration = implode(",",$ex);
                    }
                    $current_spell['duration'] = $duration;
                }


            }else{
                $current_spell['details'] .= $line;

                $sentences = explode(".", $line);
                foreach($sentences as $sentence){
                    if(str_contains($sentence,"When cast at a higher")){
                        $current_spell['higher_cast'] = $sentence;
                    }
                    if(str_contains($sentence,"If cast as a")){
                        $current_spell['ritual'] = $sentence;
                    }
                }
            }
        }
        Spell::create($current_spell);
    }

    public function dropSpells(){
        return Spell::where('source', $this->source)->forceDelete();
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

    public function dropGlossary(){
        return Glossary::where('source', $this->source)->forceDelete();
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

    public function dropMonsters(){
        return Monster::where('source', $this->source)->forceDelete();
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

    public function dropArchetypes(){
        return Archetype::where('source', $this->source)->forceDelete();
    }

    public function dropAll(){
        $this->dropArchetypes();
        $this->dropGlossary();
        $this->dropMonsters();
        $this->dropSource();
        $this->dropSpells();
    }
}