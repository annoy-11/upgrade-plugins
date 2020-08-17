<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if (!empty($this->viewer_id) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.favourite', 1)): ?>
  <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesrecipe')->isFavourite(array('resource_type'=>'sesrecipe_recipe','resource_id'=>$this->sesrecipe->recipe_id)); ?>
  <div class="sesrecipe_button">
    <a href="javascript:;" data-url="<?php echo $this->sesrecipe->recipe_id ; ?>" class="sesbasic_animation sesbasic_link_btn  sesrecipe_favourite_sesrecipe_recipe_<?php echo $this->sesrecipe->recipe_id ?> sesrecipe_favourite_sesrecipe_recipe_view <?php echo ($favStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-heart"></i><span><?php if($favStatus):?><?php echo $this->translate('Un-Favourite');?><?php else:?><?php echo $this->translate('Favourite');?><?php endif;?></span></a>
  </div>
<?php endif; ?>
