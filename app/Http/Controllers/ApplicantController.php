<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicantController extends Controller
{
    // @desc  store new job application
    // @route POST /jobs/{job}/apply
    public function store(Request $request, Job $job): RedirectResponse
    {
        // validate the incoming data
        $validatedData = $request->validate([
            'full_name' => 'required|string',
            'contact_phone' => 'string',
            'contact_email' => 'required|string|email',
            'message' => 'string',
            'location' => 'string',
            'resume' => 'required|file|mimes:pdf|max:2048'

        ]);

        // Handle resume upload
        if ($request->hasFile('resume')) {
            $path = $request->file('resume')->store('resumes', 'public');
            $validatedData['resume_path'] = $path;
        }

        // store the application
        $application = new Applicant($validatedData);
        $application->job_id = $job->id;
        $application->user_id = Auth::id();
        $application->save();

        return redirect()->back()->with('success', 'Application submitted successfully');
    }
}
