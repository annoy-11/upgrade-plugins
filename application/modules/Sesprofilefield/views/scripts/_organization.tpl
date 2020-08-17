<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _organization.tpl  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $viewer_id = $this->viewer_id; ?>
<?php foreach($this->organizationEntries as $organization) { ?>
  <li id="sesprofilefield_organization_<?php echo $organization->organization_id; ?>" class="sesbasic_clearfix">
    <div class="organization_details_main">
      <div class="organization_details">
        <p class="organization_title">
          <?php echo $organization->title; ?>
        </p>
        <p class="organization_company">
          <?php if($organization->position) { ?>
          	<span><?php echo $organization->position; ?>,</span>
          <?php } ?>
          <?php if($organization->associate_with) { ?>
            <span><?php echo $organization->associate_with; ?></span>
          <?php } ?>
        </p>
        <p class="organization_time sesbasic_text_light">
          <?php if($organization->frommonth) { ?>
            <?php echo $organization->frommonth; ?>
          <?php } ?><?php echo ", "; ?>
          <?php if($organization->fromyear) { ?>
            <?php echo $organization->fromyear; ?>
          <?php } ?>
          <?php if($organization->fromyear && $organization->toyear) { ?>
            <?php echo " - "; ?>
          <?php } ?>
          <?php if($organization->tomonth) { ?>
            <?php echo $organization->tomonth; ?>
          <?php } ?><?php echo ", "; ?>
          <?php if($organization->toyear) { ?>
            <?php echo $organization->toyear; ?>
          <?php } ?>
        </p>
        <?php if($organization->description) { ?>
          <p class="organization_des"><?php echo nl2br($organization->description); ?></p>
        <?php } ?>
      </div>
      <div class="field_option">
        <?php if($viewer_id == $organization->owner_id) { ?>
          <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesprofilefield', 'controller' => 'index', 'action' => 'edit-organization', 'organization_id' => $organization->organization_id), $this->translate(''), array('class' => 'sessmoothbox fa fa-pencil')); ?>
          <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesprofilefield', 'controller' => 'index', 'action' => 'delete-organization', 'organization_id' => $organization->organization_id), $this->translate(''), array('class' => 'sessmoothbox fa fa-trash')); ?>
        <?php } ?>
      </div>
    </div>
  </li>
<?php } ?>
