<?php
/**
 * Plugin bootstrap file
 *
 * @package App
 *
 * @wordpress-plugin
 * Plugin Name: _Boilerplate
 * Plugin URI:  https://midwestfamilymadison.com
 * Description: Custom functions by Mid-West Family Madison
 * Version:     1.0.0
 * Author:      Mid-West Family
 * Author URI:  https://midwestfamilymadison.com
 * Donate link: https://midwestfamilymadison.com
 * Tags: framework, sample
 * Requires at least: 6.0
 * Tested up to: 6.3
 * Requires PHP: 8.0.28
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: mwf_wp_lib
 */

namespace Mwf\Lib;

defined( 'ABSPATH' ) || exit;

require_once trailingslashit( plugin_dir_path( __FILE__ ) ) . 'vendor/autoload.php';
require_once trailingslashit( plugin_dir_path( __FILE__ ) ) . 'deps/autoload.php';

$mwf_wp_lib = new Main( 'boilerplate', __FILE__ );

$mwf_wp_lib->mount();