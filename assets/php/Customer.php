<?php
    class Customer{
        public $order_number, $track_number, $telephone, $name, $method, $price;
        public $address, $subdistrict, $district, $province, $postcode;
        public $contact, $telephone_opt;

        function __construct($order, $tracking, $contact, $tel, $tel_opt, $name, $price, $method, $address, $subdistrict, $district, $province, $postcode){
            $this->order_number = $order;
            $this->track_number = $tracking;
            $this->telephone = $tel;
            $this->name = $name;
            $this->method = $method;
            $this->price = $price;
            $this->address = $address;
            $this->subdistrict = $subdistrict;
            $this->district = $district;
            $this->postcode = $postcode;
            $this->province = $province;
            $this->contact = $contact;
            $this->telephone_opt = $tel_opt;
        }
    }
?>
