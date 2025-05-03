<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class JobController extends Controller
{
    // @desc show all job listing
    // @route Get /jobs
    public function index(): View
    {

        $jobs = Job::all();

        // return view('jobs.index', compact('jobs'));
        return view('jobs.index')->with('jobs', $jobs);
    }

    // @desc show create job form
    // @route Get jobs/create
    public function create(): View
    {
        return view('jobs.create');
    }

    // @desc Save jobs to the database
    // @route POST /jobs
    public function store(Request $request)

    {
        // dd($request->file('company_logo'));
        $validatedData = $request->validate([

            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'salary' => 'required|integer',
            'tags' => 'nullable|string',
            'job_type' => 'required|string',
            'remote' => 'required|boolean',
            'requirements' => 'required|string',
            'benefits' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zipcode' => 'nullable|string',
            'contact_email' => 'required|string',
            'contact_phone' => 'required|string',
            'company_name' => 'required|string',
            'company_description' => 'nullable|string',
            'company_logo' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'company_website' => 'nullable|url'
        ]);



        // Job::create([
        //     'title' => $validatedData['title'],
        //     'description' => $validatedData['description']
        // ]);

        // Hardcoded user ID
        $validatedData['user_id'] = 1;

        // check for image
        if ($request->hasFile('company_logo')) {
            // Store the file and get path
            $path = $request->file('company_logo')->store('logos', 'public');

            // Add path to validated data
            $validatedData['company_logo'] = $path;
        }

        // submit to the database
        Job::create($validatedData);


        return redirect()->route('jobs.index')->with('success', 'Job Listing created successfully');
    }

    // @desc Display a single job listing
    // @route Get jobs/{$id}
    public function show(Job $job): View
    {
        return view('jobs.show')->with('job', $job);
    }

    // @desc show edit job form
    // @route Get /jobs/{$id}/edit/
    public function edit(Job $job): View
    {
        return view('jobs.edit')->with('job', $job);
    }

    // @desc update job listing
    // @route PUT /jobs/{$id}
    public function update(Request $request, Job $job)
    {
        $validatedData = $request->validate([

            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'salary' => 'required|integer',
            'tags' => 'nullable|string',
            'job_type' => 'required|string',
            'remote' => 'required|boolean',
            'requirements' => 'required|string',
            'benefits' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zipcode' => 'nullable|string',
            'contact_email' => 'required|string',
            'contact_phone' => 'required|string',
            'company_name' => 'required|string',
            'company_description' => 'nullable|string',
            'company_logo' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'company_website' => 'nullable|url'
        ]);



        // Job::create([
        //     'title' => $validatedData['title'],
        //     'description' => $validatedData['description']
        // ]);


        // check for image
        if ($request->hasFile('company_logo')) {
            //   Delete the old logo
            Storage::delete('public/logos/' . basename($job->company_logo));

            // Store the file and get path
            $path = $request->file('company_logo')->store('logos', 'public');

            // Add path to validated data
            $validatedData['company_logo'] = $path;
        }

        // submit to the database
        $job->update($validatedData);


        return redirect()->route('jobs.index')->with('success', 'Job Listing updated successfully');
    }

    // @desc delete job listing
    // @route DELETE /jobs/{$id}

    public function destroy(Job $job): RedirectResponse
    {
        //if logo then delete it
        if ($job->company_logo) {
            Storage::delete('public/logos/' . $job->company_logo);
        }

        $job->delete();

        return redirect()->route('jobs.index')->with('success', 'Job Listing deleted successfully');
    }
}
