@props(['key'])
<div class="py-10 flex items-end sm:px-6 lg:px-8">
    {{-- visualização do arquivo --}}
    <section>
        <div id="container-file-{{ $key }}"
            class="items-center h-[275px] w-[500px] rounded-lg flex p-4 justify-center border border-gray-200 rounded-lg bg-gray-50">
            <span id="content-file-{{ $key }}" class="h-full flex">
                <img id="content-image-default-{{ $key }}" class="h-auto max-w-sm rounded-lg"
                    src="{{ asset('assets/images/image.jpg') }}" alt="">
            </span>
            <div id="container-file-gif-{{ $key }}" class="hidden" role="status">
                <div
                    class="px-3 py-1 text-xs font-medium leading-none text-center text-blue-800 bg-blue-200 rounded-full animate-pulse">
                    <span id="gif-message-{{ $key }}">

                    </span>
                </div>
            </div>
        </div>
    </section>
    {{-- end visualização do arquivo --}}
    {{-- input --}}
    <div class="sm:px-6 lg:px-8 w-full">
        <div class="w-full max-w-full mx-auto">
            {{-- exibir mensagem de erro --}}
            <div id="container-box-alert-{{ $key }}"
                class="hidden flex items-center p-4 mb-4 text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300"
                role="alert">
                <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div class="ms-3 text-sm font-medium" id="box-alert-message-{{ $key }}">

                </div>
                <button type="button" onclick="closeAlert({{ $key }})"
                    class="ms-auto -mx-1.5 -my-1.5 bg-yellow-50 text-yellow-500 rounded-lg focus:ring-2 focus:ring-yellow-400 p-1.5 hover:bg-yellow-200 inline-flex items-center justify-center h-8 w-8"
                    aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
            {{-- end exibir mensagem de erro --}}
            {{-- exibir confirmação de download --}} 
            <div id="container-card-download-{{$key}}"
                    class="hidden w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow dark:bg-gray-800 dark:text-gray-400"
                    role="alert">
                    <div class="flex">
                        <div
                            class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-blue-500 bg-blue-100 rounded-lg dark:text-blue-300 dark:bg-blue-900">
                            {{-- <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 18 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M16 1v5h-5M2 19v-5h5m10-4a8 8 0 0 1-14.947 3.97M1 10a8 8 0 0 1 14.947-3.97" />
                            </svg>
                            <span class="sr-only">Refresh icon</span> --}}
                            <svg id="card-download-icon-check-{{$key}}" class="hidden w-4 h-4 text-gray-800 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 21 21">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6.072 10.072 2 2 6-4m3.586 4.314.9-.9a2 2 0 0 0 0-2.828l-.9-.9a2 2 0 0 1-.586-1.414V5.072a2 2 0 0 0-2-2H13.8a2 2 0 0 1-1.414-.586l-.9-.9a2 2 0 0 0-2.828 0l-.9.9a2 2 0 0 1-1.414.586H5.072a2 2 0 0 0-2 2v1.272a2 2 0 0 1-.586 1.414l-.9.9a2 2 0 0 0 0 2.828l.9.9a2 2 0 0 1 .586 1.414v1.272a2 2 0 0 0 2 2h1.272a2 2 0 0 1 1.414.586l.9.9a2 2 0 0 0 2.828 0l.9-.9a2 2 0 0 1 1.414-.586h1.272a2 2 0 0 0 2-2V13.8a2 2 0 0 1 .586-1.414Z"></path>
                            </svg>
                            <svg id="card-download-icon-down-{{$key}}" class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 18">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 1v11m0 0 4-4m-4 4L4 8m11 4v3a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-3"></path>
                            </svg>
                        </div>
                        <div class="ms-3 text-sm font-normal ">
                            <span id="card-download-title-{{$key}}" class="mb-1 text-sm font-semibold text-gray-900">Deseja baixar o arquivo?</span>
                            <div id="card-download-text-{{$key}}" class="mb-2 text-sm font-normal">Confirme o download do seu arquivo.
                            </div>
                            <div id="card-download-buttons-{{$key}}" class="grid grid-cols-2 gap-2"> 
                                <div> 
                                    <button type="button" onclick="downloadImage({{ $key }} , false, {{ route('sendStock') }})" class="inline-flex justify-center w-full px-2 py-1.5 text-xs font-medium text-center text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300">Baixar</button>
                                </div>
                                <div>
                                    <button type="button" onclick="cancelDownload({{$key}})" class="inline-flex justify-center w-full px-2 py-1.5 text-xs font-medium text-center text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 ">Cancelar</button>
                                </div> 
                            </div>
                            <button id="card-dowload-button-file-{{$key}}" class="hidden inline-flex justify-center w-full px-2 py-1.5 text-xs font-medium text-center text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300">Salvar no meu computador</button>
                        </div>
                        <button type="button"
                            onclick="cancelDownload({{$key}})"
                            class="ms-auto -mx-1.5 -my-1.5 bg-white items-center justify-center flex-shrink-0 text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8"
                             aria-label="Close">
                            <span class="sr-only">Close</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>
            </div>  
            {{-- end exibir confirmação de download --}}
            <div class="mb-2 mt-4 flex justify-between items-center">
                <label class="text-sm font-medium text-gray-900 dark:text-white">Cole a url do banco de imagem aqui:</label>
            </div>
            <form id="form-shutter-{{ $key }}" class="flex items-center">
                @csrf
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <span
                    class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-s-lg ">URL</span>
                <div class="relative w-full"> <input id="stock-url-{{ $key }}" name="stock_url" type="text"
                        aria-describedby="helper-text-explanation"
                        class="bg-gray-50 border border-e-0 border-gray-300 text-gray-900 text-sm border-s-0 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  "
                        placeholder="https://www.shuterstock.com/br" />
                </div>
                <button onclick="downloadImage({{ $key }} , true)"
                    class="flex-shrink-0 z-10 inline-flex items-center py-3 px-4 text-sm font-medium text-center text-white bg-blue-700 rounded-e-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300  border border-blue-700 hover:border-blue-800"
                    type="button">
                    <span id="default-icon">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 16 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M4 8h11m0 0-4-4m4 4-4 4m-5 3H3a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h3">
                            </path>
                        </svg>
                    </span>
                    <span id="success-icon" class="hidden inline-flex items-center">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 16 12">
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
        </div>
    </div>
    {{-- end input --}}
</div>
