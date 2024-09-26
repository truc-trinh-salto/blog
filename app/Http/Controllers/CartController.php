<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class CartController extends Controller
{
    public function addToCart(Request $request){
        $bookId = $request->input('book_id');
        $quantity = 1;

        //Session retrieve value and default value
        $cart = session('cart',[]);
        $qtyCart = session('qty_array',[]);

        if(in_array($bookId,$cart)){
            $index = array_search($bookId,$cart);
            $qtyCart[$index] += $quantity;
        } else {
            $cart[] = $bookId;
            $qtyCart[] = $quantity;
        }

        //Session store value
        session()->put('cart', $cart);
        session()->put('qty_array', $qtyCart);

        $book_cart = Book::find(session('cart'));
        return view('user.partials.in_cart',['book_cart'=> $book_cart]);
    }

    public function removeFromCart(Request $request){

        $bookId = $request->query('book_id');
        $index = $request->query('index');
        
        //Session retrieve value and default value of cart session
        $cart = session('cart',[]);
        $qtyCart = session('qty_array',[]);

        if(($key = array_search($bookId, $cart)) !== false) {
            unset($cart[$key]);
            unset($qtyCart[$index]);
            
            $cart = array_values($cart);
            $qtyCart = array_values($qtyCart);
        }

        //Session store value
        session()->put('cart', $cart);
        session()->put('qty_array', $qtyCart);

        //Session using flash for back
        session()->flash('status', 'Remove was successful!');

        return back();
    }

    public function showCart(Request $request){

        $cartSession = request()->session()->get('cart'); 

        //Session portion of session data
        $carts = Book::find($cartSession);
        

        return view('user.view_cart',['carts'=>$carts]);
    }

    public function clearCart(){

        //Session delete value
        session()->forget(['cart','qty_array']);

        //Session delete all session data
        session()->flush();
    }

    public function updateCart(Request $request){

        //Session retrieve value and default value
        $cart = session('cart',[]);
        $qtyCart = session('qty_array',[]);
        $indexes = $request->input('indexes',[]);


        if(count($indexes) > 0){
            foreach($indexes as $index){
                $newQty = $request->input('qty_'.$index);
                if($newQty <= 0){
                    unset($cart[$index]);
                    unset($qtyCart[$index]);
                    $cart = array_values($cart);
                    $qtyCart = array_values($qtyCart);
                } else {
                    $qtyCart[$index] = $newQty;
                }
    
            }
        }

        //Session store value
        session()->put('cart',$cart);

        session()->put('qty_array',$qtyCart);

        //Session using flash for back
        session()->flash('status', 'Update was successful!');


        return back();
    }


}
