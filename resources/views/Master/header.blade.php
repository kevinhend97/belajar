<header class="main-header">
    <!-- Logo -->
    <a href="{{url('/')}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>W</b>N</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>TB.</b>WUNI</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          
            
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-danger">{{ $notif->count() + $notifWajib->count() }}</span>
            </a>
            <ul class="dropdown-menu">

              <li class="header">Anda memiliki {{ $notif->count() + $notifWajib->count() }} notifikasi</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  @foreach($notif as $data)
                  <li>
                    <a href="#">
                      <i class="fa fa-warning text-yellow"></i> {{ $data->nama_barang }} stok {{ $data->qty }}      
                    </a>
                   
                  </li>
                  @endforeach
                  @foreach($notifWajib as $list)
                  <li>
                    <a href="#">
                      <i class="fa fa-warning text-red"></i> {{ $list->nama_barang }} stok {{ $list->qty }}   
                    </a>
                    
                  </li>
                  @endforeach
                </ul>
              </li>
              <li class="footer"><a href="{{ route('barang.index') }}">View all</a></li>
            </ul>
          </li>

           
          
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{asset('/uploads/avatar/'.Auth::user()->avatar)}}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{asset('/uploads/avatar/'.Auth::user()->avatar)}}" class="img-circle" alt="User Image">

                <p>
                  {{ Auth::user()->name }} - {{ Auth::user()->jabatan }}
                  <small>{{ Auth::user()->email }}</small>
                </p>
              </li>
              <!-- Menu Body -->
              
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{route('profile.data', Auth::user()->id)}}" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"  class="btn btn-default btn-flat">Sign out</a>
                                                     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                            </form>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>