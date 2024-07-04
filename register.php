<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="16x16" href="images/10.png">
    <title>smsmartbooking Sign In</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0;
        width: 100%;
        height: 100%;
        max-width: 100%;
        margin-top: 40px;
        
    }

    .container {
        background-color: #fff;
        padding: 16px 30px 24px;
        position: relative;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        width: 400px;
        text-align: center;
        max-width: 100%;
        margin: 0 15px;
    }

    h3 {
        /* margin-bottom: 20px; */
        color: #333;
    }

    h6 {
        /* margin-bottom: 20px; */
        color: #666;
    }

    input[type="email"],input[type="firstname"],input[type="lastname"],
    input[type="password"] {
        width: 100%;
        padding: 10px;
        /* margin: 10px 0; */
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    /* Adjusting label width to match input width */
    label {
        display: block;
        text-align: left;
        margin-bottom: 0px;
        margin-top: 5px;
        font-weight: 500;
        font-size: 16px;
    }

    button {
        width: 100%;
        padding: 10px;
        background-color: #5392f9;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s;
    }

    button:hover {
        background-color: #3a73d4;
    }

    .tabs ul {
        list-style-type: none;
        padding: 0;
        display: flex;
        justify-content: center;
    }

    .tabs li {
        /* margin: 0 10px; */
        margin: 0;
    }

    .tabs span {
        color: #5392f9;
        cursor: pointer;
    }

    .tabs .active {
        font-weight: bold;
    }

    .password-container {
        display: flex;
        align-items: center;
    }

    .password-container input {
        flex: 1;
    }

    .password-container {
        position: relative;
    }

    .toggle-password {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        cursor: pointer;
    }

    .toggle-password i {
        font-size: 16px;
        color: #999;
    }

    .toggle-password.active i {
        color: #5392f9; 
    }

    .footer-links {
        /* display: block; */
        display: flex;
        justify-content: space-between;
        font-size: 14px;
        line-height: 20px;
        font-weight: 400;
    }
    .footer-links a {
        /* display: block; */
        display: flex !important;
        justify-content: space-between;
        align-items: center;
        margin: 10px 0;
        color: #5392f9;
        text-decoration: none;
    }

    .footer-links a:hover {
        text-decoration: underline;
    }

    .social-login {
        margin: 16px 0;
    }

    .social-buttons {
        display: flex;
        justify-content: space-between;
    }

    .social-buttons button {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 48%;
        padding: 10px;
        /* margin: 5px 0; */
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
        color: rgb(83, 146, 249);
        font-size: 14px;
        line-height: 20px;
        font-weight: 500;
    }
    .social-buttons button img {
        margin-right: 10px;
    }
    .social-buttons button:hover {
        background-color: #f5f5f5;
    }

    .terms-policy {
        margin-top: 20px;
        font-size: 12px;
        color: #666;
    }
    .terms-policy a {
        color: #5392f9;
        text-decoration: none;
    }
    .terms-policy a:hover {
        text-decoration: underline;
    }

    .forget-svg * {
        fill: rgb(83, 146, 249);
    }

    .tx-signin {
        font-size: 24px ;
        line-height: 24px;
        font-weight: 500;
        margin: 0px;
        padding-bottom: 16px;
    }
    .tx-sub-signin {
        font-size: 14px;
        line-height: 20px;
        font-weight: 400;
        margin: 0px;
        margin-top: 8px;
    }

    .tab-signin {
        display: flex;
        flex-direction: row;
        padding: 0px;
        -webkit-box-pack: start;
        justify-content: flex-start;
    }
    .tab-email {
        flex: 1 1 0%;
        -webkit-box-align: center;
        align-items: center;
        cursor: pointer;
        display: flex;
        list-style-type: none;
        padding: 12px 8px;
        width: auto;
        border-bottom: 2px solid rgb(83, 146, 249);
        margin-bottom: -2px;
    }
    .tab-mobile {
        flex: 1 1 0%;
        -webkit-box-align: center;
        align-items: center;
        cursor: pointer;
        display: flex;
        list-style-type: none;
        padding: 12px 8px;
        width: auto;
        border-bottom: 1px solid rgb(221, 223, 226);
        margin-bottom: -1px;
    }

    
    .line-bt-signin {
        min-width: 1px;
        width: 100%;
        flex: 1 1 0%;
        margin: 0px;
        border-bottom: 1px solid rgb(221, 223, 226);
    }
    .or-signin {
        width: 100%;
        display: flex;
        text-align: center;
        -webkit-box-pack: center;
        justify-content: center;
        -webkit-box-align: center;
        align-items: center;
        position: relative;
        background-color: transparent;
        padding: 0px;
    }
    .line-or-signin {
        min-width: 1px;
        width: 100%;
        flex: 1 1 0%;
        margin: 0px;
        border-bottom: 1px solid rgb(221, 223, 226);
    }
    .tx-or-signin {
        font-size: 14px;
        line-height: 20px;
        font-weight: 400;
        margin-left: 8px;
        margin-right: 8px;
    }

    .icon-social {
        width: 20px;
        height: 20px;
    }

    .icon-flag {
        background-image: url(https://cdn6.agoda.net/images/desktop/bg-sprite-flags.png);
        background-repeat: no-repeat;
        display: inline-block;
        width: 16px;
        height: 16px;
        background-position: -176px -122px;
    }
    .button-mobile {
        background-color: unset !important;
        color: #000;
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }
    .button-mobile:hover {
        color: #000;
    }

    .signin-mobile {
        display: flex;
    }

    @media (min-width: 1200px) {
        .container {
            width: 40%;
        }
    }

    .tx-ck-agree  {
        font-size: 14px;
    }
    input[type=checkbox], input[type=radio] {
        margin: 4px 4px 0;
    }
    .ck-agree {
        width: 100%;
        display: flex;
        position: relative;
        -webkit-box-align: center;
        align-items: center;
        user-select: none;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.querySelector('.toggle-password');
        const passwordField = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            this.classList.toggle('active');
        });
    });
