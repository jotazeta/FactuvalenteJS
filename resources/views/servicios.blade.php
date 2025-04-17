@extends('layouts.layoutDash')

@section('content')
<div class="loading" id="loader"></div>
<div class="loading hidden" id="loader1"></div>
<div class="container grid px-6 mx-auto" id="bodyTableProducts">
          <div class="flow-root p-4">  
              <div class="float-left">
                  <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200 hidden"
                      id="titleProductos">
                    Productos
                  </h2>
                  <a href="servicios">
                    <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200"
                      id="titleServicios">
                    Servicios
                    </h2>
                  </a>
                  <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200 hidden"
                      id="titleCombos">*
                    Combos
                  </h2>
              </div>
              <div class="ml-2 float-left">
              <button
                  class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white 
                  transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 
                  hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                  onclick="openModal('addProduct')"
                >
                  <i class="fa fa-plus-circle " aria-hidden="true"></i>
                </button>
              </div> 
             
              <div id="searchFilter" class="float-right searchFilter w-full grid grid-cols-2">
                  
                  <input 
                    type="text" 
                    id="searchQ" 
                    name="searchQ" 
                    class="hidden text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                          focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                          form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer"
                    placeholder="Nombre / Barcode"
                  >
                  <button
                    class="hidden px-4 py-2 text-sm font-medium leading-5 text-white 
                    transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 
                    hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                    id="buttonSearchNombre"
                    onclick="doitSearch()"
                  >
                  Buscar
                </button>
                  
              </div>
              
              <div class="float-right cursor-pointer" onclick="OpenSearchFilter()" id="OpenSearchFilter">
                <i class="fa fa-search text-purple-600"></i>
              </div>
          </div>
            <!-- table products -->
            @if($servicios->isEmpty())
              <div class="flex flex-row min-h-80 justify-center items-center">
                  <div class="flex items-center mr-2">
                      <p
                        class="my-6 font-semibold text-gray-700 dark:text-gray-200"
                      >
                        No tienes Productos creados
                      </p>
                  </div>
                  <div class="flex items-center">
                      <button
                        class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white 
                        transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 
                        hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                        onclick="openModal('addProduct')"
                      >
                        Crear Producto
                      </button>
                  </div>
              </div>
            @else
            <div class="w-full overflow-hidden rounded-lg shadow-xs" id="productosCreados">
              <div class="w-full overflow-x-auto">
              <div class="hidden flex filtroCategoria mb-2" id="filtroCategoria"></div>
              <table class="w-full whitespace-no-wrap">
                  <thead>
                    <tr
                      class="text-xs font-semibold tracking-wide text-left text-white text-gray-500 uppercase border-b dark:border-gray-700 bg-purple-600 dark:text-gray-400 dark:bg-gray-800"
                    >
                      <th class="px-4 py-3 mt-2 text-center" id="thBarcode" style="">BARCODE</th>
                      <th class="px-4 py-3 text-center">Nombre</th>
                      <th class="px-4 py-3 text-center">Precio</th>
                      <th class="px-4 py-3 text-center">Stock</th>
                      <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                  </thead>
                  <tbody
                    class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800 [&>*:nth-child(odd)]:bg-white-200 [&>*:nth-child(even)]:bg-neutral-200"
                  >
                    @foreach($servicios as $data)
                      <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-2 py-px flex justify-center items-center" id="jsbarcode">
                            <svg class="barcode max-h-24 max-w-24" jsbarcode-value="{{ $data->barcode }}" 
                              jsbarcode-textmargin="0" jsbarcode-fontoptions="bold" jsbarcode-linecolor="#9333ea">
                            </svg>
                        </td>
                        <td class="px-2 py-px text-center">
                          {{ $data->title }}
                        </td>
                        <td class="px-2 py-px text-center">
                          {{ $data->sell_price }}
                        </td>
                        <td class="px-2 py-px text-center">
                          {{ $data->stock }}
                        </td>
                        <td class="px-2 py-px text-center">
                          <div class="space-x-4 text-sm">
                            <button
                              class="justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                              aria-label="Edit"
                              onclick="openModal('editProduct'); showProductEdit('{{ $data->id }}', '{{ $data->category_id }}', '{{ $data->image }}', '{{ $data->barcode }}', '{{ $data->title }}', '{{ $data->description }}', '{{ $data->buy_price }}', '{{ $data->sell_price }}', '{{ $data->stock }}', '{{ $data->impuesto }}', '{{ $data->unit }}', '{{ $data->tipo }}', '{{ $data->precio_base }}', '{{ $data->minimo }}', '{{ $data->maximo }}', '{{ $data->venta_negativo }}', '{{ $data->codigo_unspsc }}')"
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
                              onclick="desactivarProducto('{{ $data->id }}', '{{ $data->activo }}')"
                              aria-label="Desactivar"
                            >
                            @if($data->activo !== 1)
                             
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
                              onclick="destroyServicio('{{ $data->id }}', '{{ $data->image }}')"
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
                {!! $servicios->links() !!}
                
                
              </div>
            </div>

            @endif
            
          <!-- init create product modal -->
          <div class="addProduct fixed w-full inset-0 z-50 flex justify-center items-center animated fadeIn faster" style="background: rgba(0,0,0,.7);">
              <div class="border border-blue-500 shadow-lg modal-container bg-white mx-auto rounded-xl shadow-lg z-50">
              <div class="modal-content py-4 text-left px-6 dark:bg-gray-800">
              <!--Body-->
              <div class="container px-6 mx-auto grid">
                  <form id="addProductform" action="{{ route('productosCreate') }}" class="group" method="POST" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div x-data="{ selectedAccordionItem: 'one' }" class="w-full divide-y divide-outline overflow-hidden rounded-sm" id="simple_form">
                              <div class="flex justify-between">
                                  <p class="text-xl font-bold text-gray-500 p-2 mb-3 hidden" id="simple_title">Formulario Básico de Productos</p>
                                  <p class="text-xl font-bold text-gray-500 p-2 mb-3" id="servicio_basic_title">Formulario Básico de Servicios</p>
                                  <p class="text-xl font-bold text-gray-500 p-2 mb-3 hidden" id="combo_basic_title">Formulario Básico de Combos</p>
                                  <div class="modal-close cursor-pointer z-50 flex flex-row" onclick="modalClose('addProduct')">
                                    <svg class="fill-current text-gray-500" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 18 18">
                                        <path
                                          d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
                                        </path>
                                    </svg>
                                  </div>
                              </div>
                              
                              <div>
                                  <button id="controlsAccordionItemOne" type="button" class="text-sm rounded-lg shadow-md flex w-full items-center justify-between gap-4 p-4 text-left border border-transparent rounded-lg 
                                            active:bg-purple-200 focus:outline-none focus:shadow-outline-purple  dark:text-gray-600" aria-controls="accordionItemOne" x-on:click="selectedAccordionItem = 'one'" 
                                  x-bind:class="selectedAccordionItem === 'one' ? 'text-on-surface-strong dark:text-on-surface-dark-strong font-bold text-purple-600'  : 'text-on-surface dark:text-on-surface-dark font-medium dark:text-gray-300'" x-bind:aria-expanded="selectedAccordionItem === 'one' ? 'true' : 'false'">
                                      Tipo*
                                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke="currentColor" class="size-5 shrink-0 transition" aria-hidden="true" x-bind:class="selectedAccordionItem === 'one'  ?  'rotate-180'  :  ''">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                      </svg>
                                  </button>
                                  <div x-cloak x-show="selectedAccordionItem === 'one'" id="accordionItemOne" role="region" aria-labelledby="controlsAccordionItemOne" x-collapse>
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4">
                                            <!-- Producto -->
                                            <label id="productoTipoLabel" onclick="selectProducto()" class="cursor-pointer relative flex items-center gap-4 rounded-radius bg-surface-alt p-2 hover:scale-105 transition-transform text-on-surface dark:text-on-surface-dark dark:bg-surface-dark-alt has-checked:border-primary has-checked:bg-primary/5 has-checked:text-on-surface-strong has-checked:border has-focus:outline-2 has-focus:outline-offset-2 has-focus:outline-primary dark:has-checked:border-primary-dark dark:has-checked:text-on-surface-dark-strong dark:has-checked:bg-primary-dark/5 dark:has-focus:outline-primary-dark border border-outline dark:border-outline-dark">
                                                <input type="radio" id="tipo_producto" aria-describedby="producto" class="sr-only peer" name="tipo" value="producto">
                                                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" viewBox="0 0 16 16" fill="#9333ea" class="dark:text-gray-300 peer-checked:visible invisible w-5 h-5 shrink-0">
                                                    <path fill-rule="evenodd" d="M12.416 3.376a.75.75 0 0 1 .208 1.04l-5 7.5a.75.75 0 0 1-1.154.114l-3-3a.75.75 0 0 1 1.06-1.06l2.353 2.353 4.493-6.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd">
                                                </svg>
                                                <box-icon type='logo' name='product-hunt' class="dark:text-gray-300"></box-icon>
                                                <div class="flex flex-col">
                                                    <h3 class="font-medium dark:text-gray-300" aria-hidden="true">Producto</h3>
                                                </div>
                                            </label>
                                            <!-- Servicio -->
                                            <label id="servicioTipoLabel" onclick="selectServicio()" class="cursor-pointer relative flex items-center gap-4 rounded-radius bg-surface-alt p-2 hover:scale-105 transition-transform text-on-surface dark:text-on-surface-dark dark:bg-surface-dark-alt has-checked:border-primary has-checked:bg-primary/5 has-checked:text-on-surface-strong has-checked:border has-focus:outline-2 has-focus:outline-offset-2 has-focus:outline-primary dark:has-checked:border-primary-dark dark:has-checked:text-on-surface-dark-strong dark:has-checked:bg-primary-dark/5 dark:has-focus:outline-primary-dark border border-outline dark:border-outline-dark">
                                                <input type="radio" id="tipo_servicio" aria-describedby="servicio" class="sr-only peer" name="tipo" value="servicio" checked>
                                                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" viewBox="0 0 16 16" fill="#9333ea" class="dark:text-gray-300 peer-checked:visible invisible w-5 h-5 shrink-0">
                                                    <path fill-rule="evenodd" d="M12.416 3.376a.75.75 0 0 1 .208 1.04l-5 7.5a.75.75 0 0 1-1.154.114l-3-3a.75.75 0 0 1 1.06-1.06l2.353 2.353 4.493-6.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd">
                                                </svg>
                                                <box-icon name='hard-hat' class="dark:text-gray-300"></box-icon>
                                                <div class="flex flex-col">
                                                    <h3 class="font-medium dark:text-gray-300" aria-hidden="true">Servicio</h3>
                                                </div>
                                            </label>
                                            <!-- Combo -->
                                            <label id="combooTipoLabel" onclick="selectCombo()" class="cursor-pointer relative flex items-center gap-4 rounded-radius bg-surface-alt p-2 hover:scale-105 transition-transform text-on-surface dark:text-on-surface-dark dark:bg-surface-dark-alt has-checked:border-primary has-checked:bg-primary/5 has-checked:text-on-surface-strong has-checked:border has-focus:outline-2 has-focus:outline-offset-2 has-focus:outline-primary dark:has-checked:border-primary-dark dark:has-checked:text-on-surface-dark-strong dark:has-checked:bg-primary-dark/5 dark:has-focus:outline-primary-dark border border-outline dark:border-outline-dark">
                                                <input type="radio" id="tipo_combo" aria-describedby="combo" class="sr-only peer" name="tipo" value="combo">
                                                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" viewBox="0 0 16 16" fill="#9333ea" class="dark:text-gray-300 peer-checked:visible invisible w-5 h-5 shrink-0">
                                                    <path fill-rule="evenodd" d="M12.416 3.376a.75.75 0 0 1 .208 1.04l-5 7.5a.75.75 0 0 1-1.154.114l-3-3a.75.75 0 0 1 1.06-1.06l2.353 2.353 4.493-6.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd">
                                                </svg>
                                                <box-icon name='unite' class="dark:text-gray-300"></box-icon>
                                                <div class="flex flex-col">
                                                    <h3 class="font-medium dark:text-gray-300" aria-hidden="true">Combo</h3>
                                                </div>
                                            </label>
                                        </div>
                                  </div>
                              </div>
                              <div>
                                  <button id="controlsAccordionItemTwo" type="button" class="text-sm rounded-lg shadow-md flex w-full items-center justify-between gap-4 p-4 text-left border border-transparent rounded-lg 
                                            active:bg-purple-200 focus:outline-none focus:shadow-outline-purple" aria-controls="accordionItemTwo" x-on:click="selectedAccordionItem = 'two'" 
                                  x-bind:class="selectedAccordionItem === 'two' ? 'text-on-surface-strong dark:text-on-surface-dark-strong font-bold text-purple-600'  : 'text-on-surface dark:text-on-surface-dark font-medium dark:text-gray-300'" x-bind:aria-expanded="selectedAccordionItem === 'two' ? 'true' : 'false'">
                                          <span class="" id="barcodeSpan"> Nombre* / Unidad* </span><span class="hidden" id="barcode2Span"> Nombre* / Unidad* / BARCODE*</span>
                                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke="currentColor" class="size-5 shrink-0 transition" aria-hidden="true" x-bind:class="selectedAccordionItem === 'two'  ?  'rotate-180'  :  ''">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                      </svg>
                                  </button>
                                  <div x-cloak x-show="selectedAccordionItem === 'two'" id="accordionItemTwo" role="region" aria-labelledby="controlsAccordionItemTwo" x-collapse>
                                      <div id="divNombreUnidad" class="p-2 text-sm sm:text-base text-pretty grid grid-cols-1 md:grid-cols-3">
                                          <div class="text-sm p-2 w-full">
                                              <span class="text-gray-700 dark:text-gray-400">
                                                  Nombre*
                                              </span>
                                              <input
                                              class="w-full text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                                              focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                                              form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer"
                                              placeholder="introduzca nombre"
                                              id="title"
                                              type="text" 
                                              name="title"
                                              pattern="[0-9a-zA-Z ]{3,}"
                                                  
                                              />
                                            <span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">
                                              Solo puede introducir letras y números, mínimo 3 caracteres.
                                            </span>       
                                          </div>

                                          <div class="text-sm p-2 w-full">
                                              <div x-data="combobox({
                                                      allOptions: [
                                                          { 
                                                              label: 'Unidad', 
                                                              value: 'Unidad' 
                                                          },
                                                          { 
                                                              label: 'Servicio', 
                                                              value: 'Servicio' 
                                                          },
                                                          { 
                                                              label: 'Pieza',
                                                              value: 'Pieza' 
                                                          },
                                                          { 
                                                              label: 'Millar',
                                                              value: 'Millar' 
                                                          },
                                                          { 
                                                              label: 'Par',
                                                              value: 'Par' 
                                                          },
                                                          { 
                                                              label: 'Numero de pares',
                                                              value: 'Numero de pares' 
                                                          },
                                                          { 
                                                              label: 'Metro',
                                                              value: 'Metro' 
                                                          },
                                                          { 
                                                              label: 'Pulgada',
                                                              value: 'Pulgada' 
                                                          },
                                                          { 
                                                              label: 'Centímetro cuadrado',
                                                              value: 'Centímetro cuadrado' 
                                                          },
                                                          { 
                                                              label: 'Pulgada cuadrada',
                                                              value: 'Pulgada cuadrada' 
                                                          },
                                                          { 
                                                              label: 'Metro cuadrado',
                                                              value: 'Metro cuadrado' 
                                                          },
                                                          { 
                                                              label: 'Mililitro',
                                                              value: 'Mililitro' 
                                                          },
                                                          { 
                                                              label: 'Litro',
                                                              value: 'Litro' 
                                                          },
                                                          { 
                                                              label: 'Galón',
                                                              value: 'Galón' 
                                                          },
                                                          { 
                                                              label: 'Gramo',
                                                              value: 'Gramo' 
                                                          },
                                                          { 
                                                              label: 'Kilogramo',
                                                              value: 'Kilogramo' 
                                                          },
                                                          { 
                                                              label: 'Tonelada',
                                                              value: 'Tonelada' 
                                                          },
                                                          { 
                                                              label: 'Libra',
                                                              value: 'Libra' 
                                                          },
                                                          { 
                                                              label: 'Administración',
                                                              value: 'Administración' 
                                                          },
                                                          { 
                                                              label: 'Metro cúbico',
                                                              value: 'Metro cúbico' 
                                                          },
                                                          { 
                                                              label: 'Metro cúbico (neto)',
                                                              value: 'Metro cúbico (neto)' 
                                                          },
                                                          { 
                                                              label: 'Hora',
                                                              value: 'Hora' 
                                                          },
                                                          { 
                                                              label: 'Minuto',
                                                              value: 'Minuto' 
                                                          },
                                                          { 
                                                              label: 'Día',
                                                              value: 'Día' 
                                                          },
                                                          { 
                                                              label: 'Ampolla',
                                                              value: 'Ampolla' 
                                                          },
                                                          { 
                                                              label: 'Hectárea',
                                                              value: 'Hectárea' 
                                                          },
                                                          { 
                                                              label: 'Frasco',
                                                              value: 'Frasco' 
                                                          },
                                                          { 
                                                              label: 'Paquete',
                                                              value: 'Paquete' 
                                                          },
                                                          { 
                                                              label: 'Sobre',
                                                              value: 'Sobre' 
                                                          },
                                                          { 
                                                              label: 'Tarro',
                                                              value: 'Tarro' 
                                                          },
                                                          { 
                                                              label: 'Tubo',
                                                              value: 'Tubo' 
                                                          },
                                                          { 
                                                              label: 'Decímetro',
                                                              value: 'Decímetro' 
                                                          },
                                                          { 
                                                              label: 'Metro lineal',
                                                              value: 'Metro lineal' 
                                                          },
                                                          { 
                                                              label: 'Kilómetro',
                                                              value: 'Kilómetro' 
                                                          },
                                                          { 
                                                              label: 'Radianes',
                                                              value: 'Radianes' 
                                                          },
                                                          { 
                                                              label: 'Kilovatios hora',
                                                              value: 'Kilovatios hora' 
                                                          },
                                                          { 
                                                              label: 'Número de rollos',
                                                              value: 'Número de rollos' 
                                                          } 
                                                      ],
                                                  })" class="flex w-full max-w-xs flex-col gap-1" x-on:keydown="handleKeydownOnOptions($event)" x-on:keydown.esc.window="isOpen = false, openedWithKeyboard = false">
                                                      
                                                  <div class="relative">
                                                        <label for="make" class="text-sm text-on-surface dark:text-on-surface-dark dark:text-gray-300">Unidad*</label>
                                                        <!-- trigger button  -->
                                                        <button type="button" class="inline-flex w-full items-center justify-between gap-2 border border-outline rounded-radius bg-surface-alt px-4 py-2 text-sm 
                                                        font-medium tracking-wide text-on-surface transition hover:opacity-75 focus:border-purple-400 
                                                        focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray" role="combobox" 
                                                        aria-controls="makesList" aria-haspopup="listbox" x-on:click="isOpen = ! isOpen" x-on:keydown.down.prevent="openedWithKeyboard = true" 
                                                        x-on:keydown.enter.prevent="openedWithKeyboard = true" x-on:keydown.space.prevent="openedWithKeyboard = true" 
                                                        x-bind:aria-expanded="isOpen || openedWithKeyboard" x-bind:aria-label="selectedOption ? selectedOption.value : 'Seleccione'" >
                                                            <span class="text-sm font-normal" x-text="selectedOption ? selectedOption.value : 'Seleccione'"></span>
                                                            <!-- Chevron  -->
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"class="size-5" aria-hidden="true">
                                                                <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/>
                                                            </svg>
                                                        </button>
                                                        <!-- Hidden Input To Grab The Selected Value  -->
                                                        <input type="text" id="unit" name="unit" x-ref="hiddenTextField" hidden=""/>
                                                        <input type="text" id="validate_unit" name="validate_unit" class="hidden">
                                                      <div x-show="isOpen || openedWithKeyboard" id="makesList" class="w-full overflow-hidden rounded-radius border border-outline bg-surface-alt 
                                                      dark:border-outline-dark dark:bg-surface-dark-alt" role="listbox" aria-label="industries list" x-on:click.outside="isOpen = false, openedWithKeyboard = false" 
                                                      x-on:keydown.down.prevent="$focus.wrap().next()" x-on:keydown.up.prevent="$focus.wrap().previous()" x-transition x-trap="openedWithKeyboard">

                                                          <!-- Search  -->
                                                          <div class="relative ">
                                                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="1.5" class="absolute left-4 top-1/2 size-5 -translate-y-1/2 text-on-surface/50 dark:text-on-surface-dark/50" aria-hidden="true" >
                                                                  <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                                                              </svg>
                                                              <input type="text" class="dark:bg-gray-800 dark:text-gray-200 w-full border-b border-outline bg-surface-alt py-2.5 pl-11 pr-4 text-sm text-on-surface focus:outline-hidden focus-visible:border-primary disabled:cursor-not-allowed disabled:opacity-75 dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark dark:focus-visible:border-primary-dark" name="searchField" x-ref="searchField" aria-label="Search" x-on:input="getFilteredOptions($el.value)" placeholder="Buscar" />
                                                          </div>

                                                          <!-- Options  -->

                                                          <ul class="flex max-h-44 flex-col overflow-y-auto">
                                                              <li class="hidden px-4 py-2 text-sm text-on-surface dark:text-on-surface-dark" x-ref="noResultsMessage">
                                                                  <span>No se encontraron coincidencias</span>
                                                              </li>
                                                              <template x-for="(item, index) in options" x-bind:key="item.value">
                                                                  <li class="dark:bg-gray-800 dark:text-gray-200 combobox-option inline-flex cursor-pointer hover:bg-gray-200 justify-between gap-6 
                                                                  bg-neutral-50 px-4 py-2 text-sm text-on-surface hover:bg-surface-dark-alt/5 hover:bg-purple-500 dark:hover:text-gray-200 
                                                                  hover:text-on-surface-strong focus-visible:bg-surface-dark-alt/5 
                                                                  focus-visible:text-on-surface-strong focus-visible:outline-hidden dark:bg-surface-dark-alt dark:text-on-surface-dark 
                                                                  dark:hover:bg-purple-200
                                                                  dark:hover:text-on-surface-dark-strong dark:focus-visible:bg-surface-alt/10 dark:focus-visible:text-on-surface-dark-strong" 
                                                                  role="option" x-on:click="setSelectedOption(item) ; catchUnit(item.value)" x-on:keydown.enter="setSelectedOption(item)" 
                                                                  x-bind:id="'option-' + index" tabindex="0">
                                                                      
                                                                      <!-- Label  -->
                                                                      <span x-bind:class="selectedOption == item ? 'font-bold text-purple-600' : null" x-text="item.label"></span>
                                                                      <!-- Screen reader 'selected' indicator  -->
                                                                      <span class="sr-only" x-text="selectedOption == item ? 'selected' : null"></span>
                                                                      <!-- Checkmark  -->
                                                                      <svg x-cloak x-show="selectedOption == item" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" fill="#9333ea" stroke-width="2" class="size-4" aria-hidden="true">
                                                                          <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5">
                                                                      </svg>
                                                                  </li>
                                                              </template>
                                                          </ul>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                          
                                          <div class="text-sm p-2 w-full hidden" id="barcode2Div">
                                              <span class="text-gray-700 dark:text-gray-400">
                                                  BARCODE*
                                              </span>
                                            
                                                    <input
                                                      class="w-full text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                                                        focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                                                        form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer"
                                                      placeholder="BARCODE"
                                                      id="barcode2"
                                                      type="text" 
                                                      name="barcode2"
                                                      pattern="[0-9a-zA-Z ]{3,}"
                                                      onchange="selectBarcode2()"
                                                      
                                                    />
                                                    <span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">
                                                      Solo puede introducir letras y números, mínimo 3 caracteres.
                                                    </span>
                                              </div>


                                      </div>
                                  </div>
                              </div>
                              <div>
                                  <button id="controlsAccordionItemThreeAdd" type="button" class="rounded-lg shadow-md flex w-full items-center justify-between gap-4 p-4 text-left border border-transparent rounded-lg 
                                            active:bg-purple-200 focus:outline-none focus:shadow-outline-purple text-sm" aria-controls="accordionItemThree" 
                                  x-on:click="selectedAccordionItem = 'three'" x-bind:class="selectedAccordionItem === 'three' ? 'text-on-surface-strong dark:text-on-surface-dark-strong font-bold text-purple-600'  : 'text-on-surface dark:text-on-surface-dark font-medium dark:text-gray-300'" x-bind:aria-expanded="selectedAccordionItem === 'three' ? 'true' : 'false'">
                                          BARCODE* / Cantidad* / Costo Inicial*
                                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke="currentColor" class="size-5 shrink-0 transition" aria-hidden="true" x-bind:class="selectedAccordionItem === 'three'  ?  'rotate-180'  :  ''">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                      </svg>
                                  </button>
                                  <div x-cloak x-show="selectedAccordionItem === 'three'" id="accordionItemThree" role="region" aria-labelledby="controlsAccordionItemThree" x-collapse>
                                      <div class="p-2 text-sm sm:text-base text-pretty grid grid-cols-1 md:grid-cols-3">

                                            <div class="p-2 w-full">
                                                    <p
                                                      class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                                                    >
                                                      BARCODE*
                                                    </p>
                                            
                                                    <input
                                                      class="w-full text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                                                        focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                                                        form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer"
                                                      placeholder="BARCODE"
                                                      id="barcode"
                                                      type="text" 
                                                      name="barcode"
                                                      pattern="[0-9a-zA-Z ]{3,}"
                                                      
                                                    />
                                                    <span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">
                                                      Solo puede introducir letras y números, mínimo 3 caracteres.
                                                    </span>
                                              </div>
                                              <div class="p-2 w-full">
                                                <p
                                                  class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                                                >
                                                  Cantidad*
                                                </p>
                                              
                                                  <input
                                                    class="w-full text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                                                      focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                                                      form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer"
                                                    placeholder="cantidad"
                                                    id="cantidad"
                                                    type="text" 
                                                    name="cantidad"
                                                    pattern="[0-9 ]{1,}"
                                                    onchange="cantidadSimple()"
                                                    
                                                  />
                                                  <span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">
                                                    Solo puede introducir números.
                                                  </span>
                                              </div>
                                              <div class="p-2 w-full">
                                                <p
                                                  class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                                                >
                                                  Costo inicial*
                                                </p>
                                              
                                                  <input
                                                    class="w-full text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                                                        focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                                                        form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer"
                                                    placeholder="Costo Inicial"
                                                    id="costoInicial"
                                                    type="text" 
                                                    name="costoInicial"
                                                    pattern="[0-9 \.]{1,}"
                                                    
                                                  />
                                                  <span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">
                                                    Solo puede introducir números.
                                                  </span>
                                              </div>


                                      </div>
                                  </div>
                              </div>
                              <div>
                                  <button id="controlsAccordionItemFour" type="button" class="text-sm mb-2 rounded-lg shadow-md flex w-full items-center justify-between gap-4 p-4 text-left border border-transparent rounded-lg 
                                            active:bg-purple-200 focus:outline-none focus:shadow-outline-purple" aria-controls="accordionItemFour" 
                                  x-on:click="selectedAccordionItem = 'four'" x-bind:class="selectedAccordionItem === 'four' ? 'text-on-surface-strong dark:text-on-surface-dark-strong font-bold text-purple-600'  : 'text-on-surface dark:text-on-surface-dark font-medium dark:text-gray-300'" x-bind:aria-expanded="selectedAccordionItem === 'four' ? 'true' : 'false'">
                                          Precio base* / Impuesto* / Precio final*
                                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke="currentColor" class="size-5 shrink-0 transition" aria-hidden="true" x-bind:class="selectedAccordionItem === 'four'  ?  'rotate-180'  :  ''">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                      </svg>
                                  </button>
                                  <div x-cloak x-show="selectedAccordionItem === 'four'" id="accordionItemFour" role="region" aria-labelledby="controlsAccordionItemFour" x-collapse>
                                      <div class="p-2 text-sm sm:text-base text-pretty rounded-lg shadow-md mb-2 grid grid-cols-1 md:grid-cols-3">
                                            <div class="text-sm p-2">
                                                      <p
                                                        class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                                                      >
                                                        Precio Base*
                                                      </p>
                                                
                                                    <input
                                                      class="w-full text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                                                        focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                                                        form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer"
                                                      placeholder="precio base"
                                                      id="precioBase"
                                                      type="text" 
                                                      name="precioBase"
                                                      pattern="[0-9 \.]{1,}"
                                                      onchange="updatePrecioBase()"
                                                      
                                                    />
                                                    <span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">
                                                      Solo puede introducir números.
                                                    </span>
                                            </div>
                                              
                                            <div class="text-sm p-2">
                                              <div x-data="combobox({
                                                    allOptions: [
                                                        { 
                                                            label: 'Ninguno (0%)', 
                                                            value: 'Ninguno (0%)' 
                                                        },
                                                        { 
                                                            label: 'IVA Exento - Exen (0.00%)',
                                                            value: 'IVA Exento - Exen (0.00%)' 
                                                        },
                                                        { 
                                                            label: 'IVA Excluído - Excl (0.00%)',
                                                            value: 'IVA Excluído - Excl (0.00%)' 
                                                        },
                                                        { 
                                                            label: 'IVA (5.00%)',
                                                            value: 'IVA (5.00%)' 
                                                        },
                                                        { 
                                                            label: 'IVA (19.00%)',
                                                            value: 'IVA (19.00%)' 
                                                        }
                                                    ],
                                                })" class="flex w-full max-w-xs flex-col gap-1" x-on:keydown="handleKeydownOnOptions($event)" x-on:keydown.esc.window="isOpen = false, openedWithKeyboard = false">
                                                    <label for="make" class="text-sm text-on-surface dark:text-on-surface-dark dark:text-gray-300">Impuesto*</label>
                                                    <div class="relative">

                                                        <!-- trigger button  -->
                                                        <button type="button" class="mt-1 inline-flex w-full items-center justify-between gap-2 border border-outline rounded-[4px] bg-surface-alt px-4 py-2 text-sm 
                                                        font-medium tracking-wide text-on-surface transition hover:opacity-75 focus:border-purple-400 
                                                        focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray" 
                                                        role="combobox" aria-controls="makesList" aria-haspopup="listbox" x-on:click="isOpen = ! isOpen" 
                                                        x-on:keydown.down.prevent="openedWithKeyboard = true" x-on:keydown.enter.prevent="openedWithKeyboard = true" 
                                                        x-on:keydown.space.prevent="openedWithKeyboard = true" x-bind:aria-expanded="isOpen || openedWithKeyboard" 
                                                        x-bind:aria-label="selectedOption ? selectedOption.value : 'Seleccione'" >
                                                            <span class="text-sm font-normal" x-text="selectedOption ? selectedOption.value : 'Seleccione'"></span>
                                                            <!-- Chevron  -->
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"class="size-5" aria-hidden="true">
                                                                <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/>
                                                            </svg>
                                                        </button>

                                                        <!-- Hidden Input To Grab The Selected Value  -->
                                                        <input id="impuesto" name="impuesto" x-ref="hiddenTextField" hidden=""/>
                                                        <input id="validate_impuesto" name="validate_impuesto" class="hidden"/>
                                                        <div x-show="isOpen || openedWithKeyboard" id="makesList" class="w-full overflow-hidden rounded-radius border border-outline bg-surface-alt dark:border-outline-dark dark:bg-surface-dark-alt" role="listbox" aria-label="industries list" x-on:click.outside="isOpen = false, openedWithKeyboard = false" x-on:keydown.down.prevent="$focus.wrap().next()" x-on:keydown.up.prevent="$focus.wrap().previous()" x-transition x-trap="openedWithKeyboard">

                                                            <!-- Search  -->
                                                            <div class="relative">
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="1.5" class="absolute left-4 top-1/2 size-5 -translate-y-1/2 text-on-surface/50 dark:text-on-surface-dark/50" aria-hidden="true" >
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                                                                </svg>
                                                                <input type="text" class="dark:bg-gray-800 dark:text-gray-200 w-full border-b border-outline bg-surface-alt py-2.5 pl-11 pr-4 text-sm text-on-surface focus:outline-hidden focus-visible:border-primary disabled:cursor-not-allowed disabled:opacity-75 dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark dark:focus-visible:border-primary-dark" name="searchField" x-ref="searchField" aria-label="Search" x-on:input="getFilteredOptions($el.value)" placeholder="Search" />
                                                            </div>

                                                            <!-- Options  -->
                                                            <ul class="flex max-h-44 flex-col overflow-y-auto">
                                                                <li class="hidden px-4 py-2 text-sm text-on-surface dark:text-on-surface-dark" x-ref="noResultsMessage">
                                                                    <span>No se encontraron coincidencias</span>
                                                                </li>
                                                                <template x-for="(item, index) in options" x-bind:key="item.value">
                                                                    <li class="dark:bg-gray-800 dark:text-gray-200 combobox-option inline-flex cursor-pointer hover:bg-gray-200 justify-between gap-6 
                                                                  bg-neutral-50 px-4 py-2 text-sm text-on-surface hover:bg-surface-dark-alt/5 hover:bg-purple-500 dark:hover:text-gray-200 
                                                                  hover:text-on-surface-strong focus-visible:bg-surface-dark-alt/5 
                                                                  focus-visible:text-on-surface-strong focus-visible:outline-hidden dark:bg-surface-dark-alt dark:text-on-surface-dark 
                                                                  dark:hover:bg-purple-200
                                                                  dark:hover:text-on-surface-dark-strong dark:focus-visible:bg-surface-alt/10 dark:focus-visible:text-on-surface-dark-strong" role="option" x-on:click="setSelectedOption(item) ; catchImpuesto(item.value) ; updatePrecioImpuesto()" 
                                                                          x-on:keydown.enter="setSelectedOption(item)" x-bind:id="'option-' + index" tabindex="0">
                                                                        <!-- Label  -->        
                                                                        <span x-bind:class="selectedOption == item ? 'font-bold' : null" x-text="item.label"></span>
                                                                        <!-- Screen reader 'selected' indicator  -->
                                                                        <span class="sr-only" x-text="selectedOption == item ? 'selected' : null"></span>
                                                                        <!-- Checkmark  -->
                                                                        <svg x-cloak x-show="selectedOption == item" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="2" class="size-4" aria-hidden="true">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5">
                                                                        </svg>
                                                                    </li>
                                                                </template>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="text-sm p-2">
                                                <p
                                                  class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                                                >
                                                  Precio final*
                                                </p>
                                                  <input
                                                    class="w-full text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                                                        focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                                                        form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer"
                                                    placeholder="introduzca nombre"
                                                    id="precioFinal"
                                                    type="text" 
                                                    name="precioFinal"
                                                    pattern="[0-9 \.]{1,}"
                                                    onchange="updatePrecioFinal()"
                                                    
                                                  />
                                                <span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">
                                                  Solo puede introducir números.
                                                </span>
                                            </div>

                                      </div>
                                  </div>
                              </div>
                              <div>
                                  <button id="controlsAccordionItemFiveAdd" type="button" class="hidden text-sm mb-2 rounded-lg shadow-md flex w-full items-center justify-between gap-4 p-4 text-left border border-transparent
                                            active:bg-purple-200 focus:outline-none focus:shadow-outline-purple" aria-controls="accordionItemFive" 
                                  x-on:click="selectedAccordionItem = 'five'" x-bind:class="selectedAccordionItem === 'five' ? 'text-on-surface-strong dark:text-on-surface-dark-strong font-bold text-purple-600'  : 'text-on-surface dark:text-on-surface-dark font-medium dark:text-gray-300'" x-bind:aria-expanded="selectedAccordionItem === 'five' ? 'true' : 'false'">
                                          Combo
                                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke="currentColor" class="size-5 shrink-0 transition" aria-hidden="true" x-bind:class="selectedAccordionItem === 'five'  ?  'rotate-180'  :  ''">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                      </svg>
                                  </button>
                                  <div x-cloak x-show="selectedAccordionItem === 'five'" id="accordionItemFour" role="region" aria-labelledby="controlsAccordionItemFour" x-collapse>
                                      
                                        <div x-data="{dataz: [], counter: 0}" class="rounded-lg shadow-md mb-2" >
                                              <div class="max-h-48 overflow-y-auto scroll-smooth flex flex-col-reverse">                                                  
                                                  <template x-for="(item, index) in dataz" :key="index" x-transition>
                                                      <div>
                                                          <div class="p-2 text-sm sm:text-base text-pretty mb-2 grid grid-cols-4 sm-grid-cols-3">
                                                            <div class="text-sm p-2 jz-center jz-hide-small">
                                                                  <button type="button"class="p-2 rounded shadow borderjz-display-middle text-purple-600 dark:gray-300 mb-2">
                                                                    <i class="fa fa-tag fa-2x" aria-hidden="true"></i>
                                                                  </button>
                                                            </div>
                                                              
                                                            <div class="text-sm p-2">
                                                                <div class="inline-block relative w-full" x-id="['comboProduct']">
                                                                      <span class="flex dark:text-gray-300">Producto</span>
                                                                      <select class="cursor-pointer border rounded border-slate-200 p-2 flex flex-col justify-center w-full items-center 
                                                                          text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                                                                          focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray"
                                                                          onfocus='this.size=4;' onblur='this.size=0;' 
                                                                          onchange='this.size=1; this.blur();'7
                                                                          :id="$id('comboProduct')"
                                                                          :name="$id('comboProduct')">
                                                                          @foreach($products as $item)
                                                                              <option value="{{$item->id}}" class="cursor-pointer hover:bg-purple-600">{{$item->title}}</option>
                                                                          @endforeach
                                                                      </select>
                                                                </div>
                                                            </div>
                                                          
                                                        
                                                            <div class="text-sm p-2 jz-center" x-id="['comboCant']">
                                                              <span class="flex dark:text-gray-300">Cantidad</span>
                                                                <input
                                                                    class="w-full text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                                                                        focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                                                                        form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer"
                                                                    placeholder="Cantidad"
                                                                    :id="$id('comboCant')"
                                                                    :name="$id('comboCant')"
                                                                    pattern="[0-9 \.]{1,}"

                                                                    
                                                                  />
                                                                <span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">
                                                                  Solo puede introducir números.
                                                                </span>
                                                            </div>

                                                            <div class="text-sm p-2 jz-center">
                                                                    <button type="button" class="p-2 rounded shadow borderjz-display-middle text-purple-600 dark:gray-300 mb-2"
                                                                            @click="dataz.splice(index, 1)"
                                                                          >
                                                                          <i class="fa fa-trash fa-2x" aria-hidden="true"></i>
                                                                    </button>
                                                            </div>

                                                        </div>
                                                  </div>
                                        
                                              </template>
                                            </div>
                                              <button
                                                class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-purple-600 active:text-white active:bg-purple-600 
                                                        focus:outline-none focus:shadow-outline-purple border border-transparent rounded-lg ml-px"
                                                type="button"
                                                @click="dataz.push({ randomNumber: Math.floor(Math.random() * 20) })"
                                              > Agrega productos a tu combo
                                              </button>
                                          
                                            
                                            
                                        </div>


                              </div>
                            
                          </div>
                        </div>


                      <!-- init second accordion -->
                      <div x-data="{ selectedAccordionItem: 'one' }" class="w-full divide-y divide-outline overflow-hidden rounded-sm hidden" id="advanced_form">
                            
                            <div class="flex justify-between">
                              <p class="text-xl font-bold text-gray-500 p-2 mb-3 hidden" id="advanced_title">Formulario Avanzado de Productos</p>
                              <p class="text-xl font-bold text-gray-500 p-2 mb-3" id="servicio_advanced_title">Formulario Avanzado de Servicios</p>
                              <p class="text-xl font-bold text-gray-500 p-2 mb-3 hidden" id="combo_advanced_title">Formulario Avanzado de Combos</p>
                              <div class="modal-close cursor-pointer z-50 flex flex-row" onclick="modalClose('addProduct')">
                                <svg class="fill-current text-gray-500" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 18 18">
                                    <path
                                      d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
                                    </path>
                                </svg>
                              </div>
                              </div>
                              <div>
                                  <button id="controlsAccordionItemOne" type="button" class="text-sm rounded-lg shadow-md flex w-full items-center justify-between gap-4 p-4 text-left border border-transparent rounded-lg 
                                            active:bg-purple-200 focus:outline-none focus:shadow-outline-purple" aria-controls="accordionItemOne" x-on:click="selectedAccordionItem = 'one'" 
                                  x-bind:class="selectedAccordionItem === 'one' ? 'text-on-surface-strong dark:text-on-surface-dark-strong font-bold text-purple-600'  : 'text-on-surface dark:text-on-surface-dark font-medium dark:text-gray-300'" x-bind:aria-expanded="selectedAccordionItem === 'one' ? 'true' : 'false'">
                                      Imagen del Producto
                                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke="currentColor" class="size-5 shrink-0 transition" aria-hidden="true" x-bind:class="selectedAccordionItem === 'one'  ?  'rotate-180'  :  ''">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                      </svg>
                                  </button>
                                  <div x-cloak x-show="selectedAccordionItem === 'one'" id="accordionItemOne" role="region" aria-labelledby="controlsAccordionItemOne" x-collapse>
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
                                                      <p class="text-gray-500">Imagen del producto</p>
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
                              </div>
                              <div>
                                  <button id="controlsAccordionItemTwo" type="button" class="text-sm rounded-lg shadow-md flex w-full items-center justify-between gap-4 p-4 text-left border border-transparent rounded-lg 
                                            active:bg-purple-200 focus:outline-none focus:shadow-outline-purple" aria-controls="accordionItemTwo" x-on:click="selectedAccordionItem = 'two'" 
                                  x-bind:class="selectedAccordionItem === 'two' ? 'text-on-surface-strong dark:text-on-surface-dark-strong font-bold text-purple-600'  : 'text-on-surface dark:text-on-surface-dark font-medium dark:text-gray-300'" x-bind:aria-expanded="selectedAccordionItem === 'two' ? 'true' : 'false'">
                                          Descripción
                                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke="currentColor" class="size-5 shrink-0 transition" aria-hidden="true" x-bind:class="selectedAccordionItem === 'two'  ?  'rotate-180'  :  ''">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                      </svg>
                                  </button>
                            <div x-cloak x-show="selectedAccordionItem === 'two'" id="accordionItemTwo" role="region" aria-labelledby="controlsAccordionItemTwo" x-collapse>
                                <div class="p-2 text-sm sm:text-base text-pretty">
                                        <div class="text-sm p-2 w-full">
                                            <textarea
                                              class="w-full text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                                                  focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray"
                                              placeholder="introduzca descripción"
                                              id="description"
                                              type="text" 
                                              name="description"
                                              pattern="[0-9 \.]{1,}"
                                              
                                            ></textarea>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                              <div>
                                  <button id="controlsAccordionItemThree" type="button" class="rounded-lg shadow-md flex w-full items-center justify-between gap-4 p-4 text-left border border-transparent rounded-lg 
                                            active:bg-purple-200 focus:outline-none focus:shadow-outline-purple text-sm" aria-controls="accordionItemThree" 
                                  x-on:click="selectedAccordionItem = 'three'" x-bind:class="selectedAccordionItem === 'three' ? 'text-on-surface-strong dark:text-on-surface-dark-strong font-bold text-purple-600'  : 'text-on-surface dark:text-on-surface-dark font-medium dark:text-gray-300'" x-bind:aria-expanded="selectedAccordionItem === 'three' ? 'true' : 'false'">
                                            Detalles de Inventario
                                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke="currentColor" class="size-5 shrink-0 transition" aria-hidden="true" x-bind:class="selectedAccordionItem === 'three'  ?  'rotate-180'  :  ''">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                      </svg>
                                  </button>
                                  <div x-cloak x-show="selectedAccordionItem === 'three'" id="accordionItemThree" role="region" aria-labelledby="controlsAccordionItemThree" x-collapse>
                                      <div class="p-2 text-sm sm:text-base text-pretty grid grid-cols-1 md:grid-cols-3">

                                              <div class="p-2 w-full">
                                                <p
                                                  class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                                                >
                                                  Cantidad*
                                                </p>
                                              
                                                  <input
                                                    class="w-full text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                                                        focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                                                        form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer"
                                                    placeholder="cantidad"
                                                    id="cantidadAdvanced"
                                                    type="text" 
                                                    name="cantidadAdvanced"
                                                    pattern="[0-9 ]{1,}"
                                                    onchange="cantidadAdvanced()"
                                                    
                                                  />
                                                  <span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">
                                                    Solo puede introducir números.
                                                  </span>
                                              </div>
                                              <div class="p-2 w-full">
                                                <p
                                                  class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                                                >
                                                  Cantidad mínima
                                                </p>
                                              
                                                  <input
                                                      class="w-full text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                                                        focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                                                        form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer"
                                                    placeholder="cantidad mínima"
                                                    id="cantidadMinima"
                                                    type="text" 
                                                    name="cantidadMinima"
                                                    pattern="[0-9 ]{1,}"
                                                    
                                                  />
                                                  <span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">
                                                    Solo puede introducir números.
                                                  </span>
                                              </div>
                                              <div class="p-2 w-full">
                                                <p
                                                  class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                                                >
                                                  Cantidad máxima
                                                </p>
                                              
                                                  <input
                                                    class="w-full text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                                                        focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                                                        form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer"
                                                    placeholder="cantidad maxima"
                                                    id="cantidadMaxima"
                                                    type="text" 
                                                    name="cantidadMaxima"
                                                    pattern="[0-9 ]{1,}"
                                                    
                                                  />
                                                  <span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">
                                                    Solo puede introducir números.
                                                  </span>
                                              </div>


                                      </div>
                                  </div>
                              </div>
                              <div>
                                  <button id="controlsAccordionItemFour" type="button" class="text-sm mb-2 rounded-lg shadow-md flex w-full items-center justify-between gap-4 p-4 text-left border border-transparent rounded-lg 
                                            active:bg-purple-200 focus:outline-none focus:shadow-outline-purple" aria-controls="accordionItemFour" 
                                  x-on:click="selectedAccordionItem = 'four'" x-bind:class="selectedAccordionItem === 'four' ? 'text-on-surface-strong dark:text-on-surface-dark-strong font-bold text-purple-600'  : 'text-on-surface dark:text-on-surface-dark font-medium dark:text-gray-300'" x-bind:aria-expanded="selectedAccordionItem === 'four' ? 'true' : 'false'">
                                          Adicionales
                                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke="currentColor" class="size-5 shrink-0 transition" aria-hidden="true" x-bind:class="selectedAccordionItem === 'four'  ?  'rotate-180'  :  ''">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                      </svg>
                                  </button>
                                  <div x-cloak x-show="selectedAccordionItem === 'four'" id="accordionItemFour" role="region" aria-labelledby="controlsAccordionItemFour" x-collapse>
                                      <div class="p-2 text-sm sm:text-base text-pretty rounded-lg shadow-md mb-2 grid grid-cols-1 md:grid-cols-3">
                                                
                                          



                                            <div class="text-sm p-2 flex m-5 marginNegative dark:text-gray-300">
                                                    <span class="flex-row">Venta en Negativo</span>
                                      
                                                <div class="relative w-fit mr-3">
                                                    <div class="peer" aria-describedby="tooltipExample">
                                                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9333ea" class="size-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                                                      </svg>
                                                  </div>
                                                    <div id="tooltipExample" class="absolute -top-9 left-1/2 -translate-x-1/2 z-10 whitespace-nowrap rounded 
                                                    bg-purple-600 px-2 py-1 text-center text-white text-sm text-on-surface-dark-strong opacity-0 transition-all ease-out 
                                                    peer-hover:opacity-100 peer-focus:opacity-100 dark:bg-surface dark:text-on-surface-strong" role="tooltip">
                                                    Vende sin unidades disponibles</div>
                                                </div>
                                                <div class="relative inline-block w-11 h-5 flex-row">
                                                  <input id="ventaNegativo" value="ventaNegativo" name="ventaNegativo" type="checkbox" class="peer appearance-none w-11 h-5 bg-slate-100 rounded-full 
                                                  checked:bg-purple-600 cursor-pointer transition-colors duration-300" />
                                                  <label for="ventaNegativo" class="absolute top-0 left-0 w-5 h-5 bg-white rounded-full border border-slate-300 shadow-sm 
                                                  transition-transform duration-300 peer-checked:translate-x-6 peer-checked:border-slate-800 cursor-pointer">
                                                  </label>
                                                </div>

                                            </div>
                                            <div class="text-sm p-2 dark:text-gray-300">
                                                <div class="inline-block relative w-full">
                                                      <span class="flex">Categoría

                                                      <div x-data="{ showTooltip: false }" class="relative w-fit -mt-3">
                                                          <button x-on:click="showTooltip = !showTooltip" type="button" class="rounded-radius bg-surface-alt px-2 py-2 
                                                          font-medium tracking-wide text-on-surface focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary 
                                                          dark:bg-surface-dark-alt dark:border-surface-dark-alt dark:text-on-surface-dark dark:focus-visible:outline-primary-dark" 
                                                          aria-describedby="tooltipExample">
                                                            <box-icon name='plus-circle' color="#9333ea"></box-icon>
                                                          </button>
                                                          <div 
                                                          style="margin-left: -100px";
                                                          x-cloak x-show="showTooltip" x-on:click.outside="showTooltip = false" id="tooltipExample" 
                                                          class="absolute rounded -top-3 text-white z-10 -ml-30 bg-purple-600 whitespace-nowrap rounded-sm bg-surface-dark px-2 py-1 text-center 
                                                          text-sm text-on-surface-dark-strong dark:bg-surface dark:text-on-surface-strong" role="tooltip" x-transition:enter="transition ease-out" 
                                                          x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out" 
                                                          x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">Crea categorías para organizar tus productos.<br>
                                                            
                                                              <button type="button" onclick="location.href='categories';" 
                                                                      class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-1 px-2 rounded inline-flex items-center">
                                                                      <box-icon name='door-open'></box-icon>
                                                                      <span>Crear Categoría</span>
                                                              </button>
                                                          </div>
                                                      </div>
                                                    
                                                      </span>
                                                    <select class="cursor-pointer border rounded border-slate-200 p-2 pr-8 flex flex-col justify-center w-full items-center 
                                                        text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                                                        focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray"
                                                        onfocus='this.size=4;' onblur='this.size=0;' 
                                                        onchange='this.size=1; this.blur();'7
                                                        id="categoria"
                                                        name="categoria">
                                                        <option value="">Vacío</option>
                                                        @foreach($categories as $item)
                                                            <option value="{{$item->id}}" class="cursor-pointer hover:bg-purple-600">{{$item->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="text-sm p-2 dark:text-gray-300">
                                                <div class="inline-block relative w-full">
                                                  <span class="flex">Códigos UNSPSC
                                                      <div x-data="{ showTooltip: false }" class="relative w-fit -mt-3">
                                                          <button x-on:click="showTooltip = !showTooltip" type="button" class="rounded-radius bg-surface-alt px-2 py-2 
                                                          font-medium tracking-wide text-on-surface focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary 
                                                          dark:bg-surface-dark-alt dark:border-surface-dark-alt dark:text-on-surface-dark dark:focus-visible:outline-primary-dark" 
                                                          aria-describedby="tooltipExample">
                                                            <box-icon name='plus-circle' color="#9333ea"></box-icon>
                                                          </button>
                                                          <div 
                                                          style="margin-left: -130px";
                                                          x-cloak x-show="showTooltip" x-on:click.outside="showTooltip = false" id="tooltipExample" 
                                                          class="absolute rounded -top-3 text-white z-10 mr-9 bg-purple-600 whitespace-nowrap rounded-sm bg-surface-dark px-2 py-1 text-center 
                                                          text-sm text-on-surface-dark-strong dark:bg-surface dark:text-on-surface-strong" role="tooltip" x-transition:enter="transition ease-out" 
                                                          x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out" 
                                                          x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">Es un campo obligatorio si generas <br>facturas electrónicas. <br>
                                                              <button type="button" onclick="location.href='codigo';"
                                                                      class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-1 px-2 rounded 
                                                                      inline-flex items-center text-sm">
                                                                      <box-icon name='door-open'></box-icon>
                                                                      <span class="text-sm ">Crear Código</span>
                                                              </button>
                                                          </div>
                                                      </div>
                                                  </span>
                                                  
                                                    <select class="cursor-pointer border rounded border-slate-200 p-2 pr-8 flex flex-col justify-center w-full items-center 
                                                        text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                                                        focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray"
                                                        onfocus='this.size=4;' onblur='this.size=0;' 
                                                        onchange='this.size=1; this.blur();'
                                                        id="codigoUNSPSC"
                                                        name="codigoUNSPSC">
                                                        <option value="">Vacío</option>
                                                        @foreach($codigos as $item)
                                                            <option value="{{$item->id}}" class="cursor-pointer hover:bg-purple-600">{{$item->codigo}} - {{$item->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>






                                        

                                      </div>
                                  </div>
                              </div>
                            
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
                                    transition-colors duration-150 bg-slate-200 border rounded-lg"
                                onclick="showAdvanced()"
                                id="advanced_button"
                              >Formulario Avanzado
                        </button>
                        <button
                                class="px-4 py-2 text-sm font-medium leading-5 text-black 
                                    transition-colors duration-150 bg-slate-200 border rounded-lg hidden"
                                onclick="showSimple()"
                                id="simple_button"
                              >Formulario Simple
                        </button>
                        <div>
                          <button 
                              class="px-4 py-2 text-sm font-medium leading-5 text-white 
                                        transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg 
                                        active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple
                                        disabled"
                              onclick="submitAddProd()"
                              
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
           <!-- end create product modal -->



          <!-- init edit product modal -->
          <div class="editProduct fixed w-full inset-0 z-50 flex justify-center items-center animated fadeIn faster" style="background: rgba(0,0,0,.7);">
                <div class="border border-blue-500 shadow-lg modal-container bg-white mx-auto rounded-xl shadow-lg z-50">
                  <div class="modal-content py-4 text-left px-6 dark:bg-gray-800">
                    <!--Body-->
                    <div class="container px-6 mx-auto grid">
                      <form id="editProductform" action="{{ route('productosEdit') }}" class="group" method="POST" enctype="multipart/form-data" novalidate>
                            @csrf
                            <div x-data="{ selectedAccordionItem: 'one' }" class="w-full divide-y divide-outline overflow-hidden rounded-sm" id="simple_form_edit">
                              <div class="flex justify-between items-center pb-3 dark:bg-gray-800">
                                <p class="text-xl font-bold text-gray-500 p-2 mb-3 hidden" id="simple_title_edit">Formulario Básico de Edición de Productos</p>
                                <p class="text-xl font-bold text-gray-500 p-2 mb-3" id="servicio_basic_title_edit">Formulario Básico de Edición de Servicios</p>
                                <p class="text-xl font-bold text-gray-500 p-2 mb-3 hidden" id="combo_basic_title_edit">Formulario Básico de Edición de Combos</p>
                                <div class="modal-close cursor-pointer z-50" onclick="modalClose('editProduct')">
                                  <svg class="fill-current text-gray-500" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 18 18">
                                    <path
                                      d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
                                    </path>
                                </svg>
                                </div>
                              </div>
                              <!-- init validate edit -->
                              <div class="hidden" id="validateEdit">
                              </div>
                              <!-- end validate init -->
                              <div>
                                  <button id="controlsAccordionItemOne" type="button" class="text-sm rounded-lg shadow-md flex w-full items-center justify-between gap-4 p-4 text-left border border-transparent rounded-lg 
                                            active:bg-purple-200 focus:outline-none focus:shadow-outline-purple" aria-controls="accordionItemOne" x-on:click="selectedAccordionItem = 'one'" 
                                  x-bind:class="selectedAccordionItem === 'one' ? 'text-on-surface-strong dark:text-on-surface-dark-strong font-bold text-purple-600'  : 'text-on-surface dark:text-on-surface-dark font-medium dark:text-gray-300'" x-bind:aria-expanded="selectedAccordionItem === 'one' ? 'true' : 'false'">
                                      Tipo*
                                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke="currentColor" class="size-5 shrink-0 transition" aria-hidden="true" x-bind:class="selectedAccordionItem === 'one'  ?  'rotate-180'  :  ''">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                      </svg>
                                  </button>
                                  <div x-cloak x-show="selectedAccordionItem === 'one'" id="accordionItemOne" role="region" aria-labelledby="controlsAccordionItemOne" x-collapse>
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4">
                                            <!-- Producto -->
                                            <label onclick="selectProductoEdit()" class="cursor-pointer relative flex items-center gap-4 rounded-radius bg-surface-alt p-2 hover:scale-105 transition-transform text-on-surface dark:text-on-surface-dark dark:bg-surface-dark-alt has-checked:border-primary has-checked:bg-primary/5 has-checked:text-on-surface-strong has-checked:border has-focus:outline-2 has-focus:outline-offset-2 has-focus:outline-primary dark:has-checked:border-primary-dark dark:has-checked:text-on-surface-dark-strong dark:has-checked:bg-primary-dark/5 dark:has-focus:outline-primary-dark border border-outline dark:border-outline-dark">
                                                <input type="radio" id="tipo_producto_edit" aria-describedby="macDescription" class="sr-only peer" name="tipo_edit" value="producto">
                                                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" viewBox="0 0 16 16" fill="#9333ea" class="peer-checked:visible invisible w-5 h-5 shrink-0">
                                                    <path fill-rule="evenodd" d="M12.416 3.376a.75.75 0 0 1 .208 1.04l-5 7.5a.75.75 0 0 1-1.154.114l-3-3a.75.75 0 0 1 1.06-1.06l2.353 2.353 4.493-6.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd">
                                                </svg>
                                                <box-icon type='logo' name='product-hunt'></box-icon>
                                                <div class="flex flex-col">
                                                    <h3 class="font-medium" aria-hidden="true">Producto</h3>
                                                </div>
                                            </label>
                                            <!-- Servicio -->
                                            <label onclick="selectServicioEdit()" class="cursor-pointer relative flex items-center gap-4 rounded-radius bg-surface-alt p-2 hover:scale-105 transition-transform text-on-surface dark:text-on-surface-dark dark:bg-surface-dark-alt has-checked:border-primary has-checked:bg-primary/5 has-checked:text-on-surface-strong has-checked:border has-focus:outline-2 has-focus:outline-offset-2 has-focus:outline-primary dark:has-checked:border-primary-dark dark:has-checked:text-on-surface-dark-strong dark:has-checked:bg-primary-dark/5 dark:has-focus:outline-primary-dark border border-outline dark:border-outline-dark">
                                                <input type="radio" id="tipo_servicio_edit" aria-describedby="windowsDescription" class="sr-only peer" name="tipo_edit" value="servicio">
                                                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" viewBox="0 0 16 16" fill="#9333ea" class="peer-checked:visible invisible w-5 h-5 shrink-0">
                                                    <path fill-rule="evenodd" d="M12.416 3.376a.75.75 0 0 1 .208 1.04l-5 7.5a.75.75 0 0 1-1.154.114l-3-3a.75.75 0 0 1 1.06-1.06l2.353 2.353 4.493-6.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd">
                                                </svg>
                                                <box-icon name='hard-hat'></box-icon>
                                                <div class="flex flex-col">
                                                    <h3 class="font-medium" aria-hidden="true">Servicio</h3>
                                                </div>
                                            </label>
                                            <!-- Combo -->
                                            <label onclick="selectComboEdit()" class="cursor-pointer relative flex items-center gap-4 rounded-radius bg-surface-alt p-2 hover:scale-105 transition-transform text-on-surface dark:text-on-surface-dark dark:bg-surface-dark-alt has-checked:border-primary has-checked:bg-primary/5 has-checked:text-on-surface-strong has-checked:border has-focus:outline-2 has-focus:outline-offset-2 has-focus:outline-primary dark:has-checked:border-primary-dark dark:has-checked:text-on-surface-dark-strong dark:has-checked:bg-primary-dark/5 dark:has-focus:outline-primary-dark border border-outline dark:border-outline-dark">
                                                <input type="radio" id="tipo_combo_edit" aria-describedby="linuxDescription" class="sr-only peer" name="tipo_edit" value="combo">
                                                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" viewBox="0 0 16 16" fill="#9333ea" class="peer-checked:visible invisible w-5 h-5 shrink-0">
                                                    <path fill-rule="evenodd" d="M12.416 3.376a.75.75 0 0 1 .208 1.04l-5 7.5a.75.75 0 0 1-1.154.114l-3-3a.75.75 0 0 1 1.06-1.06l2.353 2.353 4.493-6.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd">
                                                </svg>
                                                <box-icon name='unite'></box-icon>
                                                <div class="flex flex-col">
                                                    <h3 class="font-medium" aria-hidden="true">Combo</h3>
                                                </div>
                                            </label>
                                        </div>
                                  </div>
                              </div>

                              <div>
                                  <button id="controlsAccordionItemTwo" type="button" class="text-sm rounded-lg shadow-md flex w-full items-center justify-between gap-4 p-4 text-left border border-transparent rounded-lg 
                                            active:bg-purple-200 focus:outline-none focus:shadow-outline-purple" aria-controls="accordionItemTwo" x-on:click="selectedAccordionItem = 'two'" 
                                  x-bind:class="selectedAccordionItem === 'two' ? 'text-on-surface-strong dark:text-on-surface-dark-strong font-bold text-purple-600'  : 'text-on-surface dark:text-on-surface-dark font-medium dark:text-gray-300'" x-bind:aria-expanded="selectedAccordionItem === 'two' ? 'true' : 'false'">
                                    <span class="" id="barcodeSpanEdit"> Nombre* / Unidad* </span><span class="hidden" id="barcode2SpanEdit"> Nombre* / Unidad* / BARCODE*</span>
                                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke="currentColor" class="size-5 shrink-0 transition" aria-hidden="true" x-bind:class="selectedAccordionItem === 'two'  ?  'rotate-180'  :  ''">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                      </svg>
                                  </button>
                                  <div x-cloak x-show="selectedAccordionItem === 'two'" id="accordionItemTwo" role="region" aria-labelledby="controlsAccordionItemTwo" x-collapse>
                                      <div id="divNombreUnidadEdit" class="p-2 text-sm sm:text-base text-pretty grid grid-cols-1 md:grid-cols-2">
                                          <div class="text-sm p-2 w-full">
                                              <span class="text-gray-700 dark:text-gray-400">
                                                  Nombre*
                                              </span>
                                              <input
                                              class="w-full text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                                              focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                                              form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer"
                                              placeholder="introduzca nombre"
                                              id="title_edit"
                                              type="text" 
                                              name="title_edit"
                                              pattern="[0-9a-zA-Z ]{3,}"
                                                  
                                              />
                                            <span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">
                                              Solo puede introducir letras y números, mínimo 3 caracteres.
                                            </span>       
                                          </div>

                                          <div class="text-sm p-2 w-full">
                                                <span class="text-gray-700 dark:text-gray-400 dark:text-gray-300">Unidad*</span>
                                              <select class="cursor-pointer border rounded border-slate-200 p-2 pr-8 flex flex-col justify-center w-full items-center 
                                                      text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                                                      focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray"
                                                      onfocus='this.size=4;' onblur='this.size=0;' 
                                                      onchange='this.size=1; this.blur();'7
                                                      id="unit_edit"
                                                      name="unit_edit">
                                                      <option value="Unidad" class="cursor-pointer hover:bg-purple-600">Unidad</option>
                                                      <option value="Servicio" class="cursor-pointer hover:bg-purple-600" id="Servicio">Servicio</option>
                                                      <option value="Pieza" class="cursor-pointer hover:bg-purple-600">Pieza</option>
                                                      <option value="Millar" class="cursor-pointer hover:bg-purple-600">Millar</option>
                                                      <option value="Par" class="cursor-pointer hover:bg-purple-600">Par</option>
                                                      <option value="Numero de pares" class="cursor-pointer hover:bg-purple-600">Numero de pares</option>
                                                      <option value="Metro" class="cursor-pointer hover:bg-purple-600">Metro</option>
                                                      <option value="Pulgada" class="cursor-pointer hover:bg-purple-600">Pulgada</option>
                                                      <option value="Centímetro cuadrado" class="cursor-pointer hover:bg-purple-600">Centímetro cuadrado</option>
                                                      <option value="Pulgada cuadrada" class="cursor-pointer hover:bg-purple-600">Pulgada cuadrada</option>
                                                      <option value="Metro cuadrado" class="cursor-pointer hover:bg-purple-600">Metro cuadrado</option>
                                                      <option value="Mililitro" class="cursor-pointer hover:bg-purple-600">Mililitro</option>
                                                      <option value="Litro" class="cursor-pointer hover:bg-purple-600">Litro</option>
                                                      <option value="Galón" class="cursor-pointer hover:bg-purple-600">Galón</option>
                                                      <option value="Gramo" class="cursor-pointer hover:bg-purple-600">Gramo</option>
                                                      <option value="Kilogramo" class="cursor-pointer hover:bg-purple-600">Kilogramo</option>
                                                      <option value="Tonelada" class="cursor-pointer hover:bg-purple-600">Tonelada</option>
                                                      <option value="Libra" class="cursor-pointer hover:bg-purple-600">Libra</option>
                                                      <option value="Administración" class="cursor-pointer hover:bg-purple-600">Administración</option>
                                                      <option value="Metro cúbico" class="cursor-pointer hover:bg-purple-600">Metro cúbico</option>
                                                      <option value="Metro cúbico (neto)" class="cursor-pointer hover:bg-purple-600">Metro cúbico (neto)</option>
                                                      <option value="Hora" class="cursor-pointer hover:bg-purple-600">Hora</option>
                                                      <option value="Minuto" class="cursor-pointer hover:bg-purple-600">Minuto</option>
                                                      <option value="Día" class="cursor-pointer hover:bg-purple-600">Día</option>
                                                      <option value="Ampolla" class="cursor-pointer hover:bg-purple-600">Ampolla</option>
                                                      <option value="Hectárea" class="cursor-pointer hover:bg-purple-600">Hectárea</option>
                                                      <option value="Frasco" class="cursor-pointer hover:bg-purple-600">Frasco</option>
                                                      <option value="Paquete" class="cursor-pointer hover:bg-purple-600">Paquete</option>
                                                      <option value="Sobre" class="cursor-pointer hover:bg-purple-600">Sobre</option>
                                                      <option value="Tarro" class="cursor-pointer hover:bg-purple-600">Tarro</option>
                                                      <option value="Tubo" class="cursor-pointer hover:bg-purple-600">Tubo</option>
                                                      <option value="Decímetro" class="cursor-pointer hover:bg-purple-600">Decímetro</option>
                                                      <option value="Metro lineal" class="cursor-pointer hover:bg-purple-600">Metro lineal</option>
                                                      <option value="Kilómetro" class="cursor-pointer hover:bg-purple-600">Kilómetro</option>
                                                      <option value="Radianes" class="cursor-pointer hover:bg-purple-600">Radianes</option>
                                                      <option value="Kilovatios hora" class="cursor-pointer hover:bg-purple-600">Kilovatios hora</option>
                                                      <option value="Número de rollos" class="cursor-pointer hover:bg-purple-600">Número de rollos</option>
                                            </select>
                                            <input type="text" id="validate_unit_edit" name="validate_unit_edit" class="hidden">


                                          </div>

                                          <div class="text-sm p-2 w-full hidden" id="barcode2DivEdit">
                                            <span class="text-gray-700 dark:text-gray-400">
                                                BARCODE*
                                            </span>
                                          
                                                  <input
                                                    class="w-full text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                                                      focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                                                      form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer"
                                                    placeholder="BARCODE"
                                                    id="barcode2_edit"
                                                    type="text" 
                                                    name="barcode2_edit"
                                                    pattern="[0-9a-zA-Z ]{3,}"
                                                    onchange="selectBarcode2Edit()"
                                                    
                                                  />
                                                  <span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">
                                                    Solo puede introducir letras y números, mínimo 3 caracteres.
                                                  </span>
                                          </div>      

                                        </div>
                                    </div>
                                </div>

                                <div>
                                  <button id="controlsAccordionItemThreeEdit" type="button" class="rounded-lg shadow-md flex w-full items-center justify-between gap-4 p-4 text-left border border-transparent rounded-lg 
                                            active:bg-purple-200 focus:outline-none focus:shadow-outline-purple text-sm" aria-controls="accordionItemThree" 
                                  x-on:click="selectedAccordionItem = 'three'" x-bind:class="selectedAccordionItem === 'three' ? 'text-on-surface-strong dark:text-on-surface-dark-strong font-bold text-purple-600'  : 'text-on-surface dark:text-on-surface-dark font-medium dark:text-gray-300'" x-bind:aria-expanded="selectedAccordionItem === 'three' ? 'true' : 'false'">
                                          BARCODE* / Cantidad* / Costo Inicial*
                                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke="currentColor" class="size-5 shrink-0 transition" aria-hidden="true" x-bind:class="selectedAccordionItem === 'three'  ?  'rotate-180'  :  ''">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                      </svg>
                                  </button>
                                  <div x-cloak x-show="selectedAccordionItem === 'three'" id="accordionItemThree" role="region" aria-labelledby="controlsAccordionItemThree" x-collapse>
                                      <div class="p-2 text-sm sm:text-base text-pretty grid grid-cols-1 md:grid-cols-3">
                                            <input type="text" class="hidden" id="id_product_edit">

                                            <div class="p-2 w-full">
                                                    <p
                                                      class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                                                    >
                                                      BARCODE*
                                                    </p>
                                            
                                                    <input
                                                      class="w-full text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                                                        focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                                                        form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer"
                                                      placeholder="BARCODE"
                                                      id="barcode_edit"
                                                      type="text" 
                                                      name="barcode_edit"
                                                      pattern="[0-9a-zA-Z ]{3,}"
                                                      
                                                    />
                                                    <span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">
                                                      Solo puede introducir letras y números, mínimo 3 caracteres.
                                                    </span>
                                              </div>
                                              <div class="p-2 w-full">
                                                <p
                                                  class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                                                >
                                                  Cantidad*
                                                </p>
                                              
                                                  <input
                                                    class="w-full text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                                                      focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                                                      form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer"
                                                    placeholder="cantidad"
                                                    id="stock_edit"
                                                    type="text" 
                                                    name="stock_edit"
                                                    pattern="[0-9 ]{1,}"
                                                    onchange="cantidadSimple()"
                                                    
                                                  />
                                                  <span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">
                                                    Solo puede introducir números.
                                                  </span>
                                              </div>
                                              <div class="p-2 w-full">
                                                <p
                                                  class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                                                >
                                                  Costo inicial*
                                                </p>
                                              
                                                  <input
                                                    class="w-full text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                                                        focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                                                        form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer"
                                                    placeholder="Costo Inicial"
                                                    id="buy_price_edit"
                                                    type="text" 
                                                    name="buy_price_edit"
                                                    pattern="[0-9 \.]{1,}"
                                                    
                                                  />
                                                  <span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">
                                                    Solo puede introducir números.
                                                  </span>
                                              </div>


                                      </div>
                                  </div>
                              </div>

                              <div>
                                  <button id="controlsAccordionItemFour" type="button" class="text-sm mb-2 rounded-lg shadow-md flex w-full items-center justify-between gap-4 p-4 text-left border border-transparent rounded-lg 
                                            active:bg-purple-200 focus:outline-none focus:shadow-outline-purple" aria-controls="accordionItemFour" 
                                  x-on:click="selectedAccordionItem = 'four'" x-bind:class="selectedAccordionItem === 'four' ? 'text-on-surface-strong dark:text-on-surface-dark-strong font-bold text-purple-600'  : 'text-on-surface dark:text-on-surface-dark font-medium dark:text-gray-300'" x-bind:aria-expanded="selectedAccordionItem === 'four' ? 'true' : 'false'">
                                          Precio base* / Impuesto* / Precio final*
                                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke="currentColor" class="size-5 shrink-0 transition" aria-hidden="true" x-bind:class="selectedAccordionItem === 'four'  ?  'rotate-180'  :  ''">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                      </svg>
                                  </button>
                                  <div x-cloak x-show="selectedAccordionItem === 'four'" id="accordionItemFour" role="region" aria-labelledby="controlsAccordionItemFour" x-collapse>
                                      <div class="p-2 text-sm sm:text-base text-pretty rounded-lg shadow-md mb-2 grid grid-cols-1 md:grid-cols-3">
                                          <div class="text-sm p-2">
                                                    <p
                                                      class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                                                    >
                                                      Precio Base*
                                                    </p>
                                              
                                                  <input
                                                    class="w-full text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                                                      focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                                                      form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer"
                                                    placeholder="precio base"
                                                    id="precio_base_edit"
                                                    type="text" 
                                                    name="precio_base_edit"
                                                    pattern="[0-9 \.]{1,}"
                                                    onchange="updatePrecioBaseEdit()"
                                                    
                                                  />
                                                  <span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">
                                                    Solo puede introducir números.
                                                  </span>
                                          </div>
                                            
                                          <div class="text-sm p-2">
                                                    <p
                                                      class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                                                    >
                                                      Impuesto*
                                                    </p>
                                              <input id="validate_impuesto_edit" name="validate_impuesto_edit" class="hidden"/>
                                              <select class="cursor-pointer border rounded border-slate-200 p-2 pr-8 flex flex-col justify-center w-full items-center 
                                                      text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                                                      focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray"
                                                      onfocus='this.size=4;' onblur='this.size=0;' 
                                                      onchange='this.size=1; this.blur();'7
                                                      id="impuesto_edit"
                                                      name="impuesto_edit">
                                                      <option value="Ninguno (0%)" class="cursor-pointer hover:bg-purple-600" 
                                                              onclick="catchImpuestoEdit('Ninguno (0%)') ; updatePrecioImpuestoEdit()"
                                                              >Ninguno (0%)
                                                      </option>
                                                      <option value="IVA Exento - Exen (0.00%)" class="cursor-pointer hover:bg-purple-600"
                                                              onclick="catchImpuestoEdit('IVA Exento - Exen (0.00%)') ; updatePrecioImpuestoEdit()"
                                                              >IVA Exento - Exen (0.00%)
                                                      </option>
                                                      <option value="IVA Excluído - Excl (0.00%)" class="cursor-pointer hover:bg-purple-600"
                                                              onclick="catchImpuestoEdit('IVA Excluído - Excl (0.00%)') ; updatePrecioImpuestoEdit()"
                                                              >IVA Excluído - Excl (0.00%)
                                                      </option>
                                                      <option value="IVA (5.00%)" class="cursor-pointer hover:bg-purple-600"
                                                              onclick="catchImpuestoEdit('IVA (5.00%)') ; updatePrecioImpuestoEdit()"
                                                              >IVA (5.00%)
                                                      </option>
                                                      <option value="IVA (19.00%)" class="cursor-pointer hover:bg-purple-600"
                                                              onclick="catchImpuestoEdit('IVA (19.00%)') ; updatePrecioImpuestoEdit()"
                                                              >IVA (19.00%)ss
                                                      </option>
                                              </select>
                                          </div>

                                          <div class="text-sm p-2">
                                              <p
                                                class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                                              >
                                                Precio final*
                                              </p>
                                                <input
                                                  class="w-full text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                                                      focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                                                      form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer"
                                                  placeholder="introduzca nombre"
                                                  id="sell_price_edit"
                                                  type="text" 
                                                  name="sell_price_edit"
                                                  pattern="[0-9 \.]{1,}"
                                                  onchange="updatePrecioFinalEdit()"
                                                  
                                                />
                                              <span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">
                                                Solo puede introducir números.
                                              </span>
                                          </div>
                                      </div>
                                  </div>
                              </div>

                              <div>
                                  <button id="controlsAccordionItemFiveEdit" type="button" class="hidden text-sm mb-2 rounded-lg shadow-md flex w-full items-center justify-between gap-4 p-4 text-left border border-transparent
                                            active:bg-purple-200 focus:outline-none focus:shadow-outline-purple" aria-controls="accordionItemFive" 
                                  x-on:click="selectedAccordionItem = 'five'" x-bind:class="selectedAccordionItem === 'five' ? 'text-on-surface-strong dark:text-on-surface-dark-strong font-bold text-purple-600'  : 'text-on-surface dark:text-on-surface-dark font-medium dark:text-gray-300'" x-bind:aria-expanded="selectedAccordionItem === 'five' ? 'true' : 'false'">
                                          Combo
                                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke="currentColor" class="size-5 shrink-0 transition" aria-hidden="true" x-bind:class="selectedAccordionItem === 'five'  ?  'rotate-180'  :  ''">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                      </svg>
                                  </button>
                                  <div x-cloak x-show="selectedAccordionItem === 'five'" id="accordionItemFour" role="region" aria-labelledby="controlsAccordionItemFour" x-collapse>
                                      <div x-data="{dataz: [], counter: 0}" class="rounded-lg shadow-md mb-2" >
                                          <div class="max-h-48 overflow-y-auto scroll-smooth flex flex-col-reverse">                                                  
                                            <template x-for="(item, index) in dataz" :key="index" x-transition>
                                              <div>
                                                  <div class="p-2 text-sm sm:text-base text-pretty mb-2 grid grid-cols-4 sm-grid-cols-3">
                                                    <div class="text-sm p-2 jz-center jz-hide-small">
                                                          <button type="button"class="p-2 rounded shadow borderjz-display-middle text-purple-600 dark:gray-300 mb-2">
                                                            <i class="fa fa-tag fa-2x" aria-hidden="true"></i>
                                                          </button>
                                                    </div>
                                                    <div class="text-sm p-2">
                                                        <div class="inline-block relative w-full" x-id="['comboProduct']">
                                                              <span class="flex dark:text-gray-300">Producto</span>
                                                              <select class="cursor-pointer border rounded border-slate-200 p-2 flex flex-col justify-center w-full items-center 
                                                                  text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                                                                  focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray"
                                                                  onfocus='this.size=4;' onblur='this.size=0;' 
                                                                  onchange='this.size=1; this.blur();'7
                                                                  :id="$id('comboProduct')"
                                                                  :name="$id('comboProduct')">
                                                                  @foreach($products as $item)
                                                                      <option value="{{$item->id}}" class="cursor-pointer hover:bg-purple-600">{{$item->title}}</option>
                                                                  @endforeach
                                                              </select>
                                                        </div>
                                                    </div>
                                                    <div class="text-sm p-2 jz-center" x-id="['comboCant']">
                                                      <span class="flex dark:text-gray-300">Cantidad</span>
                                                        <input
                                                            class="w-full text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                                                                focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                                                                form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer"
                                                            placeholder="Cantidad"
                                                            :id="$id('comboCant')"
                                                            :name="$id('comboCant')"
                                                            pattern="[0-9 \.]{1,}"

                                                            
                                                          />
                                                        <span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">
                                                          Solo puede introducir números.
                                                        </span>
                                                    </div>
                                                    <div class="text-sm p-2 jz-center">
                                                            <button type="button" class="p-2 rounded shadow borderjz-display-middle text-purple-600 dark:gray-300 mb-2"
                                                                    @click="dataz.splice(index, 1)"
                                                                  >
                                                                  <i class="fa fa-trash fa-2x" aria-hidden="true"></i>
                                                            </button>
                                                    </div>
                                                  </div>
                                              </div>
                                            </template>
                                         </div>
                                          <button
                                            class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-purple-600 active:text-white active:bg-purple-600 
                                                    focus:outline-none focus:shadow-outline-purple border border-transparent rounded-lg ml-px"
                                            type="button"
                                            @click="dataz.push({ randomNumber: Math.floor(Math.random() * 20) })"
                                          > Agrega productos a tu combo
                                          </button>
                                      </div>
                                    </div>
                               </div>
                          </div>
                          <!-- end simple form -->


                          <!-- init second accordion -->
                          <div x-data="{ selectedAccordionItem: 'one' }" class="w-full divide-y divide-outline overflow-hidden rounded-sm hidden" id="advanced_form_edit">
                              <div class="flex justify-between items-center pb-3 dark:bg-gray-800">
                                <p class="text-xl font-bold text-gray-500 p-2 mb-3 hidden" id="advanced_title_edit">Formulario Avanzado de Edición de Productos</p>
                                <p class="text-xl font-bold text-gray-500 p-2 mb-3" id="servicio_advanced_title_edit">Formulario Avanzado de Edición de Servicios</p>
                                <p class="text-xl font-bold text-gray-500 p-2 mb-3 hidden" id="combo_advanced_title_edit">Formulario Avanzado de Edición de Combos</p>
                                <div class="modal-close cursor-pointer z-50" onclick="modalClose('editProduct')">
                                  <svg class="fill-current text-gray-500" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 18 18">
                                    <path
                                      d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
                                    </path>
                                </svg>
                                </div>
                              </div>
                              <div>
                                  <button id="controlsAccordionItemOne" type="button" class="text-sm rounded-lg shadow-md flex w-full items-center justify-between gap-4 p-4 text-left border border-transparent rounded-lg 
                                            active:bg-purple-200 focus:outline-none focus:shadow-outline-purple" aria-controls="accordionItemOne" x-on:click="selectedAccordionItem = 'one'" 
                                  x-bind:class="selectedAccordionItem === 'one' ? 'text-on-surface-strong dark:text-on-surface-dark-strong font-bold text-purple-600'  : 'text-on-surface dark:text-on-surface-dark font-medium dark:text-gray-300'" x-bind:aria-expanded="selectedAccordionItem === 'one' ? 'true' : 'false'">
                                      Imagen del Producto
                                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke="currentColor" class="size-5 shrink-0 transition" aria-hidden="true" x-bind:class="selectedAccordionItem === 'one'  ?  'rotate-180'  :  ''">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                      </svg>
                                  </button>
                                  <div x-cloak x-show="selectedAccordionItem === 'one'" classs="max-w-24" id="accordionItemOne" role="region" aria-labelledby="controlsAccordionItemOne" x-collapse>
                                        <div class="flex items-center justify-center">
                                              <div class="image-container rounded-lg">
                                                    
                                                  <label for="image_edit">
                                                  <img id="output_image_edit" class="hidden cursor-pointer image-size"\>
                                                  <div id="inputImageEdit" class="flex w-full h-full flex-col justify-center items-center cursor-pointer">
                                                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="tabler-icon tabler-icon-tag s-icon medium     icon-secondary icon x4 mb-2 pointer ">
                                                      <path d="M7.5 7.5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0">
                                                      </path>
                                                      <path d="M3 6v5.172a2 2 0 0 0 .586 1.414l7.71 7.71a2.41 2.41 0 0 0 3.408 0l5.592 -5.592a2.41 2.41 0 0 0 0 -3.408l-7.71 -7.71a2 2 0 0 0 -1.414 -.586h-5.172a3 3 0 0 0 -3 3z">
                                                      </path>
                                                      </svg>
                                                      <p class="text-gray-500">Imagen del producto</p>
                                                  </div>
                                                </label>
                                                  <input 
                                                    onchange="preview_image_edit(event)"
                                                    id="image_edit" name="image_edit"
                                                    type="file" class="w-full h-full hidden" 
                                                    accept=".jpg, .png, .jpeg" value="">
                                                  
                                              </div>
                                        </div>
                                  </div>
                              </div>
                              <div>
                                  <button id="controlsAccordionItemTwo" type="button" class="text-sm rounded-lg shadow-md flex w-full items-center justify-between gap-4 p-4 text-left border border-transparent rounded-lg 
                                            active:bg-purple-200 focus:outline-none focus:shadow-outline-purple" aria-controls="accordionItemTwo" x-on:click="selectedAccordionItem = 'two'" 
                                  x-bind:class="selectedAccordionItem === 'two' ? 'text-on-surface-strong dark:text-on-surface-dark-strong font-bold text-purple-600'  : 'text-on-surface dark:text-on-surface-dark font-medium dark:text-gray-300'" x-bind:aria-expanded="selectedAccordionItem === 'two' ? 'true' : 'false'">
                                          Descripción
                                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke="currentColor" class="size-5 shrink-0 transition" aria-hidden="true" x-bind:class="selectedAccordionItem === 'two'  ?  'rotate-180'  :  ''">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                      </svg>
                                  </button> 
                                  <div x-cloak x-show="selectedAccordionItem === 'two'" id="accordionItemTwo" role="region" aria-labelledby="controlsAccordionItemTwo" x-collapse>
                                      <div class="p-2 text-sm sm:text-base text-pretty">
                                              <div class="text-sm p-2 w-full">
                                                  <textarea
                                                    class="w-full text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                                                        focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray"
                                                    placeholder="introduzca descripción"
                                                    id="description_edit"
                                                    type="text" 
                                                    name="description_edit"
                                                    pattern="[0-9 \.]{1,}"
                                                    
                                                  ></textarea>
                                              </div>
                                            </div>
                                          </div>
                                      </div>
                                    <div>
                                        <button id="controlsAccordionItemThree" type="button" class="rounded-lg shadow-md flex w-full items-center justify-between gap-4 p-4 text-left border border-transparent rounded-lg 
                                                  active:bg-purple-200 focus:outline-none focus:shadow-outline-purple text-sm" aria-controls="accordionItemThree" 
                                        x-on:click="selectedAccordionItem = 'three'" x-bind:class="selectedAccordionItem === 'three' ? 'text-on-surface-strong dark:text-on-surface-dark-strong font-bold text-purple-600'  : 'text-on-surface dark:text-on-surface-dark font-medium dark:text-gray-300'" x-bind:aria-expanded="selectedAccordionItem === 'three' ? 'true' : 'false'">
                                                  Detalles de Inventario
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke="currentColor" class="size-5 shrink-0 transition" aria-hidden="true" x-bind:class="selectedAccordionItem === 'three'  ?  'rotate-180'  :  ''">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                            </svg>
                                        </button>
                                        <div x-cloak x-show="selectedAccordionItem === 'three'" id="accordionItemThree" role="region" aria-labelledby="controlsAccordionItemThree" x-collapse>
                                            <div class="p-2 text-sm sm:text-base text-pretty grid grid-cols-1 md:grid-cols-3">

                                                    <div class="p-2 w-full">
                                                      <p
                                                        class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                                                      >
                                                        Cantidad*
                                                      </p>
                                                    
                                                        <input
                                                          class="w-full text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                                                              focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                                                              form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer"
                                                          placeholder="cantidad"
                                                          id="cantidad_advanced_edit"
                                                          type="text" 
                                                          name="cantidad_advanced_edit"
                                                          pattern="[0-9 ]{1,}"
                                                          onchange="cantidadAdvanced()"
                                                          
                                                        />
                                                        <span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">
                                                          Solo puede introducir números.
                                                        </span>
                                                    </div>
                                                    <div class="p-2 w-full">
                                                      <p
                                                        class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                                                      >
                                                        Cantidad mínima
                                                      </p>
                                                    
                                                        <input
                                                            class="w-full text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                                                              focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                                                              form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer"
                                                          placeholder="cantidad mínima"
                                                          id="cantidad_minima_edit"
                                                          type="text" 
                                                          name="cantidad_minima_edit"
                                                          pattern="[0-9 ]{1,}"
                                                          
                                                        />
                                                        <span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">
                                                          Solo puede introducir números.
                                                        </span>
                                                    </div>
                                                    <div class="p-2 w-full">
                                                      <p
                                                        class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                                                      >
                                                        Cantidad máxima
                                                      </p>
                                                    
                                                        <input
                                                          class="w-full text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                                                              focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                                                              form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer"
                                                          placeholder="cantidad maxima"
                                                          id="cantidad_maxima_edit"
                                                          type="text" 
                                                          name="cantidad_maxima_edit"
                                                          pattern="[0-9 ]{1,}"
                                                          
                                                        />
                                                        <span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">
                                                          Solo puede introducir números.
                                                        </span>
                                                    </div>


                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <button id="controlsAccordionItemFour" type="button" class="text-sm mb-2 rounded-lg shadow-md flex w-full items-center justify-between gap-4 p-4 text-left border border-transparent rounded-lg 
                                                  active:bg-purple-200 focus:outline-none focus:shadow-outline-purple" aria-controls="accordionItemFour" 
                                        x-on:click="selectedAccordionItem = 'four'" x-bind:class="selectedAccordionItem === 'four' ? 'text-on-surface-strong dark:text-on-surface-dark-strong font-bold text-purple-600'  : 'text-on-surface dark:text-on-surface-dark font-medium dark:text-gray-300'" x-bind:aria-expanded="selectedAccordionItem === 'four' ? 'true' : 'false'">
                                                Adicionales
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke="currentColor" class="size-5 shrink-0 transition" aria-hidden="true" x-bind:class="selectedAccordionItem === 'four'  ?  'rotate-180'  :  ''">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                            </svg>
                                        </button>
                                        <div x-cloak x-show="selectedAccordionItem === 'four'" id="accordionItemFour" role="region" aria-labelledby="controlsAccordionItemFour" x-collapse>
                                            <div class="p-2 text-sm sm:text-base text-pretty rounded-lg shadow-md mb-2 grid grid-cols-1 md:grid-cols-3">
                                                      
                                                



                                                  <div class="text-sm p-2 flex m-8 marginNegative dark:text-gray-300">
                                                          <span class="flex-row">Venta en Negativo</span>
                                            
                                                      <div class="relative w-fit mr-3">
                                                          <div class="peer" aria-describedby="tooltipExample">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9333ea" class="size-6">
                                                              <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                                                            </svg>
                                                        </div>
                                                          <div id="tooltipExample" class="absolute -top-9 left-1/2 -translate-x-1/2 z-10 whitespace-nowrap rounded 
                                                          bg-purple-600 px-2 py-1 text-center text-white text-sm text-on-surface-dark-strong opacity-0 transition-all ease-out 
                                                          peer-hover:opacity-100 peer-focus:opacity-100 dark:bg-surface dark:text-on-surface-strong dark:text-gray-300" role="tooltip">
                                                          Vende sin unidades disponibles</div>
                                                      </div>
                                                      <div class="relative inline-block w-11 h-5 flex-row">
                                                        <input id="venta_negativo_edit" value="venta_negativo" name="venta_negativo_edit" type="checkbox" class="peer appearance-none w-11 h-5 bg-slate-100 rounded-full 
                                                        checked:bg-purple-600 cursor-pointer transition-colors duration-300" />
                                                        <label for="venta_negativo_edit" class="absolute top-0 left-0 w-5 h-5 bg-white rounded-full border border-slate-300 shadow-sm 
                                                        transition-transform duration-300 peer-checked:translate-x-6 peer-checked:border-slate-800 cursor-pointer">
                                                        </label>
                                                      </div>

                                                  </div>
                                                  <div class="text-sm p-2">
                                                      <div class="inline-block relative w-full dark:text-gray-300">
                                                            <span class="flex">Categoría

                                                            <div x-data="{ showTooltip: false }" class="relative w-fit -mt-3">
                                                                <button x-on:click="showTooltip = !showTooltip" type="button" class="rounded-radius bg-surface-alt px-2 py-2 
                                                                font-medium tracking-wide text-on-surface focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary 
                                                                dark:bg-surface-dark-alt dark:border-surface-dark-alt dark:text-on-surface-dark dark:focus-visible:outline-primary-dark" 
                                                                aria-describedby="tooltipExample">
                                                                  <box-icon name='plus-circle' color="#9333ea"></box-icon>
                                                                </button>
                                                                <div 
                                                                style="margin-left: -100px";
                                                                x-cloak x-show="showTooltip" x-on:click.outside="showTooltip = false" id="tooltipExample" 
                                                                class="absolute rounded -top-3 text-white z-10 -ml-30 bg-purple-600 whitespace-nowrap rounded-sm bg-surface-dark px-2 py-1 text-center 
                                                                text-sm text-on-surface-dark-strong dark:bg-surface dark:text-on-surface-strong" role="tooltip" x-transition:enter="transition ease-out" 
                                                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out" 
                                                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">Crea categorías para organizar tus productos.<br>
                                                                  
                                                                    <button type="button" onclick="location.href='categories';" 
                                                                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-1 px-2 rounded inline-flex items-center">
                                                                            <box-icon name='door-open'></box-icon>
                                                                            <span>Crear Categoría</span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                          
                                                            </span>
                                                          <select class="cursor-pointer border rounded border-slate-200 p-2 pr-8 flex flex-col justify-center w-full items-center 
                                                              text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                                                              focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray dark:text-gray-300"
                                                              onfocus='this.size=4;' onblur='this.size=0;' 
                                                              onchange='this.size=1; this.blur();'7
                                                              id="categoria_edit"
                                                              name="categoria_edit">
                                                              <option value="">Vacío</option>
                                                              @foreach($categories as $item)
                                                                  <option value="{{$item->id}}" class="cursor-pointer hover:bg-purple-600">{{$item->name}}</option>
                                                              @endforeach
                                                          </select>
                                                      </div>
                                                  </div>

                                                  <div class="text-sm p-2">
                                                      <div class="inline-block relative w-full dark:text-gray-300">
                                                        <span class="flex">Códigos UNSPSC
                                                            <div x-data="{ showTooltip: false }" class="relative w-fit -mt-3">
                                                                <button x-on:click="showTooltip = !showTooltip" type="button" class="rounded-radius bg-surface-alt px-2 py-2 
                                                                font-medium tracking-wide text-on-surface focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary 
                                                                dark:bg-surface-dark-alt dark:border-surface-dark-alt dark:text-on-surface-dark dark:focus-visible:outline-primary-dark" 
                                                                aria-describedby="tooltipExample">
                                                                  <box-icon name='plus-circle' color="#9333ea"></box-icon>
                                                                </button>
                                                                <div 
                                                                style="margin-left: -130px";
                                                                x-cloak x-show="showTooltip" x-on:click.outside="showTooltip = false" id="tooltipExample" 
                                                                class="absolute rounded -top-3 text-white z-10 mr-9 bg-purple-600 whitespace-nowrap rounded-sm bg-surface-dark px-2 py-1 text-center 
                                                                text-sm text-on-surface-dark-strong dark:bg-surface dark:text-on-surface-strong" role="tooltip" x-transition:enter="transition ease-out" 
                                                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out" 
                                                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">Es un campo obligatorio si generas <br>facturas electrónicas. <br>
                                                                    <button type="button" onclick="location.href='codigo';"
                                                                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-1 px-2 rounded 
                                                                            inline-flex items-center text-sm">
                                                                            <box-icon name='door-open'></box-icon>
                                                                            <span class="text-sm ">Crear Código</span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </span>
                                                        
                                                          <select class="cursor-pointer border rounded border-slate-200 p-2 pr-8 flex flex-col justify-center w-full items-center 
                                                              text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                                                              focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray dark:text-gray-300"
                                                              onfocus='this.size=4;' onblur='this.size=0;' 
                                                              onchange='this.size=1; this.blur();'
                                                              id="codigo_unspsc_edit"
                                                              name="codigo_unspsc_edit">
                                                              <option value="">Vacío</option>
                                                              @foreach($codigos as $item)
                                                                  <option value="{{$item->id}}" class="cursor-pointer hover:bg-purple-600">{{$item->codigo}} - {{$item->name}}</option>
                                                              @endforeach
                                                          </select>
                                                      </div>
                                                  </div>




                                            </div>
                                        </div>
                                    </div>
                                  
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
                          </div>
                      </form>
                      <div class="flex justify-end px-4 py-2 space-x-4 text-sm">
                          <button
                                  class="px-4 py-2 text-sm font-medium leading-5 text-black 
                                      transition-colors duration-150 bg-slate-200 border rounded-lg"
                                  onclick="showAdvancedEdit()"
                                  id="advanced_button_edit"
                                >Formulario Avanzado
                          </button>
                          <button
                                  class="px-4 py-2 text-sm font-medium leading-5 text-black 
                                      transition-colors duration-150 bg-slate-200 border rounded-lg hidden"
                                  onclick="showSimpleEdit()"
                                  id="simple_button_edit"
                                >Formulario Simple
                          </button>
                          <div>
                            <button 
                                class="px-4 py-2 text-sm font-medium leading-5 text-white 
                                          transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg 
                                          active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple
                                          disabled"
                                onclick="submitEditProd()"
                                
                                >Editar
                            </button>
                          </div>
                        
                      </div>
                    </div>
                </div>
              </div>
          </div>
          <!-- end edit product modal -->
</div>
<!-- end principal div -->
<script>
  document.addEventListener("DOMContentLoaded", function(event) {
            setTimeout(() => loader.style.display = 'none', 100);
            var filtroProductos = document.getElementById('filtroProductos')
            filtroProductos.classList.remove('hidden')

            JsBarcode(".barcode").init();

            document.onkeypress = function (e) {
                e = e || window.event;
                if (e.key === '*') {
                  OpenSearchFilter()
                }
                // use e.keyCode
            };

            // JsBarcode(text, barcodeData);
        });
  function catchCategories(item){
    console.log(item.id)
    document.getElementById('categorie').value = item.name
  }
</script>
  <script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('combobox', (comboboxData = {
            allOptions: [],
        },) => ({
            options: comboboxData.allOptions,
            isOpen: false,
            openedWithKeyboard: false,
            selectedOption: null,
            setSelectedOption(option) {
                this.selectedOption = option
                this.isOpen = false
                this.openedWithKeyboard = false
                this.$refs.hiddenTextField.value = option.value
            },
            getFilteredOptions(query) {
                this.options = comboboxData.allOptions.filter((option) =>
                    option.label.toLowerCase().includes(query.toLowerCase()),
                )
                if (this.options.length === 0) {
                    this.$refs.noResultsMessage.classList.remove('hidden')
                } else {
                    this.$refs.noResultsMessage.classList.add('hidden')
                }
            },
            // if the user presses backspace or the alpha-numeric keys, focus on the search field
            handleKeydownOnOptions(event) {
                if ((event.keyCode >= 65 && event.keyCode <= 90) || (event.keyCode >= 48 && event.keyCode <= 57) || event.keyCode === 8) {
                    this.$refs.searchField.focus()
                }
            },
        }))
    })
</script>
<script>

function filtrarCategoria(){
        var filtroCategoria = document.getElementById('filtroCategoria')
        var searchFilter = document.getElementById('searchFilter')
        filtroCategoria.setAttribute("style", "opacity: 1;")
        searchFilter.classList.add('hidden')
        filtroCategoria.classList.remove('hidden')
        filtroCategoria.innerHTML =
          '<span class="flex-row w-full p-2 text-purple-600 text-center">Filtrar por categorías:</span>'+ 
          '<select class="capitalize text-purple-600 border-purple-400 cursor-pointer border rounded p-2 pr-8 flex-row text-center justify-center w-full items-center text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray" onfocus="this.size=4;" onblur="this.size=0;" onchange="this.size=1; this.blur();" id="categoria" name="categoria">'+
            '@foreach($categories as $item)'+
            '<option value="{{$item->id}}" class="cursor-pointer hover:bg-purple-400" onclick="doitFilterCategory({{$item->id}})">{{$item->name}}</option>'+
            '@endforeach'+
          '</select>'
      
      }

      function doitFilterCategory(idCat){
        console.log(idCat, 'idCat')
        axios.post('findCatService', {
                      q: idCat
                    })
                    .then(function (response) {
                      if (response.data == 'no'){
                        Swal.fire({
                                  title: 'Error!',
                                  text: 'Categoría no asignada a algún servicio.',
                                  icon: 'error',
                                  timer: 2000,
                                  showConfirmButton: false,
                              });
                              return
                      }
                      if(response.data !== 'no' && response.data[0] !== ''){
                        window.location.href = 'servicios?q=' + idCat
                        return
                      }
                      
                      console.log(response.data, 'response')
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
                              return
                      }
                      
                    });
      }

      function OpenSearchFilter(){
        var inputFilter = document.getElementById('searchQ')
        var searchFilter = document.getElementById('searchFilter')
        var filtroCategoria = document.getElementById('filtroCategoria')
        filtroCategoria.classList.add('hidden')
        searchFilter.classList.remove('hidden')

        var openSearchFilter = document.getElementById('OpenSearchFilter')
        var buttonSearchNombre = document.getElementById('buttonSearchNombre')
        var screenWidth = window.screen.width
        

        if(screenWidth < 600){

          searchFilter.setAttribute("style", "width: 250px;")
          inputFilter.classList.remove('hidden')
          buttonSearchNombre.classList.remove('hidden')
          buttonSearchNombre.setAttribute("style", "max-width: 74px;")
          searchFilter.classList.add('mr-5')
          searchFilter.classList.add('mt-2')
          setTimeout(() => inputFilter.focus(), 500)
          inputFilter.addEventListener('keydown', (event) => {
            if (event.key === 'Enter') {
              doitSearch()
              // Perform desired actions here
            }
          })

        }else{

          searchFilter.setAttribute("style", "width: 300px;")
          inputFilter.classList.remove('hidden')
          buttonSearchNombre.classList.remove('hidden')
          searchFilter.classList.add('mr-5')
          setTimeout(() => inputFilter.focus(), 500)

          inputFilter.addEventListener('keydown', (event) => {
            if (event.key === 'Enter') {
              doitSearch()
              // Perform desired actions here
            }
          })

        }

      }

      function doitSearch(){
        var searchQ = document.getElementById('searchQ').value
        if(searchQ !== ''){
          axios.post('searchNameServicio', {
                      q: searchQ
                    })
                    .then(function (response) {
                      if (response.data == 'no'){
                        Swal.fire({
                                  title: 'Error!',
                                  text: 'Servicio no encontrado.',
                                  icon: 'error',
                                  timer: 2000,
                                  showConfirmButton: false,
                              });
                              return
                      }
                      if(!response.data){
                        Swal.fire({
                                  title: 'Error!',
                                  text: 'Servicio no encontrado.',
                                  icon: 'error',
                                  timer: 2000,
                                  showConfirmButton: false,
                              });
                              return
                      }
                      if(response.data !== 'no' && response.data[0] !== ''){
                        window.location.href = 'servicios?q=' + searchQ
                        return
                      }
                      
                      console.log('Comuniquese con el administrador del sistema')
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
                              return
                      }
                      
                    });
              }else{
                
                  Swal.fire({
                  title: 'Error!',
                  text: 'Input no puede estar vacío.',
                  icon: 'error',
                  timer: 2000,
                  showConfirmButton: false,
                  });
                  return
              }
        
                     
                    
         }

      function filterCombos(){
        var productosCreados = document.getElementById('search')
        var serviciosCreados = document.getElementById('serviciosCreados')
        var combosCreados = document.getElementById('combosCreados')
        var titleProductos = document.getElementById('titleProductos')
        var titleServicios = document.getElementById('titleServicios')
        var titleCombos = document.getElementById('titleCombos')
        titleProductos.classList.add('hidden')
        titleCombos.classList.remove('hidden')
        productosCreados.classList.add('hidden')
        combosCreados.classList.remove('hidden')
      }

      function comboProducts() {
              console.log('entesr')
              document.getElementById('comboProducts').innerHTML = 
                    '<div class="rounded-lg shadow-md mb-2">' +
                        '<div class="p-2 text-sm sm:text-base text-pretty mb-2 grid grid-cols-4">' +
                          '<div class="text-sm p-2 relative jz-center">' +
                                '<button type="button"class="p-2 rounded shadow border jz-display-middle">' +
                                    '<box-icon name="purchase-tag-alt"></box-icon>' +
                                '</button>' +
                          '</div>' +
                          '<div class="text-sm p-2">' +
                                  '<div class="dataProductoCombo">' +
                                      '<p class="flex flex-col">nombre</p>' +
                                      '<p class="flex flex-col">precio</p>' +
                                  '</div>' +
                          '</div>' +
                          '<div class="text-sm p-2 jz-center">' +
                              '<p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">' +
                                'Cantidassd</p>' +
                                '<input class="w-full text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer" placeholder="cantidad" id="cantidadCombo" type="text" name="cantidadCombo" pattern="[0-9 \.]{1,}"/>' +
                                  '<span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">' +
                                    'Solo puede introducir números.</span>' +
                          '</div>' +
                          '<div class="text-sm p-2 relative jz-center">' +
                                '<button type="button" class="p-2 rounded shadow border jz-display-middle">' +
                                  '<box-icon name="trash" class=""></box-icon>' +
                                '</button>' +
                          '</div>' +
                        '</div>' +
                        '<div id="addNewRowCombo">' +
                        '</div>' +
                        '<button type="button" onclick="addNewRowCombo()" class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-purple-600">' +
                        'Agrega producto</button>' +
                    '</div>'
                    

           
                    
        
              }

        function addRowComboProd() {
              console.log('enter')
              document.getElementById('comboProducts').innerHTML = 
                    '<div>' +
                        '<div class="p-2 text-sm sm:text-base text-pretty mb-2 grid grid-cols-4">' +
                          '<div class="text-sm p-2 relative jz-center">' +
                                '<button type="button"class="p-2 rounded shadow border jz-display-middle">' +
                                    '<box-icon name="purchase-tag-alt"></box-icon>' +
                                '</button>' +
                          '</div>' +
                          '<div class="text-sm p-2">' +
                                  '<div class="dataProductoCombo">' +
                                      '<p class="flex flex-col">nombre</p>' +
                                      '<p class="flex flex-col">precio</p>' +
                                  '</div>' +
                          '</div>' +
                          '<div class="text-sm p-2 jz-center">' +
                              '<p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">' +
                                'Cantidad</p>' +
                                '<input class="w-full text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer" placeholder="cantidad" id="cantidadCombo" type="text" name="cantidadCombo" pattern="[0-9 \.]{1,}"/>' +
                                  '<span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">' +
                                    'Solo puede introducir números.</span>' +
                            '</div>' +
                            '<div class="text-sm p-2 relative jz-center">' +
                                  '<button type="button" class="p-2 rounded shadow border jz-display-middle">' +
                                    '<box-icon name="trash" class=""></box-icon>' +
                                  '</button>' +
                            '</div>' +
                        '</div>' +
                    '</div>' 
        
              }

        
          
        function addNewRowCombo(){
          console.log('que jue')
          const ALL_WORDS = ['spam', 'egg', 'apple', 'donut', 'coffee'];
          const NUM_WORDS = ALL_WORDS.length;

         

          const allSpans = [];

      
          const textDiv = document.getElementById('addNewRowCombo');
          const newSpan = document.createElement('div');
          let x = 1;
          const y = x++;
          newSpan.innerHTML = 
                          '<div>' +
                              '<div class="p-2 text-sm sm:text-base text-pretty mb-2 grid grid-cols-4">' +
                                '<div class="text-sm p-2 relative jz-center">' +
                                      '<button type="button"class="p-2 rounded shadow border jz-display-middle">' +
                                          '<box-icon name="purchase-tag-alt"></box-icon>' +
                                      '</button>' +
                                '</div>' +
                                '<div class="text-sm p-2">' +
                                        '<div class="dataProductoCombo">' +
                                            '<p class="flex flex-col">nombre</p>' +
                                            '<p class="flex flex-col">precio</p>' +
                                        '</div>' +
                                '</div>' +
                                '<div class="text-sm p-2 jz-center">' +
                                    '<p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">' +
                                      'Cantidad</p>' +
                                      '<input class="w-full text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer" placeholder="cantidad" id="cantidadComboLoop" type="text" name="data'+y+'" pattern="[0-9 \.]{1,}"/>' +
                                        '<span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">' +
                                          'Solo puede introducir números.</span>' +
                                  '</div>' +
                                  '<div class="text-sm p-2 relative jz-center">' +
                                        '<button type="button" class="p-2 rounded shadow border jz-display-middle">' +
                                          '<box-icon name="trash" class=""></box-icon>' +
                                        '</button>' +
                                  '</div>' +
                              '</div>' +
                          '</div>'
                          
                      allSpans.push(newSpan);
                      
            textDiv.appendChild(newSpan);
            
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
            output.classList.remove("hidden");
            output.classList.add("block");
            inputImageEdit.classList.add("hidden");
            output.src = reader.result;
             // set the result of the reader as the src of the node
          }
          reader.readAsDataURL(event.target.files[0]); // now start the reader
        }
        
      function cantidadSimple(){
        var cantidad = document.getElementById('cantidad').value
        document.getElementById('cantidadAdvanced').value = cantidad
      }

      function cantidadAdvanced(){
        var cantidadAdvanced = document.getElementById('cantidadAdvanced').value
        document.getElementById('cantidad').value = cantidadAdvanced
      }

      function showAdvanced(){
        var advanced_form = document.getElementById('advanced_form')
        var simple_form = document.getElementById('simple_form')
        var simple_button = document.getElementById('simple_button')
        var advanced_button = document.getElementById('advanced_button')

        simple_button.classList.remove("hidden");
        advanced_form.classList.remove("hidden");
        advanced_form.classList.add("animate-bounce");
        simple_form.classList.add("hidden");
        advanced_button.classList.add("hidden");
        console.log('termina avanzado')

        setTimeout(() => 
        advanced_form.classList.remove("animate-bounce"), 200
        )
       
        
      }

      function showAdvancedEdit(){
        var advanced_form_edit = document.getElementById('advanced_form_edit')
        var simple_form_edit = document.getElementById('simple_form_edit')
        var simple_button_edit = document.getElementById('simple_button_edit')
        var advanced_button_edit = document.getElementById('advanced_button_edit')
        var simple_title_edit = document.getElementById('simple_title_edit')
        var advanced_title_edit = document.getElementById('advanced_title_edit')

        var servicio_advanced_title_edit =  document.getElementById("servicio_advanced_title_edit")
        var servicio_basic_title_edit =  document.getElementById("servicio_basic_title_edit")
        var combo_basic_title_edit =  document.getElementById("combo_basic_title_edit")
        var combo_advanced_title_edit =  document.getElementById("combo_advanced_title_edit")

        simple_button_edit.classList.remove("hidden");
        advanced_form_edit.classList.remove("hidden");
        advanced_form_edit.classList.add("animate-bounce");
        simple_form_edit.classList.add("hidden");
        advanced_button_edit.classList.add("hidden");

        setTimeout(() => 
          advanced_form_edit.classList.remove("animate-bounce"), 200
        )
       
        
      }

      function showSimple(){
        var advanced_form = document.getElementById('advanced_form')
        var simple_form = document.getElementById('simple_form')
        var simple_button = document.getElementById('simple_button')
        var advanced_button = document.getElementById('advanced_button')

        simple_form.classList.remove("hidden");
        simple_form.classList.add("animate-bounce");
        advanced_button.classList.remove("hidden");
        simple_button.classList.add("hidden");
        advanced_form.classList.add("hidden");

        setTimeout(() => 
          simple_form.classList.remove("animate-bounce"), 200
        )
            
      }

      function showSimpleEdit(){
        var advanced_form_edit = document.getElementById('advanced_form_edit')
        var simple_form_edit = document.getElementById('simple_form_edit')
        var simple_button_edit = document.getElementById('simple_button_edit')
        var advanced_button_edit = document.getElementById('advanced_button_edit')
        var simple_title_edit = document.getElementById('simple_title_edit')
        var advanced_title_edit = document.getElementById('advanced_title_edit')

        simple_form_edit.classList.remove("hidden");
        simple_form_edit.classList.add("animate-bounce");
        advanced_button_edit.classList.remove("hidden");
        simple_button_edit.classList.add("hidden");
        advanced_form_edit.classList.add("hidden");

        setTimeout(() => 
          simple_form_edit.classList.remove("animate-bounce"), 200
        )
            
      }

      function selectBarcode2(){
        document.getElementById("barcode").value = document.getElementById("barcode2").value
      }

      function selectServicio(){
          var controlsAccordionItemThreeAdd =  document.getElementById("controlsAccordionItemThreeAdd")
          var controlsAccordionItemFiveAdd =  document.getElementById("controlsAccordionItemFiveAdd")
          var servicio_advanced_title =  document.getElementById("servicio_advanced_title")
          var servicio_basic_title =  document.getElementById("servicio_basic_title")
          var simple_title =  document.getElementById("simple_title")
          var advanced_title =  document.getElementById("advanced_title")
          var combo_basic_title =  document.getElementById("combo_basic_title")
          var combo_advanced_title =  document.getElementById("combo_advanced_title")

           document.getElementById("cantidad").value = 1
           document.getElementById("costoInicial").value = 1

          var barcode =  document.getElementById("barcode").value
          var barcode2 =  document.getElementById("barcode2").value
          var barcode2Span =  document.getElementById("barcode2Span")
          var barcode2Div =  document.getElementById("barcode2Div")
          var barcodeSpan =  document.getElementById("barcodeSpan")
          var divNombreUnidad =  document.getElementById("divNombreUnidad")
          

          // init AccordionItemThreeAdd validatiion
          controlsAccordionItemThreeAdd.classList.add("hidden")
          combo_advanced_title.classList.add("hidden")
          combo_basic_title.classList.add("hidden")
          simple_title.classList.add("hidden")
          advanced_title.classList.add("hidden")
          servicio_advanced_title.classList.remove("hidden")
          servicio_basic_title.classList.remove("hidden")
          barcode2Span.classList.remove("hidden")
          barcode2Div.classList.remove("hidden")
          barcodeSpan.classList.add("hidden")
          divNombreUnidad.classList.add("md:grid-cols-3")
          divNombreUnidad.classList.remove("md:grid-cols-2")
          

      }

      function selectServicioEdit(){
          var controlsAccordionItemThreeEdit =  document.getElementById("controlsAccordionItemThreeEdit")
          var controlsAccordionItemFiveEdit =  document.getElementById("controlsAccordionItemFiveEdit")
          var servicio_advanced_title_edit =  document.getElementById("servicio_advanced_title_edit")
          var servicio_basic_title_edit =  document.getElementById("servicio_basic_title_edit")
          var simple_title_edit =  document.getElementById("simple_title_edit")
          var advanced_title_edit =  document.getElementById("advanced_title_edit")
          var combo_basic_title_edit =  document.getElementById("combo_basic_title_edit")
          var combo_advanced_title_edit =  document.getElementById("combo_advanced_title_edit")

          //  document.getElementById("cantidad").value = 1
          //  document.getElementById("costoInicial").value = 1

          var barcode_edit =  document.getElementById("barcode_edit").value
          var barcode2_edit =  document.getElementById("barcode2_edit").value
          var barcode2SpanEdit =  document.getElementById("barcode2SpanEdit")
          var barcode2DivEdit =  document.getElementById("barcode2DivEdit")
          var barcodeSpanEdit =  document.getElementById("barcodeSpanEdit")
          var divNombreUnidadEdit =  document.getElementById("divNombreUnidadEdit")
          

          // init AccordionItemThreeAdd validatiion
          controlsAccordionItemThreeEdit.classList.add("hidden")
          controlsAccordionItemFiveEdit.classList.add("hidden")
          combo_advanced_title_edit.classList.add("hidden")
          combo_basic_title_edit.classList.add("hidden")
          simple_title_edit.classList.add("hidden")
          advanced_title_edit.classList.add("hidden")
          servicio_advanced_title_edit.classList.remove("hidden")
          servicio_basic_title_edit.classList.remove("hidden")
          barcode2SpanEdit.classList.remove("hidden")
          barcode2DivEdit.classList.remove("hidden")
          barcodeSpanEdit.classList.add("hidden")
          divNombreUnidadEdit.classList.add("md:grid-cols-3")
          divNombreUnidadEdit.classList.remove("md:grid-cols-2")
      }

      function selectCombo(){
          var controlsAccordionItemThreeAdd =  document.getElementById("controlsAccordionItemThreeAdd")
          var controlsAccordionItemFiveAdd =  document.getElementById("controlsAccordionItemFiveAdd")
          var servicio_advanced_title =  document.getElementById("servicio_advanced_title")
          var servicio_basic_title =  document.getElementById("servicio_basic_title")
          var simple_title =  document.getElementById("simple_title")
          var advanced_title =  document.getElementById("advanced_title")
          var combo_basic_title =  document.getElementById("combo_basic_title")
          var combo_advanced_title =  document.getElementById("combo_advanced_title")
          document.getElementById("cantidad").value = 1
          document.getElementById("costoInicial").value = 1
          var barcode =  document.getElementById("barcode").value
          var barcode2 =  document.getElementById("barcode2").value
          var barcode2Span =  document.getElementById("barcode2Span")
          var barcode2Div =  document.getElementById("barcode2Div")
          var barcodeSpan =  document.getElementById("barcodeSpan")
          var divNombreUnidad =  document.getElementById("divNombreUnidad")
          

          // init AccordionItemThreeAdd validatiion
          controlsAccordionItemThreeAdd.classList.add("hidden")
          controlsAccordionItemFiveAdd.classList.remove("hidden")
          barcode2Span.classList.remove("hidden")
          barcode2Div.classList.remove("hidden")
          barcodeSpan.classList.add("hidden")
          simple_title.classList.add("hidden")
          advanced_title.classList.add("hidden")
          combo_basic_title.classList.remove("hidden")
          combo_advanced_title.classList.remove("hidden")
          servicio_basic_title.classList.add("hidden")
          servicio_advanced_title.classList.add("hidden")
          divNombreUnidad.classList.add("md:grid-cols-3")
          divNombreUnidad.classList.remove("md:grid-cols-2")
          

      }

      function selectComboEdit(){
          var controlsAccordionItemThreeEdit =  document.getElementById("controlsAccordionItemThreeEdit")
          var controlsAccordionItemFiveEdit =  document.getElementById("controlsAccordionItemFiveEdit")
          var servicio_advanced_title_edit =  document.getElementById("servicio_advanced_title_edit")
          var servicio_basic_title_edit =  document.getElementById("servicio_basic_title_edit")
          var simple_title_edit =  document.getElementById("simple_title_edit")
          var advanced_title_edit =  document.getElementById("advanced_title_edit")
          var combo_basic_title_edit =  document.getElementById("combo_basic_title_edit")
          var combo_advanced_title_edit =  document.getElementById("combo_advanced_title_edit")
          // document.getElementById("cantidad").value = 1
          // document.getElementById("costoInicial").value = 1
          var barcode_edit =  document.getElementById("barcode_edit").value
          var barcode2_edit =  document.getElementById("barcode2_edit").value
          var barcode2SpanEdit =  document.getElementById("barcode2SpanEdit")
          var barcode2DivEdit =  document.getElementById("barcode2DivEdit")
          var barcodeSpanEdit =  document.getElementById("barcodeSpanEdit")
          var divNombreUnidadEdit =  document.getElementById("divNombreUnidadEdit")
          

          // init AccordionItemThreeAdd validatiion
          controlsAccordionItemThreeEdit.classList.add("hidden")
          controlsAccordionItemFiveEdit.classList.remove("hidden")
          barcode2SpanEdit.classList.remove("hidden")
          barcode2DivEdit.classList.remove("hidden")
          barcodeSpanEdit.classList.add("hidden")
          simple_title_edit.classList.add("hidden")
          advanced_title_edit.classList.add("hidden")
          combo_basic_title_edit.classList.remove("hidden")
          combo_advanced_title_edit.classList.remove("hidden")
          servicio_basic_title_edit.classList.add("hidden")
          servicio_advanced_title_edit.classList.add("hidden")
          divNombreUnidadEdit.classList.add("md:grid-cols-3")
          divNombreUnidadEdit.classList.remove("md:grid-cols-2")
          

      }

      function selectProducto(){
          document.getElementById("cantidad").value = ''
          document.getElementById("costoInicial").value = ''
          var controlsAccordionItemThreeAdd =  document.getElementById("controlsAccordionItemThreeAdd")
          var controlsAccordionItemFiveAdd =  document.getElementById("controlsAccordionItemFiveAdd")
          var servicio_advanced_title =  document.getElementById("servicio_advanced_title")
          var servicio_basic_title =  document.getElementById("servicio_basic_title")
          var simple_title =  document.getElementById("simple_title")
          var advanced_title =  document.getElementById("advanced_title")
          var combo_basic_title =  document.getElementById("combo_basic_title")
          var combo_advanced_title =  document.getElementById("combo_advanced_title")
          var barcode =  document.getElementById("barcode").value
          var barcode2 =  document.getElementById("barcode2").value
          var barcode2Span =  document.getElementById("barcode2Span")
          var barcode2Div =  document.getElementById("barcode2Div")
          var barcodeSpan =  document.getElementById("barcodeSpan")
          var divNombreUnidad =  document.getElementById("divNombreUnidad")

          // init AccordionItemThreeAdd validatiion
          controlsAccordionItemThreeAdd.classList.remove("hidden")
          controlsAccordionItemFiveAdd.classList.add("hidden")
          servicio_basic_title.classList.add("hidden")
          servicio_advanced_title.classList.add("hidden")
          combo_basic_title.classList.add("hidden")
          combo_advanced_title.classList.add("hidden")
          simple_title.classList.remove("hidden")
          advanced_title.classList.remove("hidden")
          barcode2Span.classList.add("hidden")
          barcode2Div.classList.add("hidden")
          barcodeSpan.classList.remove("hidden")
          divNombreUnidad.classList.remove("md:grid-cols-3")
          divNombreUnidad.classList.add("md:grid-cols-2")

      }

      function selectProductoEdit(){
          // document.getElementById("stock").value = ''
          // document.getElementById("costoInicial").value = ''
          var controlsAccordionItemThreeEdit =  document.getElementById("controlsAccordionItemThreeEdit")
          var controlsAccordionItemFiveEdit =  document.getElementById("controlsAccordionItemFiveEdit")
          var servicio_advanced_title_edit =  document.getElementById("servicio_advanced_title_edit")
          var servicio_basic_title_edit =  document.getElementById("servicio_basic_title_edit")
          var simple_title_edit =  document.getElementById("simple_title_edit")
          var advanced_title_edit =  document.getElementById("advanced_title_edit")
          var combo_basic_title_edit =  document.getElementById("combo_basic_title_edit")
          var combo_advanced_title_edit =  document.getElementById("combo_advanced_title_edit")
          var barcode_edit =  document.getElementById("barcode_edit").value
          var barcode2_edit =  document.getElementById("barcode2_edit").value
          var barcode2SpanEdit =  document.getElementById("barcode2SpanEdit")
          var barcode2DivEdit =  document.getElementById("barcode2DivEdit")
          var barcodeSpanEdit =  document.getElementById("barcodeSpanEdit")
          var divNombreUnidadEdit =  document.getElementById("divNombreUnidadEdit")

          // init AccordionItemThreeAdd validatiion
          controlsAccordionItemThreeEdit.classList.remove("hidden")
          controlsAccordionItemFiveEdit.classList.add("hidden")
          servicio_basic_title_edit.classList.add("hidden")
          servicio_advanced_title_edit.classList.add("hidden")
          combo_basic_title_edit.classList.add("hidden")
          combo_advanced_title_edit.classList.add("hidden")
          simple_title_edit.classList.remove("hidden")
          advanced_title_edit.classList.remove("hidden")
          barcode2SpanEdit.classList.add("hidden")
          barcode2DivEdit.classList.add("hidden")
          barcodeSpanEdit.classList.remove("hidden")
          divNombreUnidadEdit.classList.remove("md:grid-cols-3")
          divNombreUnidadEdit.classList.add("md:grid-cols-2")

      }

      


      window.tipo = 0
      function showProductEdit(id, category_id, image, barcode, title, description, buy_price, sell_price, stock, impuesto, unit, tipo, precio_base, minimo, maximo, venta_negativo, codigo_unspsc){
        window.tipo = tipo  
        switch(tipo) {
            case 'producto':
              document.getElementById("tipo_producto_edit").checked = true;
              break;
            case 'servicio':
              document.getElementById("tipo_servicio_edit").checked = true;
              break;
            case 'combo':
              document.getElementById("tipo_combo_edit").checked = true;
              break;
            default:
              // code block
          }

        switch(venta_negativo) {
            case 'venta_negativo':
              document.getElementById("venta_negativo_edit").checked = true;
              break;
          }
        
        if(category_id == '' || image == '' || description == '' || minimo == '' || maximo == '' || venta_negativo == '' || codigo_unspsc == '' || minimo == '' || maximo == ''){
              document.getElementById('barcode_edit').value = barcode
              document.getElementById('unit_edit').value = unit
              // document.getElementById("unit_edit").setAttribute('value', unit);
              document.getElementById('impuesto_edit').value = impuesto
              document.getElementById('title_edit').value = title
              document.getElementById('buy_price_edit').value = buy_price
              document.getElementById('sell_price_edit').value = sell_price
              document.getElementById('stock_edit').value = stock
              document.getElementById('precio_base_edit').value = precio_base
              document.getElementById('categoria_edit').value = category_id
              document.getElementById('codigo_unspsc_edit').value = codigo_unspsc
              document.getElementById('id_product_edit').value = id
              document.getElementById('description_edit').value = description
              document.getElementById('cantidad_minima_edit').value = minimo
              document.getElementById('cantidad_maxima_edit').value = maximo
             
              
          
          }

          if(image == 'http://localhost/factuvalente/public/uploads/products'){  
                console.log('qlq')         
                var output_image_edit = document.getElementById('output_image_edit')
                var inputImageEdit = document.getElementById('inputImageEdit')
                output_image_edit.classList.add("hidden")
                inputImageEdit.classList.remove("hidden")
              }else{
                document.getElementById('output_image_edit').src = image
                var output_image_edit = document.getElementById('output_image_edit')
                var inputImageEdit = document.getElementById('inputImageEdit')
                inputImageEdit.classList.add("hidden")
                output_image_edit.classList.remove("hidden")
              }

          document.getElementById('validateEdit').innerHTML = 
            '<input id="val_id_product" name="val_id_product" value="'+id+'">'+
            '<input id="val_tipo_edit" name="val_tipo_edit" value="'+tipo+'">'+
            '<input id="val_title_edit" name="val_title_edit" value="'+title+'">'+
            '<input id="val_unit_edit" name="val_unit_edit" value="'+unit+'">'+
            '<input id="val_barcode_edit" name="val_barcode_edit" value="'+barcode+'">'+
            '<input id="val_stock_edit" name="val_stock_edit" value="'+stock+'">'+
            '<input id="val_buy_price_edit" name="val_buy_price_edit" value="'+buy_price+'">'+
            '<input id="val_precio_base_edit" name="val_precio_base_edit" value="'+precio_base+'">'+
            '<input id="val_impuesto_edit" name="val_impuesto_edit" value="'+impuesto+'">'+
            '<input id="val_sell_price_edit" name="val_sell_price_edit" value="'+sell_price+'">'+
            '<input id="val_description_edit" name="val_description_edit" value="'+description+'">'+
            '<input id="val_cantidad_minima_edit" name="val_cantidad_minima_edit" value="'+minimo+'">'+
            '<input id="val_cantidad_maxima_edit" name="val_cantidad_maxima_edit" value="'+maximo+'">'+
            '<input id="val_categoria_edit" name="val_categoria_edit" value="'+category_id+'">'+
            '<input id="val_venta_negativo_edit" name="val_venta_negativo_edit" value="'+venta_negativo+'">'+
            '<input id="val_codigo_unspsc_edit" name="val_codigo_unspsc_edit" value="'+codigo_unspsc+'">'
   
      } 
      

      function updatePrecioImpuesto(){
        var precioFinal = document.getElementById('precioFinal').value
        var precioBase = document.getElementById('precioBase').value
        var precioFinalId = document.getElementById('precioFinal')
        var precioBaseId = document.getElementById('precioBase')

        switch(impuesto) {
            case 'Ninguno (0%)':
                var imp = 0
              break;
            case 'IVA Exento - Exen (0.00%)':
                var imp = 0
              break;
            case 'IVA Excluído - Excl (0.00%)':
                var imp = 0
              break;
            case 'IVA (5.00%)':
                var imp = 0.05
              break;
            case 'IVA (19.00%)':
                var imp = 0.19
              break;
                }
        if(precioBase == '' && precioFinal == ''){
          console.log('no hagas nada impuesto')
        }
        else if(precioFinal == '' && precioBase !== ''){
          console.log('uno')
            var exePrecioFinal = (precioBase * imp) + parseInt(precioBase)
            document.getElementById('precioFinal').value = exePrecioFinal
            precioBaseId.classList.add("bg-input")
            precioFinalId.classList.add("bg-input")
        }
        else if(impuesto !== '' && precioBase == ''){
          console.log('dos')
            var exePrecioFinal = (precioBase * imp) + parseInt(precioBase)
            document.getElementById('precioFinal').value = exePrecioFinal
        }
        else{
          console.log('tres')
          var exePrecioFinal = (precioBase * imp) + parseInt(precioBase)
          document.getElementById('precioFinal').value = exePrecioFinal
        }        
          
      }

      function updatePrecioImpuestoEdit(){
        console.log('da')
        // var precioFinalEdit = document.getElementById('precioFinalEdit').value
        // var precioBaseEdit = document.getElementById('precioBaseEdit').value
        // var precioFinalIdEdit = document.getElementById('precioFinalEdit')
        // var precioBaseIdEdit = document.getElementById('precioBaseEdit')

        // switch(impuestoEdit) {
        //     case 'Ninguno (0%)':
        //         var imp = 0
        //       break;
        //     case 'IVA Exento - Exen (0.00%)':
        //         var imp = 0
        //       break;
        //     case 'IVA Excluído - Excl (0.00%)':
        //         var imp = 0
        //       break;
        //     case 'IVA (5.00%)':
        //         var imp = 0.05
        //       break;
        //     case 'IVA (19.00%)':
        //         var imp = 0.19
        //       break;
        //         }
        // if(precioBaseEdit == '' && precioFinalEdit == ''){
        //   console.log('no hagas nada impuesto')
        // }
        // else if(precioFinalEdit == '' && precioBaseEdit !== ''){
        //   console.log('uno')
        //     var exePrecioFinalEdit = (precioBaseEdit * imp) + parseInt(precioBaseEdit)
        //     document.getElementById('precioFinalEdit').value = exePrecioFinalEdit
        //     precioBaseIdEdit.classList.add("bg-input")
        //     precioFinalIdEdit.classList.add("bg-input")
        // }
        // else if(impuestoEdit !== '' && precioBaseEdit == ''){
        //   console.log('dos')
        //     var exePrecioFinalEdit = (precioBaseEdit * imp) + parseInt(precioBaseEdit)
        //     document.getElementById('precioFinalEdit').value = exePrecioFinalEdit
        // }
        // else{
        //   console.log('tres')
        //   var exePrecioFinalEdit = (precioBaseEdit * imp) + parseInt(precioBaseEdit)
        //   document.getElementById('precioFinalEdit').value = exePrecioFinalEdit
        // }        
          
      }

      function updatePrecioBase(){
        var precioFinal = document.getElementById('precioFinal').value
        var precioBase = document.getElementById('precioBase').value
        var precioFinalId = document.getElementById('precioFinal')
        var precioBaseId = document.getElementById('precioBase')

        switch(impuesto) {
            case 'Ninguno (0%)':
                var imp = 0
              break;
            case 'IVA Exento - Exen (0.00%)':
                var imp = 0
              break;
            case 'IVA Excluído - Excl (0.00%)':
                var imp = 0
              break;
            case 'IVA (5.00%)':
                var imp = 0.05
              break;
            case 'IVA (19.00%)':
                var imp = 0.19
              break;
                }

                if(precioFinal == '' && impuesto == 0){
                  console.log('no hagas nada base')
                  precioBaseId.classList.remove("bg-input")
                }
                if(impuesto !== 0 && precioBase !== ''){
                  var exePrecioFinal =  (precioBase * imp) + parseInt(precioBase)
                  document.getElementById('precioFinal').value = exePrecioFinal
                  precioFinalId.classList.add("bg-input")
                  precioBaseId.classList.add("bg-input")
                }
                if(precioBase == '' && impuesto !== 0){
                    console.log('nada base')
                    precioBaseId.classList.remove("bg-input")
                }  
          }

      function updatePrecioBaseEdit(){
        var precioFinalEdit = document.getElementById('precioFinalEdit').value
        var precioBaseEdit = document.getElementById('precioBaseEdit').value
        var precioFinalIdEdit = document.getElementById('precioFinalEdit')
        var precioBaseIdEdit = document.getElementById('precioBaseEdit')

        switch(impuestoEdit) {
            case 'Ninguno (0%)':
                var imp = 0
              break;
            case 'IVA Exento - Exen (0.00%)':
                var imp = 0
              break;
            case 'IVA Excluído - Excl (0.00%)':
                var imp = 0
              break;
            case 'IVA (5.00%)':
                var imp = 0.05
              break;
            case 'IVA (19.00%)':
                var imp = 0.19
              break;
                }

                if(precioFinalEdit == '' && impuestoEdit == 0){
                  console.log('no hagas nada base')
                  precioBaseIdEdit.classList.remove("bg-input")
                }
                if(impuestoEdit !== 0 && precioBaseEdit !== ''){
                  var exePrecioFinalEdit =  (precioBaseEdit * imp) + parseInt(precioBaseEdit)
                  document.getElementById('precioFinal').value = exePrecioFinalEdit
                  precioFinalIdEdit.classList.add("bg-input")
                  precioBaseIdEdit.classList.add("bg-input")
                }
                if(precioBaseEdit == '' && impuestoEdit !== 0){
                    console.log('nada base')
                    precioBaseIdEdit.classList.remove("bg-input")
                }  
          }

      function updatePrecioFinal(){
        var precioFinal = document.getElementById('precioFinal').value
        var precioFinalId = document.getElementById('precioFinal')
        var precioBaseId = document.getElementById('precioBase')
        var precioBase = document.getElementById('precioBase').value

        precioFinalId.classList.add("dark:focus:shadow-outline-gray")
        
        switch(impuesto) {
            case 'Ninguno (0%)':
                var imp = 0
              break;
            case 'IVA Exento - Exen (0.00%)':
                var imp = 0
              break;
            case 'IVA Excluído - Excl (0.00%)':
                var imp = 0
              break;
            case 'IVA (5.00%)':
                var imp = 0.05
              break;
            case 'IVA (19.00%)':
                var imp = 0.19
              break;
                }

          if(precioBase == '' && impuesto == 0){
            console.log('no hagas nada final')
          }
          if(impuesto !== 0 && precioFinal !== ''){
            var exePrecioBase =  parseInt(precioFinal) - (precioFinal * imp)
            document.getElementById('precioBase').value = exePrecioBase
            precioBaseId.classList.add("bg-input")
            precioFinalId.classList.add("bg-input")
          }
          if(precioFinal == '' && impuesto !== 0){
              console.log('nada final')
              precioFinalId.classList.remove("bg-input")
          }   
          
      }


      function updatePrecioFinalEdit(){
        var precioFinalEdit = document.getElementById('precioFinalEdit').value
        var precioFinalIdEdit = document.getElementById('precioFinalEdit')
        var precioBaseIdEdit = document.getElementById('precioBaseEdit')
        var precioBaseEdit = document.getElementById('precioBaseEdit').value

        precioFinalIdEdit.classList.add("dark:focus:shadow-outline-gray")
        
        switch(impuestoEdit) {
            case 'Ninguno (0%)':
                var imp = 0
              break;
            case 'IVA Exento - Exen (0.00%)':
                var imp = 0
              break;
            case 'IVA Excluído - Excl (0.00%)':
                var imp = 0
              break;
            case 'IVA (5.00%)':
                var imp = 0.05
              break;
            case 'IVA (19.00%)':
                var imp = 0.19
              break;
                }

          if(precioBaseEdit == '' && impuestoEdit == 0){
            console.log('no hagas nada final')
          }
          if(impuestoEdit !== 0 && precioFinalEdit !== ''){
            var exePrecioBaseEdit =  parseInt(precioFinalEdit) - (precioFinalEdit * imp)
            document.getElementById('precioBaseEdit').value = exePrecioBaseEdit
            precioBaseIdEdit.classList.add("bg-input")
            precioFinalIdEdit.classList.add("bg-input")
          }
          if(precioFinalEdit == '' && impuestoEdit !== 0){
              console.log('nada final')
              precioFinalIdEdit.classList.remove("bg-input")
          }   
          
      }
      

      window.unit = 0
      function catchUnit(unit){
        window.unit = unit
          document.getElementById('validate_unit').value = unit
      }

      window.impuesto = 0
      function catchImpuesto(impuesto){
        window.impuesto = impuesto
          document.getElementById('validate_impuesto').value = impuesto
      }

      window.impuestoEdit = 0
      function catchImpuestoEdit(impuestoEdit){
        window.impuestoEdit = impuestoEdit
          document.getElementById('validate_impuesto_edit').value = impuestoEdit
      }
  
      function submitAddProd(){
            var tipo_producto = document.getElementById('tipo_producto').value
            var tipo_servicio = document.getElementById('tipo_servicio').value
            var tipo_combo = document.getElementById('tipo_combo').value
            var validate_unit = document.getElementById('validate_unit').value
            var title = document.getElementById('title').value
            var unit = document.getElementById('unit').value
            var barcode = document.getElementById('barcode').value
            var cantidad = document.getElementById('cantidad').value
            var image_edit = document.getElementById('image_edit').value


            var costoInicial = document.getElementById('costoInicial').value
            var precioBase = document.getElementById('precioBase').value
            var precioFinal = document.getElementById('precioFinal').value
            var description = document.getElementById('description').value
            var image = document.getElementById('image').value
            var cantidadMinima = document.getElementById('cantidadMinima').value
            var cantidadMaxima = document.getElementById('cantidadMaxima').value
            var ventaNegativo = document.getElementById('ventaNegativo').value
            var categoria = document.getElementById('categoria').value
            var codigoUNSPSC = document.getElementById('codigoUNSPSC').value

            var patternLetter = /^[a-zA-Z0-9 ]*$/
            var patternNumber = /^(?:-(?:[1-9](?:\d{0,2}(?:,\d{3})+|\d*))|(?:0|(?:[1-9](?:\d{0,2}(?:,\d{3})+|\d*))))(?:.\d+|)$/
            
            if(title == '' && unit == '' && barcode == '' && cantidad == '' && costoInicial == '' && precioBase == '' && impuesto == '' && precioFinal == ''){
              Swal.fire({
                    title: 'Error!',
                    text: 'Inputs vacíos.',
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: false,
                });
                
            }
            else if(title == ''){
                  Swal.fire({
                    title: 'Error!',
                    text: 'Input Nombre vacío.',
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: false,
                });
            }
            else if(validate_unit == ''){
                  Swal.fire({
                    title: 'Error!',
                    text: 'Input unidad vacío.',
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: false,
                });
           
            }
            else if(barcode == ''){
                  Swal.fire({
                    title: 'Error!',
                    text: 'Input barcode vacío.',
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: false,
                });
           
            }
            else if(cantidad == ''){
                  Swal.fire({
                    title: 'Error!',
                    text: 'Input cantidad vacío.',
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: false,
                });
           
            }
            else if(costoInicial == ''){
                  Swal.fire({
                    title: 'Error!',
                    text: 'Input costo inicial vacío.',
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: false,
                });
           
            }
            else if(precioBase == ''){
                  Swal.fire({
                    title: 'Error!',
                    text: 'Input precio base vacío.',
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: false,
                });
           
            }
            else if(impuesto == ''){
                  Swal.fire({
                    title: 'Error!',
                    text: 'Input impuesto vacío.',
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: false,
                });
           
            }
            else if(precioFinal == ''){
                  Swal.fire({
                    title: 'Error!',
                    text: 'Input precio final vacío.',
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: false,
                });
           
            }
            else if (!patternLetter.test(title)) {
                  Swal.fire({
                        title: 'Error!',
                        text: 'Input "nombre" solo puede introducir letras y números, mínimo 3 caracteres.',
                        icon: 'error',
                        timer: 2000,
                        showConfirmButton: false,
                    });
                } 
            else if (!patternLetter.test(barcode)) {
                  Swal.fire({
                        title: 'Error!',
                        text: 'Input "barcode" solo puede introducir letras y números, mínimo 3 caracteres.',
                        icon: 'error',
                        timer: 2000,
                        showConfirmButton: false,
                    });
                } 
            else if (!patternNumber.test(cantidad)) {
                  Swal.fire({
                            title: 'Error!',
                            text: 'Input "cantidad" solo puede introducir números, mínimo 1 caracter.',
                            icon: 'error',
                            timer: 2000,
                            showConfirmButton: false,
                        });
                }
            else if (!patternNumber.test(costoInicial)) {
                  Swal.fire({
                            title: 'Error!',
                            text: 'Input "costoInicial" solo puede introducir números, mínimo 1 caracter.',
                            icon: 'error',
                            timer: 2000,
                            showConfirmButton: false,
                        });
                }
            else if (!patternNumber.test(precioBase)) {
                  Swal.fire({
                            title: 'Error!',
                            text: 'Input "Precio Base" solo puede introducir números, mínimo 1 caracter.',
                            icon: 'error',
                            timer: 2000,
                            showConfirmButton: false,
                        });
                }
            else if (!patternNumber.test(precioFinal)) {
                  Swal.fire({
                            title: 'Error!',
                            text: 'Input "Precio Final" solo puede introducir números, mínimo 1 caracter.',
                            icon: 'error',
                            timer: 2000,
                            showConfirmButton: false,
                        });
                }
            else if (!patternLetter.test(description)) {
                  Swal.fire({
                            title: 'Error!',
                            text: 'Input "descripcción" solo puede introducir letras y números, mínimo 3 caracteres.',
                            icon: 'error',
                            timer: 2000,
                            showConfirmButton: false,
                        });
                }
            else if (!patternNumber.test(cantidadMinima) && cantidadMinima !== '') {
                  Swal.fire({
                            title: 'Error!',
                            text: 'Input "cantidad mínima" solo puede introducir números, mínimo 1 caracter.',
                            icon: 'error',
                            timer: 2000,
                            showConfirmButton: false,
                        });
                }
            else if (!patternNumber.test(cantidadMaxima) && cantidadMaxima !== '') {
                  Swal.fire({
                            title: 'Error!',
                            text: 'Input "cantidad máxima" solo puede introducir números, mínimo 1 caracter.',
                            icon: 'error',
                            timer: 2000,
                            showConfirmButton: false,
                        });
                }
                else{
                  loader.classList.remove('hidden');
                  document.querySelector("#addProductform").submit();           
                } 

            //   setTimeout(() => loader.style.display = 'none', 1000);
            // loader.classList.remove('hidden');
            // document.querySelector("#some-form").submit();
          }

          var addProductform = document.querySelector('#addProductform')
          addProductform.addEventListener('submit', function (event) {
            console.log('data')
            axios.post('productosCreate', {
                      tipo: tipo,
                      title: title,
                      unit: unit,
                      barcode: barcode,
                      cantidad: cantidad,
                      costoInicial: costoInicial,
                      precioBase: precioBase,
                      precioFinal: precioFinal,
                      impuesto: impuesto,
                      imagen: image,
                      description: description,
                      cantidadMinima: cantidadMinima,
                      cantidadMaxima: cantidadMaxima,
                      ventaNegativo: ventaNegativo,
                      categoria: categoria,
                      codigoUNSPSC: codigoUNSPSC
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

        function destroyServicio(id, tipo) {
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

                    axios.post('destroyServicio', {
                        id: id,
                        tipo: 1
                      })
                      .then(function (response) {
                        if(response.data == 'si'){
                            Swal.fire({
                                title: '¡Eliminado!',
                                text: 'Producto eliminado correctamente.',
                                icon: 'success',
                                timer: 1000,
                                showConfirmButton: false,
                            });
                            setTimeout(() => loader1.style.display = 'none', 1000);
                            window.location.href = "{{ route('servicios')}}" 
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

                    axios.post('desactivarProducto', {
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
                                text: 'Servicio desactivado correctamente.',
                                icon: 'success',
                                timer: 1000,
                                showConfirmButton: false,
                            });
                            setTimeout(() => loader1.style.display = 'none', 1000);
                            window.location.href = "{{ route('servicios')}}" 
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

                    axios.post('desactivarProducto', {
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
                                text: 'Servicio activado correctamente.',
                                icon: 'success',
                                timer: 1000,
                                showConfirmButton: false,
                            });
                            setTimeout(() => loader1.style.display = 'none', 1000);
                            window.location.href = "{{ route('servicios')}}" 
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


      function submitEditProd(){
            
            var tipo_producto_edit = document.getElementById('tipo_producto_edit').value
            var tipo_servicio_edit = document.getElementById('tipo_servicio_edit').value
            var tipo_combo_edit = document.getElementById('tipo_combo_edit').value
            console.log(datas, 'datass')

            var validate_unit_edit = document.getElementById('validate_unit_edit').value
            var title_edit = document.getElementById('title_edit').value
            var unit_edit = document.getElementById('unit_edit').value
            var barcode_edit = document.getElementById('barcode_edit').value
            var stock_edit = document.getElementById('stock_edit').value
            var image_edit = document.getElementById('image_edit').value
            console.log(image_edit, 'image_edit')


            var buy_price_edit = document.getElementById('buy_price_edit').value
            var precio_base_edit = document.getElementById('precio_base_edit').value
            var sell_price_edit = document.getElementById('sell_price_edit').value
            var description_edit = document.getElementById('description_edit').value
            var cantidad_minima_edit = document.getElementById('cantidad_minima_edit').value
            var cantidad_maxima_edit = document.getElementById('cantidad_maxima_edit').value
            var venta_negativo_edit = document.getElementById('venta_negativo_edit').value
            var categoria_edit = document.getElementById('categoria_edit').value
            var codigo_unspsc_edit = document.getElementById('codigo_unspsc_edit').value

            var patternLetter = /^[a-zA-Z0-9 ]*$/
            var patternNumber = /^(?:-(?:[1-9](?:\d{0,2}(?:,\d{3})+|\d*))|(?:0|(?:[1-9](?:\d{0,2}(?:,\d{3})+|\d*))))(?:.\d+|)$/
            
            if(title_edit == '' && unit_edit == '' && barcode_edit == '' && stock_edit == '' && buy_price_edit == '' && precio_base_edit == '' && impuesto_edit == '' && sell_price_edit == ''){
              Swal.fire({
                    title: 'Error!',
                    text: 'Inputs vacíos.',
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: false,
                });
                
            }
            else if(title_edit == ''){
                  Swal.fire({
                    title: 'Error!',
                    text: 'Input Nombre vacío.',
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: false,
                });
            }
            else if(unit_edit == ''){
                  Swal.fire({
                    title: 'Error!',
                    text: 'Input unidad vacío.',
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: false,
                });
           
            }
            else if(barcode_edit == ''){
                  Swal.fire({
                    title: 'Error!',
                    text: 'Input barcode vacío.',
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: false,
                });
           
            }
            else if(stock_edit == ''){
                  Swal.fire({
                    title: 'Error!',
                    text: 'Input cantidad vacío.',
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: false,
                });
           
            }
            else if(buy_price_edit == ''){
                  Swal.fire({
                    title: 'Error!',
                    text: 'Input costo inicial vacío.',
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: false,
                });
           
            }
            else if(precio_base_edit == ''){
                  Swal.fire({
                    title: 'Error!',
                    text: 'Input precio base vacío.',
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: false,
                });
           
            }
            else if(impuesto_edit == ''){
                  Swal.fire({
                    title: 'Error!',
                    text: 'Input impuesto vacío.',
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: false,
                });
           
            }
            else if(sell_price_edit == ''){
                  Swal.fire({
                    title: 'Error!',
                    text: 'Input precio final vacío.',
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: false,
                });
           
            }
            else if (!patternLetter.test(title_edit)) {
                  Swal.fire({
                        title: 'Error!',
                        text: 'Input "nombre" solo puede introducir letras y números, mínimo 3 caracteres.',
                        icon: 'error',
                        timer: 2000,
                        showConfirmButton: false,
                    });
                } 
            else if (!patternLetter.test(barcode_edit)) {
                  Swal.fire({
                        title: 'Error!',
                        text: 'Input "barcode" solo puede introducir letras y números, mínimo 3 caracteres.',
                        icon: 'error',
                        timer: 2000,
                        showConfirmButton: false,
                    });
                } 
            else if (!patternNumber.test(stock_edit)) {
                  Swal.fire({
                            title: 'Error!',
                            text: 'Input "cantidad" solo puede introducir números, mínimo 1 caracter.',
                            icon: 'error',
                            timer: 2000,
                            showConfirmButton: false,
                        });
                }
            else if (!patternNumber.test(buy_price_edit)) {
                  Swal.fire({
                            title: 'Error!',
                            text: 'Input "costoInicial" solo puede introducir números, mínimo 1 caracter.',
                            icon: 'error',
                            timer: 2000,
                            showConfirmButton: false,
                        });
                }
            else if (!patternNumber.test(precio_base_edit)) {
                  Swal.fire({
                            title: 'Error!',
                            text: 'Input "Precio Base" solo puede introducir números, mínimo 1 caracter.',
                            icon: 'error',
                            timer: 2000,
                            showConfirmButton: false,
                        });
                }
            else if (!patternNumber.test(sell_price_edit)) {
                  Swal.fire({
                            title: 'Error!',
                            text: 'Input "Precio Final" solo puede introducir números, mínimo 1 caracter.',
                            icon: 'error',
                            timer: 2000,
                            showConfirmButton: false,
                        });
                }
            else if (!patternLetter.test(description_edit)) {
                  Swal.fire({
                            title: 'Error!',
                            text: 'Input "descripcción" solo puede introducir letras y números, mínimo 3 caracteres.',
                            icon: 'error',
                            timer: 2000,
                            showConfirmButton: false,
                        });
                }
            else if (!patternNumber.test(cantidad_minima_edit) && cantidad_minima_edit !== '') {
                  Swal.fire({
                            title: 'Error!',
                            text: 'Input "cantidad mínima" solo puede introducir números, mínimo 1 caracter.',
                            icon: 'error',
                            timer: 2000,
                            showConfirmButton: false,
                        });
                }
            else if (!patternNumber.test(cantidad_maxima_edit) && cantidad_maxima_edit !== '') {
                  Swal.fire({
                            title: 'Error!',
                            text: 'Input "cantidad máxima" solo puede introducir números, mínimo 1 caracter.',
                            icon: 'error',
                            timer: 2000,
                            showConfirmButton: false,
                        });
                }
                else{
                  loader.classList.remove('hidden');
                  document.querySelector("#editProductform").submit();           
                } 

            //   setTimeout(() => loader.style.display = 'none', 1000);
            // loader.classList.remove('hidden');
            // document.querySelector("#some-form").submit();
          }

          var editProductform = document.querySelector('#editProductform')
          editProductform.addEventListener('submit', function (event) {
            axios.post('productosEdit', {
                      tipo_edit: tipo_edit,
                      title_edit: title_edit,
                      unit_edit: unit_edit,
                      barcode_edit: barcode_edit,
                      stock_edit: stock_edit,
                      buy_price_edit: buy_price_edit,
                      precio_base_edit: precio_base_edit,
                      sell_price_edit: sell_price_edit,
                      impuesto_edit: impuesto_edit,
                      description_edit: description_edit,
                      cantidad_minima_edit: cantidad_minima_edit,
                      cantidad_maxima_edit: cantidad_maxima_edit,
                      venta_negativo_edit: venta_negativo_edit,
                      categoria_edit: categoria_edit,
                      codigo_unspsc_edit: codigo_unspsc_edit
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


</script>


    <!-- modal script -->
    <script>
        all_modals = ['addProduct', 'editProduct']
        all_modals.forEach((modal)=>{
            const modalSelected = document.querySelector('.'+modal);
            modalSelected.classList.remove('fadeIn');
            modalSelected.classList.add('fadeOut');
            modalSelected.classList.add('overflow-scroll');
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
    </script>
    <script>
        function selectOnlyThis(id){
            var myCheckbox = document.getElementsByName("myCheckbox");
            Array.prototype.forEach.call(myCheckbox,function(el){
                el.checked = false;
        });
        id.checked = true;
        }
    </script>
    
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
    
<!-- component -->
<style>

#header #button:hover > .content {
    opacity:1;
    height: 50px;
}

#header #button .content {
    opacity:0;
    clear: both;
    height: 0;
    overflow: hidden;
    
    -webkit-transition: all .3s ease .15s;
    -moz-transition: all .3s ease .15s;
    -o-transition: all .3s ease .15s;
    -ms-transition: all .3s ease .15s;
    transition: all .3s ease .15s;
    
    border-top: 1px solid rgb(214, 16, 16);
    border-left: 1px solid rgb(218, 22, 22);
    border-right: 1px solid rgb(189, 15, 15);
    border-bottom: 1px solid rgb(224, 3, 3);
    
    -webkit-border-radius: 0px 7px 7px 7px;
    -moz-border-radius: 0px 7px 7px 7px;
    -khtml-border-radius: 0px 7px 7px 7px;
    border-radius: 0px 7px 7px 7px;
    
    -webkit-box-shadow: 0px 2px 2px rgb(206, 8, 8);
    -moz-box-shadow: 0px 2px 2px rgb(185, 7, 7);
    box-shadow: 0px 2px 2px rgb(160, 12, 12);
    background: #FFF;
}

.searchFilter{
  width: 0;
  transition: width 0.5s;
}

.jz-search{
    opacity:0;
    clear: both;
    padding: 0 8px;
    overflow: hidden;
  -webkit-transition: all .3s ease .15s;
    -moz-transition: all .3s ease .15s;
    -o-transition: all .3s ease .15s;
    -ms-transition: all .3s ease .15s;
    transition: all .3s ease .15s;
    
    border-top: 1px solid #EEEEEE;
    border-left: 1px solid #EEEEEE;
    border-right: 1px solid #EEEEEE;
    border-bottom: 1px solid #EEEEEE;
    
    -webkit-border-radius: 0px 7px 7px 7px;
    -moz-border-radius: 0px 7px 7px 7px;
    -khtml-border-radius: 0px 7px 7px 7px;
    border-radius: 0px 7px 7px 7px;
    
    -webkit-box-shadow: 0px 2px 2px #DDDDDD;
    -moz-box-shadow: 0px 2px 2px #DDDDDD;
    box-shadow: 0px 2px 2px #DDDDDD;
}


@media (max-width:600px){
  .jz-hide-small{
      display:none!important
    }
}

@media (max-width:600px){
  .sm-grid-cols-3{
      grid-template-columns: repeat(3, minmax(0, 1fr));
    }
}
    

  .loading:before {
  
      background:white;
  
      background: white;
  }
  

  .jz-center{
    display: block;
    margin-left: auto;
    margin-right: auto;
  }

.jz-right{float:right!important}

.jz-display-middle{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);-ms-transform:translate(-50%,-50%)}

select option:hover {
  box-shadow: 0 0 20px 150px #9333ea inset !important;
  color:white;
}
select option:checked{
  box-shadow: 0 0 20px 150px #9333ea inset !important;
  }

.bg-input{
  background-color: #e8f0fe;
}
        
@media only screen and (max-width: 600px) {
  .z-screen{
    width: 77vw;
  }
  
    }
@media only screen and (max-width: 600px) {
    .impMargin{
      margin-top: 20px;
      }
    }

@media only screen and (max-width: 750px) {
.marginNegative{
  margin: 0rem;
  }
}

.select-menu {
max-width: 330px;
}
.select-menu .select-btn {
display: flex;
background: #fff;
padding: 5px;
font-size: 18px;
font-weight: 400;
border-radius: 8px;
align-items: center;
cursor: pointer;
justify-content: space-between;
}
.select-menu .options {
position: absolute;
width: 13rem;
overflow-y: auto;
max-height: 295px;
padding: 10px;
margin-top: 10px;
border-radius: 8px;
background: #fff;
box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
animation-name: fadeInDown;
-webkit-animation-name: fadeInDown;
animation-duration: 0.35s;
animation-fill-mode: both;
-webkit-animation-duration: 0.35s;
-webkit-animation-fill-mode: both;
}

@media only screen and (max-width: 600px) {
   .select-menu .options {
        right: 26px;
    }
    }
.select-menu .options .option {
display: flex;
height: 55px;
cursor: pointer;
padding: 0 16px;
border-radius: 8px;
align-items: center;
background: #fff;
}
.select-menu .options .option:hover {
background: #f2f2f2;
}
.select-menu .options .option i {
font-size: 25px;
margin-right: 12px;
}
.select-menu .options .option .option-text {
font-size: 16px;
color: #333;
}

.select-btn i {
font-size: 25px;
transition: 0.3s;
}

.select-menu.active .select-btn i {
transform: rotate(-180deg);
}
.select-menu.active .options {
display: block;
opacity: 0;
z-index: 10;
animation-name: fadeInUp;
-webkit-animation-name: fadeInUp;
animation-duration: 0.4s;
animation-fill-mode: both;
-webkit-animation-duration: 0.4s;
-webkit-animation-fill-mode: both;
}

@keyframes fadeInUp {
from {
    transform: translate3d(0, 30px, 0);
}
to {
    transform: translate3d(0, 0, 0);
    opacity: 1;
}
}
@keyframes fadeInDown {
from {
    transform: translate3d(0, 0, 0);
    opacity: 1;
}
to {
    transform: translate3d(0, 20px, 0);
    opacity: 0;
}
}
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

/* tr:nth-child(even) {
background-color: #f2f2f2;
} */

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