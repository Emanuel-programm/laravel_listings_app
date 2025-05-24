<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
// use Illuminate\Support\Facades\Auth;


class JobController extends Controller

{

    use AuthorizesRequests;
    // @desc show all job listing
    // @route Get /jobs
    public function index(): View
    {

        $jobs = Job::latest()->paginate(5);

        // return view('jobs.index', compact('jobs'));
        return view('jobs.index')->with('jobs', $jobs);
    }

    // @desc show create job form
    // @route Get jobs/create
    public function create()
    {
        // if (!Auth::check()) {
        //     return redirect()->route('login');
        // }

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

        // the code show warning but it is perfect fine this is because of IDE inteliphense
        $validatedData['user_id'] = auth()->user()->id;

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
        // check if the user is authorized
        $this->authorize('update', $job);
        return view('jobs.edit')->with('job', $job);
    }

    // @desc update job listing
    // @route PUT /jobs/{$id}
    public function update(Request $request, Job $job)

    {
        // Check if user is authorized
        $this->authorize('update', $job);
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
        $this->authorize('delete', $job);
        //if logo then delete it
        if ($job->company_logo) {
            Storage::delete('public/logos/' . $job->company_logo);
        }

        $job->delete();

        // check if the request comes from the dashboard
        if (request()->query('from') == 'dashboard') {
            return redirect()->route('dashboard')->with('success', 'Job Listing deleted successfully');
        }


        return redirect()->route('jobs.index')->with('success', 'Job Listing deleted successfully');
    }

    // @sesc search job listings
    // @route GET/jobs/search
    public function search(Request $request): View
    {
        $keywords = strtolower($request->input('keywords'));
        $location = strtolower($request->input('location'));

        // dd($keywords, $location);
        $query = Job::query();
        if ($keywords) {
            $query->where(function ($q) use ($keywords) {
                $q->whereRaw('LOWER(title) like ?', ['%' . $keywords . '%'])
                    ->orWhereRaw('LOWER(description) like ?', ['%' . $keywords . '%'])
                    ->orWhereRaw('LOWER(tags) like ?', ['%' . $keywords . '%']);
            });
        }
        if ($location) {
            $query->where(function ($q) use ($location) {
                $q->whereRaw('LOWER(address) like ?', ['%' . $location . '%'])
                    ->orWhereRaw('LOWER(city) like ?', ['%' . $location . '%'])
                    ->orWhereRaw('LOWER(state) like ?', ['%' . $location . '%'])
                    ->orWhereRaw('LOWER(zipcode) like ?', ['%' . $location . '%']);
            });
        }
        $jobs = $query->paginate(12);

        return view('jobs.index')->with('jobs', $jobs);
    }
}
