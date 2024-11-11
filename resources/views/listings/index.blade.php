<x-layout>
    @include('partials._hero')
    @include('partials._search')

    <div class="lg:grid lg:grid-cols-2 gap-4 space-y-4 md:space-y-0 mx-4">
        @forelse($listings as $listing)
            <x-listing-card :listing="$listing" />
        @empty
            <p>No listings found</p>
        @endforelse

        <div class="mt-6 p-4">
            {{ $listings->links() }}
        </div>
    </div>
</x-layout>
