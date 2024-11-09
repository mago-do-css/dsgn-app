<x-app-layout> 
    <style>
        .width-image-processed {
            width: -webkit-fill-available;
            height: -webkit-fill-available;
        }        

    </style>
    <div class="py-12">
        
        <div class="max-w-7xl mx-auto flex">
          
            <div class="w-full">
                <form method="POST" action="{{ route('getHistoryTeste') }}">
                    @csrf
                    <input type="text" name="search" placeholder="nome da imagem"> 
                    <button type="submit">pesquisar</button>
                </form>
            </div>
        </div>
    </div> 
</x-app-layout>
