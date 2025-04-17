@extends('layouts.layoutDash')

@section('content')
<div class="loading" id="loader"></div>
<div class="loading hidden" id="loader1"></div>
<div class="container grid px-6 mx-auto">
          <div class="flex w-1/2 content-center">
            <div class="flex items-center mr-2">
                <h2
                  class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
                >
                  Codigos UNSPSC 
                </h2>
                <div class="relative w-fit mr-3">
                  
                    <div x-data="{ showTooltip: false }" class="relative w-fit">
                        <button x-on:click="showTooltip = !showTooltip" type="button" class="rounded-radius bg-surface-alt px-2 py-2 
                        font-medium tracking-wide text-on-surface focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary 
                        dark:bg-surface-dark-alt dark:border-surface-dark-alt dark:text-on-surface-dark dark:focus-visible:outline-primary-dark" 
                        aria-describedby="tooltipExample">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9333ea" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                            </svg>
                        </button>
                        <div 
                        style="margin-left: -100px";
                        x-cloak x-show="showTooltip" x-on:click.outside="showTooltip = false" id="tooltipExample" 
                        class="absolute -top-3 text-white z-10 -ml-30 bg-purple-600 whitespace-nowrap rounded-sm bg-surface-dark px-2 py-1 text-center 
                        text-sm text-on-surface-dark-strong dark:bg-surface dark:text-on-surface-strong" role="tooltip" x-transition:enter="transition ease-out" 
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out" 
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">Es un campo obligatorio si generas <br>facturas electrónicas. <br>
                            Descarga los códigos aqui: 
                            <button type="submit" onclick="window.open('files/unspsc_castellano.pdf')" 
                                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-1 px-2 rounded inline-flex items-center">
                                <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" 
                                    viewBox="0 0 20 20"><path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z"/>
                                </svg>
                                <span>Descargar PDF</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex items-center">
                <button
                  class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white 
                  transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 
                  hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                  onclick="openModal('main-modal')"
                >
                  <i class="fa fa-plus-circle" aria-hidden="true"></i>
                </button>
            </div>
          </div>
            <!-- table categories -->
            @if($codigos->isEmpty())
              <div class="flex flex-row min-h-80 justify-center items-center">
                  <div class="flex items-center mr-2">
                      <p
                        class="my-6 font-semibold text-gray-700 dark:text-gray-200"
                      >
                        No tienes Códigos UNSPSC creados
                      </p>
                  </div>
                  <div class="flex items-center">
                      <button
                        class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white 
                        transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 
                        hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                        onclick="openModal('main-modal')"
                      >
                        Crear Código
                      </button>
                  </div>
              </div>
            @else
            <div class="w-full overflow-hidden rounded-lg shadow-xs">
              <div class="w-full overflow-x-auto">
               
                <table class="w-full whitespace-no-wrap">
                  <thead>
                    <tr
                      class="text-xs font-semibold tracking-wide text-left text-white uppercase border-b dark:border-gray-700 bg-purple-600 dark:text-gray-400 dark:bg-gray-800"
                    >
                      <th class="px-4 py-3 text-center">Código</th>
                      <th class="px-4 py-3 text-center">Nombre</th>
                      <th class="px-4 py-3 text-center">Descripción</th>
                      <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                  </thead>
                  <tbody
                    class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                  >
                    @foreach($codigos as $data)
                      <tr class="text-gray-700 dark:text-gray-400">
                        
                        <td class="px-4 py-3 text-center">
                            {{ $data->codigo }}
                        </td>
                       
                        <td class="px-4 py-3 text-center">
                          {{ $data->name }}
                        </td>
                        <td class="px-4 py-3 text-center">
                          {{ $data->description }}
                        </td>
                        <td class="px-4 py-3 text-center">
                          <div class="space-x-4 text-sm">
                            <button
                              class="justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                              aria-label="Edit"
                              onclick="openModal('another-modal'); showCodigoEdit('{{ $data->id }}', '{{ $data->codigo }}', '{{ $data->name }}', '{{ $data->description }}')"
                            >
                              <svg
                                class="w-5 h-5"
                                aria-hidden="true"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                              >
                                <path
                                  d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"
                                ></path>
                              </svg>
                            </button>
                            <button
                              class="justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                              onclick="destroyCodigo('{{ $data->id }}')"
                              aria-label="Delete"
                            >
                              <svg
                                class="w-5 h-5"
                                aria-hidden="true"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                              >
                                <path
                                  fill-rule="evenodd"
                                  d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                  clip-rule="evenodd"
                                ></path>
                              </svg>
                            </button>
                          </div>
                        </td>
                        
                      </tr>

                    @endforeach  
                  </tbody>
                </table>
                {!! $codigos->links() !!}
                
                
              </div>
            </div>
            @endif
           


          <div class="main-modal fixed w-full inset-0 z-50 overflow-hidden flex justify-center items-center animated fadeIn faster" style="background: rgba(0,0,0,.7);">
            <div class="border border-blue-500 shadow-lg modal-container bg-white mx-auto rounded-xl shadow-lg z-50 overflow-y-auto">
              <div class="modal-content py-4 text-left px-6 dark:bg-gray-800">
                <!--Title-->
                <div class="flex justify-between items-center pb-3 dark:bg-gray-800">
                  <p class="text-2xl font-bold text-gray-500">Agregar Código</p>
                  <div class="modal-close cursor-pointer z-50" onclick="modalClose('main-modal')">
                    <svg class="fill-current text-gray-500" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                      viewBox="0 0 18 18">
                      <path
                        d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
                      </path>
                    </svg>
                  </div>
                </div>
                <!--Body-->
                <div class="container px-6 mx-auto grid">
               
                    <form id="some-form" action="{{ route('codigoCreate') }}" class="group" method="POST" enctype="multipart/form-data" novalidate>
                          @csrf
                      <div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">
                        
                        <div>
                            <p
                                class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                            >
                                Código UNSPSC*
                            </p>
                            
                                <input
                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                                focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                                form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer"
                                placeholder="introduzca Código"
                                id="codigo"
                                type="text" 
                                name="codigo"
                                required
                                pattern="[0-9a-zA-Z ]{3,}"
                                
                                />
                                <span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">
                                Solo puede introducir letras y números, mínimo 3 caracteres.
                                </span>
                            </div>
                      </div>                    
                      <div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">
                        <div>
                          <p
                            class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                          >
                            Nombre*
                          </p>
                        
                            <input
                              class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                              focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                              form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer"
                              placeholder="introduzca nombre"
                              id="name"
                              type="text" 
                              name="name"
                              required
                              pattern="[0-9a-zA-Z ]{3,}"
                              
                            />
                            <span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">
                              Solo puede introducir letras y números, mínimo 3 caracteres.
                            </span>
                        </div>
                      </div>
                    <div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">
                        <div>
                            <p
                              class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                            >
                              Descripción
                            </p>
                            <input
                               class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                                focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                                form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer"
                                required
                                type="text"
                                placeholder="introduzca descripción"
                                id="description"
                                name="description"
                                type="text" 
                                pattern="[0-9a-zA-Z ]{3,}"
                                />
                            <span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">
                              Solo puede introducir letras y números, mínimo 3 caracteres.
                            </span>
                          </div>
                      </div>
                      
                      <div class="flex items-center px-4 py-2 space-x-4 text-sm">
                            <button
                              class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white 
                                    transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 
                                    hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple hidden"
                              type="submit"
                            > Guardar
                            </button>
                        </div>
                    </form>
                      <div class="flex items-center px-4 py-2 space-x-4 text-sm">
                        <button
                                  class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-black 
                                      transition-colors duration-150 bg-gray-100 border rounded-lg"
                                  aria-label="Edit"
                                  onclick="modalClose('main-modal')"
                                >Cancelar
                          </button>
                          <div>
                            <button 
                                class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white 
                                          transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg 
                                          active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple
                                          disabled"
                                onclick="submitAddCod()"
                                
                                >Agregar
                            </button>
                          </div>
                        
                      </div>
                  </div>
                 
                <!--Footer-->
                <div class="flex justify-end pt-2 space-x-14 dark:bg-gray-800">
                  
                  
                </div>
              </div>
            </div>
          </div>

          <div class="another-modal fixed w-full inset-0 z-50 overflow-hidden flex justify-center items-center animated fadeIn faster" style="background: rgba(0,0,0,.7);">
            <div class="border border-blue-500 shadow-lg modal-container bg-white mx-auto rounded-xl shadow-lg z-50 overflow-y-auto">
              <div class="modal-content py-4 text-left px-6">
                <!--Title-->
                <div class="flex justify-between items-center pb-3">
                  <p class="text-2xl font-bold text-gray-500">Editar Código UNSPSC</p>
                  <div class="modal-close cursor-pointer z-50" onclick="modalClose('another-modal')">
                    <svg class="fill-current text-gray-500" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                      viewBox="0 0 18 18">
                      <path
                        d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
                      </path>
                    </svg>
                  </div>
                </div>
                <!--Body-->
                <div class="container px-6 mx-auto grid" id="bodyEdit">
                <form id="formEdit" action="{{ route('codigoEdit') }}" class="group" method="POST" enctype="multipart/form-data" novalidate>
                          @csrf
                      <div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">
                        <div>
                            <p
                                class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                            >
                                Código
                            </p>
                                
                                <input
                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                                focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                                form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer"
                                placeholder="introduzca nombre"
                                id="codigoEdit"
                                type="text" 
                                name="codigoEdit"
                                required
                                pattern="[0-9a-zA-Z ]{3,}"
                                
                                />
                                <span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">
                                Solo puede introducir letras y números, mínimo 3 caracteres.
                                </span>
                            </div>
                      </div>                    
                      <div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">
                        <div>
                          <p
                            class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                          >
                            Nombre
                          </p>
                            <div class="" id="actualImage">

                            </div>
                            <input
                              class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                              focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                              form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer"
                              placeholder="introduzca nombre"
                              id="nameEdit"
                              type="text" 
                              name="nameEdit"
                              required
                              pattern="[0-9a-zA-Z ]{3,}"
                              
                            />
                            <span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">
                              Solo puede introducir letras y números, mínimo 3 caracteres.
                            </span>
                        </div>
                      </div>
                    <div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">
                        <div>
                            <p
                              class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                            >
                              Descripción
                            </p>
                            <input
                               class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                                focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                                form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer"
                                type="text"
                                placeholder="introduzca descripción"
                                id="descriptionEdit"
                                name="descriptionEdit"
                                type="text" 
                                pattern="[0-9a-zA-Z ]{3,}"
                                />
                            <span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">
                              Solo puede introducir letras y números, mínimo 3 caracteres.
                            </span>
                          </div>
                      </div>
                      
                      <div class="flex items-center px-4 py-2 space-x-4 text-sm">
                            <button
                              class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white 
                                    transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 
                                    hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple hidden"
                              type="submit"
                            > Guardar
                            </button>
                        </div>
                    </form>
                      <div class="flex items-center px-4 py-2 space-x-4 text-sm">
                            <div class="modal-close cursor-pointer z-50" onclick="modalClose('another-modal')">
                                Cancelar
                            </div>
                          <div>
                            <button 
                                class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white 
                                          transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg 
                                          active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple
                                          disabled"
                                onclick="submitEditCod()"
                                
                                >Agregar
                            </button>
                          </div>
                        
                      </div>             
                 
                </div>
                <!--Footer-->
                <div class="flex justify-end pt-2 space-x-14">
                  
                </div>
              </div>
            </div>
          </div>


            
