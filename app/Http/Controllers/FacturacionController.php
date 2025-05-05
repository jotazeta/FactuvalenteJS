<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Codigo;
use App\Models\Cliente;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Image;
use File;

class FacturacionController extends Controller
{
    public function index()
    {
        // get cart
        // $carts = Cart::with('product')->where('cashier_id', auth()->user()->id)->latest()->get();

        // get all customers
        // $customers = Customer::latest()->get();
        $customers = Cliente::where('is_active', 1)
                            ->where('active', 1)
                            ->get();
        return view('facturacion', compact('customers'));
        
    }

    public function addToCart(Request $request)
    {
        try {

                //add url to config (esto es para manejar la paginación de los productos)
                $configs = Config::where('id', 1)->first();
                $configs->url_id = $request->url_id;
                $configs->save();

                //check if
                $product = Product::findOrFail($request->product_id);
                // check stock product
            if (Product::whereId($request->product_id)->first()->stock < $request->product_stock || Product::whereId($request->product_id)->first()->stock == 0 && $product->venta_negativo !== 'venta_negativo') {
                // redirect
                return 'Producto sin inventario';
            }
            // check cart
            $cart = Cart::with('product')
                        ->where('product_id', $request->product_id)
                        ->where('cashier_id', auth()->user()->id)
                        ->first();
            if($cart){
                // increment qty
                $cart->increment('qty', 1);

                // sum price * qty
                $cart->price = $cart->product->sell_price + $cart->price;

                $cart->save();

                return 'actualizado';
            } else {
                // insert cart
                
                $insert = Cart::create([
                    'cashier_id' => auth()->user()->id,
                    'product_id' => $request->product_id,
                    'qty' => 1,
                    'price' => $request->product_sell_price,
                    'impuesto_global' => 1,
                    'impuesto_producto' => $request->product_impuesto,
                    'descuento' => 0
                ]);
                return 'guardado';
            }

            return 'nada';

          }
          
          catch (customException $e) {
            //display custom message
            return 'no';
          }
    }

    public function plusCantidad(Request $request)
    {
        try {
                //check if
                $product = Product::findOrFail($request->product_id);
                // check stock product
                if (Product::whereId($request->product_id)->first()->stock < $request->product_stock || Product::whereId($request->product_id)->first()->stock == 0 && $product->venta_negativo !== 'venta_negativo') {
                    // redirect
                    return 'Producto sin inventario';
                }

                $cartImpuestoGlobal = Cart::where('cashier_id', auth()->user()->id)->get();

                if($cartImpuestoGlobal){
                    if($cartImpuestoGlobal[0]->impuesto_global == 1){
                         // check cart
                        $cart = Cart::with('product')
                        ->where('product_id', $request->product_id)
                        ->where('cashier_id', auth()->user()->id)
                        ->first();

    
                        // increment qty
                        $cart->increment('qty', 1);

                        // sum price * qty
                        $cart->price = $cart->product->sell_price + $cart->price;

                        $cart->save();

                        return 'actualizado';
                    }
                    if($cartImpuestoGlobal[0]->impuesto_global == 2){
                         // check cart
                        $cart = Cart::with('product')
                        ->where('product_id', $request->product_id)
                        ->where('cashier_id', auth()->user()->id)
                        ->first();

    
                        // increment qty
                        $cart->increment('qty', 1);

                        // sum price * qty
                        $cart->price = $cart->product->precio_base + $cart->price;

                        $cart->save();

                        return 'actualizado';
                    }
                }

                // check cart
                $cart = Cart::with('product')
                            ->where('product_id', $request->product_id)
                            ->where('cashier_id', auth()->user()->id)
                            ->first();

    
                // increment qty
                $cart->increment('qty', 1);

                // sum price * qty
                $cart->price = $cart->product->sell_price + $cart->price;

                $cart->save();

                return 'actualizado';
        
                
            
            } catch (customException $e) {
            //display custom message
            return 'no';
          }
    }

