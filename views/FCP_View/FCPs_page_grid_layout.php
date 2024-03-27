

    <div class=" courses grid-view-body  pb-4 mw-25 mh-25 ">      
    <?php include 'FCPs_page_sorting_section.php'; 
    use function PHPUnit\Framework\isEmpty;?>
                            <div class="container pt-2   ">
                                
                                <div class="courses-card  ">
                                    <div class="row">
                                        
                                    
                                        <?php
                                        
                                        foreach ($FCPs as $latest_course) :
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
                                            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                                                <a href="<?php echo site_url('FCP/FCP_details/' . rawurlencode(slugify($latest_course['title'])) . '/' . $latest_course['FCP_id']); ?>" id="latest_course_<?php echo $latest_course['FCP_id']; ?>" class="checkPropagation courses-card-body">
                                                    <div class="courses-card-image">
                                                        <img loading="lazy" src="<?php echo $this->FCP_model->get_FCP_thumbnail_url($latest_course['FCP_id']); ?>">
                                                        
                                                        
                                                    </div>
                                                    <div class="courses-text">
                                                        <h5 class="mb-2"><?php echo $latest_course['title']; ?></h5>
                                                        <div class="review-icon">
                                                            <div class="review-icon-star align-items-center">
                                                                <p><?php
                                                                    echo $average_ceil_rating;
                                                                ?></p>

                                                                <p><i class="fa-solid fa-star <?php if($number_of_ratings > 0 ) {echo 'filled';} ?>"></i></p>
                                                                <p>(<?php if($number_of_ratings > 0 ) {echo $number_of_ratings;} ?> 
                                                                <?php echo get_phrase('Reviews') ?>)</p>
                                                            </div>
                                                            <div class="review-btn  align-items-center grid grid-cols-1">
                                                                <span class="compare-img checkPropagation" onclick="redirectTo('<?php echo base_url(isEmpty($latest_course['enrol_url'])?''.$latest_course['base_url'].'/'.slugify($latest_course['base_course_name']).'/?couponCode='.$latest_course['FCP_id']:$latest_course['enrol_url']); ?>');">
                                                                        <img loading="lazy" style="color: white" src="<?php echo base_url('assets/frontend/default-new/image/compare.png') ?>">
                                                                        <?php echo get_phrase('Enrol'); ?>
                                                                    </span>
                                                                
                                                                
                                                                <span class="compare-img checkPropagation " style="background-color: #ffc107;color:black; hover:background-color:#ffc;"  onclick="showAjaxModal('<?php echo site_url('addons/FCP_manager/coupon_FCP_show/'.$latest_course['coupon']); ?>', '<?php echo get_phrase('Coupon_Code'); ?>');">
                                                                        <img loading="lazy" style="color: white" src="<?php echo base_url('assets/frontend/default-new/image/Group 17906.png') ?>">
                                                                        <?php echo get_phrase('coupon_code'); ?>
                                                                    </span>
                                                            </div>
                                                        </div>
                                                        <p class="ellipsis-line-2"><?php echo $latest_course['short_description'] ?></p>
                                                        <div class="courses-price-border">
                                                            <div class="courses-price">
                                                                <div class="courses-price-left">
                                                                    <?php if($latest_course['is_free']): ?>
                                                                        <h5><?php echo get_phrase('Free'); ?></h5>
                                                                    <?php elseif($latest_course['discount_flag']): ?>
                                                                        <h5><?php echo currency($latest_course['discounted_price']); ?></h5>
                                                                        <p class="mt-1"><del><?php echo currency($latest_course['price']); ?></del></p>
                                                                    <?php else: ?>
                                                                        <h5><?php echo currency($latest_course['price']); ?></h5>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <div class="courses-price-right ">
                                                                    <p class="m-0"><i class="fa-regular fa-clock p-0 text-15px"></i> <?php echo $course_duration; ?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>




                                                <div id="latest_course_feature_<?php echo $latest_course['FCP_id']; ?>" class="course-popover-content">
                                                    <?php if ($latest_course['updated_date'] == "" || $latest_course['updated_date'] == null ) : ?>
                                                        <p class="last-update"><?php echo site_phrase('last_updated') . ' ' . date('D, d-M-Y', $latest_course['added_date']); ?></p>
                                                    <?php else : ?>
                                                        <p class="last-update"><?php echo site_phrase('last_updated') . ' ' . date('D, d-M-Y', $latest_course['updated_date']); ?></p>
                                                    <?php endif; ?>
                                                    <div class="course-title">
                                                        <a href="<?php echo site_url('FCP/FCP_details/' . rawurlencode(slugify($latest_course['title'])) . '/' . $latest_course['FCP_id']); ?>"><?php echo $latest_course['title']; ?></a>
                                                    </div>
                                                    <div class="course-meta">
                                                        <?php if ($latest_course['course_id']!="" && $latest_course['course_id'] !=null) : ?>
                                                            <span class=""><i class="fas fa-play-circle"></i>
                                                                <?php 
                                                                if($lessons != null):
                                                                    echo $lessons->num_rows() . ' ' . site_phrase('lessons');
                                                                endif; ?>
                                                            </span>
                                                            <span class=""><i class="far fa-clock"></i>
                                                                <?php echo $course_duration; ?>
                                                            </span>
                                                        
                                                        <?php endif; ?>
                                                        <span class=""><i class="fas fa-closed-captioning"></i><?php echo ucfirst($language_course); ?></span>
                                                    </div>
                                                    <div class="course-subtitle">
                                                        <?php 
                                                        if($latest_course['short_description']!=null):
                                                            echo $latest_course['short_description'];
                                                        endif; ?>
                                                    </div>
                                                    
                                                    <script>
                                                        $(document).ready(function(){
                                                            $('#latest_course_<?php echo $latest_course['FCP_id']; ?>').webuiPopover({
                                                                url:'#latest_course_feature_<?php echo $latest_course['FCP_id']; ?>',
                                                                trigger:'hover',
                                                                animation:'pop',
                                                                cache:false,
                                                                multi:true,
                                                                direction:'rtl', 
                                                                placement:'horizontal',
                                                            });
                                                        });
                                                    </script>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <!------- pagination Start ------>
                                    <div class="pagenation-items mb-0 mt-3">
                                        <?php echo $this->pagination->create_links(); ?>
                                    </div>
                                    <!------- pagination end ------>
                                </div>
                            </div>
                        </div>
