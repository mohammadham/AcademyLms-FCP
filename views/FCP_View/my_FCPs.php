<?php include "breadcrumb.php"; ?>


<section class="user-dashboard-area pt-3">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-lg-3">
                <?php include "profile_menus.php"; ?>
            </div>
            <div class="col-md-8 col-lg-9 mt-4 mt-md-0">
                <div class="my-course-1-full-body">
                    <h1><?php echo get_phrase('FCPs'); ?></h1>
                    <div class="row">
                    <?php foreach ($my_FCPs->result_array() as $key => $FCP) :
                        $FCP_payment_history = $this->db->get_where('FCP_payment', array('user_id' => $this->session->userdata('user_id'), 'FCP_id' => $FCP['FCP_id']))->row_array();
                        $instructor_details = $this->user_model->get_all_user($FCP['user_id'])->row_array(); ?>
                        <div class="col-lg-4 col-sm-6">
                            <div class="FCP-item-one">
                                <div class="img"><img src="<?php echo $this->FCP_model->get_FCP_thumbnail_url($FCP['FCP_id']); ?>" alt="" width="100%"/></div>
                                <div class="content">
                                    <h4 class="title"><?php echo $FCP['title'] ?></a></h4>
                                    <div class="content d-flex">
                                        <a href="<?php echo site_url('FCP/FCP_details/'.rawurlencode(slugify($FCP['title'])).'/'.$FCP['FCP_id']) ?>" class="link w-100"><?php echo get_phrase('View Details')?></a>
                                        <a href="<?php echo site_url('addons/FCP/FCP_invoice/'.$FCP_payment_history['payment_id']); ?>" class="ms-1 link btn-outline"><i class="fas fa-file-invoice"></i></a>
                                    </div>
                                </div>
                                <div class="status free">
                                    <p>
                                        <?php if($FCP['is_free'] == 1){
                                            echo get_phrase('Free');
                                        }else{
                                            echo currency($FCP['price']);
                                        }?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;?>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</section>