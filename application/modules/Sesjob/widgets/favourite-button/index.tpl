<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if (!empty($this->viewer_id) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.enable.favourite', 1)): ?>
  <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesjob')->isFavourite(array('resource_type'=>'sesjob_job','resource_id'=>$this->sesjob->job_id)); ?>
  <div class="sesjob_button">
    <a href="javascript:;" data-url="<?php echo $this->sesjob->job_id ; ?>" class="sesbasic_animation sesbasic_link_btn  sesjob_favourite_sesjob_job_<?php echo $this->sesjob->job_id ?> sesjob_favourite_sesjob_job_view <?php echo ($favStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-heart"></i><span><?php if($favStatus):?><?php echo $this->translate('Un-Favourite');?><?php else:?><?php echo $this->translate('Favourite');?><?php endif;?></span></a>
  </div>
<?php endif; ?>
