<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div class="sesqa_users_acted" id="sesqa-container-right">
  <?php foreach($this->defaultOptions as $key=>$defaultOptions){ ?>
    <?php if($key == 'Like' && $this->paginatorLike->getTotalItemCount() > 0){ ?>
      <!-- PEOPLE LIKE Question-->
      <section class="sesbasic_clearfix">
        <div class="_head"><?php echo $this->translate($defaultOptions); ?></div>
        <ul class="sesqa_user_listing sesbasic_clearfix clear">
          <?php foreach( $this->paginatorLike as $item ): ?>
            <li>
              <?php $user = Engine_Api::_()->getItem('user',$item->poster_id) ?>
              <?php echo $this->htmlLink($user->getHref(), $this->itemPhoto($user, 'thumb.icon'),array('title'=>$user->getTitle())); ?>
            </li>
          <?php endforeach; ?>
          <?php if($this->paginatorLike->getTotalItemCount() > $this->data_showLike){ ?>
            <li class="sesqa_user_more">
              <a href="javascript:;" onclick="getLikeDataQA('<?php echo $this->question->getIdentity(); ?>','<?php echo urlencode($this->translate($defaultOptions)); ?>')" class="sesqa_user_listing_more">
               <?php echo '+';echo $this->paginatorLike->getTotalItemCount() - $this->data_showLike ; ?>
              </a>
            </li>
          <?php } ?>
        </ul>
      </section>
    <?php } ?>
    <?php if($key == 'Fav' && $this->paginatorFav->getTotalItemCount() > 0){ ?>
      <!-- PEOPLE FAVOURITE Question-->
      <section class="sesbasic_clearfix">
        <div class="_head"><?php echo $this->translate($defaultOptions); ?></div>
        <ul class="sesqa_user_listing sesbasic_clearfix clear">
          <?php foreach( $this->paginatorFav as $item ): ?>
            <li>
              <?php $user = Engine_Api::_()->getItem('user',$item->user_id) ?>
              <?php echo $this->htmlLink($user->getHref(), $this->itemPhoto($user, 'thumb.icon'),array('title'=>$user->getTitle())); ?>
            </li>
          <?php endforeach; ?>
          <?php if($this->paginatorFav->getTotalItemCount() > $this->data_showFav){ ?>
            <li class="sesqa_user_more">
              <a href="javascript:;" onclick="getFavouriteDataQA('<?php echo $this->question->getIdentity(); ?>','<?php echo urlencode($this->translate($defaultOptions)); ?>')" class="sesqa_user_listing_more">
               <?php echo '+';echo $this->paginatorFav->getTotalItemCount() - $this->data_showFav ; ?>
              </a>
            </li>
          <?php } ?>
        </ul>
      </section>
    <?php } ?>
    <?php if($key == 'Follow' && $this->paginatorFollow->getTotalItemCount() > 0){ ?>
      <!-- PEOPLE Follow IN Question-->
      <section class="sesbasic_clearfix">
        <div class="_head"><?php echo $this->translate($defaultOptions); ?></div>
        <ul class="sesqa_user_listing sesbasic_clearfix clear">
          <?php foreach( $this->paginatorFollow as $item ): ?>
            <li>
              <?php $user = Engine_Api::_()->getItem('user',$item->user_id) ?>
              <?php echo $this->htmlLink($user->getHref(), $this->itemPhoto($user, 'thumb.icon'),array('title'=>$user->getTitle())); ?>
            </li>
            <?php endforeach; ?>
            <?php if($this->paginatorFollow->getTotalItemCount() > $this->data_showFollow){ ?>
              <li class="sesqa_user_more">
                <a href="javascript:;" onclick="getFollowDataQA('<?php echo $this->question->getIdentity(); ?>','<?php echo urlencode($this->translate($defaultOptions)); ?>')" class="sesqa_user_listing_more">
                <?php echo '+';echo $this->paginatorFollow->getTotalItemCount() - $this->data_showFollow ; ?>
                </a>
            </li>
          <?php } ?>
        </ul>
      </section>
    <?php } ?>
  <?php } ?>
</div>

