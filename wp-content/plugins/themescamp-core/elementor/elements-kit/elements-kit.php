<?php

// Some pre defined value for easy use
define('TCEK_VER', '5.2.0');
define('TCEK_TPL_DB_VER', '1.0.0');
define('TCEK__FILE__', __FILE__);
define('TCEK_TITLE', 'Element Kit');
define('TCEK_PNAME', basename(dirname(TCEK__FILE__)));
define('TCEK_PBNAME', plugin_basename(TCEK__FILE__));
define('TCEK_PATH', plugin_dir_path(TCEK__FILE__));
define('TCEK_URL', plugins_url('/', TCEK__FILE__));
define('TCEK_INC_PATH', TCEK_PATH . 'includes/');

function tcg_Element_Kit_load_plugin() {
	require_once(TCEK_PATH . 'loader.php');
}
add_action('plugins_loaded', 'tcg_Element_Kit_load_plugin', 9);