    public function minusCantidad(Request $request)
    {
        try {
                //check if
                $product = Product::findOrFail($request->product_id);
                // check stock product
                if (Product::whereId($request->product_id)->first()->stock < $request->product_stock || Product::whereId($request->product_id)->first()->stock == 0 && $product->venta_negativo !== 'venta_negativo') {
                    // redirect
                    return 'Producto sin inventario';
                }

                $cartImpuestoGlobal = Cart::where('cashier_id', auth()->user()->id)->get();

                if($cartImpuestoGlobal){
                    if($cartImpuestoGlobal[0]->impuesto_global == 1){
                        // check cart
                        $cart = Cart::with('product')
                        ->where('product_id', $request->product_id)
                        ->where('cashier_id', auth()->user()->id)
                        ->first();
    
                        // decrement qty
                        $cart->decrement('qty', 1);

                        // sum price * qty
                        $cart->price = $cart->price - $cart->product->sell_price;

                        $cart->save();

                        return 'actualizado';
                    }
                    if($cartImpuestoGlobal[0]->impuesto_global == 2){
                        // check cart
                        $cart = Cart::with('product')
                        ->where('product_id', $request->product_id)
                        ->where('cashier_id', auth()->user()->id)
                        ->first();
    
                        // decrement qty
                        $cart->decrement('qty', 1);

                        // sum price * qty
                        $cart->price = $cart->price - $cart->product->precio_base;

                        $cart->save();

                        return 'actualizado';
                    }
                }
                // check cart
                $cart = Cart::with('product')
                            ->where('product_id', $request->product_id)
                            ->where('cashier_id', auth()->user()->id)
                            ->first();
                
                    // decrement qty
                    $cart->decrement('qty', 1);

                    // sum price * qty
                    $cart->price = $cart->price - $cart->product->sell_price;

                    $cart->save();

                    return 'actualizado';
            
            } catch (customException $e) {
            //display custom message
            return 'no';
          }
    }

    public function checkCart(){
        
        try{ 
            $cart = Cart::with('product')
                        ->where('cashier_id', auth()->user()->id)
                        ->get();

            if($cart){
                return $cart;
            }

            return 'No hay productos en carrito';
        }catch (customException $e) {
            return 'no';
            //display custom message
            }
    }

    public function findCart(Request $request){
        
        try{ 
            $cartId = Cart::join('products', 'carts.product_id', '=', 'products.id')
                            ->select('products.*','carts.id', 'carts.qty', 'carts.impuesto_global', 'carts.descuento', 'carts.impuesto_producto')
                            ->where('carts.id', $request->cart_id)
                            ->first();

            if($cartId){
                return $cartId;
            }

            return 'No hay productos en carrito';
        }catch (customException $e) {
            return 'no';
            //display custom message
            }
    }

    public function editProductCart(Request $request){
        
        try{ 
            $cartId = Cart::findOrFail($request->id_product);
            
            if($cartId){
                $cartId->qty = $request->cantidadProduct;
                $cartId->price = $request->precioTotal * $request->cantidadProduct;
                $cartId->impuesto_producto = $request->impuestoProduct;
                $cartId->descuento = $request->descuentoProduct;
                $cartId->save();
                return 'actualizado';
            }

            return 'No hay productos en carrito';
        }catch (customException $e) {
            return 'no';
            //display custom message
            }
    }

    public function deleteCurrentCart(Request $request)
    {
        try {
                // find cart
                $cartId = Cart::findOrFail($request->cart_id);
                
                    // delete cart
                    $cartId->delete();

                    return 'eliminado';
            
            } catch (customException $e) {
            //display custom message
            return 'no';
          }
    }

