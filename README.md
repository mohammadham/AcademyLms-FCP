FCP Addon for Academy LMS
FCP:Free course coupons
This project is a FCP addon for Academy LMS that allows users to create and share coupon of all platforms. Users can add categories, courses, descriptions, titles, prices, and more.
Installation
To activate this addon in your Academy LMS, follow these steps:

### Route Configuration
		
- **Path:** `application/config/routes.php`
		
		```php
		// FCP
		$route['FCP/FCP_details/(:any)/(:any)'] = "addons/FCP/FCP_details/$1/$2";
		$route['FCP'] = "addons/FCP/FCPs";
		$route['FCP_manager/all_FCPs'] = "addons/FCP_manager/all_FCPs";
		$route['FCP_manager/add_FCP'] = "addons/FCP_manager/add_FCP";
		$route['FCP_manager/payment_history'] = "addons/FCP_manager/payment_history";
		$route['FCP_manager/category'] = "addons/FCP_manager/category";
		$route['FCP/buy/(:any)'] = "addons/FCP/buy/$1";
		$route['home/my_FCPs'] = "addons/FCP/my_FCPs";
		//end FCP
### Update navigation.php
- **Path:** 'application/views/backend/admin/navigation.php'
- **Line:** 82
	<!-- FCP Addon -->
		  <?php if (addon_status('FCP')) : ?>
					<li class="side-nav-item">
						<a href="javascript: void(0);" class="side-nav-link <?php if ($page_name == 'all_FCPs' || $page_name == 'add_FCP' || $page_name == 'FCP_edit') : ?> active <?php endif; ?>">
							<i class="dripicons-ticket"></i>
							<span> <?php echo get_phrase('Coupons'); ?> </span>
							<span class="menu-arrow"></span>
						</a>
						<ul class="side-nav-second-level <?php if ($page_name == 'FCP_edit') echo 'in'; ?>" aria-expanded="false">
							<li class="<?php if ($page_name == 'all_FCPs' || $page_name == 'FCP_edit') echo 'active'; ?>">
								<a href="<?php echo site_url('addons/FCP_manager/FCP'); ?>"><?php echo get_phrase('all_FCPs'); ?></a>
							</li>
							<li class="<?php if ($page_name == 'add_FCP') echo 'active'; ?>">
								<a href="<?php echo site_url('FCP_manager/add_FCP'); ?>"><?php echo get_phrase('add_FCP'); ?></a>
							</li>
							<li class="<?php if ($page_name == 'FCP_category') echo 'active'; ?>">
								<a href="<?php echo site_url('addons/FCP_manager/FCP_category'); ?>"><?php echo get_phrase('category'); ?></a>
							</li>
						</ul>
					</li>
		  <?php endif; ?>
	<!-- FCP Addon -->
### Update header_lg_device.php
- **Attention:** if you use lite version or old version use this part
- **Path:** 'application/views/frontend/default-new/header_lg_device.php'
- **Line:** 124

		```php
		<!-- FCP addon -->
		<?php if(addon_status('FCP')): ?>
			<?php $header_menu_counter += 1; ?>
			<ul class="navbar-nav main-nav-wrap mb-2 mb-lg-0 ms-2">
				<li class="nav-item">
					<a class="nav-link header-dropdown bg-white text-dark fw-600 text-nowrap" href="#" id="navbarDropdown1">
						<span class="ms-2"><?php echo get_phrase('FCP'); ?></span>
						<i class="fas fa-angle-down ms-1"></i>
					</a>
					<ul class="navbarHover">
						<?php
						$FCP_categories = $this->db->get('FCP_category')->result_array();
						foreach ($FCP_categories as $key => $FCP_category):?>
							<li class="dropdown-submenu">
								<a href="<?php echo site_url('FCP?category='.$FCP_category['slug'].'&price=all&rating=all') ?>">
									<span class="text-cat"><?php echo $FCP_category['title']; ?></span>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</li>
			</ul>
		<?php endif; ?>
		<!-- FCP addon -->
### Update header_sm_device.php
- **Attention:** if you use lite version or old version use this part
- **Path:** 'application/views/frontend/default-new/header_sm_device.php'
- **Line:** 124

		```php
		<!-- FCP addon -->
		<?php if(addon_status('FCP')): ?>
			<?php $header_menu_counter += 1; ?>
			<ul class="navbar-nav main-nav-wrap mb-2 mb-lg-0 ms-2">
				<li class="nav-item">
					<a class="nav-link header-dropdown bg-white text-dark fw-600 text-nowrap" href="#" id="navbarDropdown1">
						<span class="ms-2"><?php echo get_phrase('Coupons'); ?></span>
						<i class="fas fa-angle-down ms-1"></i>
					</a>
					<ul class="navbarHover">
						<?php
						$FCP_categories = $this->db->get('FCP_category')->result_array();
						foreach ($FCP_categories as $key => $FCP_category):?>
							<li class="dropdown-submenu">
								<a href="<?php echo site_url('FCP?category='.$FCP_category['slug'].'&price=all&rating=all') ?>">
									<span class="text-cat"><?php echo $FCP_category['title']; ?></span>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</li>
			</ul>
		<?php endif; ?>
		<!-- FCP addon -->


### Update includes_top.php
- **Attention:** if you use lite version or old version use this part
- **Path:** 'application\views\frontend\default-new\includes_top.php'
- **Description:** 'add blelow code to this file'
	<!-- tailwind CSS -->
		<link href="<?php echo site_url('assets/playing-page/') ?>css/tailwind.min.css" rel="stylesheet" />
	<!-- tailwind CSS -->

if you can beter this addon please fork and after edit send to me your code :).
