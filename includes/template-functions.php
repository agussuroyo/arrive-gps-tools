<?php

defined('ABSPATH') || exit();

if (!function_exists('agt_get_template')) {

    function agt_get_template($____file = '', $data = [])
    {
        ob_start();
        extract($data, EXTR_SKIP);
        include AGT_PATH . DIRECTORY_SEPARATOR . 'template/' . trim($____file, DIRECTORY_SEPARATOR);
        return ob_get_clean();
    }

}


if (!function_exists('agt_request_post')) {

    function agt_request_post($name)
    {
        return isset($_POST[$name]) ? $_POST[$name] : null;
    }

}


if (!function_exists('agt_inline_error')) {

    function agt_inline_error($name)
    {
        global $agt_form_errors;

        $msg = isset($agt_form_errors[$name]) ? $agt_form_errors[$name] : null;
        $cnt = '';

        if (!empty($msg)) {
            ob_start();
            ?>
            <p class="form-error" style="color: #9b2922;"><?php echo $msg; ?></p>
            <?php
            $cnt = ob_get_clean();
        }

        return $cnt;
    }

}