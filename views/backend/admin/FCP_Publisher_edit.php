<form action="<?php echo site_url('addons/FCP_manager/FCP_Publisher/update/'. $FCP_Publisher['Publisher_id']); ?>" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="Publisher_name"><?php echo get_phrase('name'); ?></label>
		<input class="form-control" type="text" id="Publisher_name" value="<?php echo $FCP_Publisher['name'] ?>" name="name" required>
	</div>
	<div class="form-group">
		<label for="Publisher_base_url"><?php echo get_phrase('base_url'); ?></label>
		<input class="form-control" type="text" id="Publisher_base_url" value="<?php echo $FCP_Publisher['base_url'] ?>" name="name" required>
	</div>
	<div class="form-group">
		<label for="Publisher_thumbnail"><?php echo get_phrase('thumbnail'); ?></label>
		<input class="form-control" type="file" id="Publisher_thumbnail" name="Publisher_thumbnail">
	</div>
	

	<div class="form-group">
		<button type="submit" class="btn btn-primary"><?php echo get_phrase('submit'); ?></button>
	</div>
</form>