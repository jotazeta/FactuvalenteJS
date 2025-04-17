<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Codigo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Image;
use File;
class CodigoController extends Controller
{
    public function index()
    {
        // get categories
        $codigos = Codigo::where('is_active', 1)
                                ->latest()
                                ->paginate(5);  

        // return 
        return view('codigo', compact('codigos'));
    }

    public function codigoCreate(Request $request)
    {
        $this->validate($request, [
            'codigo' => 'required',
            'name' => 'required'
        ]);

        $exitsCod = Codigo::where('is_active', 1)
                        ->where('codigo', $request->codigo)
                        ->get();
        
            if($exitsCod->count() > 0){
                        
                        
                return  redirect(route('codigo.index'))->with("error", "Nombre de código existe"); 
            }
            else{
                        
                // create codigo
                $data = Codigo::create([
                    'codigo'          => $request->codigo,
                    'name'          => $request->name,
                    'description'   => $request->description,
                    'is_active' => 1
                ]);
                
                // redirect
                return redirect(route('codigo.index'))->with("success", "Código agregado correctamente");
                }
                
            return redirect(route('codigo.index'))->with("error", "Comuniquese con el administrador del programa");

    }

    public function codigoEdit(Request $request)
    {

        if($request->file('codigoEdit') == $request->codigo1 AND $request->nameEdit == $request->name1 AND $request->descriptionEdit == $request->description1)
            {

                return redirect(route('categories.index'))->with("error", "No se realizó ninguna acción");
            } 

            else{
               
                
                // validate
                $this->validate($request, [
                    'codigoEdit' => 'required',
                    'nameEdit' => 'required'
                ]);
                $exitsCod = Codigo::where('is_active', 1)
                                        ->where('codigo', $request->codigoEdit)
                                        ->get();
                if($request->codigoEdit !== $request->codigo1){
                    if($exitsCod->count() > 0){
                        return  redirect(route('codigo.index'))->with("error", "Nombre de código existe"); 
                    }
                }
                else{

                        $codigoId = Codigo::findOrFail($request->idcod);
           
                        // update Codigo without image
                        $codigoId->update([
                            'codigo' => $request->codigoEdit,
                            'name' => $request->nameEdit,
                            'description' => $request->descriptionEdit
                        ]);

                        // redirect
                        return redirect(route('codigo.index'))->with("success", "Código UNSPSC editado correctamente");
                        }
                
            }
         
    }

    public function store(Request $request)
    {
        // validate
        $this->validate($request, [
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2000',
            'name' => 'required|unique:categories',
            'description' => 'required'
        ]);

        // upload image
        $image = $request->file('image');
        $image->storeAs('public/categories', $image->hashName());

        // create category
        Category::create([
            'image' => $image->hashName(),
            'name'          => $request->name,
            'description'   => $request->description
        ]);

        //redirect
        return redirect()->route('apps.categories.index');
    }

    public function edit(Category $category)
    {
        return Inertia::render('Apps/Categories/Edit', [
            'category' => $category
        ]);
    }

    public function update(Request $request, Category $category)
    {
        // validate
        $this->validate($request, [
            'name' => 'required|unique:categories,name,'.$category->id,
            'description' => 'required'
        ]);

        // check image update
        if ($request->file('image')) {
            // remove old image
            Storage::disk('local')->delete('/public/categories/'.basename($category->image));

            // upload new image
            $image = $request->file('image');
            $image->storeAs('public/categories', $image->hashName());

            // update category with new image
            $category->update([
                'image' => $image->hashName(),
                'name' => $request->name,
                'description' => $request->description
            ]);

        }

        // update category without image
        $category->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        // redirect
        return redirect()->route('apps.categories.index');
    }

    public function destroy($id)
    {
        // find by ID
        $category = Category::findOrFail($id);

        // remove image
        Storage::disk('local')->delete('public/categories/'.basename($category->image));

        // delete
        $category->delete();

        // redirect
        return redirect()->route('apps.categories.index');
    }

    public function codigoDel(Request $request)
    {
       
        try {
             // find by ID
            $codigoId = Codigo::findOrFail($request->id);
           
            // delete codigo
            $codigoId->update([
                'is_active' => 2
            ]);
            // redirect
            return redirect()->route('codigo.index');

        } catch (Exception $e) {
            return 'catch';
        } 

         
    }
}
