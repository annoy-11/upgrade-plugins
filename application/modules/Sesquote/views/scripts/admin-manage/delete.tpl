<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesquote
 * @package    Sesquote
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: delete.tpl  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>

<form method="post" class="global_form_popup">
  <div>
    <h3><?php echo $this->translate("Delete Quote Entry?") ?></h3>
    <p>
      <?php echo $this->translate("Are you sure that you want to delete this quote entry? It will not be recoverable after being deleted.") ?>
    </p>
    <br />
    <p>
      <input type="hidden" name="confirm" value="<?php echo $this->quote_id?>"/>
      <button type='submit'><?php echo $this->translate("Delete") ?></button>
      <?php echo $this->translate(" or ") ?> 
      <a href='javascript:void(0);' onclick='javascript:parent.Smoothbox.close()'>
      <?php echo $this->translate("cancel") ?></a>
    </p>
  </div>
</form>
