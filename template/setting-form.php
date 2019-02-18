<?php
defined('ABSPATH') || exit();
?>
<div class="wrap">
    <h2><?php echo $admin_title; ?></h2>
    <form action="" method="post">
        <input type="hidden" name="agt_setting_save" value="1" />
        <table class="form-table">
            <tbody>
                <tr>
                    <td>
                        <label>SMS From</label>
                    </td>
                    <td>
                        <input type="text" name="sms_from" value="<?php echo $sms_from; ?>" class="regular-text" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Account SID</label>
                    </td>
                    <td>
                        <input type="text" name="account_sid" value="<?php echo $account_sid; ?>" class="regular-text" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Auth Token</label>
                    </td>
                    <td>
                        <input type="text" name="auth_token" value="<?php echo $auth_token; ?>" class="regular-text" />
                    </td>
                </tr>
            </tbody>
        </table>
        <?php submit_button(); ?>
    </form>
</div>