<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMS Booking</title>
    <link rel="icon" type="image/x-icon" href="<?php echo site_url(); ?>/asset/image/logo.ico">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/38215a61ca.js" crossorigin="anonymous"></script>
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo site_url(); ?>asset/dist/css/adminlte.min.css">
    <!-- Custom -->
    <link rel="stylesheet" href="<?php echo site_url(); ?>asset/custom.css">

    <!-- jQuery -->
    <script src="<?php echo site_url(); ?>/asset/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo site_url(); ?>/asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery UI -->
    <script src="<?php echo site_url(); ?>/asset/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Vue -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2.7.14"></script>
    <!-- BlockUI -->
    <script src="<?php echo site_url(); ?>/asset/dist/js/jquery.blockUI.js"></script>

    <style>
        body {
            background: #222D32;
            font-family: 'Roboto', sans-serif;
        }

        .login-box {
            margin: auto;
            margin-top: 45px;
            height: auto;
            background: #1A2226;
            text-align: center;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
        }

        .login-key {
            height: 100px;
            font-size: 80px;
            line-height: 100px;
            background: -webkit-linear-gradient(#27EF9F, #0DB8DE);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .login-title {
            margin-top: 15px;
            text-align: center;
            font-size: 30px;
            letter-spacing: 2px;
            margin-top: 15px;
            font-weight: bold;
            color: #ECF0F5;
        }

        .login-form {
            margin-top: 25px;
            text-align: left;
        }

        input[type=text] {
            background-color: #1A2226;
            border: none;
            border-bottom: 2px solid #0DB8DE;
            border-top: 0px;
            border-radius: 0px;
            font-weight: bold;
            outline: 0;
            margin-bottom: 20px;
            padding-left: 0px;
            color: #ECF0F5;
        }

        input[type=password] {
            background-color: #1A2226;
            border: none;
            border-bottom: 2px solid #0DB8DE;
            border-top: 0px;
            border-radius: 0px;
            font-weight: bold;
            outline: 0;
            padding-left: 0px;
            margin-bottom: 20px;
            color: #ECF0F5;
        }

        .form-group {
            margin-bottom: 40px;
            outline: 0px;
        }

        .form-control:focus {
            border-color: inherit;
            -webkit-box-shadow: none;
            box-shadow: none;
            border-bottom: 2px solid #0DB8DE;
            outline: 0;
            background-color: #1A2226;
            color: #ECF0F5;
        }

        input:focus {
            outline: none;
            box-shadow: 0 0 0;
        }

        label {
            margin-bottom: 0px;
        }

        .form-control-label {
            font-size: 10px;
            color: #6C6C6C;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .btn-outline-primary {
            border-color: #0DB8DE;
            color: #0DB8DE;
            border-radius: 0px;
            font-weight: bold;
            letter-spacing: 1px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
        }

        .btn-outline-primary:hover {
            background-color: #0DB8DE;
            right: 0px;
        }

        .login-btm {
            float: left;
        }

        .login-button {
            padding-right: 0px;
            text-align: right;
            margin-bottom: 25px;
        }

        .login-text {
            text-align: left;
            padding-left: 0px;
            color: #A2A4A4;
        }

        .loginbttm {
            padding: 0px;
        }
    </style>
</head>

<body>
    <div class="container" id="vApp" v-cloak>
        <!-- Modal -->
        <div class="modal fade" id="forgotPasswordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document" style="overflow-y:auto;">
                <div class="modal-content" style="height:100%;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">Get reset password via email</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="overflow-y:auto;">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <small>
                                        <font color="red">*</font> Username
                                    </small>
                                    <input type="text" class="form-control" style="margin-top:-3px; padding-left:10px;" v-model="forgot_password.username">
                                </div>
                                <div class="col-md-12">
                                    <small>
                                        <font color="red">*</font> Email
                                    </small>
                                    <input type="text" class="form-control" style="margin-top:-3px; padding-left:10px;" v-model="forgot_password.email">
                                </div>
                            </div>
                            <div class="row" style="margin-top:15px">
                                <div class="col-md-12" style="text-align:center">
                                    <button class="btn" style="width:250px; height:30px; line-height:9px; background-color:#809f4e; color:white;" @click="forgotPassword()">Reset Password & Send Email</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 login-box">
                <div class="col-lg-12 login-key">
                    <i class="fa fa-key" aria-hidden="true"></i>
                </div>
                <div class="col-lg-12 login-title">
                    SMS Booking Admin Panel
                </div>

                <div class="col-lg-12 login-form">
                    <div class="col-lg-12 login-form">
                        <form>
                            <div class="form-group">
                                <label class="form-control-label">USERNAME</label>
                                <input type="text" class="form-control" v-model="username">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">PASSWORD</label>
                                <input type="password" class="form-control" i v-model="password">
                                <div class="text-right" style="margin-top:-18px; text-decoration:underline;">
                                    <a href="#" data-toggle="modal" data-target="#forgotPasswordModal">forgot password?</a>
                                </div>
                            </div>

                            <div class="col-lg-12 loginbttm">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 login-btm login-text" style="margin-top:-33px; color:red; font-weight:bold;">
                                    {{ error_message }}
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 login-btm login-button">
                                    <button type="submit" class="btn btn-outline-primary" @click.prevent="login()">LOGIN</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-3 col-md-2"></div>
            </div>
        </div>
    </div>
</body>

<script>
    $(document).ready(function() {
        app = new Vue({
            el: '#vApp',
            data: {
                username: '',
                password: '',
                error_message: '',
                forgot_password: {
                    'username': '',
                    'email': ''
                }
            },
            mounted() {},
            methods: {
                login: function(v) {
                    let self = this;
                    let param = {
                        username: this.username,
                        password: this.password
                    };

                    $.post("<?php echo user_auth_url(); ?>", param, function(res) {
                        if (res.result == 'false') {
                            self.error_message = res.message;
                            return;
                        } else {
                            window.location = "<?php echo home_url(); ?>";
                        }
                    });
                },
                forgotPassword: function() {
                    $.blockUI({
                        css: {
                            'backgroundColor': '#d9d9d9',
                            'padding-top': '10px'
                        }
                    });
                    $.post("<?php echo forgot_password_url(); ?>", this.forgot_password, function(res) {
                        if (res.result == 'false') {
                            alert(res.message);
                            $.unblockUI();
                            return;
                        } else {
                            alert('Reset Password & Send Email Success');
                            location.reload();
                        }
                    });
                }
            }
        });
    });
</script>

</html>