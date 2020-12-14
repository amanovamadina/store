<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('id')->paginate(10)->setPath('products');
		$categories = Category::all();
		return view('index', compact(['products','categories']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	 /*
    public function create()
    {
		$categories = Category::all();
        return view('products.create', compact('categories'));
    }
*/
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
		'name' => 'required',
		'count' => 'required',
		'category_id' => 'required',
		'price' => 'required'
		]);
		
		
		
		$product = Product::create($request->all());
		//return redirect()->back()->with('success', 'Create Successfully');
		if(!is_null($product)) {
            return response()->json(["status" => "success", "message" => "Success! Product created.", "data" => $product]);
       }

       else {
           return response()->json(["status" => "failed", "message" => "Alert! Product not created"]);
       }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
	 /*
    public function show($id)
    {
        $product = Product::find($id);
		return view('products.show', compact(['product']));
    }
*/
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
	 /*
    public function edit($id)
    {
		$categories = Category::all();
        $product = Product::find($id);
		return view('products.edit', compact(['product', 'categories']));
    }
*/
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $product_id = $request->id;
		
		$product = Product::where('id', $product_id)->update($request->all());
		//return redirect()->back()->with('success','Update Successfully');
		if($product == 1) {
            return response()->json(["status" => "success", "message" => "Success! Product updated"]);
        }

        else {
            return response()->json(["status" => "failed", "message" => "Alert! Product not updated"]);
        }
	
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($product_id)
    {

        $product = Product::where('id',$product_id)->delete();
		
		if($product == 1) {
            return response()->json(["status" => "success", "message" => "Success! Product deleted"]);
			return redirect()->back();
        }

        else {
            return response()->json(["status" => "failed", "message" => "Alert! Product not deleted"]);
        }
	}
}
