<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _skills.tpl  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $viewer_id = $this->viewer_id; ?>
<?php foreach($this->skills as $skills): ?>
  <li class="profile_skill_item" id="sesprofilefield_skill_<?php echo $skills->skill_id; ?>">
    <div class="profile_skill_item_endorse">
      <a href="javascript:void(0);"><span><?php echo $skills->skillname; ?></span><span id="sesprofilefield_skill_skillCount_<?php echo $skills->skill_id;?>">( <?php echo $skills->skill_count; ?> )</span></a>
    </div>
    <?php $endorsements = Engine_Api::_()->getDbtable('endorsements', 'sesprofilefield')->getEndorsmentPaginator($skills); ?>
    <?php if (count($endorsements)): ?>
      <div class="profile_skill_item_endorsers_container">
        <ul>
          <?php foreach ($endorsements as $endorsement): ?>
            <li>
              <?php $user = Engine_Api::_()->getItem( $endorsement->poster_type , $endorsement->poster_id ) ;
              echo $this->htmlLink($user->getHref(), $this->itemPhoto($user, 'thumb.icon'), array('title'=>$user->getTitle()))?>
            </li>
          <?php endforeach;?>
        </ul>
        <div></div>
      </div>  
      <div class="profile_skill_item_arrow">
        <a class="sessmoothbox fa fa-chevron-right" href="<?php echo $this->url(array('module' => 'sesprofilefield', 'controller' => 'index', 'action' => 'endorsement', 'resource_id' => $endorsement->resource_id), 'default', true); ?>"></a>
      </div>
    <?php endif;?>
    <?php if(!empty($viewer_id) && $viewer_id != $skills->user_id): ?>
      <div class="profile_skill_item_endorse_btn_container">
        <?php $hasEndorsment = Engine_Api::_()->sesprofilefield()->hasEndorsment('sesprofilefield_skill', $skills->skill_id); ?>
        <div class="profile_skill_item_endorse_btn" id="sesprofilefield_skill_unendorsement_<?php echo $skills->skill_id;?>" style ='display:<?php echo $hasEndorsment ?"inline-block":"none"?>' >
          <a href = "javascript:void(0);" class="floatL" onclick = "sesprofilefield_endorsment('<?php echo $skills->skill_id; ?>', 'sesprofilefield_skill');">
           <i class="fa fa-minus floatL"></i>
           <span><?php echo $this->translate("Remove Endorsement");?></span>
          </a>
        </div>
        <div class="profile_skill_item_endorse_btn" id="sesprofilefield_skill_mostEndorsement_<?php echo $skills->skill_id;?>" style ='display:<?php echo empty($hasEndorsment) ?"inline-block":"none"?>'>
          <a href = "javascript:void(0);" class="floatL" onclick = "sesprofilefield_endorsment('<?php echo $skills->skill_id; ?>', 'sesprofilefield_skill');">
            <i class="fa fa-plus floatL"></i>
            <span><?php echo $this->translate("Endorse");?></span>
          </a>
        </div>
        <input type ="hidden" id = "sesprofilefield_skill_endorsement_<?php echo $skills->skill_id;?>" value = '<?php echo $hasEndorsment ? $hasEndorsment[0]['endorsement_id'] :0; ?>' />
      </div>
    <?php endif; ?>
    <?php if(!empty($viewer_id) && $viewer_id == $skills->user_id): ?>
      <div class="field_option">        
        <a href="<?php echo $this->url(array('module' => 'sesprofilefield', 'controller' => 'index', 'action' => 'delete-skill', 'skill_id' => $skills->skill_id), 'default', true); ?>" class="sessmoothbox fa fa-trash">	</a>          
      </div>
    <?php endif; ?>
  </li>
<?php endforeach; ?>
