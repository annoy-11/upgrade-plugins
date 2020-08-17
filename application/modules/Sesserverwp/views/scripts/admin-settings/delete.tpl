<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesserverwp
 * @package    Sesserverwp
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: delete.tpl  2019-01-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<form method="post" class="global_form_popup">
  <div>
    <h3><?php echo $this->translate("Delete Entry?") ?></h3>
    <p><?php echo $this->translate("Are you sure that you want to delete this entry? It will not be recoverable after being deleted.") ?></p>
    <br />
    <p>
      <input type="hidden" name="confirm"/>
      <button type='submit'>Delete</button>
        &nbsp;or&nbsp;
      <a href='javascript:void(0);' onclick='javascript:parent.Smoothbox.close()'>Cancel</a>
    </p>
  </div>
</form>