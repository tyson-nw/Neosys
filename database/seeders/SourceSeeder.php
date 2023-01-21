<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Spell;
use App\Tools\SourceParser;

class SourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $sources = scandir(database_path().'/sources/');
        array_shift($sources);
        array_shift($sources);
        
        foreach($sources as $source){
            if(is_dir(database_path().'/sources/'.$source)){
                $sp = new SourceParser($source);
                $sp->parseSource();
                if(file_exists(database_path().'/sources/'.$source."/Spells.md")){
                    $sp->parseSpells();
                    echo "Spells Parsed \n";
                }
                if(file_exists(database_path().'/sources/'.$source."/Cards.md")){
                    $sp->parseCards();
                    echo "Cards Parsed \n";
                }
                if(file_exists(database_path().'/sources/'.$source."/Monsters.md")){
                    $sp->parseMonsters();
                    echo "Monsters Parsed \n";
                }
            }
        }
    }
}
