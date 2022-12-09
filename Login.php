<?php
include_once __DIR__.DIRECTORY_SEPARATOR."db.php";
$DB = new DB();
$error='';

if(isset($_COOKIE['remembr']))
{
    $DB->Forcelogin($_COOKIE['remembr']);
}

if(isset($_SESSION['login']['status'])){
    header('Location:panel.php');
}


if(isset($_POST['submit'])){

    $UserName = trim($_POST['UserName']);
    $Password = trim($_POST['Password']);
    if(!empty($UserName) && !empty($Password))
    {
        $getAccount = $DB->CheckAcc($UserName);
        if(!$getAccount)
        {
            $error='!نام کاربری نادرست است';
        }
        else
        {
            if(password_verify($Password,$getAccount->Password))
            {
                $_SESSION['login']=array(
                    'status'=>true,
                    'info'=>$getAccount,
                );
 
                if(isset($_POST['rememberme'])){
                    $token = $DB->getRememberMEToken($UserName);
                    if($token){
                        setcookie('remembr',$token,time()+(60*5));
                    }
                }

                header('Location:panel.php');

            }else
            {
                $error='!رمز عبور نادرست است';
            }
        }
    }
    else{
        $error='!نام کاربری و یا رمز عبور نمیتواند خالی باشد';
    }
    
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="utf-8" />   <title>RezDom | ورود</title>
        <meta name="author" content="AmirKhani" />
        <!-- favicon -->
        <link rel="shortcut icon" href="images/a_add.png">
        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Icons -->
        <link href="css/materialdesignicons.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="unicons.iconscout.com/release/v3.0.6/css/line.css">
        <!-- Main Css -->
        <link href="css/style-dark.min.css" rel="stylesheet" type="text/css" id="theme-opt" />
        <link href="css/colors/purple.css" rel="stylesheet" id="color-opt">
    </head>

    <body>


        <div class="back-to-home rounded d-none d-sm-block">
            <a href="./" class="btn btn-icon btn-primary"><i data-feather="home" class="icons"></i></a>
        </div>
        
        <!-- Show ON -->
        <section class="bg-home bg-circle-gradiant d-flex align-items-center">
            <div class="bg-overlay bg-overlay-white"></div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-8"> 
                        <div class="card login-page bg-white shadow rounded border-0">
                            <div class="card-body">
                                <h4 class="card-title text-center">وارد شدن </h4>  
                                <form class="login-form mt-4" method="POST">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label class="form-label">نام کاربری <span class="text-danger">*</span></label>
                                                <div class="form-icon position-relative">
                                                    <i data-feather="user" class="fea icon-sm icons"></i>
                                                    <input type="text" class="form-control ps-5" placeholder="نام کاربری" name="UserName" required="">
                                                </div>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label class="form-label">رمز عبور  <span class="text-danger">*</span></label>
                                                <div class="form-icon position-relative">
                                                    <i data-feather="key" class="fea icon-sm icons"></i>
                                                    <input type="password" class="form-control ps-5" placeholder="رمز عبور " name="Password" required="">
                                                </div>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-lg-12">
                                            <div class="d-flex justify-content-between">
                                                <div class="mb-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rememberme" id="flexCheckDefault">
                                                        <label class="form-check-label" for="flexCheckDefault">مرا به خاطر بسپار </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-lg-12 mb-0">
                                            <div class="d-grid">
                                            
                                            <input name="submit" type="submit" class="btn btn-primary" value="ورود">
    
                                            </div>
                                        </div><!--end col-->

                                    </div><!--end row-->
                                </form>
                            </div>
                        </div><!---->
                    </div><!--end col-->
                </div><!--end row-->
            </div> <!--end container-->
        </section><!--end section-->
        <!-- End On -->


        <!-- javascript -->
        <script src="js/bootstrap.bundle.min.js"></script>
        <!-- Icons -->
        <script src="js/feather.min.js"></script>
        <!-- Switcher -->
        <script src="js/switcher.js"></script>
        <!-- Main Js -->
        <script src="js/plugins.init.js"></script><!--Note: All init js like tiny slider, counter, countdown, maintenance, lightbox, gallery, swiper slider, aos animation etc.-->
        <script src="js/app.js"></script><!--Note: All important javascript like page loader, menu, sticky menu, menu-toggler, one page menu etc. -->
    </body>

</html>