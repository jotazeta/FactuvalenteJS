<!doctype html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <meta name="description" content="FactuValente POS - The best point of sale system for managing your business efficiently.">
    <meta name="keywords" content="POS, Point of Sale, FactuValente, Business Management, Inventory, Billing">
    <meta name="author" content="FactuValente Team">
    <meta name="robots" content="index, follow">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="FactuValente POS - Efficient Business Management">
    <meta property="og:description" content="FactuValente POS is your ultimate solution for managing sales, inventory, and billing.">
    <meta property="og:image" content="assets/img/whiteBgColor.png">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="FactuValente POS - Efficient Business Management">
    <meta name="twitter:description" content="FactuValente POS is your ultimate solution for managing sales, inventory, and billing.">
    <meta name="twitter:image" content="assets/img/whiteBgColor.png">

    <title>{{ config('app.name', 'FactuValente POS') }}</title>
    <link rel="icon" type="image/x-icon" href="assets/img/whiteBgColor.ico">

    <!-- Fonts -->
    <link rel="stylesheet" href="./assets/css/interFontSwap.css" />

    <link rel="stylesheet" href="./assets/css/tailwind.output.css" />
    <link rel="stylesheet" href="./assets/css/loader.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/introjs.css" />

    <script src="./assets/js/tailwind.js"></script>
    
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
    <script src="./assets/js/intro.js"></script>
    
