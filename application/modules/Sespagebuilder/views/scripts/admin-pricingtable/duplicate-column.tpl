<?php 
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: duplicate-column.tpl 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */ 
 ?>
<form method="post" class="global_form_popup">
  <div>    
    <div class="tip">
      <span>
        <?php echo $this->translate("Are you sure want to duplicate this column?") ?>
      </span>
    </div>
    <input type="hidden" name="confirm" value="<?php echo $this->id ?>"/>
    <button type='submit'><?php echo $this->translate("Duplicate") ?></button>
    <?php echo $this->translate(" or ") ?> 
    <a href='javascript:void(0);' onclick='javascript:parent.Smoothbox.close()'><?php echo $this->translate("Cancel") ?></a>
  </div>
</form>