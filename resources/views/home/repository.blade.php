<x-guest-layout>
    <div class="bg-gray-900 text-gray-100 py-10 px-4 min-h-screen">
        <div class="max-w-xl mx-auto">
            <h1 class="font-bold text-xl">{{ $repository->name }}</h1>
            <div class="opacity-70 text-xs">
                <a href="{{ $repository->url }}">{{ $repository->url }}</a>
            </div>
            <p class="opacity-70 mt-2">{{ $repository->description }}</p>
            <div class="opacity-70 text-xs mt-2">{{ $repository->created_at->format(DateTimeInterface::RFC7231) }}</div>
        </div>
    </div>
</x-guest-layout>
