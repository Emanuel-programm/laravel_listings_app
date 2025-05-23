<x-layout>

<h2 class="text-3xl text-center mb-4 font-bold border border-gray-300 p-3">Bookmarked Jobs</h2>
<div class="grid-cols-1 gap-4 mb-3 md:grid-cols-3">
@forelse ($bookmarks as $bookmark )
    <x-job-card :job="$bookmark"/>
@empty

<p class="text-3xl text-center text-white bg-gray-500">No bookmarked job found</p>

@endforelse
</div>
</x-layout>