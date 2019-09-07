<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 * @author     Your Name <email@example.com>
 */
class Post_Category_FCM_Notifications_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/postcategory-fcm-notifications-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/postcategory-fcm-notifications-admin.js', array( 'jquery' ), $this->version, false );

	}
	
	/**
	 * Create Plugin menu item in WordPress Dashboard .
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function ad_menu_pfcm(){
		add_menu_page('Post FCM notifications', 'Post FCM Notifications', 'manage_options', 'admin_menu_pfcm', array($this, 'adm_page_pfcm'), plugins_url('images/fcm-icon.png', __FILE__ ));
		add_submenu_page( 'admin_menu_pfcm', 'Settings', 'Post FCM settings', 'manage_options', 'post_fcm_settings', array($this, 'post_manage_fcm_settings'));
	}
	
	/**
	 * Display Admin Post View in WordPress Dashboard .
	 *
	 * @since     1.0.0
	 */
	function adm_page_pfcm(){
		include('partials/postcategory-fcm-notifications-admin-display.php');
	}
	
	/**
	 * Display Admin Settings View in WordPress Dashboard .
	 *
	 * @since     1.0.0
	 */
	function post_manage_fcm_settings(){
		include('partials/postcategory-fcm-notifications-admin-settings.php');
		//include(plugin_dir_path(__FILE__) .'admin/partials/postcategory-fcm-notifications-admin-display.php') ;
	}
	

	/**
	 * Register Admin settings  .
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function fcm_settings(){   
        register_setting('pfcm_group', 'pfcm_api');
        register_setting('pfcm_group', 'pfcm_topic');
        register_setting('pfcm_group', 'pfcm_disable');
		
		$catest = get_categories() ;
		foreach($catest as $catests){
			$pfcmCats = 'pfcm_'.$catests->slug;
			register_setting('pfcm_group', $pfcmCats);
		}
    }
	
	/**
	 * Getting post data and checking settings before sending Sending Notifications  .
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function fcm_on_post_publish($post_id, $post) {
		
		$categoryAll = get_the_category($post_id);
		$categorySlug = 'pfcm_'.$categoryAll[0]->slug;
		$contentt = get_post_field('post_content', $post_id);
        $title = get_the_title($post_id);
		
		if(get_option('pfcm_api') && get_option('pfcm_topic')) {
			$topic =  "/topics/".get_option('pfcm_topic') ;
			$published_at_least_once = get_post_meta( $post_id, 'is_published', true );
			
			if (get_option('pfcm_disable') != 1) {
				
				if (!$published_at_least_once && get_option($categorySlug) == 1) {
					$published_at_least_once = true;
					$this->pfcm_notification($title, $contentt, $topic);
				}
			}
			update_post_meta( $post_id, 'is_published', $published_at_least_once );
		}
	}
	
	/**
	 * FCM API Call.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function pfcm_notification($title, $contentt, $topic ){
		
        $apiKey = get_option('pfcm_api');
		
		$url = 'https://fcm.googleapis.com/fcm/send';
        $headers = array(
            'Authorization: key=' . $apiKey,
            'Content-Type: application/json'
        );
		
		$notification_data = array(
            'message'           => $contentt,
            'title'           	=> $title,
			'vibrate'			=> 1,
			'sound'				=> 1,
        );
		
		$post = array(
            'to'         		=> $topic,
            'notification'      => $notification_data
        );
		
		 $ch = curl_init();

        // Set URL to GCM endpoint
        curl_setopt($ch, CURLOPT_URL, $url);

        // Set request method to POST
        curl_setopt($ch, CURLOPT_POST, true);

        // Set our custom headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Get the response back as string instead of printing it
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Set JSON post data
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
		
		// Set Security
		curl_setopt($ch, CURLOPT_CAINFO, plugin_dir_path(__FILE__).'/cacert.pem');
		
        // Actually send the push
        $result = curl_exec($ch);

        // Close curl handle
        curl_close($ch);
		
		return $result;
	}
	
}
