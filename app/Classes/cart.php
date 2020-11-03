<?php


namespace App\Classes;

use App\Classes\Helpers\cartHelper;
use Illuminate\Support\Facades\Session;


class cart
{
    private $minQty;
    public function __construct($options = [])
    {

        $this->minQty = isset($options['minQty']) ? $options['minQty'] : 1;
    }

    public function items(){
        return Session::has('cartItems') ? Session::get('cartItems') : null;
    }

    public function totalPrice(){
        $total = 0;
        if(Session::has('cartItems')){
            $items = Session::get('cartItems');
            foreach ($items as $item){
                //Multiply item price by quantity to get total
                $itemTotal = (int)$item["qty"]*(double)$item['price'];
                $total+=$itemTotal;
            }
        }
        return $total;
    }

    public function add($item)
    {
        //Check if cart is populated and get cart item array
        $cartItems = Session::has("cartItems") ? Session::get("cartItems") : [];
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
        Session::put("cartItems", $cartItems);
    }

    public function remove($id)
    {
        //Check if cart is populated and get cart item array or assign it to blank array
        $cartItems = Session::has("cartItems") ? Session::get("cartItems") : [];
        //Check if the item exists in the cart and delete it
        if(isset($cartItems[(int)$id])){
            unset($cartItems[(int)$id]);
        }
        //Replace the cart array with the updated array
        Session::put("cartItems", $cartItems);
    }

    public function updateQty($id, $offset)
    {
        //Get cart items
        $cartItems = Session::has("cartItems") ? Session::get("cartItems") : [];
        //update item quantity at given index
        $cartItems[(int)$id]['qty'] += $offset;
        //Replace session array with updated array

        if($cartItems[(int)$id]['qty'] < $this->minQty)
        {
            $cartItems[(int)$id]['qty'] = $this->minQty;
            Session::put("msg", "Quantity cannot be lower than " . $this->minQty);
        }
        Session::put("cartItems", $cartItems);
    }
}
