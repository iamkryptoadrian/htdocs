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
      <title>Reset Password</title>
      <!-- BEGIN: CSS Assets-->
      <link rel="stylesheet" href="/css/login.css" />
      <!-- END: CSS Assets-->
   </head>
   <!-- END: Head -->
   <body class="login">
      <div class='box'>
         <div class='box-form'>
            <div class='box-login-tab'></div>
            <div class='box-login-title'>
               <div class='i i-login'></div>
               <h2>Reset Password</h2>
            </div>
            <div class='box-login'>
               <div class='fieldset-body' id='login_form'>
                  <button onclick="openLoginInfo();" class='b b-form i i-more' title='More Information'></button>
                  <form method="POST" action="{{ route('password.store') }}">
                     @csrf
                     <!-- Password Reset Token -->
                     <input type="hidden" name="token" value="{{ $request->route('token') }}">
                     <p class='field'>
                        <label for='login'>YOUR E-MAIL</label>
                        <input id="email" class="block mt-1 w-full" type="text" name="email" value="{{ old('email', $request->email) }}" required autocomplete="username" />
                     </p>
                     <p class='field'>
                        <label for='password'>New Password</label>
                        <input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                     </p>
                     <p class='field'>
                        <label for='password_confirmation'>Confirm Password</label>
                        <input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                     </p>
                     <div class="field">
                        @if (session('status'))
                        <div class="text-success" style="padding: 15px;">{{ session('status') }}</div>
                        @endif
                        @if (session('error'))
                        <div class="text-red-500">{{ session('error') }}</div>
                        @endif
                        @if ($errors->any())
                        <div class="text-red-500">
                           <div class="error-message">
                              @foreach ($errors->all() as $error)
                              <p>{{ $error }}</p>
                              @endforeach
                           </div>
                        </div>
                        @endif
                     </div>
                     <!-- Hidden field for redirect. It automatically fetches the redirect URL from the query parameters -->
                     <input type="hidden" name="redirect" value="{{ request()->get('redirect') }}">
                     <input type='submit' id='do_login' value='Reset Password' title='Reset Password' />
                  </form>
               </div>
            </div>
         </div>
         <div class='box-info'>
            <p><button onclick="closeLoginInfo();" class='b b-info i i-left' title='Back to Sign In'></button>
            <h3>Need Help?</h3>
            </p>
            <div class='line-wh'></div>
            <button onclick="window.location.href='/register'" class='b-support' title='Register Now'> Register Now</button>
            <button onclick="window.location.href='/'" class='b-support' title='Go to Homepage'> Go to Homepage</button>
            <div class='line-wh'></div>
            <button onclick="window.location.href='/login'" class='b-cta' title='Return To Login!'> LOGIN</button>
         </div>
      </div>
      <!-- BEGIN: JS Assets-->
      <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
      <script src="{{ url('/js/login.js') }}"></script>
      <!-- END: JS Assets-->
   </body>
</html>
