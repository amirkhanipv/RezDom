<?php
include_once __DIR__.DIRECTORY_SEPARATOR."db.php";
$DB = new DB();
$error=null;

if(isset($_COOKIE['remembr']))
{
    $DB->Forcelogin($_COOKIE['remembr']);
}

if(isset($_SESSION['login']['status'])){
    header('Location:panel.php');
}


if(isset($_POST['submit'])){

    $Name = trim($_POST['FirstName']);
    $Lastname = trim($_POST['LastName']);
    $UserName = trim($_POST['UserName']);
    $Email = trim($_POST['Email']);
    $Password = trim($_POST['Password']);
    if(!empty($Name) && !empty($Lastname)&&
    !empty($UserName) && !empty($Email) && !empty($Password))
    {
        
       $result =  $DB->AddToDb($Name,$Lastname,$UserName,$Email,$Password);
       if($result){
        header('Location:login.php');
       }
        
    }
    else{
        $error='!لطفا تمامی فیلد ها را کامل کنید';
    }
    
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="utf-8" />   <title>RezDom |ثبت نام</title>
        <meta name="author" content="AmirKhani" />
        <!-- favicon -->
        <link rel="shortcut icon" href="images/a_add.png">
        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Icons -->
        <link href="css/materialdesignicons.min.css" rel="stylesheet" type="text/css" />

        <!-- Main Css -->
        <link href="css/style-dark.min.css" rel="stylesheet" type="text/css" id="theme-opt" />
        <link href="css/colors/purple.css" rel="stylesheet" id="color-opt">
    </head>

    <body>


        <div class="back-to-home rounded d-none d-sm-block">
        <a href="./" class="btn btn-secondary"><i class="mdi mdi-home"></i></a>
        </div>
        
        <!-- Show ON -->
        <section class="bg-home bg-circle-gradiant d-flex align-items-center">
            <div class="bg-overlay bg-overlay-white"></div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-8"> 
                        <div class="card shadow rounded border-0 mt-4">
                            <div class="card-body">
                                <h4 class="card-title text-center">ثبت نام </h4>  
                                <form class="login-form mt-4" method="POST">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">نام<span class="text-danger">*</span></label>
                                                <div class="form-icon position-relative">
                                                    <i data-feather="user" class="fea icon-sm icons"></i>
                                                    <input type="text" class="form-control ps-5" placeholder="نام " name="FirstName" required="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3"> 
                                                <label class="form-label">نام خانوادگی  <span class="text-danger">*</span></label>
                                                <div class="form-icon position-relative">
                                                    <i data-feather="user-check" class="fea icon-sm icons"></i>
                                                    <input type="text" class="form-control ps-5" placeholder="نام خانوادگی" name="LastName" required="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">نام کاربری<span class="text-danger">*</span></label>
                                                <div class="form-icon position-relative">
                                                    <i data-feather="user" class="fea icon-sm icons"></i>
                                                    <input type="text" class="form-control ps-5" placeholder="نام کاربری" name="UserName" required="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">ایمیل شما <span class="text-danger">*</span></label>
                                                <div class="form-icon position-relative">
                                                    <i data-feather="mail" class="fea icon-sm icons"></i>
                                                    <input type="email" class="form-control ps-5" placeholder="ایمیل" name="Email" required="">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">رمز عبور  <span class="text-danger">*</span></label>
                                                <div class="form-icon position-relative">
                                                    <i data-feather="key" class="fea icon-sm icons"></i>
                                                    <input type="password" class="form-control ps-5" placeholder="رمز عبور " name="Password" required="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="d-grid">

                                              <input name="submit" type="submit" class="btn btn-primary" value="ثبت نام">
    
                                            </div>
                                        </div><!--end col-->
                                        <div class="mx-auto">
                                            <p class="mb-0 mt-3"><small class="text-dark me-2">قبلاً حساب دارید؟</small> <a href="./Login.php" class="text-dark fw-bold">وارد شوید </a></p>
                                        </div>
                                    </div><!--end row-->
                                </form>
                            </div>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div> <!--end container-->
        </section><!--end section-->
       
        <script src="js/feather.min.js"></script>
        <script src="js/app.js"></script>
   
    </body>

</html>
