@extends('layouts.app')

@section('content')

<div class="container">
	<div class="clearfix mb-2">
		<div class="float-left">
			<form method="GET" class="form-inline">
				<div class="form-group mr-2">
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
				<div class="form-group mr-2">
					<label for="type" class="sr-only">Type</label>
					<select class="form-control" id="type" name="type">
						<option value="">- เลือกประเภทสินค้า -</option>
						@foreach($type as $value)
							@php
								$sel = '';
							@endphp
							@if( !empty($_GET['type']) )
								@if( $_GET['type'] == $value->id )
									@php
										$sel = 'selected="1"';
									@endphp
								@endif
							@endif
						<option {{ $sel }} value="{{ $value->id }}">{{ $value->name }}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group mr-2">
					<label for="store" class="sr-only">Store</label>
					<select class="form-control" id="store" name="store">
						<option value="">- เลือกร้านค้า -</option>
						@foreach($store as $value)
							@php
								$sel = '';
							@endphp
							@if( !empty($_GET['store']) )
								@if( $_GET['store'] == $value->id )
									@php
										$sel = 'selected="1"';
									@endphp
								@endif
							@endif
						<option {{ $sel }} value="{{ $value->id }}">{{ $value->name }}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group mr-2">
					<label for="search" class="sr-only">Search</label>
					<input type="text" class="form-control" id="search" name="search" placeholder="ค้นหา ชื่อสินค้า" value="{{ !empty($_GET['search']) ? $_GET['search'] : '' }}">
				</div>
				<button type="submit" class="btn btn-success"><i class="fa fa-search"></i> ค้นหา</button>
			</form>
		</div>
		<a href="{{ url('product/create') }}" class="btn btn-primary float-right"><i class="fa fa-plus"></i> เพิ่มข้อมูล</a>
	</div>
	<div class="clearfix">
		<table class="table table-bordered">
			<thead class="text-center table-dark">
				<tr>
					<th width="5%">#</th>
					<th width="10%">รูปภาพ</th>
					<th width="45%">ชื่อสินค้า</th>
					<th width="10%">ราคา</th>
					<th width="20%">แก้ไขล่าสุด</th>
					<th width="10%">จัดการ</th>
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
						@if( !empty($value->image) )
						<img src="{{ asset('storage/'.$value->image) }}" style="width: 80px; height: auto;">
						@else
						<img src="{{ asset('storage/images/no-image.jpg') }}" style="width: 80px; height: auto;">
						@endif
					</td>
					<td>
						<div><span style="font-weight: bold;">{{ $value->name }}</span></div>
						<div style="font-size: 10pt;">
							ประเภท : <span style="color: gray;">{{ $value->typename }}</span>
						</div>
						<div style="font-size: 10pt;">
							ร้าน : <span style="color: gray;">{{ $value->storename }}</span>
						</div>
					</td>
					<td class="text-center">{{ number_format($value->price) }} บาท</td>
					<td class="text-center">{{ date('d-M-Y H:i', strtotime($value->updated_at)) }}</td>
					<td class="text-center">
						<a href="{{ action('ProductController@edit', $value->id) }}" class="btn btn-warning"><i class="fa fa-pen"></i></a>
						<a href="{{ action('ProductController@delete', $value->id) }}" onclick="return confirm('คุณต้องการลบข้อมูลนี้ ใช่หรือไม่ ?')" class="btn btn-danger"><i class="fa fa-trash"></i></a>
					</td>
				</tr>
				@endforeach
			</tbody>
			<tfoot class="table-dark">
				<tr>
					<th colspan="6">
						<div class="float-left">
							แสดงข้อมูลจำนวน {{ $start }} ถึง {{ $end }} จาก {{ $data->total() }} รายการ
						</div>
					</th>
				</tr>
			</tfoot>
		</table>
		<div class="clearfix">
			<div class="float-right">
				{{ $data->appends(request()->query())->links() }}
			</div>
		</div>
	</div>
</div>
@endsection