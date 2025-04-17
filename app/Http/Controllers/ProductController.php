<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Codigo;
use App\Models\ProductDetail;
use App\Models\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Image;
use File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         // get categories
        //  $products = Product::where('is_active', 1)
        //                     ->where('tipo', 'producto')
        //                     ->latest()
        //                     ->paginate(7);

        $products = Product::when(request()->q, function($products) {
            $products = $products->where('title', 'like', '%'. request()->q . '%');
        })->where('is_active', 1)->where('tipo', 'producto')->orwhere('barcode', request()->q)->latest()->paginate(7);

        $categories = Category::where('is_active', 1)
                            ->latest()
                            ->get();

        $codigos = Codigo::where('is_active', 1)
                            ->latest()
                            ->get();
            // return
            return view('productos', compact('products', 'categories', 'codigos'));
     }

     public function servicios()
     {

        $products = Product::where('is_active', 1)
                            ->where('tipo', 'producto')
                            ->latest()
                            ->paginate(7);
        // get servicios
        $servicios = Product::when(request()->q, function($servicios) {
            $servicios = $servicios->where('title', 'like', '%'. request()->q . '%');
        })->where('is_active', 1)->where('tipo', 'servicio')->orwhere('barcode', request()->q)->latest()->paginate(7);

         $categories = Category::where('is_active', 1)
                             ->latest()
                             ->get();

         $codigos = Codigo::where('is_active', 1)
                             ->latest()
                             ->get();
             // return
             return view('servicios', compact('servicios', 'products', 'categories', 'codigos'));
      }

     public function combos()
      {
         $products = Product::where('is_active', 1)
                             ->where('activo', 1)
                             ->where('tipo', 'producto')
                             ->get();
                             
        // get combos
        $combos = Product::when(request()->q, function($servicios) {
                 $servicios = $servicios->where('title', 'like', '%'. request()->q . '%');
             })->where('is_active', 1)->where('tipo', 'combo')->orwhere('barcode', request()->q)->latest()->paginate(7);
 
          $categories = Category::where('is_active', 1)
                              ->latest()
                              ->get();
 
          $codigos = Codigo::where('is_active', 1)
                              ->latest() 
                              ->get();
              // return
              return view('combos', compact('combos', 'products', 'categories', 'codigos'));
       }


    public function productosFind()
    {
         // get categories
        //  $products = Product::where('is_active', 1)
        //                     ->where('tipo', 'producto')
        //                     ->latest()
        //                     ->paginate(7);

        $products = Product::when(request()->q, function($products) {
            $products = $products->where('category_id', request()->q);
        })->where('is_active', 1)->where('tipo', 'producto')->latest()->paginate(7);

        $categories = Category::where('is_active', 1)
                            ->latest()
                            ->get();

        $codigos = Codigo::where('is_active', 1)
                            ->latest()
                            ->get();
            // return
            return view('productos', compact('products', 'categories', 'codigos'));
     }

     public function serviciosFind()
     {

        $products = Product::where('is_active', 1)
                            ->where('tipo', 'producto')
                            ->latest()
                            ->paginate(7);
        // get servicios
        $servicios = Product::when(request()->q, function($servicios) {
            $servicios = $servicios->where('title', 'like', '%'. request()->q . '%');
        })->where('is_active', 1)->where('tipo', 'servicio')->orwhere('barcode', request()->q)->latest()->paginate(7);

         $categories = Category::where('is_active', 1)
                             ->latest()
                             ->get();

         $codigos = Codigo::where('is_active', 1)
                             ->latest()
                             ->get();
             // return
             return view('servicios', compact('servicios', 'products', 'categories', 'codigos'));
      }

    public function combosFind()
     {
        $products = Product::where('is_active', 1)
                            ->where('activo', 1)
                            ->where('tipo', 'producto')
                            ->get();
                            
       // get combos
       $combos = Product::when(request()->q, function($servicios) {
                $servicios = $servicios->where('title', 'like', '%'. request()->q . '%');
            })->where('is_active', 1)->where('tipo', 'combo')->orwhere('barcode', request()->q)->latest()->paginate(7);

         $categories = Category::where('is_active', 1)
                             ->latest()
                             ->get();

         $codigos = Codigo::where('is_active', 1)
                             ->latest() 
                             ->get();
             // return
             return view('combos', compact('combos', 'products', 'categories', 'codigos'));
      }

       public function productosDetail(Request $request){

        $combosDetail = ProductDetail::where('product_id', $request->id)
                                ->join('products', 'product_details.combo_product', '=', 'products.id')
                                ->select('product_details.*','products.title')
                                ->where('product_details.is_active', 1)
                                ->get();

        return $combosDetail;
    }

    public function findCategoryProduct(Request $request){
        try{
                $q = $request->q;
                // get combos
                $products = Product::when(request()->q, function($servicios) {
                    $servicios = $servicios->where('title', 'like', '%'. request()->q . '%');
                })->where('is_active', 1)->where('tipo', 'combo')->orwhere('barcode', request()->q)->latest()->paginate(7);

                return $products;
            } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function findCatProduct(Request $request){
        try{
                
            $q = $request->q;
            // $products = Product::when(request()->q, function($products) {
            //     $products = $products->where('title', 'like', '%'. request()->q . '%');
            // })->where('is_active', 1)->where('tipo', 'producto')->latest()->paginate(7);
            $products = Product::where('is_active', 1)
                                ->where('tipo', 'producto')
                                ->where('category_id', $q)
                                ->get();

            if(count($products) > 0){
                return  $products;
            }
            //return error if empty input
            return 'no';
        
        } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function findCatService(Request $request){
        try{
                
            $q = $request->q;
            // $products = Product::when(request()->q, function($products) {
            //     $products = $products->where('title', 'like', '%'. request()->q . '%');
            // })->where('is_active', 1)->where('tipo', 'producto')->latest()->paginate(7);
            $products = Product::where('is_active', 1)
                                ->where('tipo', 'servicio')
                                ->where('category_id', $q)
                                ->get();

            if(count($products) > 0){
                return  $products;
            }
            //return error if empty input
            return 'no';
        
        } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function findCatCombo(Request $request){
        try{
                
            $q = $request->q;
            // $products = Product::when(request()->q, function($products) {
            //     $products = $products->where('title', 'like', '%'. request()->q . '%');
            // })->where('is_active', 1)->where('tipo', 'producto')->latest()->paginate(7);
            $products = Product::where('is_active', 1)
                                ->where('tipo', 'combo')
                                ->where('category_id', $q)
                                ->get();

            if(count($products) > 0){
                return  $products;
            }
            //return error if empty input
            return 'no';
        
        } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function searchNameProduct(Request $request){
        try{
                $q = $request->q;
                $products = Product::when(request()->q, function($products) {
                    $products = $products->where('title', 'like', '%'. request()->q . '%');
                })->where('is_active', 1)->where('tipo', 'producto')->orwhere('barcode', $q)->latest()->paginate(7);
                // $products = Product::where('is_active', 1)
                //                     ->where('tipo', 'producto')
                //                     ->where('barcode', $q)
                //                     ->orwhere('title', 'like', '%'. $q . '%')
                //                     ->get();
                if(count($products) > 0){
                    return  $products;
                }
                //return error if empty input
                return 'no';
            
            } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function searchNameServicio(Request $request){
        try{
                $q = $request->q;
                $products = Product::when(request()->q, function($products) {
                    $products = $products->where('title', 'like', '%'. request()->q . '%');
                })->where('is_active', 1)->where('tipo', 'servicio')->orwhere('barcode', $q)->latest()->paginate(7);
                // $products = Product::where('is_active', 1)
                //                     ->where('tipo', 'servicio')
                //                     ->where('barcode', $q)
                //                     ->orwhere('title', 'like', '%'. $q . '%')
                //                     ->get();

                if(count($products) > 0){
                    return  $products;
                }
                //return error if empty input
                return 'no';
            
            } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function searchNameCombo(Request $request){
        try{
                $q = $request->q;
                $products = Product::when(request()->q, function($products) {
                    $products = $products->where('title', 'like', '%'. request()->q . '%');
                })->where('is_active', 1)->where('tipo', 'combo')->orwhere('barcode', $q)->latest()->paginate(7);
                // $products = Product::where('is_active', 1)
                //                     ->where('tipo', 'combo')
                //                     ->where('barcode', $q)
                //                     ->orwhere('title', 'like', '%'. $q . '%')
                //                     ->get();
                if(count($products) > 0){
                    return  $products;
                }
                //return error if empty input
                return 'no';
            
            } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }


    public function productosCreate(Request $request){

        try{    
            //init input validation
            if($request->tipo !== '' && $request->title !== '' && $request->unit !== '' && $request->barcode !== '' && $request->cantidad !== '' && $request->precioBase !== '' && $request->costoInicial !== '' && $request->impuesto !== '' && $request->precioFinal !== '' ){
                                
                    $products = Product::where('is_active', 1)
                                    ->where('title', $request->title)
                                    ->orwhere('barcode', $request->barcode)
                                    ->get();

                    $productsCombo = Product::where('is_active', 1)
                                    ->where('tipo', 'combo')
                                    ->where('title', $request->title)
                                    ->orwhere('barcode', $request->barcode)
                                    ->get();

                    if($products->count() == 0 && $request->tipo == 'producto'){

                        //init validation if product have an image
                        if($image = $request->file('image')){

                            $this->validate($request, [
                                'image' => 'required|image|mimes:jpg,jpeg,png|max:20000',
                            ]);

                            $file = $request->file('image');
                            
                            $imageExtension = $file->getClientOriginalExtension();

                            $data = Storage::disk('public_uploads')->put('productos/' . $file->hashName().'.'.$imageExtension, File::get($file));

                            //create product

                            Product::create([
                                'image'         => $file->hashName(),
                                'barcode'       => $request->barcode,
                                'title'         => $request->title,
                                'buy_price'     => $request->costoInicial,
                                'sell_price'    => $request->precioFinal,
                                'stock'         => $request->cantidad,
                                'impuesto'      => $request->impuesto,
                                'unit'          => $request->unit,
                                'is_active'     => 1,
                                'tipo'          => $request->tipo,
                                'precio_base'   => $request->precioBase,
                                'activo'   => 1
                            ]);

                            return  redirect(route('productos.index'))->with("success", "Combo "."'$request->title'"." agregado correctamente.");
                        }

                        //create product whithout image

                        Product::create([
                            'image'         => 'initImage.jpg',
                            'barcode'       => $request->barcode,
                            'title'         => $request->title,
                            'buy_price'     => $request->costoInicial,
                            'sell_price'    => $request->precioFinal,
                            'stock'         => $request->cantidad,
                            'impuesto'      => $request->impuesto,
                            'unit'          => $request->unit,
                            'is_active'     => 1,
                            'tipo'          => $request->tipo,
                            'precio_base'   => $request->precioBase,
                            'activo'   => 1
                        ]);
                         
                        return  redirect(route('productos.index'))->with("success", "Producto "."'$request->title'"." agregado correctamente.");

                    }

                    //end tipo producto

                    if($products->count() == 0 && $request->tipo == 'servicio'){
                        //init validation if servicio have an image
                        if($image = $request->file('image')){

                            $this->validate($request, [
                                'image' => 'required|image|mimes:jpg,jpeg,png|max:20000',
                            ]);

                            $file = $request->file('image');
                            
                            $imageExtension = $file->getClientOriginalExtension();

                            $data = Storage::disk('public_uploads')->put('productos/' . $file->hashName().'.'.$imageExtension, File::get($file));

                            //create servicio

                            Product::create([
                                'image'         => $file->hashName().'.'.$imageExtension,
                                'barcode'       => $request->barcode,
                                'title'         => $request->title,
                                'buy_price'     => $request->costoInicial,
                                'sell_price'    => $request->precioFinal,
                                'stock'         => $request->cantidad,
                                'impuesto'      => $request->impuesto,
                                'unit'          => $request->unit,
                                'is_active'     => 1,
                                'tipo'          => $request->tipo,
                                'precio_base'   => $request->precioBase,
                                'activo'   => 1
                            ]);

                            return  redirect(route('productos.index'))->with("success", "Combo "."'$request->title'"." agregado correctamente.");
                        }

                        //create servicio whithout image
                        $product = Product::create([
                            'image'         => 'initImage.jpg',
                            'barcode'       => $request->barcode,
                            'title'         => $request->title,
                            'buy_price'     => $request->costoInicial,
                            'sell_price'    => $request->precioFinal,
                            'stock'         => $request->cantidad,
                            'impuesto'         => $request->impuesto,
                            'unit'         => $request->unit,
                            'is_active'         => 1,
                            'tipo'         => $request->tipo,
                            'precio_base'         => $request->precioBase,
                            'activo'   => 1
                        ]);
                        return  redirect(route('servicios'))->with("success", "Servicio "."'$request->title'"." agregado correctamente.");

                    }

                    //end tipo servicio

                    if($productsCombo->count() == 0 && $request->tipo == 'combo'){

                        //init validation if product have an image
                        if($image = $request->file('image')){

                            $this->validate($request, [
                                'image' => 'required|image|mimes:jpg,jpeg,png|max:20000',
                            ]);

                            $file = $request->file('image');
                            
                            $imageExtension = $file->getClientOriginalExtension();

                            $data = Storage::disk('public_uploads')->put('productos/' . $file->hashName().'.'.$imageExtension, File::get($file));

                            //create product

                            Product::create([
                                'image'         => $file->hashName().'.'.$imageExtension,
                                'barcode'       => $request->barcode,
                                'title'         => $request->title,
                                'buy_price'     => $request->costoInicial,
                                'sell_price'    => $request->precioFinal,
                                'stock'         => $request->cantidad,
                                'impuesto'      => $request->impuesto,
                                'unit'          => $request->unit,
                                'is_active'     => 1,
                                'tipo'          => $request->tipo,
                                'precio_base'   => $request->precioBase,
                                'activo'   => 1
                            ]);

                            return  redirect(route('productos.index'))->with("success", "Combo "."'$request->title'"." agregado correctamente.");
                        }

                        //create combo without image
                        $product = Product::create([
                            'image'         => 'initImage.jpg',
                            'barcode'       => $request->barcode,
                            'title'         => $request->title,
                            'buy_price'     => $request->costoInicial,
                            'sell_price'    => $request->precioFinal,
                            'stock'         => $request->cantidad,
                            'impuesto'      => $request->impuesto,
                            'unit'          => $request->unit,
                            'is_active'     => 1,
                            'tipo'          => $request->tipo,
                            'precio_base'   => $request->precioBase,
                            'activo'   => 1
                        ]);

                        $cantidadCombo = [];
                        $cantidadCombo['comboCant1'] = [
                            'cant1' => $request->input('comboCant-1'),
                            'prod1' => $request->input('comboProduct-1'),
                        ];
                        $cantidadCombo['comboCant2'] = [
                            'cant2' => $request->input('comboCant-2'),
                            'prod2' => $request->input('comboProduct-2'),
                        ];
                        $cantidadCombo['comboCant3'] = [
                            'cant3' => $request->input('comboCant-3'),
                            'prod3' => $request->input('comboProduct-3'),
                        ];
                        $cantidadCombo['comboCant4'] = [
                            'cant4' => $request->input('comboCant-4'),
                            'prod4' => $request->input('comboProduct-4'),
                        ];
                        $cantidadCombo['comboCant5'] = [
                            'cant5' => $request->input('comboCant-5'),
                            'prod5' => $request->input('comboProduct-5'),
                        ];
                        $cantidadCombo['comboCant6'] = [
                            'cant6' => $request->input('comboCant-6'),
                            'prod6' => $request->input('comboProduct-6'),
                        ];
                        $cantidadCombo['comboCant7'] = [
                            'cant7' => $request->input('comboCant-7'),
                            'prod7' => $request->input('comboProduct-7'),
                        ];
                        $cantidadCombo['comboCant8'] = [
                            'cant8' => $request->input('comboCant-8'),
                            'prod8' => $request->input('comboProduct-8'),
                        ];
                        $cantidadCombo['comboCant9'] = [
                            'cant9' => $request->input('comboCant-9'),
                            'prod9' => $request->input('comboProduct-9'),
                        ];
                        $cantidadCombo['comboCant10'] = [
                            'cant10' => $request->input('comboCant-10'),
                            'prod10' => $request->input('comboProduct-10'),
                        ];

                        $i = 1;
                            foreach ($cantidadCombo as $itemCant) {
                                if ($itemCant['cant'.$i] !== '' && $itemCant['prod'.$i]) {
                                $productTitle = Product::findOrFail($product->id);

                                    //create product_details
                                    $product->details()->create([
                                        'product_id' => $product->id,
                                        'qty' => $itemCant['cant'.$i],
                                        'combo_product' => $itemCant['prod'.$i],
                                        'title_product' => 'D',
                                        'is_active' => 1
                                    ]);

                                }
                                $i++;
                            }



                    return  redirect(route('productos.index'))->with("success", "Combo agregado correctamente.");

                }
                            //end tipo combo
                            return  redirect(route('productos.index'))->with("error", "Número "."'$request->barcode'"." introducido para el input barcode y nombre "."'$request->title'".", ya existe en la base de datos.");
            }
            //end input validation

            //return error if empty input
            return  redirect(route('productos.index'))->with("error", "Campos requeridos estan vacíos, debe llenar el formulario básico de productos correctamente.");
            
            } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function removeComboProduct(Request $request){

        $combosDetail = ProductDetail::findOrFail($request->id);

        //update product
        $combosDetail->update([
            'is_active' => 2
        ]);

        $data = [];
        $data['details'] = [
            'combosDetail' => $combosDetail,
            'i' => $request->i,
        ];
        return $data;

    }

    public function productosEdit(Request $request){
        $val_id_product = $request->val_id_product;
        $val_tipo_edit = $request->val_tipo_edit;
        $val_title_edit = $request->val_title_edit;
        $val_unit_edit = $request->val_unit_edit;
        $val_barcode_edit = $request->val_barcode_edit;
        $val_stock_edit = $request->val_stock_edit;
        $val_buy_price_edit = $request->val_buy_price_edit;
        $val_precio_base_edit = $request->val_precio_base_edit;
        $val_impuesto_edit = $request->val_impuesto_edit;
        $val_sell_price_edit = $request->val_sell_price_edit;
        $val_description_edit = $request->val_description_edit;
        $val_cantidad_minima_edit = $request->val_cantidad_minima_edit;
        $val_cantidad_maxima_edit = $request->val_cantidad_maxima_edit;
        $val_venta_negativo_edit = $request->val_venta_negativo_edit;
        $val_categoria_edit = $request->val_categoria_edit;
        $val_codigo_unspsc_edit = $request->val_codigo_unspsc_edit;

        $tipo_edit = $request->tipo_edit;
        $title_edit = $request->title_edit;
        $unit_edit = $request->unit_edit;
        $barcode_edit = $request->barcode_edit;
        $stock_edit = $request->stock_edit;
        $buy_price_edit = $request->buy_price_edit;
        $precio_base_edit = $request->precio_base_edit;
        $impuesto_edit = $request->impuesto_edit;
        $sell_price_edit = $request->sell_price_edit;
        $description_edit = $request->description_edit;
        $cantidad_minima_edit = $request->cantidad_minima_edit;
        $cantidad_maxima_edit = $request->cantidad_maxima_edit;
        $venta_negativo_edit = $request->venta_negativo_edit;
        $categoria_edit = $request->categoria_edit;
        $codigo_unspsc_edit = $request->codigo_unspsc_edit;

        try {
            // init validation empty inputs
            if( $val_tipo_edit == $tipo_edit &&
                $val_title_edit == $title_edit &&
                $val_unit_edit == $unit_edit &&
                $val_barcode_edit == $barcode_edit &&
                $val_stock_edit == $stock_edit &&
                $val_buy_price_edit == $buy_price_edit &&
                $val_precio_base_edit == $precio_base_edit &&
                $val_impuesto_edit == $impuesto_edit &&
                $val_sell_price_edit == $sell_price_edit &&
                $val_description_edit == $description_edit &&
                $val_cantidad_minima_edit == $cantidad_minima_edit &&
                $val_cantidad_maxima_edit == $cantidad_maxima_edit &&
                $val_venta_negativo_edit == $venta_negativo_edit  &&
                $val_categoria_edit == $categoria_edit &&
                $val_codigo_unspsc_edit == $codigo_unspsc_edit &&
                $request->file('image_edit') == '' &&
                $request->input('comboCantEdit-1') == '' &&
                $request->input('send_val_combo') == ''){

                return  redirect(route('productos.index'))->with("error", "Ningún campo a modificar, no se realizó ninguna acción.");

            }
            // end empty input validation

        if($tipo_edit == 'producto'){
                // validate if barcode its the same
                    if($barcode_edit !== $val_barcode_edit){
                        $products = Product::where('is_active', 1)
                            ->where('barcode', $request->barcode_edit)
                            ->get();
                        if($products->count() == 0 ){

                            // find Product to update
                                $product = Product::findOrFail($request->val_id_product);
                                if($product){
                                //update product
                                $product->update([
                                    'tipo' => $tipo_edit,
                                    'title' => $title_edit,
                                    'unit' => $unit_edit,
                                    'barcode' => $barcode_edit,
                                    'stock' => $stock_edit,
                                    'buy_price' => $buy_price_edit,
                                    'precio_base' => $precio_base_edit,
                                    'impuesto' => $impuesto_edit,
                                    'sell_price' => $sell_price_edit,
                                    'description' => $description_edit,
                                    'minimo' => $cantidad_minima_edit,
                                    'maximo' => $cantidad_maxima_edit,
                                    'venta_negativo' => $venta_negativo_edit,
                                    'category_id' => $categoria_edit,
                                    'codigo_unspsc' => $codigo_unspsc_edit,

                                ]);

                                $fileImageEdit = $request->file('image_edit');
                                if($fileImageEdit !== null){
                                    $imageExtension = $fileImageEdit->getClientOriginalExtension();

                                    // Image::make( $fileImageEdit->getRealPath() )->fit(340, 340)->save('public/uploads/products/' . $fileImageEdit->hashName());
                                    Storage::disk('public_uploads')->put('products/' . $fileImageEdit->hashName(), File::get($fileImageEdit));

                                    $product->update([
                                        'image' => $fileImageEdit->hashName()
                                    ]);
                                 }
                                return  redirect(route('productos.index'))->with("success", "Producto "."'$title_edit'"." editado correctamente.");
                                }

                        }
                        return  redirect(route('productos.index'))->with("error", "Barcode "."'$barcode_edit'"." ya existe en la base de datos, por favor seleccione otro.");
                    }

                    if($title_edit !== $val_title_edit){

                        $products = Product::where('is_active', 1)
                                            ->where('title', $title_edit)
                                            ->get();

                        if($products->count() == 0 ){

                        // find Product to update
                            $product = Product::findOrFail($val_id_product);

                            if($product){
                            //update product
                            $product->update([
                                'tipo' => $tipo_edit,
                                'title' => $title_edit,
                                'unit' => $unit_edit,
                                'barcode' => $barcode_edit,
                                'stock' => $stock_edit,
                                'buy_price' => $buy_price_edit,
                                'precio_base' => $precio_base_edit,
                                'impuesto' => $impuesto_edit,
                                'sell_price' => $sell_price_edit,
                                'description' => $description_edit,
                                'minimo' => $cantidad_minima_edit,
                                'maximo' => $cantidad_maxima_edit,
                                'venta_negativo' => $venta_negativo_edit,
                                'category_id' => $categoria_edit,
                                'codigo_unspsc' => $codigo_unspsc_edit,

                            ]);

                            $fileImageEdit = $request->file('image_edit');
                            if($fileImageEdit !== null){
                                dd('dale');
                            }
                            return  redirect(route('productos.index'))->with("success", "Producto "."'$request->title_edit'"." editado correctamente.");
                            }
                        }
                        return  redirect(route('productos.index'))->with("error", "Nombre de producto "."'$title_edit'"." ya existe en la base de datos, por favor seleccione otro.");

                    }

                     // find Product to update
                     $product = Product::findOrFail($val_id_product);

                     if($product){
                        //update product
                        $product->update([
                            'tipo' => $tipo_edit,
                            'title' => $title_edit,
                            'unit' => $unit_edit,
                            'barcode' => $barcode_edit,
                            'stock' => $stock_edit,
                            'buy_price' => $buy_price_edit,
                            'precio_base' => $precio_base_edit,
                            'impuesto' => $impuesto_edit,
                            'sell_price' => $sell_price_edit,
                            'description' => $description_edit,
                            'minimo' => $cantidad_minima_edit,
                            'maximo' => $cantidad_maxima_edit,
                            'venta_negativo' => $venta_negativo_edit,
                            'category_id' => $categoria_edit,
                            'codigo_unspsc' => $codigo_unspsc_edit,

                        ]);

                        $fileImageEdit = $request->file('image_edit');
                        if($fileImageEdit !== null){
                            $imageExtension = $fileImageEdit->getClientOriginalExtension();

                            // Image::make( $fileImageEdit->getRealPath() )->fit(340, 340)->save('public/uploads/products/' . $fileImageEdit->hashName());
                            Storage::disk('public_uploads')->put('products/' . $fileImageEdit->hashName(), File::get($fileImageEdit));

                            $product->update([
                                'image' => $fileImageEdit->hashName()
                            ]);

                            return  redirect(route('productos.index'))->with("success", "Producto "."'$request->title_edit'"." editado correctamente.");

                        }
                        return  redirect(route('productos.index'))->with("success", "Producto "."'$request->title_edit'"." editado correctamente.");
                    }

                }
                // end if tipo producto

                    if($tipo_edit == 'servicio'){
                        // validate if barcode its the same
                            if($barcode_edit !== $val_barcode_edit){

                                $products = Product::where('is_active', 1)
                                    ->where('barcode', $barcode_edit)
                                    ->get();
                                if($products->count() == 0 ){

                                    // find Product to update
                                        $product = Product::findOrFail($val_id_product);
                                        if($product){
                                        //update product
                                        $product->update([
                                            'tipo' => $tipo_edit,
                                            'title' => $title_edit,
                                            'unit' => $unit_edit,
                                            'barcode' => $barcode_edit,
                                            'stock' => $stock_edit,
                                            'buy_price' => $buy_price_edit,
                                            'precio_base' => $precio_base_edit,
                                            'impuesto' => $impuesto_edit,
                                            'sell_price' => $sell_price_edit,
                                            'description' => $description_edit,
                                            'minimo' => $cantidad_minima_edit,
                                            'maximo' => $cantidad_maxima_edit,
                                            'venta_negativo' => $venta_negativo_edit,
                                            'category_id' => $categoria_edit,
                                            'codigo_unspsc' => $codigo_unspsc_edit,

                                        ]);

                                        $fileImageEdit = $request->file('image_edit');
                                        if($fileImageEdit !== null){
                                            $imageExtension = $fileImageEdit->getClientOriginalExtension();

                                            Image::make( $fileImageEdit->getRealPath() )->fit(340, 340)->save('public/uploads/products/' . $fileImageEdit->hashName());
                                            // Storage::disk('public_uploads')->put('products/' . $fileImageEdit->hashName(), File::get($fileImageEdit));

                                            $product->update([
                                                'image' => $fileImageEdit->hashName()
                                            ]);
                                        }
                                        return  redirect(route('servicios'))->with("success", "Servicio "."'$title_edit'"." editado correctamente.");
                                        }

                                }
                                return  redirect(route('servicios'))->with("error", "Barcode "."'$barcode_edit'"." ya existe en la base de datos, por favor seleccione otro.");
                            }

                            if($title_edit !== $val_title_edit){

                                $products = Product::where('is_active', 1)
                                                    ->where('title', $title_edit)
                                                    ->get();

                                if($products->count() == 0 ){

                                // find Product to update
                                    $product = Product::findOrFail($val_id_product);

                                    if($product){
                                    //update product
                                    $product->update([
                                        'tipo' => $tipo_edit,
                                        'title' => $title_edit,
                                        'unit' => $unit_edit,
                                        'barcode' => $barcode_edit,
                                        'stock' => $stock_edit,
                                        'buy_price' => $buy_price_edit,
                                        'precio_base' => $precio_base_edit,
                                        'impuesto' => $impuesto_edit,
                                        'sell_price' => $sell_price_edit,
                                        'description' => $description_edit,
                                        'minimo' => $cantidad_minima_edit,
                                        'maximo' => $cantidad_maxima_edit,
                                        'venta_negativo' => $venta_negativo_edit,
                                        'category_id' => $categoria_edit,
                                        'codigo_unspsc' => $codigo_unspsc_edit,

                                    ]);

                                    $fileImageEdit = $request->file('image_edit');
                                    if($fileImageEdit !== null){
                                        $imageExtension = $fileImageEdit->getClientOriginalExtension();

                                        Image::make( $fileImageEdit->getRealPath() )->fit(340, 340)->save('public/uploads/products/' . $fileImageEdit->hashName());
                                        // Storage::disk('public_uploads')->put('products/' . $fileImageEdit->hashName(), File::get($fileImageEdit));

                                        $product->update([
                                            'image' => $fileImageEdit->hashName()
                                        ]);
                                    }
                                    return  redirect(route('servicios'))->with("success", "Servicio "."'$request->title_edit'"." editado correctamente.");
                                    }
                                }
                             return  redirect(route('servicios'))->with("error", "Nombre de producto "."'$title_edit'"." ya existe en la base de datos, por favor seleccione otro.");

                            }

                             // find Product to update
                             $product = Product::findOrFail($val_id_product);

                             if($product){
                             //update product
                             $product->update([
                                 'tipo' => $tipo_edit,
                                 'title' => $title_edit,
                                 'unit' => $unit_edit,
                                 'barcode' => $barcode_edit,
                                 'stock' => $stock_edit,
                                 'buy_price' => $buy_price_edit,
                                 'precio_base' => $precio_base_edit,
                                 'impuesto' => $impuesto_edit,
                                 'sell_price' => $sell_price_edit,
                                 'description' => $description_edit,
                                 'minimo' => $cantidad_minima_edit,
                                 'maximo' => $cantidad_maxima_edit,
                                 'venta_negativo' => $venta_negativo_edit,
                                 'category_id' => $categoria_edit,
                                 'codigo_unspsc' => $codigo_unspsc_edit,

                             ]);

                                $fileImageEdit = $request->file('image_edit');
                                if($fileImageEdit !== null){
                                    $imageExtension = $fileImageEdit->getClientOriginalExtension();

                                    Image::make( $fileImageEdit->getRealPath() )->fit(340, 340)->save('public/uploads/products/' . $fileImageEdit->hashName());
                                    // Storage::disk('public_uploads')->put('products/' . $fileImageEdit->hashName(), File::get($fileImageEdit));

                                    $product->update([
                                        'image' => $fileImageEdit->hashName()
                                    ]);

                                    return  redirect(route('servicios'))->with("success", "Servicio "."'$request->title_edit'"." editado correctamente.");
                                }
                             return  redirect(route('servicios'))->with("success", "Servicio "."'$request->title_edit'"." editado correctamente.");
                            }

                    }
                    // end tipo servicio

                    if($tipo_edit == 'combo'){


                        // validate if barcode its the same
                        if($barcode_edit !== $val_barcode_edit){

                            $products = Product::where('is_active', 1)
                                ->where('barcode', $barcode_edit)
                                ->get();
                            if($products->count() == 0 ){

                                // find Product to update
                                    $product = Product::findOrFail($val_id_product);
                                    if($product){
                                    //update product
                                    $product->update([
                                        'tipo' => $tipo_edit,
                                        'title' => $title_edit,
                                        'unit' => $unit_edit,
                                        'barcode' => $barcode_edit,
                                        'stock' => $stock_edit,
                                        'buy_price' => $buy_price_edit,
                                        'precio_base' => $precio_base_edit,
                                        'impuesto' => $impuesto_edit,
                                        'sell_price' => $sell_price_edit,
                                        'description' => $description_edit,
                                        'minimo' => $cantidad_minima_edit,
                                        'maximo' => $cantidad_maxima_edit,
                                        'venta_negativo' => $venta_negativo_edit,
                                        'category_id' => $categoria_edit,
                                        'codigo_unspsc' => $codigo_unspsc_edit,

                                    ]);
                                    $fileImageEdit = $request->file('image_edit');
                                    if($fileImageEdit !== null){
                                        $imageExtension = $fileImageEdit->getClientOriginalExtension();

                                        Image::make( $fileImageEdit->getRealPath() )->fit(340, 340)->save('public/uploads/products/' . $fileImageEdit->hashName());
                                        // // Storage::disk('public_uploads')->put('products/' . $fileImageEdit->hashName(), File::get($fileImageEdit));

                                        $product->update([
                                            'image' => $fileImageEdit->hashName()
                                        ]);
                                    }

                                    $cantidadCombo = [];
                                    $cantidadCombo['comboCant1'] = [
                                        'cant1' => $request->input('comboCantEdit-1'),
                                        'prod1' => $request->input('comboProductEdit-1'),
                                    ];
                                    $cantidadCombo['comboCant2'] = [
                                        'cant2' => $request->input('comboCantEdit-2'),
                                        'prod2' => $request->input('comboProductEdit-2'),
                                    ];
                                    $cantidadCombo['comboCant3'] = [
                                        'cant3' => $request->input('comboCantEdit-3'),
                                        'prod3' => $request->input('comboProductEdit-3'),
                                    ];
                                    $cantidadCombo['comboCant4'] = [
                                        'cant4' => $request->input('comboCantEdit-4'),
                                        'prod4' => $request->input('comboProductEdit-4'),
                                    ];
                                    $cantidadCombo['comboCant5'] = [
                                        'cant5' => $request->input('comboCantEdit-5'),
                                        'prod5' => $request->input('comboProductEdit-5'),
                                    ];
                                    $cantidadCombo['comboCant6'] = [
                                        'cant6' => $request->input('comboCantEdit-6'),
                                        'prod6' => $request->input('comboProductEdit-6'),
                                    ];
                                    $cantidadCombo['comboCant7'] = [
                                        'cant7' => $request->input('comboCantEdit-7'),
                                        'prod7' => $request->input('comboProductEdit-7'),
                                    ];
                                    $cantidadCombo['comboCant8'] = [
                                        'cant8' => $request->input('comboCantEdit-8'),
                                        'prod8' => $request->input('comboProductEdit-8'),
                                    ];
                                    $cantidadCombo['comboCant9'] = [
                                        'cant9' => $request->input('comboCantEdit-9'),
                                        'prod9' => $request->input('comboProductEdit-9'),
                                    ];
                                    $cantidadCombo['comboCant10'] = [
                                        'cant10' => $request->input('comboCantEdit-10'),
                                        'prod10' => $request->input('comboProductEdit-10'),
                                    ];

                                    $i = 1;
                                     foreach ($cantidadCombo as $itemCant) {
                                         if ($itemCant['cant'.$i] !== '' && $itemCant['prod'.$i]) {
                                             //create product_details
                                             $product->details()->create([
                                                 'product_id' => $product->id,
                                                 'qty' => $itemCant['cant'.$i],
                                                 'combo_product' => $itemCant['prod'.$i],
                                                 'is_active' => 1
                                             ]);

                                         }
                                         $i++;
                                     }

                                    return  redirect(route('combos'))->with("success", "Combo "."'$title_edit'"." editado correctamente.");
                                    }

                            }
                            return  redirect(route('combos'))->with("error", "Barcode "."'$barcode_edit'"." ya existe en la base de datos, por favor seleccione otro.");
                        }

                        if($title_edit !== $val_title_edit){

                            $products = Product::where('is_active', 1)
                                                ->where('title', $title_edit)
                                                ->get();

                            if($products->count() == 0 ){

                            // find Product to update
                                $product = Product::findOrFail($val_id_product);

                                if($product){
                                //update product
                                $product->update([
                                    'tipo' => $tipo_edit,
                                    'title' => $title_edit,
                                    'unit' => $unit_edit,
                                    'barcode' => $barcode_edit,
                                    'stock' => $stock_edit,
                                    'buy_price' => $buy_price_edit,
                                    'precio_base' => $precio_base_edit,
                                    'impuesto' => $impuesto_edit,
                                    'sell_price' => $sell_price_edit,
                                    'description' => $description_edit,
                                    'minimo' => $cantidad_minima_edit,
                                    'maximo' => $cantidad_maxima_edit,
                                    'venta_negativo' => $venta_negativo_edit,
                                    'category_id' => $categoria_edit,
                                    'codigo_unspsc' => $codigo_unspsc_edit,

                                ]);
                                $fileImageEdit = $request->file('image_edit');
                                if($fileImageEdit !== null){
                                    $imageExtension = $fileImageEdit->getClientOriginalExtension();

                                    Image::make( $fileImageEdit->getRealPath() )->fit(340, 340)->save('public/uploads/products/' . $fileImageEdit->hashName());
                                    // Storage::disk('public_uploads')->put('products/' . $fileImageEdit->hashName(), File::get($fileImageEdit));

                                    $product->update([
                                        'image' => $fileImageEdit->hashName()
                                    ]);
                                 }

                                 $cantidadCombo = [];
                                    $cantidadCombo['comboCant1'] = [
                                        'cant1' => $request->input('comboCantEdit-1'),
                                        'prod1' => $request->input('comboProductEdit-1'),
                                    ];
                                    $cantidadCombo['comboCant2'] = [
                                        'cant2' => $request->input('comboCantEdit-2'),
                                        'prod2' => $request->input('comboProductEdit-2'),
                                    ];
                                    $cantidadCombo['comboCant3'] = [
                                        'cant3' => $request->input('comboCantEdit-3'),
                                        'prod3' => $request->input('comboProductEdit-3'),
                                    ];
                                    $cantidadCombo['comboCant4'] = [
                                        'cant4' => $request->input('comboCantEdit-4'),
                                        'prod4' => $request->input('comboProductEdit-4'),
                                    ];
                                    $cantidadCombo['comboCant5'] = [
                                        'cant5' => $request->input('comboCantEdit-5'),
                                        'prod5' => $request->input('comboProductEdit-5'),
                                    ];
                                    $cantidadCombo['comboCant6'] = [
                                        'cant6' => $request->input('comboCantEdit-6'),
                                        'prod6' => $request->input('comboProductEdit-6'),
                                    ];
                                    $cantidadCombo['comboCant7'] = [
                                        'cant7' => $request->input('comboCantEdit-7'),
                                        'prod7' => $request->input('comboProductEdit-7'),
                                    ];
                                    $cantidadCombo['comboCant8'] = [
                                        'cant8' => $request->input('comboCantEdit-8'),
                                        'prod8' => $request->input('comboProductEdit-8'),
                                    ];
                                    $cantidadCombo['comboCant9'] = [
                                        'cant9' => $request->input('comboCantEdit-9'),
                                        'prod9' => $request->input('comboProductEdit-9'),
                                    ];
                                    $cantidadCombo['comboCant10'] = [
                                        'cant10' => $request->input('comboCantEdit-10'),
                                        'prod10' => $request->input('comboProductEdit-10'),
                                    ];

                                    $i = 1;
                                     foreach ($cantidadCombo as $itemCant) {
                                         if ($itemCant['cant'.$i] !== '' && $itemCant['prod'.$i]) {
                                             //create product_details
                                             $product->details()->create([
                                                 'product_id' => $product->id,
                                                 'qty' => $itemCant['cant'.$i],
                                                 'combo_product' => $itemCant['prod'.$i],
                                                 'is_active' => 1
                                             ]);

                                         }
                                         $i++;
                                     }

                                return  redirect(route('combos'))->with("success", "Combo "."'$request->title_edit'"." editado correctamente.");
                                }
                            }
                         return  redirect(route('combos'))->with("error", "Nombre de combo "."'$title_edit'"." ya existe en la base de datos, por favor seleccione otro.");

                        }

                        $product = Product::findOrFail($val_id_product);

                             if($product){
                                //update product
                                $product->update([
                                    'tipo' => $tipo_edit,
                                    'title' => $title_edit,
                                    'unit' => $unit_edit,
                                    'barcode' => $barcode_edit,
                                    'stock' => $stock_edit,
                                    'buy_price' => $buy_price_edit,
                                    'precio_base' => $precio_base_edit,
                                    'impuesto' => $impuesto_edit,
                                    'sell_price' => $sell_price_edit,
                                    'description' => $description_edit,
                                    'minimo' => $cantidad_minima_edit,
                                    'maximo' => $cantidad_maxima_edit,
                                    'venta_negativo' => $venta_negativo_edit,
                                    'category_id' => $categoria_edit,
                                    'codigo_unspsc' => $codigo_unspsc_edit,

                                ]);
                                $fileImageEdit = $request->file('image_edit');
                                if($fileImageEdit !== null){
                                    $imageExtension = $fileImageEdit->getClientOriginalExtension();
                                    // Image::make( $fileImageEdit->getRealPath() )->fit(340, 340)->save('public/uploads/products/' . $fileImageEdit->hashName());
                                    Storage::disk('public_uploads')->put('products/' . $fileImageEdit->hashName(), File::get($fileImageEdit));

                                    $product->update([
                                        'image' => $fileImageEdit->hashName()
                                    ]);
                                 }

                                 $cantidadCombo = [];
                                    $cantidadCombo['comboCant1'] = [
                                        'cant1' => $request->input('comboCantEdit-1'),
                                        'prod1' => $request->input('comboProductEdit-1'),
                                    ];
                                    $cantidadCombo['comboCant2'] = [
                                        'cant2' => $request->input('comboCantEdit-2'),
                                        'prod2' => $request->input('comboProductEdit-2'),
                                    ];
                                    $cantidadCombo['comboCant3'] = [
                                        'cant3' => $request->input('comboCantEdit-3'),
                                        'prod3' => $request->input('comboProductEdit-3'),
                                    ];
                                    $cantidadCombo['comboCant4'] = [
                                        'cant4' => $request->input('comboCantEdit-4'),
                                        'prod4' => $request->input('comboProductEdit-4'),
                                    ];
                                    $cantidadCombo['comboCant5'] = [
                                        'cant5' => $request->input('comboCantEdit-5'),
                                        'prod5' => $request->input('comboProductEdit-5'),
                                    ];
                                    $cantidadCombo['comboCant6'] = [
                                        'cant6' => $request->input('comboCantEdit-6'),
                                        'prod6' => $request->input('comboProductEdit-6'),
                                    ];
                                    $cantidadCombo['comboCant7'] = [
                                        'cant7' => $request->input('comboCantEdit-7'),
                                        'prod7' => $request->input('comboProductEdit-7'),
                                    ];
                                    $cantidadCombo['comboCant8'] = [
                                        'cant8' => $request->input('comboCantEdit-8'),
                                        'prod8' => $request->input('comboProductEdit-8'),
                                    ];
                                    $cantidadCombo['comboCant9'] = [
                                        'cant9' => $request->input('comboCantEdit-9'),
                                        'prod9' => $request->input('comboProductEdit-9'),
                                    ];
                                    $cantidadCombo['comboCant10'] = [
                                        'cant10' => $request->input('comboCantEdit-10'),
                                        'prod10' => $request->input('comboProductEdit-10'),
                                    ];

                                    $i = 1;
                                     foreach ($cantidadCombo as $itemCant) {
                                         if ($itemCant['cant'.$i] !== '' && $itemCant['prod'.$i]) {
                                             //create product_details
                                             $product->details()->create([
                                                 'product_id' => $product->id,
                                                 'qty' => $itemCant['cant'.$i],
                                                 'combo_product' => $itemCant['prod'.$i],
                                                 'is_active' => 1
                                             ]);

                                         }
                                         $i++;
                                     }

                             return  redirect(route('combos'))->with("success", "Combo "."'$request->title_edit'"." editado correctamente.");

                            }
                            dd('nada');
                        //  $cantidadCombo = [];
                        //  $cantidadCombo['comboCant1'] = $request->input('comboCant-1');
                        //  $cantidadCombo['comboCant2'] = $request->input('comboCant-2');
                        //  $cantidadCombo['comboCant3'] = $request->input('comboCant-3');
                        //  $cantidadCombo['comboCant4'] = $request->input('comboCant-4');
                        //  $cantidadCombo['comboCant5'] = $request->input('comboCant-5');
                        //  $cantidadCombo['comboCant6'] = $request->input('comboCant-6');
                        //  $cantidadCombo['comboCant7'] = $request->input('comboCant-7');
                        //  $cantidadCombo['comboCant8'] = $request->input('comboCant-8');
                        //  $cantidadCombo['comboCant9'] = $request->input('comboCant-9');
                        //  $cantidadCombo['comboCant10'] = $request->input('comboCant-10');

                        //  foreach ($cantidadCombo as $itemCant) {
                        //      if (!empty($itemCant)) {
                        //          //create product_details
                        //          $product->details()->create([
                        //              'product_id' => $product->id,
                        //              'qty' => $itemCant,
                        //          ]);
                        //      }
                        //  }

                        //  $productCombo = [];
                        //  $productCombo['comboProduct1'] = $request->input('comboProduct-1');
                        //  $productCombo['comboProduct2'] = $request->input('comboProduct-2');
                        //  $productCombo['comboProduct3'] = $request->input('comboProduct-3');
                        //  $productCombo['comboProduct4'] = $request->input('comboProduct-4');
                        //  $productCombo['comboProduct5'] = $request->input('comboProduct-5');
                        //  $productCombo['comboProduct6'] = $request->input('comboProduct-6');
                        //  $productCombo['comboProduct7'] = $request->input('comboProduct-7');
                        //  $productCombo['comboProduct8'] = $request->input('comboProduct-8');
                        //  $productCombo['comboProduct9'] = $request->input('comboProduct-9');
                        //  $productCombo['comboProduct10'] = $request->input('comboProduct-10');

                        //  foreach ($productCombo as $itemProd) {
                        //      if (!empty($itemProd)) {

                        //          //update comboProduct_details
                        //          $product->details()->update([
                        //              'combo_product' => $itemProd,
                        //          ]);
                        //      }
                        //  }

                    }
                    // end tipo combo
                return  redirect(route('productos.index'))->with("error", "Comuníquese con el administrador del sistema.");

        } catch (Exception $e) {
            return  redirect(route('productos.index'))->with("error", "Comuníquese con el administrador del sistema.");

        }

    }

    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function productosDel(Request $request)
    {
        try {
            $combosDetail = ProductDetail::where('combo_product', $request->id)
                                        ->where('is_active', 1)
                                        ->get();
            if(count($combosDetail) > 0){
                return  'tiene relacion';
            }
            
            // find by ID
           $proudctId = Product::findOrFail($request->id);

           // delete category
           $proudctId->update([
               'is_active' => 2
           ]);
           // redirect
           return  'si';


       } catch (Exception $e) {
           return 'catch';
       }


   }

   public function desactivarProducto(Request $request)
   {
       try {
            $combosDetail = ProductDetail::where('combo_product', $request->id)
                                        ->where('is_active', 1)
                                        ->get();
            if(count($combosDetail) > 0){
                     return  'tiene relacion';
            }

           // find by ID
          $proudctId = Product::findOrFail($request->id);
            if($proudctId->activo == 2){
                 // update product activo condition to 1
                $proudctId->update([
                        'activo' => 1
                    ]);
                    return  'si';
            }
        // delete category
        $proudctId->update([
            'activo' => 2
        ]);
          // redirect
          return  'si';


      } catch (Exception $e) {
          return 'catch';
      }


  }

   public function destroyCombo(Request $request)
   {
       try {
           
           // find by ID
          $proudctId = Product::findOrFail($request->id);

          // delete category
          $proudctId->update([
              'is_active' => 2
          ]);
          // redirect
          return  'si';


      } catch (Exception $e) {
          return 'catch';
      }


  }

   public function destroyServicio(Request $request)
   {
       try {
           
           // find by ID
          $proudctId = Product::findOrFail($request->id);

          // delete category
          $proudctId->update([
              'is_active' => 2
          ]);
          // redirect
          return  'si';


      } catch (Exception $e) {
          return 'catch';
      }


  }

  public function findProductByName(Request $request){
        try{
                $q = $request->q;
                // $products = Product::when($q, function($products) {
                //     $products = $products->where('title', 'like', '%'. $q . '%');
                // })->where('is_active', 1)->where('tipo', 'producto')->latest()->paginate(7);
                $productsSimple = Product::with('carts')
                                    ->where('is_active', 1)
                                    ->where('title', 'like', '%'. $q . '%')
                                    ->paginate(7);

                $productsCarts = Product::join('carts', 'products.id', '=', 'carts.product_id')
                ->select('products.*','carts.id', 'carts.qty', 'impuesto_global')
                ->where('products.activo', 1)
                ->where('products.is_active', 1)
                ->where('carts.cashier_id', auth()->user()->id)
                ->get();

                $products = [
                    'productsSimple' => $productsSimple,
                    'productsCarts' => $productsCarts,
                ];
                                    
                if(count($productsSimple) > 0){
                    return  $products;
                }
                //return error if empty input
                return 'no';
            
            } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

  public function findProductByBarcode(Request $request){
        try{
                $q = $request->q;
                // $products = Product::when($q, function($products) {
                //     $products = $products->where('title', 'like', '%'. $q . '%');
                // })->where('is_active', 1)->where('tipo', 'producto')->latest()->paginate(7);
                $productsSimple = Product::where('is_active', 1)
                                    ->where('barcode', 'like', '%'. $q . '%')
                                    ->latest()
                                    ->paginate(7);

                $productsCarts = Product::join('carts', 'products.id', '=', 'carts.product_id')
                                        ->select('products.*','carts.id', 'carts.qty', 'impuesto_global')
                                        ->where('products.activo', 1)
                                        ->where('products.is_active', 1)
                                        ->where('carts.cashier_id', auth()->user()->id)
                                        ->get();

                $products = [
                    'productsSimple' => $productsSimple,
                    'productsCarts' => $productsCarts,
                ];
                                    
                if(count($productsSimple) > 0){
                    return  $products;
                }
                //return error if empty input
                return 'no';
            
            } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

  public function productByName(){
        try{
                // $products = Product::when(request()->q, function($products) {
                //     $products = $products->where('title', 'like', '%'. request()->q . '%');
                // })->where('is_active', 1)->where('tipo', 'producto')->latest()->paginate(7);
                $productsSimple = Product::with('carts')
                                        ->where('is_active', 1)
                                        ->where('activo', 1)
                                        ->paginate(6);

                $productsCarts = Product::where('activo', 1)
                                    ->where('is_active', 1)
                                    ->join('carts', 'products.id', '=', 'carts.product_id')
                                    ->where('carts.cashier_id', auth()->user()->id)
                                    ->select('products.*','carts.id', 'carts.qty', 'impuesto_global')
                                    ->first();
                                    
                $products = [
                    'productsSimple' => $productsSimple,    
                    'productsCarts' => $productsCarts
                ];
                
                if(count($productsSimple) > 0){
                    return  $products;
                }
                //return error if empty input
                return 'no';
            
            } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

}