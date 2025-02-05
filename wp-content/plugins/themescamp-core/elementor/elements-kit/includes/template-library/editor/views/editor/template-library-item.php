<?php
/**
 * Template item
 */
if (!defined('ABSPATH')) exit; // Exit if accessed directly
?>

<div class="elementor-template-library-template-body">
	<div class="elementor-template-library-template-screenshot">
		<div class="elementor-template-library-template-preview">
			<i class="fa fa-search-plus"></i>
		</div>
		<img src="{{ thumbnail }}" alt="">
	</div>
</div>
<div class="elementor-template-library-template-controls">
    <?php include('tc-template-library-item-import-btn.php'); ?>
</div>
<div class="elementor-template-library-template-name">{{ title }}</div>