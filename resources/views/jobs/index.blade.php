<x-layout>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-7">      
 @forelse($jobs as $job)

<x-job-card  :job="$job"/>
@empty
<p class="text-2xl">No jobs available</p>
   @endforelse

    </div>



</x-layout>
    
