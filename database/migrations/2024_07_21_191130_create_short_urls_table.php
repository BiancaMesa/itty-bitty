<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    //  Run the migrations
    public function up(): void
    {
        Schema::create('short_urls', function (Blueprint $table) {
            $table->id();
            // The constrained method adds the foreign key constraint.
            // The onDelete('cascade') method ensures that if a user is deleted, all related short URLs are also deleted.
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->text('original_url');
            $table->string('short_url')->nullable();
            $table->string('clicks')->default(0);
            $table->timestamps();

            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    // Reverse the migrations
    public function down(): void
    {
        Schema::dropIfExists('short_urls');
    }
};
