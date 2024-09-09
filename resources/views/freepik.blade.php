<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Freepik') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto">
        <div class="py-10 flex items-end sm:px-6 lg:px-8">
            {{-- <img class="h-auto max-w-sm rounded-lg" src="{{ asset('assets/images/shutterimg.jpeg') }}"
                alt="image description"> --}}
                {{-- <div class="flex items-center justify-center h-[275px] w-[600px] border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
                    <div role="status">
                        <div class="px-3 py-1 text-xs font-medium leading-none text-center text-blue-800 bg-blue-200 rounded-full animate-pulse dark:bg-blue-900 dark:text-blue-200">Carregando Preview...</div>
                    </div>
                </div>     --}}
            <img class="h-auto max-w-sm rounded-lg" src="{{ asset('assets/images/image.jpg') }}" alt="image description">

            <div class="sm:px-6 lg:px-8 w-full">
                <div class="w-full max-w-full mx-auto">
                    <div class="mb-2 flex justify-between items-center">
                        <label for="website-url" class="text-sm font-medium text-gray-900 dark:text-white">Verify your
                            website:</label>
                    </div>
                    <form class="flex items-center" action="{{ route('sendFreepik') }}" method="POST">
                        @csrf
                        <span
                            class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-s-lg dark:bg-gray-600 dark:text-white dark:border-gray-600">URL</span>
                        <div class="relative w-full">
                            <!-- Removed 'readonly' and 'disabled' attributes from the input field -->
                            <input id="shutter_url" name="shutter_url" type="text"
                                aria-describedby="helper-text-explanation"
                                class="bg-gray-50 border border-e-0 border-gray-300 text-gray-900 dark:text-white text-sm border-s-0 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="https://br.freepik.com/" />
                        </div>
                        <button data-tooltip-target="tooltip-website-url" data-copy-to-clipboard-target="website-url"
                            class="flex-shrink-0 z-10 inline-flex items-center py-3 px-4 text-sm font-medium text-center text-white bg-blue-700 rounded-e-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 border border-blue-700 dark:border-blue-600 hover:border-blue-800 dark:hover:border-blue-700"
                            type="submit">
                            <span id="default-icon">
                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 16 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 8h11m0 0-4-4m4 4-4 4m-5 3H3a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h3">
                                    </path>
                                </svg>
                            </span>
                            <span id="success-icon" class="hidden inline-flex items-center">
                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 16 12">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5" />
                                </svg>
                            </span>
                        </button>
                        {{-- <button type="submit"></button> --}}
                        <div id="tooltip-website-url" role="tooltip"
                            class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                            <span id="default-tooltip-message">Copy link</span>
                            <span id="success-tooltip-message" class="hidden">Copied!</span>
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    </form>
                    <p id="helper-text-explanation" class="mt-2 text-sm text-gray-500 dark:text-gray-400">Security
                        certificate is required for approval</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
