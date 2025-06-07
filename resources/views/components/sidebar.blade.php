<div class="page-sidebar custom-scrollbar">
    <div class="sidebar-user text-center">
        <div>
            <img class="img-50 rounded-circle" src="{{ asset('') }}assets/images/user/kampusbaca.png" alt="#">
        </div>
        <h6 class="mt-3 f-12">{{ Auth::user()->name }}</h6>
    </div>
    <ul class="sidebar-menu">
        <li class="active">
            <div class="sidebar-title">General</div>
            <a href="{{ route('dashboard') }}" class="sidebar-header {{ request()->is('dashboard*') ? 'active' : '' }}">
                <i class="icon-desktop"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li>
            <div class="sidebar-title">Data Master</div>
            @if (Auth::user()->role == 'admin')
                <a href="{{ route('fakultas.index') }}"
                    class="sidebar-header {{ request()->is('fakultas*') ? 'active' : '' }}">
                    <i class="icon-palette"></i>
                    <span>Data Fakultas</span>
                </a>
            @endif
        </li>

        <li>
            @if (Auth::user()->role == 'admin')
                <a href="javascript:void(0)" class="sidebar-header {{ request()->is('jurusan*') ? 'active' : '' }}">
                    <i class="icon-direction-alt"></i>
                    <span>Data Jurusan</span>
                    <i class="fa fa-angle-right pull-right"></i>
                </a>
                <ul class="sidebar-submenu menu-open">
                    @foreach (\App\Models\Fakultas::all() as $item)
                        <li>
                            <a href="{{ route('jurusan.index', ['fakultas' => $item->id]) }}"
                                class="{{ request()->is("jurusan/{$item->id}*") ? 'active' : '' }}">
                                <i class="fa fa-angle-right"></i>
                                {{ $item->nama_fakultas }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </li>

        <li>
            <div class="sidebar-title">
                Manajemen Pengguna
            </div>
            @if (Auth::user()->role == 'admin')
                <a href="javascript:void(0)" class="sidebar-header {{ request()->is('mahasiswa*') ? 'active' : '' }}">
                    <i class="icon-notepad"></i>
                    <span>Mahasiswa</span>
                    <i class="fa fa-angle-right pull-right"></i>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('mahasiswa.index') }}"
                            class="{{ request()->is('mahasiswa*') ? 'active' : '' }}">
                            <i class="fa fa-angle-right"></i>
                            Data Mahasiswa
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('mahasiswa.verifikasi') }}"
                            class="{{ request()->is('mahasiswa/verifikasi*') ? 'active' : '' }}">
                            <i class="fa fa-angle-right"></i>
                            Validasi Mahasiswa
                        </a>
                    </li>
                </ul>
            @endif

            @if (Auth::user()->role == 'admin')
                <a href="{{ route('staff.index') }}"
                    class="sidebar-header {{ request()->is('staff*') ? 'active' : '' }}">
                    <i class="icon-write"></i>
                    <span>Data Staff</span>
                </a>
            @endif
        </li>

        <li>
            <div class="sidebar-title">Manajemen Koleksi Buku</div>
            @if (Auth::user()->role == 'admin')
                <a href="{{ route('kategori.index') }}"
                    class="sidebar-header {{ request()->is('kategori*') ? 'active' : '' }}">
                    <i class="icon-package"></i>
                    <span> Data Kategori</span>
                </a>
            @endif
        </li>
        @if (Auth::user()->role == 'admin')
            <li>
                <a href="{{ route('buku.index') }}"
                    class="sidebar-header {{ request()->is('buku*') ? 'active' : '' }}">
                    <i class="icon-support"></i>
                    <span> Data Buku</span>
                </a>
            </li>
        @endif
        @if (Auth::user()->role == 'admin')
            <li>
                <div class="sidebar-title">Kontrol Sirkulasi</div>
                <a href="{{ route('peminjaman.index') }}"
                    class="sidebar-header {{ request()->is('peminjaman*') ? 'active' : '' }}">
                    <i class="icon-user"></i>
                    <span>Peminjaman</span>
                </a>
            </li>
        @endif

        <li>
            <a href="javascript:void(0)" class="sidebar-header">
                <i class="icon-calendar"></i> <span>Calender</span>
                <i class="fa fa-angle-right pull-right"></i>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="calendar.html"><i class="fa fa-angle-right"></i>Full Calender Basic</a></li>
                <li><a href="calendar-event.html"><i class="fa fa-angle-right"></i>Full Calender Events </a></li>
                <li><a href="calendar-advanced.html"><i class="fa fa-angle-right"></i>Full Calender Advance </a></li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0)" class="sidebar-header">
                <i class="icon-gallery"></i> <span>Gallery</span>
                <i class="fa fa-angle-right pull-right"></i>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="gallery.html"><i class="fa fa-angle-right"></i>Gallery Grid</a></li>
                <li><a href="gallery-with-description.html"><i class="fa fa-angle-right"></i>Gallery Grid with
                        Desc</a></li>
                <li><a href="masonry-gallery.html"><i class="fa fa-angle-right"></i>Masonry Gallery</a></li>
                <li><a href="masonry-gallery-with-disc.html"><i class="fa fa-angle-right"></i>Masonry Gallery Desc</a>
                </li>
                <li><a href="gallery-hover.html"><i class="fa fa-angle-right"></i>Hover Effects</a></li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0)" class="sidebar-header">
                <i class="icon-email"></i> <span>Email</span>
                <i class="fa fa-angle-right pull-right"></i>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="email-application.html"><i class="fa fa-angle-right"></i>Email App</a></li>
                <li><a href="email-compose.html"><i class="fa fa-angle-right"></i>Email Compose</a></li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0)" class="sidebar-header">
                <i class="icon-pencil-alt"></i> <span> Blog</span>
                <i class="fa fa-angle-right pull-right"></i>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="blog.html"><i class="fa fa-angle-right"></i>Blog Details</a></li>
                <li><a href="blog-single.html"><i class="fa fa-angle-right"></i>Blog Single</a></li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0)" class="sidebar-header">
                <i class="icon-comments"></i> <span>Chat</span>
                <i class="fa fa-angle-right pull-right"></i>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="chat.html"><i class="fa fa-angle-right"></i>Chat App</a></li>
                <li><a href="call-chat.html"><i class="fa fa-angle-right"></i>Video chat</a></li>
                <li><a href="friend-list.html"><i class="fa fa-angle-right"></i>Friend List</a></li>
            </ul>
        </li>
        <li>
            <a href="support-ticket.html" class="sidebar-header">
                <i class="icon-headphone-alt"></i> <span>Support Ticket</span>
            </a>
        </li>
        <li>
            <a href="to-do.html" class="sidebar-header">
                <i class="icon-announcement"></i><span>To-Do</span>
            </a>
        </li>
        <li>
            <a href="https://admin.pixelstrap.com/universal/{{ route('dashboard') }}" class="sidebar-header">
                <i class="icon-rocket"></i> <span>Landing page</span>
            </a>
        </li>
        <li class="">
            <a href="javascript:void(0)" class="sidebar-header">
                <i class="icon-shopping-cart"></i><span>Ecommerce</span>
                <i class="fa fa-angle-right pull-right"></i>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="product.html"><i class="fa fa-angle-right"></i>Product</a></li>
                <li><a href="product-page.html"><i class="fa fa-angle-right"></i>Product page</a></li>
                <li><a href="product-list.html" class=""><i class="fa fa-angle-right"></i>Product list</a></li>
                <li><a href="payment-details.html"><i class="fa fa-angle-right"></i>Payment Details</a></li>
                <li><a href="invoice-template.html"><i class="fa fa-angle-right"></i>Invoice</a></li>
            </ul>
        </li>
        <li>
            <a href="pricing.html" class="sidebar-header">
                <i class="icon-money"></i><span> Pricing</span>
            </a>
        </li>

        <li>
            <div class="sidebar-title">Pages</div>
            <a href="sample-page.html" class="sidebar-header">
                <i class="icon-file"></i><span> Sample page</span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0)" class="sidebar-header">
                <i class="icon-search"></i> <span>Search Pages</span>
                <i class="fa fa-angle-right pull-right"></i>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="search.html"><i class="fa fa-angle-right"></i>Search Website</a></li>
                <li><a href="search-images.html"><i class="fa fa-angle-right"></i>Search Images</a></li>
                <li><a href="search-video.html"><i class="fa fa-angle-right"></i>Search Video</a></li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0)" class="sidebar-header">
                <i class="icon-info-alt"></i><span> Error Page</span>
                <i class="fa fa-angle-right pull-right"></i>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="error-400.html"><i class="fa fa-angle-right"></i>Error 400</a></li>
                <li><a href="error-401.html"><i class="fa fa-angle-right"></i>Error 401</a></li>
                <li><a href="error-403.html"><i class="fa fa-angle-right"></i>Error 403</a></li>
                <li><a href="error-404.html"><i class="fa fa-angle-right"></i>Error 404</a></li>
                <li><a href="error-500.html"><i class="fa fa-angle-right"></i>Error 500</a></li>
                <li><a href="error-503.html"><i class="fa fa-angle-right"></i>Error 503</a></li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0)" class="sidebar-header">
                <i class="icon-unlock"></i><span> Authentication</span>
                <i class="fa fa-angle-right pull-right"></i>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="login.html"><i class="fa fa-angle-right"></i>Login Simple</a></li>
                <li><a href="login-image.html"><i class="fa fa-angle-right"></i>Login with Bg Image </a></li>
                <li><a href="login-video.html"><i class="fa fa-angle-right"></i>Login with Bg video</a></li>
                <li><a href="signup.html"><i class="fa fa-angle-right"></i>Register Simple </a></li>
                <li><a href="signup-image.html"><i class="fa fa-angle-right"></i>Register with Bg Image </a></li>
                <li><a href="signup-video.html"><i class="fa fa-angle-right"></i>Register with Bg video</a></li>
                <li><a href="unlock.html"><i class="fa fa-angle-right"></i>Unlock User </a></li>
                <li><a href="forget-password.html"><i class="fa fa-angle-right"></i>Forget Password</a></li>
                <li><a href="reset-password.html"><i class="fa fa-angle-right"></i>Reset Password</a></li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0)" class="sidebar-header">
                <i class="icon-video-clapper"></i> <span>Coming Soon</span>
                <i class="fa fa-angle-right pull-right"></i>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="comingsoon.html"><i class="fa fa-angle-right"></i>Coming Simple</a></li>
                <li><a href="comingsoon-bg-video.html"><i class="fa fa-angle-right"></i>Coming with Bg video</a></li>
                <li><a href="comingsoon-bg-img.html"><i class="fa fa-angle-right"></i>Coming with Bg Image </a></li>
            </ul>
        </li>
        <li>
            <a href="maintenance.html" class="sidebar-header">
                <i class="icon-settings"></i><span> Maintenance</span>
            </a>
        </li>
    </ul>
    <div class="sidebar-widget text-center">
        <div class="sidebar-widget-top">
            <h6 class="mb-2 fs-14">Need Help</h6>
            <i class="icon-bell"></i>
        </div>
        <div class="sidebar-widget-bottom p-20 m-20">
            <p>+1 234 567 899
                <br>help@pixelstrap.com
                <br><a href="#">Visit FAQ</a>
            </p>
        </div>
    </div>
</div>
