<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslike
 * @package    Seslike
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seslike/externals/styles/styles.css'); ?>
<div class="seslike_main_content_widget sesbasic_bxs sesbasic_clearfix">
  <div class="seslike_main_content_inner">
    <?php  if($this->paginator->getTotalItemCount() > 0) {  ?>
     <ul class="seslike_items_cont">
        <?php foreach($this->paginator as $item) { ?>
          <?php $user = Engine_Api::_()->getItem('user', $item->poster_id); ?>
          <?php if($user) { ?>
            <li class="seslike_item seslike_member_liked">
              <a href="<?php echo $user->getHref(); ?>">
                <div class="_img">
                  <?php echo $this->itemPhoto($user, 'thumb.profile', true); ?>
                </div>
                <div class="_title"><span><?php echo $user->getTitle(); ?></span></div>
              </a>
            </li>
          <?php } ?>
        <?php } ?>
     </ul>
    <?php } else { ?>
      <div class="tip">
        <span>
          <?php echo $this->translate("There are no results.");?>
        </span>
      </div>
    <?php } ?>
  </div>
</div>
