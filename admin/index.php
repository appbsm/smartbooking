<?php
	session_start();
	error_reporting(0);

	include('includes/config_company.php');

	// include('includes/config.php');
	// if($_SESSION['alogin']!=''){
	// $_SESSION['alogin']='';
	// }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Broker System</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            /*background-color: #f5f5f5;*/
			background-color: #102958;
        }
        .login-box {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .login-box img {
            width: 200px;
        }
        .login-box h1 {
            margin: 20px 0;
            font-size: 24px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        .form-group {
            position: relative;
        }
        .form-control-feedback {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
        }
        .btn-login {
            background-color: #0275d8;
            color: white;
            padding: 10px 24px;
            border-radius: 5px;
            border: none;
            transition: background-color 0.3s;
        }
        .btn-login:hover {
            background-color: #025aa5;
        }
    </style>
	<script>
        function showAlert(text) {
            Swal.fire({
                // title: 'Hello!',
                // text: 'This is a custom alert without URL',
                text: text,
                icon: 'info',
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'my-confirm-button'
                }
            });
        }
    </script>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <img src="logo_s.png" alt="Logo" height="120px" style="width: 170px;" >
            <h1>Smart Booking Admin Panel</h1>
            <!-- action="<?php echo determineLoginUrl(); ?>" -->
            <!-- http://192.168.20.22/smartbooking_admin/demo/user2/auth -->

            <form id="loginForm" method="post" action="" >
                <div class="form-group has-feedback">
                    <input type="text" id="code_company" name="code_company" class="form-control" placeholder="CompanyCode"  required>
                    <span class="form-control-feedback"><i class="fas fa-building"></i></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="text" id="username" name="username" value="" class="form-control" placeholder="Username" required>
                    <span class="form-control-feedback"><i class="fas fa-user"></i></span>
                </div>
                <div class="form-group has-feedback">

					<input minlength="8" maxlength="20" type="password" id="password" name="password" value="" class="form-control" placeholder="Password" required>
                    <span  toggle="#password" class="form-control-feedback fa fa-fw fa-eye-slash field-icon toggle-password"><span>
                </div>

                <div class="form-group">
                    <input type="text" id="company" name="company" class="form-control" readOnly>
                </div>
                <div class="form-group">
                    <input hidden="true" type="text" id="url" name="url" class="form-control" readOnly>
                </div>


                <div class="form-group" style="display: flex; justify-content: space-between;">
                    <a href="forgot_password.php" style="color: #4590B8;">Forget Password</a>

                    <button type="submit" name="login" class="btn btn-login" style="background-color:#0275d8;" >Login</button>
                </div>
            </form>

    <script>
        document.querySelectorAll('.toggle-password').forEach(function(icon) {
            icon.addEventListener('click', function() {
                var target = document.querySelector(this.getAttribute('toggle'));
                if (target.type === 'password') {
                    target.type = 'text';
                    this.classList.remove('fa-eye-slash');
                    this.classList.add('fa-eye');
                } else {
                    target.type = 'password';
                    this.classList.remove('fa-eye');
                    this.classList.add('fa-eye-slash');
                }
            });
        });
    </script>

<?php
    function determineLoginUrl() {
        // $url = $_POST['url'];
        // return $url;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // echo '<script>alert("url: '.$_POST['url'].'")</script>'; 
            $_POST['url'] = 'http://192.168.20.22/smartbooking_admin/demo/user2/auth';
            return $_POST['url']; // คืนค่า URL ที่ได้รับจากฟิลด์ "url"
        } else {
            return ''; // หรือให้คืนค่าเป็น URL เริ่มต้นที่ต้องการ
        }

        // echo '<script>alert("url: '.$_POST['url'].'")</script>'; 
        // return $_POST['url'];
    }
