<?php

use App\Models\Project;
use App\Models\Technology;
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
        Schema::create('project_technology', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(Project::class)->constrained();
            $table->foreignIdFor(Technology::class)->constrained();
            $table->unique(['project_id', 'technology_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_technology');
    }
};
