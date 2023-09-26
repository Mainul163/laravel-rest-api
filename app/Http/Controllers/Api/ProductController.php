<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use App\Models\Product;
use Validator;
class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products=Product::all();
        
        //   **********    1st way to show json Data ********

        // return $this->sendResponse($products->toArray(),'products Retrieved');


          //   **********    2nd way to show json Data ********

        return $this->sendResponse(ProductResource::collection( $products),'products Retrieved');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

         $validator=Validator::make($request->all(),[
             'name'          =>'required',
             'description'   =>'required'

         ]);

         if($validator->fails()){

            return $this->sendError('Validation Error',$validator->errors());
         }

         $product=Product::create($request->all());
         return $this->sendResponse(new ProductResource($product),'Product Created successfully');

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
        $product=Product::find($id);
        if(is_null($product)){

            return $this->sendError('Product Not Found');
        }

        return $this->sendResponse(new ProductResource($product),'Product retrieved');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, Product $product)
    {
        //
        $validator=Validator::make($request->all(),[
            'name'          =>'required',
            'description'   =>'required'

        ]);

        if($validator->fails()){

           return $this->sendError('Validation Error',$validator->errors());
        }
        $product->update($request->all());
        return $this->sendResponse(new ProductResource($product),'Product updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)

    {
        //

        $product->delete();
        return $this->sendResponse(new ProductResource($product),'Product deleted');
    }
}