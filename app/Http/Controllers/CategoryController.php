<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Image;
use File;
class CategoryController extends Controller
{
    public function index()
    {
        // get categories
        $categories = Category::where('is_active', 1)
                                ->latest()
                                ->paginate(5);  

        // return 
        return view('categorias', compact('categories'));
    }

    public function categoriesCreate(Request $request)
    {
        $this->validate($request, [
            'image' => 'image|mimes:jpg,jpeg,png|max:20000',
            'name' => 'required',
            'description' => 'required'
        ]);
        
        if($request->image == ''){
                        try {
                        $exitsCat = Category::where('is_active', 1)
                                            ->where('name', $request->name)
                                            ->get();
                        if($exitsCat->count() > 0){
                           return  redirect(route('categories.index'))->with("error", "Nombre de categoría existe"); 
                        }
                        else{
                        
                        // create category
                        $data = Category::create([
                            'name'          => $request->name,
                            'description'   => $request->description,
                            'is_active' => 1
                        ]);
                        
                        // redirect
                        return redirect(route('categories.index'))->with("success", "Categoría agregada correctamente");
                        }
                        

                    } catch (Exception $e) {
                        return 'catch';
                    }
        }
        else{
                try {
                    $exitsCat = Category::where('is_active', 1)
                                        ->where('name', $request->name)
                                        ->get();
                    if($exitsCat->count() > 0){
                       return  redirect(route('categories.index'))->with("error", "Nombre de categoría existe"); 
                    }
                    else{
                    $file = $request->file('image');      
                    $imageExtension = $file->getClientOriginalExtension();
                    
                    // Image::make( $file->getRealPath() )->fit(340, 340)->save('public/uploads/categories/' . $file->hashName());
                    Storage::disk('public_uploads')->put('categories/' . $file->hashName(), File::get($file));
                    // if(!Storage::disk('public_uploads')->put('categories', $file)) {
                    //        return false;
                    //      }
                    // create category
                    $data = Category::create([
                        'image' =>  $file->hashName(),
                        'name'          => $request->name,
                        'description'   => $request->description,
                        'is_active' => 1
                    ]);
                    
                    // redirect
                    return redirect(route('categories.index'))->with("success", "Categoría agregada correctamente");
                    }
                    

                } catch (Exception $e) {
                    return 'catch';
                }

                return redirect(route('categories.index'))->with("error", "Comuniquese con el administrador del programa");
        }


        // upload image
        // $img = $request-file('image');>
        // if(!Storage::disk('public_uploads')->put('catego', $img)) {
        //     return false;
        // }

       

    }

    public function categoriesEdit(Request $request)
    {

        if($request->file('imageEdit') == $request->file('image1') AND $request->nameEdit == $request->name1 AND $request->descriptionEdit == $request->description1)
            {

                return redirect(route('categories.index'))->with("error", "No se realizó ninguna acción");
            } 

            else{
               
                
                // validate
                $this->validate($request, [
                    'nameEdit' => 'required',
                    'descriptionEdit' => 'required'
                ]);
                $exitsCat = Category::where('is_active', 1)
                                        ->where('name', $request->nameEdit)
                                        ->get();
                if($request->nameEdit !== $request->name1){
                    if($exitsCat->count() > 0){
                        return  redirect(route('categories.index'))->with("error", "Nombre de categoría existe"); 
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
                            Storage::disk('public_uploads')->delete('/public/categories/'.basename($request->oldImgEdit));
                            $file = $request->file('imageEdit');
                            $imageExtension = $file->getClientOriginalExtension();
                            
                            $data = Storage::disk('public_uploads')->put('categories/' . $file->hashName().'.'.$imageExtension, File::get($file));
                            // upload new image
                            Category::where('id', $request->idcat)
                                ->update([
                                    'image' => $file->hashName().'.'.$imageExtension,
                                    'name' => $request->nameEdit,
                                    'description' => $request->descriptionEdit
                                ]);
                                // redirect
                            return redirect(route('categories.index'))->with("success", "Categoría editada correctamente");

                        }
                        
                        // update category without image
                            Category::where('id', $request->idcat)
                                    ->update([
                                        'name' => $request->nameEdit,
                                        'description' => $request->descriptionEdit
                                    ]);

                        // redirect
                        return redirect(route('categories.index'))->with("success", "Categoría editada correctamente");
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

    public function categoriesDel(Request $request)
    {
       
        try {
             // find by ID
            $categoryId = Category::findOrFail($request->id);
            // remove image
            if(!Storage::disk('public_uploads')->delete('public/categories/'.basename($categoryId->image))) {
                return false;
                }
            
            // delete category
            $categoryId->update([
                'is_active' => 2
            ]);
            // redirect
            return redirect()->route('categories.index');

        } catch (Exception $e) {
            return 'catch';
        } 

         
    }
}