</head>
<body>
  
    <div id="app">
    <div
      class="flex h-screen bg-gray-50 dark:bg-gray-900"
      :class="{ 'overflow-hidden': isSideMenuOpen }"
    >
      <!-- Desktop sidebar -->
      <aside
        class="z-20 hidden w-48 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0 shadow-lg sidebarBig"
        id="sidebarBig"
      >
        <div class="text-gray-500 dark:text-gray-400">
          <a
            class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200"
            href="home"
            id="homeButton"
          >
          <img class="object-cover h-15 w-15 animate-pulse" src="assets/img/whiteBgColor.png" />

          </a>
          <ul class="mt-6">
            <li class="relative px-6 py-3" >
              <span {{{ (Request::is('home') ? '' : 'class=active') }}}
                class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                aria-hidden="true"
              ></span>
              <a
                class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100"
                href="home"
                id="dashboardLink"
              >
                <svg
                {{{ (Request::is('home') ? 'style=color:#7e3af2;' : '') }}}
                  class="w-5 h-5"
                  aria-hidden="true"
                  fill="none"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                  ></path>
                </svg>
                <span 
                  {{{ (Request::is('home') ? 'style=color:#7e3af2;' : '') }}}
                  class="ml-6">Dashboard
                </span>
              </a>
            </li>
          </ul>
          <ul>
            <li class="relative px-6 py-3">
            <span {{{ (Request::is('categories') ? '' : 'class=active') }}}
                class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                aria-hidden="true"
              ></span>
              <a
                class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                href="categories"
                id="categoriesLink"
              >
                <svg
                  {{{ (Request::is('categories') ? 'style=color:#7e3af2;' : '') }}}
                  class="w-5 h-5"
                  aria-hidden="true"
                  fill="none"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                </svg>
                <span 
                  {{{ (Request::is('categories') ? 'style=color:#7e3af2;' : '') }}}
                  class="ml-6">Categorías
                </span>
              </a>
            </li>
          </ul>
          <ul>
            <li class="relative px-6 py-3">
            <span {{{ (Request::is('clientes') ? '' : 'class=active') }}}
                class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                aria-hidden="true"
              ></span>
              <a
                class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                href="clientes"
                id="clientesLink"
              >
                <svg
                  {{{ (Request::is('clientes') ? 'style=color:#7e3af2;' : '') }}}
                  class="w-5 h-5"
                  aria-hidden="true"
                  fill="none"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />

                </svg>
                <span 
                  {{{ (Request::is('clientes') ? 'style=color:#7e3af2;' : '') }}}
                  class="ml-6">Clientes
                </span>
              </a>
            </li>
          </ul>
          <ul>
            <li class="relative px-6 py-3">
            <span {{{ (Request::is('codigo') ? '' : 'class=active') }}}
                class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                aria-hidden="true"
              ></span>
              <a
                class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                href="codigo"
                id="codigoLink"
              >
                <svg
                  {{{ (Request::is('codigo') ? 'style=color:#7e3af2;' : '') }}}
                  class="w-5 h-5"
                  aria-hidden="true"
                  fill="none"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                <path stroke-linecap="round" stroke-linejoin="round" d="m6.75 7.5 3 2.25-3 2.25m4.5 0h3m-9 8.25h13.5A2.25 2.25 0 0 0 21 18V6a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 6v12a2.25 2.25 0 0 0 2.25 2.25Z" />

                </svg>
                <span 
                  {{{ (Request::is('codigo') ? 'style=color:#7e3af2;' : '') }}}
                  class="ml-6">Códigos
                </span>
              </a>
            </li>
          </ul>
          <ul>
            <li class="relative px-6 py-3">
              <span {{{ (Request::is('productos', 'combos', 'servicios','productosFind', 'combosFind', 'serviciosFind') ? '' : 'class=active') }}}
                class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                aria-hidden="true"
              ></span>
              <a
                class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                href="productos"
                id="productsLink"
              >
                <svg
                  {{{ (Request::is('productos') ? 'style=color:#7e3af2;' : '') }}}
                  class="w-5 h-5"
                  aria-hidden="true"
                  fill="none"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3" />

                </svg>
                <span 
                  {{{ (Request::is('productos') ? 'style=color:#7e3af2;' : '') }}}
                  class="ml-6">Productos
                </span>
              </a>
            </li>
          </ul>
          <ul>
            <li class="relative px-6 py-3">
              <span {{{ (Request::is('facturacion') ? '' : 'class=active') }}}
                class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                aria-hidden="true"
              ></span>
              <a
                class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                href="facturacion"
                id="facturacionLink"
              >
                <svg 
                  {{{ (Request::is('facturacion') ? 'style=color:#7e3af2;' : '') }}}
                  xmlns="http://www.w3.org/2000/svg" 
                    fill="none" 
                    viewBox="0 0 24 24" 
                    stroke-width="1.5" 
                    stroke="currentColor" 
                    class="size-6"
                >
                  <path stroke-linecap="round" 
                    stroke-linejoin="round" 
                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 
                    0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 
                    1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" 
                  />
                </svg>
                <span 
                  {{{ (Request::is('facturacion') ? 'style=color:#7e3af2;' : '') }}}
                  class="ml-5">Facturación
                </span>
              </a>
            </li>
          </ul>
        </div>
      </aside>
      <span
        class="inset-y-0 left-0 w-2 bg-gray-200 rounded-tr-lg rounded-br-lg dark:bg-gray-800"
        aria-hidden="true"
      ></span>
      <!-- Mobile sidebar -->
      <!-- Backdrop -->
      <div
        x-show="isSideMenuOpen"
        x-transition:enter="transition ease-in-out duration-150"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in-out duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
      ></div>
      <aside
        class="fixed inset-y-0 z-20 flex-shrink-0 w-48 overflow-y-auto bg-white dark:bg-gray-800 md:hidden"
        x-show="isSideMenuOpen"
        x-transition:enter="transition ease-in-out duration-150"
        x-transition:enter-start="opacity-0 transform -translate-x-20"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in-out duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0 transform -translate-x-20"
        @click.away="closeSideMenu"
        @keydown.escape="closeSideMenu"
      >
        <div class="text-gray-500 dark:text-gray-400">
          <a
            class="text-lg font-bold text-gray-800 dark:text-gray-200"
            href="#"
          >
          <img class="object-cover w-15 h-15 animate-pulse" src="assets/img/whiteBgColor.png" />
          </a>
          <ul class="mt-6">
            <li class="relative px-6 py-3">
              <span
                {{{ (Request::is('home') ? '' : 'class=active') }}}
                class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                aria-hidden="true"
              ></span>
              <a
                class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                href="home"
              >
                <svg
                  class="w-5 h-5"
                  aria-hidden="true"
                  fill="none"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"
                  ></path>
                </svg>
                <span class="ml-4">Dashboard</span>
              </a>
            </li>
          </ul>
          <ul>
            <li class="relative px-6 py-3">
              <span
                {{{ (Request::is('categories') ? '' : 'class=active') }}}
                class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                aria-hidden="true"
              ></span>
              <a
                class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                href="categories"
              >
                <svg
                  class="w-5 h-5"
                  aria-hidden="true"
                  fill="none"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"
                  ></path>
                </svg>
                <span class="ml-4">Categorías</span>
              </a>
            </li>
          </ul>
          <ul>
            <li class="relative px-6 py-3">
              <span
                {{{ (Request::is('clientes') ? '' : 'class=active') }}}
                class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                aria-hidden="true"
              ></span>
              <a
                class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                href="clientes"
              >
                <svg
                  class="w-5 h-5"
                  aria-hidden="true"
                  fill="none"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                </svg>
                <span class="ml-4">Clientes</span>
              </a>
            </li>
          </ul>
          </ul>
          <ul>
            <li class="relative px-6 py-3">
              <span
                {{{ (Request::is('codigo') ? '' : 'class=active') }}}
                class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                aria-hidden="true"
              ></span>
              <a
                class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                href="codigo"
              >
                <svg
                  class="w-5 h-5"
                  aria-hidden="true"
                  fill="none"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"
                  ></path>
                </svg>
                <span class="ml-4">Códigos</span>
              </a>
            </li>
          </ul>
          <ul>
            <li class="relative px-6 py-3">
              <span
                {{{ (Request::is('productos', 'combos', 'servicios','productosFind', 'combosFind', 'serviciosFind') ? '' : 'class=active') }}}
                class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                aria-hidden="true"
              ></span>
              <a
                class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                href="productos"
              >
              <svg
                  class="w-5 h-5"
                  aria-hidden="true"
                  fill="none"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"
                  ></path>
                </svg>
                <span class="ml-4">Productos</span>
              </a>
            </li>
          </ul>
          <ul>
            <li class="relative px-6 py-3">
              <span
                {{{ (Request::is('facturacion') ? '' : 'class=active') }}}
                class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                aria-hidden="true"
              ></span>
              <a
                class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                href="facturacion"
              >
                <svg xmlns="http://www.w3.org/2000/svg" 
                    fill="none" 
                    viewBox="0 0 24 24" 
                    stroke-width="1.5" 
                    stroke="currentColor" 
                    class="size-6"
                >
                  <path stroke-linecap="round" 
                    stroke-linejoin="round" 
                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 
                    0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 
                    1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" 
                  />
                </svg>
                <span class="ml-4">Facturación</span>
              </a>
            </li>
          </ul>
        </div>
      </aside>
      <!-- init topmenu -->
      <div class="flex flex-col flex-1 w-full">
        <header class="z-10 bg-white shadow-md dark:bg-gray-800">
          <div
            class="container flex items-center justify-between h-full px-6 mx-auto text-purple-600 dark:text-purple-300"
          >
            <!-- Mobile hamburger -->
             <input type="text" id="statusMenu" class="hidden">
            <button
              class="p-1 mr-5 -ml-1 rounded-md focus:outline-none focus:shadow-outline-purple hidden lg:block md:block"
              onclick="toggleBig()"
              id="toggleBig"
            >
              <svg
                class="w-6 h-6"
                aria-hidden="true"
                fill="currentColor"
                viewBox="0 0 20 20"
              >
                <path
                  fill-rule="evenodd"
                  d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                  clip-rule="evenodd"
                ></path>
              </svg>
            </button>
            
            <button
              class="p-1 -ml-1 mr-5 rounded-md md:hidden focus:outline-none focus:shadow-outline-purple"
              @click="toggleSideMenu"
              aria-label="Menu"
            >
              <svg
                class="w-6 h-6"
                aria-hidden="true"
                fill="currentColor"
                viewBox="0 0 20 20"
              >
                <path
                  fill-rule="evenodd"
                  d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                  clip-rule="evenodd"
                ></path>
              </svg>
            </button>
            <!-- Search input -->
             
            <ul class="flex items-center flex-shrink-0 space-x-6 dark:text-gray-300">
              <!-- Theme toggler -->
              <li class="flex">
                <div class="dropdown inline-block relative hidden mt-2" id="filtroProductos">
                  <button class="text-purple-600 font-semibold py-2 px-4 inline-flex items-center">
                    <box-icon name='grid' color="#9333ea"></box-icon>
                  </button>
                  <ul class="dropdown-content absolute hidden text-gray-700 pt-1 right-3">
                    <li><a class="rounded-t bg-purple-200 hover:bg-purple-400 hover:text-white py-2 px-4 block whitespace-no-wrap cursor-pointer" onclick="filtrarCategoria()">Filtro Categoría</a></li>
                    <li class="dropdown">
                      <a class="bg-purple-200 hover:bg-purple-400 py-2 px-4 block hover:text-white whitespace-no-wrap" href="#">Cambiar tabla</a>
                        <ul class="dropdown-content absolute hidden text-gray-700 pl-5 ml-24 -mt-10 sm:right-[140px] -right-[100px]">
                          <li><a class="bg-purple-200 hover:bg-purple-400 hover:text-white py-2 px-4 block whitespace-no-wrap" href="productos">Productos</a>
                          <li><a class="bg-purple-200 hover:bg-purple-400 hover:text-white py-2 px-4 block whitespace-no-wrap" href="servicios">Servicios</a>
                          <li><a class="bg-purple-200 hover:bg-purple-400 hover:text-white py-2 px-4 block whitespace-no-wrap" href="combos">Combos</a>
                        </ul>
                    </li>
                  </ul>
                </div>
                
                <div class="flex-row m-2 mt-3 hidden" id="toggleImpuestoGlobal">
                  <span class="flex-row">Impuesto Global</span>
                    <div class="relative inline-block w-11 h-5">
                        <input id="impuestoGlobal" value="impuestoGlobal" name="impuestoGlobal" type="checkbox" onclick="doitImpuestoGlobal()" class="peer appearance-none w-11 h-5 bg-slate-100 rounded-full 
                        checked:bg-purple-600 cursor-pointer transition-colors duration-300" />
                        <label for="ventaNegativo" class="absolute top-0 left-0 w-5 h-5 bg-white rounded-full border border-slate-300 shadow-sm 
                        transition-transform duration-300 peer-checked:translate-x-6 peer-checked:border-slate-800 cursor-pointer">
                        </label>
                    </div>
                </div>
                <button
                  class="rounded-md focus:outline-none focus:shadow-outline-purple"
                  @click="toggleTheme"
                  aria-label="Toggle color mode"
                >
                  <template x-if="!dark">
                    <svg
                      class="w-5 h-5"
                      aria-hidden="true"
                      fill="currentColor"
                      viewBox="0 0 20 20"
                    >
                      <path
                        d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"
                      ></path>
                    </svg>
                  </template>
                  <template x-if="dark">
                    <svg
                      class="w-5 h-5"
                      aria-hidden="true"
                      fill="currentColor"
                      viewBox="0 0 20 20"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                        clip-rule="evenodd"
                      ></path>
                    </svg>
                  </template>
                </button>

                <div class="dropdown inline-block relative">
                  <button class="text-purple-600 font-semibold py-2 px-4 inline-flex items-center">
                    <img
                      class="object-cover w-8 h-8 rounded-full"
                      src="https://images.unsplash.com/photo-1502378735452-bc7d86632805?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&s=aa3a807e1bbdfd4364d1f449eaa96d82"
                      alt=""
                      aria-hidden="true"
                    />
                  </button>
                  <ul class="dropdown-content absolute hidden text-gray-700 pt-1 right-6">
                    <li><a class="rounded-t bg-purple-200 hover:bg-purple-400 py-2 px-4 block whitespace-no-wrap" href="#">Option 1</a></li>
                    <li><a class="bg-purple-200 hover:bg-purple-400 py-2 px-4 block whitespace-no-wrap" href="#">Option 2</a></li>
                    <li><a class="rounded-b bg-purple-200 hover:bg-purple-400 py-2 px-4 block whitespace-no-wrap"href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">Salir</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                        </form>
                    </li>
                  </ul>
                </div>


              </li>
              

              
             
            </ul>
        </div>
        </header>
        <main class="h-full overflow-y-auto">
            @yield('content')
        </main>
      </div>
    </div>
    </div>
    <input type="text" class="hidden" id="triggerInput" value="1">
