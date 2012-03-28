<?php
		$firstPageImages = normalizeColumns(3, 6);
		$np = getOption('images_per_page');
		if ($firstPageImages > 0)  {
			$firstPageImages = $firstPageImages - 1;
			$myimagepagestart = 1;
		} else {
			$firstPageImages = $np - 1;
			$myimagepagestart = 0;
		}
		$_zp_conf_vars['images_first_page'] = $firstPageImages;
		$myimagepage = $myimagepagestart + getCurrentPage() - getTotalPages(true);
		if ($myimagepage > 1 ) {
			$link_slides = 2;
		} else {
			$link_slides = 1;
		}
		setOption('images_per_page', $np - $link_slides, false);
		$_zp_conf_vars['images_first_page'] = NULL;
		setOption('custom_index_page', 'gallery', false);
?>