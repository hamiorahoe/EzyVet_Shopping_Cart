<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Classes\Helpers\cartHelper;


class CartController extends Controller
{
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
        //Check if cart items exist in session and assign to a variable
        $cartItems = Session::has("cartItems") ? Session::get("cartItems") : null;

        $cartTotal = 0;

        //check if Shopping Cart is populated and calculate total price of items
        if(isset($cartItems)){
            foreach($cartItems as $item){
                //Multiply item price by quantity to get total
                $itemTotal = (int)$item["qty"]*(double)$item['price'];
                $cartTotal+=$itemTotal;
            }
        }

        //Display the shopping cart view with cart items and total populated
        return view('home.index', [
            "cartItems" => $cartItems,
            'cartTotal' => $cartTotal,
            'products' => $products,
            "images" => $images
        ]);
    }

    //Add an item to the shopping cart and update the session
    public function addToCart(Request $request)
    {
        //Get item array from request variable
        $item = $request->all();
        //Check if cart is populated and get cart item array
        $cartItems = $request->session()->has("cartItems") ? $request->session()->get("cartItems") : [];
        //Check if current item is already in the cart. If already in the cart then add 1 to the quantity, else add item to
        //cart with quantity of 1
        if(cartHelper::isItemInCart($item, $cartItems)){
            $cartItems[(int)$item['id']]["qty"] += 1;
        }
        else{
            $item["qty"] = 1;
            $cartItems[$item['id']] = $item;
        }
        //Replace the cart array in the session with the updated array
        $request->session()->put("cartItems", $cartItems);

        //Load cart array, calc total and display the cart view
        return redirect('/');
    }

    //Remove an item from the shopping cart
    public function removeFromCart($id)
    {
        //Check if cart is populated and get cart item array or assign it to blank array
        $cartItems = Session::has("cartItems") ? Session::get("cartItems") : [];
        //Check if the item exists in the cart and delete it
        if(isset($cartItems[(int)$id])){
            unset($cartItems[(int)$id]);
        }
        //Replace the cart array with the updated array
        Session::put("cartItems", $cartItems);

        return redirect('/');
    }
    //Add one to the quantity of a given cart item
    public function addQty($id)
    {
        //Get cart items
        $cartItems = Session::has("cartItems") ? Session::get("cartItems") : [];
        //update item quantity at given index
        $cartItems[(int)$id]['qty'] += 1;
        //Replace session array with updated array
        Session::put("cartItems", $cartItems);
        return redirect('/');
    }
    //Subtract one from the quantity of a given cart item
    public function minusQty($id)
    {
        $cartItems = Session::has("cartItems") ? Session::get("cartItems") : [];
        //Check if current quantity is greater than 1 and prevent user from assigning 0 or negative value
        if($cartItems[(int)$id]['qty'] > 1){
            //If greater than 1, subtract 1 from quantity
            $cartItems[(int)$id]['qty'] -= 1;
        }
        else{
            return redirect('/')->with('msg', 'Quantity cannot be lower than 1');
        }
        Session::put("cartItems", $cartItems);
        return redirect('/');
    }





}
