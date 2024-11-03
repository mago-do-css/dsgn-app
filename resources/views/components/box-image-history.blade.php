@props(['content', 'key']) 
    {{-- max-w-sm --}}
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
            <a href="#" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
               Download
               <svg class="w-4 h-4 text-white ml-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 18">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 1v11m0 0 4-4m-4 4L4 8m11 4v3a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-3"></path>
            </svg>
            </a>
        </div>
    </div> 
    <style> 
        .width-card-history{
            width: calc(1200px / 4);
        }
    </style>