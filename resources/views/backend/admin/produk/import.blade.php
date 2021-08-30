<div style="text-align: center;" class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<h6>Import CSV</h6>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<i class="now-ui-icons ui-1_simple-remove"></i>
				</button>
			</div>
			<div class="modal-body">
				<form action="{{ route('item.import') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<input type="file" name="file" class="form-control">
					<br>
					<button class="btn btn-success">Import </button>
				</form>
			</div>
		</div>
	</div>
</div>

