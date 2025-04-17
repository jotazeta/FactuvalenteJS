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
                  Clientes
                </h2>
                
            </div>
            <div class="flex items-center">
                <button
                  class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white 
                  transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 
                  hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                  onclick="openModal('create_client')"
                >
                  <i class="fa fa-plus-circle" aria-hidden="true"></i>
                </button>
            </div>
          </div>
            <!-- table categories -->
            @if($clientes->isEmpty())
              <div class="flex flex-row min-h-80 justify-center items-center">
                  <div class="flex items-center mr-2">
                      <p
                        class="my-6 font-semibold text-gray-700 dark:text-gray-200"
                      >
                        No tienes Clientes creados
                      </p>
                  </div>
                  <div class="flex items-center">
                      <button
                        class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white 
                        transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 
                        hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                        onclick="openModal('create_client')"
                      >
                        Crear Cliente
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
                      <th class="px-4 py-3 text-center">Correo</th>
                      <th class="px-4 py-3 text-center">Telefono</th>
                      <th class="px-4 py-3 text-center">Dirección</th>
                      <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                  </thead>
                  <tbody
                    class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                  >
                    @foreach($clientes as $data)
                      <tr class="text-gray-700 dark:text-gray-400">
                        
                        <td class="px-4 py-3 text-center">
                            @if($data->image == 'https://factuvalente.com/factuvalente/public/uploads/clientes' || $data->image == 'http://localhost/factuvalente/public/uploads/clientes')
                              <i class="fa fa-archive fa-3x" aria-hidden="true" ></i>
                            @else
                            <img src="{{ $data->image }}" width="70" height="30" style="margin-left: auto;margin-right: auto;">
                            @endif
                        </td>
                       
                        <td class="px-4 py-3 text-center">
                          {{ $data->name }}
                        </td>
                        <td class="px-4 py-3 text-center">
                          {{ $data->correo }}
                        </td>
                        <td class="px-4 py-3 text-center">
                          {{ $data->telefono }}
                        </td>
                        <td class="px-4 py-3 text-center">
                          {{ $data->direccion }}
                        </td>
                        <td class="px-4 py-3 text-center">
                          <div class="space-x-4 text-sm">
                            <button
                              class="justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                              aria-label="Edit"
                              onclick="openModal('edit_client'); showClientEdit('{{ $data->id }}', '{{ $data->image }}', '{{ $data->name }}', '{{ $data->telefono }}', '{{ $data->correo }}', '{{ $data->direccion }}')"
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
                              onclick="desactivarProducto('{{ $data->id }}', '{{ $data->active }}')"
                              aria-label="Desactivar"
                            >
                            @if($data->active !== 1)
                             
                              <svg
                                class="w-5 h-5"
                                aria-hidden="true"
                                fill="#514281"
                                viewBox="0 0 20 20"
                              >
                                <path d="M12 2C9.243 2 7 4.243 7 7v3H6a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8a2 2 0 0 0-2-2h-1V7c0-2.757-2.243-5-5-5zM9 7c0-1.654 1.346-3 3-3s3 1.346 3 3v3H9V7zm4 
                                      10.723V20h-2v-2.277a1.993 1.993 0 0 1 .567-3.677A2.001 2.001 0 0 1 14 16a1.99 1.99 0 0 1-1 1.723z">
                                </path>
                              </svg>
                            @else
                              <svg
                                class="w-5 h-5"
                                style="margin-top: -12px!important;"
                                aria-hidden="true"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                              >
                                <path d="M18 10H9V7c0-1.654 1.346-3 3-3s3 1.346 3 3h2c0-2.757-2.243-5-5-5S7 4.243 7 7v3H6a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8a2 2 0 0 0-2-2zm-7.939 
                                5.499A2.002 2.002 0 0 1 14 16a1.99 1.99 0 0 1-1 1.723V20h-2v-2.277a1.992 1.992 0 0 1-.939-2.224z">
                                </path>
                              </svg>
                            @endif
                            </button>
                            <button
                              class="justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                              onclick="destroyClient('{{ $data->id }}', '{{ $data->image }}')"
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
                {!! $clientes->links() !!}
                
                
              </div>
            </div>
            @endif


          <div class="create_client fixed w-full inset-0 z-50 overflow-hidden flex justify-center items-center animated fadeIn faster" style="background: rgba(0,0,0,.7);">
            <div class="border border-blue-500 shadow-lg modal-container bg-white mx-auto rounded-xl shadow-lg z-50 overflow-y-auto">
            <div class="modal-content py-4 text-left px-6 dark:bg-gray-800">
                <!--Title-->
                <div class="flex justify-between items-center pb-3 dark:bg-gray-800">
                <p class="text-2xl font-bold text-gray-500">Agregar Cliente</p>
                <div class="modal-close cursor-pointer z-50" onclick="modalClose('create_client')">
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
            
                    <form id="create_form" action="{{ route('createClient') }}" class="group" method="POST" enctype="multipart/form-data" novalidate>
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
                                    <p class="text-gray-500">Imagen del Cliente</p>
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
                    <div class="px-4 py-3 bg-white rounded-lg shadow-md dark:bg-gray-800 flex">
                        <div class="flex-row p-2">
                            <span
                                class="text-sm font-medium text-gray-600 dark:text-gray-400"
                            >
                                Nombre
                            </span>
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
                        <div class="flex-row p-2">
                            <span
                                class="text-sm font-medium text-gray-600 dark:text-gray-400"
                            >
                                Teléfono
                            </span>
                            <input
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                            focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                            form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer"
                            placeholder="introduzca teléfono"
                            id="telefono"
                            type="text" 
                            name="telefono"
                            required
                            pattern="[0-9a-zA-Z ]{3,}"
                            />
                            <span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">
                            Solo puede introducir letras y números, mínimo 3 caracteres.
                            </span>
                        </div>
                    </div>
                    <div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800 flex">
                        <div class="flex-row p-2">
                            <span
                                class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                            >
                                Correo
                            </span>
                            <input
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                            focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                            form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer"
                            placeholder="introduzca correo electrónico"
                            id="correo"
                            type="text" 
                            name="correo"
                            required
                            pattern=".{7,}"
                            />
                            <span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">
                            Solo puede introducir letras y números, mínimo 3 caracteres.
                            </span>
                        </div>
                        <div class="flex-row p-2">
                            <span
                            class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                            >
                                Dirección
                            </span>
                            <input
                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                                focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                                form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer"
                                required
                                type="text"
                                placeholder="introduzca dirección"
                                id="direccion"
                                name="direccion"
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
                    <div class="flex justify-end px-4 py-2 space-x-4 text-sm">
                        <button
                            class="px-4 py-2 text-sm font-medium leading-5 text-black 
                                transition-colors duration-150 bg-gray-100 border rounded-lg"
                            aria-label="Edit"
                            onclick="modalClose('create_client')"
                            >Cancelar
                        </button>
                        <button 
                            class="px-4 py-2 text-sm font-medium leading-5 text-white 
                                    transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg 
                                    active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple
                                    disabled"
                            onclick="submitAddClient()"
                            
                            >Agregar
                         </button>
                    </div>
                </div>
                
                <!--Footer-->
                <div class="flex justify-end pt-2 space-x-14 dark:bg-gray-800">
                
                
                </div>
            </div>
            </div>
          </div>

          <div class="edit_client fixed w-full inset-0 z-50 overflow-hidden flex justify-center items-center animated fadeIn faster" style="background: rgba(0,0,0,.7);">
            <div class="border border-blue-500 shadow-lg modal-container bg-white mx-auto rounded-xl shadow-lg z-50 overflow-y-auto dark:bg-gray-800">
              <div class="modal-content py-4 text-left px-6">
                <!--Title-->
                <div class="flex justify-between items-center pb-3">
                  <p class="text-2xl font-bold text-gray-500">Editar Cliente</p>
                  <div class="modal-close cursor-pointer z-50" onclick="modalClose('edit_client')">
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
                <form id="edit_form" action="{{ route('editClient') }}" class="group" method="POST" enctype="multipart/form-data" novalidate>
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
                       <div class="" id="actualImage">

                        </div>                    
                      <div class="px-4 py-3 bg-white rounded-lg shadow-md dark:bg-gray-800 flex">
                        <div class="flex-row p-2">
                            <span
                                class="text-sm font-medium text-gray-600 dark:text-gray-400"
                            >
                                Nombre
                            </span>
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
                        <div class="flex-row p-2">
                            <span
                                class="text-sm font-medium text-gray-600 dark:text-gray-400"
                            >
                                Teléfono
                            </span>
                            <input
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                            focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                            form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer"
                            placeholder="introduzca teléfono"
                            id="telefonoEdit"
                            type="text" 
                            name="telefonoEdit"
                            required
                            pattern="[0-9a-zA-Z ]{3,}"
                            />
                            <span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">
                            Solo puede introducir letras y números, mínimo 3 caracteres.
                            </span>
                        </div>
                    </div>
                    <div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800 flex">
                        <div class="flex-row p-2">
                            <span
                                class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                            >
                                Correo
                            </span>
                            <input
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                            focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                            form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer"
                            placeholder="introduzca correo electrónico"
                            id="correoEdit"
                            type="text" 
                            name="correoEdit"
                            required
                            pattern=".{7,}"
                            />
                            <span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">
                            Solo puede introducir letras y números, mínimo 3 caracteres.
                            </span>
                        </div>
                        <div class="flex-row p-2">
                            <span
                            class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                            >
                                Dirección
                            </span>
                            <input
                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                                focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                                form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer"
                                required
                                type="text"
                                placeholder="introduzca dirección"
                                id="direccionEdit"
                                name="direccionEdit"
                                type="text" 
                                pattern="[0-9a-zA-Z ]{3,}"
                                />
                            <span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">
                            Solo puede introducir letras y números, mínimo 3 caracteres.
                            </span>
                        </div>
                    </div>
                      <div class="flex justify-end px-4 py-2 space-x-4 text-sm">
                            <button
                              class="px-4 py-2 text-sm font-medium leading-5 text-white 
                                    transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 
                                    hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple hidden"
                              type="submit"
                            > Guardar
                            </button>
                        </div>
                    </form>
                    <div class="flex justify-end px-4 py-2 space-x-4 text-sm">
                        <button 
                            class="px-4 py-2 text-sm font-medium leading-5 modal-close dark:text-gray-400"
                            onclick="modalClose('edit_client')"
                            >Cancelar
                        </button>
                        <button 
                            class="px-4 py-2 text-sm font-medium leading-5 text-white 
                                        transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg 
                                        active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple
                                        disabled"
                            onclick="submitEditCliente()"
                            >Editar
                        </button>
                    </div>
                <!--Footer-->
                <div class="flex justify-end pt-2 space-x-14">
                  
                </div>
              </div>
            </div>
          </div>

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
          var formCreate = document.querySelector('#create_form');
        
          function desactivarProducto(id, activo) {
          if(activo == 1){
                Swal.fire({
                title: '¿Está seguro?',
                          icon: 'warning',
                          showCancelButton: true,
                          confirmButtonColor: '#7e3af2',
                          focusConfirm: true,
                          cancelButtonColor: '#999292',
                          reverseButtons: true,
                          confirmButtonText: '¡Si, estoy seguro, desactivar!',
                          focusConfirm:true
              })
              .then((result) => {
              if (result.isConfirmed) {
                    var loader1 = document.querySelector('#loader1')
                    loader1.classList.remove('hidden');

                    axios.post('desactivarCliente', {
                        id: id,
                        tipo: 1
                      })
                      .then(function (response) {
                        if(response.data == 'tiene relacion'){
                            Swal.fire({
                                  title: '¡Error!',
                                  text: 'Producto esta asociado a un combo creado, no puede ser desactivado.',
                                  icon: 'error',
                                  timer: 2000,
                                  showConfirmButton: false,
                                });
                                setTimeout(() => loader1.style.display = 'none', 2000);
                                return
                        }
                        if(response.data == 'si'){
                            Swal.fire({
                                title: 'Desactivado!',
                                text: 'Cliente desactivado correctamente.',
                                icon: 'success',
                                timer: 1000,
                                showConfirmButton: false,
                            });
                            setTimeout(() => loader1.style.display = 'none', 1000);
                            window.location.href = "{{ route('clientes.index')}}" 
                            return
                        }
                       console.log('no')
                                    
                        
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

          else{
                Swal.fire({
                title: '¿Está seguro?',
                          icon: 'warning',
                          showCancelButton: true,
                          confirmButtonColor: '#7e3af2',
                          focusConfirm: true,
                          cancelButtonColor: '#999292',
                          reverseButtons: true,
                          confirmButtonText: '¡Si, estoy seguro, activar!',
                          focusConfirm:true
              })
              .then((result) => {
              if (result.isConfirmed) {
                    var loader1 = document.querySelector('#loader1')
                    loader1.classList.remove('hidden');

                    axios.post('desactivarCliente', {
                        id: id,
                        tipo: 1
                      })
                      .then(function (response) {
                        if(response.data == 'tiene relacion'){
                            Swal.fire({
                                  title: '¡Error!',
                                  text: 'Producto esta asociado a un combo creado, no puede ser desactivado.',
                                  icon: 'error',
                                  timer: 2000,
                                  showConfirmButton: false,
                                });
                                setTimeout(() => loader1.style.display = 'none', 2000);
                                return
                        }
                        if(response.data == 'si'){
                            Swal.fire({
                                title: 'Activado!',
                                text: 'Cliente activado correctamente.',
                                icon: 'success',
                                timer: 1000,
                                showConfirmButton: false,
                            });
                            setTimeout(() => loader1.style.display = 'none', 1000);
                            window.location.href = "{{ route('clientes.index')}}" 
                            return
                        }
                       console.log('no')
                                    
                        
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
            
            
			}

          function submitAddClient(){
            var loader1 = document.querySelector('#loader1')
            var image = document.getElementById('image').value
            var name = document.getElementById('name').value
            var telefono = document.getElementById('telefono').value
            var correo = document.getElementById('correo').value
            var direccion = document.getElementById('direccion').value
            var pattern = /[0-9a-zA-Z ]{3,}/
            var patternCorreo = /.{7,}/
           
          if(name == ''){
                  Swal.fire({
                    title: 'Error!',
                    text: 'Input Nombre vacío.',
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: false,
                });
            }
            else if(telefono == ''){
                  Swal.fire({
                    title: 'Error!',
                    text: 'Input Telefono vacío.',
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: false,
                });
            }
            else if(correo == ''){
                  Swal.fire({
                    title: 'Error!',
                    text: 'Input Correo vacío.',
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: false,
                });
            }
            else if(direccion == ''){
                  Swal.fire({
                    title: 'Error!',
                    text: 'Input Dirección vacío.',
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
            else if (!pattern.test(telefono)) {
                  Swal.fire({
                        title: 'Error!',
                        text: 'Input "telefono" solo puede introducir letras y números, mínimo 3 caracteres.',
                        icon: 'error',
                        timer: 2000,
                        showConfirmButton: false,
                    });
                } 
            else if (!patternCorreo.test(correo)) {
                  Swal.fire({
                        title: 'Error!',
                        text: 'Input "correo" solo puede caracteres válidos.',
                        icon: 'error',
                        timer: 2000,
                        showConfirmButton: false,
                    });
                } 
            else if (!pattern.test(direccion)) {
                  Swal.fire({
                            title: 'Error!',
                            text: 'Input "direccion" solo puede introducir letras y números, mínimo 3 caracteres.',
                            icon: 'error',
                            timer: 2000,
                            showConfirmButton: false,
                        });
                }
                else{
                  loader1.classList.remove('hidden');
                  document.querySelector("#create_form").submit();                
                } 

              setTimeout(() => loader.style.display = 'none', 1000);
            // loader.classList.remove('hidden');
            // document.querySelector("#create_form").submit();
          }

          var edit_client = document.querySelector('#edit_client')
          function submitEditCliente(){
            var loader1 = document.querySelector('#loader1')
            var imageEdit = document.getElementById('imageEdit').value
            var nameEdit = document.getElementById('nameEdit').value
            var correoEdit = document.getElementById('correoEdit').value
            var telefonoEdit = document.getElementById('telefonoEdit').value
            var direccionEdit = document.getElementById('direccionEdit').value
            var pattern = /[0-9a-zA-Z ]{3,}/
            var patternCorreo = /.{7,}/
           
            if(nameEdit == ''){
                  Swal.fire({
                    title: 'Error!',
                    text: 'Input Nombre vacío.',
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: false,
                });
            }
            else if(correoEdit == ''){
                  Swal.fire({
                    title: 'Error!',
                    text: 'Input correo vacío.',
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: false,
                });
           
            }
            else if(telefonoEdit == ''){
                  Swal.fire({
                    title: 'Error!',
                    text: 'Input teléfono vacío.',
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: false,
                });
           
            }
            else if(direccionEdit == ''){
                  Swal.fire({
                    title: 'Error!',
                    text: 'Input dirección vacío.',
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
            else if (!patternCorreo.test(correoEdit)) {
                  Swal.fire({
                        title: 'Error!',
                        text: 'Input "correo" solo puede introducir letras y números, mínimo 3 caracteres.',
                        icon: 'error',
                        timer: 2000,
                        showConfirmButton: false,
                    });
                } 
            else if (!pattern.test(telefonoEdit)) {
                  Swal.fire({
                        title: 'Error!',
                        text: 'Input "teléfono" solo puede introducir letras y números, mínimo 3 caracteres.',
                        icon: 'error',
                        timer: 2000,
                        showConfirmButton: false,
                    });
                } 
            else if (!pattern.test(direccionEdit)) {
                  Swal.fire({
                            title: 'Error!',
                            text: 'Input "dirección" solo puede introducir letras y números, mínimo 3 caracteres.',
                            icon: 'error',
                            timer: 2000,
                            showConfirmButton: false,
                        });
                }
                else{
                  loader1.classList.remove('hidden');
                  document.querySelector("#edit_form").submit();           
                } 

            // loader.classList.remove('hidden');
            // document.querySelector("#create_form").submit();
          }

          
          
          edit_form.addEventListener('submit', function (event) {
            axios.post('editClient', {
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

          create_form.addEventListener('submit', function (event) {
            
              axios.post('createClient', {
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
        
        all_modals = ['create_client', 'edit_client']
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


        function showClientEdit(id, image, name, telefono, correo, direccion){
          if(image == 'https://factuvalente.com/factuvalente/public/uploads/clientes' || image == 'http://localhost/factuvalente/public/uploads/clientes'){
            document.getElementById('nameEdit').value = name
            document.getElementById('telefonoEdit').value = telefono
            document.getElementById('correoEdit').value = correo
            document.getElementById('direccionEdit').value = direccion
            document.getElementById('actualImage').innerHTML = 
            '<input class="hidden" id="idcat" name="idcat" type="text" value="'+id+'">' +
            '<input class="hidden" id="image1" name="image1" type="text" value="'+name+'">' +
            '<input class="hidden" id="telefono1" name="telefono1" type="text" value="'+telefono+'">' +
            '<input class="hidden" id="correo1" name="correo1" type="text" value="'+correo+'">' +
            '<input class="hidden" id="direccion1" name="direccion1" type="text" value="'+direccion+'">' 
            var output_image_edit = document.getElementById('output_image_edit')
            var inputImageEdit = document.getElementById('inputImageEdit')
            output_image_edit.classList.add("hidden")
            inputImageEdit.classList.remove("hidden")
          }else{
            document.getElementById('output_image_edit').src = image
            document.getElementById('nameEdit').value = name
            document.getElementById('telefonoEdit').value = telefono
            document.getElementById('correoEdit').value = correo
            document.getElementById('direccionEdit').value = direccion

            document.getElementById('actualImage').innerHTML = 
            '<input class="hidden" id="oldImgEdit" name="oldImgEdit" type="text" value="'+image+'">' +
            '<input class="hidden" id="idCliente" name="idCliente" type="text" value="'+id+'">' +
            '<input class="hidden" id="image1" name="image1" type="text" value="'+image+'">' +
            '<input class="hidden" id="name1" name="name1" type="text" value="'+name+'">' +
            '<input class="hidden" id="telefono1" name="telefono1" type="text" value="'+telefono+'">' +
            '<input class="hidden" id="correo1" name="correo1" type="text" value="'+correo+'">' +
            '<input class="hidden" id="direccion1" name="direccion1" type="text" value="'+direccion+'">'

            var output_image_edit = document.getElementById('output_image_edit')
            var inputImageEdit = document.getElementById('inputImageEdit')
            inputImageEdit.classList.add("hidden")
            output_image_edit.classList.remove("hidden")
          }
          
        }

        function loaderEdit(){
          loader.classList.remove('hidden');
          setTimeout(() => loader.style.display = 'none', 1000);
        }

        function destroyClient(id, image) {
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

                    axios.post('clientesDel', {
                        id: id,
                        image: image
                      })
                      .then(function (response) {
                        Swal.fire({
                                        title: '¡Eliminado!',
                                        text: 'Cliente eliminado correctamente.',
                                        icon: 'success',
                                        timer: 1000,
                                        showConfirmButton: false,
                                    });
                                    setTimeout(() => loader.style.display = 'none', 1000);
                                    window.location.href = "{{ route('clientes.index')}}" 
                                    
                        
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
@endsection