<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       miniorange

 * @package    Miniorange_Api_Authentication
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Adding required files.
 */
require_once plugin_dir_path( __FILE__ ) . '../includes/class-miniorange-api-authentication-deactivator.php';
require plugin_dir_path( __FILE__ ) . '/class-miniorange-api-authentication-customer.php';
require 'partials/class-mo-api-authentication-admin-menu.php';
require 'partials/flow/mo-api-authentication-flow.php';
require 'partials/flow/mo-token-api-flow.php';
require 'partials/support/class-mo-api-authentication-feedback.php';

/**
 * Handle Admin actions
 */
class Miniorange_API_Authentication_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 *
	 * @return void
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		$mo_path           = ( dirname( dirname( plugin_basename( __FILE__ ) ) ) );
		$mo_path           = $mo_path . '/miniorange-api-authentication.php';
		add_filter( 'plugin_action_links_' . $mo_path, array( $this, 'add_action_links' ) );
		add_action( 'admin_menu', array( $this, 'miniorange_api_authentication_save_settings' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'plugin_settings_style' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'plugin_settings_script' ) );
	}

	// Function to add the Premium settings in Plugin's section.

	/**
	 * Add action links
	 *
	 * @param mixed $actions Hook actions.
	 * @return array
	 */
	public function add_action_links( $actions ) {

		$url            = esc_url(
			add_query_arg(
				'page',
				'mo_api_authentication_settings',
				get_admin_url() . 'admin.php'
			)
		);
		$url2           = $url . '&tab=licensing';
		$settings_link  = "<a href='$url'>" . esc_attr( 'Configure' ) . '</a>';
		$settings_link2 = "<a href='$url2' style=><b>" . esc_attr( 'Upgrade to Premium' ) . '</b></a>';
		array_push( $actions, $settings_link2 );
		array_push( $actions, $settings_link );
		return array_reverse( $actions );
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @return void
	 */
	public function plugin_settings_style() {
	}

	/**
	 * Register the scripts for the admin area.
	 *
	 * @return void
	 */
	public function plugin_settings_script() {
		if ( isset( $_GET['page'] ) && 'mo_api_authentication_settings' === $_GET['page'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Using this to enqueue styles and script only on the plugin page.
			wp_enqueue_script( 'mo_api_authentication_admin_bootstrap_bundle_script', plugins_url( 'js/bootstrap.bundle.min.js', __FILE__ ), MINIORANGE_API_AUTHENTICATION_VERSION, array(), '5.0.2', false );
			wp_enqueue_script( 'mo_api_authentication_admin_settings_phone_script', plugins_url( 'js/phone.min.js', __FILE__ ), MINIORANGE_API_AUTHENTICATION_VERSION, array(), false, false );
			wp_enqueue_script( 'mo_api_authentication_admin_settings_charts_script', plugins_url( 'js/charts.min.js', __FILE__ ), MINIORANGE_API_AUTHENTICATION_VERSION, array(), false, false );
		}
	}

	/**
	 * Enqueue styles.
	 *
	 * @return void
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Miniorange_Api_Authentication_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Miniorange_Api_Authentication_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		if ( isset( $_REQUEST['page'] ) && sanitize_text_field( wp_unslash( $_REQUEST['page'] ) ) === 'mo_api_authentication_settings' ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce validation because we are getting data from URL and not form submission.
			if ( isset( $_REQUEST['tab'] ) && sanitize_text_field( wp_unslash( $_REQUEST['tab'] ) ) === 'licensing' ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignoring nonce validation because we are getting data from URL and not form submission.
				wp_enqueue_style( 'mo-api-auth-license', plugin_dir_url( __FILE__ ) . 'css/miniorange-api-authentication-license.min.css', array(), $this->version, 'all' );
			}
			wp_enqueue_style( 'mo_rest_api_material_icon', plugin_dir_url( __FILE__ ) . 'css/materialdesignicons.min.css', array(), $this->version, 'all' );
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/miniorange-api-authentication-admin.min.css', array(), $this->version, 'all' );
			wp_enqueue_style( 'mo_api_authentication_bootstrap_css', plugins_url( 'css/bootstrap/bootstrap.min.css', __FILE__ ), array(), '5.3.3', false );
		}
		wp_enqueue_style( 'mo_api_authentication_admin_settings_feedback_style', plugins_url( 'css/miniorange-api-authentication-feedback-form.min.css', __FILE__ ), MINIORANGE_API_AUTHENTICATION_VERSION, array(), false, false );
		wp_enqueue_style( 'mo_api_authentication_admin_settings_auditing_style', plugins_url( 'css/miniorange-api-authentication-auditing-notification.min.css', __FILE__ ), MINIORANGE_API_AUTHENTICATION_VERSION, array(), false, false );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @return void
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Miniorange_Api_Authentication_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Miniorange_Api_Authentication_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
	}

	/**
	 * Show cURL error.
	 *
	 * @return void
	 */
	private function mo_api_authentication_show_curl_error() {
		if ( $this->mo_api_authentication_is_curl_installed() === 0 ) {
			update_option( 'mo_api_auth_message', '<a href="http://php.net/manual/en/curl.installation.php" target="_blank">PHP CURL extension</a> is not installed or disabled. Please enable it to continue.' );
			mo_api_auth_show_error_message();
			return;
		}
	}

	/**
	 * Check if cURL is installed.
	 *
	 * @return integer
	 */
	private function mo_api_authentication_is_curl_installed() {
		if ( in_array( 'curl', get_loaded_extensions(), true ) ) {
			return 1;
		} else {
			return 0;
		}
	}

	/**
	 * Register admin menu.
	 *
	 * @return void
	 */
	public function mo_api_auth_admin_menu() {

		add_menu_page( 'API Authentication Settings ' . __( 'Configure Authentication', 'wp-rest-api-authentication' ), 'miniOrange API Authentication', 'manage_options', 'mo_api_authentication_settings', array( $this, 'mo_api_auth_menu_options' ), plugin_dir_url( __FILE__ ) . 'images/miniorange.png' );
	}

	/**
	 * Admin menu options.
	 *
	 * @return void
	 */
	public function mo_api_auth_menu_options() {
		mo_api_authentication_is_customer_registered();
		mo_api_authentication_main_menu();
	}

	/**
	 * Return REST API access to current endpoint.
	 *
	 * @param mixed $access access to route.
	 * @return string
	 */
	public static function protect_routes( $access ) {

		$current_route = self::get_current_route();

		if ( self::is_protected( $current_route ) ) {
			return false;
		}

		return $access;
	}

	/**
	 * Check if protected.
	 *
	 * @param mixed $current_route current REST API endpoint requested.
	 * @return bool
	 */
	public static function is_protected( $current_route ) {
		return array_reduce(
			self::get_route_protect_option(),
			function ( $is_matched, $pattern ) use ( $current_route ) {
				return $is_matched || (bool) preg_match( '#^' . htmlspecialchars_decode( $pattern ) . '$#i', $current_route );
			},
			false
		);
	}

	/**
	 * Get route protect option.
	 *
	 * @return array
	 */
	public static function get_route_protect_option() {
		return (array) get_option( 'mo_api_authentication_protectedrestapi_route_whitelist', array() );
	}

	/**
	 * API shortlist.
	 *
	 * @return void
	 */
	public static function mo_api_auth_else() {
		self::mo_api_shortlist();
	}

	/**
	 * Get current route.
	 *
	 * @return string
	 */
	public static function get_current_route() {
		$rest_route = ! empty( $GLOBALS['wp']->query_vars['rest_route'] ) ? $GLOBALS['wp']->query_vars['rest_route'] : '';

		return ( empty( $rest_route ) || '/' === $rest_route ) ?
			$rest_route :
			untrailingslashit( $rest_route );
	}

	/**
	 * Check if REST API is allowed.
	 *
	 * @return bool
	 */
	public static function allow_rest_api() {
		return (bool) apply_filters( 'dra_allow_rest_api', is_user_logged_in() );
	}

	/**
	 * Config settings.
	 *
	 * @return void
	 */
	public function mo_api_authentication_config_settings() {
		mo_api_authentication_config_app_settings();
	}

	/**
	 * Export plugin configuration.
	 *
	 * @return void
	 */
	public function mo_api_authentication_export_plugin_configuration() {
		mo_api_authentication_export_plugin_config();
	}

	/**
	 * Convergence.
	 *
	 * @return void
	 */
	public static function mo_api_shortlist() {
		self::convergence();
	}

	/**
	 * Register REST routes.
	 *
	 * @return void
	 */
	public function register_rest_routes() {
		register_rest_route(
			'api/v1',
			'token-validate',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'mo_rest_jwt_validate_token' ),
				'permission_callback' => '__return_true',
			)
		);
		register_rest_route(
			'api/v1',
			'token',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'mo_rest_token_generation_callback' ),
				'permission_callback' => '__return_true',
			)
		);
	}

	/**
	 * Handle Token endpoint.
	 *
	 * @param mixed $request_body request body of REST API call.
	 * @return void
	 */
	public function mo_rest_token_generation_callback( $request_body ) {
		$json     = $request_body->get_params();
		$username = isset( $json['username'] ) ? sanitize_user( $json['username'] ) : false;
		$password = isset( $json['password'] ) ? $json['password'] : false;
		$json     = array(
			'username' => $username,
			'password' => $password,
		);
		mo_api_auth_token_endpoint_flow( $json );
	}

	/**
	 * Initialize flow.
	 *
	 * @return mixed
	 */
	public function mo_api_auth_initialize_api_flow() {
		if ( isset( $_SERVER['REQUEST_METHOD'] ) && 'OPTIONS' === $_SERVER['REQUEST_METHOD'] ) {
			// The Open API success request counter is increasing.
			Mo_API_Authentication_Utils::increment_success_counter( Mo_API_Authentication_Constants::OPEN_API );
			$response = array(
				'code'    => '200',
				'status'  => 'success',
				'message' => 'Preflight request accepted',

			);
			wp_send_json( $response );
		}

		mo_api_auth_restrict_rest_api_for_invalid_users();
	}

	/**
	 * This function adds newly registered REST routes to protected routes list.
	 */
	public static function protect_newly_added_rest_routes() {
		$wp_rest_server = rest_get_server();
		$all_routes     = array_keys( $wp_rest_server->get_routes() );

		$protected_routes = get_option( 'mo_api_authentication_protectedrestapi_route_whitelist', array() );
		$unsecured_routes = get_option( 'mo_api_authentication_unprotectedrestapi_route', array() );

		$new_added_routes = array_map( 'esc_html', array_diff( $all_routes, $protected_routes ) );
		$new_added_routes = array_diff( $new_added_routes, $unsecured_routes );

		if ( ! empty( $unsecured_routes ) && count( $new_added_routes ) >= 0 ) {

			$new_protected_routes = array_merge( $protected_routes, $new_added_routes );
			update_option( 'mo_api_authentication_protectedrestapi_route_whitelist', $new_protected_routes );
		} else {
			update_option( 'mo_api_authentication_unprotectedrestapi_route', $new_added_routes );
		}
	}

	/**
	 * Validate JWT token.
	 *
	 * @param bool $return_response response to be returned.
	 * @return void
	 */
	public function mo_rest_jwt_validate_token( $return_response = true ) {
		$headerkey = mo_api_auth_getallheaders();
		$headerkey = array_change_key_case( $headerkey, CASE_UPPER );
		$response  = Mo_API_Authentication_JWT_Auth::mo_api_auth_is_valid_request( $headerkey );
		if ( true === $response ) {
			$response = array(
				'status'  => 'TRUE',
				'message' => 'VALID_TOKEN',
				'code'    => '200',
			);

		}
		if ( false === $response ) {

			$response = array(
				'status'            => 'error',
				'error'             => 'UNAUTHORIZED',
				'code'              => '401',
				'error_description' => 'Incorrect JWT Format.',
			);

		}
		wp_send_json( $response );
	}

	/**
	 * Save temporary data.
	 *
	 * @return void
	 */
	public function save_temporary_data() {
		if ( ! empty( $_SERVER['REQUEST_METHOD'] ) && ! empty( $_POST['nonce'] ) && sanitize_text_field( wp_unslash( $_SERVER['REQUEST_METHOD'] ) ) === 'POST' && current_user_can( 'manage_options' ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'mo_rest_api_temporal_data_nonce' ) ) {
			if ( isset( $_POST['auth_method'] ) && sanitize_text_field( wp_unslash( $_POST['auth_method'] ) ) === 'basic_auth' ) {
				$api_temp               = array();
				$api_temp['algo']       = ! empty( $_POST['algo'] ) ? sanitize_text_field( wp_unslash( $_POST['algo'] ) ) : '';
				$api_temp['token_type'] = ! empty( $_POST['token_type'] ) ? sanitize_text_field( wp_unslash( $_POST['token_type'] ) ) : 'uname_pass';
				update_option( 'mo_rest_api_ajax_method_data', $api_temp );
			}
			$response = array(
				'success' => 'true',
			);
			wp_send_json( $response, 200 );
		}
	}

	/**
	 * Handle convergence.
	 *
	 * @return void
	 */
	public static function convergence() {
		if ( ! mo_api_auth_is_valid_request() ) {
			$response = array(
				'status'            => 'error',
				'error'             => 'UNAUTHORIZED',
				'error_description' => 'Sorry, you are not allowed to access REST API.',
			);
			wp_send_json( $response, 401 );
		}
	}

	/**
	 * Includes and displays the API summary box on the all pages.
	 *
	 * @return void
	 */
	public static function include_notice_class() {

		if( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		include_once plugin_dir_path( __FILE__ ) . 'partials/notices/admin-notices/class-mo-api-authentication-admin-notices.php';

		Mo_API_Authentication_Admin_Notices::display_summary_box();
	}

	/**
	 * Remove registered user.
	 *
	 * @return void
	 */
	public function miniorange_api_authentication_remove_registered_user() {
		delete_option( 'mo_api_authentication_new_registration' );
		delete_option( 'mo_api_authentication_admin_email' );
		delete_option( 'mo_api_authentication_admin_phone' );
		delete_option( 'mo_api_authentication_admin_fname' );
		delete_option( 'mo_api_authentication_admin_lname' );
		delete_option( 'mo_api_authentication_admin_company' );
		delete_option( 'mo_api_authentication_verify_customer' );
		delete_option( 'mo_api_authentication_admin_customer_key' );
		delete_option( 'mo_api_authentication_admin_api_key' );
		delete_option( 'mo_api_authentication_new_customer' );
		delete_option( 'mo_api_authentication_registration_status' );
		delete_option( 'mo_api_authentication_customer_token' );
	}

	/**
	 * Save settings in Database.
	 *
	 * @return void
	 */
	public function miniorange_api_authentication_save_settings() {
		if ( ! empty( $_SERVER['REQUEST_METHOD'] ) && sanitize_text_field( wp_unslash( $_SERVER['REQUEST_METHOD'] ) ) === 'POST' && current_user_can( 'manage_options' ) ) {

			if ( isset( $_POST['option'] ) && sanitize_text_field( wp_unslash( $_POST['option'] ) ) === 'mo_api_authentication_change_email_address' && isset( $_REQUEST['mo_api_authentication_change_email_address_form_fields'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['mo_api_authentication_change_email_address_form_fields'] ) ), 'mo_api_authentication_change_email_address_form' ) ) {
				$this->miniorange_api_authentication_remove_registered_user();
				return;
			} elseif ( isset( $_POST['option'] ) && 'mo_api_authentication_register_customer' === sanitize_text_field( wp_unslash( $_POST['option'] ) ) && isset( $_REQUEST['mo_api_authentication_register_form_fields'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['mo_api_authentication_register_form_fields'] ) ), 'mo_api_authentication_register_form' ) ) {    // register the admin to miniOrange
				// validation and sanitization.
				$email            = '';
				$phone            = '';
				$password         = '';
				$confirm_password = '';
				$fname            = '';
				$lname            = '';
				$company          = '';
				if ( ( empty( $_POST['email'] ) || empty( $_POST['password'] ) || empty( $_POST['confirm_password'] ) ) ) { //phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- As we are not storing password in the database, so we can ignore sanitization.
					update_option( 'mo_api_auth_message', 'All the fields are required. Please enter valid entries.' );
					update_option( 'mo_api_auth_message_flag', 2 );
					return;
				} elseif ( strlen( $_POST['password'] ) < 8 || strlen( $_POST['confirm_password'] ) < 8 ) { //phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- As we are not storing password in the database, so we can ignore sanitization.
					update_option( 'mo_api_auth_message', 'Choose a password with minimum length 8.' );
					update_option( 'mo_api_auth_message_flag', 2 );
					return;
				} else {
					$email            = ! empty( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
					$phone            = ! empty( $_POST['phone'] ) ? stripslashes( sanitize_text_field( wp_unslash( $_POST['phone'] ) ) ) : '';
					$password         = stripslashes( sanitize_text_field( $_POST['password'] ) ); //phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash -- Adding PHPCS ignore as there are special chars in password.
					$confirm_password = stripslashes( sanitize_text_field( $_POST['confirm_password'] ) ); //phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash -- Adding PHPCS ignore as there are special chars in password.
					$fname            = ! empty( $_POST['fname'] ) ? sanitize_text_field( wp_unslash( $_POST['fname'] ) ) : '';
					$lname            = ! empty( $_POST['lname'] ) ? sanitize_text_field( wp_unslash( $_POST['lname'] ) ) : '';
					$company          = ! empty( $_POST['company'] ) ? sanitize_text_field( wp_unslash( $_POST['company'] ) ) : '';
				}

				update_option( 'mo_api_authentication_admin_email', $email );
				update_option( 'mo_api_authentication_admin_phone', $phone );
				update_option( 'mo_api_authentication_admin_fname', $fname );
				update_option( 'mo_api_authentication_admin_lname', $lname );
				update_option( 'mo_api_authentication_admin_company', $company );

				if ( strcmp( $password, $confirm_password ) === 0 ) {
					$customer = new Miniorange_API_Authentication_Customer();
					$email    = get_option( 'mo_api_authentication_admin_email' );
					$content  = json_decode( $customer->check_customer(), true );
					if ( strcasecmp( $content['status'], 'CUSTOMER_NOT_FOUND' ) === 0 ) {
						$response = json_decode( $customer->create_customer( $password ), true );
						if ( strcasecmp( $response['status'], 'SUCCESS' ) !== 0 ) {
							update_option( 'mo_api_auth_message', 'Failed to create customer. Try again.' );
							update_option( 'mo_api_auth_message_flag', 2 );
						} else {
							update_option( 'mo_api_authentication_verify_customer', 'true' );
							update_option( 'mo_api_auth_message', sanitize_text_field( $response['message'] ) );
							update_option( 'mo_api_auth_message_flag', 1 );
						}
					} elseif ( strcasecmp( $content['status'], 'SUCCESS' ) === 0 ) {
						update_option( 'mo_api_authentication_verify_customer', 'true' );
						update_option( 'mo_api_auth_message', 'Account already exist. Please Login.' );
						update_option( 'mo_api_auth_message_flag', 2 );
					} elseif ( is_null( $content ) ) {
						update_option( 'mo_api_auth_message', 'Failed to create customer. Try again.' );
						update_option( 'mo_api_auth_message_flag', 2 );
					} else {
						update_option( 'mo_api_auth_message', sanitize_text_field( $content['message'] ) );
						update_option( 'mo_api_auth_message_flag', 1 );
					}
				} else {
					update_option( 'mo_api_auth_message', 'Passwords do not match.' );
					delete_option( 'mo_api_authentication_verify_customer' );
					update_option( 'mo_api_auth_message_flag', 2 );
				}
			} elseif ( isset( $_POST['option'] ) && sanitize_text_field( wp_unslash( $_POST['option'] ) ) === 'mo_api_authentication_goto_login' && isset( $_REQUEST['mo_api_authentication_goto_login_fields'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['mo_api_authentication_goto_login_fields'] ) ), 'mo_api_authentication_goto_login' ) ) {
				delete_option( 'mo_api_authentication_new_registration' );
				update_option( 'mo_api_authentication_verify_customer', 'true' );
			} elseif ( isset( $_POST['option'] ) && sanitize_text_field( wp_unslash( $_POST['option'] ) ) === 'mo_api_authentication_verify_customer' && isset( $_REQUEST['mo_api_authentication_verify_customer_form_fields'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['mo_api_authentication_verify_customer_form_fields'] ) ), 'mo_api_authentication_verify_customer_form' ) ) {  // login the admin to miniOrange.
				// validation and sanitization.
				$email    = '';
				$password = '';
				if ( empty( $_POST['email'] ) || empty( $_POST['password'] ) ) { //phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- As we are not storing password in the database, so we can ignore sanitization
					update_option( 'mo_api_auth_message', 'All the fields are required. Please enter valid entries.' );
					mo_api_auth_show_error_message();
					return;
				} else {
					$email    = ! empty( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
					$password = stripslashes( $_POST['password'] ); //phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized, WordPress.Security.ValidatedSanitizedInput.MissingUnslash --  Adding PHPCS ignore as there are special chars in password.
				}

				update_option( 'mo_api_authentication_admin_email', $email );
				$customer     = new Miniorange_API_Authentication_Customer();
				$content      = $customer->get_customer_key( $password );
				$customer_key = json_decode( $content, true );
				if ( json_last_error() === JSON_ERROR_NONE && isset( $customer_key['status'] ) && 'SUCCESS' === $customer_key['status'] ) {
					update_option( 'mo_api_authentication_admin_customer_key', sanitize_text_field( $customer_key['id'] ) );
					update_option( 'mo_api_authentication_admin_api_key', sanitize_text_field( $customer_key['apiKey'] ) );
					update_option( 'mo_api_authentication_customer_token', sanitize_text_field( $customer_key['token'] ) );
					if ( isset( $customer_key['phone'] ) ) {
						update_option( 'mo_api_authentication_admin_phone', sanitize_text_field( $customer_key['phone'] ) );
					}
					delete_option( 'password' );
					update_option( 'mo_api_auth_message', 'Customer retrieved successfully' );
					delete_option( 'mo_api_authentication_verify_customer' );
					update_option( 'mo_api_auth_message_flag', 1 );
				} else {
					update_option( 'mo_api_auth_message', 'Invalid username or password. Please try again.' );
					update_option( 'mo_api_auth_message_flag', 2 );
				}
			} elseif ( isset( $_POST['option'] ) && sanitize_text_field( wp_unslash( $_POST['option'] ) ) === 'mo_api_authentication_skip_feedback' && isset( $_REQUEST['mo_api_authentication_skip_feedback_form_fields'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['mo_api_authentication_skip_feedback_form_fields'] ) ), 'mo_api_authentication_skip_feedback_form' ) ) {
				$path = plugin_dir_path( __DIR__ ) . 'miniorange-api-authentication.php';
				deactivate_plugins( $path );
				update_option( 'mo_api_auth_message', 'Plugin deactivated successfully' );
				mo_api_auth_show_success_message();
			} elseif ( isset( $_POST['mo_api_authentication_feedback'] ) && sanitize_text_field( wp_unslash( $_POST['mo_api_authentication_feedback'] ) ) === 'true' && isset( $_REQUEST['mo_api_authentication_feedback_fields'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['mo_api_authentication_feedback_fields'] ) ), 'mo_api_authentication_feedback_form' ) ) {
				$user = wp_get_current_user();

				$message = 'Plugin Deactivated:';
				if ( isset( $_POST['deactivate_reason_select'] ) ) {
					$deactivate_reason = sanitize_text_field( wp_unslash( $_POST['deactivate_reason_select'] ) );
				}

				$deactivate_reason_message = array_key_exists( 'query_feedback', $_POST ) ? sanitize_text_field( wp_unslash( $_POST['query_feedback'] ) ) : false;

				if ( $deactivate_reason ) {
					$message .= $deactivate_reason;
					if ( isset( $deactivate_reason_message ) ) {
						$message .= ': ' . $deactivate_reason_message;
					}

					if ( isset( $_POST['rate'] ) ) {
						$rate_value = sanitize_text_field( wp_unslash( $_POST['rate'] ) );
					}

					$rating = '[Rating: ' . $rate_value . ']';

					$email = ! empty( $_POST['query_mail'] ) ? sanitize_email( wp_unslash( $_POST['query_mail'] ) ) : '';
					if ( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
						$email = get_option( 'mo_api_authentication_admin_email' );
						if ( empty( $email ) ) {
							$email = $user->user_email;
						}
					}

					$reply = $rating;

					$phone = get_option( 'mo_api_authentication_admin_phone' );

					// only reason.
					$feedback_reasons = new Miniorange_API_Authentication_Customer();
					$submitted        = $feedback_reasons->mo_api_authentication_send_email_alert( $email, $phone, $reply, $message, 'WordPress REST API Authentication by miniOrange' );

					$path = plugin_dir_path( __DIR__ ) . 'miniorange-api-authentication.php';
					deactivate_plugins( $path );
					if ( false === $submitted ) {
						update_option( 'mo_api_auth_message', 'Your query could not be submitted. Please try again.' );
						update_option( 'mo_api_auth_message_flag', 2 );
					} else {
						update_option( 'mo_api_auth_message', 'Thanks for getting in touch! We shall get back to you shortly.' );
						mo_api_auth_show_success_message();
					}
				} else {
					update_option( 'message', 'Please Select one of the reasons ,if your reason is not mentioned please select Other Reasons' );
					update_option( 'mo_api_auth_message_flag', 2 );
				}
			} elseif ( isset( $_POST['option'] ) && sanitize_text_field( wp_unslash( $_POST['option'] ) ) === 'mo_api_authentication_contact_us_query_option' && isset( $_REQUEST['mo_api_authentication_contact_us_query_form_fields'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['mo_api_authentication_contact_us_query_form_fields'] ) ), 'mo_api_authentication_contact_us_query_form' ) ) {

				// Contact Us query.
				$email = ! empty( $_POST['mo_api_authentication_contact_us_email'] ) ? sanitize_email( wp_unslash( $_POST['mo_api_authentication_contact_us_email'] ) ) : '';
				$phone = ! empty( $_POST['mo_api_authentication_contact_us_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['mo_api_authentication_contact_us_phone'] ) ) : '';
				$query = ! empty( $_POST['mo_api_authentication_contact_us_query'] ) ? sanitize_text_field( wp_unslash( $_POST['mo_api_authentication_contact_us_query'] ) ) : '';

				$customer = new Miniorange_API_Authentication_Customer();
				if ( empty( $email ) || empty( $query ) ) {
					update_option( 'mo_api_auth_message', 'Please fill up Email and Query fields to submit your query.' );
					mo_api_auth_show_error_message();
				} else {
					$submitted = $customer->submit_contact_us( $email, $phone, $query );
					if ( false === $submitted ) {
						update_option( 'mo_api_auth_message', 'Your query could not be submitted. Please try again.' );
						update_option( 'mo_api_auth_message_flag', 2 );
						return;
					} else {
						update_option( 'mo_api_auth_message', 'Thanks for getting in touch! We shall get back to you shortly.' );
						update_option( 'mo_api_auth_message_flag', 1 );
						return;
					}
				}
			} elseif ( isset( $_POST['option'] ) && sanitize_text_field( wp_unslash( $_POST['option'] ) ) === 'mo_api_authentication_license_contact_form' && isset( $_REQUEST['mo_api_authentication_license_contact_fields'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['mo_api_authentication_license_contact_fields'] ) ), 'mo_api_authentication_license_contact_form' ) ) {
				$email         = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
				$phone         = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
				$query         = isset( $_POST['query'] ) ? sanitize_text_field( wp_unslash( $_POST['query'] ) ) : '';
				$plugin_config = mo_api_authentication_export_plugin_config();
				// only reason.
				$payment_plan = new Miniorange_API_Authentication_Customer();
				if ( empty( $email ) || empty( $query ) ) {
					update_option( 'mo_api_auth_message', 'Please fill up Email and Query fields to submit your query.' );
					update_option( 'mo_api_auth_message_flag', 2 );
				} else {
					$submitted = $payment_plan->mo_api_authentication_send_email_alert( $email, $phone, '', $query, 'Payment Plan Information: WordPress REST API Authentication' );
					if ( false === $submitted ) {
						update_option( 'mo_api_auth_message', 'Your query could not be submitted. Please try again.' );
						update_option( 'mo_api_auth_message_flag', 2 );
					} else {
						update_option( 'mo_api_auth_message', 'Thanks for getting in touch! We shall get back to you shortly.' );
						update_option( 'mo_api_auth_message_flag', 1 );
					}
				}
			} elseif ( isset( $_POST['option'] ) && sanitize_text_field( wp_unslash( $_POST['option'] ) ) === 'mo_api_authentication_demo_request_form' && isset( $_REQUEST['mo_api_authentication_demo_request_field'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['mo_api_authentication_demo_request_field'] ) ), 'mo_api_authentication_demo_request_form' ) ) {
				// Demo Request.
				if ( $this->mo_api_authentication_is_curl_installed() === 0 ) {
					return $this->mo_api_authentication_show_curl_error();
				}

				$email = ! empty( $_POST['mo_api_authentication_demo_email'] ) ? sanitize_email( wp_unslash( $_POST['mo_api_authentication_demo_email'] ) ) : '';
				$query = ! empty( $_POST['mo_api_authentication_demo_usecase'] ) ? sanitize_text_field( wp_unslash( $_POST['mo_api_authentication_demo_usecase'] ) ) : '';

				$auth_methods_selected = '';
				$auth_methods          = array(
					'mo_api_authentication_demo_basic_auth' => 'Basic Authentication',
					'mo_api_authentication_demo_jwt_auth' => 'JWT Authentication',
					'mo_api_authentication_demo_apikey_auth' => 'API Key Authentication',
					'mo_api_authentication_demo_oauth_auth' => 'OAuth 2.0 Authentication',
					'mo_api_authentication_demo_thirdparty_auth' => 'Third Party Authentication',
				);
				foreach ( $auth_methods as $key => $value ) {
					if ( isset( $_POST[ $key ] ) && sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) === 'on' ) {
						$auth_methods_selected .= $value . ', ';
					}
				}

				$auth_methods_selected = rtrim( $auth_methods_selected, ', ' );

				$query .= '<br /><b> Auth Methods: </b>' . $auth_methods_selected;

				$endpoints_selected = '';
				$endpoints          = array(
					'mo_api_authentication_demo_endpoints_wp_rest_api' => 'WP REST APIs',
					'mo_api_authentication_demo_endpoints_custom_api'  => 'WP Third Party/Custom APIs',
				);
				foreach ( $endpoints as $key => $value ) {
					if ( isset( $_POST[ $key ] ) && sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) === 'on' ) {
						$endpoints_selected .= $value . ', ';
					}
				}

				$endpoints_selected = rtrim( $endpoints_selected, ', ' );

				$query .= '<br /><b> Endpoints Selected: </b>' . $endpoints_selected;

				if ( empty( $email ) || empty( $query ) ) {
					update_option( 'mo_api_auth_message', 'Please enter a valid email and the usecase.' );
					update_option( 'mo_api_auth_message_flag', 2 );
				} else {
					$subject = 'WP REST API Authentication Trial Request - ' . $email;

					$response = Mo_API_Authentication_Demo::mo_rest_api_auth_send_trial_mail( $email, $query, $subject );

					if ( false === $response ) {
						update_option( 'mo_api_auth_message', 'Demo Request could not be submitted. Please try again.' );
						update_option( 'mo_api_auth_message_flag', 2 );
					} else {
						update_option( 'mo_api_auth_message', 'Hang tight! We\'ll get back to you within 24hrs.' );
						update_option( 'mo_api_auth_message_flag', 1 );
					}
				}
			}
		}
	}
}
