<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Product;
use App\User;

class ProductController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
  public function index()
  {
//    $products = Product::all();
//    return view('products.index', compact('products'));
    $products = DB::table('products')->paginate(4);
    return view('products.index', ['products' => $products]);
  }
  
  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $product = Product::find($id);
    return view('products.show', ['product'=>$product, 'intent'=>User::find(1)->createSetupIntent()]);
  }
}