</body>
<script>


function toggleBig(){
        var triggerInput = document.getElementById("triggerInput").value
        var sidebarBig = document.getElementById("sidebarBig");
        var dashboardLink = document.getElementById("dashboardLink");
        var toggleBig = document.getElementById("toggleBig");
        var homeButton = document.getElementById("homeButton");
        var categoriesLink = document.getElementById("categoriesLink");
        var codigoLink = document.getElementById("codigoLink");
        var productsLink = document.getElementById("productsLink");
        var facturacionLink = document.getElementById("facturacionLink");
        var clientesLink = document.getElementById("clientesLink");

        if(triggerInput == 1){
          sidebarBig.classList.remove("w-64");
          dashboardLink.classList.remove("w-full");
          categoriesLink.classList.remove("w-full");
          codigoLink.classList.remove("w-full");
          productsLink.classList.remove("w-full");
          facturacionLink.classList.remove("w-full");
          clientesLink.classList.remove("w-full");
          toggleBig.classList.add("hidden");
          sidebarBig.classList.add("w-16");

          document.getElementById("triggerInput").value = 2
          return
        } 
        
        if(document.getElementById("triggerInput").value == 2){
          console.log(triggerInput, 'amplia')
          toggleBig.classList.remove("hidden");
          sidebarBig.classList.remove("w-16");
          sidebarBig.classList.add("w-64");
          dashboardLink.classList.add("w-full");
          categoriesLink.classList.add("w-full");
          codigoLink.classList.add("w-full");
          productsLink.classList.add("w-full");
          facturacionLink.classList.add("w-full");
          clientesLink.classList.add("w-full");
          document.getElementById("triggerInput").value = 1
          return
        }


        var screenWidth = window.screen.width

        if(screenWidth < 600){
          toggleBig.setAttribute("style", "display: none;")
          return
        }

   
      }
   
</script>
<style>
 
@font-face {
  font-family: 'digital';
  src: url('./assets/fonts/digital.ttf') format('truetype');
  font-weight: normal;
  font-style: normal;
}
  .dropdown:hover > .dropdown-content {
	display: block;
}
.sidebarBig{
  transition: width 0.7s;
}
.fontz{
  font-family: 'digital';
}
</style>
</html>
