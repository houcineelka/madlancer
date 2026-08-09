<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings_general', function (Blueprint $table) {
            $table->id();
            $table->string('title', 60)->default('Riverr');
            $table->string('subtitle', 120)->default('Freelance Services Marketplace');
            $table->string('separator', 5)->default('|');
            $table->unsignedBigInteger('logo_id')->nullable();
            $table->unsignedBigInteger('favicon_id')->nullable();
            $table->text('header_announce_text')->nullable();
            $table->text('header_announce_link')->nullable();
            $table->boolean('is_language_switcher')->default(true);
            $table->string('default_language', 2)->default('en');

            $table->foreign('logo_id')->references('id')->on('file_manager');
            $table->foreign('favicon_id')->references('id')->on('file_manager');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings_general');
    }
};