<!-- component -->
<style>
    .image-container{
      background: #f2f2f2;
      height: 15rem;
      position: relative;
      width: 15rem;
    }
    
    .image-size{
      height: 15rem;
      position: relative;
      width: 15rem;
      object-fit: contain;  
    }
    

    .addCat {
      background-color: indigo;
      color: white;
      padding: 0.5rem;
      font-family: sans-serif;
      border-radius: 0.3rem;
      cursor: pointer;
      margin-top: 1rem;
    }
    tr:nth-child(even) {
      background-color: #f2f2f2;
    }
		.animated {
			-webkit-animation-duration: 1s;
			animation-duration: 1s;
			-webkit-animation-fill-mode: both;
			animation-fill-mode: both;
		}

		.animated.faster {
			-webkit-animation-duration: 500ms;
			animation-duration: 500ms;
		}

		.fadeIn {
			-webkit-animation-name: fadeIn;
			animation-name: fadeIn;
		}

		.fadeOut {
			-webkit-animation-name: fadeOut;
			animation-name: fadeOut;
		}

		@keyframes fadeIn {
			from {
				opacity: 0;
			}

			to {
				opacity: 1;
			}
		}

		@keyframes fadeOut {
			from {
				opacity: 1;
			}

			to {
				opacity: 0;
			}
		}
	</style>
  <script>
    @if (session('success'))

      const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
          }
      });

      Toast.fire({
          icon: 'success',
          title: '{{ session('success') }}'
      });
      @endif

      @if (session('error'))

      const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
          }
      });

      Toast.fire({
          icon: 'error',
          title: '{{ session('error') }}'
      });
      @endif
    </script>
  <script>

          document.addEventListener("DOMContentLoaded", function(event) {
                      setTimeout(() => loader.style.display = 'none', 100);
                  });

          var loader = document.querySelector('#loader')
          var formCreate = document.querySelector('#some-form');

          function submitAddCod(){
            var loader1 = document.querySelector('#loader1')
            var codigo = document.getElementById('codigo').value
            var name = document.getElementById('name').value
            var description = document.getElementById('description').value
            var pattern = /^[\w ]*$/
           
            if(codigo == '' && name == '' && description == ''){
              Swal.fire({
                    title: 'Error!',
                    text: 'Inputs vacíos.',
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: false,
                });
                
            }
            else if(codigo == ''){
                  Swal.fire({
                    title: 'Error!',
                    text: 'Input Código vacío.',
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: false,
                });
            }
            else if(name == ''){
                  Swal.fire({
                    title: 'Error!',
                    text: 'Input Nombre vacío.',
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: false,
                });
            }
            else if (!pattern.test(codigo)) {
                  Swal.fire({
                        title: 'Error!',
                        text: 'Input "código" solo puede introducir letras y números, mínimo 3 caracteres.',
                        icon: 'error',
                        timer: 2000,
                        showConfirmButton: false,
                    });
                } 
            else if (!pattern.test(name)) {
                  Swal.fire({
                        title: 'Error!',
                        text: 'Input "nombre" solo puede introducir letras y números, mínimo 3 caracteres.',
                        icon: 'error',
                        timer: 2000,
                        showConfirmButton: false,
                    });
                } 
            else if (!pattern.test(description)) {
                  Swal.fire({
                            title: 'Error!',
                            text: 'Input "descripcción" solo puede introducir letras y números, mínimo 3 caracteres.',
                            icon: 'error',
                            timer: 2000,
                            showConfirmButton: false,
                        });
                }
                else{
                  loader1.classList.remove('hidden');
                  document.querySelector("#some-form").submit();                
                } 

              setTimeout(() => loader.style.display = 'none', 1000);
            // loader.classList.remove('hidden');
            // document.querySelector("#some-form").submit();
          }

          var formEdit = document.querySelector('#formEdit')
          function submitEditCod(){
            var loader1 = document.querySelector('#loader1')
            var codigoEdit = document.getElementById('codigoEdit').value
            var nameEdit = document.getElementById('nameEdit').value
            var descriptionEdit = document.getElementById('descriptionEdit').value
            var pattern = /^[\w ]*$/
            
            if(codigoEdit == '' && nameEdit == '' && descriptionEdit == ''){
              Swal.fire({
                    title: 'Error!',
                    text: 'Inputs vacíos.',
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: false,
                });
                
            }
            else if(codigoEdit == ''){
                  Swal.fire({
                    title: 'Error!',
                    text: 'Input Código vacío.',
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: false,
                });
            }
            else if(nameEdit == ''){
                  Swal.fire({
                    title: 'Error!',
                    text: 'Input Nombre vacío.',
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: false,
                });
            }
            else if (!pattern.test(nameEdit)) {
                  Swal.fire({
                        title: 'Error!',
                        text: 'Input "nombre" solo puede introducir letras y números, mínimo 3 caracteres.',
                        icon: 'error',
                        timer: 2000,
                        showConfirmButton: false,
                    });
                } 
            else if (!pattern.test(descriptionEdit)) {
                  Swal.fire({
                            title: 'Error!',
                            text: 'Input "descripcción" solo puede introducir letras y números, mínimo 3 caracteres.',
                            icon: 'error',
                            timer: 2000,
                            showConfirmButton: false,
                        });
                }
                else{
                  loader1.classList.remove('hidden');
                  document.querySelector("#formEdit").submit();           
                } 

            // loader.classList.remove('hidden');
            // document.querySelector("#some-form").submit();
          }

          
          
          formEdit.addEventListener('submit', function (event) {
            axios.post('codigoEdit', {
                      codigo: codigoEdit,
                      name: nameEdit,
                      description: descriptionEdit
                    })
                    .then(function (response) {
                            console.log(response)
                    })
                    .catch(function (error) {
                      if (error.status == 500){
                        Swal.fire({
                                  title: 'Error!',
                                  text: 'Comuniquese con el administrador.',
                                  icon: 'error',
                                  timer: 2000,
                                  showConfirmButton: false,
                              });
                      }
                      
                    });
                      // pretend the form has been sumitted and returned
            setTimeout(() => loader.style.display = 'none', 1000);
            // window.location.href = "{{ route('categories.index')}}"    
        });

          formCreate.addEventListener('submit', function (event) {
            
          console.log('que pasa')
                        // pretend the form has been sumitted and returned
              setTimeout(() => loader.style.display = 'none', 1000);
              // window.location.href = "{{ route('categories.index')}}"    
          });
        
        all_modals = ['main-modal', 'another-modal']
        all_modals.forEach((modal)=>{
            const modalSelected = document.querySelector('.'+modal);
            modalSelected.classList.remove('fadeIn');
            modalSelected.classList.add('fadeOut');
            modalSelected.style.display = 'none';
        })
        const modalClose = (modal) => {
            const modalToClose = document.querySelector('.'+modal);
            modalToClose.classList.remove('fadeIn');
            modalToClose.classList.add('fadeOut');
            setTimeout(() => {
                modalToClose.style.display = 'none';
            }, 500);
        }

        const openModal = (modal) => {
            const modalToOpen = document.querySelector('.'+modal);
            modalToOpen.classList.remove('fadeOut');
            modalToOpen.classList.add('fadeIn');
            modalToOpen.style.display = 'flex';
        }

        


        function showCodigoEdit(id, codigo, name, description){
          console.log(id, codigo, name, description, 'ddd')
        
            document.getElementById('codigoEdit').value = codigo
            document.getElementById('nameEdit').value = name
            document.getElementById('descriptionEdit').value = description
            document.getElementById('actualImage').innerHTML = 
            '<input class="hidden" id="idcod" name="idcod" type="text" value="'+id+'">' +
            '<input class="hidden" id="codigo1" name="codigo1" type="text" value="'+codigo+'">' +
            '<input class="hidden" id="name1" name="name1" type="text" value="'+name+'">' +
            '<input class="hidden" id="description1" name="description1" type="text" value="'+description+'">' 
          
        }

        

        function loaderEdit(){
          loader.classList.remove('hidden');
          setTimeout(() => loader.style.display = 'none', 1000);
        }

        function destroyCodigo(id) {
            Swal.fire({
              title: '¿Está seguro?',
                        text: "¡Esta desición no podrá ser revertida!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#7e3af2',
                        focusConfirm: true,
                        cancelButtonColor: '#999292',
                        reverseButtons: true,
                        confirmButtonText: '¡Si, estoy seguro, eliminar!',
                        focusConfirm:true
            })
            .then((result) => {
              if (result.isConfirmed) {
                    var loader1 = document.querySelector('#loader1')
                    loader1.classList.remove('hidden');

                    axios.post('codigoDel', {
                        id: id
                      })
                      .then(function (response) {
                        Swal.fire({
                                        title: '¡Eliminado!',
                                        text: 'Código eliminado correctamente.',
                                        icon: 'success',
                                        timer: 1000,
                                        showConfirmButton: false,
                                    });
                                    setTimeout(() => loader1.style.display = 'none', 1000);
                                    window.location.href = "{{ route('codigo.index')}}" 
                                    
                        
                      })
                      .catch(function (error) {
                        if (error.status == 500){
                          Swal.fire({
                                    title: 'Error!',
                                    text: 'Comuniquese con el administrador.',
                                    icon: 'error',
                                    timer: 2000,
                                    showConfirmButton: false,
                                });
                        }
                        
                      });
                     
                    
              }
            })
			}
        
      

        
              
	</script>

@endsection


