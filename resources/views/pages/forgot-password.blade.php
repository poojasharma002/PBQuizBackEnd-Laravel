@include('layout.header')

<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
 <img src="{{asset('assets/images/The-PB-Network-Logo.png')}}" alt="logo" width="60">
    <a href="#"><b style="color:#F5620D"></b> Quiz Portal </a>
  </div>
      <!-- Session Status -->
      <!-- <x-auth-session-status class="mb-4" :status="session('status')" /> -->
 <!-- Validation Errors -->
             <x-auth-validation-errors class="mb-4" :errors="$errors" />

  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Forgot Password</p>

      <form action="{{ route('login') }}" method="post">
          @csrf
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Enter your registered email" name="email" id="email"  >
          
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
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



    </div>
    <!-- /.login-card-body -->
  </div>
</div>


@include('layout.footer')
