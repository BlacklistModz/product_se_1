<?php $__env->startSection('content'); ?>

<div class="container">
    <h3 class="text-center"><?php echo e(!empty($data->id) ? "แก้ไข" : "เพิ่ม"); ?>ข้อมูลร้านค้า</h3>
	<div class="card p-3">
		<?php if( !empty($data->id) ): ?>
		<form method="POST" action="<?php echo e(action('StoreController@update', $data->id)); ?>" enctype="multipart/form-data">
			<input type="hidden" name="_method" value="PUT">
		<?php else: ?>
		<form method="POST" action="<?php echo e(url('store')); ?>" enctype="multipart/form-data">
		<?php endif; ?>
		<?php echo csrf_field(); ?>
			<div class="form-group">
				<label for="name">ชื่อร้านค้า</label>
				<input type="text" class="form-control <?php echo e(!empty($errors->first('name')) ? 'is-invalid' : ''); ?>" id="name" name="name" placeholder="ชื่อร้านค้า" value="<?php echo e(!empty($data->name) ? $data->name : old('name')); ?>">
				<?php if( !empty($errors->first('name')) ): ?>
				<message class="text-danger">- <?php echo e($errors->first('name')); ?></message>
				<?php endif; ?>
			</div>
			<div class="form-group">
				<label for="detail">ที่อยู่</label>
				<textarea class="form-control <?php echo e(!empty($errors->first('address')) ? 'is-invalid' : ''); ?>" id="address" rows="3" name="address"><?php echo e(!empty($data->address) ? $data->address : old('address')); ?></textarea>
				<?php if( !empty($errors->first('address')) ): ?>
				<message class="text-danger">- <?php echo e($errors->first('address')); ?></message>
				<?php endif; ?>
			</div>
			<div class="form-group">
				<label for="logo">Logo</label>
				<input type="file" class="form-control" id="logo" name="logo" accept="image/*">
			</div>
			<?php if( !empty($data->logo) ): ?>
			<div class="text-center mb-2">
				<img src="<?php echo e(asset('storage/'.$data->logo)); ?>" width="350">
			</div>
			<?php endif; ?>
			<div class="clearfix">
				<a class="btn btn-danger float-left" href="<?php echo e(url('store')); ?>"><i class="fa fa-arrow-left"></i> ออก</a>
                <!-- <button type="reset" class="btn btn-warning">ล้างค่า</button> -->
				<button type="submit" class="btn btn-primary float-right"><i class="fa fa-save"></i> บันทึก</button>
			</div>
		</form>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>