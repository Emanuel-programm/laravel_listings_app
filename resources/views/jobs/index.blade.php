<x-layout>

<div class="bg-blue-900 h-24 px-4 mb-4 flex justify-center items-center rounded">
<x-search/>
</div>


{{-- Back Button --}}
@if (request()->has('keywords') || request()->has('location'))
<a href="{{ route('jobs.index') }}" class="bg-gray-700 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-gray-600">
<i class="fas fa-arrow-left mr-1"></i> Back
</a>  
@endif

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-7">      
 @forelse($jobs as $job)

<x-job-card  :job="$job"/>
@empty
<p class="text-2xl">No jobs available</p>
   @endforelse

    </div>

    {{-- pagination links --}}
{{ $jobs->links() }}



</x-layout>
    
