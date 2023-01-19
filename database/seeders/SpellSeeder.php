<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Spell;

class SpellSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = fopen(database_path().'/sources/Spells.md', 'r');
   
        
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

                    var_dump($current_spell); echo "\n";
                    Spell::create($current_spell);
                }
                
                $current_spell = [];
                $current_spell['title'] = trim(implode(" ",$exploded));
                $current_spell['slug'] = Str::slug($current_spell['title']);
                $current_spell['license'] = "Copyright Double Crescent";
            }elseif($element == "*"){

            
                $first = array_shift($exploded);
                if($first == "**Cantrip**"){
                    $current_spell['tier'] = '[[#Cantrip]]';
                    $current_spell['classes'] = trim(json_encode($exploded));
                }elseif($first == "**Tier"){
                    $current_spell['tier'] = trim(array_shift($exploded),"*");
                    $current_spell['classes'] = trim(json_encode($exploded));
                }
                elseif($first =="**Casting"){
                    array_shift($exploded);
                    $current_spell['casting_time'] = trim(implode(" ",$exploded));
                }
                elseif($first == "**Target**"){
                    $target = explode(", ", trim(implode(" ",$exploded)));
                    
                    $current_spell['target'] = $target[0];
                    if(isset($target[1])){
                        $current_spell['defense'] = $target[1];
                    }
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
        
    }
}
