<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="./assets/css/tailwind.output.css" />
    <script src="./assets/js/tailwindcdn.js"></script>
       <!-- Alpine Plugins -->
       <script defer src="./assets/js/alpine-focus.js"></script>
    <script defer src="./assets/js/alpine-collapse.js"></script>
    <!-- Alpine Core -->
    <script defer src="./assets/js/alpine-core.js" defer></script>
    
    <script src="./assets/js/init-alpine.js"></script>
    <script src="./assets/js/axios.js"></script>
    <script src="./assets/js/sweet-alert.js"></script>
    <script src="./assets/js/box-icons.js"></script>
    <script src="./assets/js/js-barcode.js"></script>
    

    
</head>
<body>
    <div id="app">
        <nav x-data="{ mobileMenuIsOpen: false }" x-on:click.away="mobileMenuIsOpen = false" class="relative flex items-center justify-between border-b border-outline px-6 py-4 dark:border-outline-dark" aria-label="penguin ui menu">
            <!-- Brand Logo -->
            <a href="{{ url('/') }}" class="text-2xl font-bold text-on-surface-strong dark:text-on-surface-dark-strong">
                <img class="object-cover max-w-24 animate-pulse" src="assets/img/whiteBgColor.png" />
            </a>
            <!-- Desktop Menu -->
            <ul class="hidden items-center gap-4 md:flex">
                <li><a href="{{ url('/') }}" class="font-bold text-primary underline-offset-2 hover:text-primary focus:outline-hidden focus:underline dark:text-primary-dark dark:hover:text-primary-dark" aria-current="page">Inicio</a></li>
                <li><a href="{{ route('login') }}" class="font-medium text-on-surface underline-offset-2 hover:text-primary focus:outline-hidden focus:underline dark:text-on-surface-dark dark:hover:text-primary-dark">Login</a></li>
                <li><a href="{{ route('register') }}" class="font-medium text-on-surface underline-offset-2 hover:text-primary focus:outline-hidden focus:underline dark:text-on-surface-dark dark:hover:text-primary-dark">Registrar</a></li>
            </ul>
            <!-- Mobile Menu Button -->
            <button x-on:click="mobileMenuIsOpen = !mobileMenuIsOpen" x-bind:aria-expanded="mobileMenuIsOpen" x-bind:class="mobileMenuIsOpen ? 'fixed top-6 right-6 z-20' : null" type="button" class="flex text-on-surface dark:text-on-surface-dark md:hidden" aria-label="mobile menu" aria-controls="mobileMenu">
                <svg x-cloak x-show="!mobileMenuIsOpen" xmlns="http://www.w3.org/2000/svg" fill="none" aria-hidden="true" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
                <svg x-cloak x-show="mobileMenuIsOpen" xmlns="http://www.w3.org/2000/svg" fill="none" aria-hidden="true" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
            <!-- Mobile Menu -->
            <ul x-cloak x-show="mobileMenuIsOpen" x-transition:enter="transition motion-reduce:transition-none ease-out duration-300" 
            x-transition:enter-start="-translate-y-full" x-transition:enter-end="translate-y-0" 
            x-transition:leave="transition motion-reduce:transition-none ease-out duration-300" 
            x-transition:leave-start="translate-y-0" x-transition:leave-end="-translate-y-full" 
            id="mobileMenu" class="bg-white opacity-90 fixed max-h-svh overflow-y-auto inset-x-0 top-0 z-10 flex flex-col 
            divide-y divide-outline rounded-b-radius border-b border-outline bg-surface-alt px-6 pb-6 pt-20 
            dark:divide-outline-dark dark:border-outline-dark dark:bg-surface-dark-alt md:hidden">
                <li class="py-4"><a href="{{ url('/') }}" class="text-purple-600 w-full text-lg font-bold text-primary focus:underline dark:text-primary-dark" aria-current="page">Inicio</a></li>
                <li class="py-4"><a href="{{ route('login') }}" class="text-purple-600 w-full text-lg font-medium text-on-surface focus:underline dark:text-on-surface-dark">Login</a></li>
                <li class="py-4"><a href="{{ route('register') }}" class="text-purple-600 w-full text-lg font-medium text-on-surface focus:underline dark:text-on-surface-dark">Registrar</a></li>
            </ul>
        </nav>
        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>
