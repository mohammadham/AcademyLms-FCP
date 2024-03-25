<?php
use function PHPUnit\Framework\isEmpty;
isset($layout) ? "" : $layout = "list";
isset($selected_category_id) ? "" : $selected_category_id = "all";
isset($selected_rating) ? "" : $selected_rating = "all";
isset($selected_price) ? "" : $selected_price = "all";
$number_of_visible_categories = 10;

?>

<!---------- Bread Crumb Area Start ---------->
<?php include "breadcrumb.php"; ?>
<!---------- Bread Crumb Area End ---------->

<!-- Start Tutor list -->
<section class="pt-50 pb-120">
    <div class="container">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 col-md-4">
            <div class="s_Sidebar_one">
                <div class="content">
                <div class="pb-30">
                    <h4 class="mb-20 s_Sidebar_title_one s_bar"><?php echo get_phrase('Categories')?></h4>
                    <div class="d-flex justify-content-between align-items-center pb-12">
                    <div class="s_Sidebar_checkbox_one">
                        <input class="form-check-input" type="radio" value="all" name="sub_category" id="allcategory" onclick="filter(this)" <?php if ($selected_category_id == 'all') echo 'checked'; ?> />
                        <label class="form-check-label" for="allcategory"><?php echo get_phrase('All category')?></label>
                    </div>
                    <span class="no">(<?php echo $total_active_FCPs; ?>)</span>
                    </div>
                    <?php
                    $counter = 1;
                    $total_number_of_categories = $this->db->get('FCP_category')->num_rows();
                    $categories = $this->FCP_model->get_categories()->result_array();
                    foreach ($categories as $category) : ?>
                    <div class="pb-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="s_Sidebar_checkbox_one">
                                <input class="form-check-input categories" name="sub_category" type="radio" value="<?php echo $category['slug'];?>" id="category-<?php echo $category['category_id']; ?>" onclick="filter(this)" <?php if ($selected_category_id == $category['category_id']) echo 'checked'; ?>/>
                                <label class="form-check-label" for="category-<?php echo $category['category_id']; ?>"><?php echo $category['title']; ?></label>
                            </div>
                            <span class="no">(<?php echo $this->FCP_model->get_active_addon_by_category_id($category['category_id'], 'category_id')->num_rows(); ?>)</span>
                        </div>
                    </div>
                    <?php endforeach;?>
                    
                    <a href="javascript:;" class="text-13px fw-500" id="city-toggle-btn" onclick="showToggle(this, 'hidden-categories')"><?php echo $total_number_of_categories > $number_of_visible_categories ? site_phrase('show_more') : ""; ?></a>
                </div>
                <div class="pb-30">
                    <h4 class="mb-20 s_Sidebar_title_one s_bar"><?php echo site_phrase('Price'); ?></h4>
                    <div class="s_Sidebar_checkbox_one pb-12">
                        <input class="form-check-input prices" type="radio" id="price_all" name="price" value="all" onclick="filter(this)" <?php if ($selected_price == 'all') echo 'checked'; ?>/>
                        <label class="form-check-label" for="price_all"><?php echo site_phrase('all'); ?></label>
                    </div>
                    <div class="s_Sidebar_checkbox_one pb-12">
                        <input class="form-check-input prices" type="radio" id="price_free" name="price" value="free" onclick="filter(this)" <?php if ($selected_price == 'free') echo 'checked'; ?> />
                        <label class="form-check-label" for="price_free"><?php echo site_phrase('free'); ?></label>
                    </div>
                    <div class="s_Sidebar_checkbox_one">
                        <input class="form-check-input prices" id="price_paid" name="price" type="radio" value="paid" onclick="filter(this)" <?php if ($selected_price == 'paid') echo 'checked'; ?>/>
                        <label class="form-check-label" for="price_paid"><?php echo site_phrase('paid'); ?></label>
                    </div>
                </div>
                <div>
                    <h4 class="mb-20 s_Sidebar_title_one s_bar"><?php echo site_phrase('Ratings'); ?></h4>
                    <div class="s_Sidebar_checkbox_one pb-12">
                        <input class="form-check-input ratings" type="radio" id="all_rating" name="rating" value="<?php echo 'all'; ?>" onclick="filter(this)" <?php if ($selected_rating == "all") echo 'checked'; ?>/>
                        <label class="form-check-label" for="rAll"><?php echo site_phrase('All'); ?></label>
                    </div>
                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                    <div class="s_Sidebar_checkbox_one pb-12">
                        <input class="form-check-input ratings" id="rating_<?php echo $i; ?>" name="rating" type="radio" value="<?php echo $i; ?>" onclick="filter(this)" <?php if ($selected_rating == $i) echo 'checked'; ?>/>
                        <label class="form-check-label" for="rating_<?php echo $i; ?>">
                            <div class="rating-icon">
                                <?php for ($j = 1; $j <= $i; $j++) : ?>
                                    <img src="<?php echo base_url('assets/frontend/default-new/image/icon/star-solid.svg')?>" alt="" />
                                <?php endfor; ?>
                                <?php for ($j = $i; $j < 5; $j++) : ?>
                                    <img src="<?php echo base_url('assets/frontend/default-new/image/icon/star-solid-2.svg')?>" alt="" />
                                <?php endfor; ?>
                            </div>
                        </label>
                    </div>
                    <?php endfor; ?>
                    
                </div>
                </div>
            </div>
        </div>
        <!-- Course list -->
        <div class="col-lg-9 col-md-8">
        <div class="d-flex justify-content-between pb-10">
            <p class="searchResult"><?php echo site_phrase('showing').' '.count($FCPs).' '.site_phrase('of').' '.$total_result.' '.site_phrase('results'); ?></p>
            <div class="s_search">
            <form action="<?php echo site_url('FCP') ?>" method='get'>
                <input type="text" class="form-control" name="search" placeholder="<?php echo get_phrase('Search')?>" />
                <span><img src="<?php echo base_url('assets/frontend/default-new/image/icon/s_search.svg')?>" alt="" /></span>
            </form>
            </div>
        </div>

                    <div class=" courses grid-view-body pb-4 ">
                        <div class="container pt-2">
                            
                            <div class="courses-card ">
                                <div class="flex items-center grid grid-cols-4 gap-4 ">
                                    
                                
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
                                        <div class="single-popup-course flex-1">
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
                                                            <span class="compare-img checkPropagation" onclick="redirectTo('<?php echo base_url('home/compare?course-1='.slugify($latest_course['title']).'&course-id-1='.$latest_course['FCP_id']); ?>');">
                                                                    <img loading="lazy" style="color: white" src="<?php echo base_url('assets/frontend/default-new/image/compare.png') ?>">
                                                                    <?php echo get_phrase('Enrol'); ?>
                                                                </span>
                                                            
                                                            
                                                            <span class="compare-img checkPropagation " style="background-color: #ffc107;color:black; hover:background-color:#ffc;"  onclick="showAjaxModal('<?php echo site_url('addons/FCP_manager/coupon_FCP_show/'.$latest_course['coupon']); ?>', '<?php echo get_phrase('Coupon_Details'); ?>');">
                                                                    <img loading="lazy" style="color: white" src="<?php echo base_url('assets/frontend/default-new/image/Group 17906.png') ?>">
                                                                    <?php echo get_phrase('show_coupon_code'); ?>
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
                            </div>
                        </div>
                    </div>
             
        <!-- Items
        <div class="ebook-items ">
            <div class="row">
                <?php /*foreach($FCPs as $FCP):?>
                    <div class="col-lg-4 col-sm-6">
                        <div class="ebook-item-one ">
                            <div class="border-1 hover:border-5 rounded hoverable">
                                <div class="img"><img src="<?php echo $this->FCP_model->get_FCP_thumbnail_url($FCP['FCP_id']); ?>" alt="" width="100%"/></div>
                                <div class="content">
                                    <h4 class="title"><?php echo $FCP['title'];?></h4>
                                    <a href="<?php echo site_url('FCP/FCP_details/'.rawurlencode(slugify($FCP['title'])).'/'.$FCP['FCP_id']) ?>" class="link"><?php echo get_phrase('View Details')?></a>
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
                    </div>
                <?php endforeach;*/?>
            
            </div>
        </div> -->
        </div>
    </div>
    </div>
