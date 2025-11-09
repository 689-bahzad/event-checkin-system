 <!-- Sidebar -->
 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

     <!-- Sidebar - Brand -->
     <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
         {{-- <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div> --}}
         <div class="sidebar-brand-text mx-3">Event Planer</div>
     </a>

     <!-- Divider -->
     <hr class="sidebar-divider my-0">

     <!-- Nav Item - Dashboard -->
     {{-- <li class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li> --}}

     <!-- Divider -->
     {{-- <hr class="sidebar-divider"> --}}

     <!-- Heading -->
     {{-- <div class="sidebar-heading">
        Pages
    </div> --}}

     <!-- Nav Item - Pages Collapse Menu -->
     @if (Auth::user()->role == 'admin')
         <li class="nav-item {{ request()->is('admin/register-users') ? 'active' : '' }}">
             <a class="nav-link" href="{{ route('admin.register.users') }}">
                 <i class="fas fa-fw fa-users"></i>
                 <span>Register Users</span></a>
         </li>

         <li class="nav-item {{ request()->is('admin/all-feedback') ? 'active' : '' }}">
             <a class="nav-link" href="{{ route('all.feedback') }}">
                 <i class="fas  fa-fw fa-comments"></i>
                 <span>All Feedback</span></a>
         </li>

         
         <li class="nav-item {{ request()->is('admin/sitting-table') ? 'active' : '' }}">
             <a class="nav-link" href="{{ route('sitting-table.index') }}">
                 <i class="fas fa-fw fa-table"></i>
                 <span>Tables</span></a>
         </li>

         <li class="nav-item {{ request()->is('admin/ball-room') ? 'active' : '' }}">
             <a class="nav-link" href="{{ route('ball.room') }}">
                 <i class="fas fa-fw  fa-campground"></i>
                 <span>Ball Room</span></a>
         </li>

         <li class="nav-item {{ request()->is('admin/profile') ? 'active' : '' }}">
             <a class="nav-link" href="{{ route('profile.edit') }}">
                 <i class="fas fa-fw fa-cog"></i>
                 <span>Profile Setting</span></a>
         </li>
         <li class="nav-item {{ request()->is('admin/site-setting') ? 'active' : '' }}">
             <a class="nav-link" href="{{ route('site-setting.index') }}">
                 <i class="fas fa-fw fa-cogs"></i>
                 <span>Site Setting</span></a>
         </li>
     @endif
     @if (Auth::user()->role == 'user')
        <li class="nav-item {{ request()->is('admin/preview-page') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('preview.page') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>Preview Page</span></a>
        </li>
     @endif

     <!-- Divider -->
     <hr class="sidebar-divider d-none d-md-block">

     <!-- Sidebar Toggler (Sidebar) -->
     <div class="text-center d-none d-md-inline">
         <button class="rounded-circle border-0" id="sidebarToggle"></button>
     </div>

 </ul>
 <!-- End of Sidebar -->
