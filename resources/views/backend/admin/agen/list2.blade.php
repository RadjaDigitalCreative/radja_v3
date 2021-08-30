@extends('layout.main')
@section('title', $title)
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">Super Agen</h4>
				@if(auth()->user()->level == 'Owner') 
				<div  class="btn-group">
					<a href="{{route('agen.bonus2')}}"><button type="button" class="btn btn-success"><i class="now-ui-icons ui-1_simple-add"></i> Edit Bonus Agen</button></a>

				</div>
				@endif

			</div>
			<div class="card-body">
				<div class="toolbar">
				</div>
				<table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama Agen</th>
							<th>Referal Agen</th>
							<th>Jumlah Member</th>
							<th>Agen From</th>
							<th>Dibuat</th>
							<th class="disabled-sorting text-right">Actions</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>No</th>
							<th>Nama Agen</th>
							<th>Referal Agen</th>
							<th>Jumlah Member</th>
							<th>Agen From</th>
							<th>Dibuat</th>
							<th class="disabled-sorting text-right">Actions</th>
						</tr>
					</tfoot>
					<tbody>
						@php
						$nomor = 1;
						@endphp
						@foreach ($data as $row)
						@if($row->referal2 != NULL)

						<tr>
							<td>{{$nomor++}}</td>
							<td>{{$row->name}}</td>
							<td>{{$row->referal2}}</td>
							<td>
								@foreach ($link as $links)
								@if($links->referal2 == $row->referal2)
								{{$links->total}} Member
								@endif
								@endforeach
							</td>
							<td>
								@foreach ($ref as $refs)
								@if($refs->referal == $row->referal && $refs->agen == 1)
								{{$refs->name}} 
								@endif
								@endforeach
							</td>
							<td>{{$row->created_at}}</td>
							<td align="center">
								@include('backend.admin.agen.view2')
								<a data-toggle="modal" data-target="#modal-bonus{{$row->id}}" href=""><button type="button" class="btn btn-danger"><i class="now-ui-icons business_bulb-63"></i> View </button></a>
							</td>
						</tr>
						@endif
						@endforeach
					</tbody>
				</table>

			</div>
		</div>
	</div>
</div>
@endsection
