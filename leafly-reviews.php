<?php
/**
 * Plugin Name:     Leafly Reviews
 * Plugin URI:      http://www.deviodigital.com
 * Description:     Easily display your leafly dispensary reviews on your own website
 * Version:         1.0.0
 * Author:          Devio Digital
 * Author URI:      http://deviodigital.com
 * Text Domain:     leafly-reviews
 *
 * @package         LeaflyReviews
 */


// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;


if( ! class_exists( 'LeaflyReviews' ) ) {


    /**
     * Main LeaflyReviews class
     *
     * @since       1.0.0
     */
    class LeaflyReviews {


        /**
         * @access      private
         * @since       1.0.0
         * @var         LeaflyReviews $instance The one true LeaflyReviews
         */
        private static $instance;


        /**
         * Get active instance
         *
         * @access      public
         * @since       1.0.0
         * @return      self::$instance The one true LeaflyReviews
         */
        public static function instance() {
            if( ! self::$instance ) {
                self::$instance = new LeaflyReviews();
                self::$instance->setup_constants();
                self::$instance->includes();
                self::$instance->hooks();
            }

            return self::$instance;
        }


        /**
         * Setup plugin constants
         *
         * @access      public
         * @since       1.0.0
         * @return      void
         */
        private function setup_constants() {
            // Plugin path
            define( 'LEAFLYREVIEWS_DIR', plugin_dir_path( __FILE__ ) );

            // Plugin URL
            define( 'LEAFLYREVIEWS_URL', plugin_dir_url( __FILE__ ) );
        }


        /**
         * Include required files
         *
         * @access      private
         * @since       1.0.0
         * @return      void
         */
        private function includes() {
            require_once LEAFLYREVIEWS_DIR . 'includes/functions.php';
            require_once LEAFLYREVIEWS_DIR . 'includes/scripts.php';
            require_once LEAFLYREVIEWS_DIR . 'includes/widget.php';
        }


        /**
         * Run action and filter hooks
         *
         * @access      private
         * @since       1.0.0
         * @return      void
         */
        private function hooks() {
        }


        /**
         * Internationalization
         *
         * @access      public
         * @since       1.0.0
         * @return      void
         */
        public function load_textdomain() {
            // Set filter for language directory
            $lang_dir = dirname( plugin_basename( __FILE__ ) ) . '/languages/';
            $lang_dir = apply_filters( 'lealyreviews_language_directory', $lang_dir );

            // Traditional WordPress plugin locale filter
            $locale = apply_filters( 'plugin_locale', get_locale(), '' );
            $mofile = sprintf( '%1$s-%2$s.mo', 'leafly-reviews', $locale );

            // Setup paths to current locale file
            $mofile_local   = $lang_dir . $mofile;
            $mofile_global  = WP_LANG_DIR . '/leafly-reviews/' . $mofile;

            if( file_exists( $mofile_global ) ) {
                // Look in global /wp-content/languages/leafly-reviews/ folder
                load_textdomain( 'leafly-reviews', $mofile_global );
            } elseif( file_exists( $mofile_local ) ) {
                // Look in local /wp-content/plugins/leafly-reviews/languages/ folder
                load_textdomain( 'leafly-reviews', $mofile_local );
            } else {
                // Load the default language files
                load_plugin_textdomain( 'leafly-reviews', false, $lang_dir );
            }
        }
    }
}


/**
 * The main function responsible for returning the one true LeaflyReviews
 * instance to functions everywhere
 *
 * @since       1.0.0
 * @return      LeaflyReviews The one true LeaflyReviews
 */
function lealyreviews_load() {
    return LeaflyReviews::instance();
}
add_action( 'plugins_loaded', 'lealyreviews_load' );
