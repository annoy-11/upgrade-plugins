<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesbrowserpush
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: report.tpl 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<div class='global_form_popup' style="width:450px;">
  <table class="admin_table" style="width:100%;border:1px solid #ddd;">
  	<tr>
    	<td><?php echo "Sent Date"; ?></td>
      <td><?php echo $this->locale()->toDateTime($this->scheduled->creation_date) ?></td>
    </tr>
    <tr>
      <td><?php echo "Total Notifications Received"; ?></td>
      <td><?php echo count($this->receivers); ?></td>
    </tr>
    <tr> 
      <td><?php echo "Total Notifications Clicked"; ?></td>
      <td><?php echo count($this->clicked); ?></td>
  	</tr>
  </table>
  <div style="margin-top:15px;">
		<button onclick='javascript:parent.Smoothbox.close()'><?php echo $this->translate("Close") ?></button>
	</div>
</div>
