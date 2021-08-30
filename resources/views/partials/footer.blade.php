  <script src="{{asset('assets/js/core/jquery.min.js')}}"></script>
  <script src="{{asset('assets/js/core/popper.min.js')}}"></script>
  <script src="{{asset('assets/js/core/bootstrap.min.js')}}"></script>
  <script src="{{asset('assets/js/plugins/perfect-scrollbar.jquery.min.js')}}"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chart JS -->
  <script src="{{asset('assets/js/plugins/chartjs.min.js')}}"></script>
  <!--  Notifications Plugin    -->
  <script src="{{asset('assets/js/plugins/bootstrap-notify.js')}}"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{asset('assets/js/now-ui-dashboard.min.js?v=1.5.0')}}" type="text/javascript"></script><!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
  <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
  <!-- <script type="text/javascript"  src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script> -->
  <script src="{{asset('assets/demo/demo.js')}}"></script>
  <script src="{{asset('assets/js/sweetalert.min.js')}}"></script>
  <script src="{{asset('assets/js/jquerycountdown/jquery.countdown.js')}}"></script>
  <script src="{{asset('assets/js/jquerycountdown/jquery.countdown.min.js')}}"></script>

  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script> -->
  <!-- <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script> -->
  <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

  @include('sweet::alert')
  <script>
  	$(document).ready(function() {
      demo.initDashboardPageCharts();
    });
    $(document).ready(function(){
      $('#masking1').mask('#.##0', {reverse: true});
      $('#masking2').mask('#.##0', {reverse: true});
      $('#masking3').mask('#.##0', {reverse: true});
      $('#masking4').mask('#.##0', {reverse: true});
      $('#masking5').mask('#.##0', {reverse: true});
      $('#masking6').mask('#.##0', {reverse: true});
      $('#masking7').mask('#.##0', {reverse: true});
      $('#masking8').mask('#.##0', {reverse: true});
      $('#masking9').mask('#.##0', {reverse: true});
      
    })
  </script>
  <script>
    $(document).ready( function () {
      $('#table_id').DataTable({
        "scrollX": true,
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
      });
    } );
  </script>
  <script>
    $(document).ready( function () {
      $('#table_id2').DataTable({
        "scrollX": true,
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bInfo": false,
        "bAutoWidth": false
      });
    } );
  </script>
  <script>
    $(document).ready( function () {
      $('#table_id3').DataTable({
        "scrollX": true,
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
      });
    } );
  </script>
  
  <script type="text/javascript">
    function deleteRow(id)
    {
      swal({
        title: "Apakah Anda Yakin?",
        text: "Menghapus data ini!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $('#data-'+id).submit();
        }
      });
    }
  </script>
  <!-- <script src="http://code.jquery.com/jquery-2.2.1.min.js"></script> -->
  <script>
    $(document).ready(function(){
      $(".preloader").fadeOut();
    })
  </script>

  @yield('script')
</body>
</html>