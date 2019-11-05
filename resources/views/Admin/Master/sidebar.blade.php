 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      {{-- <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8"> --}}
      <span class="brand-text font-weight-light">پنل مدیریت</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="direction: ltr">
      <div style="direction: rtl">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="https://www.gravatar.com/avatar/52f0fbcbedee04a121cba8dad1174462?s=200&d=mm&r=g" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">
              {{auth()->user()->name.' '.auth()->user()->family}}
            </a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
                 <li class="nav-item">
                   <a href="{{url('/')}}" class="nav-link">
                     <i class="fas fa-tachometer-alt "></i>
                     <p>
                        داشبورد
                     </p>
                   </a>
                 </li>

                 {{-- Products --}}

                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                      <i class="fas fa-box-open"></i>
                    <p>
                      محصولات
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="{{route('products.create')}}" class="nav-link">
                        <i class="fas fa-plus-circle text-success"></i>
                        <p>افزودن</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="{{route('products.index')}}" class="nav-link">
                        <i class="fas fa-boxes text-warning"></i>
                        <p>تمام محصولات</p>
                      </a>
                    </li>
                  </ul>
                </li>

                {{-- Users --}}

                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                      <i class="fas fa-users "></i>
                    <p>
                      کاربران
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="{{route('users.create')}}" class="nav-link">
                        <i class="fas fa-user-plus text-success "></i>
                        <p>افزودن</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="{{route('users.index')}}" class="nav-link">
                        <i class="fas fa-user-tag text-warning "></i>
                        <p>فروشندگان</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="{{route('users.agents')}}" class="nav-link">
                        <i class="fas fa-user-tie text-warning "></i>
                        <p>نماینده ها</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="{{route('users.index')}}" class="nav-link">
                        <i class="fas fa-users text-info "></i>
                        <p>تمام کاربران</p>
                      </a>
                    </li>
                  </ul>
                </li>
                {{-- users --}}

                {{-- Citites --}}
               <li class="nav-item">
                 <a href="{{route('cities.index')}}" class="nav-link">
                   <i class="fas fa-city"></i>
                  <p>شهرها</p>
                 </a>
               </li>
               {{-- Citites --}}

               {{-- States --}}
               <li class="nav-item">
                 <a href="{{route('states.index')}}" class="nav-link">
                   <i class="fas fa-building"></i>
                   <p>
                     استانهای ایران
                   </p>
                 </a>
               </li>
              {{-- States --}}

                {{-- roles  --}}
                <li class="nav-item">
                  <a href="{{route('roles.index')}}" class="nav-link">
                    <i class="fas fa-user-lock"></i>
                    <p>
                       سطوح دسترسی
                    </p>
                  </a>
                </li>
                {{-- end roles --}}

          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
    </div>
    <!-- /.sidebar -->
  </aside>
