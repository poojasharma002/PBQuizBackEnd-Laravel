@include('layout.header')

<body class="hold-transition register-page">
 
<div class="register-box" style="width:500px;  ">
  <div class="register-logo" style="margin-bottom:70px"> <img src="{{asset('assets/images/The-PB-Network-Logo.png')}}" alt="logo" width="60">
    <a href="#"><b style="color:#F5620D"></b> Quiz Portal </a>
  </div>
  <x-auth-validation-errors class="mb-4" :errors="$errors" />
  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register a Admin </p>

      <form action="{{ route('register') }}" method="POST">
          @csrf
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Name" id="name" name="name" value="{{old('name')}}">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" id="email" name="email" value="{{ old('email') }}">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" id="password" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Retype password" name="password_confirmation" id="password_confirmation">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <!-- <input type="checkbox" id="agreeTerms" name="terms" value="agree">
              <label for="agreeTerms">
               I agree to the <a href="#">terms</a>
              </label> -->
            </div>
          </div>
     
          <div class="col-4">
            <input type="submit" class="btn btn-block text-white" value="Submit" style="background-color:#2b649e">
          </div>
          
        </div>
      </form>

      <!-- <div class="social-auth-links text-center">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i>
          Sign up using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i>
          Sign up using Google+
        </a>
      </div> -->

      <a href="{{url('login')}}" class="text-center">Already registered</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
@include('layout.footer')