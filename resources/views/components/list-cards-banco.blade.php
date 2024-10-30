@php
    $cardsData = [
        [
            'text' => 'Shutterstock',
            'image' => 'shutter.png',
            'url' => 'https://shutterstock.com/'
        ] ,
        [
            'text' => 'iStock',
            'image' => 'istock.png',
            'url' => 'https://www.istockphoto.com/br'
        ],
        [
            'text' => 'Freepik',
            'image' => 'freepik.png',
            'url' => 'https://br.freepik.com/'
        ],
        [
            'text' => 'Envato',
            'image' => 'envato.png',
            'url' => 'https://elements.envato.com/pt-br/'
        ],
        [
            'text' => 'Motion Array',
            'image' => 'motion.png',
            'url' => 'https://motionarray.com/'
        ],
        [
            'text' => 'Graphic Pear',
            'image' => 'graphic.png',
            'url' => 'https://www.graphicpear.com/'
        ],
    ];
@endphp
<div class="list-none flex-column space-y space-y-4 text-sm font-medium text-gray-500  mb-4 md:mb-0 w-max">
    @foreach ($cardsData as $card)
    <li>
        <x-card-banco :name="$card['text']" :image="$card['image']" :url="$card['url']" />
    </li>
    @endforeach
</div>  
