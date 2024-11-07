@props(['content', 'key']) 
    {{-- max-w-sm --}} 
    <form id="form-history-{{ $key }}"> 
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="stock_url" value="{{ $content['stock_url'] }}" id="">
        <input type="hidden" name="order_code" value="{{ $content['order_code'] }}" id="">
        <div class="width-card-history bg-white border border-gray-200 rounded-lg shadow">
            <div class="max-w-[200px] h-[250px]  flex mx-auto items-center">
                <img class=" " src="{{ $content['stock_image_preview'] }}" alt="" /> 
            </div> 
            <div class="p-5">
                <h5 class="capitalize text-[18px] leading-none font-semibold tracking-tight text-gray-900">{{ ($content['stock_name'] == null) ? 'Não informado' : $content['stock_name']   }}</h5>
                </a>
                <div class="flex items-center my-3">
                    <span class=" capitalize bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">{{ $content['stock_type'] }}</span>
                    <span class=" capitalize ml-3 bg-blue-300 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">{{ $content['stock_origin'] }}</span>
                </div>
                {{-- alert --}}
                <div id="box-alert-{{ $key }}" class="hidden flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="sr-only">Info</span>
                    <div class="ms-3 text-sm font-medium">
                      Erro: <span id="alert-message-{{ $key }}"></span>
                    </div>
                    <button onclick="closeAlert({{$key}})" type="button" class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700" >
                      <span class="sr-only">Close</span>
                      <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                      </svg>
                    </button>
                  </div>
                {{-- end alert --}} 
                <button type="button" id="button-form-history-{{ $key }}" onclick="downloadImage({{ $key }})" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Download
                <svg class="text-white ml-4 w-[50px] h-[50px] hidden" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 1v11m0 0 4-4m-4 4L4 8m11 4v3a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-3"></path>
                </svg>
                </button>
                <svg id="gif-loading-{{ $key }}"  xmlns="http://www.w3.org/2000/svg" class="w-[50px] mx-auto hidden" viewBox="0 0 200 200"><circle fill="#1E429F" stroke="#1E429F" stroke-width="15" r="15" cx="40" cy="100"><animate attributeName="opacity" calcMode="spline" dur="2" values="1;0;1;" keySplines=".5 0 .5 1;.5 0 .5 1" repeatCount="indefinite" begin="-.4"></animate></circle><circle fill="#1E429F" stroke="#1E429F" stroke-width="15" r="15" cx="100" cy="100"><animate attributeName="opacity" calcMode="spline" dur="2" values="1;0;1;" keySplines=".5 0 .5 1;.5 0 .5 1" repeatCount="indefinite" begin="-.2"></animate></circle><circle fill="#1E429F" stroke="#1E429F" stroke-width="15" r="15" cx="160" cy="100"><animate attributeName="opacity" calcMode="spline" dur="2" values="1;0;1;" keySplines=".5 0 .5 1;.5 0 .5 1" repeatCount="indefinite" begin="0"></animate></circle></svg>
                <a id="btn-download-finish-{{ $key }}" 
                  class=" hidden inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300"
                 download=""
                 href=""
                  >
                Salvar no meu computador
              </a>
            </div>
        </div> 
    </form>
    <style> 
        .width-card-history{
            width: calc(1200px / 4);
        }
    </style>