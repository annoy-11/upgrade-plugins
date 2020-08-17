<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespoke
 * @package    Sespoke
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _feedPoke.tpl 2016-07-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php 
  $manageaction = Engine_Api::_()->getItem('sespoke_manageaction',$this->poke->manageaction_id);
  if($manageaction) {
    $file = Engine_Api::_()->getItemTable('storage_file')->getFile($manageaction->image,'');	
    $path = $file->map();
?>
<span class="feed_attachment_sespoke_poke">
  <div> 
    <a href="javascript:void(0);">
      <img src="<?php echo $path ?>" class="" style="display:block;max-width:200px;"></a>
  </div>
</span>
<?php } ?>