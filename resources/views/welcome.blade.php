@extends('layouts.app')


@section('content')
      <!--Main-->
    <div class="leading-normal w-full tracking-normal text-indigo-400 bg-cover bg-fixed" style="background-image: url('assets/img/header.png');">
       <div class="h-full">
            
            <!--Main-->
            <div class="container pt-24 md:pt-36 mx-auto flex flex-wrap flex-col md:flex-row items-center">
              <!--Left Col-->
              <div class="flex flex-col w-full xl:w-2/5 justify-center lg:items-start overflow-y-hidden">
                <h1 class="my-4 text-3xl md:text-5xl text-white opacity-75 font-bold leading-tight text-center md:text-left">
                  Use nuestro
                  <span class="bg-clip-text text-transparent bg-gradient-to-r from-green-400 via-pink-500 to-purple-500">
                    Sistema Administrativo PO
                  </span>
                  para aumentar y controlar su ventas
                </h1>
                <p class="leading-normal text-base md:text-2xl mb-8 text-center md:text-left">
                  ¡¡Maneje sus inventarios, cierre de caja, usuarios y mucho mas!! Con conexión a la DIAN para
                  Facturación Electrónica
                </p>

                <form class="bg-gray-900 opacity-75 w-full shadow-lg rounded-lg px-8 pt-6 pb-8 mb-4">
                  <div class="mb-4">
                    <label class="block text-blue-300 py-2 font-bold mb-2" for="emailaddress">
                      Solicite mas información
                    </label>
                    <input
                      class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-tight focus:ring transform transition hover:scale-105 duration-300 ease-in-out"
                      id="emailaddress"
                      type="text"
                      placeholder="yo@ejemplo.com"
                    />
                  </div>

                  <div class="flex items-center justify-between pt-4">
                    <button
                      class="bg-gradient-to-r from-purple-800 to-green-500 hover:from-pink-500 hover:to-green-500 text-white font-bold py-2 px-4 rounded focus:ring transform transition hover:scale-105 duration-300 ease-in-out"
                      type="button"
                    >
                      Solicitar Info
                    </button>
                  </div>
                </form>
              </div>

              <!--Right Col-->
              <div class="w-full xl:w-3/5 p-12 overflow-hidden">
                <img class="mx-auto w-full md:w-4/5 transform -rotate-6 transition hover:scale-105 duration-700 ease-in-out hover:rotate-6" src="assets/img/pos1.jpg" />
              </div>

              <div class="mx-auto md:pt-16">
                <p class="text-blue-400 font-bold pb-8 lg:pb-6 text-center">
                  Descargue nuestra aplicación:
                </p>
                <div class="flex w-full justify-center md:justify-start pb-24 lg:pb-0 fade-in">
                  <img src="assets/img/App Store.svg" class="h-12 pr-12 transform hover:scale-125 duration-300 ease-in-out" />
                  <img src="assets/img/Play Store.svg" class="h-12 transform hover:scale-125 duration-300 ease-in-out" />
                </div>
              </div>

              <!--Footer-->
              <div class="w-full pt-16 pb-6 text-sm text-center md:text-left fade-in">
                <a class="text-gray-500 no-underline hover:no-underline" href="#">&copy; JZapata - 2025</a>
              </div>
            </div>
          </div>
    </div>
     

@endsection

