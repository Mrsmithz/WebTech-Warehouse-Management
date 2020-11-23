<?php
session_start();
if (isset($_SESSION['firstname'])){
    echo '<script type="text/javascript">',
     'window.location.href = "user.php"',
     '</script>';
}
?>
<!DOCTYPE html>
<html>
<head>
    <script src="https://unpkg.com/vue-router/dist/vue-router.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui" />
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Kanit', sans-serif;
        }

        #inspire {
            background: #ebf8f1 url(img/Login/bg.png) no-repeat padding-box;
            background-size: cover;
            display: flex;
            justify-content: center;
            min-height: 100vh;
            padding-top: 130px;
        }

        .v-tab--active {
            background-color: white;
            color: black !important;
        }

        .tabs{
            width: 50%;
            font-size: 25px;
            padding: 10px 0px;
            font-size: 20px;
            font-weight: 400;
        }

        .tabs-item{
            padding:35px;
            padding-top: 60px;
        }

        @media screen and (max-width:600px) {
            .card-main {
                width: 95% !important;
            }

            .tabs-item{
                padding: 5px !important;
                padding-top: 60px !important;
            }

            #inspire{
                padding-top: 40px !important;
            }
        }

        .bottom_button{
            margin-right: 10px;
        }

        p.bottom_button{
            margin-top: 15px;
            font-size: 16px !important;
            font-weight: 500;
        }

        .v-messages__message{
            margin-top: 15px;
            margin-bottom: 2px;
            font-size: 14.75px !important;
            font-weight: 400 !important;
        }

        .login_button{
            width: 100% ;
            margin-top: 50px;
            height: 42.5px !important;
            background-color: rgb(29, 134, 73) !important;
            border-color: rgb(29, 134, 73); color: white !important;
        }

        .other_button{
            width: 100%;
            margin-top: 24px !important;
            height: 40px !important;
        }

    </style>