    public function deleteCart(Request $request)
    {
        try {
            // Retrieve the cart IDs from the request
            $cartIds = $request->input('cart_ids');
    
            // Check if cart IDs are provided
            if (empty($cartIds) || !is_array($cartIds)) {
                return response()->json(['message' => 'No hay productos en carrito'], 400);
            }
    
            // Delete all carts with the provided IDs
            $deleted = Cart::where('cashier_id', auth()->user()->id)
                           ->whereIn('id', $cartIds)
                           ->delete();
    
            // Check if any carts were deleted
            if ($deleted > 0) {
                return response()->json(['message' => 'eliminado'], 200);
            } else {
                return response()->json(['message' => 'No se encontraron carritos para eliminar'], 404);
            }
        } catch (\Exception $e) {
            // Handle any exceptions and return an error message
            return response()->json(['message' => 'Error al eliminar los carritos', 'error' => $e->getMessage()], 500);
        }
    }

    public function changeQTY(Request $request)
    {
        try {
                //check if
                $product = Product::findOrFail($request->product_id);
                // check stock product
                if (Product::whereId($request->product_id)->first()->stock < $request->product_stock || Product::whereId($request->product_id)->first()->stock == 0 && $product->venta_negativo !== 'venta_negativo') {
                    // redirect
                    return 'Producto sin inventario';
                }

                $cartImpuestoGlobal = Cart::where('cashier_id', auth()->user()->id)->get();

                if($cartImpuestoGlobal){
                    if($cartImpuestoGlobal[0]->impuesto_global == 1){
                        // check cart
                        $cart = Cart::with('product')
                                    ->where('product_id', $request->product_id)
                                    ->where('cashier_id', auth()->user()->id)
                                    ->first();
    
                        // decrement qty
                        $cart->qty = $request->e;

                        // sum price * qty
                        $cart->price = $cart->product->sell_price * $request->e;

                        $cart->save();

                        return 'actualizado';
                    }
                    if($cartImpuestoGlobal[0]->impuesto_global == 2){
                        // check cart
                        $cart = Cart::with('product')
                                    ->where('product_id', $request->product_id)
                                    ->where('cashier_id', auth()->user()->id)
                                    ->first();
    
                        // decrement qty
                        $cart->qty = $request->e;

                        // sum price * qty
                        $cart->price = $cart->product->precio_base * $request->e;

                        $cart->save();

                        return 'actualizado';
                    }
                }
                // check cart
                $cart = Cart::with('product')
                            ->where('product_id', $request->product_id)
                            ->where('cashier_id', auth()->user()->id)
                            ->first();
                
                    // decrement qty
                    $cart->qty = $request->e;

                    // sum price * qty
                    $cart->price = $cart->product->sell_price * $request->e;

                    $cart->save();

                    return 'actualizado';
            
            } catch (customException $e) {
            //display custom message
            return 'no';
          }
    }

    public function impuestoGlobalCart(Request $request)
    {
        try {
                // find cart
                $cart = Cart::where('cashier_id', auth()->user()->id)
                             ->join('products', 'carts.product_id', '=', 'products.id')
                            ->select('products.*','carts.id', 'carts.qty', 'impuesto_global')
                            ->get();

                   if($cart[0]->impuesto_global == 1){
                        
                        foreach ($cart as $item) {
                            // change priceCart from products sell_price for precio_base, this movemente remove impuesto value and left the price
                            // products with preciobase value only
                            $item->price = $item->precio_base * $item->qty;
                            $item->impuesto_global = 2;
                            $item->save();
                        }
                    return 'sin impuesto';
           
                   }

                   if($cart[0]->impuesto_global == 2){
                        
                        foreach ($cart as $item) {
                            // change priceCart from products sell_price for precio_base, this movemente remove impuesto value and left the price
                            // products with preciobase value only
                            $item->price = $item->sell_price * $item->qty;
                            $item->impuesto_global = 1;
                            $item->save();
                        }
                    return 'con impuesto';
           
                   }
                   
            } catch (customException $e) {
            //display custom message
            return 'no';
          }
    }

    public function checkConfig(){
        try{ 

            $configs = Config::where('id', 1)->first();
            return $configs;
                
            } catch (customException $e) {
                //display custom message
                return 'no';
        }
    }
        
}
