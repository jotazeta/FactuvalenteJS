<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Image;
use File;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = Cliente::when(request()->q, function($clientes) {
            $clientes = $clientes->where('name', 'like', '%'. request()->q . '%');
        })->where('is_active', 1)->latest()->paginate(5);

         // return 
         return view('clientes', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createClient(Request $request)
    {
        $this->validate($request, [
            'image' => 'image|mimes:jpg,jpeg,png|max:20000'
        ]);
        
        if($request->image == ''){
                        try {

                        $exitsClientemail = Cliente::where('is_active', 1)
                                    ->where('correo', $request->correo)
                                    ->get();
                                    
                        if($exitsClientemail->count() > 0){
                            return  redirect(route('clientes.index'))->with("error", "Correo "."'$request->correo'"." existe en la base de datos, por favor intente con otro"); 
                        }
                        
                        // create client
                        $data = Cliente::create([
                            'name'          => $request->name,
                            'correo'   => $request->correo,
                            'telefono'   => $request->telefono,
                            'direccion'   => $request->direccion,
                            'is_active'   => 1,
                            'active'   => 1
                        ]);
                        
                        // redirect
                        return redirect(route('clientes.index'))->with("success", "Cliente "."'$request->name'"." agregado correctamente");

                    } catch (Exception $e) {
                        return 'catch';
                    }
        }
        else{
                try {

                    $exitsClientemail = Cliente::where('is_active', 1)
                                        ->where('correo', $request->correo)
                                        ->get();
                                        
                    if($exitsClientemail->count() > 0){
                        return  redirect(route('clientes.index'))->with("error", "Correo "."'$request->correo'"." existe en la base de datos, por favor intente con otro"); 
                    }
                    
                    $file = $request->file('image');      
                    $imageExtension = $file->getClientOriginalExtension();
                    
                    // Image::make( $file->getRealPath() )->fit(340, 340)->save('public/uploads/categories/' . $file->hashName());
                    Storage::disk('public_uploads')->put('clientes/' . $file->hashName(), File::get($file));
                    // if(!Storage::disk('public_uploads')->put('categories', $file)) {
                    //        return false;
                    //      }
                    // create client
                    $data = Cliente::create([
                        'name'          => $request->name,
                        'image' =>  $file->hashName(),
                        'correo'   => $request->correo,
                        'telefono'   => $request->telefono,
                        'direccion'   => $request->direccion,
                        'is_active'   => 1,
                        'active'   => 1
                    ]);
                    
                    // redirect
                    return redirect(route('clientes.index'))->with("success", "Cliente "."'$request->name'"." agregado correctamente");

                } catch (Exception $e) {
                    return 'catch';
                }

                return redirect(route('clientes.index'))->with("error", "Comuniquese con el administrador del programa");
        }


        // upload image
        // $img = $request-file('image');>
        // if(!Storage::disk('public_uploads')->put('catego', $img)) {
        //     return false;
        // }

       

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function show(clientes $clientes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function editClient(Request $request)
    {

        try{ 
            if($request->file('imageEdit') == $request->file('image1') AND $request->nameEdit == $request->name1 AND $request->correoEdit == $request->correo1 AND $request->telefonoEdit == $request->telefono1 AND $request->direccionEdit == $request->direccion1)
            {

                return redirect(route('clientes.index'))->with("error", "No se realizó ninguna acción");
            } 

            else{
                $exitsClientEmail = Cliente::where('is_active', 1)
                                        ->where('correo', $request->correoEdit)
                                        ->get();
                if($request->correoEdit !== $request->correo1){
                    if($exitsClientEmail->count() > 0){
                        return  redirect(route('clientes.index'))->with("error", "Correo "."'$request->correoEdit'"." existe en la base de datos, por favor intente con otro"); 
                    }
                }
                else{
                    // check image update
                        if ($request->file('imageEdit')) {
                            // validate
                            
                            $this->validate($request, [
                                'imageEdit' => 'required|image|mimes:jpg,jpeg,png|max:20000',
                            ]);
                            // remove old image
                            Storage::disk('public_uploads')->delete('/public/clientes/'.basename($request->oldImgEdit));
                            $file = $request->file('imageEdit');
                            $imageExtension = $file->getClientOriginalExtension();
                            
                            $data = Storage::disk('public_uploads')->put('clientes/' . $file->hashName().'.'.$imageExtension, File::get($file));
                            // upload new image
                            Cliente::where('id', $request->idCliente)
                                ->update([
                                    'image' => $file->hashName().'.'.$imageExtension,
                                    'name' => $request->nameEdit,
                                    'correo' => $request->correoEdit,
                                    'telefono' => $request->telefonoEdit,
                                    'direccion' => $request->direccionEdit
                                ]);
                                // redirect
                            return redirect(route('clientes.index'))->with("success", "Cliente "."'$request->nameEdit'"." editado correctamente");

                        }
                        
                        // update cliente without image
                            Cliente::where('id', $request->idCliente)
                                    ->update([
                                        'name' => $request->nameEdit,
                                        'correo' => $request->correoEdit,
                                        'telefono' => $request->telefonoEdit,
                                        'direccion' => $request->direccionEdit
                                    ]);

                        // redirect
                        return redirect(route('clientes.index'))->with("success", "Cliente "."'$request->nameEdit'"." editado correctamente");
                        }
                
                
            }
        } catch (Exception $e) {
            return 'catch';
        }

        return redirect(route('clientes.index'))->with("error", "Comuniquese con el administrador del programa");
         
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, clientes $clientes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function clientesDel(Request $request)
    {
        try {
          
            // find by ID
           $clienteId = Cliente::findOrFail($request->id);

           // delete category
           $clienteId->update([
               'is_active' => 2
           ]);
           // redirect
           return  'si';


       } catch (Exception $e) {
           return 'catch';
       }


   }

    
   public function desactivarCliente(Request $request)
   {
       try {

           // find by ID
          $clientId = Cliente::findOrFail($request->id);
            if($clientId->active == 2){
                 // update product activo condition to 1
                $clientId->update([
                        'active' => 1
                    ]);
                    return  'si';
            }
        // delete category
        $clientId->update([
            'active' => 2
        ]);
          // redirect
          return  'si';


      } catch (Exception $e) {
          return 'catch';
      }


  }
}
