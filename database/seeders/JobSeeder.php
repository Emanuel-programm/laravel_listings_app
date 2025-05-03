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

        // Get the test user id
        $testUserId = User::where('email', 'test@test.com')->value('id');

        //Get all other user id from user id 
        $userIds = User::where('email', '!=', 'test@test.com')->pluck('id')->toArray();

        foreach ($jobListings as $index => $listing) {
            //Assign user id to listing
            if ($index < 2) {
                // Assign the first two listing to the first user
                $listing['user_id'] = $testUserId;
            } else {

                $listing['user_id'] = $userIds[array_rand($userIds)];
            }

            // Add time stamp
            $listing['created_at'] = now();
            $listing['updated_at'] = now();
        }
        //Insert job listing
        DB::table('job_listings')->insert($jobListings);
        echo 'Job created successfully';
    }
}
