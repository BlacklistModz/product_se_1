@extends('layouts.app')

@section('content')

<div class="container">
    <h3 class="text-center">{{ !empty($data->id) ? "แก้ไข" : "เพิ่ม" }}ข้อมูลประเภทสินค้า</h3>
	<!-- @if( count($errors) > 0 )
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			<ul>
				@foreach( $errors->all() as $error )
				<li>{{ $error }}</li>
				@endforeach
			</ul>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	@endif -->
	<div class="card p-3">
		@if( !empty($data->id) )
		<form method="POST" action="{{ action('ProductTypeController@update', $data->id) }}">
			<input type="hidden" name="_method" value="PUT">
		@else
		<form method="POST" action="{{ url('producttype') }}">
		@endif
		@csrf
			<div class="form-group">
				<label for="name">ชื่อประเภทสินค้า</label>
				<input type="text" class="form-control {{ !empty($errors->first('name')) ? 'is-invalid' : '' }}" id="name" name="name" placeholder="ชื่อประเภทสินค้า" value="{{ !empty($data->name) ? $data->name : old('name') }}">
				@if( !empty($errors->first('name')) )
				<message class="text-danger">- {{ $errors->first('name') }}</message>
				@endif
			</div>
			<div class="clearfix text-center">
				<a class="btn btn-danger" href="{{ url('product') }}">ออก</a>
                <button type="reset" class="btn btn-warning">ล้างค่า</button>
				<button type="submit" class="btn btn-primary">บันทึก</button>
			</div>
		</form>
	</div>
</div>
@endsection