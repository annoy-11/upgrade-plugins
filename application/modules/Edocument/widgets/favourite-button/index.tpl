<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if (!empty($this->viewer_id) && Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.enable.favourite', 1)): ?>
  <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'edocument')->isFavourite(array('resource_type'=>'edocument','resource_id'=>$this->edocument->edocument_id)); ?>
  <div class="edocument_button">
    <a href="javascript:;" data-url="<?php echo $this->edocument->edocument_id ; ?>" class="sesbasic_animation sesbasic_link_btn  edocument_favourite_edocument_<?php echo $this->edocument->edocument_id ?> edocument_favourite_edocument_view <?php echo ($favStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-heart"></i><span><?php if($favStatus):?><?php echo $this->translate('Un-Favourite');?><?php else:?><?php echo $this->translate('Favourite');?><?php endif;?></span></a>
  </div>
<?php endif; ?>
