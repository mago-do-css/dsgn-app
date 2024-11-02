@props(['name', 'image', 'url'])
<a target="noopener noreferrer" href="{{ $url }}" class="cursor-pointer inline-flex items-center px-4 py-3 rounded-lg hover:text-gray-900 bg-gray-50 hover:bg-blue-700 hover:text-white w-full ">
    <img class="w-[35px] mr-[5px]" src="{{ asset('assets/images/icons-logos/' . $image) }}" alt="">
    {{ $name }} 
</a>