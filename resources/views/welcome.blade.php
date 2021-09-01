<x-guest-layout>
    <div class="pt-4 bg-gray-100">
        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
            @foreach ($repositories as $repository)
                <h2>{{ $repository->url }}</h2>
                <p>{{ $repository->description }}</p>
            @endforeach
        </div>
    </div>
</x-guest-layout>
