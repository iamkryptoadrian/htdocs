<!DOCTYPE html>
<html lang="en" class="js">
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{url('admin/images/favicon.png')}}">
    <title>Reset Password</title>
    <link rel="stylesheet" href="{{url('admin/assets/css/dashlite.css')}}">
    <link id="skin-default" rel="stylesheet" href="{{url('admin/assets/css/theme.css')}}">
</head>
<body class="nk-body dark-mode bg-white npc-general pg-auth" theme="dark">
    <div class="nk-app-root">
        <div class="nk-main ">
            <div class="nk-wrap nk-wrap-nosidebar">
                <div class="nk-content ">
                    <div class="nk-split nk-split-page nk-split-md">
                        <div class="nk-split-content nk-block-area nk-block-area-column nk-auth-container bg-white">
                            <div class="nk-block nk-block-middle nk-auth-body">
                                <div class="brand-logo pb-5">
                                    <a href="{{ route('agent.login') }}" class="logo-link">
                                        <img class="logo-light logo-img logo-img-lg" src="{{url('admin/images/logo-white.svg')}}" alt="logo">
                                        <img class="logo-dark logo-img logo-img-lg" src="{{url('admin/images/logo-white.svg')}}" alt="logo-dark">
                                    </a>
                                </div>
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h5 class="nk-block-title">Reset Password</h5>
                                        <div class="nk-block-des">
                                            <p>Enter your new password below.</p>
                                        </div>
                                    </div>
                                </div><!-- .nk-block-head -->
                                <form method="POST" action="{{ route('agent.password.update') }}">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="email">Email</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <input type="email" class="form-control form-control-lg" id="email" name="email" value="{{ $email }}">
                                        </div>
                                    </div><!-- .form-group -->
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="password">New Password</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Enter your new password" required>
                                        </div>
                                    </div><!-- .form-group -->
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="password_confirmation">Confirm New Password</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <input type="password" class="form-control form-control-lg" id="password_confirmation" name="password_confirmation" placeholder="Confirm your new password" required>
                                        </div>
                                    </div><!-- .form-group -->
                                    <div class="mb-4 mt-4">
                                        @if ($errors->any())
                                            <div class="text-danger">{{ $errors->first() }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-lg btn-primary btn-block">Reset Password</button>
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
