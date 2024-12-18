 <!-- Sidebar Navigation-->
 <nav id="sidebar">
   <!-- Sidebar Header-->
   <div class="sidebar-header d-flex align-items-center">

     @if (Auth::check())
     <div class="avatar">
       <img
         src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('images/default-profile.png') }}"
         alt="Profile Picture"
         class="profile-picture img-fluid rounded-circle">
     </div>

     <div class="title">
       <h1 class="h5"> {{ Auth::user()->name }}</h1>
     </div>
     @else
     <a href="{{ route('login') }}">Login</a>
     @endif

   </div>
   <!-- Sidebar Navidation Menus--><span class="heading">Main</span>
   <ul class="list-unstyled">
     <li class="active"><a href="{{ route('admin.dashboard') }}"> <i class="icon-home"></i>Home </a></li>
     <li class="active"><a href="{{ route('admin.profile.edit') }}"> <i class="icon-user"></i>Profile </a></li>
     <li class="active"><a href="{{ route('admin.index') }}"> <i class="icon-list"></i>QR Code Lists </a></li>
     <li class="active"><a href="{{ route('scanlog.index') }}"> <i class="icon-list"></i>Scanned Logs </a></li>
   </ul><span class="heading">Settings</span>
   <ul class="list-unstyled">
     <li> <a href="{{ route('admin.registeredusers')}}"> <i class="icon-user"></i>Users </a></li>
   </ul>
 </nav>
 <!-- Sidebar Navigation end-->

 
<style>
    .profile-picture {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #ddd;
    }
</style>
