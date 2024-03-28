<form action="<?php echo site_url('addons/FCP_manager/FCP_Publisher/add'); ?>" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="Publisher_name"><?php echo get_phrase('name'); ?></label>
		<input class="form-control" type="text" id="Publisher_name" name="name" required>
	</div>
	<div class="form-group">
		<label for="Publisher_base_url"><?php echo get_phrase('base_url'); ?></label>
		<input class="form-control" type="text" id="Publisher_base_url" name="base_url" required>
	</div>
	
	<div class="form-group">
		<label for="Publisher_thumbnail"><?php echo get_phrase('thumbnail'); ?></label>
		<input class="form-control" type="file" id="Publisher_thumbnail" name="Publisher_thumbnail">
	</div>
	<!-- description need -->

	<div class="form-group">
		<button type="submit" class="btn btn-primary"><?php echo get_phrase('submit'); ?></button>
	</div>
</form>