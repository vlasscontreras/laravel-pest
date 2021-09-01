<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Repositories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                <table>
                    <thead>
                        <tr>
                            <th class="px-4 py-2">{{ __('ID') }}</th>
                            <th class="px-4 py-2">{{ __('URL') }}</th>
                            <th class="px-4 py-2">{{ __('Description') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($repositories as $repository)
                            <tr>
                                <td class="border px-4 py-2">{{ $repository->id }}</td>
                                <td class="border px-4 py-2">
                                    <a href="{{ route('repositories.show', $repository) }}">
                                        {{ $repository->url }}
                                    </a>
                                    <a href="{{ route('repositories.edit', $repository) }}">
                                        {{ __('Edit') }}
                                    </a>
                                </td>
                                <td class="border px-4 py-2">{{ $repository->description }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="border px-4 py-2" colspan="3">
                                    {{ __('No repositories found.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
