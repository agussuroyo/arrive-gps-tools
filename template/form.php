<?php
defined('ABSPATH') || exit();
?>
<form action="" method="post">
    <div class="wrap-forms">
        <div class="fw-row">
            <div class="fw-col-xs-12 fw-col-sm-6 form-builder-item">
                <div class="field-text">
                    <input type="text" name="agt_name" class="" value="" placeholder="Name" autocomplete="off" />
                </div>
                <?php echo agt_inline_error('agt_name'); ?>
            </div>
        </div>
        <div class="fw-row">
            <div class="fw-col-xs-12 fw-col-sm-6 form-builder-item">
                <div class="field-text">
                    <input type="text" name="agt_bussines_name" class="" value="" placeholder="Business Name" autocomplete="off" />
                </div>
                <?php echo agt_inline_error('agt_bussines_name'); ?>
            </div>
        </div>
        <div class="fw-row">
            <div class="fw-col-xs-12 fw-col-sm-6 form-builder-item">
                <div class="field-text">
                    <input type="text" name="agt_bussines_address" class="" value="" placeholder="Business Address" autocomplete="off" />
                </div>
                <?php echo agt_inline_error('agt_bussines_address'); ?>
            </div>
        </div>
        <div class="fw-row">
            <div class="fw-col-xs-12 fw-col-sm-6 form-builder-item">
                <div class="field-text">
                    <input type="text" name="agt_imei" class="" value="" placeholder="IMEI Number" autocomplete="off" />
                </div>
                <?php echo agt_inline_error('agt_imei'); ?>
            </div>
        </div>
        <div class="fw-row">
            <div class="fw-col-xs-12 fw-col-sm-6 form-builder-item">
                <div class="field-text">
                    <input type="date" name="agt_date" class="" placeholder="Date" autocomplete="off" />
                </div>
                <?php echo agt_inline_error('agt_date'); ?>
            </div>
        </div>
        <div class="fw-row">
            <div class="fw-col-xs-12 fw-col-sm-6 form-builder-item">
                <div class="field-select">
                    <select name="agt_device_type">
                        <option value="">Device Type</option>
                        <option value="1">XT2050C</option>
                        <option value="2">XT2060G</option>
                        <option value="3">XT2150CS</option>
                        <option value="4">XT2150CV</option>
                        <option value="5">XT2160G</option>                        
                    </select>
                </div>
                <?php echo agt_inline_error('agt_date'); ?>
            </div>
        </div>
        <div class="fw-row">
            <div class="fw-col-md-12">
                <button name="agt_submit" type="submit" value="1">Activate</button>
            </div>
        </div>
    </div>
</form>