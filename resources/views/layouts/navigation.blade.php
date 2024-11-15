<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('history')" :active="request()->routeIs('history')">
                        {{ __('Histórico') }}
                    </x-nav-link>

                    <a
                        class="inline-flex items-center px-1 pt-1 cursor-default select-none border-indigo-400 dark:border-indigo-600 text-sm font-medium leading-5 text-gray-400 dark:text-gray-600 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out">
                        Favoritos
                        <span
                            class="text-white bg-gradient-to-r from-indigo-500 via-violet-600 to-fuchsia-700 focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 shadow-md shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded text-[10px] px-2 py-0.5 text-center ml-2 me-2 mb-0">EM
                            BREVE</span>
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <form id="limitCounter" class="ml-auto">@csrf<a data-popover-target="popover-bottom"
                    data-popover-placement="bottom" type="button"
                    class="text-white cursor-default select-none bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-3 py-1.5 text-center me-4 mb-2 mt-3.5 inline-flex items-center">
                    <!-- SVG Icon on the Left -->
                    <svg class="w-6 h-6 text-white mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="white" viewBox="0 0 24 24">
                        <path
                            d="M13.383 4.076a6.5 6.5 0 0 0-6.887 3.95A5 5 0 0 0 7 18h3v-4a2 2 0 0 1-1.414-3.414l2-2a2 2 0 0 1 2.828 0l2 2A2 2 0 0 1 14 14v4h4a4 4 0 0 0 .988-7.876 6.5 6.5 0 0 0-5.605-6.048Z" />
                        <path
                            d="M12.707 9.293a1 1 0 0 0-1.414 0l-2 2a1 1 0 1 0 1.414 1.414l.293-.293V19a1 1 0 1 0 2 0v-6.586l.293.293a1 1 0 0 0 1.414-1.414l-2-2Z" />
                    </svg>
                    Limite
                    <div class="flex ml-1 items-center justify-center min-w-10 h-6">
                        <svg id="loader" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200">
                            <circle fill="white" stroke="white" stroke-width="15" r="15" cx="40" cy="100"
                                data-darkreader-inline-fill="" data-darkreader-inline-stroke=""
                                style="--darkreader-inline-fill: white; --darkreader-inline-stroke: white;">
                                <animate attributeName="opacity" calcMode="spline" dur="2" values="1;0;1;"
                                    keySplines=".5 0 .5 1;.5 0 .5 1" repeatCount="indefinite" begin="-.4"></animate>
                            </circle>
                            <circle fill="white" stroke="white" stroke-width="15" r="15" cx="100" cy="100"
                                data-darkreader-inline-fill="" data-darkreader-inline-stroke=""
                                style="--darkreader-inline-fill: white; --darkreader-inline-stroke: white;">
                                <animate attributeName="opacity" calcMode="spline" dur="2" values="1;0;1;"
                                    keySplines=".5 0 .5 1;.5 0 .5 1" repeatCount="indefinite" begin="-.2"></animate>
                            </circle>
                            <circle fill="white" stroke="white" stroke-width="15" r="15" cx="160" cy="100"
                                data-darkreader-inline-fill="" data-darkreader-inline-stroke=""
                                style="--darkreader-inline-fill: white; --darkreader-inline-stroke: white;">
                                <animate attributeName="opacity" calcMode="spline" dur="2" values="1;0;1;"
                                    keySplines=".5 0 .5 1;.5 0 .5 1" repeatCount="indefinite" begin="0"></animate>
                            </circle>
                        </svg>
                        <span id="limitDisplay">
                            <span id="actualLimit"></span>/<span id="totalLimit"></span>
                        </span>
                    </div>
                </a>
            </form>
            <div data-popover id="popover-bottom" role="tooltip"
                class="absolute z-10 shadow-md shadow-indigo-500/40 invisible inline-block w-64 text-sm text-gray-700 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                <div class="px-3 py-2 cursor-default select-none shadow-indigo-500/40">
                    <p>Este é o seu limite diário de pedido.</p>
                    <p>Ele é resetado todo dia.</p>
                </div>
                <div data-popper-arrow></div>
            </div>

            <!-- Dropdown Button -->
            <button id="dropdownAvatarNameButton" data-dropdown-toggle="dropdownAvatarName"
                class="flex items-center text-sm pe-1 font-medium text-gray-900 hover:text-blue-600 dark:hover:text-blue-500 md:me-0 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-white"
                type="button">
                <span class="sr-only">Open user menu</span>
                <img class="w-9 h-9 me-2 rounded-full" src="{{ asset('assets/images/avatar.png') }}" alt="user photo">
                {{ Auth::user()->name }}
                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 4 4 4-4" />
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div id="dropdownAvatarName"
                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-md shadow-indigo-500/40 w-52 dark:bg-gray-700 dark:divide-gray-600">
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownAvatarNameButton">
                    <li>
                        <a
                            class="block px-4 py-2 cursor-default select-none hover:bg-gray-100 text-gray-400 dark:hover:bg-gray-600 dark:hover:text-grey-200">Minha
                            Assinatura
                            <span
                                class="text-white bg-gradient-to-r from-indigo-500 via-violet-600 to-fuchsia-700 focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 shadow-md shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded text-[8px] px-2 py-1 text-center ml-1 me-2 mb-0">EM
                                BREVE</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('profile.edit') }}"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Perfil</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Ajuda</a>
                    </li>
                </ul>
                <div class="py-2">
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                        Sair
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
<script>
    document.addEventListener('DOMContentLoaded', limitCounter());

    function limitCounter() {
        const xhttp = new XMLHttpRequest();
        const actionUrl = @json(route('userLimit'));
        let actualLimit = document.getElementById('actualLimit');
        let totalLimit = document.getElementById('totalLimit');
        let loader = document.getElementById('loader');
        let limitDisplay = document.getElementById('limitDisplay');
        var form = document.getElementById('limitCounter');
        var token = form.querySelector('input[name="_token"]').value;

        xhttp.open("GET", actionUrl, true);
        xhttp.setRequestHeader("Content-Type", "application/json");
        xhttp.setRequestHeader("X-CSRF-TOKEN", token);

        // Exibe o loader e oculta o display do limite
        loader.classList.remove('hidden');
        limitDisplay.classList.add('hidden');

        xhttp.onload = function() {
            let response;

            try {
                response = JSON.parse(this.responseText);
            } catch (error) {
                response = {
                    status: false,
                    message: "Resposta do servidor está inválida. Contacte o suporte!"
                };
            }

            // Atualiza os valores de limite
            actualLimit.innerHTML = response.actualLimit;
            totalLimit.innerHTML = response.totalLimit;

            // Oculta o loader e exibe o display do limite após carregar os dados
            loader.classList.add('hidden');
            limitDisplay.classList.remove('hidden');
        };

        xhttp.onerror = function() {
            console.error('Erro:' + this.message);
            loader.classList.add('hidden');
            limitDisplay.classList.remove('hidden');
        };

        xhttp.send();
    }
</script>
