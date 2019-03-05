<?php

class TwilioTest extends WP_UnitTestCase {

	public function test_get_rate() {
		$rates = agt_get_rates_plan();
		
		$this->assertTrue( is_array( $rates ));
	}

}
