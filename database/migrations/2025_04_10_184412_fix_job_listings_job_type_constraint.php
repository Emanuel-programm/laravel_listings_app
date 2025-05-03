<?php

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
        //
        DB::statement("
        ALTER TABLE job_listings 
        DROP CONSTRAINT IF EXISTS job_listings_job_type_check,
        ADD CONSTRAINT job_listings_job_type_check 
        CHECK (job_type IN (
            'Full-Time', 
            'Part-Time', 
            'Contract', 
            'Temporary', 
            'Internship',  
            'Volunteer', 
            'On-Call'      
        ))
    ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
