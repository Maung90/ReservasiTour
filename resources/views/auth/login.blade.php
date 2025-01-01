<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="handheldfriendly" content="true" />
    <meta name="MobileOptimized" content="width" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Senang Tours & Travel " />
    <meta name="author" content="" />
    <meta name="keywords" content="Senang Tours & Travel" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.ico') }}" />

    <title>Login</title>

    <link rel="stylesheet" href="{{ asset('assets/libs/toastr/toastr.css') }}">
    <link id="themeColors" rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
</head>
<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100">
        <div class="position-relative z-index-5">
            <div class="row">
                <div class="col-xl-7 col-xxl-8">
                    <span class="text-primary fs-8 fw-bolder  text-nowrap logo-img d-block px-4 py-9 w-100">
                        SenangTours & Travel
                    </span>
                    <div class="d-none d-xl-flex align-items-center justify-content-center" style="height: calc(100vh - 80px);">
                        <img src="{{ asset('assets/images/backgrounds/login-security.svg')}}" alt="" class="img-fluid" width="500">
                    </div>
                </div>
                <div class="col-xl-5 col-xxl-4">
                    <div class="authentication-login min-vh-100 bg-body row justify-content-center align-items-center p-4">
                        <div class="col-sm-8 col-md-6 col-xl-9">
                            <h2 class="mb-3 fs-7 fw-bolder">Welcome to SenangTours & Travel</h2>
                            <p class=" mb-9" style="letter-spacing:0.5px;">Masuk menggunakan akun SenangTours & Travel</p> 
                            <div class="position-relative text-center my-4">
                                <p class="mb-0 fs-4 px-3 d-inline-block bg-white text-dark z-index-5 position-relative"></p>
                                <span class="border-top w-100 position-absolute top-50 start-50 translate-middle"></span>
                            </div>
                            <form id="form-login">
                                @csrf
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Username</label>
                                    <input type="text" name="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" autocomplete="off" required>
                                </div>
                                <div class="mb-4">
                                    <label for="exampleInputPassword1" class="form-label">Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password"  required/>
                                        <span class="input-group-text cursor-pointer" id="mata"><i class="ti ti-eye-off" id="matanya"></i></span>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2" id="submit-btn">
                                    <span class="spinner-border spinner-border-sm d-none" id="loading-spinner" role="status" aria-hidden="true"></span>
                                    <span class="mx-2">Sign In</span>
                                </button>
                                <div class="d-flex align-items-center justify-content-center">
                                    <p class="fs-4 mb-0 fw-medium">Forgot Password ?</p>
                                    <a class="text-primary fw-medium ms-2" href="./authentication-register.html">Create new password</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/toastr/toastr.js') }}"></script>
<script src="{{ asset('assets/js/crud/crud.js') }}"></script>
@if (session('error'))
<script>
    showToastr('error','{{ session('error') }}','Error!');
</script>
@endif
@if (session('logout'))
<script>
    showToastr('success','{{ session('logout') }}','Success!');
</script>
@endif
<script>
    $(document).ready(function(){

        $('#form-login').submit(function (e) {
            e.preventDefault();
            $('#loading-spinner').removeClass('d-none');
            $.ajax({
                url: "{{ route('auth.login') }}",
                method:'POST',
                data: $(this).serialize(),
                success: function(response) {
                    showToastr('success',response.message,'Success');
                    $('meta[name="csrf-token"]').attr('content', response.csrf_token);
                    $('#loading-spinner').addClass('d-none');
                    window.location.href = 'dashboard';
                },
                error: function (xhr, status, error) {
                    $('#loading-spinner').addClass('d-none');
                    showToastr('error',xhr.responseJSON.message,'Warning');
                }
            });
        }); 
        $('#mata').on('click',()=>{ 
            if ($('#password').attr("type") == "password") {
                $('#matanya').removeClass("ti-eye-off");
                $('#matanya').addClass("ti-eye");
                $('#password').removeAttr("type");
                $('#password').attr("type","text"); 
            }else{ 
                $('#matanya').removeClass("ti-eye");
                $('#matanya').addClass("ti-eye-off");
                $('#password').removeAttr("type");
                $('#password').attr("type","password"); 
            }
        });
    });
</script>
</body>
</html>