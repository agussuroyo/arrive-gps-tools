<?php

defined('ABSPATH') || exit();

use Twilio\Rest\Client;

class AGT_Webhook
{

    /**
     * Callback handler for Twilio after activation
     * 
     * @return void
     */
    public function notify_sim_update()
    {
        $sim_id = agt_request_post('SimSid');
        $sim_unique_name = agt_request_post('SimUniqueName');
        
        $sim_status = agt_request_post('SimStatus');
        $sim_error_code = agt_request_post('ErrorCode');

        if (!empty($sim_error_code)) {
            error_log('Twilio error code: ' . $sim_error_code);
            error_log('Twilio post data: ' . json_encode($_POST));
            return;
        }

        if ($sim_status == 'active') {
            $this->send_sms(array(
                'to' => '',
                'body' => ''
            ));
        }

        wp_send_json(array(
            'data' => $_POST
        ));
    }

    /**
     * Send SMS to with body
     * 
     * @param array $args
     * @return \WP_Error|object
     */
    public function send_sms($args = [])
    {
        try {

            $params = wp_parse_args($args, array(
                'from' => get_option('agt_sms_from'),
                'to' => '',
                'body' => ''
            ));

            $twilio = new Client(get_option('agt_account_sid'), get_option('agt_auth_token'));

            return $twilio->messages->create($params['to'], array(
                        'from' => $params['from'],
                        'body' => $params['body']
            ));
        } catch (Exception $exc) {
            return new WP_Error($exc->getCode(), $exc->getMessage());
        }
    }

}
