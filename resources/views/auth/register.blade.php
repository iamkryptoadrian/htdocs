<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<!-- BEGIN: Head -->
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <head>
        <meta charset="utf-8">
        <link href="/img/general/favicon.png" rel="shortcut icon">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="author" content="Vynzio.co">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>User Register</title>
        <!-- BEGIN: CSS Assets-->
        <link rel="stylesheet" href="/css/login.css" />
        <!-- END: CSS Assets-->
    </head>
    <!-- END: Head -->
    <body class="login mb-6" style="overflow: auto;">
        <div class='box'>
                <div class='box-form'>
                    <div class='box-login-tab'></div>
                    <div class='box-login-title'>
                        <div class='i i-login'></div>
                        <h2>Register</h2>
                    </div>
                        <div class='box-login'>
                            <div class='fieldset-body' >
                                <button onclick="openLoginInfo();" class='b b-form i i-more' title='More Information'></button>
                                <form method="POST" action="{{ route('register') }}" id='login_form'>
                                    @csrf
                                    <p class='field'>
                                        <label for='first_name'>First Name</label>
                                        <input type='text' id='first_name' name='first_name' required />
                                        @error('first_name')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </p>

                                    <p class='field'>
                                        <label for='last_name'>Last Name</label>
                                        <input type='text' id='last_name' name='last_name' required />
                                        @error('last_name')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </p>

                                    <p class='field'>
                                        <label for='email'>Email</label>
                                        <input type='text' id='email' name='email' required />
                                        @error('email')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </p>

                                    <p class='field'>
                                        <label for='phone_number'>Phone Number</label>
                                        <input type='text' id='phone_number' name='phone_number' required />
                                        @error('phone_number')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </p>

                                    <p class='field'>
                                        <label for='password'>Password</label>
                                        <input type='password' id='password' name='password' required />
                                        @error('password')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </p>

                                    <p class='field'>
                                        <label for='password_confirmation'>Confirm Password</label>
                                        <input type='password' id='password_confirmation' name='password_confirmation' required />
                                        <span id="password_error" class="text-red-500"></span>
                                        @error('password_confirmation')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </p>
                                    <div class="intro-x mt-4">
                                        @if (session('status'))
                                            <div class="text-success">{{ session('status') }}</div>
                                        @endif
                                        @if (session('error'))
                                            <div class="text-red-500">{{ session('error') }}</div>
                                        @endif
                                    </div>
                                    <input type='submit' id='do_login' value='REGISTER NOW' title='REGISTER NOW' />
                                </form>
                            </div>
                        </div>
                </div>
                <div class='box-info'>
                   <p><button onclick="closeLoginInfo();" class='b b-info i i-left' title='Back to Sign In'></button>
                   <h3>Need Help?</h3>
                   </p>
                   <div class='line-wh'></div>
                   <button onclick="window.location.href='/forgot-password'" class='b-support' title='Forgot Password?'> Forgot Password?</button>
                   <button onclick="window.location.href='/'" class='b-support' title='Go to Homepage'> Go to Homepage</button>
                   <div class='line-wh'></div>
                   <button onclick="window.location.href='/login'" class='b-cta' title='Login to your account!'> LOGIN NOW</button>
                </div>
        </div>
        <!-- BEGIN: JS Assets-->
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src={{url('/js/login.js')}}></script>
        <!-- END: JS Assets-->

        <script>
            document.getElementById('login_form').addEventListener('submit', function(event) {
                var password = document.getElementById('password').value;
                var confirmPassword = document.getElementById('password_confirmation').value;
                var passwordError = document.getElementById('password_error');

                // Clear any previous error message
                passwordError.textContent = '';

                // Check if passwords match
                if (password !== confirmPassword) {
                    event.preventDefault(); // Stop form from submitting
                    passwordError.textContent = 'Confirm password does not match.'; // Display error message
                }
            });
        </script>
    </body>
</html>
