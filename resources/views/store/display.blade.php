@extends('layouts.app')

@section('content')

<div class="container">
	<div class="clearfix mb-2">
		<div class="float-left">
			<form method="GET" class="form-inline">
				<div class="form-group">
					<label for="limit" class="sr-only">Limit</label>
					<select class="form-control" id="limit" name="limit">
						@php
							$limits = [5, 10, 15, 20];
						@endphp
						@for($i=0; $i < count($limits); $i++)
							@php
								$sel = $limits[$i] == $limit ? 'selected="1"' : '';
							@endphp
						<option {{ $sel }} value="{{ $limits[$i] }}">{{ $limits[$i] }}</option>
						@endfor
					</select>
				</div>
				<div class="form-group">
					<label for="search" class="sr-only">Search</label>
					<input type="text" class="form-control" id="search" name="search" placeholder="ค้นหา ชื่อร้าน / ที่อยู่" value="{{ !empty($_GET['search']) ? $_GET['search'] : '' }}">
				</div>
				<button type="submit" class="btn btn-success"><i class="fa fa-search"></i></button>
			</form>
		</div>
		<a href="{{ url('store/create') }}" class="btn btn-primary float-right">เพิ่มข้อมูล</a>
	</div>
	<div class="clearfix">
		<table class="table table-bordered">
			<thead class="text-center table-dark">
				<tr>
					<th width="5%">#</th>
					<th width="15%">โลโก้</th>
					<th width="25%">ชื่อร้านค้า</th>
					<th width="25%">ที่อยู่</th>
					<th width="15%">แก้ไขล่าสุด</th>
					<th width="15%">จัดการ</th>
				</tr>
			</thead>
			<tbody>

				@php
					#SET INFO NUMBER OF LISTS
					$Number = 0;
					$start = 1;
					$end = $limit < count($data) ? $limit : count($data);
				@endphp
				
				@if( $data->currentPage() > 1 )

					@php
						$Number = $limit * ($data->currentPage() - 1);

						$start = $limit * ($data->currentPage() - 1) + 1;
						$end = $start + ($limit - 1);
					@endphp

					@if( $end >= $data->total() )
						@php
							$end = $data->total();
						@endphp
					@endif

				@endif

				@foreach( $data as $key => $value )
				<tr>
					<td class="text-center">{{ $Number + $loop->iteration }}</td>
					<td class="text-center">
						@if( !empty($value->logo) )
							<img src="{{ asset('storage/'.$value->logo) }}" style="width: 80px; height: auto;">
						@else
							<img src="{{ asset('storage/no-image.jpg') }}" style="width: 80px; height: auto;">
						@endif
					</td>
					<td>{{ $value->name }}</td>
					<td>{{ $value->address }}</td>
					<td class="text-center">{{ $value->updated_at }}</td>
					<td class="text-center">
						<a href="{{ action('StoreController@edit', $value->id) }}" class="btn btn-warning">แก้ไข</a>
						<a href="{{ action('StoreController@delete', $value->id) }}" onclick="return confirm('คุณต้องการลบข้อมูลนี้ ใช่หรือไม่ ?')" class="btn btn-danger">ลบ</a>
					</td>
				</tr>
				@endforeach
			</tbody>
			<tfoot class="table-dark">
				<tr>
					<th colspan="6">แสดงข้อมูลจำนวน {{ $start }} ถึง {{ $end }} จาก {{ $data->total() }} รายการ</th>
				</tr>
			</tfoot>
		</table>
		{{ $data->appends(request()->query())->links() }}
	</div>
</div>
@endsection