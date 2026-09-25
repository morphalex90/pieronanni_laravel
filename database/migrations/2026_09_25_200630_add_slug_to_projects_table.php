<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('title');
        });

        // Backfill from the title, suffixing duplicates, before the column becomes required.
        $taken = [];

        DB::table('projects')->orderBy('id')->get(['id', 'title'])->each(function (object $project) use (&$taken): void {
            $base = Str::slug($project->title) ?: 'project';
            $slug = $base;

            for ($suffix = 2; isset($taken[$slug]); $suffix++) {
                $slug = $base . '-' . $suffix;
            }

            $taken[$slug] = true;

            DB::table('projects')->where('id', $project->id)->update(['slug' => $slug]);
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });
    }
};
