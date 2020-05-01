<?php $__env->startSection('content'); ?>

<div class="container">
    <h3 class="text-center"><?php echo e(!empty($data->id) ? "แก้ไข" : "เพิ่ม"); ?>ข้อมูลสินค้า</h3>
	<div class="card p-3">
		<?php if( !empty($data->id) ): ?>
		<form method="POST" action="<?php echo e(action('ProductController@update', $data->id)); ?>" enctype="multipart/form-data">
			<input type="hidden" name="_method" value="PUT">
		<?php else: ?>
		<form method="POST" action="<?php echo e(url('product')); ?>" enctype="multipart/form-data">
		<?php endif; ?>
		<?php echo csrf_field(); ?>
			<div class="form-group">
				<label for="store">ร้านค้า</label>
				<select class="form-control <?php echo e(!empty($errors->first('store')) ? 'is-invalid' : ''); ?>" name="store" id="store">
					<option value="">- เลือกร้านค้า -</option>
					<?php $__currentLoopData = $store; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php
							$sel = '';
						?>

						<?php if( !empty($data->store) ): ?>
							<?php if( $value->id == $data->store ): ?>
								<?php
									$sel = 'selected="1"';
								?>
							<?php endif; ?>
						<?php endif; ?>

						<?php if( $value->id == old('store') ): ?>
							<?php
								$sel = 'selected="1"';
							?>
						<?php endif; ?>
					<option <?php echo e($sel); ?> value="<?php echo e($value->id); ?>"><?php echo e($value->name); ?></option>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</select>
				<?php if( !empty($errors->first('store')) ): ?>
				<message class="text-danger">- <?php echo e($errors->first('store')); ?></message>
				<?php endif; ?>
			</div>
			<div class="form-group">
				<label for="type">ประเภทสินค้า</label>
				<select class="form-control <?php echo e(!empty($errors->first('type')) ? 'is-invalid' : ''); ?>" name="type" id="type">
					<option value="">- เลือกประเภทสินค้า -</option>
					<?php $__currentLoopData = $type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php
							$sel = '';
						?>

						<?php if( !empty($data->type) ): ?>
							<?php if( $value->id == $data->type ): ?>
								<?php
									$sel = 'selected="1"';
								?>
							<?php endif; ?>
						<?php endif; ?>

						<?php if( $value->id == old('type') ): ?>
							<?php
								$sel = 'selected="1"';
							?>
						<?php endif; ?>
					<option <?php echo e($sel); ?> value="<?php echo e($value->id); ?>"><?php echo e($value->name); ?></option>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</select>
				<?php if( !empty($errors->first('type')) ): ?>
				<message class="text-danger">- <?php echo e($errors->first('type')); ?></message>
				<?php endif; ?>
			</div>
			<div class="form-group">
				<label for="name">ชื่อสินค้า</label>
				<input type="text" class="form-control <?php echo e(!empty($errors->first('name')) ? 'is-invalid' : ''); ?>" id="name" name="name" placeholder="ชื่อสินค้า" value="<?php echo e(!empty($data->name) ? $data->name : old('name')); ?>">
				<?php if( !empty($errors->first('name')) ): ?>
				<message class="text-danger">- <?php echo e($errors->first('name')); ?></message>
				<?php endif; ?>
			</div>
			<div class="form-group">
				<label for="detail">รายละเอียด</label>
				<textarea class="form-control <?php echo e(!empty($errors->first('detail')) ? 'is-invalid' : ''); ?>" id="detail" rows="3" name="detail"><?php echo e(!empty($data->detail) ? $data->detail : old('detail')); ?></textarea>
				<?php if( !empty($errors->first('detail')) ): ?>
				<message class="text-danger">- <?php echo e($errors->first('detail')); ?></message>
				<?php endif; ?>
			</div>
			<div class="form-group">
				<label for="price">ราคา</label>
				<input type="text" class="form-control <?php echo e(!empty($errors->first('price')) ? 'is-invalid' : ''); ?>" id="price" name="price" placeholder="ราคา" value="<?php echo e(!empty($data->price) ? $data->price : old('price')); ?>">
				<?php if( !empty($errors->first('price')) ): ?>
				<message class="text-danger">- <?php echo e($errors->first('price')); ?></message>
				<?php endif; ?>
			</div>
			<div class="form-group">
				<label for="image">รูป</label>
				<input type="file" class="form-control" id="image" name="image" accept="image/*">
			</div>
			<?php if( !empty($data->image) ): ?>
			<div class="text-center mb-2">
				<img src="<?php echo e(asset('storage/'.$data->image)); ?>" width="350">
			</div>
			<?php endif; ?>
			<div class="clearfix">
				<a class="btn btn-danger float-left" href="<?php echo e(url('product')); ?>"><i class="fa fa-arrow-left"></i> ออก</a>
                <!-- <button type="reset" class="btn btn-warning">ล้างค่า</button> -->
				<button type="submit" class="btn btn-primary float-right"><i class="fa fa-save"></i> บันทึก</button>
			</div>
		</form>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>