</script>
<body>
    <div class="container">
        <div class="login-panel">
            <div class="login-form">
                <div class="login-panel-title" style="text-align: left;">
                    <h3 class="tx-signin">Sign up</h3>
                </div>
                <div>
                    <div class="form-content form-email">
                        <form>
                            <div class="form-group">
                                <label for="email">First name</label>
                                <input type="firstname" id="email" name="email" placeholder="First name" required>
                            </div>
                            <div class="form-group">
                                <label for="Last name">Last name</label>
                                <input type="lastname" id="email" name="email" placeholder="Last name" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <div class="password-container">
                                    <input type="password" id="password" name="password" placeholder="Password" required>
                                    <span class="toggle-password"><i class="fas fa-eye-slash"></i></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div style="padding: 8px 0;">
                                    <label class="ck-agree">
                                        <input id="newsLetter" name="newsLetter" data-cy="newsLetter" type="checkbox" class="" checked="">
                                        <span class="tx-ck-agree">I agree to receive updates and promotions about Smsmartbooking and its affiliates or business&nbsp;partners via various channels, including WhatsApp. Opt out anytime. Read more in the Privacy Policy.</span>
                                    </label>
                                </div>
                            </div>
                            <button type="submit">Sign up</button>
                        </form>
                        <!-- <div class="footer-links">
                            <a href="#">Create account</a>
                            <a href="#">
                                <svg width="1em" height="1em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="forget-svg" style="padding-right: 4px;">
                                    <path d="M5.286 9.143V6.388A6.388 6.388 0 0 1 11.673 0h1.167a6.388 6.388 0 0 1 6.388 6.388 1 1 0 0 1-2 0A4.388 4.388 0 0 0 12.84 2h-1.167a4.388 4.388 0 0 0-4.387 4.388v2.755H19a2 2 0 0 1 2 2v10.714a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V11.143a2 2 0 0 1 2-2h.286zM13 17.829a3.001 3.001 0 1 0-2 0v2.15a1 1 0 1 0 2 0v-2.15zM11 15a1 1 0 1 1 2 0 1 1 0 0 1-2 0z"></path>
                                </svg>
                                Forgot password?
                            </a>
                        </div> -->
                    </div>
                </div>
                <div class="or-signin" style="margin-top: 8px;">
                    <div class="line-or-signin"></div>
                    <div style="margin-top: 8px;">
                        <span class="sc-fznZeY tx-or-signin">or sign in with</span>
                    </div> 
                    <div class="line-or-signin"></div>
                </div>
                <div class="social-login ">
                    <div class="social-buttons">
                        <button class="google">
                            <img src="https://cdn6.agoda.net/images/universal-login/google-logo-v2.svg" alt="Google" class="icon-social">Google
                        </button>
                        <button class="facebook">
                            <img src="https://cdn6.agoda.net/images/universal-login/facebook-logo.svg" alt="Facebook" class="icon-social">Facebook
                        </button>
                    </div>
                </div>
                <hr/>
                <div class="form-group">
                    <a href="signin.php">
                        <button type="submit">Already have an account? Sign in</button>
                    </a>
                </div>
                <div class="terms-policy">
                    <span>By signing in, I agree to Smsmartbooking's </span><br/>
                    <span>   
                        <a href="#" target="_blank">Terms of Use</a> and 
                        <a href="#" target="_blank">Privacy Policy</a>.
                    </span>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.tab-signin li');
            const forms = document.querySelectorAll('.form-content');

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    tabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');

                    const tabName = this.classList.contains('tab-email') ? 'email' : 'mobile';

                    forms.forEach(form => {
                        if (form.classList.contains(`form-${tabName}`)) {
                            form.style.display = 'block';
                        } else {
                            form.style.display = 'none';
                        }
                    });
                });
            });

            const togglePassword = document.querySelector('.toggle-password');
            const passwordField = document.getElementById('password');

            togglePassword.addEventListener('click', function() {
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                this.classList.toggle('active');
            });
        });
    </script>
</body>

</html>
</html>
