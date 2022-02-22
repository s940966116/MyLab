<template>
    <div class="body">
        <div class="login-container">

            <div class="mode-select">
                <div class="{modeActive: isactive_1}" @click="setMode(1)">普通登入</div>
                <div class="{modeActive: isactive_2}" @click="setMode(2)">mode 2</div>
            </div>

            <div v-if="mode == 1" class="login-frame">
                <div class="login-text">
                    <div class="login-title">登入</div>

                    <div class="login-user">
                        <div>
                            <label for="user_name">帳號</label>
                        </div>
                        <div>
                            <input @keyup.enter="userLogin" id="user_name" v-model="user_name" type="email" placeholder="請輸入帳號" autocomplete="off" spellcheck="false">
                        </div>
                    </div>
                    <br>
                    <div class="login-passwd">
                        <div>
                            <label for="user_password">密碼</label>
                        </div>
                        <div>
                            <input @keyup.enter="userLogin" id="user_password" :class="{'hide-password':!hide}" v-model="user_password" type="text" placeholder="請輸入密碼" autocomplete="off" spellcheck="false">
                        </div>
                    </div>

                    <div class="show-passwd">
                        <input type="checkbox" v-model='hide'>
                        <span style="font-size: 18px;">顯示密碼</span>
                    </div>

                    <div class="vcode-area">
                        <div>
                            <span>驗證碼</span>
                        </div>
                        <div style="line-height: 56px;">
                            <input @keyup.enter="userLogin" v-model="vcode" class="vcode-input" type="text" placeholder="驗證碼">
                        </div>
                        <div>
                            <img id="vcode" src="getCaptcha/1" alt="vcode">
                        </div>
                    </div>

                    <div class="change-vcode">
                        <div>
                            <span @click="changeVcode">換一張驗證碼</span>
                        </div>
                    </div>

                    <div class="show-error">
                        <span v-if="show_error">*請輸入正確資訊</span>
                    </div>
                </div>

                <div class="button-group">
                    <input @click="userLogin" type="button" value="登入"><br>
                </div>
            </div>

            <div class="qrcode-login-frame" v-else>
                <img src="images/invisible.svg" alt="">
            </div>
        </div>
    </div>
</template>

<script>
    import $ from "jquery";
    import swal from "sweetalert2";

    export default {
        data(){
            return {
                user_name: "",
                user_password: "",
                show_error: false,
                hide: false,
                mode: 1,
                vcode: "",
                isactive_1: true,
                isactive_2: false,
            }
        },
        methods: {
            //使用者登入
            userLogin: function(){
                var upper = this;
                if(this.user_name == "" || this.user_password == "" || this.vcode == ""){
                    this.show_error = true;
                    return;
                }else{
                    this.show_error = false;
                }

                axios.post("checkLogin",{
                    name: this.user_name,
                    password: this.user_password,
                    vcode: this.vcode
                }).then(function(response) {
                    if(response.data.status == "success"){
                        upper.$router.push("home");
                    }else{
                        var date = new Date();
                        $("#vcode").attr("src","getCaptcha/" + date.getTime());
                        swal.fire({
                            icon: "error",
                            title: "login fail",
                            text: response.data.message,
                        })
                    }
                }).catch(function(error) {
                    swal.fire({
                        icon: "error",
                        title: "login fail",
                        text: error,
                    })
                })
            },
            //設定模式
            setMode: function(mode){
                this.mode = mode;
            },
            //更換驗證碼
            changeVcode: function(){
                var date = new Date();
                $("#vcode").attr("src","getCaptcha/" + date.getTime());
            },
        },
    }
</script>

<style scoped>
    .body{
        background-color: silver;
        background-image: url("https://cdn.hk01.com/di/media/images/3473061/org/1bf4d6b616bbccfef6f66e0034acd376.jpg/Ua8QqShySKlijPxMEgIQg1zmLJvMWX0lTw6L4U8Oi-E?v=w1920");
        background-size: cover;
        padding: 10px;
    }

    .login-container {
        font-size: 22px;
        color: white;
        width: 40%;
        margin: auto;
        background-color: black;
        opacity: 0.7;
        border-radius: 4px;
        text-align: center;
    }

    .login-title {
        font-size:26px;
        margin-top: 10px;
    }

    .login-user {
        display: inline-flex;
        margin-top: 40px;
    }

    .login-user label {
        line-height: 56px;
        margin-right: 10px;
    }

    .login-passwd{
        display: inline-flex;
        margin-top: 20px;
    }

    .login-passwd label {
        line-height: 56px;
        margin-right: 10px;
    }

    #user_name, #user_password {
        width: 95%;
        font-size: 20px;
        margin: 10px 0;
        border-radius: 6px;
        padding: 5px 5px;
    }

    .mode-select div{
        font-size: 30px;
        cursor: pointer;
        float:left;
        width: 50%;
        height: 58px;
        line-height: 58px;
    }

    .mode-select div:hover{
        background-color: dimgray;
    }

    .login-frame{
        clear: both;
        margin-top: 70px;
        border-top: 1px solid white;
    }

    .show-passwd{
        text-align: left;
        position: relative;
        left: 30%;
    }

    .show-passwd input[type="checkbox"]{
        border-radius: 4px;
        height: 16px;
        width: 16px;
    }

    .hide-password{
        -webkit-text-security:disc;
    }

    .button-group{
        margin-top: 20px;
    }

    .button-group input{
        font-size: 20px;
        border-radius: 4px;
        width:24%;
        margin-top: 20px;
        padding: 4px;
        margin-bottom: 20%;
    }

    .vcode-area{
        display: inline-flex;
        height: 56px;
        line-height: 56px;
        margin-top: 20px;
    }

    .vcode-input{
        border-radius: 4px;
        width: 128px;
        font-size: 20px;
        margin: 0 10px;
        padding: 5px;
    }

    .vcode-area img{
        margin-top: 10px;
    }

    .change-vcode{
        font-size: 16px;
        text-align: left;
        position: relative;
        left: 30%;
    }

    .change-vcode span{
        cursor: pointer;
    }

    .show-error{
        margin-top: 20px;
    }

    .modeActive{
        background-color: dimgray;
    }

    @media screen and (min-width:721px) and (max-width:930px){
        .login-container{
            width: 50%;
        }
    }

    @media screen and (min-width:525px) and (max-width:720px){
        .login-container{
            width: 70%;
        }
    }

    @media screen and (min-width:0px) and (max-width:524px){
        .login-container{
            width: 100%;
        }

        .vcode-input{
            width: 120px;
        }

        .show-passwd{
            left: 20%;
        }

        .change-vcode{
            left: 25%;
        }
    }
</style>