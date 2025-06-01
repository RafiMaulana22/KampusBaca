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

    @include('components.style')

</head>
<body>

<!-- Loader starts -->
<div class="loader-wrapper">
    <div class="loader bg-white">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
    </div>
</div>
<!-- Loader ends -->

<!--page-wrapper Start-->
<div class="page-wrapper">

    <!--Page Header Start-->
    @include('components.header')
    <!--Page Header Ends-->

    <!--Page Body Start-->
    <div class="page-body-wrapper">
        <!--Page Sidebar Start-->
        @include('components.sidebar')
        <!--Page Sidebar Ends-->

        <div class="page-body">
            <!-- Container-fluid starts -->
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-lg-6">
                            <h3>
                                {{ $title }}
                                <small>KampusBaca {{ Auth::user()->role }} panel</small>
                            </h3>
                        </div>
                        <div class="col-lg-6">
                            @yield('breadcrumb')
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends -->

            <!-- Container-fluid starts -->
            <div class="container-fluid">
                <div class="row g-3">
                    @yield('content')
                </div>
            </div>
            <!-- Container-fluid Ends -->
        </div>
        <!--Page Body Ends-->
    </div>
    <!--Page Body Ends-->

</div>
<!--page-wrapper Ends-->

@include('components.script')
@yield('script')
</body>

</html>
