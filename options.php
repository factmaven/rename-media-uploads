
<div class="wrap">
    <h2><?php echo $this->__('Upload Renamer Settings'); ?></h2>

    <style type="text/css">
    .upload_renamer_option{ padding-left:30px; }
    .upload_renamer_option b{ text-decoration:underline; }
    </style>

    <div id="upload_renamer_options" class="inside">
        <form method="post" action="options.php">
            <?php
                wp_nonce_field('update-options');
                settings_fields('upload_renamer_setting');
            ?>

            <h3><?php echo $this->__('Setting'); ?></h3>
            <div class="upload_renamer_option">
                <h4><?php echo $this->__('Rename to'); ?>:</h4>
                <select name="upload_renamer_options[mode]" onchange="upload_renamer_selectMode(this)">
                    <option value="char-mixed" <?php echo $this->option('mode') == 'char-mixed' ? 'selected' : ''; ?>><?php echo $this->__('MiXeD cAsE'); ?></option>
                    <option value="char-lower" <?php echo $this->option('mode') == 'char-lower' ? 'selected' : ''; ?>><?php echo $this->__('lower case'); ?></option>
                    <option value="char-upper" <?php echo $this->option('mode') == 'char-upper' ? 'selected' : ''; ?>><?php echo $this->__('UPPER CASE'); ?></option>
                    <option value="num" <?php echo $this->option('mode') == 'num' ? 'selected' : ''; ?>><?php echo $this->__('Numbers'); ?></option>
                    <option value="date" <?php echo $this->option('mode') == 'date' ? 'selected' : ''; ?>><?php echo $this->__('Date & Time'); ?></option>
                    <option value="custom" <?php echo $this->option('mode') == 'custom' ? 'selected' : ''; ?>><?php echo $this->__('Custom'); ?></option>
                </select>
            </div>

            <div class="upload_renamer_option">
                <h4><?php echo $this->__('Length'); ?>:</h4>
                <p><?php echo $this->__('Set length of the random chars / numbers.'); ?></p>
                <input id="upload_renamer_length" style="width:60px;" name="upload_renamer_options[length]" value="<?php echo $this->option('length'); ?>" />
            </div>

            <div class="upload_renamer_option">
                <h4><?php echo $this->__('Parameters'); ?>:</h4>
                <p><?php echo $this->__('Set value of some chars in char mode, ex:"ABCDEFGHIabcdefg_123"<br /> or a date format string in time mode, ex:"Y_m_d_H_i_s"<br /> or use <b>%file%</b> , <b>%date|Y-m-d%</b> , <b>%chars|5%</b> , <b>%nums|7%</b> in custom mode.'); ?></p>
                <input id="upload_renamer_param" style="width:400px;" name="upload_renamer_options[param]" value="<?php echo $this->option('param'); ?>" />
            </div>

            <input type="hidden" name="action" value="update" />
            <input type="hidden" name="upload_renamer_setting" value="upload_renamer_options" />
            <div style="padding:20px 0px 30px 30px ;">
                <input type="submit" class="button-primary" value="<?php echo $this->__('Save'); ?>" />
            </div>
        </form>

        <hr />

    </div>
</div>

<script type="text/javascript">
upload_renamer_selectMode(dom){
    var j = jQuery(dom);
    jQuery("#upload_renamer_length, #upload_renamer_options").removeAttr("disabled");
    if(j.val() == 'date' || j.val() == 'custom'){
        jQuery("#upload_renamer_length").attr("disabled");
    }else if(j.val() == 'num'){
        jQuery("#upload_renamer_options").attr("disabled");
    }
}
</script>