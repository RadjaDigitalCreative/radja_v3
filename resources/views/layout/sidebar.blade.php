 <div class="sidebar" data-color="blue">
  <div class="logo">
    <a href="{{url('/admin/')}}" class="simple-text logo-mini">
      <img style="border-radius: 50%;" src="{{asset('logo_depan.png')}}">
    </a>
    <a href="{{url('/admin/')}}" class="simple-text logo-normal">
      Radja Sistem 
    </a>
  </div>
  <div class="logo">
    <a href="#" class="simple-text logo-mini">
      @if(auth()->user()->image == NULL)
      <img style="border-radius: 50%;" src="{{asset('/images/radja.png')}}" alt="...">
      @else
      <img style="border-radius: 50%;" src="{{ URL::to('/') }}/images/{{ auth()->user()->image }}" alt="...">
      @endif
    </a>
    <a data-toggle="collapse" href="#collapseExample" class="simple-text logo-normal collapsed">
      {{auth()->user()->name}}
    </a>
    <div class="user">
      <div class="info">
        <div class="clearfix"></div>
        <div class="collapse" id="collapseExample">
          <ul class="nav">
            <li>
              <a href="{{url('/admin/profile/')}}">
                <span class="sidebar-normal">My Profile</span>
              </a>
            </li>
            <li>
              <a href="{{url('/admin/profile/edit')}}">
                <span class="sidebar-normal">Edit Profile</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>

  </div>
  <div class="sidebar-wrapper" id="sidebar-wrapper">
   @foreach($bayar as $row)
   @if($row->dibayar >= now() && auth()->user()->id == $row->user_id)
   <ul class="nav">
    @foreach ($role as $row)
    @if($row->is_admin == 1 && $row->user_id == auth()->user()->id)
    <li class="{{Request::is('admin')?'active':''}}">
      <a href="{{url('admin/')}}">
        <i class="now-ui-icons design_app"></i>
        <p>Beranda</p>
      </a>
    </li>
    @endif
    @if($row->is_user == 1 && $row->user_id == auth()->user()->id && $row->id_team == 1 )
    <li class="{{Request::is('admin/notif')?'active':''}}">
      <a href="{{url('admin/notif/')}}">
        <i class="now-ui-icons ui-2_time-alarm"></i>
        <p>Notifikasi</p>
      </a>
    </li>
    @endif
    @if($row->is_akses == 1 && $row->user_id == auth()->user()->id)
    <li class="{{Request::is('admin/akses')?'active':''}}">
      <a href="{{url('/admin/akses/')}}">
        <i class="now-ui-icons education_atom"></i>
        <p>Hak Akses</p>
      </a>
    </li>
    @endif

    @if($row->is_supplier == 1 && $row->user_id == auth()->user()->id)
    <li class="{{Request::is('admin/supplier')?'active':''}}">
      <a href="{{url('/admin/supplier/')}}">
        <i class="now-ui-icons users_circle-08"></i>
        <p>Supplier</p>
      </a>
    </li>
    @endif

    @if($row->is_kategori == 1 && $row->user_id == auth()->user()->id)
    <li class="{{Request::is('admin/category')?'active':''}}">
      <a href="{{url('/admin/category/')}}">
        <i class="now-ui-icons ui-1_bell-53"></i>
        <p>Kategori</p>
      </a>
    </li>
    @endif

    @if($row->is_produk == 1 && $row->user_id == auth()->user()->id)

    <li >
      <a data-toggle="collapse" href="#pro" >
        <i class="now-ui-icons files_box"></i>
        <p>
          Produk <b class="caret"></b>
        </p>
      </a>
      <div class="collapse " id="pro">
        <ul class="nav">
          <li class="{{Request::is('admin/item')?'active':''}}">
            <a href="{{url('/admin/item/')}}">
              <i class="now-ui-icons design_vector"></i>
              <p>Produk List</p>
            </a>
          </li>
        </ul>
      </div>
      <div class="collapse " id="pro">
        <ul class="nav">
          <li class="{{Request::is('admin/qc/qc')?'active':''}}">
            <a href="{{url('/admin/qc/qc')}}">
              <i class="now-ui-icons design_vector"></i>
              <p>Quality Control</p>
            </a>
          </li>
        </ul>
      </div>

    </li>
    @endif

    @if($row->is_order == 1 && $row->user_id == auth()->user()->id)
    <li class="{{Request::is('admin/order')?'active':''}}">
      <a href="{{url('/admin/order/')}}">
        <i class="now-ui-icons shopping_bag-16"></i>
        <p>Order</p>
      </a>
    </li>
    @endif

    @if($row->is_pay == 1 && $row->user_id == auth()->user()->id)
    <li class="{{Request::is('admin/payment')?'active':''}}">
      <a href="{{url('/admin/payment/')}}">
        <i class="now-ui-icons business_money-coins"></i>
        <p>Pembayaran</p>
      </a>
    </li>
    @endif

    @if($row->is_report == 1 && $row->user_id == auth()->user()->id)
    <li class="{{Request::is('admin/report')?'active':''}}">
      <a href="{{url('/admin/report/')}}">
        <i class="now-ui-icons business_badge"></i>
        <p>Laporan Penjualan</p>
      </a>
    </li>
    @endif

    @if($row->is_report == 1 && $row->user_id == auth()->user()->id)
    <li class="{{Request::is('admin/report/pembeli')?'active':''}}">
      <a href="{{url('/admin/report/pembeli')}}">
        <i class="now-ui-icons files_single-copy-04"></i>
        <p>Laporan Pembeli</p>
      </a>
    </li>
    @endif
    @if($row->is_report == 1 && $row->user_id == auth()->user()->id)
    <li class="{{Request::is('admin/laba')?'active':''}}">
      <a href="{{url('admin/laba')}}">
        <i class="now-ui-icons arrows-1_refresh-69"></i>
        <p>Laporan Laba</p>
      </a>
    </li>
    @endif
    @if($row->is_report == 1 && $row->user_id == auth()->user()->id)

    @endif

    @if($row->is_kas == 1 && $row->user_id == auth()->user()->id)
    <li class="{{Request::is('admin/kas')?'active':''}}">
      <a href="{{url('/admin/kas/')}}">
        <i class="now-ui-icons business_globe"></i>
        <p>Kas</p>
      </a>
    </li>
    @endif

    @if($row->is_stok == 1 && $row->user_id == auth()->user()->id)
    <li class="{{Request::is('admin/restock')?'active':''}}">
      <a href="{{url('/admin/restock/')}}">
        <i class="now-ui-icons health_ambulance"></i>
        <p>Restock</p>
      </a>
    </li>
    @endif

    @if($row->is_cabang == 1 && $row->user_id == auth()->user()->id)
    <li class="{{Request::is('admin/cabang')?'active':''}}">
      <a href="{{url('/admin/cabang/')}}">
        <i class="now-ui-icons location_compass-05"></i>
        <p>Cabang</p>
      </a>
    </li>
    @endif

    @if($row->is_user == 1 && $row->user_id == auth()->user()->id)
    <li class="{{Request::is('admin/user')?'active':''}}">
      <a href="{{url('/admin/user/')}}">
        <i class="now-ui-icons users_single-02"></i>
        <p>User</p>
      </a>
    </li>
    @endif
    @if($row->is_user == 1 && $row->user_id == auth()->user()->id)

    <li >
      <a data-toggle="collapse" href="#pegawai" >
        <i class="now-ui-icons users_circle-08"></i>
        <p>
          Pegawai <b class="caret"></b>
        </p>
      </a>
      <div class="collapse " id="pegawai">
        <ul class="nav">
          <li class="{{Request::is('admin/pegawai/hari')?'active':''}}">
            <a href="{{url('/admin/pegawai/hari')}}">
              <i class="now-ui-icons education_paper"></i>
              <p>Hari Kerja</p>
            </a>
          </li>
          <li class="{{Request::is('admin/pegawai/absensi')?'active':''}}">
            <a href="{{url('/admin/pegawai/absensi')}}">
              <i class="now-ui-icons education_paper"></i>
              <p>Absensi</p>
            </a>
          </li>
          <li class="{{Request::is('admin/pegawai/cuti')?'active':''}}">
            <a href="{{url('/admin/pegawai/cuti')}}">
              <i class="now-ui-icons education_paper"></i>
              <p>Cuti</p>
            </a>
          </li>
          <li class="{{Request::is('admin/pegawai/gaji')?'active':''}}">
            <a href="{{url('/admin/pegawai/gaji')}}">
              <i class="now-ui-icons education_paper"></i>
              <p>Gaji</p>
            </a>
          </li>
          <li class="{{Request::is('admin/pegawai/rekap')?'active':''}}">
            <a href="{{url('/admin/pegawai/rekap')}}">
              <i class="now-ui-icons education_paper"></i>
              <p>Rekap</p>
            </a>
          </li>
          <li class="{{Request::is('admin/pegawai/user')?'active':''}}">
            <a href="{{url('/admin/pegawai/user')}}">
              <i class="now-ui-icons education_paper"></i>
              <p>User Pegawai</p>
            </a>
          </li>
        </ul>
      </div>
    </li>
    <hr style="outline-color: white;">

    @endif
    @if($row->is_user == 1 && $row->user_id == auth()->user()->id && $row->id_team == 1 )
    <li >
      <a data-toggle="collapse" href="#agen" >
        <i class="now-ui-icons design_vector"></i>
        <p>
          Agen <b class="caret"></b>
        </p>
      </a>
      <div class="collapse " id="agen">
        <ul class="nav">
          <li class="{{Request::is('admin/agen')?'active':''}}">
            <a href="{{url('/admin/agen/')}}">
              <i class="now-ui-icons design_vector"></i>
              <p>Agen Distributor</p>
            </a>
          </li>
          <li class="{{Request::is('admin/agen2')?'active':''}}">
            <a href="{{url('/admin/agen2/')}}">
              <i class="now-ui-icons design_vector"></i>
              <p>Super Agen</p>
            </a>
          </li>
          <li class="{{Request::is('admin/agen3')?'active':''}}">
            <a href="{{url('/admin/agen3/')}}">
              <i class="now-ui-icons design_vector"></i>
              <p>Agen Biasa</p>
            </a>
          </li>
        </ul>
      </div>
      <hr style="color: white;">
      <div class="collapse " id="agen">
        <ul class="nav">
          <li class="{{Request::is('admin/agen/bonus/list')?'active':''}}">
            <a href="{{url('/admin/agen/bonus/list')}}">
              <i class="now-ui-icons design_vector"></i>
              <p>List Bonus Agen Distributor</p>
            </a>
          </li>
          <li class="{{Request::is('admin/agen/bonus/list2')?'active':''}}">
            <a href="{{url('/admin/agen/bonus/list2')}}">
              <i class="now-ui-icons design_vector"></i>
              <p>List Bonus Super Agen</p>
            </a>
          </li>
          <li class="{{Request::is('admin/agen/bonus/list3')?'active':''}}">
            <a href="{{url('/admin/agen/bonus/list3')}}">
              <i class="now-ui-icons design_vector"></i>
              <p>List Bonus Agen Biasa</p>
            </a>
          </li>
        </ul>
      </div>
    </li>
    <li >
      <a data-toggle="collapse" href="#database" >
        <i class="now-ui-icons education_atom"></i>
        <p>
          Database <b class="caret"></b>
        </p>
      </a>
      <div class="collapse " id="database">
        <ul class="nav">
          <li class="{{Request::is('admin/database/pembeli')?'active':''}}">
            <a href="{{url('/admin/database/pembeli')}}">
              <i class="now-ui-icons shopping_delivery-fast"></i>
              <p>Database Pembeli</p>
            </a>
          </li>
          <li class="{{Request::is('admin/database')?'active':''}}">
            <a href="{{url('/admin/database')}}">
              <i class="now-ui-icons shopping_delivery-fast"></i>
              <p>Database Wa</p>
            </a>
          </li>
        </ul>
      </div>
    </li>
    @endif

    <!-- member1 -->
    @if($row->is_user == 1 && $row->user_id == auth()->user()->id  && $row->id_team != 1 && auth()->user()->referal2 == NULL)
    <li >
      <a data-toggle="collapse" href="#agen" >
        <i class="now-ui-icons design_vector"></i>
        <p>
          Agen<b class="caret"></b>
        </p>
      </a>
      <div class="collapse " id="agen">
        <ul class="nav">
          <li class="{{Request::is('admin/agen')?'active':''}}">
            <a href="{{url('/admin/agen/')}}">
              <i class="now-ui-icons design_vector"></i>
              <p>Agenku</p>
            </a>
          </li>

        </ul>
      </div>

    </li>

    @endif
    <!-- member2 -->
    @if($row->is_user == 1 && $row->user_id == auth()->user()->id  && $row->id_team != 1 && auth()->user()->referal2 != NULL  && auth()->user()->agen == 2)
    <li >
      <a data-toggle="collapse" href="#agen" >
        <i class="now-ui-icons design_vector"></i>
        <p>
          Agen  <b class="caret"></b>
        </p>
      </a>
      <div class="collapse " id="agen">
        <ul class="nav">
          <li class="{{Request::is('admin/agen2')?'active':''}}">
            <a href="{{url('/admin/agen2/')}}">
              <i class="now-ui-icons design_vector"></i>
              <p>Agenku</p>
            </a>
          </li>

        </ul>
      </div>

    </li>

    @endif
    @if($row->is_user == 1 && $row->user_id == auth()->user()->id  && $row->id_team != 1 && auth()->user()->referal3 != NULL  && auth()->user()->agen == 3)
    <li >
      <a data-toggle="collapse" href="#agen" >
        <i class="now-ui-icons design_vector"></i>
        <p>
          Agen  <b class="caret"></b>
        </p>
      </a>
      <div class="collapse " id="agen">
        <ul class="nav">
          <li class="{{Request::is('admin/agen3')?'active':''}}">
            <a href="{{url('/admin/agen3/')}}">
              <i class="now-ui-icons design_vector"></i>
              <p>Agenku</p>
            </a>
          </li>

        </ul>
      </div>

    </li>

    @endif
    @endforeach

    @foreach ($role as $row)
    @if($row->is_user == 1 && $row->user_id == auth()->user()->id) 
    <li class="{{Request::is('admin/waweb')?'active':''}}">
      <a href="{{url('/admin/waweb/')}}">
        <i class="now-ui-icons sport_user-run"></i>
        <p>Sent WA</p>
      </a>
    </li>
    @endif
    @endforeach
    <li>
      <a href="{{url('/admin/about/')}}">
        <i class="now-ui-icons travel_info"></i>
        <p>Tentang Kami</p>
      </a>
    </li>
    <li>
      <a href="{{url('logout')}}">
        <i class="now-ui-icons business_bank"></i>
        <p>logout</p>
      </a>
    </li>
    @elseif($row->dibayar <= now() && auth()->user()->id == $row->user_id)
    <ul class="nav">
      @foreach ($role as $row)
      @if($row->is_user == 1 && $row->user_id == auth()->user()->id)
      <li class="{{Request::is('admin/user')?'active':''}}">
        <a href="{{url('/admin/user/')}}">
          <i class="now-ui-icons users_single-02"></i>
          <p>User</p>
        </a>
      </li>
      @endif
      @endforeach

      <li>
        <a href="{{url('logout')}}">
          <i class="now-ui-icons business_bank"></i>
          <p>logout</p>
        </a>
      </li>
    </ul>
    <?php 
    redirect('/admin/user');
    ?>
    @endif
    @endforeach
  </div>
</div>

