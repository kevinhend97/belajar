  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{asset('/uploads/avatar/'.Auth::user()->avatar)}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->name }}</p>
          <a href="#"><i class="fa fa-key text-success"></i> {{ Auth::user()->jabatan }}</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="active treeview">
          <a href="{{route('home')}}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        @if(Auth::user()->jabatan == "Pemilik")
        <li class="treeview">
          <a href="#">
            <i class="fa  fa-paper-plane-o"></i>
            <span>Data Master</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('profile.index') }}"><i class="fa fa-user"></i> Pengguna</a></li>
            <li><a href="{{ route('supplier.index') }}"><i class="fa fa-id-card-o"></i> Supplier</a></li>
            <li><a href="{{ route('pelanggan.index') }}"><i class="fa  fa-users"></i> Pelanggan</a></li>
          </ul>
        </li>
        @elseif(Auth::user()->jabatan == "Kasir")
        <li class="treeview">
          <a href="#">
            <i class="fa  fa-paper-plane-o"></i>
            <span>Data Master</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('supplier.index') }}"><i class="fa fa-id-card-o"></i> Supplier</a></li>
            <li><a href="{{ route('pelanggan.index') }}"><i class="fa  fa-users"></i> Pelanggan</a></li>
          </ul>
        </li>
        @endif

        <li class="treeview">
          <a href="#">
            <i class="fa fa-briefcase"></i>
            <span>Barang</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @if(Auth::user()->jabatan == "Pemilik")
            <li><a href="{{ route('barang.index') }}"><i class="fa fa-list"></i>Daftar Barang </a></li>
            <li><a href="{{ route('pembelian.index') }}"><i class="fa fa-truck"></i> Pembelian</a></li>
            <li><a href="{{ route('penjualan.index') }}"><i class="fa fa-shopping-cart"></i> Penjualan </a></li>
            <li><a href="{{ route('transaksi.new') }}"><i class="fa fa-money"></i> Transaksi Penjualan </a></li>
            <li><a href="{{ route('piutang.index') }}"><i class="fa  fa-minus-square"></i> Piutang </a></li>
            <li><a href="{{ route('kategori.index') }}"><i class="fa fa-tags"></i> Kategori Barang</a></li>
            @elseif(Auth::user()->jabatan == "Kasir")
            <li><a href="{{ route('penjualan.index') }}"><i class="fa fa-shopping-cart"></i> Penjualan </a></li>
            <li><a href="{{ route('transaksi.new') }}"><i class="fa fa-money"></i> Transaksi Penjualan </a></li>
            <li><a href="{{ route('piutang.index') }}"><i class="fa  fa-minus-square"></i> Piutang </a></li>
            @elseif(Auth::user()->jabatan == "Karyawan")
            <li><a href="{{ route('barang.index') }}"><i class="fa fa-list"></i>Daftar Barang </a></li>
            <li><a href="{{ route('pembelian.index') }}"><i class="fa fa-truck"></i> Pembelian</a></li>
            @endif
          </ul>
        </li>
        @if(Auth::user()->jabatan == "Pemilik")
        <li class="treeview">
          <a href="#">
            <i class="fa fa-bar-chart"></i>
            <span>Laporan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('laporan.index', $jenis = 'Pembelian') }}"><i class="fa  fa-pie-chart"></i>Laporan Pembelian </a></li>
            <li><a href="{{ route('laporan.index', $jenis = 'Penjualan') }}"><i class="fa fa-line-chart"></i>Laporan Penjualan </a></li>
            <li><a href="{{ route('laporan.index', $jenis = 'Pendapatan') }}""><i class="fa  fa-area-chart"></i>Laporan Transaksi </a></li>

          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-gear"></i>
            <span>Pengaturan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('kota.index') }}"><i class="fa fa-map-marker"></i> Kota</a></li>
            <li><a href="{{ route('provinsi.index') }}"><i class="fa fa-map-o"></i> Provinsi</a></li>
            <li><a href="{{ route('satuan.index') }}"><i class="fa  fa-balance-scale"></i> Satuan </a></li>
          </ul>
        </li>
        @endif

    </section>
    <!-- /.sidebar -->
  </aside>
