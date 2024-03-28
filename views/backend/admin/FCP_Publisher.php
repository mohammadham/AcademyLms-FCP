<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body py-2">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo get_phrase('FCP_Publishers'); ?>
                    <button onclick="showAjaxModal('<?php echo site_url('addons/FCP_manager/add_FCP_Publisher'); ?>', '<?php echo get_phrase('add_a_new_FCP_Publisher'); ?>');" class="btn btn-outline-primary btn-rounded alignToTitle"><i class="mdi mdi-plus"></i><?php echo get_phrase('add_new_Publisher'); ?></button>
                </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="row">
	<?php if($Publishers != null): 
		?>
		<?php foreach($Publishers->result_array() as $Publisher): 
			?>
			<div class="col-md-4 mb-3">
				<ul class="list-group list-group-numbered">
					<li class="list-group-item d-flex justify-content-between align-items-start">
						<div class="ml-2 mr-auto">
							<div class="fw-bold" style="font-size: 20px; font-weight: 600;"><?php echo $Publisher['name']; ?></div>
							<div class="fw-bold" style="font-size: 20px; font-weight: 600;"><?php echo $Publisher['base_url']; ?></div>
							<img src="<?php echo base_url('uploads/FCP/thumbnails/Publisher_thumbnails/' . $Publisher['thumbnail']); ?>"  style = "height:200px; width:200px"></img>

						</div>
						<div class="ml-auto text-center">
							<span class="badge badge-primary text-right"><?php echo $this->FCP_model->get_FCPs_by_Publisher_id($Publisher['Publisher_id'])->num_rows(); ?></span>
							

							<div class="btn-group d-block mt-2">
								<button type="button" class="border-0 bg-white" data-toggle="dropdown" aria-expanded="false">
									<i class="mdi mdi-dots-vertical"></i>
								</button>
								<div class="dropdown-menu dropdown-menu-right">
									<button class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('addons/FCP_manager/edit_FCP_Publisher/'.$Publisher['Publisher_id']); ?>', '<?php echo get_phrase('edit_Publisher'); ?>');" type="button"><i class="mdi mdi-pencil"></i> <?php echo get_phrase('edit'); ?></button>
									<button class="dropdown-item" onclick="confirm_modal('<?php echo site_url('addons/FCP_manager/FCP_Publisher/delete/'.$Publisher['Publisher_id']); ?>');" type="button"><i class="mdi mdi-trash-can-outline"></i> <?php echo get_phrase('delete'); ?></button>
								</div>
							</div>
						</div>
					</li>
				</ul>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>
</div>