<?php
/**
 * SocialEngine
 *
 * @category   Application_Core
 * @package    User
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: index.tpl 10167 2014-04-15 19:18:29Z lucas $
 * @author     John
 */
?>
<?php $params = $this->params; ?>
<?php if($params['viewType'] == 'list') { ?>
  <div class="sesinviter_topinviters generic_list_wrapper">
      <ul class="sesinviter_topinviters_inner generic_list_widget">
        <?php foreach( $this->results as $result ): ?>
          <?php $user = Engine_Api::_()->getItem('user', $result->sender_id); ?>
          <li class="sesinviter_list_item">
            <?php echo $this->htmlLink($user->getHref(), $this->itemPhoto($user, 'thumb.icon', $user->getTitle()), array('class' => 'sesinviter_topinviters_thumb')) ?>
            <div class='sesinviter_topinviters_info'>
              <div class='sesinviter_topinviters_name'>
                <?php echo $this->htmlLink($user->getHref(), $user->getTitle()) ?>
              </div>
              <?php if($this->invitecountActive || $this->friendcountActive) { ?>
                <div class='sesinviter_topinviters_friends'>
                  <?php if($this->invitecountActive) { ?>
                    <span class="_des sesbasic_text_light"><?php echo $this->translate(array('<span>%s</span> invite', '<span>%s</span> invites', $result->topinviters),$this->locale()->toNumber($result->topinviters)) ?></span>
                  <?php } ?>
                  <?php if($this->friendcountActive) { ?>
                    <span class="_des sesbasic_text_light"><?php echo $this->translate(array('<span>%s</span> friend', '<span>%s</span> friends', $user->member_count),$this->locale()->toNumber($user->member_count)) ?></span>
                  <?php } ?>
                </div>
              <?php } ?>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
  </div>
<?php } else { ?>
<?php //height and width setting
 $params['photoheight'].'px;';
 $params['photowidth'].'px;';
?>
  <div class="generic_list_wrapper">
      <ul class="generic_list_widget">
        <?php foreach( $this->results as $user ): ?>
          <?php $user = Engine_Api::_()->getItem('user', $user->sender_id); ?>
          <li class="sesinviter_grid_item">
            <?php echo $this->htmlLink($user->getHref(), $this->itemPhoto($user, $user->getTitle()), array('class' => 'sesinviter_topinviters_thumb')) ?>
            <div class='sesinviter_topinviters_info'>
              <div class='sesinviter_topinviters_name'>
                <?php echo $this->htmlLink($user->getHref(), $user->getTitle()) ?>
              </div>
              <?php if($this->invitecountActive || $this->friendcountActive) { ?>
                <div class='sesinviter_topinviters_friends'>
                  <?php if($this->invitecountActive) { ?>
                    <span class="_des sesbasic_text_light"><?php echo $this->translate(array('<span>%s</span> invite', '<span>%s</span> invites', $result->topinviters),$this->locale()->toNumber($result->topinviters)) ?></span>
                  <?php } ?>
                  <?php if($this->friendcountActive) { ?>
                    <span class="_des sesbasic_text_light"><?php echo $this->translate(array('<span>%s</span> friend', '<span>%s</span> friends', $user->member_count),$this->locale()->toNumber($user->member_count)) ?></span>
                  <?php } ?>
                </div>
              <?php } ?>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
  </div>
<?php } ?>
