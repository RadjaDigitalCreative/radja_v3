   <nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
    <div class="container-fluid">
      <div class="navbar-wrapper">
        <div class="navbar-toggle">
          <button type="button" class="navbar-toggler">
            <span class="navbar-toggler-bar bar1"></span>
            <span class="navbar-toggler-bar bar2"></span>
            <span class="navbar-toggler-bar bar3"></span>
          </button>
        </div>
        <a class="navbar-brand" href="#pablo">Radja Sistem / {{$title}}</a>
      </div>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-bar navbar-kebab"></span>
        <span class="navbar-toggler-bar navbar-kebab"></span>
        <span class="navbar-toggler-bar navbar-kebab"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navigation">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="#pablo">
              <i class="now-ui-icons users_single-02"></i>
              <p>
               {{auth()->user()->name}}
             </p>
             <p>
              ({{auth()->user()->level}}) 
              /{{auth()->user()->lokasi}} 
            </p>
          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <p>
              <span class="d-lg-none d-md-block">Some Actions</span>
            </p>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
            @if(auth()->user()->agen == 1)
            <a target="_blank" class="dropdown-item" href="https://wa.me/+62/?text=Your referal number is {{auth()->user()->referal}}">Share Referal</a>
            @elseif(auth()->user()->agen == 2)
            <a target="_blank" class="dropdown-item" href="https://wa.me/+62/?text=Your referal number is {{auth()->user()->referal2}}">Share Referal</a>
            @elseif(auth()->user()->agen == 3)
            <a target="_blank" class="dropdown-item" href="https://wa.me/+62/?text=Your referal number is {{auth()->user()->referal3}}">Share Referal</a>
            @endif
            <a class="dropdown-item" href="{{ url('/admin/referal')}}">Copy Referal</a> 
            <a class="dropdown-item" href="{{ url('/logout')}}">Logout</a>
          </div>
        </li> 
      </ul>
    </div>
  </div>
</nav>
<div class="panel-header panel-header-sm">
</div>