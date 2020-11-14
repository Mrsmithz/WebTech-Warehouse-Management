<?php
 class Item{
     public $item_name, $item_type;
     public $item_price, $item_weight;
     public $quantity, $user_id;

     function __construct($name, $type, $price, $weight, $quantity, $user_id){
         $this->item_name = $name;
         $this->item_type = $type;
         $this->item_price = $price;
         $this->item_weight = $weight;
         $this->quantity = $quantity;
         $this->user_id = $user_id;
     }
     function getUser_id(){
         return $this->user_id;
     }
 }
?>
