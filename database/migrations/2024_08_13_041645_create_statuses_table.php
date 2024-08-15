<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->string('status');
            $table->timestamps();
        });

        // Modify the 'status' column to use ENUM type
        DB::statement("ALTER TABLE `statuses` CHANGE `status` `status` ENUM('READY', 'PERSONAL TIME', 'BREAK', 'LUNCH', 'MEETING', 'END OF SHIFT') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statuses');
    }
};
