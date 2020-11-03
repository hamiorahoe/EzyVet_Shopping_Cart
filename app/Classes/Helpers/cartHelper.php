<?php


namespace App\Classes\Helpers;


//Helper class to hold functions outside of the scope of the controller
class cartHelper
{
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
