<?php $__env->startSection('content'); ?>

<div class="container">
    <h3 class="text-center"><?php echo e(!empty($data->id) ? "แก้ไข" : "เพิ่ม"); ?>ข้อมูลประเภทสินค้า</h3>
	<!-- <?php if( count($errors) > 0 ): ?>
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			<ul>
				<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<li><?php echo e($error); ?></li>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</ul>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	<?php endif; ?> -->
	<div class="card p-3">
		<?php if( !empty($data->id) ): ?>
		<form method="POST" action="<?php echo e(action('ProductTypeController@update', $data->id)); ?>">
			<input type="hidden" name="_method" value="PUT">
		<?php else: ?>
		<form method="POST" action="<?php echo e(url('producttype')); ?>">
		<?php endif; ?>
		<?php echo csrf_field(); ?>
			<div class="form-group">
				<label for="name">ชื่อประเภทสินค้า</label>
				<input type="text" class="form-control <?php echo e(!empty($errors->first('name')) ? 'is-invalid' : ''); ?>" id="name" name="name" placeholder="ชื่อประเภทสินค้า" value="<?php echo e(!empty($data->name) ? $data->name : old('name')); ?>">
				<?php if( !empty($errors->first('name')) ): ?>
				<message class="text-danger">- <?php echo e($errors->first('name')); ?></message>
				<?php endif; ?>
			</div>
			<div class="clearfix text-center">
				<a class="btn btn-danger" href="<?php echo e(url('product')); ?>">ออก</a>
                <button type="reset" class="btn btn-warning">ล้างค่า</button>
				<button type="submit" class="btn btn-primary">บันทึก</button>
			</div>
		</form>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>