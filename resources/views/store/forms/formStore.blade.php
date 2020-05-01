@extends('layouts.app')

@section('content')

<div class="container">
    <h3 class="text-center">{{ !empty($data->id) ? "แก้ไข" : "เพิ่ม" }}ข้อมูลร้านค้า</h3>
	<div class="card p-3">
		@if( !empty($data->id) )
		<form method="POST" action="{{ action('StoreController@update', $data->id) }}" enctype="multipart/form-data">
			<input type="hidden" name="_method" value="PUT">
		@else
		<form method="POST" action="{{ url('store') }}" enctype="multipart/form-data">
		@endif
		@csrf
			<div class="form-group">
				<label for="name">ชื่อร้านค้า</label>
				<input type="text" class="form-control {{ !empty($errors->first('name')) ? 'is-invalid' : '' }}" id="name" name="name" placeholder="ชื่อร้านค้า" value="{{ !empty($data->name) ? $data->name : old('name') }}">
				@if( !empty($errors->first('name')) )
				<message class="text-danger">- {{ $errors->first('name') }}</message>
				@endif
			</div>
			<div class="form-group">
				<label for="detail">ที่อยู่</label>
				<textarea class="form-control {{ !empty($errors->first('address')) ? 'is-invalid' : '' }}" id="address" rows="3" name="address">{{ !empty($data->address) ? $data->address : old('address') }}</textarea>
				@if( !empty($errors->first('address')) )
				<message class="text-danger">- {{ $errors->first('address') }}</message>
				@endif
			</div>
			<div class="form-group">
				<label for="logo">Logo</label>
				<input type="file" class="form-control" id="logo" name="logo" accept="image/*">
			</div>
			@if( !empty($data->logo) )
			<div class="text-center mb-2">
				<img src="{{ asset('storage/'.$data->logo) }}" width="350">
			</div>
			@endif
			<div class="clearfix">
				<a class="btn btn-danger float-left" href="{{ url('store') }}"><i class="fa fa-arrow-left"></i> ออก</a>
                <!-- <button type="reset" class="btn btn-warning">ล้างค่า</button> -->
				<button type="submit" class="btn btn-primary float-right"><i class="fa fa-save"></i> บันทึก</button>
			</div>
		</form>
	</div>
</div>
@endsection