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

    public static function initProductList($products, $images){
        $r = $products;
        $id = 0;
        foreach ($r as $product){
            $product["id"] = $id;
            $product["image"] = $images[$id];
            $r[$id] = $product;
            $id ++;
        }
        error_log(print_r($products, TRUE));

        return $r;
    }
}
