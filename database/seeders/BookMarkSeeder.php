<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Job;

class BookMarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the test user
        $testUser = User::where('email', 'test@test.com')->firstOrFail();

        //Get all job ids
        $jobIds = Job::pluck('id')->toArray();

        // Random select jobs to bookmarks
        $randomJObIds = array_rand($jobIds, 3);

        // Attach the selected bookmarks for the test user
        foreach ($randomJObIds as $joId) {
            $testUser->bookmarkedJobs()->attach($jobIds[$joId]);
        }
    }
}
