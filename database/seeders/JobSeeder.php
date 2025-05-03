<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use illuminate\support\Facades\DB;
use App\Models\User;
use App\Models\Job;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobListings = include database_path('seeders/data/job_listings.php');

        //Get user id from user id
        $userIds = User::pluck('id')->toArray();

        foreach ($jobListings as &$listing) {
            //Assign user id to listing
            $listing['user_id'] = $userIds[array_rand($userIds)];

            // Add time stamp
            $listing['created_at'] = now();
            $listing['updated_at'] = now();
        }
        //Insert job listing
        DB::table('job_listings')->insert($jobListings);
        echo 'Job created successfully';
    }
}
