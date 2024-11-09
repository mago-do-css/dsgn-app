<x-app-layout>
    <style>
        .width-image-processed {
            width: -webkit-fill-available;
            height: -webkit-fill-available;
        }
    </style>
    {{-- 
    @dd($historyData)  --}}
    <div class="py-12">
        {{-- max-w-7xl --}}
        <div class=" justify-center sm:px-6 lg:px-8 flex">
            <div class="mr-4">
                <form id="form-filters" action="{{ route('history', ['page' => 1]) }}" method="GET">
                    <input type="hidden" name="search" value="{{ request()->query('search') }}">  
                    {{-- date --}}
                    <div id="date-range-picker" datepicker datepicker-format="dd/mm/yyyy" date-rangepicker
                        class="w-48 flex flex-col items-center">
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input autocomplete="off" id="datepicker-range-start" datepicker
                                datepicker-format="dd/mm/yyyy" name="date_start" type="text"
                                class="form-control-input bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Selecione a data inicial" value='{{ request()->date_start ?? '' }}'>
                        </div>
                        <span class="mx-4 text-gray-500">até</span>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input autocomplete="off" id="datepicker-range-end" datepicker
                                datepicker-format="dd/mm/yyyy" name="date_end" type="text"
                                class=" form-control-input bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Selecione a data final" value='{{ request()->date_end ?? '' }}'>
                        </div>
                        {{-- end date --}}
                    </div>
                    {{-- checkbox --}}

                    <h3 class="mt-4 mb-2 font-semibold text-gray-900 dark:text-white">Banco de imagem:</h3>
                    @php
                        $bancoImagem = [
                            [
                                'name' => 'Shutterstock',
                                'id' => 'shutterstock',
                            ],
                            [
                                'name' => 'iStock',
                                'id' => 'istock',
                            ],
                            [
                                'name' => 'Freepik',
                                'id' => 'freepik',
                            ],
                            [
                                'name' => 'Flaticon',
                                'id' => 'flaticon',
                            ],
                            [
                                'name' => 'Envato',
                                'id' => 'envato',
                            ],
                            [
                                'name' => 'Motion Array',
                                'id' => 'motionarray',
                            ],
                            [
                                'name' => 'Graphic Pear',
                                'id' => 'graphicpear',
                            ],
                        ];
                    @endphp
                    <ul
                        class="w-48 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        @foreach ($bancoImagem as $banco)
                            <li class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600">
                                <div class="flex items-center ps-3">
                                    <input id="banco-{{ $banco['id'] }}" type="checkbox"
                                        @if ($selectedOptionsImageBank != null && in_array($banco['id'], $selectedOptionsImageBank)) checked @endif value="{{ $banco['id'] }}"
                                        name="stocks_origin[]"
                                        class=" form-control-input w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">

                                    <label for="{{ $banco['name'] . '-' . $banco['id'] }}"
                                        class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $banco['name'] }}</label>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    {{-- end checkbox --}}
                    {{-- chebox filter advanced --}}
                    <h3 class="mt-4 mb-2 font-semibold text-gray-900 dark:text-white">Tipos de arquivo:</h3>
                    @php
                        $tiposImagem = [
                            [
                                'name' => 'Todos',
                                'id' => 'all',
                            ],
                            [
                                'name' => 'Imagens',
                                'id' => 'image',
                            ],
                            [
                                'name' => 'Vetores',
                                'id' => 'vector',
                            ],
                            [
                                'name' => 'Mockups',
                                'id' => 'mockup',
                            ],
                            [
                                'name' => 'Vídeos',
                                'id' => 'video',
                            ],
                            [
                                'name' => 'Ícones',
                                'id' => 'icon',
                            ],
                            [
                                'name' => 'PSD',
                                'id' => 'psd',
                            ],
                        ];
                    @endphp

                    <ul
                        class="w-48 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        @foreach ($tiposImagem as $tipo)
                            <li class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600">
                                <div class="flex items-center ps-3">
                                    <input id="banco-{{ $banco['id'] }}" type="checkbox"
                                        @if ($selectedOptionsStockType != null && in_array($tipo['id'], $selectedOptionsStockType)) checked @endif value="{{ $tipo['id'] }}"
                                        name="stocks_type[]"
                                        class=" form-control-input w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">

                                    <label for="{{ $tipo['name'] . '-' . $tipo['id'] }}"
                                        class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $tipo['name'] }}</label>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    {{-- end checbox filter advanced --}}

                    {{-- ordenation filter --}}
                    <label for="ordernation"
                        class="block mb-2 mt-3 text-sm font-medium text-gray-900 dark:text-white">Ordenação</label>
                    <select id="ordernation" name="ordernation"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option @if ($selectedOptionOrdernation == null) selected @endif disabled>Ordenar por</option>
                        <option @if ($selectedOptionOrdernation == 'order') selected @endif value="order">Ordem Alfabética
                        </option>
                        <option @if ($selectedOptionOrdernation == 'date_max') selected @endif value="date_max">Recente</option>
                        <option @if ($selectedOptionOrdernation == 'date_min') selected @endif value="date_min">Mais Antigo</option>
                    </select>
                    {{--  end ordenation filter --}}

                    <div class="mt-5 flex flex-col">
                        <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Filtrar</button>
                        <a href="{{ route('history', ['page' => $page]) }}" type="button"
                            class="text-center py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white   border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700">Limpar
                            Filtros</a>
                    </div>
                </form>
            </div>
            <div>
                <form class="w-full mx-auto mb-4" action="{{ route('history', ['page' => 1]) }}" method="GET">

                    {{-- values filtros avançados --}}
                    @if ($selectedOptionsImageBank != null)
                    @foreach ($selectedOptionsImageBank as $option)
                        <input type="hidden" name="stocks_origin[]" value="{{ $option }}">
                    @endforeach
                    @endif
                    @if ($selectedOptionsStockType != null)
                        @foreach ($selectedOptionsStockType as $type)
                            <input type="hidden" name="stocks_type[]" value="{{ $type }}">
                        @endforeach
                    @endif
                    <input type="hidden" name="min_date" value="{{ request()->query('min_date') }}">
                    <input type="hidden" name="max_date" value="{{ request()->query('max_date') }}">
                    {{-- end values filtros avançados --}} 
                    <label for="default-search"
                        class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Pesquisar</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="search" id="default-search"
                            class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Procure por Mockups, Logos..." value="{{ request()->search ?? '' }}" required name="search" />
                        <button type="submit"
                            class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Pesquisar</button>
                    </div>
                </form>
                {{-- w-[1200px] grid grid-cols-3 grid-flow-row gap-4 --}}
                <div class="w-[1200px] grid grid-cols-4 grid-flow-row gap-4">
                    @foreach ($historyData as $key => $content)
                        <x-box-image-history :content="$content" :key="$key" />
                    @endforeach
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto flex justify-center mt-8">
            <x-pagination-history :page="$page" :paginationData="$paginationData" />
        </div>
    </div>
    <script type="text/javascript">
        function downloadImage(keyForm) {
            //Busca os dados do formulário
            let form = document.querySelector('#form-history-' + keyForm);
            let csrfToken = form.querySelector('input[name="_token"]').value;
            let inputUrl = form.querySelector('input[name="stock_url"]');
            let orderCode = form.querySelector('input[name="order_code"]');
            let btnForm = document.getElementById('button-form-history-' + keyForm);

            //oculta o botão de download
            btnForm.classList.add("hidden");

            //exibe o gif de loading ao iniciar o processo
            let gifLoading = document.getElementById("gif-loading-" + keyForm);
            gifLoading.classList.remove('hidden');

            //Inicia a requisição
            const xhttp = new XMLHttpRequest();
            console.log(inputUrl);
            //Define a rota 
            const actionUrl = @json(route('sendStock'));

            let data = {
                stock_url: inputUrl.value,
                isPreview: false,
                orderCode: orderCode.value ? orderCode.value : null
            }

            xhttp.open("POST", actionUrl, true);
            xhttp.setRequestHeader("Content-Type", "application/json");
            xhttp.setRequestHeader("X-CSRF-TOKEN", csrfToken);

            const dataToSend = JSON.stringify(data);
            xhttp.send(dataToSend);

            xhttp.onload = function() {
                console.log(this);

                let response;

                try {
                    response = JSON.parse(this.responseText);
                } catch (error) {
                    // Trata o erro de JSON inválido 
                    response = {
                        status: false,
                        message: "Resposta do servidor está inválida. Contacte o suporte!"
                    };
                }

                //let imageDefaultHTML = '<img class="w-[150px] h-[120px] rounded-lg" src="{{ asset('assets/images/image_blank.png') }}" alt="">';

                let imagePath = response.imagePath;
                let baseUrl = "{{ asset('storage/processed_image/') }}";
                let completeUrl = baseUrl + '/' + imagePath;

                console.log(response);
                if (this.status == 200 && response.status == true) {
                    //exibe o botão de download com a url da imagem 
                    let btnDownloadFinished = document.getElementById('btn-download-finish-' + keyForm);
                    btnDownloadFinished.classList.remove('hidden');
                    gifLoading.classList.add('hidden');
                    btnDownloadFinished.setAttribute('href', completeUrl);
                    btnDownloadFinished.setAttribute('download', imagePath);
                    limitCounter();
                } else {
                    //exibe o box de alerta
                    let boxAlert = document.getElementById('box-alert-' + keyForm);
                    let alertContent = document.getElementById('alert-message-' + keyForm);
                    boxAlert.classList.remove('hidden');
                    alertContent.innerHTML = response.message != null ? response.message : 'Erro de servidor';
                    gifLoading.classList.add('hidden');
                }
            }

            xhttp.onerror = function() {
                console.error('Erro:' + this.message);
            };
        }
    </script>
    <script>
        function closeAlert(keyForm) {
            let boxAlert = document.getElementById('box-alert-' + keyForm);
            let btnForm = document.getElementById('button-form-history-' + keyForm);
            boxAlert.classList.add('hidden');
            btnForm.classList.remove('hidden');
        }
    </script>
</x-app-layout>