?>


            <script>
                // function validateForm() {
                //     var url = document.getElementById("url").value;
                //     alert('url:'+url);
                //     if (!url) {
                //         alert("Your company code incorrect.");
                //         return false;
                //     }
                //     return url;
                //     // return true;
                // }
                // function validateForm() {
                //     var company_value = document.getElementById("company").value;
                //     if (company_value!="") {
                //         // document.getElementById("loading-overlay").style.display = "flex";
                //         return true;
                //     }else{
                //         // alert("Please enter the correct company code.");
                //         showAlert("Your company code incorrect.");
                //         return false;
                //     }
                // }
            </script>

            <script>
                var company_object = document.getElementById("code_company");
                company_object.addEventListener("change", function() {
                    $.get('get_company_name.php?code_company=' + $(this).val().toUpperCase(), function(data){
                        var result = JSON.parse(data);
                        $.each(result, function(index, item){
                            document.getElementById("company").value = item.company_name;
                            document.getElementById("url").value = item.path_web;
                            var form = document.getElementById('loginForm');
                            form.action = item.path_web;
                        });

                    });
                });
            </script> 

			<script>
				// document.querySelectorAll('.toggle-password').forEach(function(icon) {
				// 	icon.addEventListener('click', function() {
				// 		var target = document.querySelector(this.getAttribute('toggle'));
				// 		if (target.type === 'password') {
				// 			target.type = 'text';
				// 			this.classList.remove('fa-eye-slash');
				// 			this.classList.add('fa-eye');
				// 		} else {
				// 			target.type = 'password';
				// 			this.classList.remove('fa-eye');
				// 			this.classList.add('fa-eye-slash');
				// 		}
				// 	});
				// });

				// function valid() {
				// 	var password = document.forms["chngpwd"]["password"].value;
				// 	var confirmPassword = document.forms["chngpwd"]["confirmpassword"].value;

				// 	// เงื่อนไขสำหรับตรวจสอบรหัสผ่าน
				// 	var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

				// 	if (!regex.test(password)) {
				// 		var text = "Your password is not strong, please using the following criteria:\n"+
				// 			"1.The password must have a minimum of 8 characters.\n"+
				// 			"2.It must include at least 1 uppercase letter.\n"+
				// 			"3.It must include at least 1 lowercase letter.\n"+
				// 			"4.It must include at least 1 digit.\n"+
				// 			"5.It must include at least 1 special character (e.g., @, !, #, $).";
				// 		alert(text);
				// 		return false;
				// 	}

				// 	if (password !== confirmPassword) {
				// 		//alert("รหัสผ่านและยืนยันรหัสผ่านไม่ตรงกัน");
				// 		alert("Your Password do not match.");
				// 		return false;
				// 	}
				// }
			</script>
        </div>
    </div>
    
</body>
</html>
<!-- ========== COMMON JS FILES ========== -->
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/jquery-ui/jquery-ui.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>

        <!-- ========== PAGE JS FILES ========== -->

        <!-- ========== THEME JS ========== -->
        <script src="js/main.js"></script>

        <!-- ========== ADD custom.js FILE BELOW WITH YOUR CHANGES ========== -->
    </body>
</html>

<?php   
    if(isset($_GET['message'])){
        if($_GET['message']=='false'){
            $text ='Your username or password invalid.';
            echo '<script>',
            'showAlert("'.$text.'");',
            '</script>';
        }
    }

//     if(isset($_POST['login'])){

//     $uname=$_POST['username'];
//     $password=md5($_POST['password']);

//     $sql_com ="SELECT user_info.* 
//      FROM user_info 
//      left join company_list cl ON cl.id = user_info.id_company
//      WHERE username = '".$_POST['username']."' and user_info.status = '1' and  cl.company_code = '".$_POST['code_company']."'  ";
//     $queryl_com = $dbh -> prepare($sql_com);
//     $queryl_com-> execute();
//     $results=$queryl_com->fetchAll(PDO::FETCH_OBJ);

//     if($queryl_com->rowCount() > 0){

//         $sql ="SELECT user_info.* 
//          FROM user_info WHERE username=:uname and user_info.status = '1' ";
//         $query= $dbh -> prepare($sql);
//         $query-> bindParam(':uname', $uname, PDO::PARAM_STR);
//         $query-> execute();
//         $results=$query->fetchAll(PDO::FETCH_OBJ);

//         if($query->rowCount() > 0){

//             $sql ="SELECT cl.id as id_company,cl.path_web,user_info.* 
//              FROM user_info
//              LEFT JOIN company_list cl ON cl.id = user_info.id_company
//              WHERE username=:uname and password=:password and user_info.status = '1' and cl.company_code ='".$_POST['code_company']."' ";
//             $query= $dbh -> prepare($sql);
//             $query-> bindParam(':uname', $uname, PDO::PARAM_STR);
//             $query-> bindParam(':password', $password, PDO::PARAM_STR);
//             $query-> execute();
//             $results=$query->fetchAll(PDO::FETCH_OBJ);

//             if($query->rowCount() > 0){
                
//                 foreach($results as $result){
//                     $id = $result->id;
//                     $id_company = $result->id_company;
//                     $path_web = $result->path_web;
//                 }

//                 $sql_insert="INSERT INTO  login_history(user_id,company_id,login_time) VALUES(".$id.",".$id_company.",GETDATE())";
//                 // echo '<script>alert("sql_insert: '.$sql_insert.'")</script>'; 
//                 $query_insert = $dbh->prepare($sql_insert); 
//                 $query_insert->execute();

//                 $dbh = null;
//                 echo "<script>window.location.href ='".$path_web."?username=".$uname."&password=".$password."&company_code=".$_POST['code_company']."'</script>";
//             }else{
//                 $text ='Your username or password invalid.';
//                 echo '<script>',
//                 'showAlert("'.$text.'");',
//                 '</script>';
//             }

//         }else{
//             $text ='Your username or password invalid.';
//             echo '<script>',
//             'showAlert("'.$text.'");',
//             '</script>';
//         }
//     }else{
//         $text = 'The company code and username do not match.';
//         echo '<script>',
//              'showAlert("'.$text.'");',
//              '</script>';
//     }   

// }

?>

<?php $dbh = null; ?>