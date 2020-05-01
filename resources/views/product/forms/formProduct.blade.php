@extends('layouts.app')

@section('content')

<div class="container">
    <h3 class="text-center">{{ !empty($data->id) ? "แก้ไข" : "เพิ่ม" }}ข้อมูลสินค้า</h3>
	<div class="card p-3">
		@if( !empty($data->id) )
		<form method="POST" action="{{ action('ProductController@update', $data->id) }}" enctype="multipart/form-data">
			<input type="hidden" name="_method" value="PUT">
		@else
		<form method="POST" action="{{ url('product') }}" enctype="multipart/form-data">
		@endif
		@csrf
			<div class="form-group">
				<label for="store">ร้านค้า</label>
				<select class="form-control {{ !empty($errors->first('store')) ? 'is-invalid' : '' }}" name="store" id="store">
					<option value="">- เลือกร้านค้า -</option>
					@foreach( $store AS $key => $value )
						@php
							$sel = '';
						@endphp

						@if( !empty($data->store) )
							@if( $value->id == $data->store )
								@php
									$sel = 'selected="1"';
								@endphp
							@endif
						@endif

						@if( $value->id == old('store') )
							@php
								$sel = 'selected="1"';
							@endphp
						@endif
					<option {{ $sel }} value="{{ $value->id }}">{{ $value->name }}</option>
					@endforeach
				</select>
				@if( !empty($errors->first('store')) )
				<message class="text-danger">- {{ $errors->first('store') }}</message>
				@endif
			</div>
			<div class="form-group">
				<label for="type">ประเภทสินค้า</label>
				<select class="form-control {{ !empty($errors->first('type')) ? 'is-invalid' : '' }}" name="type" id="type">
					<option value="">- เลือกประเภทสินค้า -</option>
					@foreach( $type AS $key => $value )
						@php
							$sel = '';
						@endphp

						@if( !empty($data->type) )
							@if( $value->id == $data->type )
								@php
									$sel = 'selected="1"';
								@endphp
							@endif
						@endif

						@if( $value->id == old('type') )
							@php
								$sel = 'selected="1"';
							@endphp
						@endif
					<option {{ $sel }} value="{{ $value->id }}">{{ $value->name }}</option>
					@endforeach
				</select>
				@if( !empty($errors->first('type')) )
				<message class="text-danger">- {{ $errors->first('type') }}</message>
				@endif
			</div>
			<div class="form-group">
				<label for="name">ชื่อสินค้า</label>
				<input type="text" class="form-control {{ !empty($errors->first('name')) ? 'is-invalid' : '' }}" id="name" name="name" placeholder="ชื่อสินค้า" value="{{ !empty($data->name) ? $data->name : old('name') }}">
				@if( !empty($errors->first('name')) )
				<message class="text-danger">- {{ $errors->first('name') }}</message>
				@endif
			</div>
			<div class="form-group">
				<label for="detail">รายละเอียด</label>
				<textarea class="form-control {{ !empty($errors->first('detail')) ? 'is-invalid' : '' }}" id="detail" rows="3" name="detail">{{ !empty($data->detail) ? $data->detail : old('detail') }}</textarea>
				@if( !empty($errors->first('detail')) )
				<message class="text-danger">- {{ $errors->first('detail') }}</message>
				@endif
			</div>
			<div class="form-group">
				<label for="price">ราคา</label>
				<input type="text" class="form-control {{ !empty($errors->first('price')) ? 'is-invalid' : '' }}" id="price" name="price" placeholder="ราคา" value="{{ !empty($data->price) ? $data->price : old('price') }}">
				@if( !empty($errors->first('price')) )
				<message class="text-danger">- {{ $errors->first('price') }}</message>
				@endif
			</div>
			<div class="form-group">
				<label for="image">รูป</label>
				<input type="file" class="form-control" id="image" name="image" accept="image/*">
			</div>
			@if( !empty($data->image) )
			<div class="text-center mb-2">
				<img src="{{ asset('storage/'.$data->image) }}" width="350">
			</div>
			@endif
			<div class="clearfix">
				<a class="btn btn-danger float-left" href="{{ url('product') }}"><i class="fa fa-arrow-left"></i> ออก</a>
                <!-- <button type="reset" class="btn btn-warning">ล้างค่า</button> -->
				<button type="submit" class="btn btn-primary float-right"><i class="fa fa-save"></i> บันทึก</button>
			</div>
		</form>
	</div>
</div>
@endsection