<form action="<?php echo site_url('addons/FCP_manager/FCP_category/update/'. $FCP_category['category_id']); ?>" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="category_title"><?php echo get_phrase('title'); ?></label>
		<input class="form-control" type="text" id="category_title" value="<?php echo $FCP_category['title'] ?>" name="title" required>
	</div>
	<div class="form-group">
		<label for="category_thumbnail"><?php echo get_phrase('thumbnail'); ?></label>
		<input class="form-control" type="file" id="category_thumbnail" name="category_thumbnail">
	</div>
	

	<div class="form-group">
		<button type="submit" class="btn btn-primary"><?php echo get_phrase('submit'); ?></button>
	</div>
</form>