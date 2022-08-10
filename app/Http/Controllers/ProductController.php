<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    //
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('product.index', compact('products'));
    }

    public function create(){
        return view('product.create');
    }

    public function edit($id)
{
    return view('product.edit', compact($id));
}

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'     => 'required',
            'description'   => 'required',
            'price'   => 'required'
        ]);

        //get data Product by ID
        $product = Blog::findOrFail($id);

        if($request->file('image') == "") {

            $product->update([
                'name'     => $request->name,
                'description'   => $request->description,
                'price'   => $request->price
            ]);

        } else {

            //hapus old image
            Storage::disk('local')->delete('public/productimage/'.$product->image);

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/productimage', $image->hashName());

            $blog->update([
                'image'     => $image->hashName(),
                'name'     => $request->name,
                'description'   => $request->description,
                'price'   => $request->price
            ]);

        }

        if($product){
            //redirect dengan pesan sukses
            return redirect()->route('productindex')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('product-index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }


    // public function destroy($id){

    // }

    public function store(Request $request)
    {
        $this->validate($request, [
            'image'     => 'required|image|mimes:png,jpg,jpeg',
            'name'     => 'required',
            'description'     => 'required',
            'price'   => 'required'
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/productimage', $image->hashName());

        $product = Product::create([
            'image'     => $image->hashName(),
            'name'     => $request->name,
            'description'     => $request->description,
            'price'   => $request->price
        ]);

        if($product){
            //redirect dengan pesan sukses
            return redirect()->route('product-index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('product-index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function destroy($id)
    {
    $product = Product::findOrFail($id);
    $product->delete();

    if($product){
        //redirect dengan pesan sukses
        return redirect()->route('product-index')->with(['success' => 'Data Berhasil Dihapus!']);
    }else{
        //redirect dengan pesan error
        return redirect()->route('product-index')->with(['error' => 'Data Gagal Dihapus!']);
    }
    }





}
