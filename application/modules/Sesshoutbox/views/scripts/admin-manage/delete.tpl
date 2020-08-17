<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesshoutbox	
 * @package    Sesshoutbox
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: delete.tpl  2018-10-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<form method="post" class="global_form_popup" action="<?php echo $this->url(array()) ?>">
  <div>
    <h3><?php echo $this->translate("Delete This Shoutbox") ?></h3>
    <p>
      <?php echo $this->translate("Are you sure that you want to delete this shoutbox? It will not be recoverable after being deleted.", $this->type) ?>
    </p>
    <br />
    <p>
      <input type="hidden" name="id" value="<?php echo $this->item_id?>"/>
      <button type='submit'><?php echo $this->translate("Delete") ?></button>
      <?php echo $this->translate("or") ?>
			<a href='javascript:void(0);' onclick='javascript:parent.Smoothbox.close()'>
				<?php echo $this->translate("cancel") ?>
			</a>
    </p>
  </div>
</form>
