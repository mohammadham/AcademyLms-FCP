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