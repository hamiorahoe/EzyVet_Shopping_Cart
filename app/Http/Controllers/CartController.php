<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\Helpers\cartHelper;
use App\Classes\cart;


class CartController extends Controller
{
    private $cart;
    public function __construct()
    {
        $this->cart = new cart();
    }

    //Get cart items and display the shopping cart page
    public function getCart()
    {
        // ######## please do not alter the following code ########
        $products = [
            [ "name" => "Sledgehammer", "price" => 125.75 ],
            [ "name" => "Axe", "price" => 190.50 ],
            [ "name" => "Bandsaw", "price" => 562.131 ],
            [ "name" => "Chisel", "price" => 12.9 ],
            [ "name" => "Hacksaw", "price" => 18.45 ],
        ];
        // ########################################################

        //Image paths for product thumbnail images
        $images = [
            "images/sledge.jpg",
            "images/axe.jpg",
            "images/bandsaw.jpg",
            "images/chisel.jpg",
            "images/hacksaw.jpg"
        ];

        $productList = cartHelper::initProductList($products, $images);

        $cartItems = $this->cart->items();
        $cartTotal = $this->cart->totalPrice();

        //Display the shopping cart view with cart items and total populated
        return view('home.index', [
            "cartItems" => $cartItems,
            'cartTotal' => $cartTotal,
            'products' => $productList
        ]);
    }

    //Add an item to the shopping cart and update the session
    public function addToCart(Request $request)
    {
        //Get item array from request variable
        $item = array_slice($request->all(),1);
        //Add item to cart
        $this->cart->add($item);

        //Load cart array, calc total and display the cart view
        return redirect('/');
    }

    //Remove an item from the shopping cart
    public function removeFromCart($id)
    {
        $this->cart->remove($id);

        return redirect('/');
    }
    //Add one to the quantity of a given cart item
    public function addQty($id)
    {
        $this->cart->updateQty($id, 1);
        return redirect('/');
    }
    //Subtract one from the quantity of a given cart item
    public function minusQty($id)
    {
        $this->cart->updateQty($id, -1);
        return redirect('/');
    }

}
