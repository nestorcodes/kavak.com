<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Car;
use App\User;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
         $this->middleware('auth');
    }

    public function cart()  {
        $cartCollection = \Cart::getContent();
        // dd($cartCollection);
        return view('cart.cart', [
            'cartCollection' => $cartCollection
        ]);
    }

    public function add(Request $request){
         //validate
         $this->validate($request,[
            'quantity' => 'int|required|min:1',
            'id' => 'required',
        ] );
         // Condicion
         $taxCondition = new \Darryldecode\Cart\CartCondition(array(
            'name' => 'Iva 16%',
            'type' => 'tax',
            'value' => '16%',
        ));
        $this->validate($request,[
            'id' => 'required',
        ] );
        $item = Car::findOrFail($request->id);
        // return $request;
        \Cart::add(array(
            'id' => $request->id,
            'price' => $item->price,
            'brand_id'  => $item->brand_id,
            'model_id'  => $item->model_id,
            'quantity' => $request->quantity,
            'attributes' => array(
                'details' => $item->details,
            ),
            'conditions' => $taxCondition
        ));
        return redirect()->route('cart.index')->with('success_msg', '¡El Auto se Agregó al Carrito!');
    }

    public function remove(Request $request){
        \Cart::remove($request->id);
        return redirect()->route('cart.index')->with('success_msg', '¡El Auto ha Sido Eliminado!');
    }

    public function update(Request $request){
        \Cart::update($request->id,
            array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $request->quantity
                ),
        ));
        return redirect()->route('cart.index')->with('success_msg', '¡El Carrito Fue Actualizado!');
    }

    public function clear(){
        \Cart::clear();
        return redirect()->route('cars.show')->with('success_msg', '¡El Carrito fue Vaciado!');
    }
}
