<?php

defined('ABSPATH') || exit();

use Twilio\Rest\Client;

class AGT_Shortcode
{

    /**
     * Form handler
     * 
     * @global array $agt_form_errors
     * @return void
     */
    public function handle()
    {
        if (!isset($_POST['agt_submit'])) {
            return;
        }

        // Form Validations
        global $agt_form_errors;
        $agt_form_errors = [];

        $rules = array(
            [
                'name' => 'agt_name',
                'callback' => function($value) {
                    return !empty($value);
                }
            ],
            [
                'name' => 'agt_bussines_name',
                'callback' => function($value) {
                    return !empty($value);
                }
            ],
            [
                'name' => 'agt_bussines_address',
                'callback' => function($value) {
                    return !empty($value);
                }
            ],
            [
                'name' => 'agt_imei',
                'callback' => function($value) {
                    return !empty($value);
                }
            ],
            [
                'name' => 'agt_date',
                'callback' => function($value) {
                    return !empty($value);
                }
            ],
            [
                'name' => 'agt_device_type',
                'callback' => function($value) {
                    return !empty($value);
                }
            ],
        );

        // Apply rules
        foreach ($rules as $rule) {
            if (!call_user_func_array($rule['callback'], [agt_request_post($rule['name'])])) {
                $agt_form_errors[$rule['name']] = 'The field is required';
            }
        }

        // Stop when errors
        if (!empty($agt_form_errors)) {
            return;
        }

        // No errors? Execute the configuration
        if (empty($agt_form_errors)) {

            // Activate first
            $this->send_activate(array(
                'sid' => 'DEAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA'
            ));
        }
    }

    /**
     * Get all available SIMS
     * 
     * @return \WP_Error|object
     */
    public function get_sims()
    {
        try {
            $sims = [];

            $twilio = new Client(get_option('agt_account_sid'), get_option('agt_auth_token'));

            $results = $twilio->wireless->v1->sims->read();

            foreach ($results as $record) {
                $sims[] = $record->sid;
            }

            return $sims;
        } catch (Exception $exc) {
            return new WP_Error($exc->getCode(), $exc->getMessage());
        }
    }

    /**
     * SIM activation
     * 
     * @param array $args
     * @return \WP_Error|object
     */
    public function send_activate($args = [])
    {
        try {
            $params = wp_parse_args($args, array(
                'sid' => ''
            ));

            $twilio = new Client(get_option('agt_account_sid'), get_option('agt_auth_token'));
            return $twilio->wireless->v1->sims($params['sid'])->update(array(
                        'status' => 'active',
                        'callbackUrl' => add_query_arg(array('agt_callback' => 'yes'), home_url()),
                        'callbackMethod' => 'POST'
            ));
        } catch (Exception $exc) {
            return new WP_Error($exc->getCode(), $exc->getMessage());
        }
    }

    /**
     * Display form
     * 
     * @return string
     */
    public function form()
    {
        return agt_get_template('form.php');
    }

}
