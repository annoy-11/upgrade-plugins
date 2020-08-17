<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _awards.tpl  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $viewer_id = $this->viewer_id; ?>
<?php foreach($this->awardEntries as $awardEntrie) { ?>
  <li id="sesprofilefield_award_<?php echo $awardEntrie->award_id; ?>">
    <div class="awards_details_main">
      <div class="awards_details">
        <p class="awards_name"><?php echo $awardEntrie->title; ?></p>
        <?php if($awardEntrie->fromyear && $awardEntrie->frommonth) { ?>
          <p class="date sesbasic_text_light">
            <span><?php echo $awardEntrie->fromyear; ?><?php echo " - "; ?><?php echo $awardEntrie->frommonth; ?></span>
            <?php if($awardEntrie->issuer) { ?><span>, <?php echo $awardEntrie->issuer; ?></span><?php } ?>
          </p>
        <?php } ?>
        
        <?php if($awardEntrie->description) { ?>
          <p class="awards_des"><?php echo nl2br($awardEntrie->description); ?></p>
        <?php } ?>
      </div>
      <div class="field_option">
        <?php if($viewer_id == $awardEntrie->owner_id) { ?>
          <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesprofilefield', 'controller' => 'index', 'action' => 'edit-award', 'award_id' => $awardEntrie->award_id), $this->translate(''), array('class' => 'sessmoothbox fa fa-pencil')); ?>
          <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesprofilefield', 'controller' => 'index', 'action' => 'delete-award', 'award_id' => $awardEntrie->award_id), $this->translate('	'), array('class' => 'sessmoothbox fa fa-trash')); ?>
        <?php } ?>
      </div>
    </div>
  </li>
<?php } ?>