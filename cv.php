
<?php

include_once __DIR__ . DIRECTORY_SEPARATOR . "DB.php";
$DB = new DB();

$cv = null;
$username = "";
$_user="";

if (isset($_GET['user'])) {

    $username = $_GET['user'];
    if (!empty($username)) {

        $user = $DB->CheckAcc($username);
        if($user!=false){
            $_user = $user;
            $userid = $user->ID;
            $cv = $DB->GetCVByID($userid);

            if($cv==false)
            {
                header('Location:index.php');
            }

        }else
        {
            header('Location:index.php');
        }
        
    }else
    {
        header('Location:index.php');
    }

}else
{
    header('Location:index.php');
}


?>

<!DOCTYPE html>
    <html lang="en">

    
<head>
        <title>RezDom </title>
        <meta name="author" content="AmirKhani" />
        <!-- favicon -->
        <link rel="shortcut icon" href="images/favicon.ico">
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
  
        
        <header id="topnav" class="defaultscroll sticky">
            <div class="container">
                <!-- Logo container-->
                <div>
                    <a class="logo" href="index.html">
                        <img src="images/a_add.png" height="39" alt="">
                    </a>
                </div>                 
                <div class="buy-button">

                    <a href="./" class="btn btn-secondary"><i class="mdi mdi-home"> </i>صفحه اصلی</a>
                </div>
        
               
            </div><!--end container-->
        </header><!--end header-->
        
        <!-- Hero Start -->
        <section class="bg-profile d-table w-100 bg-primary" style="background: url('images/account/bg.png') center center;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card public-profile border-0 rounded shadow" style="z-index: 1;">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-lg-2 col-md-3 text-md-start text-center">
                                        <img src="images/client/05.jpg" class="avatar avatar-large rounded-circle shadow d-block mx-auto" alt="">
                                    </div><!--end col-->
    
                                    <div class="col-lg-10 col-md-9">
                                        <div class="row align-items-end">
                                            <div class="col-md-7 text-md-start text-center mt-4 mt-sm-0">
                                                <h3 class="title mb-0"><?php 
                                                if($cv->Gender=="male"){
                                                    echo("آقای ");  
                                                }else if($cv->Gender=="female"){
                                                    echo("خانم ");  
                                                }
                                                echo($_user->FirstName . " " . $_user->LastName);  
                                                ?>
                                                </h3>
                                              <div style="padding-top:10px;">
                                                <?php $sps = explode("|", $cv->Specialties);
                                                foreach($sps as $sp){
                                        
                                                 ?>
                                                <li class="list-inline-item m-1"><a href="jvascript:void(0)" class="rounded bg-light py-1 px-2 text-muted small"><?php echo($sp);?></a></li>
                                                <?php  }?>
                                             </div>
                                            </div><!--end col-->
                                            
                                        </div><!--end row-->
                                    </div><!--end col-->
                                </div><!--end row-->
                            </div>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--ed container-->
        </section><!--end section-->
        <!-- Hero End -->

        <!-- Profile Start -->
        <section class="section mt-60">
            <div class="container mt-lg-3">
                <div class="row">
    
                    <div class="col-12" style="">
                        <div class="border-bottom pb-4">
                            <h5>درباره من</h5>
                            <p class="text-muted mb-0"><?php echo($cv->About);  ?></p>
                        </div>
                        
                        <div class="border-bottom pb-4">
                            <div class="row">

                                <div class="col-md-6 mt-4">
                                    <h5>جزئیات شخصی :</h5>
                                    <div class="mt-4">
                                        <div class="d-flex align-items-center">
                                            <i data-feather="mail" class="fea icon-ex-md text-muted me-3"></i>
                                            <div class="flex-1">
                                                <h6 class="text-primary mb-0">ایمیل :</h6>
                                                <a href="javascript:void(0)" class="text-muted"><?php echo($_user->Email);  ?></a>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mt-3">
                                            <i data-feather="user" class="fea icon-ex-md text-muted me-3"></i>
                                            <div class="flex-1">
                                                <h6 class="text-primary mb-0">سن :</h6>
                                                <a href="javascript:void(0)" class="text-muted"><?php echo($cv->Age);  ?></a>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mt-3">
                                            <i data-feather="italic" class="fea icon-ex-md text-muted me-3"></i>
                                            <div class="flex-1">
                                                <h6 class="text-primary mb-0">سابقه کاری :</h6>
                                                <a href="javascript:void(0)" class="text-muted"><?php echo($cv->YWR);  ?></a>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mt-3">
                                            <i data-feather="globe" class="fea icon-ex-md text-muted me-3"></i>
                                            <div class="flex-1">
                                                <h6 class="text-primary mb-0">شماره تماس :</h6>
                                                <a href="javascript:void(0)" class="text-muted"><?php echo($cv->Phone);  ?></a>
                                            </div>
                                        </div>
                                
                                        <div class="d-flex align-items-center mt-3">
                                            <i data-feather="map-pin" class="fea icon-ex-md text-muted me-3"></i>
                                            <div class="flex-1">
                                                <h6 class="text-primary mb-0">تخصص ها :</h6>
                                                <?php $sps = explode("|", $cv->Specialties);
                                                foreach($sps as $sp){
                                        
                                                 ?>
                                                <li class="list-inline-item m-1"><a href="jvascript:void(0)" class="rounded bg-light py-1 px-2 text-muted small"><?php echo($sp);?></a></li>
                                                <?php  }?>
                                            </div>
                                        </div>
                               
                                    </div>
                                </div><!--end col-->
                    
                            </div><!--end row-->
                        </div>

              
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->
        </section><!--end section-->
        <!-- Profile End -->



        <footer class="footer footer-bar">
            <div class="container text-center">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="text-sm-start">
                            <p class="mb-0">موفق باشید! مدیرسایت: امیرعباس خانی</p>
                        </div>
                    </div><!--end col-->

                    <div class="col-sm-6 mt-4 mt-sm-0 pt-2 pt-sm-0" >
                        <ul class="list-unstyled text-sm-end mb-0">
                            <li class="list-inline-item" style="margin-left: 5px;"><a href="https://www.instagram.com/amirkhani_gsm/"><img src="images/insta.png" class="avatar avatar-ex-sm" title="instagram" alt=""></a></li>
                            <li class="list-inline-item"><a href="https://t.me/amirkhani_pv"><img src="images/tele.png" class="avatar avatar-ex-sm" title="telegram" alt=""></a></li>

                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->
        </footer><!--end footer-->





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