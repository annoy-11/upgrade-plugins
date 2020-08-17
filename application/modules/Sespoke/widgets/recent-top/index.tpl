<?php 
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespoke
 * @package    Sespoke
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespoke/externals/styles/styles.css'); ?>
<?php if(!$this->showType) : ?>
  <ul class="sespoke_sidebar_list sespoke_clearfix sespoke_bxs">
    <?php foreach($this->results as $item): 
    if($this->popularity == 'top'):
      $user = Engine_Api::_()->getItem('user', $item['user_id']);
    else: 
      $user = Engine_Api::_()->getItem('user', $item['poster_id']);
    endif;
    ?>
    <?php if(!empty($user->user_id)): ?>
      <?php if($this->popularity == 'recent'): ?>
        <?php $userinfos = Engine_Api::_()->getDbtable('userinfos', 'sespoke')->getResults(array('user_id' => $item['poster_id'], 'action' => 'widget')); ?>
      <?php endif; ?>
      <li class="sespoke_clearfix">
        <?php echo $this->htmlLink($user->getHref(), $this->itemPhoto($user, 'thumb.icon', $user->getTitle()), array('class' => 'sespoke_sidebar_list_thumb')) ?>
        <div class='sespoke_sidebar_list_info'>
          <div class='sespoke_sidebar_list_title'>
            <?php echo $this->htmlLink($user->getHref(), $user->getTitle()) ?>
          </div>
          <div class="sespoke_sidebar_list_stats sespoke_text_light">
          <?php if($this->popularity == 'top'): ?>
            <?php if($item[$this->count] == 1): ?>
              <?php //$count = "%s " . $this->action;
              echo $item[$this->count]. ' ' . $this->translate($this->action); ?>
            <?php else: ?>
              <?php //$counts = "%s " . $this->action . 's';
              echo $item[$this->count] . ' ' . $this->translate($this->action) . 's'; ?>
            <?php endif; ?>
          <?php endif; ?>
          </div>
        </div>
      </li>
    <?php endif; ?>
    <?php endforeach; ?>
  </ul>
<?php else : ?>
  <ul class="sespoke_member_list_grid sespoke_clearfix sespoke_bxs">
    <?php foreach($this->results as $item):
    if($this->popularity == 'top'):
      $user = Engine_Api::_()->getItem('user', $item['user_id']);
    else: 
      $user = Engine_Api::_()->getItem('user', $item['poster_id']);
    endif;
    ?>
    <?php if(!empty($user->user_id)): ?>
      <li class="sespoke_clearfix">
        <?php echo $this->htmlLink($user->getHref(), $this->itemPhoto($user, 'thumb.icon', $user->getTitle()), array('title' => $user->getTitle(), 'class' => 'sespoke_member_list_grid_thumb')) ?>
      </li>
    <?php endif; ?>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>