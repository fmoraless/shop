<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductImage;
use Illuminate\Http\Request;
use File;

class ImageController extends Controller
{
    public function index($id)
    {
        //Mostrar imagenes asociaas a producto
        $product = Product::find($id);
        $images = $product->images;
        return view('admin.products.images.index')->with(compact('product', 'images'));
    }
    public function store(Request $request, $id)
    {
        //guardar img en nuestro proyecto
        $file = $request->file('photo');
        $path = public_path() . '/images/products';
        $fileName = uniqid() . $file->getClientOriginalName();
        $moved = $file->move($path, $fileName);


        // crear 1 registro en la tabla product_images
        if ($moved) {
            $productImage = new ProductImage();
            $productImage->image = $fileName;
            //$productImage->featured = false;
            $productImage->product_id = $id;
            $productImage->save(); // insert
        }
        return back();
    }
    public function destroy(Request $request, $id)
    {
        //Eliminar el archivo
        $productImage = ProductImage::find($request->image_id);
        if (substr($productImage->image, 0,4) !== "http") {
            $deleted = true;
        }else{
            $fullPath = public_path() . '/images/products' . $productImage->image;
            $deleted = File::delete($fullPath);
        }
        //Eliminar el archivo de la img en la BD
        if ($deleted){
            $productImage->delete();
        }
        return back();
        }
}
