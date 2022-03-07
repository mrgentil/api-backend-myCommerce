<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $category = Category::all();
        return response()->json([
            'status' => 200,
            'category' => $category,

        ]);
    }

    public function allCategories()
    {
        $category = Category::where('status', '0')->get();
        return response()->json([
            'status' => 200,
            'category' => $category,

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:191',
            'slug' => 'required|string|max:191',
            'name' => 'required|string|max:191',


        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),

            ]);
        } else {
            $category = new Category;
            $category->title = $request->input('title');
            $category->keywords = $request->input('keywords');
            $category->descript = $request->input('descript');
            $category->slug = $request->input('slug');
            $category->name = $request->input('name');
            $category->description = $request->input('description');
            $category->status = $request->input('status') == true ? '1' : '0';
            $category->save();
            return response()->json([
                'status' => 200,
                'message' => 'Category add Successfully',

            ]);
        }
    }

    public function edit($id)
    {
        $category = Category::find($id);
        if ($category) {
            return response()->json([
                'status' => 200,
                'category' => $category,

            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Id Category Found',

            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
            'title' => 'required|string|max:191',
            'slug' => 'required|string|max:191',
            'name' => 'required|string|max:191',


        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),

            ]);
        } else {
            $category =  Category::find($id);
            if ($category) {
                $category->title = $request->input('title');
                $category->keywords = $request->input('keywords');
                $category->descript = $request->input('descript');
                $category->slug = $request->input('slug');
                $category->name = $request->input('name');
                $category->description = $request->input('description');
                $category->status = $request->input('status') == true ? '1' : '0';
                $category->save();
                return response()->json([
                    'status' => 200,
                    'message' => 'Category Updated Successfully',

                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Not Category ID Found',

                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Category Delete Successfully',

            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Not Category ID Found',

            ]);
        }
    }
}