</head>
<body>
    <div id="app">
        <v-app id="inspire">
            <img style="width: 228px; margin: 0 auto;" src="img/Login/icon.png">
            <v-card class="mx-auto card-main" style="width: 440px; margin-top: 28px;">
                <v-tabs background-color="grey lighten-5" light v-model="active_tab" >
                    <v-tabs-slider color="#1d8649"></v-tabs-slider>
                    <!-- <v-tab class="tabs">เข้าสู่ระบบ</v-tab>
                    <v-tab class="tabs">สมัครสมาชิก</v-tab> -->
                    <v-tab v-for="tab of tabs" :key="tab.id" class="tabs">
                        {{tab.name}}
                    </v-tab>
                </v-tabs>
                <v-tabs-items v-model="active_tab" class="tabs-item">
                    <v-tab-item>
                        <div class="col-md-12">
                            <v-form ref="form" v-model="login" lazy-validation id="login_form" @submit="sendForm">
                                <v-text-field v-model="email" :rules="emailRules" color="red" name="login_email"required id="login_email">
                                    <template v-slot:label>
                                        <div style="font-weight: 300; font-size: 18px;">
                                          อีเมล
                                        </div>
                                      </template>
                                </v-text-field>

                                <v-text-field v-model="password" :type="show1 ? 'text' : 'password'" :rules="passRules" name="login_pass" color="red" required style="margin-top: 10px;" id="login_pass">
                                    <template v-slot:label>
                                        <div style="font-weight: 300; font-size: 18px;">
                                          รหัสผ่าน
                                        </div>
                                      </template>
                                </v-text-field>

                                <v-btn class="login_button" :disabled="!valid" fill-height class="mr-4" type="submit" id="submitbtn">
                                    <p class="bottom_button">LOG IN</p>
                                </v-btn>

                                <v-btn color="blue darken-2"
                                    class=" white--text bottom_button other_button" @click="checkStatus" style="padding-left: 20px">
                                    <i class="v-icon v-icon--left fa fa-facebook" aria-hidden="true" style="font-size: 22px;"></i>
                                    <p class="bottom_button">CONTINUE WITH FACEBOOK</p>
                                </v-btn>

                                <v-btn color="white"
                                    class="bottom_button other_button" @click="" style="color: black;">
                                    <svg width="20" height="20" viewBox="0 0 200 200" style="margin-right: 12.5px;">
                                        <image width="200" height="200" xlink:href="img/search.svg"/>
                                    </svg>
                                    <p class="bottom_button">CONTINUE WITH GOOGLE</p>
                                </v-btn>

                                <v-btn color="black"
                                    class=" white--text bottom_button other_button" @click="" style="width: 100%; margin-top: 24px; height: 40px; ">
                                    <i class="v-icon v-icon--left fa fa-apple" aria-hidden="true" style="font-size: 18px;"></i>
                                    <p class="bottom_button">CONTINUE WITH APPLE</p>
                                </v-btn>

                                <v-btn
                                    class="v-btn--flat v-btn--text theme--light bottom_button other_button" @click="" style="color: black; box-shadow: none; font-size: 5px; margin-bottom: 20px;">
                                    <p class="bottom_button" style="color: rgb(29, 134, 73);">ลืมรหัสผ่าน</p>
                                </v-btn>

                            </v-form>
                        </div>
                    </v-tab-item>
                    <v-tab-item>
                        <div class="col-md-12">
                            <v-form ref="register_form" v-model="register" lazy-validation @submit="sendRegis">

                                <v-text-field v-model="register_username" color="red" label="Username" :rules="r_usernameRules" name="r_username" required></v-text-field>

                                <div class="row">
                                    <div class="col-md-6">
                                        <v-text-field v-model="register_firstname" color="red" label="ชื่อ"  :rules="r_firstnameRules" name="r_firstname" required></v-text-field>
                                    </div>
                                    <div class="col-md-6">
                                        <v-text-field v-model="register_lastname" color="red" label="นามสกุล" :rules="r_lastnameRules" name="r_lastname" required></v-text-field>
                                    </div>
                                </div>

                                <v-text-field v-model="register_telephone" color="red" label="เบอร์โทรศัพท์" :rules="r_telRules" name="r_tel" required></v-text-field>

                                <v-text-field v-model="register_email" color="red" label="อีเมล" :rules="r_emailRules" name="r_email" required></v-text-field>

                                <v-text-field v-model="register_password" color="red" label="รหัสผ่าน" :rules="r_passRules" :type="show1 ? 'text' : 'password'" name="r_password" required></v-text-field>

                                <v-btn :disabled="!valid" fill-height color="success" class="mr-4"
                                    style="width: 100% ; margin-top: 20px; height: 40px;" type="submit">
                                    <p class="bottom_button">SIGN UP</p>
                                </v-btn>

                            </v-form>
                        </div>
                    </v-tab-item>
                </v-tabs-items>
            </v-card>
        </v-app>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
    <script>
        new Vue({
            el: "#app",
            vuetify: new Vuetify(),
            data() {
                return {
                    register:true,
                    login:false,
                    check: false,
                    active_tab: this.checkStatus(),
                    tabs:[
                        {id:1, name:'เข้าสู่ระบบ'},
                        {id:2, name:'สมัครสมาชิก'}
                    ],
                    valid: true,
                    show1: false,
                    items: ["One", "Two"],
                    text:
                        "L  orem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
                    email: '',
                    emailRules: [
                        v => !!v || 'กรุณากรอกอีเมล',
                        v => /.+@.+\..+/.test(v) || 'กรุกณากรอกอีเมลให้ถูกต้อง',
                    ],
                    password: '',
                    passRules: [
                        v => !!v || 'กรุณากรอกรหัสผ่าน',
                        v => (v && v.length >= 8) || 'กรุณากรอกรหัสผ่านมากกว่า 8 ตัว',
                    ],
                    register_username: '',
                    r_usernameRules:[
                        v => !!v || 'กรุณากรอกชื่อผู้ใช้',
                        v => (v && v.length >= 6 && /[a-zA-Z0-9]+/.test(v)) || 'ชื่อผู้ใช้ต้องมีตัวอักษรอย่างน้อย 6 ตัว'
                    ],
                    register_firstname: '',
                    r_firstnameRules:[
                        v => !!v || 'กรุณากรอกชื่อ',
                        v => (v && v.length >= 4 && /^[a-zA-Zก-ฮ]+/.test(v)) || 'กรุณากรอกชื่อให้ถูกต้่อง'
                    ],
                    register_lastname: '',
                    r_lastnameRules:[
                        v => !!v || 'กรุณากรอกนามสกุล',
                        v => (v && v.length >= 4 && /^[a-zA-Zก-ฮ]+/.test(v)) || 'กรุณากรอกนามสกุลให้ถูกต้อง'
                    ],
                    register_telephone: '',
                    r_telRules:[
                        v => !!v || 'กรุณากรอกหมายเลขโทรศัทพ์',
                        v => (v && v.length == 10 && /^0[0-9]{9}/.test(v)) || 'กรุณากรอกหมายเลขโทรศัพท์ให้ถูกต้อง'
                    ],
                    register_email: '',
                    r_emailRules:[
                        v => !!v || 'กรุณากรอกอีเมลล์',
                        v => (v && /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(v)) || 'กรุณากรอกอีเมลล์ให้ถูกต้อง'
                    ],
                    register_password: '',
                    r_passRules:[
                        v => !!v || 'กรุณากรอกรหัสผ่าน',
                        v => (v && v.length >= 8 && /^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=])(?=\S+$).{8,}$/.test(v)) || 'รหัสผ่านต้องประกอบด้้วย อักษรตัวใหญ่ อักษรตัวเล็ก ตัวเลข อักษรพิเศษ และต้องมีความยาวอย่างน้อย 8 ตัว'
                    ],
                };
            },
            methods: {
                checkStatus(){
                    let val = localStorage.getItem('status');
                    if (val == "login"){
                        return 0;
                    }
                    else if (val == "register"){
                        return 1;
                    }
                },
                validate() {
                    this.$refs.form.validate()
                    console.log(this.password)
                },
                signup_validate(){
                    this.$refs.register_form.validate()
                    console.log(this.register_username)
                },
                checkAcct:function(e){
                    e.preventDefault();
                    console.log("fucntion called");
                    var request = this.$http.get("/assets/php/LoginTest.php",
                    function(data, status, request){
                        console.log(data);
                    })
                },
                RegistoFormData:function(){
                    let formdata = new FormData();
                    formdata.append("r_username", this.register_username);
                    formdata.append("r_firstname", this.register_firstname);
                    formdata.append("r_lastname", this.register_lastname);
                    formdata.append("r_email", this.register_email);
                    formdata.append("r_password", this.register_password);
                    formdata.append("r_tel", this.register_telephone);
                    return formdata;
                },
                toFormData:function(){
                    let formdata = new FormData();
                    formdata.append("email", this.email);
                    formdata.append("password", this.password);
                    return formdata;
                },
                sendForm:function(e){
                    e.preventDefault();
                    let account = this.toFormData();
                    const options = {
                        method:'POST',
                        headers:{'content-type':'application/form-data'},
                        data:account,
                        url:"assets/php/LoginTest.php",
                    };
                    axios(options).then(
                        function(response){
                            if (response.data){
                                window.location.href = "user.php";
                            }
                        }
                    ).catch(err => console.log(err));
                },
                sendRegis:function(e){
                    e.preventDefault();
                    let account = this.RegistoFormData();
                    const options = {
                        method:'POST',
                        headers:{'content-type':'application/form-data'},
                        data:account,
                        url:"assets/php/register.php",
                    };
                    axios(options).then(
                        function(response){
                            if (response.data){
                                window.location.href = "login.php";
                                console.log(response.data)
                            }
                        }
                    ).catch(err => console.log(err));
                },

            },
        });
    </script>
</body>

</html>
