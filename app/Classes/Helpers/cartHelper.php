<?php


namespace App\Classes\Helpers;


//Helper class to hold functions outside of the scope of the controller
class cartHelper
{
    //Loop through cart array and check if the given item ID matches the ID of any item in the cart
    public static function isItemInCart($item, $cart)
    {
        foreach ($cart as $c) {
            if($c['id'] == $item['id']){
                return true;
            }
        }
        return false;
    }
}
