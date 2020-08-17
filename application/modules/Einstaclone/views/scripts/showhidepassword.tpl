<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Einstaclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: showhidepassword.tpl 2019-12-30 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<div id="showhide_password" class="showhide_password ka">
<a class="fa fa-eye" id="show_password" href="javascript:void(0);" onclick="showhidepassword('show')" title='<?php echo $this->translate("Show Password"); ?>'></a>
<a class="fa fa-eye-slash" id="hide_password" href="javascript:void(0);" onclick="showhidepassword('hide')" style="display:none;" title='<?php echo $this->translate("Hide Password"); ?>'></a>
</div>
<script>
function showhidepassword(showhidepassword) {
	if(showhidepassword == 'show'){
		if($('show_password'))
			$('show_password').style.display = 'none';
		if($('hide_password'))
			$('hide_password').style.display = 'block';
		if(scriptJquery('#password'))
			scriptJquery('#password').attr('type', 'text');
		if(scriptJquery('#showhide_password'))
			scriptJquery('#showhide_password').addClass('m');
	} else if(showhidepassword == 'hide') {
		if($('show_password'))
			$('show_password').style.display = 'block';
		if($('hide_password'))
			$('hide_password').style.display = 'none';
		if(scriptJquery('#password'))
			scriptJquery('#password').attr('type', 'password');
		if(scriptJquery('#showhide_password'))
			scriptJquery('#showhide_password').removeClass('m');
	}
}
</script>
