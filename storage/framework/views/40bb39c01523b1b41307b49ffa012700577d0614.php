<?php $__env->startSection('content'); ?>

<div class="container">
	<div class="clearfix mb-2">
		<div class="float-left">
			<form method="GET" class="form-inline">
				<div class="form-group">
					<label for="limit" class="sr-only">Limit</label>
					<select class="form-control" id="limit" name="limit">
						<?php
							$limits = [5, 10, 15, 20];
						?>
						<?php for($i=0; $i < count($limits); $i++): ?>
							<?php
								$sel = $limits[$i] == $limit ? 'selected="1"' : '';
							?>
						<option <?php echo e($sel); ?> value="<?php echo e($limits[$i]); ?>"><?php echo e($limits[$i]); ?></option>
						<?php endfor; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="search" class="sr-only">Search</label>
					<input type="text" class="form-control" id="search" name="search" placeholder="ค้นหา ชื่อสินค้า" value="<?php echo e(!empty($_GET['search']) ? $_GET['search'] : ''); ?>">
				</div>
				<button type="submit" class="btn btn-success"><i class="fa fa-search"></i></button>
			</form>
		</div>
		<a href="<?php echo e(url('producttype/create')); ?>" class="btn btn-primary float-right">เพิ่มข้อมูล</a>
	</div>
	<div class="clearfix">
		<table class="table table-bordered">
			<thead class="text-center table-dark">
				<tr>
					<th width="5%">#</th>
					<th width="60%">ชื่อประเภทสินค้า</th>
					<th width="20%">แก้ไขล่าสุด</th>
					<th width="15%">จัดการ</th>
				</tr>
			</thead>
			<tbody>

				<?php
					#SET INFO NUMBER OF LISTS
					$Number = 0;
					$start = 1;
					$end = $limit < count($data) ? $limit : count($data);
				?>
				
				<?php if( $data->currentPage() > 1 ): ?>

					<?php
						$Number = $limit * ($data->currentPage() - 1);

						$start = $limit * ($data->currentPage() - 1) + 1;
						$end = $start + ($limit - 1);
					?>

					<?php if( $end >= $data->total() ): ?>
						<?php
							$end = $data->total();
						?>
					<?php endif; ?>

				<?php endif; ?>

				<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<tr>
					<td class="text-center"><?php echo e($Number + $loop->iteration); ?></td>
					<td><?php echo e($value->name); ?></td>
					<td class="text-center"><?php echo e($value->updated_at); ?></td>
					<td class="text-center">
						<a href="<?php echo e(action('ProductTypeController@edit', $value->id)); ?>" class="btn btn-warning">แก้ไข</a>
						<a href="<?php echo e(action('ProductTypeController@delete', $value->id)); ?>" onclick="return confirm('คุณต้องการลบข้อมูลนี้ ใช่หรือไม่ ?')" class="btn btn-danger">ลบ</a>
					</td>
				</tr>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</tbody>
			<tfoot class="table-dark">
				<tr>
					<th colspan="5">แสดงข้อมูลจำนวน <?php echo e($start); ?> ถึง <?php echo e($end); ?> จาก <?php echo e($data->total()); ?> รายการ</th>
				</tr>
			</tfoot>
		</table>
		<?php echo e($data->appends(request()->query())->links()); ?>

	</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>