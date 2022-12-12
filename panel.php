<?php

include_once __DIR__ . DIRECTORY_SEPARATOR . "DB.php";
$DB = new DB();
$error=null;
$error_status='alert-danger';

if (isset($_COOKIE['remembr'])) {
    $DB->Forcelogin($_COOKIE['remembr']);
}

if (!isset($_SESSION['login']['status'])) {
    header('Location:login.php');
}

$UName = $_SESSION['login']['info']->UserName;
$user = $DB->CheckAcc($UName);

$_UserName = $user->UserName;
$_FirstName = $user->FirstName;
$_LastName = $user->LastName;
$_mix=$_FirstName." ".$_LastName;
$_email=$user->Email;
$_UserId = $user->ID;

$cv = $DB->GetCVByID($_UserId);
$cvlng = $cv->Language;

if (isset($_POST['account'])) {

    $_FirstNameNew = trim($_POST['FirstName']);
    $_LastNameNew = trim($_POST['LastName']);
    $_EmailNew = trim($_POST['Email']);
    
    if (!empty($_FirstNameNew) && !empty($_LastNameNew)) {

        $result = $DB->UpdateAccount($_FirstNameNew, $_LastNameNew,$_EmailNew, $_UserId);
        header('Location:panel.php');
    }
    else{
 
        $error_status='alert-danger';
        $error="فیلد های الزامی نمی توانند خالی باشند!";
   
    }


}

