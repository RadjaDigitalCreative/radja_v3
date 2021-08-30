 <?php 
 $title = 'Verifikasi Email';
 ?>
 @include('partials.header')
 <div class="wrapper ">
 	<div class="sidebar" data-color="blue">
 		<div class="logo">
 			<a href="#" class="simple-text logo-mini">
 				<img style="border-radius: 50%;" src="{{asset('/images/logo.png')}}">
 			</a>
 			<a href="#" class="simple-text logo-normal">
 				Radja Sistem  
 			</a>
 		</div>
 		<div class="sidebar-wrapper" id="sidebar-wrapper">
 		</div>
 	</div>

 	<div class="main-panel" id="main-panel">
 		@include('layout.navbar')

 		<div class="content">
 			@yield('content')
 		</div>
 		@include('layout.footer')
 	</div>
 </div>
 @include('partials.footer')
