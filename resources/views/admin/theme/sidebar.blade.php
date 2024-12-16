 <!-- Sidebar Navigation-->
      <nav id="sidebar">
        <!-- Sidebar Header-->
        <div class="sidebar-header d-flex align-items-center">
          <div class="avatar"><img src="img/avatar-6.jpg" alt="..." class="img-fluid rounded-circle"></div>
          <div class="title">
            <h1 class="h5"> {{ Auth::user()->name }}</h1>
            <p>Web Designer</p>
          </div>
        </div>
        <!-- Sidebar Navidation Menus--><span class="heading">Main</span>
        <ul class="list-unstyled">
                <li class="active"><a href="{{ route('admin.dashboard') }}"> <i class="icon-home"></i>Home </a></li>
                <li class="active"><a href="{{ route('admin.profile.edit') }}"> <i class="icon-user"></i>Profile </a></li>
                <li class="active"><a href="{{ route('admin.index') }}"> <i class="icon-list"></i>QR Code Lists </a></li>
                <li class="active"><a href="{{ route('scanlog.index') }}"> <i class="icon-list"></i>Scanned Logs </a></li>
        </ul><span class="heading">Settings</span>
        <ul class="list-unstyled">
          <li> <a href="#"> <i class="icon-user"></i>Users </a></li>
        </ul>
      </nav>
      <!-- Sidebar Navigation end-->
       