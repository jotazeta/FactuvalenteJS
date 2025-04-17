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
                  Categorías
                </h2>
                
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
            @if($categories->isEmpty())
              <div class="flex flex-row min-h-80 justify-center items-center">
                  <div class="flex items-center mr-2">
                      <p
                        class="my-6 font-semibold text-gray-700 dark:text-gray-200"
                      >
                        No tienes Categorías creadas
                      </p>
                  </div>
                  <div class="flex items-center">
                      <button
                        class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white 
                        transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 
                        hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                        onclick="openModal('main-modal')"
                      >
                        Crear Categoría
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
                      <th class="px-4 py-3 text-center">Imagen</th>
                      <th class="px-4 py-3 text-center">Nombre</th>
                      <th class="px-4 py-3 text-center">Descripción</th>
                      <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                  </thead>
                  <tbody
                    class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                  >
                    @foreach($categories as $data)
                      <tr class="text-gray-700 dark:text-gray-400">
                        
                        <td class="px-4 py-3 text-center">
                            @if($data->image == 'https://factuvalente.com/factuvalente/public/uploads/categories' || $data->image == 'http://localhost/factuvalente/public/uploads/categories')
                              <i class="fa fa-archive fa-3x" aria-hidden="true" ></i>
                            @else
                            <img src="{{ $data->image }}" width="70" height="30" style="margin-left: auto;margin-right: auto;">
                            @endif
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
                              onclick="openModal('another-modal'); showCategoryEdit('{{ $data->id }}', '{{ $data->image }}', '{{ $data->name }}', '{{ $data->description }}')"
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
                              onclick="destroyCategory('{{ $data->id }}', '{{ $data->image }}')"
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
                {!! $categories->links() !!}
                
                
              </div>
            </div>
            @endif
           


          <div class="main-modal fixed w-full inset-0 z-50 overflow-hidden flex justify-center items-center animated fadeIn faster" style="background: rgba(0,0,0,.7);">
            <div class="border border-blue-500 shadow-lg modal-container bg-white mx-auto rounded-xl shadow-lg z-50 overflow-y-auto">
              <div class="modal-content py-4 text-left px-6 dark:bg-gray-800">
                <!--Title-->
                <div class="flex justify-between items-center pb-3 dark:bg-gray-800">
                  <p class="text-2xl font-bold text-gray-500">Agregar Categoría</p>
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
               
                    <form id="some-form" action="{{ route('categoriesCreate') }}" class="group" method="POST" enctype="multipart/form-data" novalidate>
                          @csrf
                      <div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">
                        
                        <div class="flex items-center justify-center">
                            <div class="image-container rounded-lg">
                              <label for="image">
                                <img id="output_image" class="hidden cursor-pointer image-size"\>
                                <div id="inputImage" class="flex w-full h-full flex-col justify-center items-center cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="tabler-icon tabler-icon-tag s-icon medium     icon-secondary icon x4 mb-2 pointer ">
                                    <path d="M7.5 7.5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0">
                                    </path>
                                    <path d="M3 6v5.172a2 2 0 0 0 .586 1.414l7.71 7.71a2.41 2.41 0 0 0 3.408 0l5.592 -5.592a2.41 2.41 0 0 0 0 -3.408l-7.71 -7.71a2 2 0 0 0 -1.414 -.586h-5.172a3 3 0 0 0 -3 3z">
                                    </path>
                                    </svg>
                                    <p class="text-gray-500">Imagen de la Categoría</p>
                                </div>
                              </label>
                                <input 
                                      onchange="preview_image(event)"
                                      id="image" name="image"
                                      type="file" class="w-full h-full hidden" 
                                      accept=".jpg, .png, .jpeg" value="">
                            </div>
                        </div>
                      </div>                    
                      <div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">
                        <div>
                          <p
                            class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                          >
                            Nombre
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
                                onclick="submitAddCat()"
                                
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
                  <p class="text-2xl font-bold text-gray-500">Editar Categoría</p>
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
                <form id="formEdit" action="{{ route('categoriesEdit') }}" class="group" method="POST" enctype="multipart/form-data" novalidate>
                          @csrf
                      <div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">
                        
                        <div class="flex items-center justify-center">
                            <div class="image-container rounded-lg">
                              <label for="imageEdit">
                                <img id="output_image_edit" class="hidden cursor-pointer image-size"\>
                                <div id="inputImageEdit" class="flex w-full h-full flex-col justify-center items-center cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="tabler-icon tabler-icon-tag s-icon medium     icon-secondary icon x4 mb-2 pointer ">
                                    <path d="M7.5 7.5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0">
                                    </path>
                                    <path d="M3 6v5.172a2 2 0 0 0 .586 1.414l7.71 7.71a2.41 2.41 0 0 0 3.408 0l5.592 -5.592a2.41 2.41 0 0 0 0 -3.408l-7.71 -7.71a2 2 0 0 0 -1.414 -.586h-5.172a3 3 0 0 0 -3 3z">
                                    </path>
                                    </svg>
                                    <p class="text-gray-500">Imagen de la Categoría</p>
                                </div>
                              </label>
                                <input 
                                      onchange="preview_image_edit(event)"
                                      id="imageEdit" name="imageEdit"
                                      type="file" class="w-full h-full hidden" 
                                      accept=".jpg, .png, .jpeg" value="">
                            </div>
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
                                required
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
                          <div>
                            <button 
                                class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white 
                                          transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg 
                                          active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple
                                          disabled"
                                onclick="submitEditCat()"
                                >Editar
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

          function submitAddCat(){
            var loader1 = document.querySelector('#loader1')
            var image = document.getElementById('image').value
            var name = document.getElementById('name').value
            var description = document.getElementById('description').value
            var pattern = /[0-9a-zA-Z ]{3,}/
           
            if(name == '' && description == ''){
              Swal.fire({
                    title: 'Error!',
                    text: 'Inputs vacíos.',
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
            else if(description == ''){
                  Swal.fire({
                    title: 'Error!',
                    text: 'Input descripcción vacío.',
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
          function submitEditCat(){
            var loader1 = document.querySelector('#loader1')
            var imageEdit = document.getElementById('imageEdit').value
            var nameEdit = document.getElementById('nameEdit').value
            var descriptionEdit = document.getElementById('descriptionEdit').value
            var pattern = /[0-9a-zA-Z ]{3,}/
            
            if(nameEdit == '' && descriptionEdit == ''){
              Swal.fire({
                    title: 'Error!',
                    text: 'Inputs vacíos.',
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
            else if(descriptionEdit == ''){
                  Swal.fire({
                    title: 'Error!',
                    text: 'Input descripcción vacío.',
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
            axios.post('categoriesEdit', {
                      image: imageEdit,
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
            
              axios.post('categoriesCreate', {
                        image: image,
                        name: name,
                        description: description
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

        
            window.datas = 0
        function preview_image(event) {
            var reader = new FileReader(); //create a reader
            reader.onload = function(){ // set a handler what to do when done loading
            var output = document.getElementById('output_image'); // get the node
            var inputImage = document.getElementById('inputImage'); // get the node
            var imageFile = event.target.files[0]
            window.datas = imageFile
            output.classList.remove("hidden");
            output.classList.add("block");
            inputImage.classList.add("hidden");
            output.src = reader.result;
             // set the result of the reader as the src of the node
          }
          reader.readAsDataURL(event.target.files[0]); // now start the reader
        }

        function preview_image_edit(event) {
            var reader = new FileReader(); //create a reader
            reader.onload = function(){ // set a handler what to do when done loading
            var output = document.getElementById('output_image_edit'); // get the node
            var inputImageEdit = document.getElementById('inputImageEdit'); // get the node
            var imageFile = event.target.files[0]
            window.datas = imageFile
            output.classList.remove("hidden")
            inputImageEdit.classList.add("hidden")
            console.log(output, 'que jueee')
            output.src = reader.result;
             // set the result of the reader as the src of the node
          }
          reader.readAsDataURL(event.target.files[0]); // now start the reader
        }

        function preview_image_edit1(event) {
            var reader = new FileReader(); //create a reader
            reader.onload = function(){ // set a handler what to do when done loading
            var output = document.getElementById('output_image_edit'); // get the node
            var inputImageEdit = document.getElementById('inputImageEdit'); // get the node
            var imageFile = event.target.files[0]
            window.datas = imageFile
            
            console.log(output, 'que jueee')
            output.src = reader.result;
             // set the result of the reader as the src of the node
          }
          reader.readAsDataURL(event.target.files[0]); // now start the reader
        }


        function showCategoryEdit(id, image, name, description){
          console.log(id, image, name, description, 'ddd')
          if(image == 'https://factuvalente.com/factuvalente/public/uploads/categories' || image == 'http://localhost/factuvalente/public/uploads/categories'){
            document.getElementById('nameEdit').value = name
            document.getElementById('descriptionEdit').value = description
            document.getElementById('actualImage').innerHTML = 
            '<input class="hidden" id="name1" name="idcat" type="text" value="'+id+'">' +
            '<input class="hidden" id="name1" name="image1" type="text" value="'+name+'">' +
            '<input class="hidden" id="name1" name="name1" type="text" value="'+name+'">' +
            '<input class="hidden" id="description1" name="description1" type="text" value="'+description+'">' 
            var output_image_edit = document.getElementById('output_image_edit')
            var inputImageEdit = document.getElementById('inputImageEdit')
            output_image_edit.classList.add("hidden")
            inputImageEdit.classList.remove("hidden")
          }else{
            document.getElementById('output_image_edit').src = image
            document.getElementById('nameEdit').value = name
            document.getElementById('descriptionEdit').value = description
            document.getElementById('actualImage').innerHTML = 
            '<input class="hidden" id="oldImgEdit" name="oldImgEdit" type="text" value="'+image+'">' +
            '<input class="hidden" id="name1" name="idcat" type="text" value="'+id+'">' +
            '<input class="hidden" id="name1" name="image1" type="text" value="'+name+'">' +
            '<input class="hidden" id="name1" name="name1" type="text" value="'+name+'">' +
            '<input class="hidden" id="description1" name="description1" type="text" value="'+description+'">' 
            var output_image_edit = document.getElementById('output_image_edit')
            var inputImageEdit = document.getElementById('inputImageEdit')
            inputImageEdit.classList.add("hidden")
            output_image_edit.classList.remove("hidden")
          }
          
        }

        function showCategory(id, image, name, description ){
          if(image == 'https://factuvalente.com/factuvalente/public/uploads/categories'){
            console.log('no tiene foto')
            document.getElementById('bodyEdit').innerHTML = 
            '<form id="formEdit" action="{{ route('categoriesEdit') }}" class="group" method="POST" enctype="multipart/form-data" novalidate>' +
                          '@csrf' +
                      '<div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">' +
                        '<div class="flex items-center justify-center">' +
                            '<div class="image-container rounded-lg">' +
                              '<label for="image1">' +
                                '<img id="output_image_edit" class="hidden cursor-pointer image-size"\>' +
                                '<div id="inputImageEdit" class="flex w-full h-full flex-col justify-center items-center cursor-pointer">' +
                                    '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="tabler-icon tabler-icon-tag s-icon medium     icon-secondary icon x4 mb-2 pointer ">' +
                                    '<path d="M7.5 7.5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0">' +
                                    '</path>' +
                                    '<path d="M3 6v5.172a2 2 0 0 0 .586 1.414l7.71 7.71a2.41 2.41 0 0 0 3.408 0l5.592 -5.592a2.41 2.41 0 0 0 0 -3.408l-7.71 -7.71a2 2 0 0 0 -1.414 -.586h-5.172a3 3 0 0 0 -3 3z">' +
                                    '</path>' +
                                    '</svg>' +
                                    '<p class="text-gray-500">Imagen de la Categoría</p>' +
                                '</div>' +
                              '</label>' +
                                '<input onchange="preview_image(event)" id="image1" name="image" type="file" class="w-full h-full hidden" accept=".jpg, .png, .jpeg" value="">' +
                            '</div>' +
                        '</div>' +
                      '</div>' +                    
                      '<div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">' +
                        '<div>' +
                          '<p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">' +
                          'Nombre</p>' +
                          '<input value="'+image+'" class="hidden" id="oldImg" name="oldImg" type="file">' +
                           '<input value="'+name+'" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer" placeholder="introduzca nombre" id="name" type="text" name="name" required pattern="[0-9a-zA-Z ]{3,}"/>' +
                            '<span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">' +
                            'Solo puede introducir letras y números, mínimo 3 caracteres.</span>' +
                        '</div>' +
                      '</div>' +
                    '<div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">' +
                        '<div>' +
                            '<p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">' +
                            'Descripción</p>' +
                            '<input value="'+description+'"class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer"required type="text" placeholder="introduzca descripción" id="description" name="description" type="text" pattern="[0-9a-zA-Z ]{3,}"/>' +
                            '<span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">' +
                            'Solo puede introducir letras y números, mínimo 3 caracteres.</span>' +
                          '</div>' +
                      '</div>' +
                      '<div class="flex items-center px-4 py-2 space-x-4 text-sm">' +
                            '<button class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple hidden"type="submit">' +
                            'Guardar</button>' +
                        '</div>' +
                    '</form>' +
                      '<div class="flex items-center px-4 py-2 space-x-4 text-sm">' +
                        '<button class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-black transition-colors duration-150 bg-gray-100 border rounded-lg" aria-label="Edit" onclick="modalClose(\'another-modal\')">' +
                        'Cancelar</button>' +
                          '<div>' +
                            '<button class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple" onclick="submitEditCat(document.getElementById(\`description\`).value)">' +
                            'Agregar</button>' +
                          '</div>' +
                      '</div>'
                 
          }
          else{
            console.log('si tiene foto')
            document.getElementById('bodyEdit').innerHTML = 
              '<form action="{{ route('categoriesEdit') }}" class="group" novalidate method="POST" enctype="multipart/form-data">' + 
              '@csrf' +
              '<div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">' + 
              '<div class="flex items-center justify-center">' + 
              '<div class="image-container rounded-lg">' + 
              '<label for="image1">' + 
              '<div id="inputImageEdit" class="flex w-full h-full flex-col justify-center items-center cursor-pointer">' + 
              '<img id="output_image_edit" src="'+image+'" class="cursor-pointer image-size"\>' + 
              '</div>' + 
              '</label>' + 
              '<input onchange="preview_image_edit1(event)" id="image1" name="image" type="file" class="w-full h-ful hidden" accept=".jpg, .png, .jpeg" value="">' + 
              '</div>' + 
              '</div>' + 
              '</div>' + 
              '<div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">'+
              '<div>'+
              '<p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">'+
              'Nombre</p>'+
              '<input class="hidden" id="idcat" value="'+id+'" name="idcat" type="text" />' +
              '<input value="'+name+'" class="invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="introduzca nombre" id="name" type="text" name="name" required pattern="[0-9a-zA-Z ]{3,}"/>'+
              '<input value="'+name+'" class="hidden" id="name1" name="name1" type="text" />'+
              '<span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">Solo puede introducir letras y números, mínimo 3 caracteres.</span>' +
              '</div>'+
              '</div>'+
              '<div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">'+
              '<div>'+
              '<p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">'+
              'Descripción</p>'+
              '<input value="'+description+'" class="invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="introduzca descripción" id="description" name="description" type="text" required pattern="[0-9a-zA-Z ]{3,}"/>'+
              '<input value="'+description+'" class="hidden" id="description1" name="description1" type="text" />'+
              '<span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">Solo puede introducir letras y números, mínimo 3 caracteres.</span>' +
              '</div>'+
              '</div>'+
              '<div class="flex items-center px-4 py-2 space-x-4 text-sm">'+
              '<div class="">'+
              '<button type="button" class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-black transition-colors duration-150 bg-gray-100 border rounded-lg" onclick="modalClose(\'another-modal\')">' +
              'Cancelar</button>'+
              '</div>'+
              '<div class="">'+
              '<button type="submit" onclick="loaderEdit()" class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">' +
              'Submit</button>'+
              '</div>'+
              '</div>'+
              '</form>'
          }
          
        }

        function loaderEdit(){
          loader.classList.remove('hidden');
          setTimeout(() => loader.style.display = 'none', 1000);
        }

        function destroyCategory(id, image) {
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
                    var loader = document.querySelector('#loader')
                    loader.classList.remove('hidden');

                    axios.post('categoriesDel', {
                        id: id,
                        image: image
                      })
                      .then(function (response) {
                        Swal.fire({
                                        title: '¡Eliminada!',
                                        text: 'Categoría eliminada correctamente.',
                                        icon: 'success',
                                        timer: 1000,
                                        showConfirmButton: false,
                                    });
                                    setTimeout(() => loader.style.display = 'none', 1000);
                                    window.location.href = "{{ route('categories.index')}}" 
                                    
                        
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


