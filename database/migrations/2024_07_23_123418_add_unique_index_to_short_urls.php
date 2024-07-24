<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueIndexToShortUrls extends Migration
{
    public function up()
    {
        Schema::table('short_urls', function (Blueprint $table) {
            $table->unique(['original_url', 'user_id']); 
        });
    }

    public function down()
    {
        Schema::table('short_urls', function (Blueprint $table) {
            $table->dropUnique(['original_url', 'user_id']);
        });
    }
}
