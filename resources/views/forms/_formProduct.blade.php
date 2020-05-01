@extends('layouts.app')

@section('content')

<div class="container">
    <h3 class="text-center">เพิ่มสินค้า</h3>
	<div class="card p-3">
		<form method="POST" action="{{ url('product') }}" class="form-check">
        @csrf
			<div class="form-group">
				<label for="name">ชื่อสินค้า</label>
				<input type="text" class="form-control {{ $errors->first('name') ? 'is-invalid' : '' }}" id="name" name="name" placeholder="ชื่อสินค้า" value="{{ old('name') }}">
				@if( !empty($errors->first('name')) )
					<div class="invalid-feedback error-name">{{ $errors->first('name') }}</div>
				@endif
			</div>
			<div class="form-group">
				<label for="detail">รายละเอียด</label>
				<textarea class="form-control {{ $errors->first('detail') ? 'is-invalid' : '' }}" id="detail" rows="3" name="detail">{{ old('detail') }}</textarea>
				@if( !empty($errors->first('detail')) )
					<div class="invalid-feedback error-detail">{{ $errors->first('detail') }}</div>
				@endif
			</div>
			<div class="form-group">
				<label for="price">ราคา</label>
				<input type="text" class="form-control {{ $errors->first('price') ? 'is-invalid' : '' }}" id="price" name="price" placeholder="ราคา" value="{{ old('price') }}">
				@if( !empty($errors->first('price')) )
					<div class="invalid-feedback error-price">{{ $errors->first('price') }}</div>
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