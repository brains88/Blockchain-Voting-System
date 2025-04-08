<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('blocks', function (Blueprint $table) {
            $table->id();
            $table->string('previous_hash');
            $table->json('data');
            $table->string('hash');
            $table->timestamps();
            
            $table->index('hash');
            $table->index('previous_hash');
        });
    }

    public function down()
    {
        Schema::dropIfExists('blocks');
    }
};
