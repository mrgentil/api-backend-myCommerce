<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{



    public function index()
    {
        //
        $products = Product::all();
        return response()->json([
            'status' => 200,
            'products' => $products,

        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|max:191',
            'slug' => 'required|string|max:191',
            'name' => 'required|string|max:191',
            'meta_title' => 'required|string|max:191',
            'brand' => 'required|string|max:191',
            'selling_price' => 'required|max:20',
            'original_price' => 'required|max:20',
            'qte' => 'required|max:4',
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),

            ]);
        } else {
            $product = new Product;
            $product->category_id = $request->input('category_id');
            $product->slug = $request->input('slug');
            $product->name = $request->input('name');
            $product->description = $request->input('description');
            $product->meta_title = $request->input('meta_title');
            $product->meta_keywords = $request->input('meta_keywords');
            $product->meta_description = $request->input('meta_description');
            $product->brand = $request->input('brand');
            $product->selling_price = $request->input('selling_price');
            $product->original_price = $request->input('original_price');
            $product->qte = $request->input('qte');

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filName = time() . '.' . $extension;
                $file->move('uploads/products', $filName);
                $product->image = 'uploads/products/' . $filName;
            }
            $product->status = $request->input('featured') == true ? '1' : '0';
            $product->status = $request->input('popular') == true ? '1' : '0';
            $product->status = $request->input('status') == true ? '1' : '0';
            $product->save();
            return response()->json([
                'status' => 200,
                'message' => 'Product add Successfully',

            ]);
        }
    }

    public function edit($id)
    {
        $product = Product::find($id);
        if ($product) {
            return response()->json([
                'status' => 200,
                'product' => $product,

            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Id Product Found',

            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|max:191',
            'slug' => 'required|string|max:191',
            'name' => 'required|string|max:191',
            'meta_title' => 'required|string|max:191',
            'brand' => 'required|string|max:191',
            'selling_price' => 'required|max:20',
            'original_price' => 'required|max:20',
            'qte' => 'required|max:4',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),

            ]);
        } else {

            $product = Product::find($id);


            if ($product) {
                $product->category_id = $request->input('category_id');
                $product->slug = $request->input('slug');
                $product->name = $request->input('name');
                $product->description = $request->input('description');
                $product->meta_title = $request->input('meta_title');
                $product->meta_keywords = $request->input('meta_keywords');
                $product->meta_description = $request->input('meta_description');
                $product->brand = $request->input('brand');
                $product->selling_price = $request->input('selling_price');
                $product->original_price = $request->input('original_price');
                $product->qte = $request->input('qte');
                if ($request->hasFile('image')) {
                    $path = $product->image;
                    if (File::exists($path)) {
                        File::delete($path);
                    }
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filName = time() . '.' . $extension;
                    $file->move('uploads/products', $filName);
                    $product->image = 'uploads/products/' . $filName;
                }
                $product->status = $request->input('featured') == true ? '1' : '0';
                $product->status = $request->input('popular') == true ? '1' : '0';
                $product->status = $request->input('status') == true ? '1' : '0';
                $product->update();
                return response()->json([
                    'status' => 200,
                    'message' => 'Product Updated Successfully',

                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Not Product ID Found',

                ]);
            }
        }
    }
}
