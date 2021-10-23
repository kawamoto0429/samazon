<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $sort_query = [];
        $sorted = "";

        if ($request->sort !== null) {
            $slices = explode(' ', $request->sort);
            $sort_query[$slices[0]] = $slices[1];
            $sorted = $request->sort;
        }

        
        $sort_query = [];
        $sorted = "";

        if ($request->sort !== null) {
            $slices = explode(' ', $request->sort);
            $sort_query[$slices[0]] = $slices[1];
            $sorted = $request->sort;
        }

        if ($request->category !== null) {
            $products = Product::where('category_id', $request->category)->sortable($sort_query)->sortable($sort_query)->paginate(15);
            $category = Category::find($request->category);
        } else {
            $products = Product::sortable($sort_query)->sortable($sort_query)->paginate(15);
            $category = null;
        }
        
        $sort = [
            '並び替え' => '', 
            '価格の安い順' => 'price asc',
            '価格の高い順' => 'price desc', 
            '出品の古い順' => 'updated_at asc', 
            '出品の新しい順' => 'updated_at desc'
        ];
        
        $categories = Category::all();
        $major_category_names = Category::pluck('major_category_name')->unique();

        return view('products.index', compact('products', 'category', 'categories', 'major_category_names', 'sort', 'sorted'));
    }
    
    public function favorite(Product $product)
    {
        $user = Auth::user();

        if ($user->hasFavorited($product)) {
            $user->unfavorite($product);
        } else {
            $user->favorite($product);
        }

        return redirect()->route('products.show', $product);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $reviews = $product->reviews()->get();

        return view('products.show', compact('product', 'reviews'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
}
