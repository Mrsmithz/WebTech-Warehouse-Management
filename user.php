<?php
session_start();
$sessionlifetime = 20;
if(isset($_SESSION["timeLasetdActive"])){
	$seclogin = (time()-$_SESSION["timeLasetdActive"])/60;
	if($seclogin>$sessionlifetime){
		session_destroy();
	}else{
		$_SESSION["timeLasetdActive"] = time();
	}
}else{
	$_SESSION["timeLasetdActive"] = time();
}
if (!isset($_SESSION['firstname'])){
    echo '<script type="text/javascript">',
        'window.location.href = "login.php"',
            '</script>';
     exit;
}
include "assets/php/Account.php";
$acct = new Account();
$acct->id = $_SESSION['id'];
$acct->firstname = $_SESSION['firstname'];
$acct->lastname = $_SESSION['lastname'];
$acct->username = $_SESSION['username'];
$acct->password = $_SESSION['password'];
$acct->email = $_SESSION['email'];
$acct->tel = $_SESSION['telephone'];
function getItem(){
    $acct = $GLOBALS['acct'];
    $result = $acct->getAllItem();
    if ($result){
        $item = array();
        while ($row = $result->fetch_assoc()){
            $temp = array("id"=>$row['item_id'], "name"=>$row['item_name'], "type"=>$row['item_type'], "price"=>$row['item_price'], "weight"=>$row['item_weight'], "quantities"=>$row['quantity']);
            array_push($item, $temp);
        }
        echo json_encode($item);
    }
}
function getCustomer(){
    $acct = $GLOBALS['acct'];
    $result = $acct->getCustomer();
    if ($result){
        $customer = array();
        while ($row = $result->fetch_assoc()){
            $temp = array('customer_name'=>$row['name'], 'customer_phone'=>$row['telephone'], 'customer_address'=>$row['address'], 'customer_district'=>$row['district'], 'customer_sub_district'=>$row['subdistrict'], 'customer_province'=>$row['province'], 'customer_postcode'=>$row['postcode']);
            array_push($customer, $temp);
        }
        echo json_encode($customer);
    }
}
function getOrder(){
    $acct = $GLOBALS['acct'];
    $result = $acct->getCustomer();
    if ($result){
        $order = array();
        while ($row = $result->fetch_assoc()){
            $temp = array('order_number'=>$row['order_number'], 'track_number'=>$row['track_number'], 'phone_number'=>$row['telephone'], 'customer_name'=>$row['name'], 'price'=>$row['price'], 'payment'=>$row['method'], 'create_date'=>$row['date']);
            array_push($order, $temp);
        }
        echo json_encode($order);
    }
}
function getQuantity(){
    $acct = $GLOBALS['acct'];
    $result = $acct->getAllItem();
    if ($result){
        $item = array();
        $count = 1;
        while ($row = $result->fetch_assoc()){
            if ($count >= 15){
                break;
            }
            $temp =  array('name'=>$row['item_name'], 'quantities'=>$row['quantity']);
            array_push($item, $temp);
            $count++;
        }
        shuffle($item);
        echo json_encode($item);
    }
}
function getItemType(){
    $acct = $GLOBALS['acct'];
    $result = $acct->getAllItem();
    if ($result){
        $first = true;
        $item = array();
        $count = 1;
        while ($row = $result->fetch_assoc()){
            $value = $row['item_type'];
            if ($count >= 15){
                break;
            }
            $count++;
            if (!$item){
                $temp = array('quantities'=>1, 'type'=>$value);
                array_push($item, $temp);
            }
            for ($i = 0;$i<sizeof($item);$i++){
                if (!strcmp($value, $item[$i]['type'])){
                    $item[$i]['quantities'] = $item[$i]['quantities']+1;
                    continue 2;
                }
            }
            $temp = array('quantities'=>1, 'type'=>$value);
            array_push($item, $temp);
        }
        echo json_encode($item);
    }
}
function getPrice(){
    $acct = $GLOBALS['acct'];
    $result = $acct->getAllItem();
    if($result){
        $item = array();
        $count = 1;
        while ($row = $result->fetch_assoc()){
            if ($count >= 15){
                break;
            }
            $count++;
            $temp = array('name'=>$row['item_name'], 'price'=>$row['item_price']);
            array_push($item, $temp);
        }
        echo json_encode($item);
    }
}
function getWeight(){
    $acct = $GLOBALS['acct'];
    $result = $acct->getAllItem();
    if($result){
        $item = array();
        while ($row = $result->fetch_assoc()){
            if ($count >= 15){
                break;
            }
            $count++;
            $temp = array('name'=>$row['item_name'], 'weight'=>$row['item_weight']);
            array_push($item, $temp);
        }
        echo json_encode($item);
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <meta charset="UTF-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui" />
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <style>
        * {
            letter-spacing: -0.5px;
        }

        #inspire {
            background-color: #eff2f5;
            display: flex;
            justify-content: center;
            min-height: 100vh;
        }

        .logo {
            height: inherit;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            border-right: 2px solid #d0dadc;
        }

        .bars-button {
            box-shadow: none !important;
            font-size: 18px !important;
            padding-top: 15px !important;
            justify-content: left !important;
        }

        .bars-button-last {
            box-shadow: none !important;
            font-size: 18px !important;
            padding-top: 15px !important;
            justify-content: left !important;
            background-color: #1d8649 !important;
            color: white !important;
            border-radius: 9px !important;
        }

        .bars-button-user {
            box-shadow: none !important;
            font-size: 18px !important;
            justify-content: left !important;
        }

        .bars-button-bell {
            padding: 0 !important;
            box-shadow: none !important;
            border-radius: 50px !important;
            font-size: 23px !important;
            color: #1d8649 !important;
        }

        .bars-button-right {
            box-shadow: none !important;
            font-size: 18px !important;
            padding-top: 15px;
            justify-content: left !important;
            float: right !important;
        }

        .result-col {
            font-size: 18px;
            font-weight: 600;
            margin-top: 10px;
            border-right: 1px solid rgba(0, 0, 0, .1);
        }

        .button-right {
            box-shadow: none !important;
            padding-top: 15px !important;
            font-size: 22px !important;
            background-color: #1d8649 !important;
            border-radius: 2px !important;
            color: white !important;
        }

        .v-tab--active {
            color: black !important;
        }

        .v-text-field--outlined fieldset {
            border-color: #989fa1 !important;
        }

        .v-btn--outlined {
            border-color: #d9dee2 !important;
            box-shadow: none !important;
        }

        .v-application .elevation-2 {
            box-shadow: none !important;
        }

        .v-btn {
            min-width: 0 !important;
        }

        th {
            font-size: 14px !important;
        }

        td {
            font-size: 18px !important;
        }

        .add-item {
            max-height: 70vh;
            overflow: scroll;
            overflow-x: hidden;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        .v-list-item {
            font-family: 'Kanit', sans-serif;
        }

        .border-green {
            border: 1px solid #1d8649 !important;
            box-shadow: none !important;
        }

        .v-pagination__item {
            background-color: #1d8649 !important;
        }

        .table-border td{
            border-bottom: 1px solid rgba(0, 0, 0, .1) !important;
            border-right: 1px solid rgba(0, 0, 0, .1) !important;
        }

        .black-table .v-data-table-header {
            background-color: #424242 !important;
            border-radius: 5px !important;
        }

        .black-table .v-data-table-header th {
            color: white !important;
        }

        .black-table .v-data-table-header th i {
            color: white !important;
        }

        .green-table .v-data-table-header {
            background-color: #1d8649 !important;
            border-radius: 5px !important;
        }

        .green-table .v-data-table-header th {
            color: white !important;
            font-size: 16px !important;
        }

        .NonSelectedBankDiv {
            border-radius: 10px;
            -webkit-filter: grayscale(100%);
            filter: grayscale(100%);
        }

        .selectedBankImageIcon img {
            -webkit-box-shadow: 0 0 15px #08a7a3;
            box-shadow: 0 0 15px #08a7a3;
            -webkit-filter: grayscale(0);
            filter: grayscale(0);
            border-radius: 10px;
        }

        .row-pointer {
            cursor: pointer;
        }

        @media screen and (max-width: 600px) {}
    </style>
</head>

<body>
    <div id="app">
        <v-app id="inspire">

            <v-app-bar absolute dense style="
            background-color: rgb(248, 248, 248);
            border-color: rgb(248, 248, 248);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            padding: 0px 10px;
            font-family: 'Sarabun', sans-serif;
          ">
                <div class="logo hidden-sm-and-down">
                    <span>
                        <img src="img/logo.png" style="height: 27.5px; padding-right: 26px" />
                    </span>
                </div>
                <div class="v-toolbar__items hidden-sm-and-down">
                    <v-btn class="v-btn--flat v-btn--text theme--light bars-button" @click="to_Overview()">
                        <p>ภาพรวม</p>
                    </v-btn>
                </div>
                <div class="v-toolbar__items hidden-sm-and-down">
                    <v-menu offset-y>
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn class="v-btn--flat v-btn--text theme--light bars-button " v-bind="attrs" v-on="on"
                                style="padding: 0 15px">
                                <p style="padding-right: 8px">
                                    สินค้า <i class="fa fa-caret-down" aria-hidden="true"></i>
                                </p>
                            </v-btn>
                        </template>
                        <v-list>
                            <v-list-item :key="index" style="padding: 0 0;">
                                <v-btn class="v-btn--flat v-btn--text theme--light bars-button"
                                    @click="to_ManageProduct()" v-bind="attrs" v-on="on" style="height: 48px;">
                                    <p style="font-size: 18px;">
                                        จัดการสินค้า
                                    </p>
                                </v-btn>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </div>
                <div class="v-toolbar__items hidden-sm-and-down">
                    <v-menu offset-y>
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn class="v-btn--flat v-btn--text theme--light bars-button" v-bind="attrs" v-on="on"
                                style="padding: 0 15px">
                                <p style="padding-right: 8px">
                                    ออเดอร์ <i class="fa fa-caret-down" aria-hidden="true"></i>
                                </p>
                            </v-btn>
                        </template>
                        <v-list>
                            <v-list-item :key="index" style="padding: 0 0;">
                                <v-btn class="v-btn--flat v-btn--text theme--light bars-button" v-bind="attrs" v-on="on"
                                    @click="to_Orders()" style="height: 48px; width: 100%;">
                                    <p style="font-size: 18px;">
                                        รายการ
                                    </p>
                                </v-btn>
                            </v-list-item>
                            <v-list-item :key="index" style="padding: 0 0;">
                                <v-btn class="v-btn--flat v-btn--text theme--light bars-button" v-bind="attrs" v-on="on"
                                    @click="to_Create_Orders()" style="height: 48px; width: 100%;">
                                    <p style="font-size: 18px;">
                                        สร้างออเดอร์
                                    </p>
                                </v-btn>
                            </v-list-item>
                            <v-list-item :key="index" style="padding: 0 0;">
                                <v-btn class="v-btn--flat v-btn--text theme--light bars-button" v-bind="attrs" v-on="on"
                                    style="height: 48px; width: 100%;">
                                    <p style="font-size: 18px;">
                                        กู้คืนออเดอร์
                                    </p>
                                </v-btn>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </div>
                <div class="v-toolbar__items hidden-sm-and-down">
                    <v-btn @click="to_Customer()" class="v-btn--flat v-btn--text theme--light bars-button">
                        <p>รายชื่อลูกค้า</p>
                    </v-btn>
                </div>
                <div class="v-toolbar__items hidden-sm-and-down">
                    <v-menu offset-y>
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn class="v-btn--flat v-btn--text theme--light bars-button" v-bind="attrs" v-on="on"
                                style="padding: 0 15px">
                                <p style="padding-right: 8px">
                                    รายงาน <i class="fa fa-caret-down" aria-hidden="true"></i>
                                </p>
                            </v-btn>
                        </template>
                        <v-list>
                            <v-list-item :key="index" style="padding: 0 0;">
                                <v-btn class="v-btn--flat v-btn--text theme--light bars-button" @click="to_Deep_Overview()" v-bind="attrs" v-on="on"
                                    style="height: 48px; width: 100%;">
                                    <p style="font-size: 18px;">
                                        ภาพรวมอย่างละเอียด
                                    </p>
                                </v-btn>
                            </v-list-item>
                            <v-list-item :key="index" style="padding: 0 0;">
                                <v-btn class="v-btn--flat v-btn--text theme--light bars-button" v-bind="attrs" v-on="on"
                                    style="height: 48px; width: 100%;">
                                    <p style="font-size: 18px;">
                                        รายงานการขนส่ง
                                    </p>
                                </v-btn>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </div>
                <div class="v-toolbar__items hidden-sm-and-down">
                    <v-btn class="v-btn--flat v-btn--text theme--light bars-button" style="overflow: hidden;">
                        <p>ช่องทางการขาย</p>
                        <svg width="90" height="50" viewBox="0 0 200 200"
                            style="position: absolute; left: 60px; top: 5px;">
                            <image width="200" height="200" xlink:href="img/beta.svg" />
                        </svg>
                    </v-btn>
                </div>
                <div class="v-toolbar__items hidden-sm-and-down">
                    <v-btn class="v-btn--flat v-btn--text theme--light bars-button" style="overflow: hidden;">
                        <p>ศูนย์ช่วยเหลือ</p>
                    </v-btn>
                </div>
                <div class="v-toolbar__items hidden-sm-and-down" style="padding: 5px 0;">
                    <v-btn class="bars-button-last" style="overflow: hidden;">
                        <p>สมัครลูกค้าประจำ</p>
                    </v-btn>
                </div>
                <div class="spacer"></div>
                <div class="v-toolbar__items hidden-sm-and-down">
                    <v-menu offset-y>
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn class="v-btn--flat v-btn--text theme--light bars-button-user" v-bind="attrs"
                                v-on="on" style="padding: 0 15px; border-right: 2px solid #d0dadc; padding-top: 0;">

                                <p style="padding-right: 8px">
                                <div class="v-avatar" style="height: 25px; width: 25px; margin-right: 5px;">
                                    <img src="img/shop.png">
                                </div> <?php echo $_SESSION['firstname']." ".$_SESSION['lastname'];?> <i
                                    class="fa fa-caret-down" aria-hidden="true" style="margin-left: 5px;"></i>
                                </p>
                            </v-btn>
                        </template>
                        <v-list>
                            <v-list-item :key="index" style="padding: 0 0;">
                                <v-btn class="v-btn--flat v-btn--text theme--light bars-button" v-bind="attrs" v-on="on"
                                    style="height: 48px; width: 100%;">
                                    <p style="font-size: 18px;">
                                        แสดงร้านค้าทั้งหมด
                                    </p>
                                </v-btn>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </div>
                <div class="v-toolbar__items hidden-sm-and-down">
                    <v-btn class="bars-button-bell" icon>
                        <i class="fa fa-bell" aria-hidden="true"></i>
                    </v-btn>
                </div>
                <div class="v-toolbar__items hidden-sm-and-down" style="float: right;">
                    <v-menu offset-y>
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn class="v-btn--flat v-btn--text theme--light bars-button-right" v-bind="attrs"
                                v-on="on" style="padding: 0 25px;">
                                <div class="v-avatar" style="height: 40px; width: 40px;">
                                    <img
                                        src="https://www.shareicon.net/data/128x128/2015/10/07/113615_face_512x512.png">
                                </div>
                                <div class="v-avatar"
                                    style="height: 22px; width: 22px; position: absolute; background-color: white; font-size: 20px; top: 25px; left: 25px;">
                                    <i class="fa fa-cog" aria-hidden="true" style="color: #1d8649;"></i>
                                </div>
                            </v-btn>
                        </template>
                        <v-list>
                            <v-list-item :key="index" style="padding: 0 0;">
                                <v-btn class="v-btn--flat v-btn--text theme--light bars-button" v-bind="attrs" v-on="on"
                                    style="height: 48px; width: 100%;" @click="logout">
                                    <p style="font-size: 18px; color: #08a7a3;">
                                        ออกจากระบบ
                                    </p>
                                </v-btn>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </div>
            </v-app-bar>

            <div class="row wrap col-md-12 col-lg-10 col-xl-9" :lazy="lazy" v-if="is_Overview_Active"
                v-model="is_Overview_Active" transition="fade-transition"
                style="padding-top: 55px; margin: 0 auto; padding: 55px 50px; font-family: 'Sarabun', sans-serif;">
                <div class="col-lg-6">
                    <v-card tile
                        style="width: 100%; height: 180px; margin-bottom: 25px; box-shadow: 0 0 15px rgba(0, 0, 0, 0.2)">
                        <div>
                            <svg style="width:24px;height:24px; color: #1d8649; position: absolute; top: 22px; left: 15px;"
                                viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M17,17H15V13H17M13,17H11V7H13M9,17H7V10H9M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3Z" />
                            </svg>
                            <p
                                style="font-size: 23px; padding: 15px; padding-left: 40px; margin-bottom: 0; padding-bottom: 10px;">
                                สรุปยอดขาย</p>
                            <div class="row">
                                <div class="col-md-4 result-col" style="padding-left: 30px;">
                                    <p style="margin-bottom: 0;">0.00 ฿</p>
                                    <p>วันนี้</p>
                                </div>
                                <div class="col-md-4 result-col">
                                    <p style="margin-bottom: 0;">0.00 ฿</p>
                                    <p>สัปดาห์นี้</p>
                                </div>
                                <div class="col-md-4 result-col" style="border: none;">
                                    <p style="margin-bottom: 0;">0.00 ฿</p>
                                    <p>เดือนนี้</p>
                                </div>
                            </div>
                        </div>
                    </v-card>

                    <v-card tile style="width: 100%; margin-bottom: 15px; box-shadow: 0 0 15px rgba(0, 0, 0, 0.2) ">
                        <div>
                            <svg style="width:24px;height:24px; color: #1d8649; position: absolute; top: 22px; left: 15px;"
                                viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M6,17C6,15 10,13.9 12,13.9C14,13.9 18,15 18,17V18H6M15,9A3,3 0 0,1 12,12A3,3 0 0,1 9,9A3,3 0 0,1 12,6A3,3 0 0,1 15,9M3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3H5C3.89,3 3,3.9 3,5Z" />
                            </svg>
                            <p
                                style="font-size: 23px; padding: 15px; padding-left: 40px; margin-bottom: 0; padding-bottom: 10px;">
                                ปริมาณการสร้างออเดอร์ (ออเดอร์ต่อวัน)</p>

                        </div>
                    </v-card>

                    <v-card tile style="width: 100%; margin-bottom: 25px; box-shadow: 0 0 15px rgba(0, 0, 0, 0.2)">
                        <div class="row"
                            style="text-align: center; color:  #1d8649; font-size: 24px; padding-top: 5px;">
                            <div class="col-sm-6" style="border-right: 1px solid rgba(0, 0, 0, .1);">
                                <p>แผนภาพสินค้าขายดี</p>
                            </div>
                            <div class="col-sm-6">
                                <p>ช่องทางการขาย</p>
                            </div>
                        </div>
                    </v-card>
                </div>
                <div class="col-lg-6">
                    <v-card tile
                        style="width: 100%; height: 180px; margin-bottom: 25px; box-shadow: 0 0 15px rgba(0, 0, 0, 0.2)">
                        <div>
                            <svg style="width:24px;height:24px; color: #1d8649; position: absolute; top: 22px; left: 15px;"
                                viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M9 17H7V10H9V17M13 17H11V7H13V17M17 17H15V13H17V17M19.5 19.1H4.5V5H19.5V19.1M19.5 3H4.5C3.4 3 2.5 3.9 2.5 5V19C2.5 20.1 3.4 21 4.5 21H19.5C20.6 21 21.5 20.1 21.5 19V5C21.5 3.9 20.6 3 19.5 3Z" />
                            </svg>
                            <p
                                style="font-size: 23px; padding: 15px; padding-left: 40px; margin-bottom: 0; padding-bottom: 10px;">
                                สรุปคำสั่งซื้อ</p>
                            <div class="row">
                                <div class="col-md-4 result-col" style="padding-left: 30px;">
                                    <p style="margin-bottom: 0;">0 รายการ</p>
                                    <p>วันนี้</p>
                                </div>
                                <div class="col-md-4 result-col">
                                    <p style="margin-bottom: 0;">0 รายการ</p>
                                    <p>สัปดาห์นี้</p>
                                </div>
                                <div class="col-md-4 result-col" style="border: none;">
                                    <p style="margin-bottom: 0;">0 รายการ</p>
                                    <p>เดือนนี้</p>
                                </div>
                            </div>
                        </div>
                    </v-card>

                    <v-card tile style="width: 100%; margin-bottom: 20px; box-shadow: 0 0 15px rgba(0, 0, 0, 0.2)">
                        <div>
                            <span
                                style="width:24px;height:24px; color: #1d8649; position: absolute; top: 22px; left: 15px;"
                                class="material-icons">
                                list_alt
                            </span>
                            <p
                                style="font-size: 23px; padding: 15px; padding-left: 40px; margin-bottom: 0; padding-bottom: 10px;">
                                สินค้าขายดีวันนี้</p>

                        </div>
                    </v-card>

                    <div style="width: 100%;">
                        <v-btn class="button-right" style="overflow: hidden; float: right; " @click="to_Deep_Overview()">
                            <p>ภาพรวมอย่างละเอียด</p>
                        </v-btn>
                    </div>
                </div>
            </div>

            <div class="row wrap col-md-12 col-lg-10 col-xl-9" :lazy="lazy" v-if="is_Manage_Product_Active"
                v-model="is_Manage_Product_Active" transition="fade-transition"
                style="padding-top: 55px; margin: 0 auto; padding: 75px 90px; font-family: 'Kanit', sans-serif;">
                <v-card tile style="width: 100%; margin-bottom: 25px; padding: 24px;">
                    <div class="row">
                        <div class="col-sm-4 d-flex" style="padding-top: 5px; padding-bottom: 0;">
                            <p style="font-size: 24px; font-weight: 500; margin-bottom: 0;">จัดการสินค้า</p>
                        </div>
                        <div class="col-sm-8 d-flex justify-end" style="padding-top: 0; padding-bottom: 8px;">
                            <v-tabs right light v-model="tab">
                                <v-tabs-slider color="#1d8649"></v-tabs-slider>
                                <v-tab class="tabs" style="font-size: 18px; letter-spacing: -0.5px; ">รายการสินค้า
                                </v-tab>

                            </v-tabs>
                        </div>
                        <v-tabs-items v-model="tab" class="tabs-item" style="width: 100%;">
                            <v-tab-item :transition="false" :reverse-transition="false">
                                <div class="row" style="padding-left: 13px;">
                                    <div class="col-sm-12 col-md-5" style="padding-top: 0;">
                                        <v-text-field v-model="search" prepend-inner-icon="mdi-magnify"
                                            placeholder="ชื่อสินค้า ชนิด" single-line hide-details outlined dense
                                            color="none" style="padding-top: 0; margin-top: 0; width: 100%;">
                                        </v-text-field>
                                    </div>
                                    <div class="col-sm-12 col-md-7 d-flex justify-end" style="padding-top: 0;">





                                        <v-dialog v-model="dialog" max-width="98vw" max-height="95vh">
                                            <template v-slot:activator="{ on, attrs }">
                                                <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on"
                                                    style="font-size: 18px; height: 40px; width: 130px; background-color: #1d8649 !important;">
                                                    <i class="fa fa-plus" style="font-size: 20px; margin-right: 5px;"
                                                        saria-hidden="true"></i>สร้างสินค้า
                                                </v-btn>
                                            </template>
                                            <v-card style="font-family: 'Kanit', sans-serif; padding: 15px;">
                                                <v-card-title>
                                                    <p style="font-size: 25px;">สร้างสินค้า</p>
                                                </v-card-title>

                                                <v-card-text class="add-item" style=" color: black;">
                                                    <div class="row" style="border-top: 1.5px solid rgba(0, 0, 0, .1);">
                                                        <div class="col-md-2 col-sm-3">
                                                            <p style="font-size: 18px;">รายละเอียดสินค้า</p>
                                                        </div>
                                                        <div class="col-md-10 col-sm-9"
                                                            style="padding: 10px 0px 0px 14vw;">


                                                            <div class="row" style="padding-top: 30px;">
                                                                <div class="col-md-8 col-sm-9 col-xs-12"
                                                                    style="padding: 0;">
                                                                    <p
                                                                        style="font-size: 15px; width: 100%; margin-bottom: 5px; padding-left: 20px; color: #666;">
                                                                        ชื่อสินค้า</p>
                                                                    <v-text-field placeholder="ชื่อสินค้า" single-line
                                                                        hide-details outlined color="none"
                                                                        style="padding-top: 0; margin-top: 0; width: 100%; background-color: #fafafa; font-size: 18px;"
                                                                        v-model="item_name">
                                                                    </v-text-field>
                                                                </div>
                                                            </div>

                                                            <div class="row" style="padding-top: 30px;">
                                                                <div class="col-md-8 col-sm-9 col-xs-12"
                                                                    style="padding: 0;">
                                                                    <p
                                                                        style="font-size: 15px; width: 100%; margin-bottom: 5px; padding-left: 20px; color: #666;">
                                                                        ชนิดของสินค้า</p>
                                                                    <v-text-field placeholder="ชนิดของสินค้า"
                                                                        single-line hide-details outlined color="none"
                                                                        style="padding-top: 0; margin-top: 0; width: 100%; background-color: #fafafa; font-size: 18px;"
                                                                        v-model="item_type">
                                                                    </v-text-field>
                                                                </div>
                                                            </div>

                                                            <div class="row" style="padding-top: 20px;">
                                                                <div class="col-md-3 col-sm-5 col-xs-12"
                                                                    style="padding: 0; padding-right: 25px;">
                                                                    <p
                                                                        style="font-size: 15px; width: 100%; margin-bottom: 5px; padding-left: 20px; color: #666;">
                                                                        ราคา</p>
                                                                    <v-text-field type="number" placeholder="0.00"
                                                                        single-line hide-details outlined color="none"
                                                                        style="padding-top: 0; margin-top: 0; width: 100%; background-color: #fafafa; font-size: 18px;"
                                                                        v-model="item_price">
                                                                    </v-text-field>
                                                                </div>
                                                                <div class="col-md-3 col-sm-5 col-xs-12"
                                                                    style="padding: 0;">
                                                                    <p
                                                                        style="font-size: 15px; width: 100%; margin-bottom: 5px; padding-left: 20px; color: #666;">
                                                                        จำนวน</p>
                                                                    <v-text-field type="number" placeholder="0"
                                                                        single-line hide-details outlined color="none"
                                                                        style="padding-top: 0; margin-top: 0; width: 100%; background-color: #fafafa; font-size: 18px;"
                                                                        v-model="item_quantities">
                                                                    </v-text-field>
                                                                </div>

                                                            </div>

                                                            <div class="row" style="padding-top: 20px;">
                                                                <div class="col-md-3 col-sm-5 col-xs-12"
                                                                    style="padding: 0; padding-right: 25px;">
                                                                    <p
                                                                        style="font-size: 15px; width: 100%; margin-bottom: 5px; padding-left: 20px; color: #666;">
                                                                        น้ำหนัก</p>
                                                                    <v-text-field type="number" placeholder="0.00"
                                                                        single-line hide-details outlined color="none"
                                                                        style="padding-top: 0; margin-top: 0; width: 100%; background-color: #fafafa; font-size: 18px;"
                                                                        v-model="gram_weight" @keyup="convertWeight">
                                                                    </v-text-field>
                                                                    <p
                                                                        style="font-size: 15px; width: 100%; margin-top: 5px; padding-right: 20px; color: #666; text-align: right;">
                                                                        กรัม</p>

                                                                </div>
                                                                <div class="col-md-3 col-sm-5 col-xs-12"
                                                                    style="padding: 0; position: relative;">
                                                                    <span
                                                                        style="position: absolute; margin: 37.5px -18px; font-size: 26px;">=</span>
                                                                    <p
                                                                        style="font-size: 15px; width: 100%; margin-bottom: 5px; padding-left: 20px; color: #666;">
                                                                        น้ำหนัก</p>
                                                                    <v-text-field type="number" placeholder="0.00"
                                                                        single-line hide-details outlined color="none"
                                                                        style="padding-top: 0; margin-top: 0; width: 100%; background-color: #fafafa; font-size: 18px;"
                                                                        v-model="item_weight" disabled>
                                                                    </v-text-field>
                                                                    <p
                                                                        style="font-size: 15px; width: 100%; margin-top: 5px; padding-right: 20px; color: #666; text-align: right;">
                                                                        กิโลกรัม</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </v-card-text>

                                                <v-card-actions class="flex justify-center">
                                                    <v-btn outlined
                                                        style="width: 200px; height: 45px ; padding-top: 15px; font-size: 18px;"
                                                        @click="close">
                                                        <p>ยกเลิก</p>
                                                    </v-btn>
                                                    <v-btn outlined
                                                        style="width: 200px; height: 45px ; padding-top: 15px; font-size: 18px; background-color: #1d8649; color: white;"
                                                        @click="addItemToSQL">
                                                        <p>บันทึก</p>
                                                    </v-btn>
                                                </v-card-actions>
                                            </v-card>
                                        </v-dialog>

                                        <v-menu offset-y>
                                            <template v-slot:activator="{ on, attrs }">
                                                <v-btn elevation="2" outlined
                                                    style="padding: 8px 8px; font-size: 18px; padding-top: 25px; height: 40px; width: 80px; margin-left: 20px; margin-right: 20px;"
                                                    v-bind="attrs" v-on="on">
                                                    <p>จัดการ<i class="fa fa-angle-down" style="font-size: 25px; "
                                                            saria-hidden="true"></i></p>
                                                </v-btn>
                                            </template>

                                            <v-list class="border-green">

                                                <v-list-item :key="index" style="padding: 0 0;">
                                                    <v-btn class="v-btn--flat v-btn--text theme--light bars-button"
                                                        v-bind="attrs" v-on="on" style="height: 48px;">
                                                        <p style="font-size: 18px;">
                                                            Delete
                                                        </p>
                                                    </v-btn>
                                                </v-list-item>
                                            </v-list>
                                        </v-menu>

                                    </div>
                                </div>
                                <v-data-table v-model="selected" :headers="headers" :items="item"
                                    :single-select="singleSelect" item-key="name" :search="search" :page.sync="page"
                                    show-select :items-per-page="`${select.itemsPerPage}`" text-left hide-default-footer
                                    @page-count="pageCount = $event">
                                </v-data-table>
                                <div class="text-center pt-2">
                                    <v-pagination circle color="green darken-3" style="box-shadow: none" v-model="page"
                                        :length="pageCount"></v-pagination>
                                    <div style="float: right; position: absolute; right: 0px; bottom: -25px;">
                                        <p
                                            style="float: left; position: absolute; right: 70px; white-space: nowrap; top: 10px;">
                                            จำนวนต่อหน้า</p>
                                        <v-select v-model="select" :items="items" item-text="itemsPerPage"
                                            label="Select" return-object single-line text-left
                                            style="width: 60px; float: left; padding-top: 0;"></v-select>
                                    </div>
                                </div>
                            </v-tab-item>
                            <v-tab-item :transition="false" :reverse-transition="false">
                                eiei2
                            </v-tab-item>
                        </v-tabs-items>
                    </div>
                </v-card>
            </div>

            <div :lazy="lazy" v-if="is_Orders_Active" v-model="is_Orders_Active" transition="fade-transition"
                style=" padding: 50px 30px; font-family: 'Sarabun', sans-serif;">

                <div class="row" style="height: 50px;">
                    <div class="col-md-7 col-sm-8 col-xs-12">
                        <v-text-field v-model="search" prepend-inner-icon="mdi-magnify"
                            placeholder="เลขออเดอร์, เลขแทร๊กกิ้ง, ชื่อ, เบอร์โทร, สถานะการจ่ายเงิน, ปริ้นท์ (พิมพ์ print, noprint, reprint), ผู้จัดส่ง"
                            single-line hide-details outlined dense
                            style="padding-top: 0; margin-top: 0; width: 100%; background-color: white;"></v-text-field>
                    </div>
                </div>

                <div class="row"
                    style="width: 100%; padding-left: 13px; margin-right: 0px; margin-top: 15px; padding-top: 0px;">
                    <v-card
                        style="width: 100%; padding: 15px; box-shadow: 0 0 10px rgba(0,0,0,.1); border-radius: 5px; padding-top: 10px; padding-bottom: 5px;">
                        <div class="row">
                            <div class="d-flex col-md-9 col-sm12" style="padding: 5px;">
                                <v-btn style="overflow: hidden; padding-top: 0; box-shadow: none !important;
                                    font-size: 16px !important;
                                    padding-top: 15px !important;
                                    background-color: #1d8649 !important;
                                    color: white !important;
                                    border-radius: 6px !important;
                                    height: 65px; margin-right: 10px;" @click="to_Create_Orders()">
                                    <i class="fa fa-plus-circle"
                                        style="margin-top: -15px; font-size: 22px; margin-right: 5px;"
                                        aria-hidden="true"></i>
                                    <p>สร้างออเดอร์</p>
                                </v-btn>
                                <div class="d-inline-block">
                                    <v-btn style="overflow: hidden; padding-top: 0; box-shadow: none !important;
                                    font-size: 16px !important;
                                    padding-top: 15px !important;
                                    background-color: #525152 !important;
                                    color: white !important;
                                    border-radius: 6px !important;
                                    margin-right: 5px;
                                    margin-bottom: 8px;">
                                        <p>ทั้งหมด<span
                                                style="background-color: #fff; color: #424143; border-radius: 10px; padding: 0 .4rem; margin-left: 5px;">0</span>
                                        </p>
                                    </v-btn>

                                    <v-menu offset-y>
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-btn elevation="2" outlined
                                                style="margin-bottom: 8px; padding: 10px 15px; font-size: 16px; padding-top: 25px; margin-right: 5px; border-color: #424143 !important;"
                                                v-bind="attrs" v-on="on">
                                                <p>รอดำเนินการ<span
                                                        style="background-color: #424143; color: #fff; border-radius: 10px; padding: 0 .4rem; margin-left: 5px; margin-right: 2.5px">0</span><i
                                                        class="fa fa-angle-down" style="font-size: 25px; "
                                                        saria-hidden="true"></i></p>
                                            </v-btn>
                                        </template>

                                        <v-list>
                                            <v-list-item style="padding: 0 0;">
                                                <v-btn class="v-btn--flat v-btn--text theme--light bars-button"
                                                    v-bind="attrs" v-on="on" style="height: 48px; width: 100%;">
                                                    <p style="font-size: 16px; font-family: 'Sarabun', sans-serif;">
                                                        ทั้งหมด (0)
                                                    </p>
                                                </v-btn>
                                            </v-list-item>
                                            <v-list-item style="padding: 0 0;">
                                                <v-btn class="v-btn--flat v-btn--text theme--light bars-button"
                                                    v-bind="attrs" v-on="on" style="height: 48px; width: 100%;">
                                                    <p style="font-size: 16px; font-family: 'Sarabun', sans-serif;">
                                                        เก็บเงินปลายทาง (0)
                                                    </p>
                                                </v-btn>
                                            </v-list-item>
                                            <v-list-item style="padding: 0 0;">
                                                <v-btn class="v-btn--flat v-btn--text theme--light bars-button"
                                                    v-bind="attrs" v-on="on" style="height: 48px; width: 100%;">
                                                    <p style="font-size: 16px; font-family: 'Sarabun', sans-serif;">
                                                        รอโอนเงิน (0)
                                                    </p>
                                                </v-btn>
                                            </v-list-item>
                                            <v-list-item style="padding: 0 0;">
                                                <v-btn class="v-btn--flat v-btn--text theme--light bars-button"
                                                    v-bind="attrs" v-on="on" style="height: 48px; width: 100%;">
                                                    <p style="font-size: 16px; font-family: 'Sarabun', sans-serif;">
                                                        โอนเงินแล้ว (0)
                                                    </p>
                                                </v-btn>
                                            </v-list-item>
                                            <v-list-item style="padding: 0 0;">
                                                <v-btn class="v-btn--flat v-btn--text theme--light bars-button"
                                                    v-bind="attrs" v-on="on" style="height: 48px; width: 100%;">
                                                    <p style="font-size: 16px; font-family: 'Sarabun', sans-serif;">
                                                        เคลม (0)
                                                    </p>
                                                </v-btn>
                                            </v-list-item>
                                        </v-list>
                                    </v-menu>

                                    <v-btn elevation="2" outlined
                                        style="margin-bottom: 8px; padding: 10px 15px; font-size: 16px; padding-top: 25px; margin-right: 5px; border-color: #424143 !important;"
                                        v-bind="attrs" v-on="on">
                                        <p>เตรียมตัวส่ง<span
                                                style="background-color: #424143; color: #fff; border-radius: 10px; padding: 0 .4rem; margin-left: 5px; margin-right: 2.5px">0</span>
                                        </p>
                                    </v-btn>

                                    <v-btn elevation="2" outlined
                                        style="margin-bottom: 8px; padding: 10px 15px; font-size: 16px; padding-top: 25px; margin-right: 5px; border-color: #424143 !important;"
                                        v-bind="attrs" v-on="on">
                                        <p>พร้อมจัดส่ง<span
                                                style="background-color: #424143; color: #fff; border-radius: 10px; padding: 0 .4rem; margin-left: 5px; margin-right: 2.5px">0</span>
                                        </p>
                                    </v-btn>

                                    <v-menu offset-y>
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-btn elevation="2" outlined
                                                style="margin-bottom: 8px; padding: 10px 15px; font-size: 16px; padding-top: 25px; margin-right: 5px; border-color: #424143 !important;"
                                                v-bind="attrs" v-on="on">
                                                <p>กำลังจัดส่ง<span
                                                        style="background-color: #424143; color: #fff; border-radius: 10px; padding: 0 .4rem; margin-left: 5px; margin-right: 2.5px">0</span><i
                                                        class="fa fa-angle-down" style="font-size: 25px; "
                                                        saria-hidden="true"></i></p>
                                            </v-btn>
                                        </template>

                                        <v-list>
                                            <v-list-item style="padding: 0 0;">
                                                <v-btn class="v-btn--flat v-btn--text theme--light bars-button"
                                                    v-bind="attrs" v-on="on" style="height: 48px; width: 100%;">
                                                    <p style="font-size: 16px; font-family: 'Sarabun', sans-serif;">
                                                        ทั้งหมด (0)
                                                    </p>
                                                </v-btn>
                                            </v-list-item>
                                            <v-list-item style="padding: 0 0;">
                                                <v-btn class="v-btn--flat v-btn--text theme--light bars-button"
                                                    v-bind="attrs" v-on="on" style="height: 48px; width: 100%;">
                                                    <p style="font-size: 16px; font-family: 'Sarabun', sans-serif;">
                                                        ขนส่งรับสินค้าเข้าคลังแล้ว (0)
                                                    </p>
                                                </v-btn>
                                            </v-list-item>
                                            <v-list-item style="padding: 0 0;">
                                                <v-btn class="v-btn--flat v-btn--text theme--light bars-button"
                                                    v-bind="attrs" v-on="on" style="height: 48px; width: 100%;">
                                                    <p style="font-size: 16px; font-family: 'Sarabun', sans-serif;">
                                                        พัสดุกำลังนำส่ง (0)
                                                    </p>
                                                </v-btn>
                                            </v-list-item>
                                            <v-list-item style="padding: 0 0;">
                                                <v-btn class="v-btn--flat v-btn--text theme--light bars-button"
                                                    v-bind="attrs" v-on="on" style="height: 48px; width: 100%;">
                                                    <p style="font-size: 16px; font-family: 'Sarabun', sans-serif;">
                                                        ส่งไม่สำเร็จ (0)
                                                    </p>
                                                </v-btn>
                                            </v-list-item>
                                            <v-list-item style="padding: 0 0;">
                                                <v-btn class="v-btn--flat v-btn--text theme--light bars-button"
                                                    v-bind="attrs" v-on="on" style="height: 48px; width: 100%;">
                                                    <p style="font-size: 16px; font-family: 'Sarabun', sans-serif;">
                                                        ไม่ทราบสถานะ (0)
                                                    </p>
                                                </v-btn>
                                            </v-list-item>
                                        </v-list>
                                    </v-menu>

                                    <v-menu offset-y>
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-btn elevation="2" outlined
                                                style="margin-bottom: 8px; padding: 10px 15px; font-size: 16px; padding-top: 25px; margin-right: 5px; border-color: #424143 !important;"
                                                v-bind="attrs" v-on="on">
                                                <p>สำเร็จ<span
                                                        style="background-color: #424143; color: #fff; border-radius: 10px; padding: 0 .4rem; margin-left: 5px; margin-right: 2.5px">0</span><i
                                                        class="fa fa-angle-down" style="font-size: 25px; "
                                                        saria-hidden="true"></i></p>
                                            </v-btn>
                                        </template>

                                        <v-list>
                                            <v-list-item style="padding: 0 0;">
                                                <v-btn class="v-btn--flat v-btn--text theme--light bars-button"
                                                    v-bind="attrs" v-on="on" style="height: 48px; width: 100%;">
                                                    <p style="font-size: 16px; font-family: 'Sarabun', sans-serif;">
                                                        ทั้งหมด (0)
                                                    </p>
                                                </v-btn>
                                            </v-list-item>
                                            <v-list-item style="padding: 0 0;">
                                                <v-btn class="v-btn--flat v-btn--text theme--light bars-button"
                                                    v-bind="attrs" v-on="on" style="height: 48px; width: 100%;">
                                                    <p style="font-size: 16px; font-family: 'Sarabun', sans-serif;">
                                                        ส่งสำเร็จแล้ว (0)
                                                    </p>
                                                </v-btn>
                                            </v-list-item>
                                            <v-list-item style="padding: 0 0;">
                                                <v-btn class="v-btn--flat v-btn--text theme--light bars-button"
                                                    v-bind="attrs" v-on="on" style="height: 48px; width: 100%;">
                                                    <p style="font-size: 16px; font-family: 'Sarabun', sans-serif;">
                                                        ถูกตีกลับ (0)
                                                    </p>
                                                </v-btn>
                                            </v-list-item>
                                            <v-list-item style="padding: 0 0;">
                                                <v-btn class="v-btn--flat v-btn--text theme--light bars-button"
                                                    v-bind="attrs" v-on="on" style="height: 48px; width: 100%;">
                                                    <p style="font-size: 16px; font-family: 'Sarabun', sans-serif;">
                                                        ได้รับเงินแล้ว (0)
                                                    </p>
                                                </v-btn>
                                            </v-list-item>
                                        </v-list>
                                    </v-menu>

                                    <v-dialog v-model="description" max-width="500px" max-height="95vh">
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-btn icon v-bind="attrs" v-on="on"
                                                style="margin-bottom: 8px; margin-right: 10px;">
                                                <span
                                                    style="width: 22.5px; height: 22.5px;background-color: #424143; color: #fff; border-radius: 10px; padding: 0 .4rem; font-size: 15px;">i</span>
                                            </v-btn>
                                        </template>
                                        <v-card style="font-family: 'Sarabun', sans-serif;">
                                            <v-card-title style="background-color: #08a7a3; padding: 10px 10px;">
                                                <p style="font-size: 16px; margin-bottom: 0px; color: white;">
                                                    <span
                                                        style="background-color: white; color:#08a7a3; border-radius: 10px; padding: 0 .6rem; margin-right: 2.5px">i</span>
                                                    คำอธิบาย</p>
                                            </v-card-title>

                                            <v-card-text class="add-item"
                                                style=" color: black; padding: 15px 15px; font-size: 18px;">
                                                <p style="margin-bottom: 5px; color: #08a7a3;"><b>All (ทั้งหมด)</b></p>
                                                <p style="margin-bottom: 25px;">
                                                    จำนวนออเดอร์รวมทั้งหมดในช่วงเวลาที่ทำการค้นหาไว้(ค่าเริ่มต้นคือ 14
                                                    วัน ย้อนหลังจากวันที่ปัจจุบัน)</p>

                                                <p style="margin-bottom: 5px; color: #08a7a3;"><b>Pending
                                                        (รอดำเนินการ)</b></p>
                                                <p style="margin-bottom: 25px;">สถานะของออเดอร์ที่สร้างเสร็จแล้ว
                                                    และรอการจัดการต่อ</p>

                                                <p style="margin-bottom: 5px; color: #08a7a3;"><b>Prepare to ship
                                                        (เตรียมตัวส่ง)</b></p>
                                                <p style="margin-bottom: 25px;">สถานะการเตรียมส่งออเดอร์ ใช้ในการแยกว่า
                                                    ออเดอร์ไหนได้มีการปริ้นไปปะหน้า (Shiping label)เพื่อเตรียมตัวส่งแล้ว
                                                </p>

                                                <p style="margin-bottom: 5px; color: #08a7a3;"><b>Ready to ship
                                                        (พร้อมจัดส่ง)</b></p>
                                                <p style="margin-bottom: 25px;">สถานะที่บอกว่า ออเดอร์พร้อมจัดส่งแล้ว
                                                    สถานะนี้ควรจะเป็น 0 ในทุกๆ วันหลังขนส่ง มารับ
                                                    สถานะนี้ใช้เพื่อตรวจสอบว่าสินค้ามีการสูญหาย หลังจากขนส่งรับไปหรือไม่
                                                </p>

                                                <p style="margin-bottom: 25px; color: #08a7a3;"><b>In Transit
                                                        (อยู่ในระหว่างการจัดส่ง) เป็นสถานะที่บอกว่าสินค้ากำลังถูกจัดส่ง
                                                        โดยสามารถแยกเป็น</b></p>

                                                <p style="margin-bottom: 5px;"><b>Shipped (ส่งแล้ว)</b></p>
                                                <p style="margin-bottom: 25px;">เป็นสถานะที่บอกว่าขนส่งรับเข้าคลังไปแล้ว
                                                    มั่นใจได้เลยว่าสินค้าถึงมือขนส่งแล้วแน่นอน และสามารถใช้ตรวจสอบได้ว่า
                                                    สินค้าที่ส่งไปแล้วที่ยังค้างอยู่ที่คลังสินค้าของขนส่งมี
                                                    รายการไหนบ้าง</p>

                                                <p style="margin-bottom: 5px;"><b>Out for delivery
                                                        (ของถูกส่งออกไปแล้ว)</b></p>
                                                <p style="margin-bottom: 25px;">พัสดุกำลังจัดส่ง</p>

                                                <p style="margin-bottom: 5px;"><b>Fail to Delivery (ส่งไม่สำเร็จ)
                                                        เนื่องมาจากหลายสาเหตุ ดังต่อไปนี้</b></p>
                                                <p style="margin-bottom: 5px;">• Insufficient address
                                                    (ที่อยู่ไม่ถูกต้อง): พัสดุที่มีที่อยู่ไม่ชัดเจน หากเป็นร้านที่มี
                                                    การเก็บเงินปลายทาง ควรจะจัดการแก้ปัญหาโดย</p>
                                                <p style="margin-bottom: 5px;">• Delivery Reschedule
                                                    (ผู้รับเลื่อนวันรับสินค้า): ผู้รับเลื่อนวันรับสินค้าไปก่อน
                                                    เมื่อมีผู้รับสินค้าหรือมีการปฏิเสธจะดำเนินการไปยังสถานะถัดไป</p>
                                                <p style="margin-bottom: 25px;">• Delivery Refused
                                                    (ผู้รับปฏิเสธการรับสินค้า): สินค้าจะถูกตีกลับ (return) ในขั้นถัดไป
                                                </p>

                                                <p style="margin-bottom: 25px; color: #08a7a3;"><b>Complete (สำเร็จ)
                                                        สถานะที่บอกว่า การจัดส่งสำเร็จแล้ว</b></p>

                                                <p style="margin-bottom: 5px;"><b>Delivered (ส่งแล้ว)</b></p>
                                                <p style="margin-bottom: 25px;">จัดส่งสำเร็จแล้ว</p>

                                                <p style="margin-bottom: 5px;"><b>COD Remitted (ได้รับเงินแล้ว)</b></p>
                                                <p style="margin-bottom: 25px;">ยอดเก็บเงินโอนเข้าบัญชีร้านค้าแล้ว</p>

                                                <p style="margin-bottom: 5px;"><b>Return (ถูกตีกลับ)</b></p>
                                                <p style="margin-bottom: 25px;">สินค้าโดนตีกลับเนื่องจาก
                                                    ผู้รับปฏิเสธการรับสินค้า หรือ จัดส่งไม่สามารถติดต่อผู้รับ
                                                    ได้เนื่องจากที่อยู่ผิดหรือเบอร์โทรติดต่อไปยังผู้รับผิด</p>

                                            </v-card-text>

                                            <v-card-actions class="flex justify-center"
                                                style="border-top   : 1px solid rgba(0, 0, 0, .1);">
                                                <v-btn outlined
                                                    style="width: 90px; height: 38px ; padding-top: 15px; font-size: 15px; background-color: #2bb43e; color: white;"
                                                    @click="close">
                                                    <p>ปิด</p>
                                                </v-btn>
                                            </v-card-actions>
                                        </v-card>
                                    </v-dialog>

                                    <v-menu>
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-btn elevation="2" outlined
                                                style="margin-bottom: 8px; padding: 10px 15px; font-size: 16px; padding-top: 25px; margin-right: 5px; background-color: #aac27f; color: white; border-radius: 5px;"
                                                v-bind="attrs" v-on="on">
                                                <p>เลือกออเดอร์</p>
                                            </v-btn>
                                        </template>

                                        <v-list>
                                            <v-list-item style="padding: 0 0;">
                                                <v-btn class="v-btn--flat v-btn--text theme--light bars-button"
                                                    v-bind="attrs" v-on="on" style="height: 48px; width: 100%;">
                                                    <p style="font-size: 16px; font-family: 'Sarabun', sans-serif;">
                                                        จากไฟล์ Excel
                                                    </p>
                                                </v-btn>
                                            </v-list-item>
                                            <v-list-item style="padding: 0 0;">
                                                <v-btn class="v-btn--flat v-btn--text theme--light bars-button"
                                                    v-bind="attrs" v-on="on" style="height: 48px; width: 100%;">
                                                    <p
                                                        style="font-size: 16px; font-family: 'Sarabun', sans-serif; color: #6aaee2; text-decoration: underline;">
                                                        ตัวอย่างไฟล์ Excel
                                                    </p>
                                                </v-btn>
                                            </v-list-item>
                                        </v-list>
                                    </v-menu>

                                    <v-btn elevation="2" outlined
                                        style="margin-bottom: 8px; padding: 10px 15px; font-size: 16px; padding-top: 25px; margin-right: 10px; background-color: red; color: white; border-radius: 5px;"
                                        v-bind="attrs" v-on="on">
                                        <p>ที่ต้องพิมใหม่ (1)</p>
                                    </v-btn>
                                </div>
                            </div>
                            <div class="d-flex col-md-3 col-sm12 justify-end" style="padding: 5px;">
                                <v-menu offset-y>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn elevation="2" outlined
                                            style="margin-bottom: 8px; padding: 10px 15px; font-size: 16px; padding-top: 25px; margin-right: 5px; background-color: rgb(106, 174, 184); color: white;"
                                            v-bind="attrs" v-on="on">
                                            <p><i class="fa fa-download"
                                                    style="font-size: 20px; margin-right: 5px;"></i>ดาวโหลดไฟล์<i
                                                    class="fa fa-angle-down" style="font-size: 25px; margin-left: 5px;"
                                                    saria-hidden="true"></i></p>
                                        </v-btn>
                                    </template>

                                    <v-list>
                                        <v-list-item style="padding: 0 0;">
                                            <v-btn class="v-btn--flat v-btn--text theme--light bars-button"
                                                v-bind="attrs" v-on="on" style="height: 48px; width: 100%;">
                                                <p style="font-size: 16px; font-family: 'Sarabun', sans-serif;">
                                                    ดาวโหลดไฟล์จากวันที่
                                                </p>
                                            </v-btn>
                                        </v-list-item>
                                        <v-list-item style="padding: 0 0;">
                                            <v-btn class="v-btn--flat v-btn--text theme--light bars-button"
                                                v-bind="attrs" v-on="on" style="height: 48px; width: 100%;">
                                                <p style="font-size: 16px; font-family: 'Sarabun', sans-serif;">
                                                    ดาวโหลดไฟล์จากที่เลือก
                                                </p>
                                            </v-btn>
                                        </v-list-item>
                                    </v-list>
                                </v-menu>

                                <v-btn elevation="2" outlined
                                    style="margin-bottom: 8px; padding: 10px 15px; font-size: 16px; padding-top: 25px; margin-right: 5px; background-color: #9e9e9e; color: white;"
                                    v-bind="attrs" v-on="on">
                                    <p><svg style="width:15px;height:15px;margin-right: 5px;" viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M18,3H6V7H18M19,12A1,1 0 0,1 18,11A1,1 0 0,1 19,10A1,1 0 0,1 20,11A1,1 0 0,1 19,12M16,19H8V14H16M19,8H5A3,3 0 0,0 2,11V17H6V21H18V17H22V11A3,3 0 0,0 19,8Z" />
                                        </svg>พิมพ์<i class="fa fa-angle-down"
                                            style="font-size: 25px;  margin-left: 5px;" saria-hidden="true"></i></p>
                                </v-btn>
                            </div>
                        </div>
                    </v-card>
                </div>

                <div class="row" style="width: 100%; margin-right: 0px; margin-top: 15px; padding-left: 12px;">
                    <v-card
                        style="width: 100%; padding: 0px; box-shadow: 0 0 10px rgba(0,0,0,.1); border-radius: 5px; padding-bottom: 10px;">
                        <v-data-table class="black-table" v-model="selected" :headers="orders_headers"
                            :items="orders_item" :single-select="singleSelect" item-key="name" :search="search"
                            :page.sync="page" show-select :items-per-page="`${select.itemsPerPage}`" text-left
                            hide-default-footer @page-count="pageCount = $event">
                        </v-data-table>
                        <div class="text-center pt-2">
                            <v-pagination circle color="black" style="box-shadow: none" v-model="page"
                                :length="pageCount"></v-pagination>
                            <div style="float: right; position: absolute; right: 5px; bottom: -15px;">
                                <p
                                    style="float: left; position: absolute; right: 70px; white-space: nowrap; top: 10px;">
                                    จำนวนต่อหน้า</p>
                                <v-select v-model="select" :items="items" item-text="itemsPerPage" label="Select"
                                    return-object single-line text-left
                                    style="width: 60px; float: left; padding-top: 0;"></v-select>
                            </div>
                        </div>
                    </v-card>
                </div>

            </div>

            <div class="row wrap col-md-12 col-lg-10 col-xl-9" :lazy="lazy" v-if="is_Create_Orders_Active"
                v-model="is_Create_Orders_Active" transition="fade-transition"
                style="margin: 0 auto; padding: 70px 90px; font-family: 'Sarabun', sans-serif;">
                <h2 style="margin-bottom: 15px;">สร้างรายการสั่งซื้อ</h2>
                <v-card
                    style="width: 100%; box-shadow: none; border: #ccc 1px solid; padding: 24px; background-color: #f8f8f8; padding-bottom: 0;">
                    <p style="margin-bottom: 0%;">ช่องทางการติดต่อ</p>
                    <div class="row" style="padding-left: 10px;">

                        <div class="col-xs-3 col-md-2 col-lg-1">
                            <div class="selectedBankImageIcon d-flex justify-center">
                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4i
                                xAAAABHNCSVQICAgIfAhkiAAABPNJREFUaIHdmX9M1GUcx1/PcWog4mSSSgUjjbmJNKwhujox
                                58rMlpllzGWZa7q2fqyVU+GfBMu1mltsVqtGokWjUpnTipU/Wv4IcXLiAY1EMUV+BB4gO064p
                                z+eCE6O4/l+746jXtv3n+f7+TzP533f57vn/fmeYCi2yscQzEUyB5iDYOqQsaGlATiD5AzwGzn
                                igK8gMWhkq0xCsBuYH9r6THMcyWpyRN3AQYtXSJ5cB9gZvSJA1WYnT64dONj/RHLlemDnCBcVK
                                BvIFh9Bn5B35N30YgfGh7MqE9wgglQ2iQsWpBT0Ush/TwTAeHrYhZRCkCszgBPhrihA5lmAjHB
                                XEQQyLEBmuKsIAhlWgvhEIgRkJsLq2ZASB5OjYHIk9Hig+i91nb0GRy6BvQlksBaGDEGuDHi+u
                                Ch4ax6svRdiI/Vy2lzwXTW8dwJqWgOtAAISEmWF7YvgpTQYG2FuDokS9PL30HjDbCUBCJk1GfY
                                /DdMnmV98IPVOWFIEjhZz+ZbhQwazMBHK1wVPBEDCRDj1AtgSzOUbFnLPJNi3EsaZ3Er+iB4Lh
                                1bBfSZ8tiEhUVY49CzEjDO+kPYaY+Cn1ZAcayzPkJAtDwR3Ow3FxHGQ/4ixHG0hd8XAGyPoARY
                                nwdIZ+vHaQl5PD8174Y835+nHagvJSjFeiLNbP9YjlQMYiC0Bpmp6ci0hc+NhikGTf7AWkvKhv
                                GH42EN/QIEdrLdUI4AnZ+qtpyUkJU5vsj6O1cPyYmVDFu1RvsoXlc2QWQh7q5W98cUszbW1hNw
                                ZozcZwMkrsOQrcP+zTZzdsLAQqgac2JfbYU0JpH6iDsKPl/pZe4LeuladoGnRepPZm2DxHujq8
                                R5vdcGCQvgxC752wI5T4OqFJ5KhYJmvTzn9xAdTSK+GG6tqUb98502wCng8GfbVQN/729wFaZ/
                                2xz86HYpXgMWfCqDDrVOh5tZq6fJ//6JT/eKtLlgxE6o3wLdPwWfLfMfbEmDvysEvty+utOtUq
                                PlEKhqHvne5HWy7lKU4uArun9Z/7/lUcLrgtdL+sYw7lJ/Stf1/dujFaQn5+aLqG27dBQ2dsP4
                                g5D+stpIvXk2Hpi7Y9qsyg6VZyk/p8sMFvTgtIde7oewqpMd7j//eCiXPqBbXH3mZcFsEvJKuH
                                K4ubS44ekkvVvtk31k+eGxBwvAi+sh5UJlBI3xh1+/rtYV8Wel9FoSaDje8/Yt+vLYQtweeK1G
                                eaCTIOaK2li6G+pHTDbD9uNGSjFNaBx+WGcsx3OrmHIXPK4xm6VPVonyaZ/hQLwwL6ZXw4gF4N
                                wRPpuwqPLQbbtw0nmvqKwrApsN6Fl2X90/C/AK4ZvLbltY5MhSunuFj/NErodihDstzzYHNFZA
                                QX9S2qSZsgp+Dr6oFihxQaIc6Z3DWDZqQy+2w+TDsqVRWZvbtMCNW9RORY5TxbO6C2lY4H4LzK
                                GAhHW714n9wUvUYoE7jiiZ1jRRWoBGYYia5yAHLv1G/dJhptABnzWbnnx4VIgDOWpDmhYwa5P9
                                KiIcSJOfCXYtpJOeJZr/qJvJkCh7KERhoe0YBEjcRpLFZOJRF2SIqEWwMc1nGEWxks3DAQK+VL
                                XYgWY+kM2yF6SK5joc1ZIsdfUODG9VcmQgUMHr/fz+CIIstwsuyDt1xb5PJSGxIbIANSAxxgb6
                                R1APH/r1yRI2vsL8Bp/Zw8agy6lUAAAAASUVORK5CYII=" style="width: 46px; height: 46px;">
                            </div>
                            <div class="d-flex justify-center"
                                style="width: 100%; font-size: 14px; margin-top: -2.5px;">Messenger</div>
                        </div>

                        <div class="col-xs-3 col-md-2 col-lg-1">
                            <div class="NonSelectedBankDiv d-flex justify-center">
                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ix
                                AAAABHNCSVQICAgIfAhkiAAAA0NJREFUaIHtmV1IU2EYx//PuxNW2yozXV2UVmIfmJFELi+kSNQi
                                qIsy0yCIIN2qiwq86EqCrrowqll0lflRCEUZpZYgEgkRIpaWFkpG6KaW+TFNc08XJc3c5tzH2Zns
                                d7U9e97//n+ew/uesxGckJZTtF8wJ4E5EUAiiFY66/UnDHSD0QjiRibxuqY074mjPvq/kHb42lqS
                                VCVESPa/zbnDjFf8a/JYTcWZTvu6sH+TftR0kiTRrNQQAECEZJJEc1pW0Ylp9akX6VmmXBIokt+a
                                57ANedX3DDeBv0FSs03rVOBmAqkDa21uMHhkEpTwoszQIQAmFeNusIUAAAKpJaAYYKK9OSY9MxoC
                                bcobiLBTstmgpxl7l7yEhUnYFKuDLlKLiHANhPhnaHBoDF1fv6G9wwLr6ITD9TYb9BKIdznYhf0OE
                                ZCUGIODGQmI37AKKpVw2X++4CFa23uciEEvgaGXO0fUCg0unk1H3Poon+gRWC8Rkc4nam6iUYfh6
                                qVDWLZkkQ9VKdr1PP1AvjHVxyH+IGuQjbE6bN+6xi/asgY5kL7Fb9qS35Qd4M402jt60dc/jM4v/
                                dPqlr5hl+tkC6KL1EKjDnPZc6WoFrUv2z3Sl+3SCl+62OXnLW3dHocAZAyinWUa7z+ZvdKXLQgJ
                                16fu2Jjj2w93kf0c8RehIEpj3gShjGwT+1LwxuVMrIuO8KUkvg9YkW2847InKCZi7huatScogv
                                RYBmftCYog5t75MpHe0ESUhTsT8flt/MdOC0asP2fUtZqFiFm93Ok6c+8QLE52J7Nl9on4PEjh
                                7TqH9R3bolFwYZ/Tdc/rP6D0wRuPvzcoLi13CAVRGqEgSiMURGnMnyDM7N3vMAqAmc2CiJoCbc
                                RbiKhJMBD0QRhoEoR5MBFQk1gwJB4D/DbQZjyFmVt+TIw+EpWVp6y2SZENxnigTc0ZxrgQqsyG
                                inOjAgBq7ue9YyA/0L7mCgP5z0pzWwG7c6S63FAI5lxmdv2PigJg8ACDj1eXGwqnatMOxKpy4y
                                0VcTwYjp+OlACjDkLaXF1mLLYvz3hCfFp2+jOA3XuOXI+ThEgBIYXAKQBFy2bWDga6iFHPzPUk
                                UX1ViaHNUd9vlg3+kpHX6eoAAAAASUVORK5CYII=" style="width: 46px; height: 46px;">
                            </div>
                            <div class="d-flex justify-center"
                                style="width: 100%; font-size: 14px; margin-top: -2.5px;">Facebook</div>
                        </div>

                        <div class="col-xs-3 col-md-2 col-lg-1">
                            <div class="NonSelectedBankDiv d-flex justify-center">
                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP
                                4ixAAAABHNCSVQICAgIfAhkiAAABstJREFUaIHVmntQlNcZh5/z7XIRgcWFgCUKSgIhtQ1FnII
                                4KGqblomDSZOmHe00lammMUmn6VSd2NRJE9uJ6fRubIyZYu9G7UySlpqYeolJBFSI1E60EsQLcl1
                                g2YUFdvf7Tv/gJu71WxaIzwz/vO97zvn9dmc57znfJ/CGRBTUskoRfFFCPpAuECleaycd2Q40AG
                                ek5HDlQioQyJurxM2B/BoKDIKXQeRMhUz9yDpV8p3qPKpujI4zUljDOuAVhDBOqTa9SOkGNpzMo
                                3wkNGqksIZ1CPH7aREWIpqQ66tyeRWGjRTUka+4+QAhDNMrTSdSqpqRJVU5VCsAws2uW84EgBAG
                                RWUngMg/y3KDJo5Ot6aJoCpyhaKorJ5uIRNFUSk1AkvDNWGEiCQ3tph7YpdgMiYSZ5hFvMGMhoZd
                                7cbm7sLq7uBs7wn+0/s+Kmq4ll5mFDB3ouK/ZP4GRabVLIpbSbQSE9S4Ps3GKdthjlv/zrHugxMy
                                JQRzxOJaNIHw2BgDcXvUHXz1ticpMT9CrMEUsgiAbnc7FZ3lHOj4LRZXs+7xEilFYa3w2O79YRB
                                G1qZspmz2NiJEpO5F/eFQ7bzUvIU3LLuRnl2IX3QZSY2cz4473iAj+jO6Reqhrvc9tjY+iNVtCXq
                                MEmzhpyLn8VLWu5NuAiAntohdmSdIMN4W9JigjKREzGVX1gmSI+aELE4v6dHZ7Mp8lzhDQlD1AY
                                0IBD+e/7cpNTFCenQ2W9OCa/8CGnk4+Xt8dmbhhEWFytKE+1k562sB6/z+2Gcq8fzjnhaixIywi
                                tOL1W2h9FwqKm6fNX6/kfuS1nk10afZOGLdj1MOeOT+21fJ//prAWh1XqHL3TYuP6A5OGY9SL/W
                                B0Bd3/vU9h4f/TtqPeAxZ4IxiWWzHvAnFb8HqK8kPeY1vrNpE2927uGFjNcpMpWOxs87TvPoxSU
                                UmUp5IeN1Hq8vxubuYs9dVcyLvhuAPS3b2Nf+C7bN+xORIopnGh/2mH9udiaZMz43LrbKXMbRbk
                                +TAY2YjEnMjcrymnNoNgAGNce4eK/aAwx96gB9qg2HZmfzpVL2Zn9IjBKLQx0b62IQALMxhbTou
                                wCIUeJIjcrwWHNR3EoEwudG6dPI7Mh0XyndXB9s4NnLa3gx402v+ULTfTyd9qrfOQzCiDliNp2u
                                Fq/5KTEyy5jMBz3/ZH/Hr73mT/ZU8Hh9MTD0jfwk4yCRIsqrJt1GjGG8f/hR+h/Y1LCKnU0/IDM
                                m1yPf5W6jq3fsn0LLYCPp0dkedd7MjeBTbZvzml69Pvn0zM+zIXU7v2t+mguOMx75xfElrEnZBA
                                x9I95MAHS6W32u4dNIq/NyQIGNAx9R23scALd0ITyvyUZZm7KZU/Z3qLGHdqru1/poGqj3mfdpx
                                OJqoWnwY+ZE3emRE8Pbz97W7ext3Q6AyZDI8/NfG84PGVJGtymBQPDcvH2s+ehuetROBApCDOUr
                                bYeotB0anf/AggZSI+ePW7PGfhQNTb8RgLe6/8y3Zz/rEb/XvJYO1/VxsawZuSyYWcDi+BKKEx4
                                E4KHkJ2gabBg9eCUYk/j5nf/iYMdOliU8gFMbIC9uBaoc27FjlDhMxkSPNY9Y9/uT6r9FSYpI5c
                                CCBr8/sqmgy93G/efm+D0O+21RLK5mylufD7swvbzcvDXgmT5g9/uX1hep7z8bNlF6OWV/h4rO8
                                oB1AY2ouHnq4y/T5rwaFmF6aHFeZltj4BYegjwhdrvbebJ+Ba3OKxMSpofzjtNsvLgUu2oNqj7o
                                M/t15yUeuZBLte3tkMUFy6GuP7LhYiHtrqagxwRtBKBXtfL9hhJ+2fRdHJpdt8BASCSvtDzD9iv
                                fQpP6Lux032uNYDIksvH2HdxrXkOkiA5linH0qj38sPEhztiPhDQ+ZCMjxCixFJlW8wXz11kYuz
                                zoK9Mbqe+vY0tDKW2u0Pu7CRu5EQWFrJhccmKLSIlIoyTxm8QbzH7HVHSW87Nrj+GSzgmtHdZnh
                                RoaFxw1XHDUAHB54Dxb0nZ7rXVodnZcfZR/d+8Ly9qT+tDz0sA5r/Fq29v89GoZFh+HJL1IpDQi
                                pQUhksIy400kR4x/YmFxtfCbpqcCNoB6EWAxSrgqYFKMjByQXNLJa+2/orz1udGLiXAiJdeMwHv
                                AwrDPDlTZ3sKh2Tnc9Ve63e2TscQIJ0TBhxQrUhybzFUmG03I5QKgsJbTIBZNt6BQkFLWVuaRpw
                                BoBp5A6uwJPglIqUojG2G416rKoRpYP62iQmP9sPaxpvFkHuVIWTb8wsonGyndSFnm9aWaEQrqy
                                FdUdt/SrzmN1d56L579H4TWeN8v9K+wAAAAAElFTkSuQmCC" style="width: 46px; height: 46px;">
                            </div>
                            <div class="d-flex justify-center"
                                style="width: 100%; font-size: 14px; margin-top: -2.5px;">Line</div>
                        </div>

                        <div class="col-xs-3 col-md-2 col-lg-1">
                            <div class="NonSelectedBankDiv d-flex justify-center">
                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixA
                                AAABHNCSVQICAgIfAhkiAAABHVJREFUaIHdmX9M1GUcx1/P9w6E44cEAgXVpRgbUi7cqhOYqMll5T
                                9qrs0QZmvL/rBprdxaWz/XD/ujtSxrsymYf9jcTFYjEYzAiUkRQ0AywYAuEhBQBIU77ukPAiXuiO/
                                zvePA13Z/fD+f557v+73nnh+f5wTesOevAfEwUi5ByCUgbvfa1r+0I2U1iGoEpynO+9ZTIzEhYi+Y
                                D/IrIN3fChU5CSKH4twLNwe1cU2y859FylpmrgmAdKSsxZ7/zM3BGyOSXbAFIXdPuywjSPE8x3I/h
                                1Ejqw4sQLhqEYQFVJheJP1I82JKnm7WQAo01/5ZZwJAEIZwFoAUglV7bWhaZaA1GcLtXqqByRZoHc
                                Yx2TQ0uTzQMgyjSZuGlLN/RCQ2DSHiA63DMAKr9v+tZgdmlS/FzQ1hkXXuhLjT5eZkQyfSsCz96D
                                Zi1gQnPlrNvYmRHvPbdlfx8TdnDQvTi+6fVoQlyKsJgLSF0YYEqaLbSP9116T5uKgQZTFG0G1ky
                                OXm2uCw13xCjMWQIFWUVq1zjitec6nWKEKCpn8xVHrj2dZerzmzSZCRGqcsSBUlIxV1HZPmrfHhS
                                mKMoGTkeE2715yja4DCyjZlQaooGWlsu8K5PyfOk9aOfjK2F9F1ZdCwML0oz8pdhY3jnpvbr5K+r
                                YiWjn7DolRQNrKv+DwDgzf2lEdfPYbj0oBPRKmgbKTvmos9Rb+PPb+0PtUnglQxtODv/Lp+bKffs
                                iaZpSmxPhGlgiEjjksDbP30p7HnglcyibQEGRalguEteG9xE4cqWgBYmBBB4ZsrMWkTLzD9jU/OE
                                nkfnqC+ZWS3z1ocz57t6R7uYv2LiaS1bxjtxDksKaxsY+OK+YSHBvFAUjS2lFgKT7Ux6HRPaB8ab
                                OLw6ysoeDmTrPvjibQEI6XEpAkGrrtwK1RmAnu+zwq6tKRoSj7IJjpiDgBNf/Wx7q0yai/0jLUJD
                                zFz9L1s0hd5Xxi+r3Lw2Gulut7t02Pqr03dPLT1OxxdI/tJUkIEP+96gnc3pxESpBEeYub4TvukJ
                                gBWP5iIWec88+mIjBIVFsSXL2awLvPusVhbZz9dlwenXEEGP74f5/DUpfmlcOjtd7L+7TI2vPMjH
                                b3XAbgrNsyvZbBfK6BDFS0kbz7MJ0caPU56X+L3Uu7ygJMXPjuNNecQ7x+so63TP4dKv8yRyV8It
                                pRYNiyz8lTWPR5r/O6+QWKePKiz32k28l9uCw/mznkWEmIsJM6zcEd0KEVVDqrPd+vqR+mm0Zf0X
                                B2i5+oQZ/7wfg8wFW6Zu18NKS8GWoRhpLyogagJtA7jiBoNuAWMUKMh3LPfiHDXaMwZKkTKM4HWo
                                o6spy/syMgR015wH8hfgODAitLNEMOmNEpzGkaW3+LcOtxiR4BF6cctdlCa0wBgGgs2Hz7FgrV/A
                                8sRM3xkpOxF8hwleV+MhiZWLysPWDE59yHEzPz/XcoyNNNGjm4adwHtvQx7JD8ZjWXw70dg9bNEz
                                0hagXKkKGdYlPPDpt88NfsHk8RVajtSYSYAAAAASUVORK5CYII="
                                    style="width: 46px; height: 46px;">
                            </div>
                            <div class="d-flex justify-center" style="width: 100%; font-size: 14px;">โทรศัพท์</div>
                        </div>

                        <div class="col-xs-3 col-md-2 col-lg-1">
                            <div class="NonSelectedBankDiv d-flex justify-center">
                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ix
                                AAAABHNCSVQICAgIfAhkiAAADzVJREFUaIG9mnuwX1V1xz9r7X1+93dzc29yQ4KBQAIJIUiREAVEq
                                yhY7VSn2gfq4DiOSnVaWxRxajtSaR1n6pSHwIDVcWypM04LIxoV6UMYiw+KAYHaxgcCARIS8oIkN7
                                mv3+/svfrH3ufxu/kFph2nZ+bOuvucfc5Za33X+q619/kJL3Js3nTzZf1O57090zWIFsRgDjGI5kSs
                                Zxxn4kYFQwEsogKYoQhYRKqxCGaGCpgZIgJm9btUmNVQPqOqPWLY7UWejGX5k9HC3XvRjz+y9YX0l
                                GEnv37+LceV6m+dovumUtyIWkQBIaIYaklpMUMwxEDJ/1fnpbkOJCPzdSoj8jUsazIgqzvTULGDnR
                                DuWNqRj12w5cNTL2rIN15544f26eSNJVI4QCzixJDKGIu47GGXEXAMIlAprdV5qZTPMms7oHs2rm0
                                LCIYlo7JxYjY1pnzwogcvv/2Yhtxxwedu26cT70wIWOsvjcUMlz2v2dsNMklWyqcxDUoYWaf6eqVA
                                o3wyso1EY0TbOLGu9W98w8NXXnmUIV9/1U037pVlHxEL+IyAExALWcZkRM4BGYpIS8acEzEjlY22G
                                pmWUTl3KlkpLwLRQESItVEGokSDUYmfeP1DH/1Mbchdr/nr03fFVb+AKBUCroWEVuFVIVSHmdVI1
                                eFkFULShFFMUow6pKTx+TGO4chYDr+cfeWIm177ugf/YocHmGfibyFIhUSSCQm1gNOEjFbIKEiMj
                                J+8lO7xY3TGRhhfv6LxdBVe2aVxus/0k/thPmKxYasGCegfmGFm234sks/HgdywmMbRyIhEEPXWG
                                /kU8H5vmH7ZvnShl4gjopqlxISEkpCRFFKrLl7PCRedzrJNqykmui/g0f/9EY7Mc/jhHez79laev
                                /sXmZmlJatwDZnKAzi5xOAyues111y6j8l/VEKNhJcmvCQjMr56KedfewndlRO/UuWPdRz58Xaev
                                PpO5nYdGkAmtqjZRIlmeLW3qqn8pqMkIVLitZIBJ0lObjiOV3/+Xf9vRgAsPnc1Z95+GZPnnoyPEU
                                /EWaTI0mM4C3gMgv26D8gZXiNqAa8ZEWeIlXiF0ZeMcd61b8cvbsJobtcBnv7idzh03y+g30+5EyKa
                                c8KJQB4n1tKjZAyVBBHHyIYTWfyqtSzatJrxC9cD4Ma7rLvlUh5/998x89jeGhknQoygmc1EdK188/
                                XXPzZv/rQqLzwRlZBZK/CqL32AxWuPr43Y/Y0tbP/CXUg/UNWbirXkKApOiS8RsMRaYpoS2jLFmmJR
                                wASLifsWv/FMVl33jszP0N99iMffcjOxDHX/YEBEMBEidq8accxrxElJoQEn/RRW2ueEC9cPGvG1+9
                                h+y2ZcmMdLj8KleYUv8dqjcCWuOk+fjgt4+hQuUGh6rkof5wKiAVUDiUhbYhy5+2fsu+Hu+r3FyiUs
                                +71zWuFUhVfEWaADk6pqXUcf73JOuGRMoYFVb9lUP6w8eISdX7qTwpV47VP4gNMehZZ4ScpW573M0/
                                EBJz2ci4iUSUldoLRERCNjF57OqXd+jFM2X86i808BjOf/4T562/bV7196ybk10mqxZYwhMYyrErx3
                                ISd4mZBxAdeJLD3n1AaN2+/By3xCwJU4MgLVWOaTkdLDuwhSIs4QDYhrKb/AGH/CBCde/x6Kk5bROX
                                UFq258FzrmkzG33le/f2TDStyysQFCUAxnkY7Q8eqiF2JiKwnpj8D4qSuRwtc3zTz8U7z2c68VcZor
                                v+YcUeoihkX8xBidM07Dr1wO6ih37Wd261PEAzOYRQTFLOImR0ldZVZucRd//GL6Tx/gyA9/OaB499
                                dWMf2DwXMpJeOYVymdF0MlUa9aSaHGogVUW+7ZSeFiritV25IqPAgWBRWh2LCOyT94J50z1tbJ2j56
                                jz3D1J3/wdRdW9Ce0XvsGWYffoLRl68DYPbBJyiffQ4E4oEjxOl5dGwEgM5Jk0wf9cR0yXsNqhLq+u
                                FcRAmMtGCMM7N0tMxtS0iQYmQuxKLgRkdY8sF3M/bGC4e/qnrj+pNYfuU7WHLJ63n2o5/D9k6x64rP
                                M/4bryDOlRz57k9Tm6OKxUi5Z4rO2hUAR4VWCxOvqqUULrFJnei+xI+6ZtrcPCrzFEU/50Qf0bKOfT
                                dacPz1V7+oEe2jWH08q77wUdzkItQCh//tQabv/QkQEKXOoTg7X99TIXPUIeJ84YKolPicH14jKn2K
                                bpMf1u9R+DL1YN4y/wtYQJyw9MMfwK8+qZ7ff3oHU//0LeYe/ilxZh4dH6c4bS3djS9l/M2vRRal4u
                                pWLOUln34fz15+c41AI1OjaL2y0Xek0WkADwNV6UuqB2VNqR0XUN9qsWPAuR7OlyAB0QiZjUbO28To
                                q19ZT5378SPs/fhfMfejLTA/AxKxw4eZf+i/OPT3X+WZ915F77Ht9fzuxtOYeNurQSKaq6ikypnYrQ
                                yNIV6HAwJOvQuo9vG+RLWHd0lq0UpUC3gfEnW6CBpRl6h04p3vqKeF/c9x4MZbkHK+plitKNfFVOIP
                                T7H3kzcRDx2p71v6vt8aUl+SbG9OyHA7AEOd6+NdmSp6VReKgEhsHmCxLl7JiAgScCuW4desqecd+d
                                od0JtO8ySmHNLB4odGbGqKg7duru9zyybonn0qeVU2YIzFRo+8IBqGiahzQZwr8b7Euz5FUeI0VeSB
                                qS7mtqJRsrPh9JZTjLkt9zdFz7WUH+LpmXt/BC0lR166Zsg8G2RwoW5jFh6qGQl1vRxe83jfTyHRgq
                                5WrhUmbnJpPSNOHYLe9FClhxlj/Tn625+t7/fLJ4YYYWkXpfY7QBwaYlrlRuGrXEmNoEjDFggtJJJM
                                4dV+iSQicINhdKzYF7UBRKo2uW1Ekg0kZpaNiAv2f0C9K6P3ISW6L/Guhy/KQfhUMktVRiRlbOq5Ro
                                +JJejYaJMbLxBWkjo//IlNZx0OTiWPL8iRtsJ1814Z0/ggqnMlziXWcq6H9yEVu3ZSWfXwkNkqGdXf
                                9rMBr4ycfwGiEVmo/BBkui8/C+k2Ba7cuTtdl7xHMsTzVp1vIUd2uar2xLuAcyW+CIjr54RqWSw0lC
                                uhVsYO7iHs2FbPW/y7lyKjHajYbRgSEpFCWfLehrYpS+Ye3rpgXVJ5vhW+gNXGDRCBqC9iVNfDF31U
                                e3WxQ9q0pyknajZKuSASmbnzy820yeUs+dCfIh03RKk8dsLSP3o/xZqT6/sOf+seKHs5rDISCiapwj
                                eQtJyRZULFojrt4XzqtdSlqi3OIPabBzjXVPQ6oVN49bbeT++h79dTO2efx7Krr2fkvAvQRd1sPEi3
                                oPuKTSz/9F+y6KKmJwv7n2fq9m9SV/RWDogArqEoC7E5X0tDEPHOl9G5vvOuxVIGhKZZk6KDOEvrCB
                                Hyyj9tWKtw5CvXsWTVKbiVq5PdJ53Ckj/+86To3t1Yv48/8aSj2/oy8NxnbsDmZnOPZem5rZ5LR4pG
                                rX4fUbCQ5lmoNvmIKq4M3pcNK1WynGsM6XRzuxFrJKSdwP0Zpq67gvD00Ysed/xK/KqTjzIi7NvP/q
                                s+RX/bU02CZ0SqHXARkG6nMWSul+ZpixASy/W9cyGIlmguPhVcNneoeWt3MVK0t3iyxyym3XOLMDfF
                                oesup/OKN9B93Vvxp2wYurAiRqb/5Z85fNtXiXP9GonUjljd9Yo4TAy3ZHFj/NQ0iNXbrGlFqli06J
                                3r95wPY/V2ZLVne2jnwPt1+YnYvu1YFMQpFgIi6fOOWDbKoPfA3fS2fBfrjtM581yKDRvRiWWUe3ZT
                                bnuCuUf+EzsyiwVJymYkIhWdWt59j+jYKDo53hiy50CNlBHr+1XpeV+UsxAmq7Jf7aLHfb+k3tsHin
                                Ub6e1/KhkRE/sMrh8GJbOHmX/wXuYf+H7ar4qKVX8iC+ZnREJLijBy1roBZ84/uSsZIQtzJM4q9KfT
                                bkcV8zlH+oeJO5vPdsUFb2/YaljF1sQ2NlCZaWJfmhyQVh2wZvs+3Y+Rd/sY/+0Wu+07SLl9D7TCv5
                                EyrerjITTTroZcL9K4/O9vN6G1cj1+07HXDdLqlayi0GG9U0WtdaK2xrVyke45ZzB6/svq9x/5zhaq
                                bxbtXM7jQ4rG/druanNFFo2ER74KMweanH/bJ/BnXTS8d2oVP23XAVpdbKv9SBW6qRvN2OiefQbLr/
                                rDOqyt1+fQbfcMR1IMFfa5T75pxcUQN9We00HPxd2P4s96M4iCevxZb8SvOw9608T9O6gdI9V3qOqD
                                pjQ5V/2Z5I88rXGWqDKy8WyWvu9Slrzn95GRhnafu+bLzD+6A2vPb90fke97pHwstQHp9alVzrvmIs
                                Snfkj/21dTvOVToGnxr2s20V2ziW5vlrDr0fShD9JGdJYskMc8r0qxeg0yOsqw4+Ctm5n+7oOApm+K
                                7ZwSiNFQY6tH4/1I5b/8yTjvjlQWh62bsYM7KH7nOmS8ab3pjOJOOWeoAr+K4+AXb2Pq6/8OSB1OAx
                                9Oq7Fwv9jbcf0LTttrxGX1JJQYSduaETAlRkH8GP61f4Lf+DYYXfpievyfDpuZYXbLI0zd8a/0n3oW
                                CwrREYOAOSzLGKQ6//z6B65ZLgDzN6z9G8E+PvhEyd8t0vcLs3YtEGTFGegJZyETK1Oo1PPz/ybgOu
                                hxq9DFS0lbzgyGl0F/507iwSnC1GF6P3+C3rYdWAlE19SdsKAOZeMsCkS95rQHrv0zD9Bxel2/DFcg
                                NBkmhrjUcYpq/uBtTUXd8yhh9+NHe6qsxpqQbClRe7ZWou3pNI+ouWOo2hAbzI1co2NaTvVCiNdC/o
                                mIfPjxfaZcNgToZiUmlotddT7Lo4oTDOV7hvJ//aOB6pcNkiXZiGZeNaE1z+JlGx66fn9tCMDIFU9+
                                BZUrSFkxaEyrHgxU4IW8XoHZrBOofktyFP9bW+nUFtUJTXM92SS1sZmQIpEr1m/57Feqdw5srHQ+su
                                0mMS42Y3ejVdWgtcdWs9yAxxj0LAvn1T+oqTzOi19vIZiN3S3Ei9fdf8NNbd2P2iEqrnzqe52xZesM
                                +wQi22uHMeCRGv5KmLU8n95ZG1XrmimzjVxri2PB9SpH6tu3i8pVz87vWXvqD27+3kK9ZeGJhcfsTW
                                tXS7CNEtyZFnWtBV1j5rpEfZkFXWZ1Iic2sVYip/Gxr8eoEJQYdCfmHicKMTTEYUFniPJzK93mNfd8
                                8YcvpOf/AE0R4bQ47eS2AAAAAElFTkSuQmCC" style="width: 46px; height: 46px;">
                            </div>
                            <div class="d-flex justify-center"
                                style="width: 100%; font-size: 14px; margin-top: -2.5px;">Instagram</div>
                        </div>

                        <div class="col-xs-3 col-md-2 col-lg-1">
                            <div class="NonSelectedBankDiv d-flex justify-center">
                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAA
                                ABHNCSVQICAgIfAhkiAAACGNJREFUaIHdmWtQlNcZx3/n3Qt3QVAXFeRWUSNe8AKIYrxkIlpNE422y
                                XTaiDBjO+1kmtRx2iaZ9EMn006mdZJpUxUx0yZe0SjaZqITo6AmUUwWULwLqFwiUS4Cyy677+kH5N1dF
                                mQXsJj8P73nec95zvM/l+d5zjmCXrA2Z+9yIBUpZoCcIYSI7K3uI0YtyK+QyldSqGe2b119uKdKorsgO
                                3tPnEMoHwhIf/Q2+g4Jp3VS/Wlu7poKV7niWli7bm+2KkTp40oCQEC6KkTpSzn5Wd3kncjKyV8PvPd/t
                                2xg+EXe1uf/CQ+IZGXti5eKWiqECBpau3yDlLJVqMrUvLxVNxSQQurkv79rJACEEEEo8l8ghXgpe1+aI
                                uTnQ23UQKBKMUdRUNOG2pCBQkFNUyQsGGpDBgqJSNMLGLQZMRp1TJs6mtmzohg5MoiQYD9CQvxwOCQtL
                                VZaWm1UVzdRfK6a8xfqcDjkoPQrIE1k5eQPWFtYqD8rn0siZXY0BoPSdwPAYrFz8nQlBYfKaWvrGKgJD
                                IiITif44dKJLFs60WsC3WGx2Pno4AU+PXatv2Z02pI8c82b/WkYFGRkw6tPkpY6Dp3OI9MBwG5X+XCHG
                                YvFTlRUaI91DAaFKUmRxMWG87W5pt/LrV/DGBkZwpuvP0Vc7HBN1m61c6CgHOlix45dZo4X3mDrtjOUl
                                tZp8ra2DnbsKqGlxabJpk6J5LXfLSI01L8/JvlOZFiIH799JYPw8ABNduXqt7z2xhGsVjviweS0ttoo
                                Olmp1dm526x9BwYauHu3lY2//5hTp6s0+dixw/jNy/MwGnWPlojRqOPVVzIYHuYk8cmRK/zl7RM0NFiY
                                kzpOkxcWVaCqzum5U9/Kpcv1WjktdRzt7Xby3i/mwx1mrW50VCi/+mW6NiCPhMjKZycTNda51g8UlLMn
                                vwwpwd9PT3R0mPavpLTWo/2Zs7e070kTR2nfx45fZ+fuEq08+YlRLF70A19M855IWJg/ixY6lZedr+PQ
                                4YtaOSEhQhtFq9XBtet3PXQUn6vW9lBwsJGRI53p3bHPrvPFlze18jPLJ/m0xPTeVlz5bJLmnaxWB1tz
                                zwCdLjg+LoJFCxO0un5+OnI3r+pT57LMCZworKDqZgNSws7dJcyaGYVerxAUZGRp5gQOFpQPHhGdTjB7
                                VpRWPnL0ComJI8mYF8ukiaP6tTkB5mfEMT8jDoulg9KyOgqLKig6WcnCBfEApM+JGVwiU5Ii3Yx9avF4
                                AgK8nsw+ERBgIDUlmtSUaCwWZ5QfERFIdFQot2439anDK2umTx/TrWP3Zi0tNgICDNrS25NfRmVlQ4+6
                                pk6NJPPpRKBziaqqdNMXEGDw6HvQiIyODPGQ2WwOjh2/zrlz1dyouMfmfzxH18n58pX6XokEBxu173v3
                                2njjj0dJHD+C5OljmDc3Fn9/d5MiTZ5995tImEvcADh1uor8fWU037cCnXtIr3c6QNfl0R2u//z99aiq
                                5NLlei5drid/fxnLMifyzIpJLn17F+m9IuIaAHftLuHop+4JnisJ6MyxeoPd4fxnMLg7iY4OlYOHyjEa
                                dWQu6Vx+YV6mLD6nKKYepto1ggPgZd6nyp4r6vS+p4BezUhjo4WIiEAAFi6IJyzUn30HzlNbex/wnIGH
                                uWOD3vnP0a2dyRTMCz+expQk56VmU7PVGxO9JNLUrhEBSE4eQ3LyGK7fuIfZXENJaS02m0Mj0N3zuMJ1
                                M7db7YwaGURMzHAmTzYxd04MiuKeZDU1WQaPSE1tMwnx4R7yhPhwEuLDWbUyyU2eMS+W4cMD3NJ0gNBQ
                                P2bNdAbW0ZEhvPWnzD76vu+Nid4RMZtryJgbq5Utlo6HjnpXxO4Puus2m2u8aucVkfKLd7DbVc07HTl6
                                lVu3mwaconTBYumg7Pw3FJ6sIDUlWhu0xqZ2r4IheEnEZnPw5ZlbzE2PASBzyQQ2bPwPX5trtKRxydPj
                                SX6QAdhsDioqG9DrFUZHhhAYaMDhkNTXt2AyhWhZcmFRBSeKKqiq6kwaTaZg5qU7Z76wsMLDlgERAfjo
                                wAXtfO7npyMnO4VN75zC4ZBcvfYtBoOiEVEUwaZ3TmKzOdx0jIgI5M9vLdXKh/97ibt32zoN0Susz0l1
                                O2F+/Mllr4l47bAbGi0c+8wZCKckRfKjFU9o5RsV97Szhl6vuB2cuuCaszU1tWskANatnc24cc6DWcHh
                                ix4D8TD4FHn2H7jgtmZXLJ/E8yuTEALa2+1U3XTmVzNnjPVoPzPZKes6QRoMCjnrUkiZ7fRm5Rfv+Hw9
                                5BMRm83BXzcV0dTUDoAQsDRzAhs3PInJFOx22ZCaEk1QoNP7jB4dQmLiCK18+vMqYmOG8/ofFpOWGq3J
                                a+vu8+7fT9NL0O8VPt9rWa0OSkprmT59DIEP3GREeCALFyRgsXQQNTYUITr3idFPT9n5zmug7KzZmEYF
                                azqCgoy88JNpDAvx03RXVzfz9t+K+nXz2O+bxuBgIy//ei7xcZ6B0hVHjl5l2DB/t1HvCaVldby3+Quf
                                9oUrvjdXpt+jS+zsvXUIYRqwJnp/VlBVyf0WKy0tNqprmikuvj2ozwpI+Y1eIswClgyGPpvNwdni25wt
                                vj0Y6ryGRJgVIYS576qPN4QQZkWgfveJoJoVnfAvkMiyoTamv5BwoblRHlS2bFnRpqi6F6WUtr6bPV6Q
                                Utqwq2v27l1jUQC2bVt5XsDGoTbMVwjYuH37mnJwybXycldvkkKuB9kydKZ5BylpRMqf5+Wu3tQl83hO
                                WbduX4wq5PtCPJ7v71JyvEMRL36wZZXbA0yv70I/y9mfqFMd84Ui5iOZjyDm0ZvpCYm8iRSFQlCIQy3M
                                y1vT42nrfzjdK+DQQBxMAAAAAElFTkSuQmCC" style="width: 46px; height: 46px;">
                            </div>
                            <div class="d-flex justify-center"
                                style="width: 100%; font-size: 14px; margin-top: -2.5px;">Website</div>
                        </div>

                        <div class="col-xs-3 col-md-2 col-lg-1">
                            <div class="NonSelectedBankDiv d-flex justify-center">
                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAA
                                BHNCSVQICAgIfAhkiAAAAgpJREFUaIHtmr9rE2EYxz/PS3Tp0q1dJOjgJGq7eDoEN6Wc7S5Cgzi0W7f+
                                G910s/74A2yS7pJBoWA5Yi24WBChdlKhdRC5x+ESPS4XvPRM37fx/UDg3ofvcd8PL+Hg7oQBaIMQ4Row2
                                /1ND8qOFGUfYRtlG9iSeVp5Mek7r8F5hOfAjVF3PCavUO7JPHvpoUkvtMkDoIO7EpB062iL++nh7x3RJk
                                vAw5NuVZJlucMj6IpoiwsoHWDCaq3hOUK4LCEfjCqC8ozTJwEwQcxTVUS0QYDw2najUijXDYbAdo/SGAJ
                                DzE3bPUqjBAbGYEcgMAhTtlv8A6rm75nTgRdxDS/iGl7ENbyIa3gR1yguUpmEK4/h1hcINTmuTNrLZ08v
                                nLy6DtMLf9bn6iACUd1OPkPxHUlfpMdUzuyk8hnK/Uek77GYtXxxkc8bObMX9vIZiotE9eRiP78l609PY
                                GfFXj6DaBMtnHaY//A+4jhexDW8iGt4EdfwIq4xRiLKge0SpVEODEJku0dphMigYyCiRAYzBiIm2ZEG8N
                                Z2l2OjvOM7G70PBi4R8wbhrO1eQ6H8oMKMzLFrACRkB8Oq7V5DY1iVOXaTwy4SsoayhHJor1lBlK/AooS
                                s9Ub9nzltUiVmHZx9//6SM9yV2+ynhwMfHOkmF4mpodQQakB15BXz+YjSRmgT05YF3ueFfgG9SJxo5Lz
                                18AAAAABJRU5ErkJggg==" style="width: 46px; height: 46px;">
                            </div>
                            <div class="d-flex justify-center" style="width: 100%; font-size: 14px;">อื่น ๆ</div>
                        </div>

                        <div class="col-xs-3 col-md-2 col-lg-1">
                            <div class="NonSelectedBankDiv d-flex justify-center">
                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAA
                                BHNCSVQICAgIfAhkiAAACVBJREFUaIHNmWuMXVUVx39r73PvnZnO0JcpLRSYTh9CERuLhlJjAQkiKekXa
                                YeIJIIE8YPyyRCVEDX6wUS/SdAPio8gFGJCABECMdra0vBKHxkeOgyP2gfQ50xn7uOcvZYfzp079z13huH
                                xT07mzj5nr7X+e+/12HsLLWCDA9er2GVish5YDyxt9e2HCuMI8LJhLzuR52X7yBPNPpOGfl9fM2Ah+TOw8
                                cO2cZbYLT66Wf7yn5HqRlf9jw2uuM1Cso9PLgmAjRaSfbZt4NbqxsqM2LaBO0y476O3a/YQ4zvy8MhvoEz
                                EBletNHQfMA/AzBAR7GM0shka/ADGBbdOtg+/IfZjnL06sJPycjJLzRcRsE8OFaNsUyN2yUUjm8QG+zcY
                                7rlKh0njrc6BZqgUDCGd1abqZwiVlkQQ9PII3IbaVkHMZqbcUkXpDAqJCyTdC9FzVyB9C7HRE7hDI2Tzo
                                zjzmBiClQdqLmi6DZFhV9YIE5ixc0jaTQU0myVZdzVu8y1kL1iFeocLgfjN/cSP/gH/2i6iYoKIw5jhgL
                                WAYhtEBweOAmdPNpqAqCEzIGMYmJB4SK65CXfDd5HRUZI9TyDvHUHPPge/8Tpcrpfk6QeI/nY/UTyB4Do
                                m0m5pAW9H1SRmDyOIp3jeKrJbbof3D1G67x56/vcKzgxFOPPCM+Ru/zmZ628mGdmP37+7TGJOAsoFs/XnW
                                qgn5HqIvnYnIIT7f0buYEoCQDByb79G8sCvoBDgmhsJvoc5IgHMPjDVQB2Ec1eSWbsRPbCLzMheRKpFK14
                                TogP/pvjcdqK1GyiuWAvoXKgH5oiIGLiBi7HuHPbqC0iSIDU5SHAYkYB7cTdoIHP5VzDn50I9MFdEUHT5A
                                BIn8NZQU6GCwwHZo++gJ97HXbgO6+qdC/UARA0tlqqtzmQBAxQxSfNFfawRwS1eho6dhtPHSSRCMJIqGpP
                                Q4gR64l388pWEnj4sPzqlM/0CAcRcKrdDP2okQjmc1qon7llMcf4icgpWF5sDDn/WEkJSJFmwFLrOaqkwi
                                XJ4C2h3H7b8YkI0ryIF0jBrZmTGxshMvIuZL9vRPlCLDg7UWGUoWG23eNFS9I5fIAMXIZJpiP5GwOW6AYe
                                W8og1y6rlYCuGZLKYzyKlMVBN35kvy4KgMZw+jtz7fbJvDlV3b4mmM1JZV5Odexfgz1+Dn7cIEU/rvAQ+k
                                5uSYqEqiTXxnO6FjZrN8JoQ5i1AzluNjQwhUibbhk1Hzu6SGAkJMsOCwhDMKD+d5wwTwZmR5M+0HbRqRA2
                                letVEVFZHqYAWizgDkfb1bGqwYUlCcuoQNjYGmRx+4VJ8T19aAiEYhpMm4yiGKThTKE5UthJpGd+GSH1Nl
                                a7vOh+IYyTOlxdc+yHSEFMafonwzCNw7Aiuu5eQxCiB6JzV+C9cjVx4KZHzmJOG+snKGjQkuLGTFUefbj5
                                b+EgtXEiwUmnahaWqhLdex+69G/nidWS2fQ/fvQC1hNLpE9j+nUzsfpLe81YjffMxUYT6pGhp2I0TQn68E
                                /M6J2JJiSSfJ4uVS++6UTQrP4rueQJd3k9my21EXb2ogDehu28hnLuSLo0Rn0VFiEwaU5Kl4d9KJSjm6ym
                                2HMyOiEhIsOKZ9HczSQaKAQl69B3c6nWQ68VJhKtbqc53UJYIhPwZpFSoEGjCuQYdRS0Jhs+far0NKjerR
                                LgFZ6N7n8OdPFJOrLOocA2slMfFcUX8dPujjoiYKpofb2mUiODFEUmEXHoF/uAwpYd/TXzsbTQEQgioKaq
                                KapiGQ9m9i6eRJK7V06Zfy6VVHfdFDCkWUGhwzWoyAshnNsKNdyKP/ZbC8Eu4jVtw668gWtKPdM3DuWlKj
                                fLhjZ46gdd4KjtMk1Ba+0hVRzNFx06nTdMci3ifwX95G/Ga9UT7dpAM7cF2PYktWY5s3Ezm81fheuZXqag
                                VJpbuUmx0DExB0qGbLmK2IcLUwjSD0ZNpsppGqHcOXBa/Yi16/qcJm79JcvBVkr8/hPzxpxRe+gddt/wQ5
                                i8hokkeMfAWiEePpUwrztGeShsfqetYGMdr6LhIMQx1hvcZMv2XkLv1R0Tfugd38DXinY/i26RqNUNPHJ5
                                RSdTxxkpHTyGmzd29Oo+YoWbpAZ85TBzg0Ww3/rItuM3fgH17UC22PMk0BZk4mcbciorZ+kgVBCMaP44Fn
                                VyytYqxSnDQckbx5hCf7grTJJo+YfEy1JJy4GhinJTz1sQoMwndbWbEan5JIZ9m26YQzJRiqUg8cgAJCZR
                                PE6eEZEi0iO5/nmjxcvCZlmpDiMmMjcM0Ea4abWakanMkEAp5tDiO713QRLdhIkT5McYf/x0h14VffxW+/
                                yLcvLOwJCEcHSHe+TjulZfRW39A1qy5/wpIKGKlifKtQBXDNj7TQKTy+WRdMCk8KeEKE00FCoIDSvPnk73
                                lbnT3s8SP/h4dPUzStZBMqYgmBWz1Z3F3/ARZ9bnycVGLQ+lSCQrjacCq2NCsymtDpCKsyhGdCr5UgvGJl
                                uOiCDnNkMxfDF/dCl+6Dj12BH/yMPgcftEy/KeWY7lM6huV0NpEWrGAKxTApgw3XNsI3GRGrFxJS02bxQX
                                s+Hs4mzycsMohXFqieMRBhEv79uWgbxGsuJjKMrV09zftduDMSSSU0hMUmZqRdj07KxpxeA0Uh/4FSbFif
                                O03k3+lrnXqDdOQmNwO6MiB9GBimpBbjdZEpjbbQMDEk3vhKeL/7iOYkhhgivEBH5t8DDUlPvIGPPtXpAQ
                                mWmVDe4htXVFzraCi6UVP075CfukFhGsG8ctW47K5Zh/NAoZpTDg0DE8/TM+R4cbSxTlotsdP8a7Y1hVPA
                                dd2RgQS85hXNNOFkxa5YBZQSXDFAi4IXhpL/fZE5OkIk72IXdviiwZ4Eiw4nBYQKc7W7jor09wnWl5OM+1
                                utjcC3TuTe7x031FVFc8VPsCtqRPZ6+jOPw4cmDuLPnIMMZF/LE3iWwcuAXsRyE5eUKah8OO1sAIBnNRdH
                                gFQEufWy4PDQw5AHhk5gNldaZ/J2J9uej4RT4tzX4G75MHhIerf2g3930bkl8Dc3cDMEepudU8Jcqdsf+N
                                Pkw0NNO3G/n6C3A9c+RHZ2BGmiNg/RZKb5KGDh6vft4wTNjiwhmCbEDYBm4ALPmRbW+EdjB3BscMbO+SRN
                                19v9tH/AcbdVTBgzppeAAAAAElFTkSuQmCC" style="width: 46px; height: 46px;">
                            </div>
                            <div class="d-flex justify-center"
                                style="width: 100%; font-size: 14px; margin-top: -2.5px;">Shopee</div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6 col-xs-12" style="padding-right: 0; padding-bottom: 0;">
                            <p style="font-size: 16px; width: 100%; margin-bottom: 5px; color: #666;">
                                <b>ชื่อลูกค้า</b></p>
                            <v-text-field class="border-grey" :rules="customer_name_rules" counter="50" single-line
                                outlined color="none"
                                style="padding-top: 0; margin-top: 0; width: 100%; background-color: #fafafa; font-size: 18px;"
                                v-model="customer_name">
                            </v-text-field>
                        </div>
                        <div class="col-md-6 col-xs-12" style="padding-bottom: 0;">
                            <p style="font-size: 16px; width: 100%; margin-bottom: 5px; color: #666;">
                                <b>Facebook / LINE / อีเมล</b></p>
                            <v-text-field class="border-grey" counter="200" single-line outlined color="none"
                                style="padding-top: 0; margin-top: 0; width: 100%; background-color: #fafafa; font-size: 18px;"
                                v-model="customer_contact">
                            </v-text-field>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-xs-12" style="padding-right: 0; padding-top: 0;">
                            <p style="font-size: 16px; width: 100%; margin-bottom: 5px; color: #666;">
                                <b>ที่อยู่</b></p>
                            <v-textarea class="border-grey" counter="80" single-line outlined color="none"
                                style="padding-top: 0; margin-top: 0; width: 100%; background-color: #fafafa; font-size: 18px;"
                                v-model="customer_address">
                            </v-textarea>
                        </div>
                        <div class="col-md-6 col-xs-12" style="padding-top: 0;">
                            <p style="font-size: 16px; width: 100%; margin-bottom: 5px; color: #666;">
                                <b>เบอร์โทรศัพท์</b></p>
                            <v-text-field class="border-grey" single-line outlined color="none"
                                style="padding-top: 0; margin-top: 0; width: 100%; background-color: #fafafa; font-size: 18px;"
                                v-model="customer_tel">
                            </v-text-field>

                            <p style="font-size: 16px; width: 100%; margin-bottom: 5px; color: #666;">
                                <b>เบอร์โทรศัพท์สำรอง (ปล่อยว่างได้) </b></p>
                            <v-text-field class="border-grey" hide-details single-line outlined color="none"
                                style="padding-top: 0; margin-top: 0; width: 100%; background-color: #fafafa; font-size: 18px;"
                                v-model="customer_tel_opt">
                            </v-text-field>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-3 col-xs-12" style="padding-right: 0; padding-top: 0;">
                            <p style="font-size: 16px; width: 100%; margin-bottom: 5px; color: #666;">
                                <b>จังหวัด</b></p>
                            <v-text-field class="border-grey" single-line outlined color="none"
                                style="padding-top: 0; margin-top: 0; width: 100%; background-color: #fafafa; font-size: 18px;"
                                v-model="customer_province">
                            </v-text-field>
                        </div>

                        <div class="col-md-3 col-xs-12" style="padding-top: 0;">
                            <p style="font-size: 16px; width: 100%; margin-bottom: 5px; color: #666;">
                                <b>อำเภอ / เขต</b></p>
                            <v-text-field class="border-grey" single-line outlined color="none"
                                style="padding-top: 0; margin-top: 0; width: 100%; background-color: #fafafa; font-size: 18px;"
                                v-model="customer_district">
                            </v-text-field>
                        </div>

                        <div class="col-md-3 col-xs-12" style="padding-top: 0;">
                            <p style="font-size: 16px; width: 100%; margin-bottom: 5px; color: #666;">
                                <b>ตำบล / แขวง</b></p>
                            <v-text-field class="border-grey" single-line outlined color="none"
                                style="padding-top: 0; margin-top: 0; width: 100%; background-color: #fafafa; font-size: 18px;"
                                v-model="customer_subdistrict" @keyup="test">
                            </v-text-field>
                        </div>

                        <div class="col-md-3 col-xs-12" style="padding-top: 0;">
                            <p style="font-size: 16px; width: 100%; margin-bottom: 5px; color: #666;">
                                <b>รหัสไปรษณีย์</b></p>
                            <v-text-field class="border-grey" single-line outlined color="none"
                                style="padding-top: 0; margin-top: 0; width: 100%; background-color: #fafafa; font-size: 18px;"
                                v-model="customer_postcode">
                            </v-text-field>
                        </div>

                    </div>

                </v-card>

                <div class="row" style="width: 100%; margin-right: 0px; margin-top: 15px; padding-left: 12px;">
                    <v-card style="width: 100%; padding: 0px; box-shadow: 0 0 10px rgba(0,0,0,.1); border-radius: 5px;">
                        <v-data-table class="green-table" :headers="create_orders_headers" :items="create_orders_item"
                            item-key="name" :page.sync="page" :items-per-page="`${select.itemsPerPage}`" text-center
                            hide-default-footer @page-count="pageCount = $event">

                            <template v-slot:item="{ item }" slot-scope="props">
                                <tr>
                                    <td class="text-xs-left"
                                        style="height: 72px; border-right: 1px solid rgba(0,0,0,.18); padding: 12px 24px;">
                                        {{ item.item_name }}</td>
                                    <td class="text-xs-left"
                                        style="width: 120px; height: 72px; border-right: 1px solid rgba(0,0,0,.18); padding: 12px 24px;">
                                        <v-text-field v-model="item.quantity" class="border-grey" hide-details
                                            single-line outlined dense color="none"
                                            style="padding-top: 0; margin-top: 0; width: 100%; background-color: #fafafa; font-size: 16px; "
                                            @keyup="calculatePrice(item)">
                                        </v-text-field>
                                    </td>
                                    <td class="text-xs-left"
                                        style="width: 120px; height: 72px; border-right: 1px solid rgba(0,0,0,.18); padding: 12px 24px;">
                                        <v-text-field v-model="item.price" class="border-grey" hide-details single-line
                                            outlined dense color="none"
                                            style="padding-top: 0; margin-top: 0; width: 100%; background-color: #fafafa; font-size: 16px;"
                                            disabled>
                                        </v-text-field>
                                    </td>
                                    <td class="text-xs-left"
                                        style="width: 120px; height: 72px; border-right: 1px solid rgba(0,0,0,.18); padding: 12px 24px;">
                                        <v-text-field v-model="item.type" class="border-grey" hide-details single-line
                                            outlined dense color="none"
                                            style="padding-top: 0; margin-top: 0; width: 100%; background-color: #fafafa; font-size: 16px;"
                                            disabled>
                                        </v-text-field>
                                    </td>
                                    <td class="text-xs-left"
                                        style="width: 120px; height: 72px; border-right: 1px solid rgba(0,0,0,.18); padding: 12px 24px;">
                                        <v-text-field v-model="item.all_price" class="border-grey" hide-details
                                            single-line outlined dense color="none"
                                            style="padding-top: 0; margin-top: 0; width: 100%; background-color: #fafafa; font-size: 16px;"
                                            disabled>
                                        </v-text-field>
                                    </td>
                                    <td
                                        style="width: 80px; height: 72px; border-right: 1px solid rgba(0,0,0,.18); padding: 12px 24px;">
                                        <v-btn @click="deleteItem(item)" color="red darken-4" style="width: 46px;">
                                            <svg style="width:22px;height:22px; color: white;" viewBox="0 0 24 24">
                                                <path fill="currentColor"
                                                    d="M9,3V4H4V6H5V19A2,2 0 0,0 7,21H17A2,2 0 0,0 19,19V6H20V4H15V3H9M7,6H17V19H7V6M9,8V17H11V8H9M13,8V17H15V8H13Z" />
                                            </svg>
                                        </v-btn>
                                    </td>
                                </tr>
                            </template>
                        </v-data-table>
                    </v-card>

                    <div class="row" style="width: 100%">
                        <div class="col-md-6 col-sm-6 col-xs-12">

                            <v-dialog v-model="addItemWindow" max-width="600px" max-height="95vh">
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn v-bind="attrs" v-on="on" style="overflow: hidden; padding-top: 0; box-shadow: none !important;
                                            font-size: 16px !important;
                                            padding-top: 15px !important;
                                            background-color: rgb(170, 194, 127) !important;
                                            color: white !important;
                                            border-radius: 6px !important;">
                                        <i class="fa fa-plus-circle"
                                            style="margin-top: -15px; font-size: 22px; margin-right: 5px;"
                                            aria-hidden="true"></i>
                                        <p>เพิ่มสินค้า</p>
                                    </v-btn>
                                </template>
                                <v-card style="font-family: 'Kanit', sans-serif; height: 90vh;
                                overflow: scroll;
                                overflow-x: hidden; padding: 48px;">

                                    <v-btn icon v-bind="attrs" v-on="on"
                                        style="margin-bottom: 8px; margin-right: 10px; position: absolute; right: 0; top: 5px"
                                        @click="close">
                                        <span
                                            style="width: 22.5px; height: 22.5px;background-color: white; color: black; border-radius: 10px; padding: 0 .4rem; font-size: 15px;">X</span>
                                    </v-btn>

                                    <v-card-text style=" color: black; font-size: 18px; text-align: center; padding: 0px;">
                                        <p style="font-size: 22px;">เลือกสินค้า</p>
                                        <div class="row" style="width: 100%;">

                                            <div class="col-md-10">
                                                <v-text-field v-model="search" prepend-inner-icon="mdi-magnify"
                                                    placeholder="search" single-line hide-details outlined dense color="none"
                                                    style="padding-top: 0; margin-top: 0; width: 100%;">
                                                </v-text-field>
                                            </div>
                                            <div class="col-md-2">
                                                <v-dialog v-model="dialog" max-width="98vw" max-height="95vh">
                                                    <template v-slot:activator="{ on, attrs }">
                                                        <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on"
                                                            style="font-size: 18px; height: 36px; width: 105px; background-color: rgb(170, 194, 127) !important;">
                                                            สร้างสินค้า
                                                        </v-btn>
                                                    </template>
                                                    <v-card style="font-family: 'Kanit', sans-serif; padding: 15px;">
                                                        <v-card-title>
                                                            <p style="font-size: 25px;">สร้างสินค้า</p>
                                                        </v-card-title>

                                                        <v-card-text class="add-item" style=" color: black;">
                                                            <div class="row" style="border-top: 1.5px solid rgba(0, 0, 0, .1);">
                                                                <div class="col-md-2 col-sm-3">
                                                                    <p style="font-size: 18px;">รายละเอียดสินค้า</p>
                                                                </div>
                                                                <div class="col-md-10 col-sm-9"
                                                                    style="padding: 10px 0px 0px 14vw;">



                                                                    <div class="row" style="padding-top: 30px;">
                                                                        <div class="col-md-8 col-sm-9 col-xs-12"
                                                                            style="padding: 0;">
                                                                            <p
                                                                                style="font-size: 15px; width: 100%; margin-bottom: 5px; padding-left: 20px; color: #666;">
                                                                                ชื่อสินค้า</p>
                                                                            <v-text-field placeholder="ชื่อสินค้า" single-line
                                                                                hide-details outlined color="none"
                                                                                style="padding-top: 0; margin-top: 0; width: 100%; background-color: #fafafa; font-size: 18px;"
                                                                                v-model="item_name">
                                                                            </v-text-field>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row" style="padding-top: 30px;">
                                                                        <div class="col-md-8 col-sm-9 col-xs-12"
                                                                            style="padding: 0;">
                                                                            <p
                                                                                style="font-size: 15px; width: 100%; margin-bottom: 5px; padding-left: 20px; color: #666;">
                                                                                ชนิดของสินค้า</p>
                                                                            <v-text-field placeholder="ชนิดของสินค้า"
                                                                                single-line hide-details outlined color="none"
                                                                                style="padding-top: 0; margin-top: 0; width: 100%; background-color: #fafafa; font-size: 18px;"
                                                                                v-model="item_type">
                                                                            </v-text-field>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row" style="padding-top: 20px;">
                                                                        <div class="col-md-3 col-sm-5 col-xs-12"
                                                                            style="padding: 0; padding-right: 25px;">
                                                                            <p
                                                                                style="font-size: 15px; width: 100%; margin-bottom: 5px; padding-left: 20px; color: #666;">
                                                                                ราคา</p>
                                                                            <v-text-field type="number" value="0.00"
                                                                                placeholder="0.00" single-line hide-details
                                                                                outlined color="none"
                                                                                style="padding-top: 0; margin-top: 0; width: 100%; background-color: #fafafa; font-size: 18px;"
                                                                                v-model="item_price">
                                                                            </v-text-field>
                                                                        </div>
                                                                        <div class="col-md-3 col-sm-5 col-xs-12"
                                                                            style="padding: 0;">
                                                                            <p
                                                                                style="font-size: 15px; width: 100%; margin-bottom: 5px; padding-left: 20px; color: #666;">
                                                                                จำนวน</p>
                                                                            <v-text-field type="number" placeholder="0"
                                                                                single-line hide-details outlined color="none"
                                                                                style="padding-top: 0; margin-top: 0; width: 100%; background-color: #fafafa; font-size: 18px;"
                                                                                v-model="item_quantities">
                                                                            </v-text-field>
                                                                        </div>

                                                                    </div>

                                                                    <div class="row" style="padding-top: 20px;">
                                                                        <div class="col-md-3 col-sm-5 col-xs-12"
                                                                            style="padding: 0; padding-right: 25px;">
                                                                            <p
                                                                                style="font-size: 15px; width: 100%; margin-bottom: 5px; padding-left: 20px; color: #666;">
                                                                                น้ำหนัก</p>
                                                                            <v-text-field type="number" placeholder="0.00"
                                                                                single-line hide-details outlined color="none"
                                                                                style="padding-top: 0; margin-top: 0; width: 100%; background-color: #fafafa; font-size: 18px;"
                                                                                v-model="gram_weight" @keyup="convertWeight">
                                                                            </v-text-field>
                                                                            <p
                                                                                style="font-size: 15px; width: 100%; margin-top: 5px; padding-right: 20px; color: #666; text-align: right;">
                                                                                กรัม</p>

                                                                        </div>
                                                                        <div class="col-md-3 col-sm-5 col-xs-12"
                                                                            style="padding: 0; position: relative;">
                                                                            <span
                                                                                style="position: absolute; margin: 37.5px -18px; font-size: 26px;">=</span>
                                                                            <p
                                                                                style="font-size: 15px; width: 100%; margin-bottom: 5px; padding-left: 20px; color: #666;">
                                                                                น้ำหนัก</p>
                                                                            <v-text-field type="number" placeholder="0.00"
                                                                                single-line hide-details outlined color="none"
                                                                                style="padding-top: 0; margin-top: 0; width: 100%; background-color: #fafafa; font-size: 18px;"
                                                                                v-model="item_weight" disabled>
                                                                            </v-text-field>
                                                                            <p
                                                                                style="font-size: 15px; width: 100%; margin-top: 5px; padding-right: 20px; color: #666; text-align: right;">
                                                                                กิโลกรัม</p>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </v-card-text>

                                                        <v-card-actions class="flex justify-center">
                                                            <v-btn outlined
                                                                style="width: 200px; height: 45px ; padding-top: 15px; font-size: 18px;"
                                                                @click="close">
                                                                <p>ยกเลิก</p>
                                                            </v-btn>
                                                            <v-btn outlined
                                                                style="width: 200px; height: 45px ; padding-top: 15px; font-size: 18px; background-color: #1d8649; color: white;"
                                                                @click="addItemToSQLL">
                                                                <p>บันทึก</p>
                                                            </v-btn>
                                                        </v-card-actions>
                                                    </v-card>
                                                </v-dialog>
                                            </div>
                                        </div>
                                        <v-data-table hide-default-header v-model="selected" :headers="headers" :items="item"
                                            :single-select="singleSelect" item-key="name" :search="search" :page.sync="page"
                                            :items-per-page="`${select.itemsPerPage}`" text-left hide-default-footer
                                            @page-count="pageCount = $event" style="width: 100%;">
                                            <template v-slot:item="{ item }" slot-scope="props">
                                                <tr @click="addItem(item)">
                                                    <td class="text-xs-left d-flex"
                                                        style="height: 72px; border-bottom: 1px solid rgba(0,0,0,.18); padding: 12px 24px; width: 100% !important; text-align: left; font-size: 15px !important; padding-top: 0;">
                                                        <div class="row" style="padding-top: 0;">
                                                            <div class="col-xs-9 col-sm-10 row-pointer">
                                                                {{ item.name }}<br>
                                                                Type : {{ item.type }}
                                                            </div>
                                                            <div class="col-xs-3 col-sm-2" style="text-align: right;">
                                                                <p style="float: right;">{{ item.price }} ฿</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </template>
                                        </v-data-table>
                                        <div class="text-center pt-2">
                                            <v-pagination color="green darken-3" style="box-shadow: none" v-model="page"
                                                :length="pageCount"></v-pagination>
                                            <div style="float: right; position: absolute; right: 0px; top: 240px;">
                                                <p
                                                    style="float: right; position: absolute; right: 70px; white-space: nowrap; top: 10px; font-size: 12px;">
                                                    แสดงจำนวนต่อหน้า</p>
                                                <v-select v-model="select" :items="items" item-text="itemsPerPage"
                                                    label="Select" return-object single-line text-left
                                                    style="width: 60px; float: left; padding-top: 0;"></v-select>
                                            </div>
                                        </div>

                                    </v-card-text>

                                </v-card>
                            </v-dialog>

                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <v-btn style="overflow: hidden; padding-top: 0; box-shadow: none !important;
                                                    font-size: 16px !important;
                                                    padding-top: 15px !important;
                                                    background-color: rgb(170, 194, 127) !important;
                                                    color: white !important;
                                                    border-radius: 6px !important;
                                                    margin-left: 10px;
                                                    float:right" @click="addCustomerToSQL">
                                <p>บันทึก</p>
                            </v-btn>
                        <v-text-field class="border-grey" hide-details single-line
                                            outlined dense color="none"
                                            placeholder="ยอมรวม"
                                            style="padding-top: 0; margin-top: 0; width: 225px; background-color: #fafafa; font-size: 16px; float:right"
                                            disabled>
                                        </v-text-field>


                        </div>
                    </div>
                </div>
            </div>

            <div :lazy="lazy" v-if="is_Customer_Active" v-model="is_Customer_Active" transition="fade-transition"
                style=" padding: 50px 30px; font-family: 'Sarabun', sans-serif;">

                <div class="row" style="height: 50px;">
                    <div class="col-md-6 col-sm-4 col-xs-12">
                        <h2>ข้อมูลลูกค้า</h2>
                    </div>
                    <div class="col-md-6 col-sm-8 col-xs-12">
                        <v-text-field v-model="search" prepend-inner-icon="mdi-magnify"
                            placeholder="ชื่อ-นามสกุล หรือเบอร์โทรศัพท์"
                            single-line hide-details outlined dense
                            style="margin-left: auto; padding-top: 0; margin-top: 0; width: 100%; background-color: white;"></v-text-field>
                    </div>
                </div>

                <div class="row" style="width: 100%; margin-right: 0px; margin-top: 15px; padding-left: 12px;">
                    <v-card
                        style="width: 100%; padding: 0px; box-shadow: 0 0 10px rgba(0,0,0,.1); border-radius: 5px; padding-bottom: 10px;">
                        <v-data-table class="black-table table-border" v-model="selected" :headers="customer_headers"
                            :items="customer_item" :single-select="singleSelect" item-key="name" :search="search"
                            :page.sync="page" :items-per-page="`${select.itemsPerPage}`" text-left
                            hide-default-footer @page-count="pageCount = $event">
                        </v-data-table>
                        <div class="text-center pt-2">
                            <v-pagination circle color="black" style="box-shadow: none" v-model="page"
                                :length="pageCount"></v-pagination>
                            <div style="float: right; position: absolute; right: 5px; bottom: -15px;">
                                <p
                                    style="float: left; position: absolute; right: 70px; white-space: nowrap; top: 10px;">
                                    จำนวนรายการต่อหน้า</p>
                                <v-select v-model="select" :items="items" item-text="itemsPerPage" label="Select"
                                    return-object single-line text-left
                                    style="width: 60px; float: left; padding-top: 0;"></v-select>
                            </div>
                        </div>
                    </v-card>
                </div>

            </div>

            <div class="row wrap col-md-12 col-lg-9 col-xl-8" :lazy="lazy" v-if="is_Deep_Overview_Active"
                v-model="is_Deep_Overview_Active" transition="fade-transition"
                style="padding-top: 55px; margin: 0 auto; padding: 55px 50px; font-family: 'Sarabun', sans-serif;">

                <div class="col-lg-6">

                <v-dialog v-model="details" max-width="500px" max-height="95vh">
                                        <template v-slot:activator="{ on, attrs }">
                                        <p style="margin-bottom: 15px; font-size: 25px">ภาพรวมอย่างละเอียด<v-btn icon v-bind="attrs" v-on="on"
                                                style="margin-bottom: 8px; margin-right: 10px;">
                                                <span
                                                    style="width: 22.5px; height: 22.5px;background-color: #424143; color: #fff; border-radius: 10px; padding: 0 .4rem; font-size: 15px;">i</span>
                                            </v-btn></p>

                                        </template>
                                        <v-card style="font-family: 'Sarabun', sans-serif;">
                                            <v-card-title style="background-color: rgb(29, 134, 73); padding: 5px 8px;">
                                                <p style="font-size: 16px; margin-bottom: 0px; color: white;">
                                                    ภาพรวมอย่างละเอียด<span
                                                        style="background-color: white; color:#08a7a3; border-radius: 10px; padding: 0 .6rem; margin-left: 2.5px">i</span></p>
                                            </v-card-title>

                                            <v-card-text
                                                style=" color: black; padding: 30px 15px; font-size: 18px;">
                                            <p>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                                                ภาพรวมอย่างละเอียดนี้ แสดงภาพรวมของร้านที่คุณกำลังเลือกอยู่ หากต้องการเลือกร้านอื่นๆ
                                                ให้กดที่ชื่อ shop และเลือกร้านนั้นๆ หากต้องการ ร้านทั้งหมดให้เลือก ร้านทั้งหมด</p>

                                            </v-card-text>

                                            <v-card-actions class="flex justify-center"
                                                style="border-top   : 1px solid rgba(0, 0, 0, .1);">
                                                <v-btn outlined
                                                    style="width: 90px; height: 38px ; padding-top: 15px; font-size: 15px; background-color: rgb(29, 134, 73); color: white;"
                                                    @click="close">
                                                    <p>ปิด</p>
                                                </v-btn>
                                            </v-card-actions>
                                        </v-card>
                                    </v-dialog>
                    <v-card tile
                        style="width: 100%; height: ; margin-bottom: 25px; box-shadow: 0 0 15px rgba(0, 0, 0, 0.2)">
                        <div>
                            <p
                                style="font-size: 23px; padding: 15px; margin-bottom: 0; padding-bottom: 10px;text-align:center;">
                                Item Quantities Graph</p>
                            <ve-pie :data="quantitiesData" :settings="rosePie"></ve-pie>
                        </div>
                    </v-card>

                    <v-card tile
                        style="width: 100%; height: ; margin-bottom: 25px; box-shadow: 0 0 15px rgba(0, 0, 0, 0.2)">
                        <div>
                            <p
                                style="font-size: 23px; padding: 15px; margin-bottom: 0; padding-bottom: 10px;text-align:center;">
                                Item Price Graph</p>
                            <ve-bar :data="priceData" :settings="barSetting"></ve-bar>
                        </div>
                    </v-card>


                </div>
                <div class="col-lg-6" style="padding-top: 72px">
                <v-card tile
                        style="width: 100%; height: ; margin-bottom: 25px; box-shadow: 0 0 15px rgba(0, 0, 0, 0.2)">
                        <div>
                            <p
                                style="font-size: 23px; padding: 15px; margin-bottom: 0; padding-bottom: 10px;text-align:center;">
                                Item Type Graph</p>
                            <ve-pie :data="typeData"></ve-pie>
                        </div>
                    </v-card>

                    <v-card tile
                        style="width: 100%; height: ; margin-bottom: 25px; box-shadow: 0 0 15px rgba(0, 0, 0, 0.2)">
                        <div>
                            <p
                                style="font-size: 23px; padding: 15px; margin-bottom: 0; padding-bottom: 10px;text-align:center;">
                                Item Weight Graph</p>
                            <ve-bar :data="weightData"></ve-bar>
                        </div>
                    </v-card>

                </div>
            </div>

        </div>

    </v-app>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/v-charts/lib/index.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/v-charts/lib/pie.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/v-charts/lib/bar.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/v-charts/lib/style.min.css">
    <script>
        new Vue({
            el: "#app",
            vuetify: new Vuetify(),
            data: () => ({
                rosePie:{
                    roseType:'radius'
                },
                barSetting:{
                    dimension:['name'],
                    metrics:['price']
                },
                quantitiesData:{
                    columns:['name', 'quantities'],
                    rows:<?php getQuantity();?>
                },
                typeData:{
                    columns:['type', 'quantities'],
                    rows:<?php getItemType();?>
                },
                priceData:{
                    columns:['name', 'price'],
                    rows:<?php getPrice();?>
                },
                weightData:{
                    columns:['name', 'weight'],
                    rows:<?php getWeight();?>
                },
                tab: null,
                lazy: false,
                search: '',
                dialog: false,
                addItemWindow: false,
                dialogDelete: false,
                details:false,
                description:false,
                is_Overview_Active: false,
                is_Deep_Overview_Active: true,
                is_Manage_Product_Active: false,
                is_Orders_Active: false,
                is_Create_Orders_Active: false,
                is_Customer_Active: false,
                item_name: '',
                item_type: '',
                item_price: '',
                item_weight: '',
                item_quantities: '',
                gram_weight: '',
                customer_name: '',
                customer_contact: '',
                customer_address: '',
                customer_tel: '',
                customer_tel_opt: '',
                customer_province: '',
                customer_district: '',
                customer_subdistrict: '',
                customer_postcode: '',
                customer_sum_price: '',
                page: 1,
                pageCount: 0,
                select: { itemsPerPage: 10, },
                items: [
                    { itemsPerPage: 10, },
                    { itemsPerPage: 25, },
                    { itemsPerPage: 50, },
                    { itemsPerPage: 100, },
                ],
                singleSelect: false,
                selected: [],
                headers: [
                    {
                        text: 'ID',
                        align: 'start',
                        filterable: false,
                        value: 'id',
                    },
                    { text: 'ชื่อ', value: 'name' },
                    { text: 'ราคา/บาท', value: 'price' },
                    { text: 'น้ำหนัก', value: 'weight', filterable: false, },
                    { text: 'ชนิด', value: 'type' },
                    { text: 'จำนวน', value: 'quantities', filterable: false, },
                ],
                item: <?php echo getItem();?>,
                orders_headers: [
                    {
                        text: 'เลขออเดอร์',
                        align: 'start',
                        sortable: false,
                        value: 'order_number',
                    },
                    { text: 'เลขแทรคกิ้ง', value: 'track_number' },
                    { text: 'เบอร์โทร', value: 'phone_number' },
                    { text: 'ชื่อลูกค้า', value: 'customer_name' },
                    { text: 'ราคา', value: 'price', filterable: false, },
                    { text: 'การชำระเงิน', value: 'payment', filterable: false, },
                    { text: 'วันที่สร้าง', value: 'create_date', filterable: false, },
                ],
            orders_item: <?php getOrder();?>,
            create_orders_headers: [
                {
                    text: 'ชื่อสินค้า',
                    align: 'center',
                    value: 'item_name',
                },
                { text: 'จำนวน', align: 'center', value: 'quantity' },
                { text: 'ราคา', align: 'center', value: 'price' },
                { text: 'ชนิดสินค้า', align: 'center', value: 'type' },
                { text: 'รวม', align: 'center', value: 'all_price' },
                { text: 'ลบ', align: 'center', value: 'delete' },
            ],
            create_orders_item: [
                {
                    item_name: "หห",
                    quantity: 1,
                    type: 'asd',
                    price: 201,
                    all_price: 5,
                },
            ],
            customer_headers: [
                    {
                        text: "ชื่อลูกค้า",
                        align: 'start',
                        value: 'customer_name',
                    },
                    { text: 'เบอร์โทรศัพท์', value: 'customer_phone' },
                    { text: 'ที่อยู่ลูกค้า', value: 'customer_address', filterable: false, },
                    { text: 'ตำบล/แขวง', value: 'customer_district', filterable: false, },
                    { text: 'อำเภอ/เขต', value: 'customer_sub_district', filterable: false, },
                    { text: 'จังหวัด', value: 'customer_province', filterable: false, },
                    { text: 'รหัสไปรษณีย์', value: 'customer_postcode', filterable: false, },

                ],
            customer_item: <?php getCustomer();?>,
            tag_items: [],
            price_items: ["เปลี่ยนได้", "เปลี่ยนไม่ได้"],
            editedIndex: -1,
            editedItem: {
                photo: '',
                name: '',
                code: '',
                price: 0,
                weight: 0,
                tag: '',
                amount: 0,
                booking: 0,
            },
            defaultItem: {
                photo: '',
                name: '',
                code: '',
                price: 0,
                weight: 0,
                tag: '',
                amount: 0,
                booking: 0,
            },
            customer_name_rules: [
                v => !!v || 'ยังไม่ได้กรอกชื่อลูกค้า',
            ],
        }),
        components:{VePie, VeBar},
            methods: {
            to_Overview() {
                this.is_Overview_Active = true;
                this.is_Deep_Overview_Active = false;
                this.is_Manage_Product_Active = false;
                this.is_Orders_Active = false;
                this.is_Create_Orders_Active = false;
                this.is_Customer_Active = false;
            },
            to_Deep_Overview() {
                this.is_Overview_Active = false;
                this.is_Deep_Overview_Active = true;
                this.is_Manage_Product_Active = false;
                this.is_Orders_Active = false;
                this.is_Create_Orders_Active = false;
                this.is_Customer_Active = false;
            },
            to_ManageProduct() {
                this.is_Overview_Active = false;
                this.is_Deep_Overview_Active = false;
                this.is_Manage_Product_Active = true;
                this.is_Orders_Active = false;
                this.is_Create_Orders_Active = false;
                this.is_Customer_Active = false;
            },
            to_Orders() {
                this.is_Overview_Active = false;
                this.is_Deep_Overview_Active = false;
                this.is_Manage_Product_Active = false;
                this.is_Orders_Active = true;
                this.is_Create_Orders_Active = false;
                this.is_Customer_Active = false;
            },
            to_Create_Orders() {
                this.is_Overview_Active = false;
                this.is_Deep_Overview_Active = false;
                this.is_Manage_Product_Active = false;
                this.is_Orders_Active = false;
                this.is_Create_Orders_Active = true;
                this.is_Customer_Active = false;
            },
            to_Customer() {
                this.is_Overview_Active = false;
                this.is_Deep_Overview_Active = false;
                this.is_Manage_Product_Active = false;
                this.is_Orders_Active = false;
                this.is_Create_Orders_Active = false;
                this.is_Customer_Active = true;
            },
            deleteItem(item) {
                this.create_orders_item.splice(this.create_orders_item.indexOf(item), 1)
            },
            convertWeight(){
                this.item_weight = this.gram_weight / 1000;
            },
            close(){
                if (this.dialog) {
                    this.dialog = false;
                }
                else if (this.addItemWindow) {
                    this.addItemWindow = false;
                }
                else if (this.details){
                    this.details = false;
                }
                else if (this.description){
                    this.description = false;
                }
                this.$nextTick(() => {
                    this.editedItem = Object.assign({}, this.defaultItem);
                    this.editedIndex = -1;
                    this.item_weight = 0;
                    this.item_price = 0;
                    this.item_name = '';
                    this.item_type = '';
                    this.gram_weight = 0;
                })
            },
            itemToFormData: function(e) {
                let formdata = new FormData();
                formdata.append('item_name', this.item_name);
                formdata.append('item_type', this.item_type);
                formdata.append('item_price', this.item_price);
                formdata.append('item_weight', this.item_weight);
                formdata.append('item_quantities', this.item_quantities);
                return formdata;
            },
            randomOrderNumber(){
                return Math.floor(Math.random() * 99999999) + 10000000;
            },
            randomTrackNumber(){
                return Math.floor(Math.random() * 999999999999) + 100000000000;
            },
            getSumPrice(){
                let sum = 0;
                for (var i = 0; i < this.create_orders_item.length; i++) {
                    sum += this.create_orders_item[i].all_price;
                }
                console.log(sum);
                return sum;
            },
            orderToFormData: function(e) {
                let formdata = new FormData();
                formdata.append('order_number', this.randomOrderNumber());
                formdata.append('track_number', this.randomTrackNumber());
                formdata.append('contact', this.customer_contact);
                formdata.append('telephone_opt', this.customer_tel_opt);
                formdata.append('telephone', this.customer_tel);
                formdata.append('name', this.customer_name);
                formdata.append('price', this.getSumPrice());
                formdata.append('method', "COD");
                formdata.append('address', this.customer_address);
                formdata.append('subdistrict', this.customer_subdistrict);
                formdata.append('district', this.customer_district);
                formdata.append('province', this.customer_province);
                formdata.append('postcode', this.customer_postcode);
                return formdata;

            },
            addItemToSQLL: function(e) {
                e.preventDefault();
                let item = this.itemToFormData();
                const options = {
                    method: 'POST',
                    headers: { 'content-type': 'application/form-data' },
                    data: item,
                    url: "assets/php/addItemToSQL.php",
                };
                axios(options).then(
                    function (response) {
                        if (response.data) {
                            this.close();
                            window.location.href = "user.php";

                        }
                    }
                ).catch(err => console.log(err));
            },
            addItemToSQL: function(e) {
                e.preventDefault();
                let item = this.itemToFormData();
                const options = {
                    method: 'POST',
                    headers: { 'content-type': 'application/form-data' },
                    data: item,
                    url: "assets/php/addItemToSQL.php",
                };
                axios(options).then(
                    function (response) {
                        if (response.data) {
                            this.close();
                            window.location.href = "user.php";
                        }
                    }
                ).catch(err => console.log(err));
            },
            addCustomerToSQL: function(e) {
                e.preventDefault();
                let customer = this.orderToFormData();
                const options = {
                    method: 'POST',
                    headers: { 'content-type': 'application/form-data' },
                    data: customer,
                    url: "assets/php/addCustomer.php",
                };
                axios(options).then(
                    function (response) {
                        if (response.data) {
                            this.close();
                            window.location.href = "user.php";
                        }
                    }
                ).catch(err => console.log(err));

            },
            addItem: function(item) {
                this.close();
                console.log(item);
                this.create_orders_item.push({
                    item_name: item.name,
                    quantity: 1,
                    type: item.type,
                    price: item.price,
                    all_price: item.price,
                });
                console.log(item);
            },
            calculatePrice: function(item) {
                item.all_price = item.quantity * item.price;
            },
            logout(){
                window.location.href = "assets/php/logout.php";
            }
        }
        })
    </script>
</body>

</html>
