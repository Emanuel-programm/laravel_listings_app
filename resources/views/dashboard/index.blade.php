<x-layout>

<section class="flex flex-col gap-4 md:flex-row">
{{-- profile info form --}}
<div class="bg-white p-8 rounded-lg shadow-md w-full">
<h3 class="text-3xl text-center font-bold mb-4">Profile Info</h3>

@if($user->avatar)
<div class="mt-2 flex justify-center">
<img class="w-32 h-32 object-cover rounded-full" src="{{ asset('storage/' .$user->avatar) }}" alt="{{ $user->name }}">
</div>
@endif


<form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
@csrf
@method('PUT')
<x-inputs.text id="name" name="name" label="Name" value="{{$user->name}}" />
<x-inputs.text id="email" name="email" label="Email" value="{{$user->email}}" />

<x-inputs.file id="avatar"  name="avatar" label="Upload Avatar" type="file" />

<button class="w-full  bg-green-500 text-white px-4 py-2 hover:bg-green-600 focus:outline-none" type="submit">Submit</button> 
  
</form>

</div>

{{-- Job listings --}}

<div class="bg-white p-8 rounded-lg shadow-md w-full">
<h3 class="text-3xl text-center font-bold mt-4">
My Job Listings
</h3>

@forelse ($jobs as $job )
 <div class="flex justify-between items-center border-b-2 border-gray-200 py-2">
<div>
<h3 class="text-3xl font-semibold">{{$job->title}}</h3>
<p class="text-gray-700">{{$job->job_type}}</p>
</div>
<div class="flex space-x-3">
<a href="{{ route('jobs.edit',$job->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded text-sm">Edit</a>
<!-- Delete form-->
<form method="POST" action="{{ route('jobs.destroy',$job->id)}}?from=dashboard" onsubmit="return confirm('Are you sure you want to delete this job?')">
@csrf
@method('DELETE')
<button class="px-4 py-2 bg-red-500 text-white hover:bg-red-600 text-sm" type="submit">Delete</button>

</form>
<!-- End Delete form-->
</div>
</div>   
@empty
 <p class="text-gray-700">You have not job listing</p>   
@endforelse
</div>
</section>
<x-bottom-banner/>

</x-layout>