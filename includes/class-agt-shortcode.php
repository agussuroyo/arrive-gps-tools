<?php
/**
 * Shortcode module
 *
 * @package AGT
 */

defined( 'ABSPATH' ) || exit();

use Twilio\Rest\Client;

/**
 * AGT_Shortcode
 */
class AGT_Shortcode {


	/**
	 * Form handler
	 *
	 * @global array $agt_form_errors Save errors data.
	 * @return void
	 */
	public function handle() {

		global $agt_form_errors, $agt_form_success, $agt_form_fields;
		$agt_form_errors  = array();
		$agt_form_success = array();
		$agt_form_fields  = array();

		if ( ! isset( $_POST['agt_submit'] ) ) {
			return;
		}

		// Form Validations
		$rules = array(
			array(
				'name'     => 'agt_unique_name',
				'callback' => function( $value ) {
					return ! empty( $value );
				},
			),
			array(
				'name'     => 'agt_rates',
				'callback' => function( $value ) {
					return ! empty( $value );
				},
			),
		);

		// Apply rules.
		foreach ( $rules as $rule ) {
			$post_item                        = agt_request_post( $rule['name'] );
			$agt_form_fields[ $rule['name'] ] = $post_item;
			if ( ! call_user_func_array( $rule['callback'], array( $post_item ) ) ) {
				$agt_form_errors[ $rule['name'] ] = 'The field is required';
			}
		}

		// Stop when errors.
		if ( ! empty( $agt_form_errors ) ) {
			return;
		}

		// No errors? Execute the configuration.
		try {

			$sid = agt_get_simid_by_unique( agt_request_post( 'agt_unique_name' ) );
			if ( is_wp_error( $sid ) ) {
				throw new Exception( $sid->get_error_message(), $sid->get_error_code() );
			}

			$data = array(
				'sid'    => $sid,
				'status' => 'active',
			);

			$rate_plan_id = agt_request_post( 'agt_rates' );
			if ( ! empty( $rate_plan_id ) ) {
				$data['ratePlan'] = $rate_plan_id;
			}

			$save = agt_update_status( $data );

			if ( ! is_wp_error( $save ) ) {
				$agt_form_success[] = 'Activating SIM processed.';
				$agt_form_fields    = array();
			}
		} catch ( Exception $exc ) {
			$agt_form_errors['agt_unique_name'] = 'Incorrect SIM';
		}
	}

	/**
	 * Display form
	 *
	 * @return string
	 */
	public function form() {
		global $agt_form_success, $agt_form_fields;
		$rates = agt_get_rates_plan();

		$data                    = array();
		$data['rates']           = $rates;
		$data['success_message'] = $agt_form_success;
		$data['fields']          = $agt_form_fields;
		return agt_get_template( 'form.php', $data );
	}

}
