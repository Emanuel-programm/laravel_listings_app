<?php

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
        Schema::table('applicants', function (Blueprint $table) {
            // Drop the incorrect foreign key first
            $table->dropForeign(['job_id']);

            // Add correct foreign key WITHOUT redefining the column
            $table->foreign('job_id')
                ->references('id')
                ->on('job_listings')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->dropForeign(['job_id']);

            // Restore old incorrect foreign key (optional)
            $table->dropForeign(['job_id']);

            // Optional: revert to referencing jobs
            $table->foreign('job_id')
                ->references('id')
                ->on('jobs')
                ->onDelete('cascade');
        });
    }
};
