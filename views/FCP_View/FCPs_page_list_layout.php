<div class="grid-view-body courses courses-list-view-body">

    <?php include 'FCPs_page_sorting_section.php'; ?>

    <div class="courses-card courses-list-view-card">
        <?php foreach ($FCPs as $latest_course) : ?>
            <?php
            
                if( $latest_course['course_id']!="" && $latest_course['course_id'] !=null )
                {
                    $course_details = $this->crud_model->get_course_by_id($latest_course['course_id'])->row_array();
                    $lessons = $this->crud_model->get_lessons('course', $latest_course['course_id']);
                    $course_duration = $this->crud_model->get_total_duration_of_lesson_by_course_id($latest_course['course_id']);
                    $total_rating =  $this->crud_model->get_ratings('course', $latest_course['course_id'], true)->row()->rating;
                    $number_of_ratings = $this->crud_model->get_ratings('course', $latest_course['course_id'])->num_rows();
                    $language_course = $course_details['language'];
                    
                }else{
                    $course_duration = $latest_course['course_duration'];
                    $total_rating =  $this->FCP_model->get_ratings( $latest_course['FCP_id'], true)->row()->rating;
                    $number_of_ratings  = $this->FCO_model->get_ratings( $latest_course['FCP_id'],true)->num_rows();
                    $language_course = "english";
                    $lessons = null;
                    
                }
                if ($number_of_ratings > 0) {
                    $average_ceil_rating = ceil($total_rating / $number_of_ratings);
                } else {
                    $average_ceil_rating = 0;
                }
            ?>
            <!-- Course List Card -->
            <a href="<?php echo site_url('addons/FCP/' . rawurlencode(slugify($latest_course['title'])) . '/' . $latest_course['FCP_id']); ?>" class="courses-list-view-card-body courses-card-body checkPropagation">
                <div class="courses-card-image ">
                    <img loading="lazy" src="<?php echo $this->FCP_model->get_FCP_thumbnail_url($latest_course['FCP_id']); ?>">
                </div>
                <div class="courses-text w-100">
                    <div class="courses-d-flex-text">
                        <h5><?php echo $latest_course['title']; ?></h5>
                        <div>
                            <span class="compare-img checkPropagation" onclick="redirectTo('<?php echo base_url(isEmpty($latest_course['enrol_url'])?''.$latest_course['base_url'].'/'.slugify($latest_course['base_course_name']).'/?couponCode='.$latest_course['FCP_id']:$latest_course['enrol_url']); ?>');">
                                <img loading="lazy" src="<?php echo base_url('assets/frontend/default-new/image/compare.png') ?>">
                                <?php echo get_phrase('Enrol'); ?>
                            </span>
                            <span class="compare-img checkPropagation" onclick="showAjaxModal('<?php echo site_url('addons/FCP_manager/coupon_FCP_show/'.$latest_course['coupon']); ?>', '<?php echo get_phrase('Coupon_Details'); ?>');">
                                <img loading="lazy" src="<?php echo base_url('assets/frontend/default-new/image/compare.png') ?>">
                                <?php echo get_phrase('Coupon_Code'); ?>
                            </span>
                        </div>
                    </div>
                    <div class="review-icon">
                        <p><?php echo $average_ceil_rating; ?></p>
                        <p><i class="fa-solid fa-star <?php if ($number_of_ratings > 0) echo 'filled'; ?>"></i></p>
                        <p>(<?php echo $number_of_ratings; ?> <?php echo get_phrase('Reviews') ?>)</p>
                        <p><i class="fas fa-closed-captioning"></i><?php echo site_phrase($course['language']); ?></p>
                    </div>
                    <p class="ellipsis-line-2"><?php echo $latest_course['short_description']; ?></p>
                    <div class="courses-price-border">
                        <div class="courses-price">
                            <div class="courses-price-left">
                                <?php if ($latest_course['is_free']) : ?>
                                    <h5 class="price-free"><?php echo get_phrase('Free'); ?></h5>
                                <?php elseif ($latest_course['discount_flag']) : ?>
                                    <h5><?php echo currency($latest_course['discounted_price']); ?></h5>
                                    <p class="mt-1"><del><?php echo currency($latest_course['price']); ?></del></p>
                                <?php else : ?>
                                    <h5><?php echo currency($latest_course['price']); ?></h5>
                                <?php endif; ?>
                            </div>
                            <div class="courses-price-right ">
                                <p class="me-2"><i class="fa-regular fa-list-alt p-0 text-15px"></i> <?php echo $lessons->num_rows() . ' ' . get_phrase('lessons'); ?></p>
                                <?php if ($course_duration) : ?>
                                    <p><i class="fa-regular fa-clock text-15px p-0"></i> <?php echo $course_duration; ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <!-- End Course List Card -->
        <?php endforeach; ?>

        <!------- pagination Start ------>
        <div class="pagenation-items mb-0 mt-3">
            <?php echo $this->pagination->create_links(); ?>
        </div>
    </div>
</div>