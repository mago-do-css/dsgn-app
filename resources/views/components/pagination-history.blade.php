@props(['page', 'paginationData'])
<div>
    <nav aria-label="Page navigation example">
        <ul class="inline-flex -space-x-px text-sm">
            <li>
                <a onclick="updatePagination({{ $paginationData['previousPage'] }})" 
                    class="cursor-pointer flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Anterior</a>
            </li>
            @for ($i = $paginationData['startNumber']; $i <= $paginationData['endNumber']; $i++)
                <li>
                    <a @if ($i == $page) aria-current="page" @endif
                        {{-- href="{{ route('history', ['page' => $i]) }}" --}}
                        onclick="updatePagination({{ $i }})"
                        class="cursor-pointer flex items-center justify-center px-3 h-8 leading-tight 
                          @if ($i == $page) text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 
                          @else text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 @endif 
                        ">
                        {{ $i }}
                    </a>
                </li>
            @endfor 
            <li>
                <a onclick="updatePagination({{ $paginationData['nextPage'] }})"  class=" cursor-pointer flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Próximo</a>
            </li>
        </ul>
    </nav>
</div>
<script>
    function updatePagination(newPage) {
         
    // Obtém a URL atual do navegador
    const currentUrl = window.location.href;

    // Cria um objeto URL a partir da URL atual
    const urlObj = new URL(currentUrl);

    // Obtém os parâmetros existentes
    const params = new URLSearchParams(urlObj.search);

    // Atualiza ou adiciona o parâmetro de página
    params.set('page', newPage);

    // Constrói a nova URL
    urlObj.search = params.toString();
    
    window.location.href = urlObj.toString();
}
</script>