if (isset($_POST['cv'])) {
    
    $_gender = "male";
    $_about = trim($_POST['about']);
    $_age = trim($_POST['age']);
    $_lang = trim($_POST['lang'][0]);
    $_ywr = trim($_POST['ywr']);
    $_phone = trim($_POST['phone']);
    $_specialties = trim($_POST['specialties']);
    $_gender = trim($_POST['gender']);


    if (!empty($_about) && !empty($_age) && !empty($_ywr) && !empty($_gender) && !empty($_specialties)) {

        $result = $DB->UpdateCV($_about, $_age, $_lang , $_ywr, $_phone , $_specialties , $_gender , $_UserId);
        header('Location:panel.php');
    }
    else{
 
        $error_status='alert-danger';
        $error="فیلد های الزامی نمی توانند خالی باشند!";
   
    }


}
?>
<!DOCTYPE html>
    <html lang="en">

    <head>
    <meta charset="utf-8" />   
        <title>RezDom | داشبورد</title>
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
                                                <h3 class="title mb-0"><?php echo $_mix; ?></h3>
                                            </div><!--end col-->
                                            <div class="col-md-5 text-md-end text-center">
                                                <ul class="list-unstyled social-icon social mb-0 mt-4">
                                                    <li class="list-inline-item"><a href="./" class="rounded" ><i class="mdi mdi-home"> </i></a></li>
                                                    <li class="list-inline-item"><a href="./logout" class="rounded" ><i class="mdi mdi-logout"> </i></a></li>
                                                </ul><!--end icon-->
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

        <section style="padding-bottom: 100px; ">
            
            <div class="container mt-100 mt-60">
                <div class="row">
                    <div class="col-md-5 mt-4 pt-2" style="box-shadow: 0px 0px 5px 1px #ffffff14;border-radius: 10px;width: 30%;height: fit-content;">
                        <ul class="nav nav-pills bg-white nav-justified flex-column mb-0" id="pills-tab" role="tablist" style="padding-top: 8px;padding-bottom: 16px;"> 
                          
                            <li class="nav-item bg-light rounded-md">
                                <a class="nav-link rounded-md active" id="dashboard" data-bs-toggle="pill" href="#dash-board" role="tab" aria-controls="dash-board" aria-selected="false">
                                    <div class="p-2 text-start flexselectionitem">
                                        <span class="h4 mb-0"><i class="mdi mdi-card-account-details"> </i></span>
                                        <h6 class="mb-0 ms-2">مشخصات کاربری </h6>
                                    </div>
                                </a><!--end nav link-->
                            </li><!--end nav item-->
                            <?php
                            
                            if($user->AdPer != 1){
                                echo('
                                
                                <li class="nav-item bg-light rounded-md mt-3">
                                 <a class="nav-link rounded-md " id="timeline" data-bs-toggle="pill" href="#time-line" role="tab" aria-controls="time-line" aria-selected="false">
                                    <div class="p-2 text-start flexselectionitem">
                                        <span class="h4 mb-0"><i class="mdi mdi-briefcase-account"> </i></span>
                                        <h6 class="mb-0 ms-2">رزومه </h6>
                                    </div>
                                 </a>
                                </li>

                                
                                ');
                            }
                            ?>

                            <?php
                            
                            if($user->AdPer == 1){
                                echo('
                                
                                <li class="nav-item bg-light rounded-md mt-3">
                                 <a class="nav-link rounded-md " id="dashboard" data-bs-toggle="pill" href="#dash-board" role="tab" aria-controls="dash-board" aria-selected="false">
                                    <div class="p-2 text-start flexselectionitem">
                                        <span class="h4 mb-0"><i class="mdi mdi-cog"> </i></span>
                                        <h6 class="mb-0 ms-2">تنظیمات سایت </h6>
                                    </div>
                                  </a>
                                 </li>

                                
                                ');
              
                                echo('
                                
                         
                                <li class="nav-item bg-light rounded-md mt-3">
                                  <a class="nav-link rounded-md " id="dashboard" data-bs-toggle="pill" href="#dash-board" role="tab" aria-controls="dash-board" aria-selected="false">
                                    <div class="p-2 text-start flexselectionitem">
                                        <span class="h4 mb-0"><i class="mdi mdi-clipboard-list"> </i></span>
                                        <h6 class="mb-0 ms-2">رزومه ها </h6>
                                    </div>
                                 </a>
                                </li>

                                
                                ');
                            }
                            
                            
                            ?>

             



                        </ul><!--end nav pills-->
                    </div><!--end col-->

                    <div class="col-md-7 col-12 mt-4 pt-2" style="width: 70%;">
                        <div class="tab-content ms-lg-4" id="pills-tabContent">

                            <?php  if($error!=null): ?>
                                <div class="alert <?php echo($error_status);?> alert-dismissible fade show mb-4" role="alert">
                                    <?php echo($error); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="بستن"></button>
                                </div>
                            <?php $error=null; endif ?>

                            <div class="tab-pane fade show active" id="dash-board" role="tabpanel" aria-labelledby="dashboard">
                                <h5 class="text-md-start text-center">مشخصات کاربری</h5>
                                <form method="POST">
                                    <div class="row mt-4">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">نام  <span class="text-danger">*</span></label>
                                                <div class="form-icon position-relative">
                                                    <i data-feather="user" class="fea icon-sm icons"></i>
                                                    <input name="FirstName" id="first" type="text" class="form-control ps-5" placeholder="نام " value="<?php echo($_FirstName)?>">
                                                </div>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">نام خانوادگی <span class="text-danger">*</span></label>
                                                <div class="form-icon position-relative">
                                                    <i data-feather="user-check" class="fea icon-sm icons"></i>
                                                    <input name="LastName" id="last" type="text" class="form-control ps-5" placeholder="نام خانوادگی " value="<?php echo($_LastName)?>">
                                                </div>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">ایمیل شما </label>
                                                <div class="form-icon position-relative">
                                                    <i data-feather="mail" class="fea icon-sm icons"></i>
                                                    <input name="Email" id="email" type="email" class="form-control ps-5" placeholder="ایمیل شما " value="<?php echo($_email)?>">
                                                </div>
                                            </div> 
                                        </div><!--end col-->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">نام کاربری</label>
                                                <div class="form-icon position-relative">
                                                    <i data-feather="user" class="fea icon-sm icons"></i>
                                                    <input name="name" disabled id="occupation" type="text" class="form-control ps-5" placeholder="نام کاربری :" value="<?php echo($_UserName)?>">
                                                </div>
                                            </div> 
                                        </div><!--end col-->
                                    </div><!--end row-->
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="submit" id="submit" name="account" class="btn btn-primary" value="ذخیره تغییرات">
                                        </div><!--end col-->
                                    </div><!--end row-->
                                </form><!--end form-->
                            
                            </div><!--end teb pane-->
                            
                            <div class="tab-pane fade" id="time-line" role="tabpanel" aria-labelledby="timeline">
              
                                <div class="card-body">
                                <h5 class="text-md-start text-center">رزومه  :</h5>

                                <div class="mt-3 text-md-start text-center d-sm-flex">
                                    <img src="images/client/05.jpg" class="avatar float-md-left avatar-medium rounded-circle shadow me-md-4" alt="">
                                    
                                    <div class="mt-md-4 mt-3 mt-sm-0" style="margin-right:5px;">
                                        <a href="javascript:void(0)" class="btn btn-primary mt-2">تغییر تصویر</a>
                                        <a href="javascript:void(0)" class="btn btn-outline-primary mt-2 ms-2">حذف </a>
                                    </div>
                                </div>

                                <form method="POST">
                                    <div class="row mt-4">
                      
                                        <div class="mb-3">
                                            <label class="form-label">درباره من<span class="text-danger">*</span></label>
                                            <div class="form-icon position-relative">

                                                 <i data-feather="info" class="fea icon-sm icons"></i>
                                                 <textarea name="about" id="job" class="form-control ps-5" placeholder="توضیحات مربوط به خود"><?php echo($cv->About);?></textarea>
                                      
                                            </div>
                                        </div>
                                
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                            <label class="form-label">سن <span class="text-danger">*</span></label>
                                            <div class="form-icon position-relative">
                                            <select name="age" class="form-select form-control" aria-label="Default select example">
                                                <option value="" disabled selected>سن : </option>
                                                <option value="بین 13 تا 18 سال" <?php if($cv->Age == "بین 13 تا 18 سال"){echo("selected");}?>>بین 13 تا 18 سال</option>
                                                <option value="بین 18 تا 25 سال" <?php if($cv->Age == "بین 18 تا 25 سال"){echo("selected");}?>>بین 18 تا 25 سال</option>
                                                <option value="بین 25 تا 30 سال" <?php if($cv->Age == "بین 25 تا 30 سال"){echo("selected");}?>>بین 25 تا 30 سال</option>
                                                <option value="بالای 30 سال" <?php if($cv->Age == "بالای 30 سال"){echo("selected");}?>>بالای 30 سال</option>
                                            </select>
                                            </div>
                                            </div> 
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                            <label class="form-label">زبان های خارجی</label>
                                            <div class="form-icon position-relative">
                                            <div class="form-check form-check-inline">
                                            <div class="mb-0">
                                                <div class="form-check">
                                                    <input name="lang[]" class="form-check-input" type="checkbox" value="en" id="flexCheckDefault1" <?php if(strpos($cvlng, 'en')!== false){ echo("checked"); } ?> >
                                                    <label class="form-check-label" for="flexCheckDefault1">انگلیسی </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <div class="mb-0">
                                                <div class="form-check">
                                                    <input name="lang[]" class="form-check-input" type="checkbox" value="fr" id="flexCheckDefault2" <?php if(strpos($cvlng, 'fr')!== false){ echo("checked"); } ?> >
                                                    <label class="form-check-label" for="flexCheckDefault2">فرانسوی </label>
                                                </div>
                                            </div>
                                        </div>
                                            </div>
                                            </div> 
                                        </div>
                                            <div class="col-md-6">
                                            <div class="mb-3">
                                            <label class="form-label">سابقه کاری <span class="text-danger">*</span></label>
                                            <div class="form-icon position-relative">
                                            <select name="ywr" class="form-select form-control" aria-label="Default select example">
                                                <option disabled selected>سابقه کاری: </option>
                                                <option value="کمتر از یک سال " <?php if($cv->YWR == "کمتر از یک سال "){echo("selected");}?>>کمتر از یک سال </option>
                                                <option value="یک سال " <?php if($cv->YWR == "یک سال"){echo("selected");}?>>یک سال </option>
                                                <option value="دو سال" <?php if($cv->YWR == "دو سال"){echo("selected");}?>>دو سال</option>
                                                <option value="بیشتر از دو سال" <?php if($cv->YWR == "بیشتر از دو سال"){echo("selected");}?>>بیشتر از دو سال</option>
                                            </select>
                                            </div>
                                            </div> 
                                        </div>
                                      
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                
                                            <label class="form-label">جنسیت <span class="text-danger">*</span></label>
                                            <div class="form-icon position-relative">
                                            
                                            <div class="form-check form-check-inline" >
                                        
                                            <div class="form-check mb-0">
                                                <input name="gender" class="form-check-input" <?php if(strpos($cv->Gender, 'male')!== false){ echo("checked"); } ?>  type="radio"  id="flexRadioDefault1" value="male" >
                                                <label class="form-check-label" for="flexRadioDefault1">آقا</label>
                                            </div>
                                           
                                        </div>

                                        <div class="form-check form-check-inline">
                                           
                                            <div class="form-check mb-0">
                                                <input name="gender" class="form-check-input"  type="radio"  id="flexRadioDefault2" value="female" <?php if(strpos($cv->Gender, 'female')!== false){ echo("checked"); } ?>>
                                                <label class="form-check-label" for="flexRadioDefault2">خانوم</label>
                                            </div>
                                            
                                        </div>

                                            
                                            </div>
                                            </div> 
                                            
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">شماره تماس</label>
                                                <div class="form-icon position-relative">
                                                    <i data-feather="phone" class="fea icon-sm icons"></i>
                                                    <input name="phone" id="phone" type="tel" class="form-control ps-5" placeholder="شماره تماس" value="<?php echo($cv->Phone);?>">
                                                </div>
                                        </div>
                                        
                                
                                     
                               
                                    </div><!--end row-->
                                    <div class="mb-3">
                                            <label class="form-label">تخصص ها <span class="text-danger">*</span></label>
                                            <div class="form-icon position-relative">

                                                 <i data-feather="code" class="fea icon-sm icons"></i>
                                                 <textarea name="specialties" id="job" class="form-control ps-5" placeholder="برای جدا کردن از <|> استفاده کنید"><?php echo($cv->Specialties);?></textarea>
                                      
                                            </div>
                                    </div> 

                               


                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="submit" id="submit" name="cv" class="btn btn-primary" value="ثبت رزومه">
                                        </div><!--end col-->
                                    </div><!--end row-->
                                </form><!--end form-->

                                
                              
                                </div>
                            
                            </div><!--end teb pane-->
                        </div><!--end tab content-->
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->
       
        </section>

        <script>
             if ( window.history.replaceState ) {
                  window.history.replaceState( null, null, window.location.href );
            }
        </script>
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