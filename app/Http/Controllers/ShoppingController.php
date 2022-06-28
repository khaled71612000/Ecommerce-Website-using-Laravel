<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class ShoppingController extends Controller
{
    public function add_to_cart() {

        $pdt = Product::find(request()->pdt_id);

      $cartItem =  Cart::add([
            'id' => $pdt->id,
            'name' =>$pdt->name,
            'qty' => request() ->qty,
            'price' =>$pdt->price
        ]);

        // attatch item with model 
        Cart::associate($cartItem->rowId,'App\Product');
        session()->flash('success','added to cart');

        // dd(Cart::content());

        return redirect()->route('cart');
    }
    public function cart() {


        return view('cart');
       
    }
    
    public function cart_delete($id) {
        Cart::remove($id);
        session()->flash('success','removed from cart');
        return redirect()->route('cart');
    }


    public function incr($id,$qty) {
        
        Cart::update($id, $qty + 1 );
        session()->flash('success','added to cart');

        return redirect()->back();
    }
    public function decr($id,$qty) {
        
        Cart::update($id, $qty - 1 );
        session()->flash('success','removed from cart');

        return redirect()->back();
    }
    public function rapid_Add($id) {

        $pdt = Product::find($id);

      $cartItem =  Cart::add([
            'id' => $pdt->id,
            'name' =>$pdt->name,
            'qty' => 1,
            'price' =>$pdt->price
        ]);

        // attatch item with model 
        Cart::associate($cartItem->rowId,'App\Product');

        session()->flash('success','added to cart');

        // dd(Cart::content());

        return redirect()->route('cart');
    }

}
