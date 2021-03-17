<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $product= Product::all();
        return response()->success($product,'successful',200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make(
            $data,
            [
                'title' => 'required|string',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'image' => 'required|string',
            ]
        );

        if ($validator->fails()) {
            return response()->error($validator->errors()->first(),400);           
        }
        $product=Product::create($data);
        if ($product) {
            return response()->success($product,'Insert successful',201);
        } else {
            return response()->error('Product not saved',422);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,Product $product)
    {
        dd($product->id);
        $data = $product->find($product->id);
        if ($data) {
            return response()->success($product,'Product detail',201);
        } else {
            return response()->error('Product not saved',422);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->all();
        $validator = Validator::make(
            $data,
            [
                'title' => 'filled|string',
                'description' => 'filled|string',
                'price' => 'filled|numeric',
                'image' => 'filled|string',
            ]
        );

        if ($validator->fails()) {
            return response()->error($validator->errors()->first(),400);
        }

        $product->update($data);

        if ($product) {
            return response()->success($product,'update successful',201);
        } else {
            return response()->error('Product not saved',422);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if ($product->delete()) {
            return response()->success($product,'Delete successful',201);
        } else {
            return response()->error('Product not Deleted',422);
        }

    }
}
