<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addons', function (Blueprint $table) {
            $table->increments('id');
            $table->char('uuid', 36)->unique();
            $table->char('uuidShort', 8)->unique();
            $table->char('name', 255);
            $table->text('description')->nullable();
            $table->char('image', 255)->nullable();
            $table->char('version', 255)->nullable();
            $table->char('author', 255)->nullable();
            $table->char('website', 255)->nullable();
            $table->char('license', 255)->nullable();
            $table->boolean('enabled')->default(true);
            $table->boolean('installed')->default(true);
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
        Schema::dropIfExists('addons');
    }
}
