<!DOCTYPE html>
<html lang="en">
<head>
	<!--  Title -->
	<title>@yield('title', 'Senang Tours & Travel')</title>
	<!--  Required Meta Tag -->
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="handheldfriendly" content="true" />
	<meta name="MobileOptimized" content="width" />
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="description" content="Senang Tours & Travel " />
	<meta name="author" content="" />
	<meta name="keywords" content="Senang Tours & Travel" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<!--  Favicon -->
	<link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/logo_senangtour.png') }}" />
	<!-- Owl Carousel  -->
	<link rel="stylesheet" href="{{ asset('assets/libs/owl.carousel/dist/assets/owl.carousel.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}">
	{{-- <link rel="stylesheet" href="{{ asset('assets/libs/toastr/toastr.css') }}"> --}}
	<!-- Core Css -->
	<link  id="themeColors"  rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
	@yield('css')
</head>
<body>
	<!-- Preloader -->
	<div class="preloader">
		<img src="{{ asset('assets/images/logos/favicon.ico') }}" alt="loader" class="lds-ripple img-fluid" />
	</div>
	<!-- Preloader -->
	<div class="preloader">
		<img src="{{ asset('assets/images/logos/favicon.ico') }}" alt="loader" class="lds-ripple img-fluid" />
	</div>
	<!--  Body Wrapper -->
	<div class="page-wrapper" id="main-wrapper" data-theme="blue_theme"  data-layout="vertical" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
		<!-- Sidebar Start -->
		<aside class="left-sidebar">
			<!-- Sidebar scroll-->
			<div>
				<div class="brand-logo d-flex align-items-center justify-content-between">
					<a href="/dashboard" class="text-nowrap logo-img">
						<img src="{{ asset('assets/images/logos/logo_senangtour.png') }}" class="dark-logo" width="50" alt="" /> 
						<span class="fs-6">SenangTours</span>
					</a>
					<div class="close-btn d-lg-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
						<i class="ti ti-x fs-8 text-muted"></i>
					</div>
				</div>
				<!-- Sidebar navigation-->
				<nav class="sidebar-nav scroll-sidebar" data-simplebar>
					<ul id="sidebarnav">
						<!-- ============================= -->
						<!-- Home -->
						<!-- ============================= -->
						<li class="nav-small-cap">
							<i class="ti ti-dots nav-small-cap-icon fs-4"></i>
							<span class="hide-menu">Home</span>
						</li>
						<!-- =================== -->
						<!-- Dashboard -->
						<!-- =================== -->
						<x-sidebar-item icon="ti ti-smart-home" url="dashboard">
							Dashboard
						</x-sidebar-item>
						<!-- =================== -->
						<!-- MENU AGENT -->
						<!-- =================== --> 
						@if(	session('user.role') == 5) 

						<li class="nav-small-cap mt-0">
							<i class="ti ti-dots nav-small-cap-icon fs-4"></i>
							<span class="hide-menu">Reservasi</span>
						</li>
						<x-sidebar-item icon="ti ti ti-shopping-cart" url="reservasi-paket">
							Paket Reservasi
						</x-sidebar-item>
						<x-sidebar-item icon="ti ti ti-shopping-cart-plus" url="reservasi-custom">
							Custom Reservasi
						</x-sidebar-item>

						<li class="nav-small-cap">
							<i class="ti ti-dots nav-small-cap-icon fs-4"></i>
							<span class="hide-menu">TAGIHAN</span>
						</li>
						<x-sidebar-item icon="ti ti ti-file-dollar" url="tagihan">
							Tagihan
						</x-sidebar-item>
						@endif


						<!-- =================== -->
						<!-- MENU ACCOUNTING -->
						<!-- =================== --> 
						@if(	session('user.role') == 4) 
						<li class="nav-small-cap">
							<i class="ti ti-dots nav-small-cap-icon fs-4"></i>
							<span class="hide-menu">TAGIHAN</span>
						</li>
						<x-sidebar-item icon="ti ti ti-file-dollar" url="tagihan">
							Tagihan
						</x-sidebar-item>
						@endif

						<!-- =================== -->
						<!-- MENU OPERATION -->
						<!-- =================== --> 
						@if(	session('user.role') == 3) :
						<li class="nav-small-cap">
							<i class="ti ti-dots nav-small-cap-icon fs-4"></i>
							<span class="hide-menu">Reservasi</span>
						</li>
						<x-sidebar-item icon="ti ti ti-shopping-cart" url="reservasi">
							Reservasi
						</x-sidebar-item>

						<li class="nav-small-cap">
							<i class="ti ti-dots nav-small-cap-icon fs-4"></i>
							<span class="hide-menu">TAGIHAN</span>
						</li>
						<x-sidebar-item icon="ti ti ti-file-dollar" url="tagihan">
							Tagihan
						</x-sidebar-item>

						<li class="nav-small-cap">
							<i class="ti ti-dots nav-small-cap-icon fs-4"></i>
							<span class="hide-menu">Data Management</span>
						</li>
						<x-sidebar-item icon="ti ti-color-swatch" url="produk">
							Produk
						</x-sidebar-item>
						<x-sidebar-item icon="ti ti-table-options" url="program">
							Program
						</x-sidebar-item>
						<x-sidebar-item icon="ti ti-language" url="bahasa">
							Bahasa
						</x-sidebar-item>
						<x-sidebar-item icon="ti ti-bus" url="sopir">
							Sopir
						</x-sidebar-item>
						<x-sidebar-item icon="ti ti-flag" url="guide">
							Guide
						</x-sidebar-item>
						<x-sidebar-item icon="ti ti-car" url="kendaraan">
							Kendaraan
						</x-sidebar-item>
						<x-sidebar-item icon="ti ti-affiliate" url="vendor">
							Vendor
						</x-sidebar-item>
						@endif

						<!-- =================== -->
						<!-- MENU PRODUCTION -->
						<!-- =================== --> 
						@if(	session('user.role') == 2) 

						<li class="nav-small-cap mt-0">
							<i class="ti ti-dots nav-small-cap-icon fs-4"></i>
							<span class="hide-menu">PRODUK & PROGRAM</span>
						</li>
						<x-sidebar-item icon="ti ti-color-swatch" url="produk">
							Produk
						</x-sidebar-item>
						<x-sidebar-item icon="ti ti-table-options" url="program">
							Program
						</x-sidebar-item>
						@endif

						<!-- =================== -->
						<!-- MENU MASTER / ADMIN -->
						<!-- =================== -->
						@if(	session('user.role') == 1) 
						<li class="nav-small-cap">
							<i class="ti ti-dots nav-small-cap-icon fs-4"></i>
							<span class="hide-menu">Reservasi</span>
						</li>
						<x-sidebar-item icon="ti ti ti-file-dollar" url="tagihan">
							Tagihan
						</x-sidebar-item>
						<x-sidebar-item icon="ti ti ti-shopping-cart" url="reservasi">
							Reservasi
						</x-sidebar-item>
						
						<li class="nav-small-cap">
							<i class="ti ti-dots nav-small-cap-icon fs-4"></i>
							<span class="hide-menu">Data Management</span>
						</li>
						<x-sidebar-item icon="ti ti-color-swatch" url="produk">
							Produk
						</x-sidebar-item>
						<x-sidebar-item icon="ti ti-table-options" url="program">
							Program
						</x-sidebar-item>
						<x-sidebar-item icon="ti ti-users" url="user">
							User
						</x-sidebar-item>
						<x-sidebar-item icon="ti ti-language" url="bahasa">
							Bahasa
						</x-sidebar-item>
						<x-sidebar-item icon="ti ti-bus" url="sopir">
							Sopir
						</x-sidebar-item>
						<x-sidebar-item icon="ti ti-flag" url="guide">
							Guide
						</x-sidebar-item>
						<x-sidebar-item icon="ti ti-car" url="kendaraan">
							Kendaraan
						</x-sidebar-item>
						<x-sidebar-item icon="ti ti-affiliate" url="vendor">
							Vendor
						</x-sidebar-item>
						@endif
						<!-- End Sidebar navigation -->
					</div>
					<!-- End Sidebar scroll-->
				</aside>
				<!--  Sidebar End -->
				<!--  Main wrapper -->
				<div class="body-wrapper">
					<!--  Header Start -->
					<header class="app-header"> 
						<nav class="navbar navbar-expand-lg navbar-light">
							<ul class="navbar-nav">
								<li class="nav-item">
									<a class="nav-link sidebartoggler nav-icon-hover ms-n3" id="headerCollapse" href="javascript:void(0)">
										<i class="ti ti-menu-2"></i>
									</a>
								</li> 
							</ul> 
							<div class="d-block d-lg-none">
								<span class="text-primary fs-8 fw-bold">
									Senang Tours & Travel - Dashboard
								</span>
							</div>
							<button class="p-0 border-0 navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
								<span class="p-2">
									<i class="ti ti-dots fs-7"></i>
								</span>
							</button>
							<div class="collapse navbar-collapse justify-content-end" id="navbarNav">
								<div class="d-flex align-items-center justify-content-between">
									<span href="javascript:void(0)" class="nav-link d-flex d-lg-none align-items-center justify-content-center"  >
										<i class="fs-7"></i>
									</span>
									<ul class="flex-row navbar-nav ms-auto align-items-center justify-content-center">
										<li class="nav-item dropdown">
											<a class="nav-link pe-0" href="javascript:void(0)" id="drop1" data-bs-toggle="dropdown" aria-expanded="false">
												<div class="d-flex align-items-center">
													<div class="user-profile-img">
														<img src="{{ asset('assets/images/profile/user-1.jpg') }}" class="rounded-circle" width="35" height="35" alt="" />
													</div>
												</div>
											</a>
											<div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop1">
												<div class="profile-dropdown position-relative" data-simplebar>
													<div class="py-3 pb-0 px-7">
														<h5 class="mb-0 fs-5 fw-semibold">User Profile</h5>
													</div>
													<div class="d-flex align-items-center py-9 mx-7 border-bottom">
														<img src="{{ asset('assets/images/profile/user-1.jpg') }}" class="rounded-circle" width="80" height="80" alt="" />
														<div class="ms-3">
															<h5 class="mb-1 fs-3">{{ session('user.name') }}</h5>
															<span class="mb-1 d-block text-dark">
																{{ 
																	session('user.role') == 1 ? 'admin' : 
																	(session('user.role') == 2 ? 'production' : 
																		(session('user.role') == 3 ? 'operation' : 
																			(session('user.role') == 4 ? 'accounting' : 'agent')))
																		}}

																	</span>
																	<!-- Menampilkan email user -->
																	<p class="gap-2 mb-0 d-flex text-dark align-items-center">
																		<i class="ti ti-mail fs-4"></i> {{ session('user.email') }}
																	</p>
																</div>
															</div>
															<div class="message-body">
																<a href="{{ url('/profile') }}" class="py-8 mt-8 px-7 d-flex align-items-center">
																	<span class="p-6 d-flex align-items-center justify-content-center bg-light rounded-1">
																		<img src="{{ asset('assets/images/svgs/icon-account.svg') }}" alt="" width="24" height="24">
																	</span>
																	<div class="w-75 d-inline-block v-middle ps-3">
																		<h6 class="mb-1 bg-hover-primary fw-semibold">My Profile</h6>
																		<span class="d-block text-dark">Account Settings</span>
																	</div>
																</a>
																<a href="{{ url('/email') }}" class="py-8 px-7 d-flex align-items-center">
																	<span class="p-6 d-flex align-items-center justify-content-center bg-light rounded-1">
																		<img src="{{ asset('assets/images/svgs/icon-inbox.svg') }}" alt="" width="24" height="24">
																	</span>
																	<div class="w-75 d-inline-block v-middle ps-3">
																		<h6 class="mb-1 bg-hover-primary fw-semibold">My Inbox</h6>
																		<span class="d-block text-dark">Messages & Emails</span>
																	</div>
																</a>
															</div>
															<div class="py-4 pt-8 d-grid px-7"> 
																<form action="{{ route('logout') }}" method="POST" style="display: inline;">
																	@csrf
																	<button type="submit" class="btn btn-outline-primary">Logout</button>
																</form>
															</div>
														</div>
													</div>

												</li>
											</ul>
										</div>
									</div>
								</nav>
							</header>
							<!--  Header End -->
							<div class="container-fluid">
								@yield('content')
							</div>
						</div>
						<div class="dark-transparent sidebartoggler"></div>
						<div class="dark-transparent sidebartoggler"></div>
					</div>

					<!--  Import Js Files -->
					<script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
					<script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
					<script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
					<!--  core files -->
					<script src="{{ asset('assets/js/app.min.js') }}"></script>
					<script src="{{ asset('assets/js/app.init.js') }}"></script>
					<script src="{{ asset('assets/js/app-style-switcher.js') }}"></script>
					<script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
					<script src="{{ asset('assets/js/custom.js') }}"></script>
					<script src="{{ asset('assets/libs/prismjs/prism.js') }}"></script> 
					<script src="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.js') }}"></script>
					<!--  current page js files -->
					<script src="{{ asset('assets/libs/owl.carousel/dist/owl.carousel.min.js') }}"></script>
					{{-- <script src="{{ asset('assets/libs/toastr/toastr.js') }}"></script> --}}
					<script src="{{ asset('assets/js/plugins/toastr-init.js') }}"></script>
					@yield('js','')
				</body>
				</html>