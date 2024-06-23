<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movies', function (Blueprint $table) {
            // Pozn. Napojení na žánry je řešeno přes "movie_genre" pivot tabulku.
            $table->id();
            $table->foreignIdFor(User::class);
            $table->text('name')->index();
            $table->longText('description')->nullable(true);
            $table->text('csfd')->nullable(true);
            $table->text('imdb')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
