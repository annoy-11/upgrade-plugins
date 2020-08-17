<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroupteam
 * @package    Sesgroupteam
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _teams.tpl  2018-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php foreach($this->paginator as $item): ?>
  <?php if($item->type == 'sitemember') { ?>
    <?php $user = Engine_Api::_()->getItem('user', $item->user_id); ?>
  <?php } ?>
  <div class="sesgroupteam_dashboard_member sesbasic_clearfix" id="sesgroupteam_team_<?php echo $item->team_id; ?>">
    <div>
      <?php if($item->type == 'sitemember'): ?>
        <a href="<?php echo $item->getHref(); ?>"><?php echo $this->itemPhoto($user, 'thumb.profile', $user->getTitle()); ?></a>
      <?php else: ?>
        <a href="<?php echo $item->getHref(); ?>"><?php echo $this->itemPhoto($item, 'thumb.profile', $item->getTitle()); ?></a>
      <?php endif; ?>
    </div>
    <div class="_cont">
      <div class="_title sesbasic_clearfix">
        <a href="<?php echo $item->getHref(); ?>"><?php echo $item->name;?></a>
        <span>
          <a href="<?php echo $this->url(array('group_id' => $item->group_id,'team_id' => $item->team_id,'type' => $item->type, 'action'=>'edit'),'sesgroupteam_dashboard',true);?>" title='<?php echo $this->translate("Edit");?>' class="sessmoothbox fa fa-pencil"></a>
          <a href="<?php echo $this->url(array('group_id' => $item->group_id,'team_id' => $item->team_id,'action'=>'delete'),'sesgroupteam_dashboard',true);?>" title='<?php echo $this->translate("Delete");?>' class="sessmoothbox fa fa-trash"></a>
        </span>
      </div>
      <div class="_info">
        <?php if($item->description) { ?>
          <div class="_infof">
            <span><?php echo $this->translate("Description:");?></span>
            <span><?php echo $item->description;?></span>
          </div>
        <?php } ?>
        <?php if($item->designation) { ?>
          <div class="_infof">
            <span><?php echo $this->translate("Designation:");?></span>
            <span><?php echo $item->designation;?></span>
          </div>
        <?php } ?>
        <?php if($item->email) { ?>
          <div class="_infof">
            <span><?php echo $this->translate("Email:");?></span>
            <span><?php echo $item->email;?></span>
          </div>
        <?php } ?>
        <?php if($item->location) { ?>
          <div class="_infof">
            <span><?php echo $this->translate("Location");?></span>
            <span><?php echo $item->location;?></span>
          </div>
        <?php } ?>
        <?php if($item->phone) { ?>
          <div class="_infof">
            <span><?php echo $this->translate("Phone:");?></span>
            <span><?php echo $item->phone;?></span>
          </div>
        <?php } ?>
        <?php if($item->website) { ?>
          <div class="_infof">
            <span><?php echo $this->translate("Website:");?></span>
            <span><?php echo $item->website;?></span>
          </div>
        <?php } ?>
        <?php if($item->skype) { ?>
          <div class="_infof">
            <span><?php echo $this->translate("Skype:");?></span>
            <span><?php echo $item->skype;?></span>
          </div>
        <?php } ?>
        <?php if($item->facebook) { ?>
          <div class="_infof">
            <span><?php echo $this->translate("Facebook:");?></span>
            <span><?php echo $item->facebook;?></span>
          </div>
        <?php } ?>
        <?php if($item->twitter) { ?>
          <div class="_infof">
            <span><?php echo $this->translate("Twitter:");?></span>
            <span><?php echo $item->twitter;?></span>
          </div>
        <?php } ?>
        <?php if($item->linkdin) { ?>
          <div class="_infof">
            <span><?php echo $this->translate("Linkdin:");?></span>
            <span><?php echo $item->linkdin;?></span>
          </div>
        <?php } ?>
        <?php if($item->googleplus) { ?>
          <div class="_infof">
            <span><?php echo $this->translate("Google Plus:");?></span>
            <span><?php echo $item->googleplus;?></span>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
<?php endforeach;?>
