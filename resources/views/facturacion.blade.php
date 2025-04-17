@extends('layouts.layoutDash')

@section('content')
<div class="loading" id="loader"></div>
<div class="loading hidden" id="loader1"></div>
<div class="container mx-auto">
   
    <div class="hidden lg:block md:block">
        <div class="flex">
            <div class="w-2/3 p-2 flex-auto min-h-[30rem] max-h-[700px] overflow-y-scroll" style="border-right:1px solid #9333ea;">
                
                <div class="mt-4 flex">
                    <span class="flex-row bg-purple-400 p-1 pt-2 rounded m-px" id="searchName" onclick="triggerSearch(1)">
                        <box-icon class="cursor-pointer" name='search-alt' flip='horizontal' color="white"></box-icon>
                    </span>
                    <span class="flex-row bg-purple-600 p-1 pt-2 rounded m-px hidden" id="searchNameAnim">
                        <box-icon name='search-alt' animation='tada' flip='horizontal' color="white"></box-icon>
                    </span>
                    <span class="flex-row bg-purple-400 p-1 pt-2 rounded" id="searchBarcode" onclick="triggerSearch(2)">
                        <box-icon class="cursor-pointer" name='barcode-reader' flip='horizontal' color="white"></box-icon>
                    </span>
                    <span class="flex-row bg-purple-600 p-1 pt-2 rounded hidden" id="searchBarcodeAnim">
                        <box-icon name='barcode-reader' animation='tada' flip='horizontal' color="white"></box-icon>
                    </span>
                    <input
                        class="flex-row w-full text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                        focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                        form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer"
                        placeholder="Introduzca Nombre"
                        id="inputSearchName"
                        type="text" 
                        name="inputSearchName"
                        pattern="[0-9a-zA-Z ]{3,}"
                        />
                    <input
                        class="hidden flex-row w-full text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
                        focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray 
                        form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer"
                        placeholder="Introduzca Barcode"
                        id="inputSearchBarcode"
                        type="text" 
                        name="inputSearchBarcode"
                        pattern="[0-9a-zA-Z ]{3,}"
                        />
                        <span class="flex-row cursor-pointer bg-purple-600 p-1 pl-2 rounded min-w-[9.5rem] text-white">
                            Nuevo Producto<box-icon type='solid' name='bookmark-plus' color="white"></box-icon>
                    </span>
                </div>

                <div id="initProductsByName" class="grid grid-cols-3"></div>
                <div id="resultProductsByName" class="grid grid-cols-3"></div>
                <div id="resultProductsByBarcode" class="grid grid-cols-3"></div>
                <div id="paginationProducts" class="flex flex-row justify-center"></div>
            </div>
            
            <div class="w-1/3 flex-auto">
                <span class="mt-4 p-2 flex text-purple-600">Factura de venta</span>
                <div class="flex w-full">
                    <div class="wrapper">
                        <span class="flex-row p-1 pt-2 m-px">
                            Cliente:
                        </span>
                        <select 
                            class="select w-full"
                            id="clientSelected"
                            name="clientSelected">
                            @foreach($customers as $item)
                                <option value="{{$item->id}}" class="cursor-pointer hover:bg-purple-600">{{$item->name}}</option>
                            @endforeach
                         </select>
                    </div>
                    
                    <span class="flex-row cursor-pointer bg-purple-600 p-1 pl-2 rounded text-white">
                        <box-icon name='user-plus' color="white"></box-icon>
                    </span>
                    
                </div>
                <div class="flex flex-col min-h-[15rem] justify-center items-center text-center bg-slate-200" id="initDomFacturacion">
                    <box-icon name='cart-download' color="#9333ea" size="md"></box-icon>
                    <span>Aquí verás los productos que elijas en tu próxima venta</span>
                </div>
                <div class="flow-root p-[0.2rem] border border-purple-200 mr-5 ml-5 mb-px rounded text-gray-400">
                    <span class="float-left p-1" id="initShowCantProd">0 productos</span>
                    <span class="float-left p-1 text-purple-600 hidden" id="showCantProd"></span>
                    <span class="float-right p-1 text-purple-600" id="initDeleteCart">Cancelar</span>
                    <span class="float-right p-1 text-purple-600 cursor-pointer hidden" id="deleteCart" onclick="deleteCart()">Cancelar</span>
                </div>  
                <div class="min-h-[15rem] justify-center items-center text-center bg-slate-200 hidden max-h-[400px] overflow-y-scroll" id="domFacturacion">
                    
                </div>
                <div class="flow-root p-[0.2rem] border border-purple-200 mr-5 ml-5 mb-2 mt-2 rounded text-gray-800" id="divSubTotal">
                    <span class="float-left p-1" id="textSubTotal">SubTotal</span>
                    <span class="float-right p-1 text-purple-600" id="valSubTotal"></span>
                </div>
                <div class="flow-root p-[0.2rem] border border-purple-200 mr-5 ml-5 mb-2 mt-2 rounded text-gray-800" id="impuestoSelect">
                    <span class="float-right p-1 text-purple-600 mt-2" id="valImpuestoGeneral"></span>
                    <div class="float-left p-1">
                        <div x-data="combobox({
                            allOptions: [
                                { 
                                    label: 'IVA (5.00%)',
                                    value: 'IVA (5.00%)' 
                                },
                                { 
                                    label: 'IVA (19.00%)',
                                    value: 'IVA (19.00%)' 
                                },
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
                                }
                            ],
                            })" class="flex w-[9rem] max-w-xs flex-col gap-1" x-on:keydown="handleKeydownOnOptions($event)" x-on:keydown.esc.window="isOpen = false, openedWithKeyboard = false">
                            <div class="relative">

                                <!-- trigger button  -->
                                <button type="button" class="mt-1 inline-flex w-[9rem] items-center justify-between gap-2 border border-outline rounded-[4px] bg-surface-alt px-4 py-2 text-sm 
                                font-medium tracking-wide text-on-surface transition hover:opacity-75 focus:border-purple-400 
                                focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray" 
                                role="combobox" aria-controls="makesList" aria-haspopup="listbox" x-on:click="isOpen = ! isOpen" 
                                x-on:keydown.down.prevent="openedWithKeyboard = true" x-on:keydown.enter.prevent="openedWithKeyboard = true" 
                                x-on:keydown.space.prevent="openedWithKeyboard = true" x-bind:aria-expanded="isOpen || openedWithKeyboard" 
                                x-bind:aria-label="selectedOption ? selectedOption.value : 'Impuesto'" >
                                    <span class="text-sm font-normal" x-text="selectedOption ? selectedOption.value : 'Impuesto'"></span>
                                    <!-- Chevron  -->
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"class="size-5" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/>
                                    </svg>
                                </button>

                                <!-- Hidden Input To Grab The Selected Value  -->
                                <input id="impuesto" name="impuesto" x-ref="hiddenTextField" hidden=""/>
                                <div x-show="isOpen || openedWithKeyboard" id="makesList" class="w-full overflow-hidden rounded-radius border border-outline bg-surface-alt dark:border-outline-dark dark:bg-surface-dark-alt" role="listbox" aria-label="industries list" x-on:click.outside="isOpen = false, openedWithKeyboard = false" x-on:keydown.down.prevent="$focus.wrap().next()" x-on:keydown.up.prevent="$focus.wrap().previous()" x-transition x-trap="openedWithKeyboard">

                                    <!-- Search  -->
                                    <div class="relative">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="1.5" class="absolute left-4 top-1/2 size-5 -translate-y-1/2 text-on-surface/50 dark:text-on-surface-dark/50" aria-hidden="true" >
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                                        </svg>
                                        <input type="text" class="dark:bg-gray-800 dark:text-gray-200 w-full border-b border-outline bg-surface-alt py-2.5 pl-11 pr-4 text-sm text-on-surface focus:outline-hidden focus-visible:border-primary disabled:cursor-not-allowed disabled:opacity-75 dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark dark:focus-visible:border-primary-dark" name="searchField" x-ref="searchField" aria-label="Search" x-on:input="getFilteredOptions($el.value)" placeholder="Search" />
                                    </div>

                                    <!-- Options  -->
                                    <ul class="flex max-h-44 flex-col overflow-y-auto overflow max-w-48">
                                        <li class="hidden px-4 py-2 text-sm text-on-surface dark:text-on-surface-dark" x-ref="noResultsMessage">
                                            <span>No se encontraron coincidencias</span>
                                        </li>
                                        <template x-for="(item, index) in options" x-bind:key="item.value">
                                            <li class="dark:bg-gray-800 dark:text-gray-200 combobox-option inline-flex cursor-pointer hover:bg-gray-200 justify-between gap-6 
                                            bg-neutral-50 px-4 py-2 text-sm text-on-surface hover:bg-surface-dark-alt/5 hover:bg-purple-500 dark:hover:text-gray-200 
                                            hover:text-on-surface-strong focus-visible:bg-surface-dark-alt/5 
                                            focus-visible:text-on-surface-strong focus-visible:outline-hidden dark:bg-surface-dark-alt dark:text-on-surface-dark 
                                            dark:hover:bg-purple-200
                                            dark:hover:text-on-surface-dark-strong dark:focus-visible:bg-surface-alt/10 dark:focus-visible:text-on-surface-dark-strong" role="option" x-on:click="setSelectedOption(item) ; impuestoGeneral(item)" 
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
                </div>
                <div class="flow-root p-[0.2rem] bg-gray-300 mr-5 ml-5 mb-px rounded text-white" id="buttonSell">
                    <span class="float-left text-lg p-1 mt-1 p-2" id="textVender">Vender</span>
                    <span class="float-right p-1 fontz text-5xl text-white" id="showTotalSell"></span>
                </div>
            </div>
        </div>
        <div class="">
            <div class="dropzone" id="dropzone">
                <div class="draggable p-2 m-2 rounded" draggable="true" id="div1">Div 1</div>
                <div class="draggable p-2 m-2 rounded" draggable="true" id="div2">Div 2</div>
                <div class="draggable p-2 m-2 rounded" draggable="true" id="div3">Div 3</div>
            </div>
        </div>
    </div>

    <div class="sm:block lg:hidden md:hidden">
        <div class="flex">
            <div class="flex-auto">
                <span>datos movil</span>
            </div>
        </div>
    </div>

        <!-- <div class="grid grid-cols-1 gap-4 sm:block hidden">
            <div class="">05d</div>
        </div> -->
        <input type="text" class="hidden" id="triggerDomFacturacion" value="1">
        <input type="text" class="hidden" id="triggerImpuestoGlobal" value="1">
        <input type="text" class="hidden" id="triggerImpuestoGeneral" value="1">
        <input type="text" class="hidden" id="urlDom" value="0">
    
</div>

<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        
        toggleBig()
        triggerSearch(1)

        var initProductsByName = document.getElementById('initProductsByName')
        
        var inputSearchNameValue = document.getElementById('inputSearchName').value
        
        checkCart()
        

    })
