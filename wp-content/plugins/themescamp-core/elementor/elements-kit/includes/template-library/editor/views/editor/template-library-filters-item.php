<?php
/**
 * Template Library Header Template
 */
if (!defined('ABSPATH')) exit; // Exit if accessed directly
?>
<label class="tc-elementkit-template-library-filter-label">
    <input type="radio" value="{{ term_slug }}" <# if ( '' === term_slug ) { #> checked<# } #> name="tc-elementkit-library-filter">
    <span>{{ term_name }} <span class="tc-category-badge">{{ count }}</span></span>
</label>