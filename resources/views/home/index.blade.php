<x-guest-layout>
    <div class="bg-gray-900 text-gray-100 py-10 px-4">
        <div class="max-w-xl mx-auto">
            <h1 class="font-bold text-xl">{{ __('Explore Repositories') }}</h1>

            <div class="min-h-screen flex flex-col mt-7 space-y-7">
                @foreach ($repositories as $repository)
                    <div>
                        <h2 class="font-bold hover:text-indigo-400">
                            <a href="{{ route('repository', $repository) }}">{{ $repository->name }}</a>
                        </h2>
                        <div class="opacity-70 text-xs">
                            <a href="{{ $repository->url }}">{{ $repository->url }}</a>
                        </div>
                        <p class="opacity-70 mt-2">{{ $repository->description }}</p>
                        <div class="opacity-70 text-xs mt-2">{{ $repository->created_at->format(DateTimeInterface::RFC7231) }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-guest-layout>
