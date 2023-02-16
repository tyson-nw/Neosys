<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpellsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spells', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->string('license');
            $table->string('source');
            $table->string('tier');
            $table->json('archetypes')->nullable();
            $table->string('casting_time');
            $table->string('target');
            $table->string('defense')->nullable();
            $table->string('duration')->nullable();
            $table->boolean('concentration')->default(FALSE);
            $table->text('details');
            $table->text('higher_cast')->nullable();
            $table->text('ritual')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spells');
    }
}
