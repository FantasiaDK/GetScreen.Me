<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://getscreen.me
 * @since      1.0.0
 *
 * @package    GetScreen_Me
 * @subpackage GetScreen_Me/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    GetScreen_Me
 * @subpackage GetScreen_Me/public
 * @author     Michael Dyhr Iversen <michael@qcompany.dk>
 */
class GetScreen_Me_Public {

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
		if(!shortcode_exists('getscreenme'))
			add_shortcode('getscreenme', array($this, 'getscreen_me_shortcode'));
		add_action( 'wp_ajax_getscreen_me_create_session', array($this,'getscreen_me_ajax_handler') );
		add_action( 'wp_ajax_nopriv_getscreen_me_create_session', array($this,'getscreen_me_ajax_handler') );
		add_action( 'wp_footer', array($this, 'getscreen_me_footer') );
	}

	public function getscreen_me_shortcode($atts=[], $content = null){
		// do something to $content
		$getscreen_me_options = get_option( 'getscreen_me_option_name' ); // Array of All Options
		//return var_export($getscreen_me_options, true);
		$show_client_name_input_1 = $getscreen_me_options['show_client_name_input_1']; // Show Client Name input
		$force_client_name_input_2 = false;
		if(array_key_exists('force_client_name_input_2', $getscreen_me_options))
			$force_client_name_input_2 = $getscreen_me_options['force_client_name_input_2']; // Force Client Name input
		$label_for_the_client_name_input_field_3 = $getscreen_me_options['label_for_the_client_name_input_field_3']; // Label for the Client Name input field
		$label_for_the_create_connection_4 = $getscreen_me_options['label_for_the_create_connection_4']; // Label for the Create Connection
		$btn = preg_replace( '/<input type="submit"(.*)value="(.*)"(.*)\/>/iU', '<button type="submit"$1value="$2"$3>$2</button>', get_submit_button($label_for_the_create_connection_4!=''?$label_for_the_create_connection_4:'Create session','button medium') , 1 );

		$s = '<form name="getscreen_me" id="getscreen_me">
<input type="' . ($show_client_name_input_1?'text':'hidden') . '" name="getscreenme_clientname" placeholder="'. ($label_for_the_client_name_input_field_3!=''?$label_for_the_client_name_input_field_3:'Customer name') . '" />
		'. $btn . '</form>
		';

		// run shortcode parser recursively
    	//$content = do_shortcode( $content );
	    // always return
	    return $s;
	}

	public function getscreen_me_footer(){
		echo '<div id="greenscreenpopup"><iframe id="greenscreenpopupiframe"></iframe></div><div id="greenscreenpopupdarkbg"></div>';
	}

	public function getscreen_me_createsession($name = ''){
		$getscreen_me_options = get_option( 'getscreen_me_option_name' ); // Array of All Options
 		$api_key_0 = $getscreen_me_options['api_key_0']; // API Key
 		$getargs = 'apikey='.$api_key_0;
		$reqbody = array('apikey'=>$api_key_0);
		if(isset($name) && $name!='')
			$getargs .= '&client_name='.$name;
		$args = array(
    'timeout'     => '15',
    'redirection' => '5',
    'httpversion' => '1.0',
    'blocking'    => true,
    'headers'     => array(),
    'cookies'     => array(),
);
		$body = wp_remote_post( 'https://api.getscreen.me/v1/support/create?'.$getargs, $args );
		if($body['response']['code'] != 200){
			error_log('Recieved another code than 200 OK: '.$body['response']['code']);
		}else{ 
			$json     = wp_remote_retrieve_body( $body );
			error_log($json);
			$jsonObj  = json_decode($json,true);
			$invite_url = $jsonObj['data']['invite_url'];
			error_log('InviteURL: '.$invite_url);
			$ch = curl_init($invite_url);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		    $response = curl_exec($ch);
		    curl_close($ch);
		    preg_match_all('(http|https):\/\/[\w\-_]+(\.[\w\-_]+)+([\w\-\.,@?^=%&amp;:/~\+#]*[\w\-\@?^=%&amp;/~\+#])?', $response, $matches, PREG_PATTERN_ORDER);
		    if($matches)
		    foreach($matches as $idx->$match){
		    	error_log(($match));
		    }
			return $invite_url;
		}
		$invite_url = $name;
		error_log('InviteURL: '.$invite_url);
		$ch = curl_init($invite_url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	    $response = curl_exec($ch);
	    curl_close($ch);
	    $matches = array();
	    preg_match_all ("/https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*/)", $response, $matches);
        
	    $matches = $matches[1];
	    $list = array();

	    if($matches)
	    foreach($matches as $var)
	    {    
	        print($var."<br>");
	        error_log(($var));
	    }


	   /* $condition = "\s*(?i)href\s*=\s*(\"([^\"]*\")|'[^']*'|([^'\">\s]+));";
	    preg_match_all($condition, $response, $matches, PREG_PATTERN_ORDER);
	    if($matches)
	    foreach($matches as $idx->$match){
	    	
	    }*/
		return $invite_url;
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
		 * defined in GetScreen_Me_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The GetScreen_Me_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/getscreen-me-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		$getscreen_me_options = get_option( 'getscreen_me_option_name' );
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in GetScreen_Me_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The GetScreen_Me_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/getscreen-me-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script($this->plugin_name, 'getscreen_me_obj', array('ajax_url' => admin_url('admin-ajax.php'),'security'=>wp_create_nonce('Rt$70SBAsVmQzZLF&$2F'),'gsoverlay'=>$getscreen_me_options['force_link_as_overlay_6'],'gslabel'=>$getscreen_me_options['label_for_the_url_created_5'],'gsoverride'=>$getscreen_me_options['label_for_the_url_created_5']!=''));

	}

	/**
	 * AJAX handler using JSON
	 */
	public function getscreen_me_ajax_handler__json() {
	    check_ajax_referer( 'Rt$70SBAsVmQzZLF&$2F', 'security' );
	    //error_log('Run getscreen_me_ajax_handler__json()');
	    $invite_url = $this->getscreen_me_createsession($_POST['getscreenme_clientname']);
	    wp_send_json( esc_html( $invite_url ));
	}

	/**
	 * AJAX handler not using JSON.
	 */
	public function getscreen_me_ajax_handler() {
	    check_ajax_referer( 'Rt$70SBAsVmQzZLF&$2F', 'security' );
	    //error_log('Run getscreen_me_ajax_handler()');
	    $invite_url = $this->getscreen_me_createsession($_POST['getscreenme_clientname']);
	    wp_send_json( esc_html( $invite_url ));
	}
}
