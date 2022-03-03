<aside class="main-sidebar " style="background-color:#2b649e;position:fixed;top:0;left:0;min-height:100vh">
    <!-- Brand Logo -->
    <a href="#" class="brand-link" style="padding:0.4rem .5rem">
      <!-- <img src="{{asset('assets/images/logo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
      <!-- <span class="brand-text font-weight-light">Cynoteck Canteen</span> -->
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <div class="user-panel  pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('assets/images/The-PB-Network-Logo.png')}}" class="img-circle elevation-2" alt="User Image" style="width:3.1rem">
          <span style="font-size:1.5rem" class="ml-2 text-white"> Admin Portal</h1></span>
        </div>
        
      </div>
      <!-- <hr style="border-color:#000;margin-top:0.5rem;margin-bottom:0.5rem"> -->
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

         <li  class="nav-item {{ Route::is('dashboard') ? 'bg-light' : '' }} ">
            <a href="{{url('dashboard')}}" class="nav-link">
              <i class="nav-icon fa fa-chart-line nav-item {{ Route::is('dashboard') ? 'text-primary' : 'text-white' }} "></i>
              <p class="nav-item {{ Route::is('dashboard') ? 'text-primary' : 'text-white' }} ">
                Dashboard
              </p>
            </a>
          </li>

          <li  class="nav-item {{ Route::is('all-questions') ? 'bg-light' : '' }} ">
            <a href="{{url('all-questions')}}" class="nav-link">
              <i class="nav-icon fa fa-question-circle nav-item {{ Route::is('all-questions') ? 'text-primary' : 'text-white' }} "></i>
              <p class="nav-item {{ Route::is('all-questions') ? 'text-primary' : 'text-white' }} ">
                Questions
              </p>
            </a>
          </li>

          <li  class="nav-item {{ Route::is('all_games') ? 'bg-light' : '' }} ">
            <a href="{{url('all_games')}}" class="nav-link">
              <i class="nav-icon fa fa-gamepad nav-item {{ Route::is('all_games') ? 'text-primary' : 'text-white' }} "></i>
              <p class="nav-item {{ Route::is('all_games') ? 'text-primary' : 'text-white' }} ">
                Games
              </p>
            </a>
          </li>

          <li  class="nav-item {{ Route::is('all_users') ? 'bg-light' : '' }} ">
            <a href="{{url('all_users')}}" class="nav-link">
              <i class="nav-icon fa fa-users nav-item {{ Route::is('all_users') ? 'text-primary' : 'text-white' }} "></i>
              <p class="nav-item {{ Route::is('all_users') ? 'text-primary' : 'text-white' }} ">
                Users
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-edit text-light"></i>
              <p class="text-light">
                Settings
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li  class="nav-item {{ Route::is('add_tag') ? 'bg-light' : '' }} ">
            <a href="{{url('add_tag')}}" class="nav-link">
              <i class="nav-icon fa fa-plus nav-item {{ Route::is('add_tag') ? 'text-primary' : 'text-white' }} "></i>
              <p class="nav-item {{ Route::is('add_tag') ? 'text-primary' : 'text-white' }} ">
              Add Tags
              </p>
            </a>
          </li>

          <li  class="nav-item {{ Route::is('add_host') ? 'bg-light' : '' }} ">
            <a href="{{url('add_host')}}" class="nav-link">
              <i class="nav-icon fa fa-plus nav-item {{ Route::is('add_host') ? 'text-primary' : 'text-white' }} "></i>
              <p class="nav-item {{ Route::is('add_host') ? 'text-primary' : 'text-white' }} ">
              Add host
              </p>
            </a>
          </li>

          <li  class="nav-item {{ Route::is('add_music') ? 'bg-light' : '' }} ">
            <a href="{{url('add_music')}}" class="nav-link">
              <i class="nav-icon fa fa-plus nav-item {{ Route::is('add_music') ? 'text-primary' : 'text-white' }} "></i>
              <p class="nav-item {{ Route::is('add_music') ? 'text-primary' : 'text-white' }} ">
              Add Audio
              </p>
            </a>
          </li>

          <li  class="nav-item {{ Route::is('add_trophy') ? 'bg-light' : '' }} ">
            <a href="{{url('add_trophy')}}" class="nav-link">
              <i class="nav-icon fa fa-plus nav-item {{ Route::is('add_trophy') ? 'text-primary' : 'text-white' }} "></i>
              <p class="nav-item {{ Route::is('add_trophy') ? 'text-primary' : 'text-white' }} ">
              Add Trophy
              </p>
            </a>
          </li>

            </ul>
          </li>
     
         
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>