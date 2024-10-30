@props(['page', 'paginationData'])
<div>
    <nav aria-label="Page navigation example">
        <ul class="inline-flex -space-x-px text-sm">
            <li>
                <a href="#"
                    class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Previous</a>
            </li>
            @for ($i = $paginationData['startNumber']; $i <= $paginationData['endNumber']; $i++)
                <li>
                    <a @if ($i == $page) aria-current="page" @endif
                        href="{{ route('history', ['page' => $i]) }}"
                        class=" flex items-center justify-center px-3 h-8 leading-tight 
                          @if ($i == $page) text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 
                          @else text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 @endif 
                        ">
                        {{ $i }}
                    </a>
                </li>
            @endfor

            <li>
                <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Next</a>
            </li>
        </ul>
    </nav>
</div>
