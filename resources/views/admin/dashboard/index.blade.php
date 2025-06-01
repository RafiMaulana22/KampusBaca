@extends('layouts.template-admin')

@section('breadcrumb')
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item active">
            <i class="fa fa-home"></i>
            {{--  <a href="#">
                <i class="fa fa-home"></i>
            </a>  --}}
        </li>
        {{--  <li class="breadcrumb-item">Dashboard</li>
        <li class="breadcrumb-item active">Default</li>  --}}
    </ol>
@endsection

@section('content')
    <div class="col-xl-3 col-lg-6 col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="stat-widget-dashboard">
                    <div class="d-flex">
                        <img class="flex-shrink-0 me-3" src="{{ asset('') }}assets/images/dashboard-icons/document.png"
                            alt="Generic placeholder image">
                        <div class="text-end">
                            <h4 class="mt-0 counter font-primary">2569</h4>
                            <span>New projects</span>
                        </div>
                    </div>
                    <div class="dashboard-chart-container">
                        <div id="line-chart-sparkline-dashboard1" class="flot-chart-placeholder line-chart-sparkline"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="stat-widget-dashboard">
                    <div class="d-flex">
                        <img class="flex-shrink-0 me-3" src="{{ asset('') }}assets/images/dashboard-icons/operator.png"
                            alt="Generic placeholder image">
                        <div class="text-end">
                            <h4 class="mt-0 counter font-secondary">346</h4>
                            <span>New Clients</span>
                        </div>
                    </div>
                    <div class="dashboard-chart-container">
                        <div id="line-chart-sparkline-dashboard2" class="flot-chart-placeholder line-chart-sparkline"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="stat-widget-dashboard">
                    <div class="d-flex">
                        <img class="flex-shrink-0 me-3" src="{{ asset('') }}assets/images/dashboard-icons/chat.png"
                            alt="Generic placeholder image">
                        <div class="text-end">
                            <h4 class="mt-0 counter font-success">026</h4>
                            <span>Message</span>
                        </div>
                    </div>
                    <div class="dashboard-chart-container">
                        <div id="line-chart-sparkline-dashboard3" class="flot-chart-placeholder line-chart-sparkline"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="stat-widget-dashboard">
                    <div class="d-flex">
                        <img class="flex-shrink-0 me-3" src="{{ asset('') }}assets/images/dashboard-icons/like.png"
                            alt="Generic placeholder image">
                        <div class="text-end">
                            <h4 class="mt-0 counter font-info">9563</h4>
                            <span>New Likes</span>
                        </div>
                    </div>
                    <div class="dashboard-chart-container">
                        <div id="line-chart-sparkline-dashboard4" class="flot-chart-placeholder line-chart-sparkline"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-8 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5>Sales Overview</h5>
                <span>Contrary to popular belief, Lorem Ipsum is not simply random text.</span>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="icofont icofont-simple-left "></i></li>
                        <li><i class="view-html fa fa-code"></i></li>
                        <li><i class="icofont icofont-maximize full-card"></i></li>
                        <li><i class="icofont icofont-minus minimize-card"></i></li>
                        <li><i class="icofont icofont-refresh reload-card"></i></li>
                        <li><i class="icofont icofont-error close-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="dashboard-chart-container">
                    <div id="custom-line-chart" class="flot-chart-placeholder default-dashboard-main-chart"></div>
                    <div class="code-box-copy">
                        <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#example-head"
                            title="Copy"><i class="icofont icofont-copy-alt"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-12">
        <div class="card default-widget-count">
            <div class="card-body">
                <div class="d-flex">
                    <div class="me-3 left b-primary">
                        <div class="bg bg-primary"></div>
                        <i class="icon-user"></i>
                    </div>
                    <div class="align-self-center">
                        <h4 class="mt-0 counter">2560146</h4>
                        <span>Happy Clients </span>
                        <i class="icon-user icon-bg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="card default-widget-count">
            <div class="card-body">
                <div class="d-flex">
                    <div class="me-3 left b-secondary">
                        <div class="bg bg-secondary"></div>
                        <i class="icon-package"></i>
                    </div>
                    <div class="align-self-center">
                        <h4 class="mt-0 counter">95314</h4>
                        <span>Order Complate </span>
                        <i class="icon-package icon-bg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="card default-widget-count">
            <div class="card-body">
                <div class="d-flex">
                    <div class="me-3 left b-success">
                        <div class="bg bg-success"></div>
                        <i class="icon-money"></i>
                    </div>
                    <div class="align-self-center">
                        <h4 class="mt-0 counter">1035976</h4>
                        <span>Early income </span>
                        <i class="icon-money icon-bg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-6 col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Monthly Visiter</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="icofont icofont-simple-left "></i></li>
                        <li><i class="view-html fa fa-code"></i></li>
                        <li><i class="icofont icofont-maximize full-card"></i></li>
                        <li><i class="icofont icofont-minus minimize-card"></i></li>
                        <li><i class="icofont icofont-refresh reload-card"></i></li>
                        <li><i class="icofont icofont-error close-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div id="donut-color-chart-morris" class="flot-chart-placeholder"></div>
                <div class="code-box-copy">
                    <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#example-head1"
                        title="Copy"><i class="icofont icofont-copy-alt"></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-6 col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Daily Visiter</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="icofont icofont-simple-left "></i></li>
                        <li><i class="view-html fa fa-code"></i></li>
                        <li><i class="icofont icofont-maximize full-card"></i></li>
                        <li><i class="icofont icofont-minus minimize-card"></i></li>
                        <li><i class="icofont icofont-refresh reload-card"></i></li>
                        <li><i class="icofont icofont-error close-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div id="donut-color-chart-morris-daily" class="flot-chart-placeholder"></div>
                <div class="code-box-copy">
                    <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#example-head2"
                        title="Copy"><i class="icofont icofont-copy-alt"></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-12 col-md-12">
        <div class="row">
            <div class="col-lg-12 col-md-5">
                <div class="card">
                    <div class="card-body">
                        <div class="row social-media-counter">
                            <div class="col text-center">
                                <i class="icofont icofont-social-facebook font-primary"></i>
                                <h4 class="font-primary mt-2"><span class="counter">25</span>K</h4>
                            </div>
                            <div class="col text-center">
                                <i class="icofont icofont-social-twitter font-secondary"></i>
                                <h4 class="font-secondary mt-2"><span class="counter">456</span>K</h4>
                            </div>
                            <div class="col text-center">
                                <i class="icofont icofont-social-instagram font-success"></i>
                                <h4 class="font-success mt-2"><span class="counter">22</span>K</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-7">
                <div class="card ">
                    <div class="card-body">
                        <div id="testimonial" class="owl-carousel owl-theme testimonial-default">
                            <div class="slide--item">
                                <div>
                                    <p class="text-center">I must explain to you how all this mistaken idea of denouncing
                                        pleasure and praising pain was born and I will give you a complete account of the
                                        system,Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                        Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                                    <div class="text-center">
                                        <div class="media d-inline-flex">
                                            <img class="me-3 img-60"
                                                src="{{ asset('') }}assets/images/dashboard/boy-1.png"
                                                alt="Generic placeholder image">
                                            <div class="align-self-center">
                                                <div>
                                                    <h6 class="mt-2 text-uppercase f-w-700">Mark Jecno</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-8 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5>Top Sale</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="icofont icofont-simple-left "></i></li>
                        <li><i class="view-html fa fa-code"></i></li>
                        <li><i class="icofont icofont-maximize full-card"></i></li>
                        <li><i class="icofont icofont-minus minimize-card"></i></li>
                        <li><i class="icofont icofont-refresh reload-card"></i></li>
                        <li><i class="icofont icofont-error close-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="top-sale-chart">
                    <canvas id="myLineCharts"></canvas>
                </div>
                <div class="code-box-copy">
                    <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#example-head3"
                        title="Copy"><i class="icofont icofont-copy-alt"></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-12">
        <div class="card custom-card">
            <div class="card-header">
                <img src="{{ asset('') }}assets/images/user-card/1.jpg" class="img-fluid w-100" alt="">
            </div>
            <div class="card-profile">
                <img src="{{ asset('') }}assets/images/avtar/3.jpg" class="rounded-circle" alt="">
            </div>
            <ul class="card-social">
                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                <li><a href="#"><i class="fa fa-rss"></i></a></li>
            </ul>
            <div class="text-center profile-details">
                <h4 class="m-b-15 m-t-5">Mark Jecno</h4>
                <h6 class="m-t-15">Manager</h6>
            </div>
            <div class="card-footer row">
                <div class="col-4 col-sm-4">
                    <h6 class="dashboard-card">Follower</h6>
                    <h3 class="counter">9564</h3>
                </div>
                <div class="col-4 col-sm-4">
                    <h6 class="dashboard-card">Follows</h6>
                    <h3><span class="counter">49</span>K</h3>
                </div>
                <div class="col-4 col-sm-4">
                    <h6 class="dashboard-card">Total</h6>
                    <h3><span class="counter">96</span>M</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-12">
        <div class="card height-equal equal-height-lg">
            <div class="card-header">
                <h5>PRODUCT CART</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="icofont icofont-simple-left "></i></li>
                        <li><i class="view-html fa fa-code"></i></li>
                        <li><i class="icofont icofont-maximize full-card"></i></li>
                        <li><i class="icofont icofont-minus minimize-card"></i></li>
                        <li><i class="icofont icofont-refresh reload-card"></i></li>
                        <li><i class="icofont icofont-error close-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="user-status height-scroll custom-scrollbar">
                    <table class="table table-bordernone">
                        <thead>
                            <tr>
                                <th scope="col" class="pt-0">Details</th>
                                <th scope="col" class="pt-0">Quantity</th>
                                <th scope="col" class="pt-0">Status</th>
                                <th scope="col" class="pt-0">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Simply dummy text of the printing</td>
                                <td class="digits">1</td>
                                <td class="font-secondary">Pending</td>
                                <td class="digits">$6523</td>
                            </tr>
                            <tr>
                                <td>Long established</td>
                                <td class="digits">5</td>
                                <td class="font-danger">Cancle</td>
                                <td class="digits">$6523</td>
                            </tr>
                            <tr>
                                <td>sometimes by accident</td>
                                <td class="digits">10</td>
                                <td class="font-danger">Cancle</td>
                                <td class="digits">$6523</td>
                            </tr>
                            <tr>
                                <td>Classical Latin literature</td>
                                <td class="digits">9</td>
                                <td class="font-info">Return</td>
                                <td class="digits">$6523</td>
                            </tr>
                            <tr>
                                <td>keep the site on the Internet</td>
                                <td class="digits">8</td>
                                <td class="font-secondary">Pending</td>
                                <td class="digits">$6523</td>
                            </tr>
                            <tr>
                                <td>Molestiae consequatur</td>
                                <td class="digits">3</td>
                                <td class="font-danger">Cancle</td>
                                <td class="digits">$6523</td>
                            </tr>
                            <tr>
                                <td>Classical Latin literature</td>
                                <td class="digits">9</td>
                                <td class="font-info">Return</td>
                                <td class="digits">$6523</td>
                            </tr>
                            <tr>
                                <td>Long established</td>
                                <td class="digits">5</td>
                                <td class="font-danger">Cancle</td>
                                <td class="digits">$6523</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div class="code-box-copy">
                    <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#example-head4"
                        title="Copy"><i class="icofont icofont-copy-alt"></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-12">
        <div class="card height-equal equal-height-lg">
            <div class="card-header">
                <h5>Support ticket</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="icofont icofont-simple-left "></i></li>
                        <li><i class="view-html fa fa-code"></i></li>
                        <li><i class="icofont icofont-maximize full-card"></i></li>
                        <li><i class="icofont icofont-minus minimize-card"></i></li>
                        <li><i class="icofont icofont-refresh reload-card"></i></li>
                        <li><i class="icofont icofont-error close-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="support-ticket">
                    <div class="row table-responsive-sm">
                        <table class="table table-bordernone">
                            <tbody>
                                <tr>
                                    <td class="pt-0">
                                        <div class="bg-primary left">A</div>
                                    </td>
                                    <td>
                                        <span class="pt-0">Aredo jeko </span>
                                        <h6>25 july 2019</h6>
                                    </td>
                                    <td class="pt-0">
                                        <p>Mistaken idea of denouncing pleasure and praising pain was born and I will give
                                            you a complete account of the system, Lorem Ipsum is simply dummy text of the
                                            printing and typesetting industry. Lorem Ipsum has been</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="bg-secondary left">C</div>
                                    </td>
                                    <td>
                                        <span>Aredo jeko </span>
                                        <h6>25 july 2019</h6>
                                    </td>
                                    <td>
                                        <p>Mistaken idea of denouncing pleasure and praising pain was born and I will give
                                            you a complete account of the system, Lorem Ipsum is simply dummy text of the
                                            printing and typesetting industry. Lorem Ipsum has been
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pb-0">
                                        <div class="bg-success left">H</div>
                                    </td>
                                    <td>
                                        <span>Aredo jeko </span>
                                        <h6>25 july 2019</h6>
                                    </td>
                                    <td class="pb-0">
                                        <p>Mistaken idea of denouncing pleasure and praising pain was born and I will give
                                            you a complete account of the system, Lorem Ipsum is simply dummy text of the
                                            printing and typesetting industry. Lorem Ipsum has been
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="code-box-copy">
                    <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#example-head5"
                        title="Copy"><i class="icofont icofont-copy-alt"></i></button>
                </div>
            </div>
        </div>
    </div>
@endsection
