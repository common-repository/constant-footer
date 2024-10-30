<?php
$location = $footer_options_page; // Form Action URI

/* Check for admin Options submission and update options*/
if ('process' == $_POST['stage']) {
    update_option('constant_footer_height', $_POST['constant_footer_height']);
    update_option('constant_footer_bgcolor', $_POST['constant_footer_bgcolor']);
    update_option('constant_footer_opacity', $_POST['constant_footer_opacity']);
	update_option('constant_footer_fhtml', addslashes($_POST['constant_footer_fhtml']));
	$status = "settings updated successfully.";
}

$constant_footer_fhtml = stripslashes(get_option('constant_footer_fhtml'));
?>

<div class="wrap">
  <h2><?php _e('Constant Footer Options', 'constant-footer') ?></h2>
  <?php if(isset($status)) {?>
  	<div class="updated fade" id="message" style="background-color: rgb(255, 251, 204);">
  		<p><?php echo $status;?></p>
	</div>
  <?php } ?>

  <form name="form1" method="post" action="<?php echo $location ?>&amp;updated=true">
	<input type="hidden" name="stage" value="process" />
	 <table width="100%" cellspacing="2" cellpadding="5" class="form-table">
        <tr valign="baseline">
         <th scope="row"><?php _e('Height', 'constant-footer') ?></th> 
         <td><input type="text" name="constant_footer_height" id="constant_footer_height" value="<?php echo get_option('constant_footer_height'); ?>" />px</td>

        </tr>
		<tr valign="baseline">
         <th scope="row"><?php _e('Background Color', 'constant-footer') ?></th> 
         <td><input class="color" name="constant_footer_bgcolor" id="constant_footer_bgcolor" value="<?php echo get_option('constant_footer_bgcolor'); ?>"/>
		 </td>

        </tr>
		<tr valign="baseline">
         <th scope="row"><?php _e('Opacity', 'constant-footer') ?></th> 
         <td><input type="text" name="constant_footer_opacity" id="constant_footer_opacity" value="<?php echo get_option('constant_footer_opacity'); ?>" /></td>
        </tr>
	<tr valign="baseline">
         <th scope="row"><?php _e('Footer Html', 'constant-footer') ?></th> 
         <td><textarea rows="5" cols="30" name="constant_footer_fhtml" id="constant_footer_fhtml"><?php echo stripslashes($constant_footer_fhtml); ?></textarea></td>
        </tr>
     </table>


	<p class="submit">
      <input type="submit" name="Submit" value="<?php _e('Save Changes', 'constant-footer') ?>" />
    </p>
  </form>
  
  <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="CQ655WTCB49CS">
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
  
</div>