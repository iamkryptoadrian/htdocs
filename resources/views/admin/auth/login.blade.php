<!DOCTYPE html>
<html lang="en" class="js">
   <head>
      <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
      <meta name="author" content="Softnio">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <link rel="shortcut icon" href="{{url('admin/images/favicon.png')}}">
      <title>Admin Login</title>
      <link rel="stylesheet" href="{{url('admin/assets/css/dashlite.css')}}">
      <link id="skin-default" rel="stylesheet" href="{{url('admin/assets/css/theme.css')}}">
   </head>

<body class="nk-body dark-mode bg-white npc-general pg-auth"  theme="dark">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="nk-split nk-split-page nk-split-md">
                        <div class="nk-split-content nk-block-area nk-block-area-column nk-auth-container bg-white">
                            <div class="nk-block nk-block-middle nk-auth-body">
                                <div class="brand-logo pb-5">
                                    <a href="html/index.html" class="logo-link">
                                        <img class="logo-light logo-img logo-img-lg" src="{{url('admin/images/logo-white.svg')}}" alt="logo">
                                        <img class="logo-dark logo-img logo-img-lg" src="{{url('admin/images/logo-white.svg')}}" alt="logo-dark">
                                    </a>
                                </div>
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h5 class="nk-block-title">Sign-In</h5>
                                        <div class="nk-block-des">
                                            <p>Access The Rock Resort panel using your email and passcode.</p>
                                        </div>
                                    </div>
                                </div><!-- .nk-block-head -->
                                <form method="POST" action="{{ route('admin.adminlogin') }}">
                                    @csrf
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="email">Email</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="Enter your email address" required>
                                        </div>
                                    </div><!-- .form-group -->

                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="password">Passcode</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch" data-target="password">
                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                            </a>
                                            <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Enter your passcode" required>
                                        </div>
                                    </div><!-- .form-group -->
                                    <div class="mb-4 mt-4">
                                        @if (session('status'))
                                            {{ session('status') }}
                                        @endif
                                        @if (session('error'))
                                            <div class="text-danger">{{ session('error') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <div class="flex items-center justify-between">
                                            <div class="custom-control custom-checkbox">
                                                <input id="remember_me" type="checkbox" name="remember" class="custom-control-input">
                                                <label for="remember_me" class="custom-control-label">Remember me</label>
                                            </div>
                                            @if (Route::has('password.request'))
                                                <a href="{{ route('password.request') }}" class="link link-primary link-sm">Forgot Password?</a>
                                            @endif
                                        </div>
                                    </div><!-- .form-group -->

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-lg btn-primary btn-block">Sign in</button>
                                    </div>
                                </form>
                            </div>
                            <div class="nk-block nk-auth-footer">
                                <div class="nk-block-between">
                                </div>
                                <div class="mt-3">
                                    <p>&copy; 2024 The Rock Resort | All Rights Reserved.</p>
                                </div>
                            </div>
                        </div>
                        <div class="nk-split-content nk-split-stretch bg-abstract"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{url('/admin/assets/js/bundle.js')}}"></script>
    <script src="{{url('/admin/assets/js/scripts.js')}}"></script>

</body>
</html>
