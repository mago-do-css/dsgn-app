<x-app-layout> 
    <style>
        .width-image-processed {
            width: -webkit-fill-available;
            height: -webkit-fill-available;
        }        

    </style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- <x-list-cards-banco /> --}}
        </div>
        <div class="max-w-7xl mx-auto flex">
            <div>
                <x-list-cards-banco />
            </div>
            <div class="w-full">
                <form method="POST" action="{{ route('sendStocTeste') }}">
                    @csrf
                    <input type="text" name="stock_url" placeholder="url">
                    <input type="text" name="isPreview">
                    <button type="submit">ok</button>
                </form>
            </div>
        </div>
    </div> 
</x-app-layout>
