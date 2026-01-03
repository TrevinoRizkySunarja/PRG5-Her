<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // owner
            $table->string('name');
            $table->string('rarity'); // Common, Rare, Legendary etc
            $table->text('description')->nullable();
            $table->string('image_path')->nullable(); // stored file path

            $table->timestamps();

            $table->index(['name', 'rarity']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
