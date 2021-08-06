<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{asset('image/logo.png')}}" alt="AdminLTE Logo" class="brand-image elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light"></span><br />
    </a>

    <!-- Sidebar -->
    <div class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-transition"><div class="os-resize-observer-host observed"><div class="os-resize-observer" style="left: 0px; right: auto;"></div></div><div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left;"><div class="os-resize-observer"></div></div><div class="os-content-glue" style="margin: 0px -8px; width: 249px; height: 519px;"></div><div class="os-padding"><div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;"><div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{Auth::guard('admin')->user()->name}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.admin.list')}}" class="nav-link">
              <i class="nav-icon far fa-image"></i>
              <p>
                Manage Admin
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Booking
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('admin.booking.add')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Booking</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.booking.list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>List Booking</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Masters
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('admin.country.list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Country</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.state.list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>State</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="{{route('admin.city.list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>City</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.brand.list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Brand</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.load.list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Load</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="{{route('admin.size.list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Size</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.rate.list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Rate</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="{{route('admin.driver.list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Driver</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.customer.list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Customer</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="{{route('admin.vehicle.list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Vehicle</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div></div></div><div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden"><div class="os-scrollbar-track"><div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);"></div></div></div><div class="os-scrollbar os-scrollbar-vertical os-scrollbar-auto-hidden"><div class="os-scrollbar-track"><div class="os-scrollbar-handle" style="height: 41.3026%; transform: translate(0px, 136.21px);"></div></div></div><div class="os-scrollbar-corner"></div></div>
    <!-- /.sidebar -->
  </aside>