<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://nayon.net
 * @since      1.0.0
 *
 * @package    nmembership
 * @subpackage nmembership/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    nmembership
 * @subpackage nmembership/public
 * @author     Shariful Islam Nayon <si.nayon@gmail.com>
 */
class nmembership_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in nmembership_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The nmembership_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/nmembership-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in nmembership_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The nmembership_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/nmembership-public.js', array( 'jquery' ), $this->version, false );

	}

	public function the_content( $post_content ) {

		if ( is_main_query() && is_singular('post') ) {
			$position  = get_option( 'nmembership_position', 'before' );
			$days      = (int) get_option( 'nmembership_day', 0 );
			$date_now  = new DateTime( current_time('mysql') );
			$date_old  = new DateTime( get_the_modified_time('Y-m-d H:i:s') );
			$date_diff = $date_old->diff( $date_now );

			if ( $date_diff->days > $days ) {
				$class = 'is-outdated';
			} else {
				$class = 'is-fresh';
			}

			// Filter the text
			$notice = sprintf(
						_n(
							'This post is last updated %s day ago.',
							'This post is last updated %s days ago.',
							$date_diff->days,
							'nmembership'
						),
						$date_diff->days
					);

			// Add the class
			$notice = '<div class="nmembership %s">' . $notice . '</div>';
			$notice = sprintf( $notice, $class );

			if ( 'after' == $position ) {
				$post_content .= $notice;
			} else {
				$post_content = $notice . $post_content;
			}
		}

        return $post_content;
	}

}