</section>
<!-- End Tutor list -->

<script>
    function get_url() {
        var urlPrefix = '<?php echo site_url('FCP?'); ?>'
        var urlSuffix = "";
        var slectedCategory = "";
        var selectedPrice = "";
        var selectedRating = "";
        var search_text = "";

        // Get selected category
        $('.categories:checked').each(function() {
            slectedCategory = $(this).attr('value');
        });

        // Get selected price
        $('.prices:checked').each(function() {
            selectedPrice = $(this).attr('value');
        });
        searchText = $('.search').val();
        // Get selected rating
        $('.ratings:checked').each(function() {
            selectedRating = $(this).attr('value');
        });

        if (searchText != null) {
            urlSuffix = "category=" + slectedCategory + "&&price=" + selectedPrice + "&&rating=" + selectedRating +
                "&&search=" + searchText;
        } else {
            urlSuffix = "category=" + slectedCategory + "&&price=" + selectedPrice + "&&rating=" + selectedRating;
        }
        var url = urlPrefix + urlSuffix;
        return url;
    }
    function filter() {
        var url = get_url();
        window.location.replace(url);
        //console.log(url);
    }
    function showToggle(elem, selector) {
        $('.' + selector).slideToggle(20);
        if ($(elem).text() === "<?php echo site_phrase('show_more'); ?>") {
            $(elem).text('<?php echo site_phrase('show_less'); ?>');
        } else {
            $(elem).text('<?php echo site_phrase('show_more'); ?>');
        }
    }
    $('.course-compare').click(function(e) {
        e.preventDefault()
        var redirect_to = $(this).attr('redirect_to');
        window.location.replace(redirect_to);
    });
    function toggleLayout(layout) {
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('home/set_layout_to_session'); ?>',
            data: {
                layout: layout
            },
            success: function(response) {
                location.reload();
            }
        });
    }
</script>
