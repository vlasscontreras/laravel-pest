<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Repository') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1 flex justify-between">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium text-gray-900">{{ __('Repository Information') }}</h3>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Add the repository URL (GitHub, GitLab, BitBucket, etc.) and a short description.') }}
                        </p>
                    </div>
                </div>

                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form action="{{ route('repositories.store') }}" method="POST">
                        @csrf
                        <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-4">
                                    <x-jet-label for="url" value="{{ __('URL') }}" />
                                    <x-jet-input id="url" type="url" name="url" placeholder="https://github.com/vlasscontreras/laravel-pest" value="{{ old('url') }}" class="mt-1 block w-full" />
                                    <x-jet-input-error for="url" class="mt-2" />
                                </div>
                                <div class="col-span-6 sm:col-span-4">
                                    <x-jet-label for="description" value="{{ __('Description') }}" />
                                    <x-jet-input id="description" type="text" name="description" placeholder="{{ __('A Laravel application that uses Pest as testing library.') }}" value="{{ old('description') }}" class="mt-1 block w-full" />
                                    <x-jet-input-error for="description" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-start px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                            <x-jet-button type="submit">
                                {{ __('Create Repository') }}
                            </x-jet-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
