<?php
include_once __DIR__ . DIRECTORY_SEPARATOR . "DB.php";
$DB = new DB();

if(isset($_SESSION['login']['status'])){
    $UserName = $_SESSION['login']['info']->UserName;
    $user = $DB->CheckAcc($UserName);
}
$_cvs = $DB->GetCv();

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />   <title>RezDom | از رزومه تا استخدام</title>
        <meta name="author" content="AmirKhani" />
        <link rel="shortcut icon" href="images/a_add.png">
   
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
     
        <link href="css/materialdesignicons.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="unicons.iconscout.com/release/v3.0.6/css/line.css">
   
        <link href="css/style-dark.min.css" rel="stylesheet" type="text/css" id="theme-opt" />
        <link href="css/colors/purple.css" rel="stylesheet" id="color-opt">

    </head>

    <body>

        <!-- Navbar STart -->
        <header id="topnav" class="defaultscroll sticky">
            <div class="container">
                <!-- Logo container-->
                <div>
                    <a class="logo" href="index.html">
                        <img src="images/a_add.png" height="39" alt="">
                    </a>
                </div>                 
                <div class="buy-button">

                    <?php

                    if(!isset($_SESSION['login']['status'])){
                        echo('<a href="./login" class="btn btn-secondary"><i class="mdi mdi-account"> </i>ورود</a>
                        <a href="./register" class="btn btn-secondary"><i class="mdi mdi-account-plus"> </i>ثبت نام</a>');
                    }else
                    {
                        echo('<a href="./panel" class="btn btn-secondary"><i class="mdi mdi-card-account-details"> </i>داشبورد</a>');
                    }
                    
                    ?>
        
               
            </div><!--end container-->
        </header><!--end header-->
        <!-- Navbar End -->

        <!-- Hero Start -->
        <section class="bg-half-170 pb-0 bg-primary d-table w-100" style="background: url('images/bg2.png') center center;">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-7 col-md-6">
                        <div class="title-heading">
                            <h4 class="text-white-60">ما مشکل شمارا حل میکنیم!</h4>
                            <h4 class="heading text-white mb-3 title-dark"> بهترین سایت برای ارتباط<br> با برنامه نویسان</h4>
                            <p class="para-desc text-white-50"> میتونی رزومه خودتو داخل سایت ثبت کنی تا اشخاصی که بهت نیاز دارن پیدات کنن و باهات همکاری کنند. سایت ما رایگانه پس همین الان رزومتو ثبت کن!</p>
                            <div class="mt-4 pt-2">
                                <a href="./register.php" style="margin-bottom: 30px;;" class="btn btn-light">ثبت رزومه  <i class="mdi mdi-arrow-left"> </i></a>
                            </div>
                        </div>
                    </div><!--end col-->

                </div><!--end row-->
            </div> <!--end container-->
        </section><!--end section-->
        <!-- Hero End -->

        <section class="section">
        <div class="row justify-content-center" style="margin-top: -40px;margin-bottom:-40px;">
                    <div class="col-12 text-center">
                        <div class="section-title mb-4 pb-2">
                            <h4 class="title mb-4">آخرین رزومه ها</h4>
                         </div>
                    </div><!--end col-->
                </div><!--end row-->
            <div class="container">
                
                <div class="row">
                    <?php 
                    foreach($_cvs as $cv) { 
                        $_user = $DB->GetUser($cv->UserID);
                        ?>
                    <div class="col-lg-4 col-md-6 col-12 mt-4 pt-2">
                        <div class="candidate-list card rounded border-0 shadow">
                            <div class="card-body">
                                <ul class="list-unstyled align-items-center">

                                    <li class="list-inline-item"><span class="badge rounded-pill bg-soft-success">ویژه </span></li>
                                </ul>

                                <div class="content text-center">
                                    <img src="images/client/07.jpg" class="avatar avatar-md-md shadow-md rounded-circle" alt="">
                                    <p class="text-muted mb-1 mt-2"></p>
                                    <a href="page-job-candidate.html" class="text-dark h5 name"><?php echo($_user->FirstName." ".$_user->LastName);?></a>
                                    <p class="text-muted my-1"></p>

                                    <span class="text-muted"><i class="uil uil-graduation-cap h4 mb-0 me-2 text-primary"></i>تجربه  : <span class="text-success"><?php echo($cv->YWR);?></span></span>
                                    
                                    <ul class="list-unstyled mt-3">
                                        <?php $sps = explode("|", $cv->Specialties);
                                        foreach($sps as $sp){
                                        
                                        ?>
                                        <li class="list-inline-item m-1"><a href="jvascript:void(0)" class="rounded bg-light py-1 px-2 text-muted small"><?php echo($sp);?></a></li>
                                       <?php  }?>
                                    </ul>
                                    <div class="d-grid">
                                        <a href="page-job-candidate.html" class="btn btn-soft-primary">مشاهده رزومه<i class="uil uil-angle-left-b align-middle"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                    <?php
                    }
                    ?>
                   

                    
                </div><!--end row-->
            </div><!--end container-->
        </section><!--end section-->
        
       
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
        <!-- Footer End -->

        <!-- javascript -->
        <script src="js/bootstrap.bundle.min.js"></script>
        <!-- SLIDER -->
        <script src="js/tiny-slider.js"></script>
        <!-- Icons -->
        <script src="js/feather.min.js"></script>
        <!-- Switcher -->
        <script src="js/switcher.js"></script>
        <!-- Main Js -->
        <script src="js/plugins.init.js"></script><!--Note: All init js like tiny slider, counter, countdown, maintenance, lightbox, gallery, swiper slider, aos animation etc.-->
        <script src="js/app.js"></script><!--Note: All important javascript like page loader, menu, sticky menu, menu-toggler, one page menu etc. -->
    </body>

</html>