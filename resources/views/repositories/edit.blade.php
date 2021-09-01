<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Repositories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                <form action="{{ route('repositories.update', $repository) }}" method="POST">
                    @method('PATCH')
                    @csrf

                    <label for="url">{{ __('URL') }}</label>
                    <input type="text" name="url" id="url" class="form-input mt-1 block w-full" value="{{ old('url', $repository->url) }}">

                    <label for="description">{{ __('Description') }}</label>
                    <textarea name="description" id="description" class="form-textarea mt-1 block w-full" rows="3">
                        {{ old('description', $repository->description) }}
                    </textarea>

                    <button type="submit" class="btn btn-primary mt-4">{{ __('Update') }}</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>