</script>
<script>

        var inputSearchName = document.getElementById('inputSearchName')
        var inputSearchBarcode = document.getElementById('inputSearchBarcode')
        var modifyQTY = document.getElementById('modifyQTY')
    
        inputSearchName.addEventListener('keyup', debounce(() => {
            findProductByName()
        }, 800))

        inputSearchBarcode.addEventListener('keyup', debounce(() => {
            findProductByBarcode()
        }, 800))


        function debounce(fn, duration) {
            var timer;
            return function(){
                clearTimeout(timer);
                timer = setTimeout(fn, duration);
            }
        }


        function productByName(){
            var urlDom = document.getElementById('urlDom').value
            console.log(urlDom, 'dir')
            var initProductsByName = document.getElementById('initProductsByName')
            var paginationProducts = document.getElementById('paginationProducts')
            
            //validate if urlDom is not 0
            if(urlDom > 0){
                    console.log(urlDom, 'dale mano')
                    axios.get('productByName?page='+urlDom+'')
                .then((response) => {
                    try {
                        
                        if(response.data.productsCarts){
                            if(response.data.productsCarts.impuesto_global == 2){
                                console.log('veo')
                                initProductsByName.innerHTML = ''
                                response.data.productsSimple.data.forEach(function(element){
                                        if(element.carts.length !== 0){
                                            initProductsByName.innerHTML += 
                                            '<div class="w-full p-6 flex flex-row text-center max-w-[17rem] relative">'+
                                            '<div class="absolute right-7 ...">'+
                                                '<p class="p-1 rounded-[24rem] text-white bg-purple-600">'+element.carts[0].qty+'</p>'+
                                            '</div>'+
                                                '<a onclick="addToCart('+element.id+','+element.stock+','+element.precio_base+','+response.data.productsSimple.current_page+',\'' + element.impuesto + '\')" class="shadow p-2 cursor-pointer bg-purple-200 rounded">'+
                                                    '<img class="" src="'+element.image+'">'+
                                                    '<div class="pt-3">'+
                                                        '<p class="capitalize">Nombre: '+element.title+'</p>'+
                                                    '</div>'+
                                                    '<p class="pt-1 text-gray-900 capitalize">tipo: '+element.tipo+'</p>'+
                                                    '<p class="pt-1 text-gray-900">Precio: $'+element.precio_base+'</p>'+
                                                '</a>'+
                                            '</div>'
                                            return
                                        }
                                        initProductsByName.innerHTML += element.stock == 0 ? 
                                            '<div class="w-full p-6 flex flex-row text-center max-w-[17rem]">'+
                                                '<a onclick="addToCart('+element.id+','+element.stock+','+element.precio_base+','+response.data.productsSimple.current_page+',\'' + element.impuesto + '\')" class="shadow p-2 cursor-pointer border-4 border-purple-400 rounded" id="productoVentaNegativo">'+
                                                    '<img class="" src="'+element.image+'">'+
                                                    '<div class="pt-3">'+
                                                        '<p class="capitalize">Nombre: '+element.title+'s</p>'+
                                                    '</div>'+
                                                    '<p class="pt-1 text-gray-900 capitalize">tipo: '+element.tipo+'</p>'+
                                                    '<p class="pt-1 text-gray-900">Precio: $'+element.precio_base+'</p>'+
                                                    '<span class="pt-1 text-purple-600">PRODUCTO AGOTADO</span>'+
                                                '</a>'+
                                            '</div>' : 
                                            
                                            '<div class="w-full p-6 flex flex-row text-center max-w-[17rem]">'+
                                                '<a onclick="addToCart('+element.id+','+element.stock+','+element.precio_base+','+response.data.productsSimple.current_page+',\'' + element.impuesto + '\')" class="shadow p-2 cursor-pointer">'+
                                                    '<img class="" src="'+element.image+'">'+
                                                    '<div class="pt-3">'+
                                                        '<p class="capitalize">Nombre: '+element.title+'s</p>'+
                                                    '</div>'+
                                                    '<p class="pt-1 text-gray-900 capitalize">Tipo: '+element.tipo+'</p>'+
                                                    '<p class="pt-1 text-gray-900">Precio: $'+element.precio_base+'</p>'+
                                                '</a>'+
                                            '</div>'
                                            if(element.venta_negativo == 'venta_negativo'){
                                                var productoVentaNegativo = document.getElementById('productoVentaNegativo')
                                                productoVentaNegativo.classList.add('border-dashed')
                                                return
                                            }
                                            paginationProducts.innerHTML = ''
                                            response.data.productsSimple.links.forEach(function(element){
                                                var url = element.url
                                                if(element.label == '&laquo; Previous' || element.label == 'Next &raquo;'){
                                                    paginationProducts.innerHTML += ''
                                                    return
                                                }
                                                paginationProducts.innerHTML += element.active == false ?
                                                '<span class="cursor-pointer bg-purple-400 text-white text-center rounded p-2 m-2" onclick="goPage(\'' + element.label + '\')">'+element.label+'</span>' :
                                                '<span class="cursor-pointer bg-purple-600 text-white text-center rounded p-2 m-2" onclick="goPage(\'' + element.label + '\')">'+element.label+'</span>'
                                            })
                                    
                                    })
                                    loader.style.display = 'none'
                                return
                            }
                            
                        }
                        //end if carts not empty
                        console.log('muerte')
                        initProductsByName.innerHTML = ''
                        response.data.productsSimple.data.forEach(function(element){
                                if(element.carts.length !== 0){
                                        initProductsByName.innerHTML += 
                                        '<div class="w-full p-6 flex flex-row text-center max-w-[17rem] relative">'+
                                        '<div class="absolute right-7 ...">'+
                                            '<p class="p-1 rounded-[24rem] text-white bg-purple-600">'+element.carts[0].qty+'</p>'+
                                        '</div>'+
                                            '<a onclick="addToCart('+element.id+','+element.stock+','+element.sell_price+','+response.data.productsSimple.current_page+',\'' + element.impuesto + '\')" class="shadow p-2 cursor-pointer bg-purple-200 rounded">'+
                                                '<img class="" src="'+element.image+'">'+
                                                '<div class="pt-3">'+
                                                    '<p class="capitalize">Nombre: '+element.title+'</p>'+
                                                '</div>'+
                                                '<p class="pt-1 text-gray-900 capitalize">tipo: '+element.tipo+'</p>'+
                                                '<p class="pt-1 text-gray-900">Precio: $'+element.sell_price+'</p>'+
                                            '</a>'+
                                        '</div>'
                                        return
                                    }
                                initProductsByName.innerHTML += element.stock == 0 ? 
                                    '<div class="w-full p-6 flex flex-row text-center max-w-[17rem]">'+
                                        '<a onclick="addToCart('+element.id+','+element.stock+','+element.sell_price+','+response.data.productsSimple.current_page+',\'' + element.impuesto + '\')" class="shadow p-2 cursor-pointer border-4 border-purple-400 rounded" id="productoVentaNegativo">'+
                                            '<img class="" src="'+element.image+'">'+
                                            '<div class="pt-3">'+
                                                '<p class="capitalize">Nombre: '+element.title+'</p>'+
                                            '</div>'+
                                            '<p class="pt-1 text-gray-900 capitalize">tipo: '+element.tipo+'</p>'+
                                            '<p class="pt-1 text-gray-900">Precio: $'+element.sell_price+'</p>'+
                                            '<span class="pt-1 text-purple-600">PRODUCTO AGOTADO</span>'+
                                        '</a>'+
                                    '</div>' : 
                                    
                                    '<div class="w-full p-6 flex flex-row text-center max-w-[17rem]">'+
                                        '<a onclick="addToCart('+element.id+','+element.stock+','+element.sell_price+','+response.data.productsSimple.current_page+',\'' + element.impuesto + '\')" class="shadow p-2 cursor-pointer">'+
                                            '<img class="" src="'+element.image+'">'+
                                            '<div class="pt-3">'+
                                                '<p class="capitalize">Nombre: '+element.title+'</p>'+
                                            '</div>'+
                                            '<p class="pt-1 text-gray-900 capitalize">Tipo: '+element.tipo+'</p>'+
                                            '<p class="pt-1 text-gray-900">Precio: $'+element.sell_price+'</p>'+
                                        '</a>'+
                                    '</div>'
                                    if(element.venta_negativo == 'venta_negativo'){
                                        var productoVentaNegativo = document.getElementById('productoVentaNegativo')
                                        productoVentaNegativo.classList.add('border-dashed')
                                        return
                                    }
                                                        
                        })
                        
                        paginationProducts.innerHTML = ''
                        response.data.productsSimple.links.forEach(function(element){
                                var url = element.url
                                if(element.label == '&laquo; Previous' || element.label == 'Next &raquo;'){
                                    paginationProducts.innerHTML += ''
                                    return
                                }
                                paginationProducts.innerHTML += element.active == false ?
                                '<span class="cursor-pointer bg-purple-400 text-white text-center rounded p-2 m-2" onclick="goPage(\'' + element.label + '\')">'+element.label+'</span>' :
                                '<span class="cursor-pointer bg-purple-600 text-white text-center rounded p-2 m-2" onclick="goPage(\'' + element.label + '\')">'+element.label+'</span>'
                            })
                        loader.style.display = 'none'
                    }catch(err) {
                        console.log(err,'err')
                    }
                });

                loader.style.display = 'none'
                return
            }

         


            console.log('como otras veces')
            //si no esta activo el impuesto global y hay productos en carrito, entonces se va a mostrar esta información
            // debido a que carga la cantidad del producto asignado asi como variantes propias de lo que se está vendiendo
            var inputSearchNameValue = document.getElementById('inputSearchName').value
            axios.get('productByName')
            .then((response) => {
                //init trycatch para manejar errores de la petición
                try {
                    //inicio validación si productsCarts no está vacío
                    if(response.data.productsCarts){
                        //inicio validación si productsCarts tiene impuesto global (o es igual a 2, en su lógica)
                        if(response.data.productsCarts.impuesto_global == 2){
                            impuestoGlobal.checked = true
                            console.log('productsCarts no está vacío y no tiene impuesto global activo')
                            initProductsByName.innerHTML = ''
                            response.data.productsSimple.data.forEach(function(element){
                                if(element.carts.length !== 0){
                                    console.log('te encontré')
                                    initProductsByName.innerHTML += 
                                    '<div class="w-full p-6 flex flex-row text-center max-w-[17rem] relative">'+
                                    '<div class="absolute right-7 ...">'+
                                        '<p class="p-1 rounded-[24rem] text-white bg-purple-600">'+element.carts[0].qty+'</p>'+
                                    '</div>'+
                                        '<a onclick="addToCart('+element.id+','+element.stock+','+element.precio_base+','+response.data.productsSimple.current_page+',\'' + element.impuesto + '\')" class="shadow p-2 cursor-pointer bg-purple-200 rounded">'+
                                            '<img class="" src="'+element.image+'">'+
                                            '<div class="pt-3">'+
                                                '<p class="capitalize">Nombre: '+element.title+'dd</p>'+
                                            '</div>'+
                                            '<p class="pt-1 text-gray-900 capitalize">tipo: '+element.tipo+'</p>'+
                                            '<p class="pt-1 text-gray-900">Precio: $'+element.sell_price+'</p>'+
                                        '</a>'+
                                    '</div>'
                                    return
                                }
                                    initProductsByName.innerHTML += element.stock == 0 ? 
                                        '<div class="w-full p-6 flex flex-row text-center max-w-[17rem]">'+
                                            '<a onclick="addToCart('+element.id+','+element.stock+','+element.precio_base+','+response.data.productsSimple.current_page+',\'' + element.impuesto + '\')" class="shadow p-2 cursor-pointer border-4 border-purple-400 rounded" id="productoVentaNegativo">'+
                                                '<img class="" src="'+element.image+'">'+
                                                '<div class="pt-3">'+
                                                    '<p class="capitalize">Nombre: '+element.title+'s</p>'+
                                                '</div>'+
                                                '<p class="pt-1 text-gray-900 capitalize">tipo: '+element.tipo+'</p>'+
                                                '<p class="pt-1 text-gray-900">Precio: $'+element.precio_base+'</p>'+
                                                '<span class="pt-1 text-purple-600">PRODUCTO AGOTADO</span>'+
                                            '</a>'+
                                        '</div>' : 
                                        
                                        '<div class="w-full p-6 flex flex-row text-center max-w-[17rem]">'+
                                            '<a onclick="addToCart('+element.id+','+element.stock+','+element.precio_base+','+response.data.productsSimple.current_page+',\'' + element.impuesto + '\')" class="shadow p-2 cursor-pointer">'+
                                                '<img class="" src="'+element.image+'">'+
                                                '<div class="pt-3">'+
                                                    '<p class="capitalize">Nombre: '+element.title+'s</p>'+
                                                '</div>'+
                                                '<p class="pt-1 text-gray-900 capitalize">Tipo: '+element.tipo+'</p>'+
                                                '<p class="pt-1 text-gray-900">Precio: $'+element.precio_base+'</p>'+
                                            '</a>'+
                                        '</div>'
                                        if(element.venta_negativo == 'venta_negativo'){
                                            var productoVentaNegativo = document.getElementById('productoVentaNegativo')
                                            productoVentaNegativo.classList.add('border-dashed')
                                            return
                                        }
                                        paginationProducts.innerHTML = ''
                                        response.data.productsSimple.links.forEach(function(element){
                                            var url = element.url
                                            if(element.label == '&laquo; Previous' || element.label == 'Next &raquo;'){
                                                paginationProducts.innerHTML += ''
                                                return
                                            }
                                            paginationProducts.innerHTML += element.active == false ?
                                            '<span class="cursor-pointer bg-purple-400 text-white text-center rounded p-2 m-2" onclick="goPage(\'' + element.label + '\')">'+element.label+'</span>' :
                                            '<span class="cursor-pointer bg-purple-600 text-white text-center rounded p-2 m-2" onclick="goPage(\'' + element.label + '\')">'+element.label+'</span>'
                                        })
                                
                                 })
                                console.log('casi puedo vivir')
                                loader.style.display = 'none'
                            return
                        }//fin validación si productsCarts tiene impuesto global (o es igual a 2, en su lógica)

                    }
                    //fin validación si productsCarts no está vacío

                    //inicio script para cargar los productos en la vista de venta si no hay productos en carrito
                    // y no tiene impuesto global activo. Resumen, esta es la vista que mostraremos siempre y cuando
                    // no haya productos en carrito y no tenga impuesto global activo (repetido para entendimiento)
                    initProductsByName.innerHTML = ''
                    response.data.productsSimple.data.forEach(function(element){
                        //inicio validación si hay productos en carrito para mostrar producto agregado y cantidad
                            if(element.carts.length !== 0){
                                    initProductsByName.innerHTML += 
                                    '<div class="w-full p-6 flex flex-row text-center max-w-[17rem] relative">'+
                                    '<div class="absolute right-7 ...">'+
                                        '<p class="p-1 rounded-[24rem] text-white bg-purple-600">'+element.carts[0].qty+'</p>'+
                                    '</div>'+
                                        '<a onclick="addToCart('+element.id+','+element.stock+','+element.sell_price+','+response.data.productsSimple.current_page+',\'' + element.impuesto + '\')" class="shadow p-2 cursor-pointer bg-purple-200 rounded">'+
                                            '<img class="" src="'+element.image+'">'+
                                            '<div class="pt-3">'+
                                                '<p class="capitalize">Nombre: '+element.title+'</p>'+
                                            '</div>'+
                                            '<p class="pt-1 text-gray-900 capitalize">tipo: '+element.tipo+'</p>'+
                                            '<p class="pt-1 text-gray-900">Precio: $'+element.sell_price+'</p>'+
                                            '<p class="pt-1 text-gray-900">Impuesto: '+element.impuesto+'</p>'+
                                        '</a>'+
                                    '</div>'
                                    return
                                }
                         //fin validación si hay productos en carrito para mostrar producto agregado y cantidad

                         //inicio validación si no hay productos en carrito para mostrar producto agregado y cantidad
                         // tambien para identificar si el producto tiene stock o no
                            initProductsByName.innerHTML += element.stock == 0 ? 
                                '<div class="w-full p-6 flex flex-row text-center max-w-[17rem]">'+
                                    '<a onclick="addToCart('+element.id+','+element.stock+','+element.sell_price+','+response.data.productsSimple.current_page+',\'' + element.impuesto + '\')" class="shadow p-2 cursor-pointer border-4 border-purple-400 rounded" id="productoVentaNegativo">'+
                                        '<img class="" src="'+element.image+'">'+
                                        '<div class="pt-3">'+
                                            '<p class="capitalize">Nombre: '+element.title+'</p>'+
                                        '</div>'+
                                        '<p class="pt-1 text-gray-900 capitalize">tipo: '+element.tipo+'</p>'+
                                        '<p class="pt-1 text-gray-900">Precio: $'+element.sell_price+'</p>'+
                                        '<p class="pt-1 text-gray-900">Impuesto: '+element.impuesto+'</p>'+
                                        '<span class="pt-1 text-purple-600">PRODUCTO AGOTADO</span>'+
                                    '</a>'+
                                '</div>' : 
                                
                                '<div class="w-full p-6 flex flex-row text-center max-w-[17rem]">'+
                                    '<a onclick="addToCart('+element.id+','+element.stock+','+element.sell_price+','+response.data.productsSimple.current_page+',\'' + element.impuesto + '\')" class="shadow p-2 cursor-pointer">'+
                                        '<img class="" src="'+element.image+'">'+
                                        '<div class="pt-3">'+
                                            '<p class="capitalize">Nombre: '+element.title+'</p>'+
                                        '</div>'+
                                        '<p class="pt-1 text-gray-900 capitalize">Tipo: '+element.tipo+'</p>'+
                                        '<p class="pt-1 text-gray-900">Precio: $'+element.sell_price+'</p>'+
                                        '<p class="pt-1 text-gray-900">Impuesto: '+element.impuesto+'</p>'+
                                    '</a>'+
                                '</div>'
                                // fin validación si no hay productos en carrito para mostrar producto agregado y cantidad
                                // tambien para identificar si el producto tiene stock o no

                                // validación si el producto tiene condición de venta en negativo
                                if(element.venta_negativo == 'venta_negativo'){
                                    var productoVentaNegativo = document.getElementById('productoVentaNegativo')
                                    productoVentaNegativo.classList.add('border-dashed')
                                    return
                                }
                                // fin validación si el producto tiene condición de venta en negativo
                                                     
                    })
                    //inicio detección de paginación para productos
                    //colocamos paginationProducts en blanco para evitar duplicados
                    paginationProducts.innerHTML = ''
                    //recorremos (productsSimple) los links de la paginación y los mostramos en la vista
                    response.data.productsSimple.links.forEach(function(element){
                            var url = element.url
                            //inicio script para eliminar los botones next y previous de la paginación
                            if(element.label == '&laquo; Previous' || element.label == 'Next &raquo;'){
                                paginationProducts.innerHTML += ''
                                return
                            }
                            //fin script para eliminar los botones next y previous de la paginación

                            //inicio script para mostrar los botones de paginación con condición de si están activos o no
                            // y asignar la función goPage para que cambie de página al hacer click en el botón
                            paginationProducts.innerHTML += element.active == false ?
                            '<span class="cursor-pointer bg-purple-400 text-white text-center rounded p-2 m-2" onclick="goPage(\'' + element.label + '\')">'+element.label+'</span>' :
                            '<span class="cursor-pointer bg-purple-600 text-white text-center rounded p-2 m-2" onclick="goPage(\'' + element.label + '\')">'+element.label+'</span>'
                            //fin script para mostrar los botones de paginación con condición de si están activos o no
                            // y asignar la función goPage para que cambie de página al hacer click en el botón
                        })
                        //fin recorrer (productsSimple) los links de la paginación y los mostramos en la vista
                    //cerramos loader para que no se quede cargando y se vea la vista de venta con todos los elementos cargados
                    loader.style.display = 'none'
                }
                //atrapamos el error de la petición y lo mostramos en consola
                catch(err) {
                    //identificamos si hay algún error en la carga de productos y lo mostramos en consola
                    console.log(err,'err')
                }
            })
            //fin trycatch para manejar errores de la petición
        }

        function goPage(url){
            console.log(url, 'entra')
            var initProductsByName = document.getElementById('initProductsByName')
            var paginationProducts = document.getElementById('paginationProducts')

            if(url){
                axios.get('productByName?page='+url+'')
            .then((response) => {
                try {
                    console.log(response.data.productsSimple, 'el lacra')
                    var i = 0
            if(response.data.productsCarts){
                if(response.data.productsCarts.impuesto_global == 2){
                        console.log('con impuesto')
                        initProductsByName.innerHTML = ''
                    response.data.productsSimple.data.forEach(function(element){
                        if(element.carts.length !== 0){
                                    initProductsByName.innerHTML += 
                                    '<div class="w-full p-6 flex flex-row text-center max-w-[17rem] relative">'+
                                    '<div class="absolute right-7 ...">'+
                                        '<p class="p-1 rounded-[24rem] text-white bg-purple-600">'+element.carts[0].qty+'</p>'+
                                    '</div>'+
                                        '<a onclick="addToCart('+element.id+','+element.stock+','+element.precio_base+','+response.data.productsSimple.current_page+',\'' + element.impuesto + '\')" class="shadow p-2 cursor-pointer bg-purple-200 rounded">'+
                                            '<img class="" src="'+element.image+'">'+
                                            '<div class="pt-3">'+
                                                '<p class="capitalize">Nombre: '+element.title+'</p>'+
                                            '</div>'+
                                            '<p class="pt-1 text-gray-900 capitalize">tipo: '+element.tipo+'</p>'+
                                            '<p class="pt-1 text-gray-900">Precio: $'+element.precio_base+'</p>'+
                                        '</a>'+
                                    '</div>'
                                    return
                                }
                       
                            initProductsByName.innerHTML += element.stock == 0 ? 
                                '<div class="w-full p-6 flex flex-row text-center max-w-[17rem]">'+
                                    '<a onclick="addToCart('+element.id+','+element.stock+','+element.precio_base+','+response.data.productsSimple.current_page+',\'' + element.impuesto + '\')" class="shadow p-2 cursor-pointer border-4 border-purple-400 rounded" id="productoVentaNegativo">'+
                                        '<img class="" src="'+element.image+'">'+
                                        '<div class="pt-3">'+
                                            '<p class="capitalize">Nombre: '+element.title+'s</p>'+
                                        '</div>'+
                                        '<p class="pt-1 text-gray-900 capitalize">tipo: '+element.tipo+'</p>'+
                                        '<p class="pt-1 text-gray-900">Precio: $'+element.precio_base+'</p>'+
                                        '<span class="pt-1 text-purple-600">PRODUCTO AGOTADO</span>'+
                                    '</a>'+
                                '</div>' : 
                                
                                '<div class="w-full p-6 flex flex-row text-center max-w-[17rem]">'+
                                    '<a onclick="addToCart('+element.id+','+element.stock+','+element.precio_base+','+response.data.productsSimple.current_page+',\'' + element.impuesto + '\')" class="shadow p-2 cursor-pointer">'+
                                        '<img class="" src="'+element.image+'">'+
                                        '<div class="pt-3">'+
                                            '<p class="capitalize">Nombre: '+element.title+'s</p>'+
                                        '</div>'+
                                        '<p class="pt-1 text-gray-900 capitalize">Tipo: '+element.tipo+'</p>'+
                                        '<p class="pt-1 text-gray-900">Precio: $'+element.precio_base+'</p>'+
                                    '</a>'+
                                '</div>'
                                if(element.venta_negativo == 'venta_negativo'){
                                    var productoVentaNegativo = document.getElementById('productoVentaNegativo')
                                    productoVentaNegativo.classList.add('border-dashed')
                                    return
                                }

                                
                        
                    })
                        paginationProducts.innerHTML = ''
                        response.data.productsSimple.links.forEach(function(element){
                            var url = element.url
                            if(element.label == '&laquo; Previous' || element.label == 'Next &raquo;'){
                                paginationProducts.innerHTML += ''
                                return
                            }
                            paginationProducts.innerHTML += element.active == false ?
                            '<span class="cursor-pointer bg-purple-400 text-white text-center rounded p-2 m-2" onclick="goPage(\'' + element.label + '\')">'+element.label+'</span>' :
                            '<span class="cursor-pointer bg-purple-600 text-white text-center rounded p-2 m-2" onclick="goPage(\'' + element.label + '\')">'+element.label+'</span>'
                        })
                        return
                    }//end if impuesto haves global value
                 }// end if productsCarts haves value

                 //init validación si impuesto global no está activo y hay productos en carrito
                    initProductsByName.innerHTML = ''
                    response.data.productsSimple.data.forEach(function(element){
                        if(element.carts.length !== 0){
                                    
                                    initProductsByName.innerHTML += 
                                    '<div class="w-full p-6 flex flex-row text-center max-w-[17rem] relative">'+
                                    '<div class="absolute right-7 ...">'+
                                        '<p class="p-1 rounded-[24rem] text-white bg-purple-600">'+element.carts[0].qty+'</p>'+
                                    '</div>'+
                                        '<a onclick="addToCart('+element.id+','+element.stock+','+element.precio_base+','+response.data.productsSimple.current_page+',\'' + element.impuesto + '\')" class="shadow p-2 cursor-pointer bg-purple-200 rounded">'+
                                            '<img class="" src="'+element.image+'">'+
                                            '<div class="pt-3">'+
                                                '<p class="capitalize">Nombre: '+element.title+'</p>'+
                                            '</div>'+
                                            '<p class="pt-1 text-gray-900 capitalize">tipo: '+element.tipo+'</p>'+
                                            '<p class="pt-1 text-gray-900">Precio: $'+element.sell_price+'</p>'+
                                        '</a>'+
                                    '</div>'
                                    return
                                }
                                
                            initProductsByName.innerHTML += element.stock == 0 ? 
                                '<div class="w-full p-6 flex flex-row text-center max-w-[17rem]">'+
                                    '<a onclick="addToCart('+element.id+','+element.stock+','+element.precio_base+','+response.data.productsSimple.current_page+',\'' + element.impuesto + '\')" class="shadow p-2 cursor-pointer border-4 border-purple-400 rounded" id="productoVentaNegativo">'+
                                        '<img class="" src="'+element.image+'">'+
                                        '<div class="pt-3">'+
                                            '<p class="capitalize">Nombre: '+element.title+'</p>'+
                                        '</div>'+
                                        '<p class="pt-1 text-gray-900 capitalize">tipo: '+element.tipo+'</p>'+
                                        '<p class="pt-1 text-gray-900">Precio: $'+element.sell_price+'</p>'+
                                        '<span class="pt-1 text-purple-600">PRODUCTO AGOTADO</span>'+
                                    '</a>'+
                                '</div>' : 
                                
                                '<div class="w-full p-6 flex flex-row text-center max-w-[17rem]">'+
                                    '<a onclick="addToCart('+element.id+','+element.stock+','+element.precio_base+','+response.data.productsSimple.current_page+',\'' + element.impuesto + '\')" class="shadow p-2 cursor-pointer">'+
                                        '<img class="" src="'+element.image+'">'+
                                        '<div class="pt-3">'+
                                            '<p class="capitalize">Nombre: '+element.title+'</p>'+
                                        '</div>'+
                                        '<p class="pt-1 text-gray-900 capitalize">Tipo: '+element.tipo+'</p>'+
                                        '<p class="pt-1 text-gray-900">Precio: $'+element.sell_price+'</p>'+
                                    '</a>'+
                                '</div>'
                                if(element.venta_negativo == 'venta_negativo'){
                                    var productoVentaNegativo = document.getElementById('productoVentaNegativo')
                                    productoVentaNegativo.classList.add('border-dashed')
                                    return
                                }
                                paginationProducts.innerHTML = ''
                             response.data.productsSimple.links.forEach(function(element){
                                var url = element.url
                                if(element.label == '&laquo; Previous' || element.label == 'Next &raquo;'){
                                    paginationProducts.innerHTML += ''
                                    return
                                }
                                paginationProducts.innerHTML += element.active == false ?
                                '<span class="cursor-pointer bg-purple-400 text-white text-center rounded p-2 m-2" onclick="goPage(\'' + element.label + '\')">'+element.label+'</span>' :
                                '<span class="cursor-pointer bg-purple-600 text-white text-center rounded p-2 m-2" onclick="goPage(\'' + element.label + '\')">'+element.label+'</span>'
                            })
                        
                    })

                    //end validación si impuesto global no está activo y hay productos en carrito

                }
                catch(err) {
                    console.log(err,'err')
                }
            });
            }
            console.log(url, 'url')
        }

        // Function to check the cart and update the UI accordingly
        function checkCart() {
            // Get references to various DOM elements used in the function
            var initShowCantProd = document.getElementById('initShowCantProd');
            var showCantProd = document.getElementById('showCantProd');
            var initDeleteCart = document.getElementById('initDeleteCart');
            var deleteCart = document.getElementById('deleteCart');
            var buttonSell = document.getElementById('buttonSell');
            var textVender = document.getElementById('textVender');
            var showTotalSell = document.getElementById('showTotalSell');
            var domFacturacion = document.getElementById('domFacturacion');
            var initDomFacturacion = document.getElementById('initDomFacturacion');
            var divSubTotal = document.getElementById('divSubTotal');
            var valSubTotal = document.getElementById('valSubTotal');
            var impuestoGlobal = document.getElementById('impuestoGlobal');
            var impuestoSelect = document.getElementById('impuestoSelect');
            var valImpuestoGeneral = document.getElementById('valImpuestoGeneral');
            var triggerImpuestoGeneral = document.getElementById('triggerImpuestoGeneral');
            var triggerImpuestoGlobal = document.getElementById('triggerImpuestoGlobal').value;
            
            // Make an API call to check the cart data
            axios.get('checkCart')
                .then((response) => {
                    console.log('2 checkCart')
                    try {
                        console.log('3 checkCart')
                        // If the cart is empty, reset the UI to its initial state
                        if (response.data.length == 0) {
                            console.log('4 if empty checkCart')
                            domFacturacion.classList.add('hidden');
                            initDomFacturacion.classList.remove('hidden');
                            initShowCantProd.classList.remove('hidden');
                            showCantProd.classList.add('hidden');
                            toggleImpuestoGlobal.classList.add('hidden');
                            initDeleteCart.classList.remove('hidden');
                            deleteCart.classList.add('hidden');
                            buttonSell.setAttribute("style", "background-color: #9ca3af;");
                            textVender.classList.remove('text-white');
                            divSubTotal.classList.add('hidden');
                            impuestoSelect.classList.add('hidden');
                            valImpuestoGeneral.innerHTML = '';
                            domFacturacion.innerHTML = '';
                            valSubTotal.innerHTML = '';
                            showTotalSell.innerHTML = '';
                            impuestoGlobal.checked = false;
                            document.getElementById('triggerImpuestoGlobal').value = 1;
                            productByName();
                            
                            return;
                        }

                        //init validation if there are products in the cart and if the global tax is active
                        if (response.data[0].impuesto_global == 2) {
                            console.log('5 con impuesto global checkCart', response.data[0].impuesto_global)
                            domFacturacion.innerHTML = '';
                            valSubTotal.innerHTML = '';
                            showTotalSell.innerHTML = '';
                            valImpuestoGeneral.innerHTML = '';
                            impuestoSelect.classList.remove('hidden');
                            initShowCantProd.classList.add('hidden');
                            showCantProd.classList.remove('hidden');
                            initDeleteCart.classList.add('hidden');
                            
                            deleteCart.classList.remove('hidden');
                            toggleImpuestoGlobal.classList.remove('hidden');
                            buttonSell.setAttribute("style", "background-color: #003200;")

                            textVender.classList.add('text-white');
                            divSubTotal.classList.remove('hidden');

                            valSubTotal.innerHTML = '';
                            showCantProd.innerHTML = '';
                            if (response.data.length == 1) {
                                showCantProd.innerHTML =
                                    '' + response.data.length + '' +
                                    '&nbsp;' +
                                    'producto agregado'

                            } else {
                                showCantProd.innerHTML =
                                    '' + response.data.length + '' +
                                    '&nbsp;' +
                                    'productos agregados'
                            }


                            initDomFacturacion.classList.add('hidden');
                            domFacturacion.classList.remove('hidden');
                            let subTotal = 0; // Variable acumuladora

                            response.data.forEach(function (element) {

                                subTotal += element.price; // Sumar el número a la variable acumuladora

                                window.idInputQTY = 0

                                valSubTotal.innerHTML = '$' + subTotal.toLocaleString('EN-US')
                                switch (triggerImpuestoGeneral.value) {
                                    case 'Ninguno (0%)':
                                        var total = subTotal
                                        valImpuestoGeneral.innerHTML = '0'
                                        break;
                                    case 'IVA Exento - Exen (0.00%)':
                                        var total = subTotal
                                        valImpuestoGeneral.innerHTML = '0'
                                        break;
                                    case 'IVA Exento - Exen (0.00%)':
                                        var total = subTotal
                                        valImpuestoGeneral.innerHTML = '0'
                                        break;
                                    case 'IVA (5.00%)':
                                        console.log('aqui')
                                        var total = subTotal * 0.05 + subTotal
                                        var imp = subTotal * 0.05
                                        valImpuestoGeneral.innerHTML = '$' + imp.toLocaleString('EN-US')
                                        break;
                                    case 'IVA (19.00%)':
                                        var total = subTotal * 0.19 + subTotal
                                        var imp = subTotal * 0.19
                                        valImpuestoGeneral.innerHTML = '$' + imp.toLocaleString('EN-US')
                                        break;
                                    default:
                                        var total = subTotal
                                }

                                showTotalSell.innerHTML = '$' + total.toLocaleString('EN-US')
                                var price = element.price.toLocaleString('EN-US')
                                if (element.qty !== 1) {
                                    console.log('qty diferente de 1')
                                    domFacturacion.innerHTML +=
                                        '<div class="flex justify-between p-2 m-2 border border-slate-300 rounded">' +
                                        '<div class="order-1 grid grid-flow-col grid-rows-2 max-w-[1rem]">' +
                                        '<span class="capitalize text-purple-600">' + element.product.title + '</span>' +
                                        '<span class="">$' + element.product.precio_base.toLocaleString('EN-US') + '</span>' +
                                        '</div>' +
                                        '<div class="order-2 mt-2">' +
                                        '<span class="cursor-pointer" onclick="minusCantidad(' + element.id + ',' + element.product.id + ',' + element.product.stock + ',' + element.product.sell_price + ')">' +
                                        '<i class="fa fa-minus bg-purple-600 text-white p-px" aria-hidden="true"></i>' +
                                        '</span>' +
                                        '<input type="text" value="' + element.qty + '" class="max-w-[3rem] text-center" id="modifyQTY' + i + '" onkeyup="triggerChangeQTY(this, ' + element.id + ', ' + element.product.id + ',' + element.product.stock + ',' + element.product.sell_price + ')"/>' +
                                        '<span class="cursor-pointer" onclick="plusCantidad(' + element.id + ',' + element.product.id + ',' + element.product.stock + ',' + element.product.sell_price + ')">' +
                                        '<i class="fa fa-plus bg-purple-600 text-white p-px" aria-hidden="true"></i>' +
                                        '</span>' +
                                        '<span class="cursor-pointer ml-4" onclick="deleteCurrentCart(' + element.id + ')">' +
                                        '<i class="fa fa-trash bg-purple-600 text-white rounded text-sm pl-1 pr-1" aria-hidden="true"></i>' +
                                        '</span>' +
                                        '<span class="cursor-pointer ml-4" onclick="doitSteps(' + i + ',' + element.id + ', ' + response.data[0].impuesto_global + ')">' +
                                        '<i class="fa fa-pencil bg-purple-600 text-white rounded text-sm pl-1 pr-1" aria-hidden="true"></i>' +
                                        '</span>' +
                                        '</div>' +
                                        '<div class="order-3 mt-2">' +
                                        '<span class="">$' + price + '</span>' +
                                        '</div>' +
                                        '</div>'

                                    i++
                                } else {
                                    console.log('qty igual a 1 checkCart')
                                    domFacturacion.innerHTML +=
                                        '<div class="flex justify-between p-2 m-2 border border-slate-300 rounded">' +
                                        '<div class="order-1 grid grid-flow-col grid-rows-2 max-w-[1rem]">' +
                                        '<span class="capitalize text-purple-600">' + element.product.title + '</span>' +
                                        '<span class="">' + element.product.precio_base.toLocaleString('EN-US') + '</span>' +
                                        '</div>' +
                                        '<div class="order-2 mt-2">' +
                                        '<span class="">' +
                                        '<i class="fa fa-minus bg-purple-300 text-white p-px" aria-hidden="true"></i>' +
                                        '</span>' +
                                        '<input type="text" value="' + element.qty + '" class="max-w-[3rem] text-center id="modifyQTY' + i + '" onkeyup="triggerChangeQTY(this, ' + element.id + ', ' + element.product.id + ',' + element.product.stock + ',' + element.product.sell_price + ')"/>' +
                                        '<span class="cursor-pointer" onclick="plusCantidad(' + element.id + ',' + element.product.id + ',' + element.product.stock + ',' + element.product.sell_price + ')">' +
                                        '<i class="fa fa-plus bg-purple-600 text-white p-px" aria-hidden="true"></i>' +
                                        '</span>' +
                                        '<span class="cursor-pointer ml-4" onclick="deleteCurrentCart(' + element.id + ')">' +
                                        '<i class="fa fa-trash bg-purple-600 text-white rounded text-sm pl-1 pr-1" aria-hidden="true"></i>' +
                                        '</span>' +
                                        '<span class="cursor-pointer ml-4" onclick="doitSteps(' + i + ',' + element.id + ', ' + response.data[0].impuesto_global + ')">' +
                                        '<i class="fa fa-pencil bg-purple-600 text-white rounded text-sm pl-1 pr-1" aria-hidden="true"></i>' +
                                        '</span>' +
                                        '</div>' +
                                        '<div class="order-3 mt-2">' +
                                        '<span class="">$' + price + '</span>' +
                                        '</div>' +
                                        '</div>'

                                }

                            })

                            productByName()
                            
                            return
                        }//end validation if there are products in the cart and if the global tax is active

                        //init validation if there are products in the cart and if the global tax is not active
                        if (response.data.length !== 0 && response.data[0].impuesto_global == 1) {
                            console.log('6 con impuesto checkCart')
                            domFacturacion.innerHTML = ''
                            valSubTotal.innerHTML = ''
                            showTotalSell.innerHTML = ''
                            valImpuestoGeneral.innerHTML = ''
                            impuestoSelect.classList.add('hidden')
                            initShowCantProd.classList.add('hidden')
                            showCantProd.classList.remove('hidden')
                            initDeleteCart.classList.add('hidden')
                            deleteCart.classList.remove('hidden')
                            toggleImpuestoGlobal.classList.remove('hidden')
                            buttonSell.setAttribute("style", "background-color: #003200;")

                            textVender.classList.add('text-white')
                            divSubTotal.classList.remove('hidden')

                            valSubTotal.innerHTML = ''
                            showCantProd.innerHTML = ''
                            if (response.data.length == 1) {
                                showCantProd.innerHTML =
                                    '' + response.data.length + '' +
                                    '&nbsp;' +
                                    'producto agregado'

                            } else {
                                showCantProd.innerHTML =
                                    '' + response.data.length + '' +
                                    '&nbsp;' +
                                    'productos agregados'
                            }


                            initDomFacturacion.classList.add('hidden')
                            domFacturacion.classList.remove('hidden')
                            let subTotal = 0; // Variable acumuladora
                            var i = 0
                            response.data.forEach(function (element) {
                                console.log(element, 'quel')
                                subTotal += element.price; // Sumar el número a la variable acumuladora

                                window.idInputQTY = 0
                                
                                valSubTotal.innerHTML = '$' + subTotal.toLocaleString('EN-US')
                                var total = subTotal

                                showTotalSell.innerHTML = '$' + total.toLocaleString('EN-US')
                                var price = element.price.toLocaleString('EN-US')
                                var item = '<input type="text"/>'
                                if (element.qty !== 1) {
                                    console.log('qty diferente de 1 sin impuesto checkCart')
                                    domFacturacion.innerHTML +=
                                        '<div class="flex justify-between p-2 m-2 border border-slate-300 rounded" id="step' + i + '" data-step="' + i + '">' +
                                        '<div class="order-1 grid grid-flow-col grid-rows-2 max-w-[1rem]">' +
                                        '<span class="capitalize text-purple-600">' + element.product.title + '</span>' +
                                        '<span class="">$' + element.product.sell_price.toLocaleString('EN-US') + '</span>' +
                                        '</div>' +
                                        '<div class="order-2 mt-2">' +
                                        '<span class="cursor-pointer" onclick="minusCantidad(' + element.id + ',' + element.product.id + ',' + element.product.stock + ',' + element.product.sell_price + ')">' +
                                        '<i class="fa fa-minus bg-purple-600 text-white p-px" aria-hidden="true"></i>' +
                                        '</span>' +
                                        '<input type="text" value="' + element.qty + '" class="max-w-[3rem] text-center" id="modifyQTY' + i + '" onkeyup="triggerChangeQTY(this, ' + element.id + ',' + element.product.id + ',' + element.product.stock + ',' + element.product.sell_price + ')"/>' +
                                        '<span class="cursor-pointer" onclick="plusCantidad(' + element.id + ',' + element.product.id + ',' + element.product.stock + ',' + element.product.sell_price + ')">' +
                                        '<i class="fa fa-plus bg-purple-600 text-white p-px" aria-hidden="true"></i>' +
                                        '</span>' +
                                        '<span class="cursor-pointer ml-4" onclick="deleteCurrentCart(' + element.id + ')">' +
                                        '<i class="fa fa-trash bg-purple-600 text-white rounded text-sm pl-1 pr-1" aria-hidden="true"></i>' +
                                        '</span>' +
                                        '<span class="cursor-pointer ml-4" onclick="doitSteps(' + i + ',' + element.id + ', ' + response.data[0].impuesto_global + ')">' +
                                        '<i class="fa fa-pencil bg-purple-600 text-white rounded text-sm pl-1 pr-1" aria-hidden="true"></i>' +
                                        '</span>' +
                                        '</div>' +
                                        '<div class="order-3 mt-2">' +
                                        '<span class="">$' + price + '</span>' +
                                        '</div>' +
                                        '</div>'

                                    i++
                                } else {
                                    console.log('qty igual a 1 sin impuesto checkCart')
                                    domFacturacion.innerHTML +=
                                        '<div class="flex justify-between p-2 m-2 border border-slate-300 rounded" id="step' + i + '" data-step="' + i + '">' +
                                        '<div class="order-1 grid grid-flow-col grid-rows-2 max-w-[1rem]">' +
                                        '<span class="capitalize text-purple-600">' + element.product.title + '</span>' +
                                        '<span class="">' + element.product.sell_price.toLocaleString('EN-US') + '</span>' +
                                        '</div>' +
                                        '<div class="order-2 mt-2">' +
                                        '<span class="">' +
                                        '<i class="fa fa-minus bg-purple-300 text-white p-px" aria-hidden="true"></i>' +
                                        '</span>' +
                                        '<input type="text" value="' + element.qty + '" class="max-w-[3rem] text-center id="modifyQTY' + i + '" onkeyup="triggerChangeQTY(this, ' + element.id + ',' + element.product.id + ',' + element.product.stock + ',' + element.product.sell_price + ')"/>' +
                                        '<span class="cursor-pointer" onclick="plusCantidad(' + element.id + ',' + element.product.id + ',' + element.product.stock + ',' + element.product.sell_price + ')">' +
                                        '<i class="fa fa-plus bg-purple-600 text-white p-px" aria-hidden="true"></i>' +
                                        '</span>' +
                                        '<span class="cursor-pointer ml-4" onclick="deleteCurrentCart(' + element.id + ')">' +
                                        '<i class="fa fa-trash bg-purple-600 text-white rounded text-sm pl-1 pr-1" aria-hidden="true"></i>' +
                                        '</span>' +
                                        '<span class="cursor-pointer ml-4" onclick="doitSteps(' + i + ',' + element.id + ', ' + response.data[0].impuesto_global + ')">' +
                                        '<i class="fa fa-pencil bg-purple-600 text-white rounded text-sm pl-1 pr-1" aria-hidden="true"></i>' +
                                        '</span>' +
                                        '</div>' +
                                        '<div class="order-3 mt-2">' +
                                        '<span class="">$' + price + '</span>' +
                                        '</div>' +
                                        '</div>'
                                    i++
                                }

                            })

                            productByName()
                            
                            return

                        }//end validation if there are products in the cart and if the global tax is not active

                        if (response.data == 'No hay productos en carrito') {
                            console.log('No hay productos en carrito')
                            return
                        }

                        if (response.data == 'no') {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Comuníquese con el admnistrador del sistema.',
                                icon: 'error',
                                timer: 2000,
                                showConfirmButton: false,
                            });
                            return
                        }

                        console.log(response.data.length, 'consomechan')
                    }
                    catch (err) {
                        console.log(err, 'err')
                    }
                });

        }

        window.precioBaseProduct = 0
        window.descuentoProduct = 0
        window.cantidadProduct = 0
        window.idProduct = 0
    function doitSteps(id, cart_id, impuesto_global) {
        axios.post('findCart', {
            cart_id: cart_id
        })
        .then(function (response) {
            try {
                console.log(response.data, 'data');
                introJs().setOptions({
                    showBullets: false,
                    showButtons: false,
                    steps: [{
                        element: document.querySelector('#step' + id),
                        title: 'Editar Producto',
                        color: '#3b82f680',
                        intro: '<span class="flex shadow-md rounded items-center">' +
                                    'Precio Base $: <input id="precioBaseProduct" value="' + response.data.precio_base.toLocaleString('EN-US') + '" type="text" class="w-[9rem] flex-row w-full text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer" oninput="updatePrecioBaseProduct(this.value)"/>' +
                                '</span><br>' +
                                '<span class="flex shadow-md rounded items-center">' +
                                    'Descuento $: <input id="descuentoProduct" value="' + response.data.descuento.toLocaleString('EN-US') + '" type="text" class="w-[9rem] flex-row w-full text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer" oninput="updateDescuentoProduct(this.value)"/>' +
                                '</span><br>' +
                                '<span class="flex shadow-md rounded items-center" id="putImpuesto">' +
                                    'Impuesto: ' +
                                    '<select onchange="doitImpuestoProduct(this.value, ' + response.data.id + ', '+response.data.precio_base+', '+response.data.descuento+', '+response.data.qty+')" value="' + response.data.impuesto + '" class="cursor-pointer border rounded border-slate-200 p-2 pr-8 flex flex-col justify-center w-full items-center text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray" id="importSelected" name="importSelected">' +
                                        '<option value="IVA (5.00%)" style="color:black;">IVA (5.00%)</option>' +
                                        '<option value="IVA (19.00%)" class="cursor-pointer hover:bg-purple-600">IVA (19.00%)</option>' +
                                        '<option value="Ninguno (0%)" class="cursor-pointer hover:bg-purple-600">Ninguno (0%)</option>' +
                                        '<option value="IVA Exento - Exen (0.00%)" class="cursor-pointer hover:bg-purple-600">IVA Exento - Exen (0.00%)</option>' +
                                        '<option value="IVA Excluído - Excl (0.00%)" class="cursor-pointer hover:bg-purple-600">IVA Excluído - Excl (0.00%)</option>' +
                                    '</select>' +
                                '</span><br id="brImpuestoGlobal">' +
                                '<span class="flex shadow-md rounded items-center">' +
                                    'Cantidad: <input id="cantidadProduct" value="' + response.data.qty + '" type="text" class="w-[9rem] flex-row w-full text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500 peer" oninput="updateCantidadProduct(this.value)"/>' +
                                '</span><br>' +
                                '<span class="flex shadow-md rounded" id="precioVenta1">Precio Venta $: ' + response.data.sell_price.toLocaleString('EN-US') + '</span>' +
                                '<span class="flex shadow-md rounded" id="precioVenta2" class="hidden"></span>' +
                                '<div class="flex flow-root mt-2">' +
                                    '<button id="buttonEditPro1" class="float-right items-center px-4 py-2 text-sm font-medium leading-5 text-black transition-colors duration-150 bg-purple-200 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">Editar</button>' +
                                    '<span id="buttonEditPro2" class="hidden"></span>' +
                                '</div>',
                        position: 'left'
                    }]
                }).start();
    
                document.getElementById('importSelected').value = response.data.impuesto_producto;
                var putImpuesto = document.getElementById('putImpuesto');
                var brImpuestoGlobal = document.getElementById('brImpuestoGlobal');
                //validate if the global tax is active and hide the select impuesto
                if(impuesto_global == 2){
                    putImpuesto.classList.add('hidden')
                    brImpuestoGlobal.classList.add('hidden')
                }
                else{
                    putImpuesto.classList.remove('hidden')
                    brImpuestoGlobal.classList.remove('hidden')
                }
                //end validate if the global tax is active and hide the select impuesto       
                window.precioBaseProduct = response.data.precio_base
                window.descuentoProduct = response.data.descuento
                window.cantidadProduct = response.data.qty
                window.idProduct = response.data.id
                window.precioTotal = response.data.sell_price
                window.impuestoProduct = response.data.impuesto_producto
    
            } catch (err) {
                console.log(err, 'err');
            }
        });
    }

    function doitImpuestoProduct(impuestoProductvalue, id, precioBaseProductBD, descuentoProductBD, cantidadProductBD) {
        var precioVenta1 = document.getElementById('precioVenta1');
        var precioVenta2 = document.getElementById('precioVenta2');
        var buttonEditPro1 = document.getElementById('buttonEditPro1');
        var buttonEditPro2 = document.getElementById('buttonEditPro2');
    
        // Use local variables instead of relying on global variables
        var precioBaseProductNumber = parseFloat(precioBaseProductBD || 0); // Default to 0 if undefined
        var descuentoProductNumber = parseFloat(descuentoProductBD || 0); // Default to 0 if undefined
        var cantidadProductNumber = parseInt(cantidadProductBD || 0); // Default to 0 if undefined
    
        console.log(precioBaseProductNumber, descuentoProductNumber, cantidadProductNumber, 'Values in doitImpuestoProduct');
    
        // Update the global impuestoProduct variable
        window.impuestoProduct = impuestoProductvalue;
    
        // Perform calculations based on the selected tax
        switch (impuestoProductvalue) {
            case 'IVA (5.00%)':
                precioVenta1.classList.add('hidden');
                precioVenta2.classList.remove('hidden');
                var precio_baseF = (precioBaseProductNumber - descuentoProductNumber) * 0.05 + (precioBaseProductNumber - descuentoProductNumber);
                precioVenta2.innerHTML = 'Precio Venta $: ' + '&nbsp;' + precio_baseF.toLocaleString('EN-US');
                window.precioTotal = precio_baseF;
                buttonEditPro1.classList.add('hidden');
                buttonEditPro2.classList.remove('hidden');
                buttonEditPro2.innerHTML = '<button id="buttonEditPro2" onclick="doitEditPro(' + cantidadProductNumber + ')" class="float-right items-center px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">Editar</button>';
                break;
    
            case 'IVA (19.00%)':
                precioVenta1.classList.add('hidden');
                precioVenta2.classList.remove('hidden');
                var precio_baseF = (precioBaseProductNumber - descuentoProductNumber) * 0.19 + (precioBaseProductNumber - descuentoProductNumber);
                precioVenta2.innerHTML = 'Precio Venta $: ' + '&nbsp;' + precio_baseF.toLocaleString('EN-US');
                window.precioTotal = precio_baseF;
                buttonEditPro1.classList.add('hidden');
                buttonEditPro2.classList.remove('hidden');
                buttonEditPro2.innerHTML = '<button id="buttonEditPro2" onclick="doitEditPro(' + cantidadProductNumber + ')" class="float-right items-center px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">Editar</button>';
                break;
    
            case 'Ninguno (0%)':
                precioVenta1.classList.remove('hidden');
                precioVenta2.classList.add('hidden');
                var precio_baseF = precioBaseProductNumber - descuentoProductNumber;
                precioVenta1.innerHTML = 'Precio Venta $: ' + '&nbsp;' + precio_baseF.toLocaleString('EN-US');
                break;
    
            case 'IVA Exento - Exen (0.00%)':
                precioVenta1.classList.add('hidden');
                precioVenta2.classList.remove('hidden');
                var precio_baseF = precioBaseProductNumber - descuentoProductNumber;
                precioVenta2.innerHTML = 'Precio Venta $: Exento de IVA - ' + '&nbsp;' + precio_baseF.toLocaleString('EN-US');
                break;
    
            case 'IVA Excluído - Excl (0.00%)':
                precioVenta1.classList.add('hidden');
                precioVenta2.classList.remove('hidden');
                var precio_baseF = precioBaseProductNumber - descuentoProductNumber;
                precioVenta2.innerHTML = 'Precio Venta $: Excluido de IVA - ' + '&nbsp;' + precio_baseF.toLocaleString('EN-US');
                break;
    
            default:
                console.log('Opción no reconocida:', impuestoProductvalue);
                break;
        }
    }

    function doitEditPro(cantidadProduct){
            console.log(cantidadProduct, 'cantidadProduct')
            axios.post('editProductCart', {
                        id_product: idProduct,
                        precioBaseProduct: precioBaseProduct,
                        descuentoProduct: descuentoProduct,
                        cantidadProduct: cantidadProduct,
                        precioTotal: precioTotal,
                        impuestoProduct: impuestoProduct
                    })
                    .then(function (response) {
                        if (response.data == 'no'){
                            Swal.fire({
                                title: 'Error!',
                                    text: 'Comuniquese con el administrador.',
                                    icon: 'error',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            return
                        }
    
                        if(response.data == 'actualizado'){ 
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2000,
                                timerProgressBar: true,   
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })

                            Toast.fire({
                                icon: 'success',
                                title: 'Producto del carrito editado'
                            })
                            introJs().exit()
                            checkCart()                            
                            return
                        }
                       
                    })
                    .catch(function (error) {
                      if (error.status == 500){
                        console.log(error)
                              return
                      }
                      
                    })
        }
        
        function triggerChangeQTY(e, cart_id, product_id, product_stock, product_sell_price){
            var timer = 0
            clearTimeout(timer);
             timer=setTimeout(changeQTY(e, cart_id, product_id, product_stock, product_sell_price),1000);

        }

        function changeQTY(e, cart_id, product_id, product_stock, product_sell_price){

            if(e.value !== ''){
                axios.post('changeQTY', {
                        e: e.value,
                        cart_id: cart_id,
                        product_id: product_id,
                        product_stock: product_stock,
                        product_sell_price: product_sell_price
                    })
                    .then(function (response) {
                      if (response.data == 'no'){
                        Swal.fire({
                            title: 'Error!',
                                  text: 'Comuniquese con el administrador.',
                                  icon: 'error',
                                  timer: 2000,
                                  showConfirmButton: false
                              });
                        return
                      }

                      if(response.data == 'actualizado'){                                                
                            checkCart()                            
                        return
                      }
                      
                      if (response.data == 'Producto sin inventario'){
                        Swal.fire({
                            title: '¡Sin Inventario!',
                                  text: 'Producto se encuentra agotado, no puede ser vendido.',
                                  icon: 'error',
                                  timer: 2000,
                                  showConfirmButton: false
                              });
                        return
                      }
                    })
                    .catch(function (error) {
                      if (error.status == 500){
                        console.log(error)
                              return
                      }
                      
                    })
                return
            }else{
                console.log('dont doit')
                return
            }

            
            console.log('pajuo')
        }

        function findProductByName(){
            var inputSearchNameValue = document.getElementById('inputSearchName').value
            var resultProductsByName = document.getElementById('resultProductsByName')
            var initProductsByName = document.getElementById('initProductsByName')
            var paginationProducts = document.getElementById('paginationProducts')
            paginationProducts.innerHTML = ''
            console.log(inputSearchNameValue, 'que pasa')
                if(inputSearchNameValue.length >= 3){
                    initProductsByName.classList.add('hidden')
                    resultProductsByName.innerHTML = ''
                    resultProductsByName.classList.remove('hidden')

                    axios.post('findProductByName', {
                      q: inputSearchNameValue
                    })
                    .then(function (response) {
                        console.log(response, 'que jue mijo')
                      if (response.data == 'no'){
                        Swal.fire({
                                  title: 'Error!',
                                  text: 'Producto no encontrado.',
                                  icon: 'error',
                                  timer: 2000,
                                  showConfirmButton: false,
                              });
                        return
                      }

                      if(response.data.productsCarts[0].impuesto_global == 2)
                       {
                            response.data.productsSimple.data.forEach(function(element){
                                if(element.carts.length !== 0){
                                    resultProductsByName.innerHTML += 
                                    '<div class="w-full p-6 flex flex-row text-center max-w-[17rem] relative">'+
                                    '<div class="absolute right-7 ...">'+
                                        '<p class="p-1 rounded-[24rem] text-white bg-purple-600">'+element.carts[0].qty+'</p>'+
                                    '</div>'+
                                        '<a onclick="addToCart('+element.id+','+element.stock+','+element.precio_base+','+response.data.productsSimple.current_page+',\'' + element.impuesto + '\')" class="shadow p-2 cursor-pointer bg-purple-200 rounded">'+
                                            '<img class="" src="'+element.image+'">'+
                                            '<div class="pt-3">'+
                                                '<p class="capitalize">Nombre: '+element.title+'</p>'+
                                            '</div>'+
                                            '<p class="pt-1 text-gray-900 capitalize">tipo: '+element.tipo+'</p>'+
                                            '<p class="pt-1 text-gray-900">Precio: $'+element.precio_base+'</p>'+
                                        '</a>'+
                                    '</div>'
                                    return
                                }

                                if(element.image !== 'http://localhost/factuvalente/public/uploads/products'){
                                        resultProductsByName.innerHTML += element.stock == 0 ? 
                                        '<div class="w-full p-6 flex flex-row text-center max-w-[17rem]">'+
                                            '<a onclick="addToCart('+element.id+','+element.stock+','+element.precio_base+','+response.data.productsSimple.current_page+',\'' + element.impuesto + '\')" class="shadow p-2 cursor-pointer border-4 border-purple-400 rounded" id="productoVentaNegativo">'+
                                                '<img class="" src="'+element.image+'">'+
                                                '<div class="pt-3">'+
                                                    '<p class="capitalize">Nombre: '+element.title+'</p>'+
                                                '</div>'+
                                                '<p class="pt-1 text-gray-900 capitalize">tipo: '+element.tipo+'</p>'+
                                                '<p class="pt-1 text-gray-900">Precio: $'+element.precio_base+'</p>'+
                                                '<span class="pt-1 text-purple-600">PRODUCTO AGOTADO</span>'+
                                            '</a>'+
                                        '</div>' : 
                                
                                        '<div class="w-full p-6 flex flex-row text-center max-w-[17rem]">'+
                                            '<a onclick="addToCart('+element.id+','+element.stock+','+element.precio_base+','+response.data.productsSimple.current_page+',\'' + element.impuesto + '\')" class="shadow p-2 cursor-pointer">'+
                                                '<img class="" src="'+element.image+'">'+
                                                '<div class="pt-3">'+
                                                    '<p class="capitalize">Nombre: '+element.title+'</p>'+
                                                '</div>'+
                                                '<p class="pt-1 text-gray-900 capitalize">Tipo: '+element.tipo+'</p>'+
                                                '<p class="pt-1 text-gray-900">Precio: $'+element.precio_base+'</p>'+
                                            '</a>'+
                                        '</div>'
                                            if(element.venta_negativo == 'venta_negativo'){
                                                var productoVentaNegativo = document.getElementById('productoVentaNegativo')
                                                productoVentaNegativo.classList.add('border-dashed')
                                                return
                                            }
                                    }
                            })
                            return
                        } 

                        console.log(response.data, 'habla pecho rajao')

                      if(response.data.productsSimple.data){     
                                                               
                        response.data.productsSimple.data.forEach(function(element){
                                    console.log(element, 'pecho rajao')
                            if(element.image !== 'http://localhost/factuvalente/public/uploads/products'){
                                        resultProductsByName.innerHTML += element.stock == 0 ? 
                                        '<div class="w-full p-6 flex flex-row text-center max-w-[17rem]">'+
                                    '<a onclick="addToCart('+element.id+','+element.stock+','+element.precio_base+','+response.data.productsSimple.current_page+',\'' + element.impuesto + '\')" class="shadow p-2 cursor-pointer border-4 border-purple-400 rounded" id="productoVentaNegativo">'+
                                        '<img class="" src="'+element.image+'">'+
                                        '<div class="pt-3">'+
                                            '<p class="capitalize">Nombre: '+element.title+'</p>'+
                                        '</div>'+
                                        '<p class="pt-1 text-gray-900 capitalize">tipo: '+element.tipo+'</p>'+
                                        '<p class="pt-1 text-gray-900">Precio: $'+element.sell_price+'</p>'+
                                        '<span class="pt-1 text-purple-600">PRODUCTO AGOTADO</span>'+
                                    '</a>'+
                                '</div>' : 
                                
                                '<div class="w-full p-6 flex flex-row text-center max-w-[17rem]">'+
                                    '<a onclick="addToCart('+element.id+','+element.stock+','+element.precio_base+','+response.data.productsSimple.current_page+',\'' + element.impuesto + '\')" class="shadow p-2 cursor-pointer">'+
                                        '<img class="" src="'+element.image+'">'+
                                        '<div class="pt-3">'+
                                            '<p class="capitalize">Nombre: '+element.title+'</p>'+
                                        '</div>'+
                                        '<p class="pt-1 text-gray-900 capitalize">Tipo: '+element.tipo+'</p>'+
                                        '<p class="pt-1 text-gray-900">Precio: $'+element.sell_price+'</p>'+
                                    '</a>'+
                                '</div>'
                                if(element.venta_negativo == 'venta_negativo'){
                                    var productoVentaNegativo = document.getElementById('productoVentaNegativo')
                                    productoVentaNegativo.classList.add('border-dashed')
                                    return
                                }
                            }
                        })
                        return
                      }
                      
                    })
                    .catch(function (error) {
                      if (error.status == 500){
                        console.log(error)
                              return
                      }
                      
                    })
                }
                if(inputSearchNameValue.length == 0){

                    resultProductsByName.innerHTML =''
                    resultProductsByName.classList.add('hidden')
                    initProductsByName.classList.remove('hidden')
                    productByName()
                }
                
               
            
        }

        function findProductByBarcode(){
            var inputSearchBarcodeValue = document.getElementById('inputSearchBarcode').value
            var resultProductsByBarcode = document.getElementById('resultProductsByBarcode')
            var initProductsByName = document.getElementById('initProductsByName')
            var paginationProducts = document.getElementById('paginationProducts')
            paginationProducts.innerHTML = ''
                if(inputSearchBarcodeValue.length >= 3){
                    initProductsByName.classList.add('hidden')
                    resultProductsByName.classList.add('hidden')
                    resultProductsByBarcode.classList.remove('hidden')

                    resultProductsByBarcode.innerHTML = ''

                    axios.post('findProductByBarcode', {
                      q: inputSearchBarcodeValue
                    })
                    .then(function (response) {
                      if (response.data == 'no'){
                        Swal.fire({
                                  title: 'Error!',
                                  text: 'Producto no encontrado.',
                                  icon: 'error',
                                  timer: 2000,
                                  showConfirmButton: false,
                              });
                        return
                      }
                      if(response.data.productsCarts[0].impuesto_global == 2){
                            response.data.productsSimple.data.forEach(function(element){

                                        if(element.image !== 'http://localhost/factuvalente/public/uploads/products'){
                                            resultProductsByBarcode.innerHTML += element.stock == 0 ? 
                                            '<div class="w-full p-6 flex flex-row text-center max-w-[17rem]">'+
                                        '<a onclick="addToCart('+element.id+','+element.stock+','+element.precio_base+','+response.data.productsSimple.current_page+',\'' + element.impuesto + '\')" class="shadow p-2 cursor-pointer border-4 border-purple-400 rounded" id="productoVentaNegativo">'+
                                            '<img class="" src="'+element.image+'">'+
                                            '<div class="pt-3">'+
                                                '<p class="capitalize">Nombre: '+element.title+'</p>'+
                                            '</div>'+
                                            '<p class="pt-1 text-gray-900 capitalize">tipo: '+element.tipo+'</p>'+
                                            '<p class="pt-1 text-gray-900">Precio: $'+element.precio_base+'</p>'+
                                            '<span class="pt-1 text-purple-600">PRODUCTO AGOTADO</span>'+
                                        '</a>'+
                                    '</div>' : 
                                    
                                    '<div class="w-full p-6 flex flex-row text-center max-w-[17rem]">'+
                                        '<a onclick="addToCart('+element.id+','+element.stock+','+element.precio_base+','+response.data.productsSimple.current_page+',\'' + element.impuesto + '\')" class="shadow p-2 cursor-pointer">'+
                                            '<img class="" src="'+element.image+'">'+
                                            '<div class="pt-3">'+
                                                '<p class="capitalize">Nombre: '+element.title+'</p>'+
                                            '</div>'+
                                            '<p class="pt-1 text-gray-900 capitalize">Tipo: '+element.tipo+'</p>'+
                                            '<p class="pt-1 text-gray-900">Precio: $'+element.precio_base+'</p>'+
                                        '</a>'+
                                    '</div>'
                                    if(element.venta_negativo == 'venta_negativo'){
                                        var productoVentaNegativo = document.getElementById('productoVentaNegativo')
                                        productoVentaNegativo.classList.add('border-dashed')
                                        return
                                    }
                                }
                            })
                        return
                    }

                    if(response.data.productsSimple.data){     
                                                               
                        response.data.productsSimple.data.forEach(function(element){

                                    if(element.image !== 'http://localhost/factuvalente/public/uploads/products'){
                                        resultProductsByBarcode.innerHTML += element.stock == 0 ? 
                                        '<div class="w-full p-6 flex flex-row text-center max-w-[17rem]">'+
                                    '<a onclick="addToCart('+element.id+','+element.stock+','+element.precio_base+','+response.data.productsSimple.current_page+',\'' + element.impuesto + '\')" class="shadow p-2 cursor-pointer border-4 border-purple-400 rounded" id="productoVentaNegativo">'+
                                        '<img class="" src="'+element.image+'">'+
                                        '<div class="pt-3">'+
                                            '<p class="capitalize">Nombre: '+element.title+'</p>'+
                                        '</div>'+
                                        '<p class="pt-1 text-gray-900 capitalize">tipo: '+element.tipo+'</p>'+
                                        '<p class="pt-1 text-gray-900">Precio: $'+element.sell_price+'</p>'+
                                        '<span class="pt-1 text-purple-600">PRODUCTO AGOTADO</span>'+
                                    '</a>'+
                                '</div>' : 
                                
                                '<div class="w-full p-6 flex flex-row text-center max-w-[17rem]">'+
                                    '<a onclick="addToCart('+element.id+','+element.stock+','+element.precio_base+','+response.data.productsSimple.current_page+',\'' + element.impuesto + '\')" class="shadow p-2 cursor-pointer">'+
                                        '<img class="" src="'+element.image+'">'+
                                        '<div class="pt-3">'+
                                            '<p class="capitalize">Nombre: '+element.title+'</p>'+
                                        '</div>'+
                                        '<p class="pt-1 text-gray-900 capitalize">Tipo: '+element.tipo+'</p>'+
                                        '<p class="pt-1 text-gray-900">Precio: $'+element.sell_price+'</p>'+
                                    '</a>'+
                                '</div>'
                                if(element.venta_negativo == 'venta_negativo'){
                                    var productoVentaNegativo = document.getElementById('productoVentaNegativo')
                                    productoVentaNegativo.classList.add('border-dashed')
                                    return
                                }
                            }
                        })
                        return
                        }
                      
                    })
                    .catch(function (error) {
                      if (error.status == 500){
                        console.log(error)
                              return
                      }
                      
                    })
                }
                if(inputSearchBarcodeValue.length == 0){
                    resultProductsByBarcode.innerHTML =''
                    resultProductsByBarcode.classList.add('hidden')
                    initProductsByName.classList.remove('hidden')
                }
                
               
            
        }

        function triggerSearch(data){

            var searchName = document.getElementById('searchName')
            var searchNameAnim = document.getElementById('searchNameAnim')
            var searchBarcode = document.getElementById('searchBarcode')
            var searchBarcodeAnim = document.getElementById('searchBarcodeAnim')
            var inputSearchName = document.getElementById('inputSearchName')
            var resultProductsByName = document.getElementById('resultProductsByName')
            var initProductsByName = document.getElementById('initProductsByName')

            var inputSearchNameValue = document.getElementById('inputSearchName').value
            var inputSearchBarcode = document.getElementById('inputSearchBarcode')
            var inputSearchBarcodeValue = document.getElementById('inputSearchBarcode').value
            
            switch (data) {
                case 1:
                    searchName.classList.add('hidden')
                    searchNameAnim.classList.remove('hidden')
                    searchBarcode.classList.remove('hidden')
                    searchBarcodeAnim.classList.add('hidden')
                    inputSearchName.classList.remove('hidden')
                    inputSearchBarcode.classList.add('hidden')
                    inputSearchName.focus()

                    break;
                case 2:
                    searchName.classList.remove('hidden')
                    searchNameAnim.classList.add('hidden')
                    searchBarcode.classList.add('hidden')
                    searchBarcodeAnim.classList.remove('hidden')
                    inputSearchName.classList.add('hidden')
                    inputSearchBarcode.classList.remove('hidden')
                    inputSearchBarcode.focus()
                    break;
            }
            return
        }

        function addToCart(product_id, product_stock, product_sell_price, url, product_impuesto){
            document.getElementById('urlDom').value = url
                console.log(url, 'urlDom')
            axios.post('addToCart', {
                        product_id: product_id,
                        product_stock: product_stock,
                        product_sell_price: product_sell_price,
                        product_impuesto
                    })
                    .then(function (response) {
                      if (response.data == 'no'){
                        Swal.fire({
                            title: 'Error!',
                                  text: 'Comuniquese con el administrador.',
                                  icon: 'error',
                                  timer: 2000,
                                  showConfirmButton: false
                              });
                        return
                      }

                      if(response.data == 'guardado' || response.data == 'actualizado'){                                                
                            checkCart()
                        return
                      }
                      
                      if (response.data == 'Producto sin inventario'){
                        Swal.fire({
                            title: '¡Sin Inventario!',
                                  text: 'Producto se encuentra agotado, no puede ser vendido.',
                                  icon: 'error',
                                  timer: 2000,
                                  showConfirmButton: false
                              });
                        return
                      }
                    })
                    .catch(function (error) {
                      if (error.status == 500){
                        console.log(error)
                              return
                      }
                      
                    })

            return
        }

        function domFacturacion(){
            var initDomFacturacion = document.getElementById('initDomFacturacion')
            var domFacturacion = document.getElementById('domFacturacion')
            var triggerDomFacturacion = document.getElementById('triggerDomFacturacion').value

            if(triggerDomFacturacion == 2){
                initDomFacturacion.classList.add('hidden')
                domFacturacion.classList.remove('hidden')
                domFacturacion.innerHTML = 'dale mano'
                return
            }

        }

        function plusCantidad(cart_id, product_id, product_stock, product_sell_price){
            axios.post('plusCantidad', {
                        cart_id: cart_id,
                        product_id: product_id,
                        product_stock: product_stock,
                        product_sell_price: product_sell_price
                    })
                    .then(function (response) {
                      if (response.data == 'no'){
                        Swal.fire({
                            title: 'Error!',
                                  text: 'Comuniquese con el administrador.',
                                  icon: 'error',
                                  timer: 2000,
                                  showConfirmButton: false
                              });
                        return
                      }

                      if(response.data == 'actualizado'){                                                
                            checkCart()
                                                        
                        return
                      }
                      
                      if (response.data == 'Producto sin inventario'){
                        Swal.fire({
                            title: '¡Sin Inventario!',
                                  text: 'Producto se encuentra agotado, no puede ser vendido.',
                                  icon: 'error',
                                  timer: 2000,
                                  showConfirmButton: false
                              });
                        return
                      }
                    })
                    .catch(function (error) {
                      if (error.status == 500){
                        console.log(error)
                              return
                      }
                      
                    })

            return
        }

        function minusCantidad(cart_id, product_id, product_stock, product_sell_price){
            axios.post('minusCantidad', {
                        cart_id: cart_id,
                        product_id: product_id,
                        product_stock: product_stock,
                        product_sell_price: product_sell_price
                    })
                    .then(function (response) {
                      if (response.data == 'no'){
                        Swal.fire({
                            title: 'Error!',
                                  text: 'Comuniquese con el administrador.',
                                  icon: 'error',
                                  timer: 2000,
                                  showConfirmButton: false
                              });
                        return
                      }

                      if(response.data == 'actualizado'){                                                
                            checkCart()                            
                        return
                      }
                      
                      if (response.data == 'Producto sin inventario'){
                        Swal.fire({
                            title: '¡Sin Inventario!',
                                  text: 'Producto se encuentra agotado, no puede ser vendido.',
                                  icon: 'error',
                                  timer: 2000,
                                  showConfirmButton: false
                              });
                        return
                      }
                    })
                    .catch(function (error) {
                      if (error.status == 500){
                        console.log(error)
                              return
                      }
                      
                    })

            return
        }

        function deleteCurrentCart(cart_id){
            axios.post('deleteCurrentCart', {
                        cart_id: cart_id
                    })
                    .then(function (response) {
                      if (response.data == 'no'){
                        Swal.fire({
                            title: 'Error!',
                                  text: 'Comuniquese con el administrador.',
                                  icon: 'error',
                                  timer: 2000,
                                  showConfirmButton: false
                              });
                        return
                      }

                      if(response.data == 'eliminado'){                                                
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2000,
                                timerProgressBar: true,   
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            });

                            Toast.fire({
                                icon: 'success',
                                title: 'Producto eliminado del carrito'
                            });
                            document.getElementById('triggerImpuestoGlobal').value = 1
                             checkCart()
                            return
                      }
                      
                    })
                    .catch(function (error) {
                      if (error.status == 500){
                        console.log(error)
                              return
                      }
                      
                    })

            return
        }

        // Function to handle the global tax checkbox change event
        function doitImpuestoGlobal() {
            // Get the checkbox element for impuestoGlobal
            var impuestoGlobal = document.getElementById('impuestoGlobal');
            console.log('1')
            // Check if the checkbox is checked
            if (impuestoGlobal.checked == true) {
                console.log('2')
                // If checked, send a request to apply global tax to the cart
                axios.post('impuestoGlobalCart', {
                        cart_id: 1 // Specify the cart ID
                    })
                    .then(function (response) {
                        console.log('3')
                        // Handle the response
                        if (response.data == 'no') {
                            console.log('no')
                            // Show an error message if the operation fails
                            Swal.fire({
                                title: 'Error!',
                                text: 'Comuniquese con el administrador.',
                                icon: 'error',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            return;
                        }

                        if (response.data == 'sin impuesto') {
                            console.log('sin impuesto')
                            // Show success message and refresh the cart
                            Swal.fire({
                                title: 'Impuesto Global',
                                text: 'Productos del carrito actualizados sin impuesto',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            // Update the UI to reflect the changes
                            checkCart();
                            initProductsByName.classList.remove('hidden');
                            resultProductsByName.innerHTML = '';
                            resultProductsByName.classList.add('hidden');
                            resultProductsByBarcode.classList.add('hidden');
                            resultProductsByBarcode.innerHTML = '';
                            return;
                        }

                        if (response.data == 'ya realizado') {
                            console.log('ya realizado')
                            // Refresh the cart if the action was already performed
                            checkCart();
                            return;
                        }
                        // Update the trigger value and refresh the cart
                        document.getElementById('triggerImpuestoGlobal').value = 2;
                        console.log('4')
                        checkCart();

                    })
                    .catch(function (error) {
                        // Handle errors
                        if (error.status == 500) {
                            console.log(error);
                            return;
                        }
                    });

                
            } else {
                console.log('5')
                // If unchecked, send a request to remove global tax from the cart
                axios.post('impuestoGlobalCart', {
                        cart_id: 1 // Specify the cart ID
                    })
                    .then(function (response) {
                        console.log('6')
                        // Handle the response
                        if (response.data == 'no') {
                            console.log('no, 7')
                            // Show an error message if the operation fails
                            Swal.fire({
                                title: 'Error!',
                                text: 'Comuniquese con el administrador.',
                                icon: 'error',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            return;
                        }

                        if (response.data == 'con impuesto') {
                            console.log('con impuesto 8')
                            // Show success message and refresh the cart
                            Swal.fire({
                                title: 'Impuesto Global',
                                text: 'Productos del carrito actualizados con impuesto',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            // Update the UI to reflect the changes
                            impuestoGlobal.checked = false;
                            checkCart();
                            initProductsByName.classList.remove('hidden');
                            resultProductsByName.innerHTML = '';
                            resultProductsByName.classList.add('hidden');
                            resultProductsByBarcode.classList.add('hidden');
                            resultProductsByBarcode.innerHTML = '';
                            return;
                        }
                        console.log('9')
                        // Update the trigger value and refresh the cart
                        document.getElementById('triggerImpuestoGlobal').value = 1;
                        checkCart();

                    })
                    .catch(function (error) {
                        // Handle errors
                        if (error.status == 500) {
                            console.log(error);
                            return;
                        }
                    });
                
            }
        }

        function deleteCart(cart_id){
            axios.post('deleteCart', {
                        cart_id: cart_id
                    })
                    .then(function (response) {
                      if (response.data == 'no'){
                        Swal.fire({
                            title: 'Error!',
                                  text: 'Comuniquese con el administrador.',
                                  icon: 'error',
                                  timer: 2000,
                                  showConfirmButton: false
                              });
                        return
                      }

                      if(response.data == 'eliminado'){                                                
                            Swal.fire({
                                  title: 'Eliminados!',
                                  text: 'Productos eliminados del carrito',
                                  icon: 'success',
                                  timer: 2000,
                                  showConfirmButton: false,
                              });
                             checkCart()
                            return
                      }
                      
                    })
                    .catch(function (error) {
                      if (error.status == 500){
                        console.log(error)
                              return
                      }
                      
                    })

            return
        }

        function impuestoGeneral(item){
            console.log(item.value, 'item')
            document.getElementById('triggerImpuestoGeneral').value = item.value
            checkCart()
        }

        // Define a global flag variable
        let isDescuentoUpdated = false;
        
        function updateDescuentoProduct(value) {
            // Check if the function has already run
            if (isDescuentoUpdated) {
                console.log('updateDescuentoProduct has already run.');
                return;
            }
        
            // Update the global descuentoProduct variable
            window.descuentoProduct = value.replace('$', '');
            console.log('Updated descuentoProduct:', window.descuentoProduct);
        
            // Update the button state
            buttonEditPro1.classList.add('hidden');
            buttonEditPro2.classList.remove('hidden');
            buttonEditPro2.innerHTML = '<button id="buttonEditPro2" onclick="doitEditPro(' + value + ')" class="float-right items-center px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">Editar</button>';
        
            // Set the flag to true
            isDescuentoUpdated = true;
        }

                // Define a global flag variable
        let isPrecioBaseUpdated = false;
        
        function updatePrecioBaseProduct(value) {
            // Check if the function has already run
            if (isPrecioBaseUpdated) {
                console.log('updatePrecioBaseProduct has already run.');
                return;
            }
        
            // Update the global precioBaseProduct variable
            window.precioBaseProduct = value.replace('$', '');
            console.log('Updated precioBaseProduct:', window.precioBaseProduct);
        
            // Update the button state
            buttonEditPro1.classList.add('hidden');
            buttonEditPro2.classList.remove('hidden');
            buttonEditPro2.innerHTML = '<button id="buttonEditPro2" onclick="doitEditPro(' + value + ')" class="float-right items-center px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">Editar</button>';
        
            // Set the flag to true
            isPrecioBaseUpdated = true;
        }

                // Define a global flag variable
        let isCantidadUpdated = false;
        
        function updateCantidadProduct(value) {
            // Check if the function has already run
            if (isCantidadUpdated) {
                console.log('updateCantidadProduct has already run.');
                return;
            }
        
            // Update the global cantidadProduct variable
            window.cantidadProduct = value;
            console.log('Updated cantidadProduct:', window.cantidadProduct);
        
            // Update the button state
            buttonEditPro1.classList.add('hidden');
            buttonEditPro2.classList.remove('hidden');
            buttonEditPro2.innerHTML = '<button id="buttonEditPro2" onclick="doitEditPro(' + value + ')" class="float-right items-center px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">Editar</button>';
        
            // Set the flag to true
            isCantidadUpdated = true;
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
        const draggables = document.querySelectorAll('.draggable');
        const dropzone = document.getElementById('dropzone');

        let draggedElement = null;

        // Add event listeners to draggable elements
        draggables.forEach(draggable => {
            draggable.addEventListener('dragstart', (e) => {
                draggedElement = e.target;
                e.target.style.opacity = '0.5';
            });

            draggable.addEventListener('dragend', (e) => {
                e.target.style.opacity = '1';
                draggedElement = null;
            });
        });

        // Add event listeners to the dropzone
        dropzone.addEventListener('dragover', (e) => {
            e.preventDefault(); // Allow dropping
            dropzone.classList.add('drag-over');
        });

        dropzone.addEventListener('dragleave', () => {
            dropzone.classList.remove('drag-over');
        });

        dropzone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropzone.classList.remove('drag-over');
            if (draggedElement) {
                dropzone.appendChild(draggedElement); // Move the dragged element to the dropzone
            }
        });
    </script>
<link rel="stylesheet" href="./assets/css/selectSearch.css" />
<script src="./assets/js/selectSearch.js"></script>
<style>
    .introjs-tooltip-title{
        color:rgb(147, 51, 234);
        border: 1;
        border-bottom: solid;
        border-bottom-width: thin;
    }
    .introjs-tooltip{
        width: 900px;
    }
    .introjs-helperLayer {
    box-shadow: rgb(147, 51, 234) 0px 0px 1px 2px, rgba(33, 33, 33, 0.5) 0px 0px 0px 5000px!important;
}
</style>
<style>
        .draggable {
            background-color: #9333ea;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: grab;
        }

        .dropzone {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            padding: 10px;
        }

        .drag-over {
            background-color: #f3e8ff;
        }
    </style>

@endsection