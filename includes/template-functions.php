<?php
/**
 * Functions module
 *
 * @package AGT
 */

defined( 'ABSPATH' ) || exit();

if ( ! function_exists( 'agt_get_template' ) ) {

	function agt_get_template( $____file = '', $data = array() ) {
		ob_start();
		extract( $data, EXTR_SKIP );
		include AGT_PATH . DIRECTORY_SEPARATOR . 'template/' . trim( $____file, DIRECTORY_SEPARATOR );
		return ob_get_clean();
	}
}


if ( ! function_exists( 'agt_request_post' ) ) {

	function agt_request_post( $name ) {
		return isset( $_POST[ $name ] ) ? $_POST[ $name ] : null;
	}
}


if ( ! function_exists( 'agt_inline_error' ) ) {

	function agt_inline_error( $name ) {
		global $agt_form_errors;

		$msg = isset( $agt_form_errors[ $name ] ) ? $agt_form_errors[ $name ] : null;
		$cnt = '';

		if ( ! empty( $msg ) ) {
			ob_start();
			?>
		<p class="form-error" style="color: #9b2922;"><?php echo $msg; ?></p>
			<?php
			$cnt = ob_get_clean();
		}

		return $cnt;
	}
}

if ( ! function_exists( 'agt_get_rates_plan' ) ) {

	function agt_get_rates_plan() {
		$rate_plans = get_transient( 'agt_rates_plan' );

		if ( empty( $rate_plans ) ) {
			$sid    = get_option( 'agt_account_sid' );
			$token  = get_option( 'agt_auth_token' );
			$twilio = new Twilio\Rest\Client( $sid, $token );

			$ratePlans = $twilio->wireless->v1->ratePlans
			->read();

			$rates = array();
			foreach ( $ratePlans as $record ) {
				$rates[ $record->sid ] = $record->uniqueName;
			}

			$rate_plans = $rates;

			set_transient( 'agt_rates_plan', $rates, WEEK_IN_SECONDS );
		}

		return $rate_plans;
	}
}


if ( ! function_exists( 'agt_get_all_sim' ) ) {

	function agt_get_all_sim() {
		try {
			$sims = array();

			$twilio = new Twilio\Rest\Client( get_option( 'agt_account_sid' ), get_option( 'agt_auth_token' ) );

			$results = $twilio->wireless->v1->sims->read();

			foreach ( $results as $record ) {
				$sims[] = $record->sid;
			}

			return $sims;
		} catch ( Exception $exc ) {
			return new WP_Error( $exc->getCode(), $exc->getMessage() );
		}
	}
}

if ( ! function_exists( 'agt_get_simid_by_unique' ) ) {

	function agt_get_simid_by_unique( $name = '' ) {
		$sim = array();

		try {
			$twilio = new Twilio\Rest\Client( get_option( 'agt_account_sid' ), get_option( 'agt_auth_token' ) );
			$sim    = $twilio->wireless->v1->sims( $name )
			->fetch();

			return $sim->sid;
		} catch ( Exception $exc ) {
			return new WP_Error( $exc->getCode(), $exc->getMessage() );
		}
	}
}


if ( ! function_exists( 'agt_update_status' ) ) {

	function agt_update_status( $args = array() ) {
		try {
			$params = wp_parse_args(
				$args,
				array(
					'sid'    => '',
					'status' => 'active',
				)
			);

			$twilio = new Twilio\Rest\Client( get_option( 'agt_account_sid' ), get_option( 'agt_auth_token' ) );
			return $twilio->wireless->v1->sims( $params['sid'] )->update(
				array(
					'status'         => $params['status'],
					'callbackUrl'    => add_query_arg( array( 'agt_callback' => 'yes' ), home_url() ),
					'callbackMethod' => 'POST',
				)
			);
		} catch ( Exception $exc ) {
			return new WP_Error( $exc->getCode(), $exc->getMessage() );
		}
	}
}
