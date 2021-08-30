 @include('partials.header')

 <div class="wrapper ">
 	@include('layout.sidebar')
 	<div class="main-panel" id="main-panel">
 		@include('layout.navbar')
 		
 		<div class="content">
 			@yield('content')
 		</div>
 		@include('layout.footer')
 	</div>
 </div>
 
 @include('partials.footer')
