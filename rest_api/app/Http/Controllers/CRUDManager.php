<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Products;
use App\Models\User;

class CRUDManager extends Controller
{

    function create(Request $request){


// receiving product details
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
        ]);
       if ($validator->fails()){
        return response()->json(['status' => 'error', 'message'=> $validator->messages()]);
       }
        $product = new Products();
        $product->name = $request->input('name');
        // $product-> user_id = auth()->user()->id;
        $product->description = $request->input('description');
        $product->price= $request->input('price');
        if($product->save()){
            return response()->json(['status' => 'success' , 'product'=> $product , 'message' => 'Product created']);
        
        }
        return response()->json(['status'=> 'error', 'message'=> 'Product created failed']);
    }
    function read(){
        $products =Products::all();
        return response()->json(['status'=>'success','products'=>$products,"message"=>"Product read"]);
    }
    function update(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'description' => 'requires',
            'price'=> 'required',
        ]);
        if( $validator->fails()){
            return response()->json(['status'=> 'error', 'message' => $validator-> messages()]);

        }
        $validator = $validator->validate();
        $product = Products::where('id', $id)->where("user_id" , auth()->user()->id)->first();
        if (!$product){
            return response()->json(["status"=> "error","message"=> "Product not found"]);
        }
        $product-> name = $validator['name'];
        $product->description = $validator['description'];
        $product->price = $validator['price'];
        if ($product->save()){
            return response()->json(['status'=> 'seccess', 'product'=> $product, 'message'=> 'Product updated']);

        }
        return response()->json(['status' => 'error','message'=> 'Product update failed']);
    }
    function delete($id){
        if(Products::where('id', $id)->where("user_id", auth()->user()->id)->delete()){
            return response()->json(['status'=>'success', 'message' => 'Product delete']);

    }
    return response()->json(['staus' => 'error', 'message'=>'Product deleted']);
}
}
