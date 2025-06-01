<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="universal admin is super flexible, powerful, clean & modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, universal admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    @include('components.title')

    <!--Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}assets/css/fontawesome.css">

    <!-- Themify icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}assets/css/themify.css">

    <!-- Bootstrap css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}assets/css/bootstrap.css">

    <!-- App css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}assets/css/style.css">

    <!-- Responsive css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}assets/css/responsive.css">

</head>

<body>

<!-- Loader starts -->
<div class="loader-wrapper">
    <div class="loader bg-white">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        <h4>Have a great day at work today <span>&#x263A;</span></h4>
    </div>
</div>
<!-- Loader ends -->

<!--page-wrapper Start-->
<div class="page-wrapper">
    <div class="container-fluid">
        <!--login page start-->
        <div class="authentication-main">
            <div class="row">
                <div class="col-md-4 p-0">
                    <div class="auth-innerleft">
                        <div class="text-center">
                            <img src="{{ asset('') }}assets/images/logo-login-kb.png" class="logo-login" alt="">
                            <hr>
                            <div class="social-media">
                                <ul class="list-inline">
                                    <li class="list-inline-item"><i class="fa fa-facebook txt-fb" aria-hidden="true"></i></li>
                                    <li class="list-inline-item"><i class="fa fa-google-plus txt-google-plus" aria-hidden="true"></i></li>
                                    <li class="list-inline-item"><i class="fa fa-twitter txt-twitter" aria-hidden="true"></i></li>
                                    <li class="list-inline-item"><i class="fa fa-linkedin txt-linkedin" aria-hidden="true"></i></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 p-0">
                    <div class="auth-innerright">
                        <div class="authentication-box">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--login page end-->
    </div>
</div>
<!--page-wrapper Ends-->

<!-- latest jquery-->
<script src="{{ asset('') }}assets/js/jquery-3.2.1.min.js"></script>

<!-- Bootstrap js-->
<script src="{{ asset('') }}assets/js/bootstrap/bootstrap.bundle.min.js" ></script>

<!-- Theme js-->
<script src="{{ asset('') }}assets/js/script.js"></script>

</body>


<!-- Mirrored from admin.pixelstrap.com/universal/default/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 23 May 2025 13:46:01 GMT -->
</html>
