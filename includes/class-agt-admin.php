<?php

class AGT_Admin
{

    public function menu()
    {
        add_menu_page('AGT', 'AGT', 'manage_options', 'agt', array($this, 'setting_form'));
    }

    public function setting_handle()
    {
        if (!isset($_POST['agt_setting_save'])) {
            return;
        }

        $sid = agt_request_post('sms_from');
        if($sid){
            update_option('agt_sms_from', $sid);
        }
        
        $sid = agt_request_post('account_sid');
        if($sid){
            update_option('agt_account_sid', $sid);
        }

        $token = agt_request_post('auth_token');
        if($token){
            update_option('agt_auth_token', $token);
        }
    }

    public function setting_form()
    {
        $data = [];
        $data['admin_title'] = get_admin_page_title();
        $data['sms_from'] = get_option('agt_sms_from');
        $data['account_sid'] = get_option('agt_account_sid');
        $data['auth_token'] = get_option('agt_auth_token');
        echo agt_get_template('setting-form.php', $data);
    }

}
