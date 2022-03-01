@include('layout.header')

<body class="hold-transition login-page">
<div class="login-box" style="width:500px;  "> 
  <div class="login-logo" style="margin-bottom:70px">
 <img src="{{asset('assets/images/The-PB-Network-Logo.png')}}" alt="logo" width="60">
    <a href="#"><b style="color:#F5620D"></b> Quiz Portal </a>
  </div>
      <!-- Session Status -->
      <!-- <x-auth-session-status class="mb-4" :status="session('status')" /> -->
 <!-- Validation Errors -->
             <x-auth-validation-errors class="mb-4" :errors="$errors" />

  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Login to admin portal</p>

      <form action="{{ route('login') }}" method="post">
          @csrf
        <div class="input-group mb-3"> 
          <label for="username" class="d-block w-100" style="font-size:1.2rem !important">Email</label> 
          <input type="email" class="form-control" placeholder="Email" name="email" id="email" @if(Cookie::has('adminuser')) value="{{Cookie::get('adminuser')}}" @endif>
          
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
        <label for="username" class="d-block w-100" style="font-size:1.2rem !important">Password</label> 
          <input type="password" class="form-control" placeholder="Password" name="password" id="password" @if(Cookie::has('adminpwd')) value="{{Cookie::get('adminpwd')}}" @endif>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <input type="checkbox" onclick="myFunction()" > <span style="font-size:1.2rem !important"> Show Password</span> 
        <div class="row py-3">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember" name="remember" @if(Cookie::has('adminpwd')) checked="checked" @endif>
              <label for="remember" style="font-size:1.2rem !important">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <input type="submit" class="btn  btn-block text-white" value="Login" style="background-color:#2b649e">
          </div>
          <!-- /.col -->
        </div>
      </form>

      <!-- <div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div> -->
      <!-- /.social-auth-links -->

      <p class="mt-3">
        <a href="{{url('/forget-password')}}" style="font-size:1.2rem !important">I forgot my password</a>
      </p>
      <p class="mt-3">
        <a href="{{url('register')}}" class="text-center" style="font-size:1.2rem !important">Register here</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>

<script>
  function myFunction() {
  var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>

@include('layout.footer')
