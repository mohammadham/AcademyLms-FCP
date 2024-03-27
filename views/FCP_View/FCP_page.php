<?php
use function PHPUnit\Framework\isEmpty;




    $layout = isset($_GET['$layout']) ? $_GET['$layout'] : "list" ;
    $selected_category = isset($_GET['category']) ? $_GET['category'] : 'all';
    $selected_category_id = $this->FCP_model->get_category_id($selected_category);
    $selected_category_id = isset($selected_category_id) ? $selected_category_id:"all";
    $selected_price    = isset($_GET['price']) ? $_GET['price'] : 'all';
    $selected_level    = isset($_GET['level']) ? $_GET['level'] : 'all';
    $selected_language = isset($_GET['language']) ? $_GET['language'] : 'all';
    $selected_rating   = isset($_GET['rating']) ? $_GET['rating'] : 'all';
    $selected_sorting  = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'all';
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
        <?php include "FCPs_page_sidebar.php"; ?>
        <!-- Course list -->
        <div class="col-lg-9 col-md-8">
            <?php include 'FCPs_page_' . $layout . '_layout.php'; ?>
            

                        
            <?php if(count($FCPs) == 0): ?>
                    <div class="not-found w-100 text-center d-flex align-items-center flex-column">
                        <img loading="lazy" width="80px" src="<?php echo base_url('assets/global/image/not-found.svg'); ?>">
                        <h5><?php echo get_phrase('Course Not Found'); ?></h5>
                        <p><?php echo get_phrase('Sorry, try using more similar words in your search.') ?></p>
                    </div>
            <?php endif; ?>   
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
    function filterFCPs(){
        //sorting value added to the filter form
        var sort_by = $('#sorting_select_input').val();
        $('#sorting_hidden_input').val(sort_by);

        $('#course_filter_form').submit();
    }
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
