<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _records.tpl  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $viewer_id = $this->viewer_id; ?>
<?php $athletic = json_decode($this->specialties->athletic_specialties); ?>
<?php foreach($athletic as $athlet) { ?>
	<li class="sesbasic_clearfix">
  <?php $getSpecialty = Engine_Api::_()->getDbTable('adminspecialties', 'sesprofilefield')->getColumnName(array('adminspecialty_id' => $athlet, 'column_name' => 'name'));  ?>
  	<div class="records_head"><h4><?php echo $getSpecialty; ?></h4></div>
		<div class="records_cont">
      <?php $subSpecialties = Engine_Api::_()->getDbTable('adminspecialties', 'sesprofilefield')->getModuleSubspecialty(array('adminspecialty_id' => $athlet, 'column_name' => array('name', 'adminspecialty_id')));  ?>
      <?php foreach($subSpecialties as $subSpecialty) { ?>
        <div class="records_cont_head"><?php echo $subSpecialty->name; ?></div>
        <div class="records_cont_entries sesbasic_clearfix">
          <?php $subsubSpecialties = Engine_Api::_()->getDbTable('adminspecialties', 'sesprofilefield')->getModuleSubsubspecialty(array('adminspecialty_id' => $subSpecialty->adminspecialty_id, 'column_name' => array('name', 'adminspecialty_id', 'type')));  ?>
          
          <?php foreach($subsubSpecialties as $subsubSpecialty) {   ?>
            <div class="records_cont_entries_item">
              <span><?php echo $subsubSpecialty; ?></span>
              <?php 
                $record = Engine_Api::_()->getDbtable('records', 'sesprofilefield')->getViewerRecords(array('user_id' => $this->viewer_id, 'adminspecialty_id' => $athlet, 'subid' => $subSpecialty->adminspecialty_id, 'subsubid' => $subsubSpecialty->adminspecialty_id, 'type' => $subsubSpecialty->type));
                
                $minutes = $seconds = $reps = $lbs = $lbskg = 00;
                if(isset($record->minutes) && !empty($record->minutes)) 
                  $minutes = $record->minutes;
                else
                  $minutes = '00';
                if(isset($record->seconds) && !empty($record->seconds)) 
                  $seconds = $record->seconds;
                else 
                  $seconds = '00';
                if(isset($record->reps)) 
                  $reps = $record->reps;
                if(isset($record->lbs)) 
                  $lbs = $record->lbs;
                if(isset($record->lbskg)) 
                  $lbskg = $record->lbskg;
              ?>
              <span id="sesprofilefield_record_<?php echo $subsubSpecialty->adminspecialty_id; ?>">
                <?php if(in_array('lbskg', json_decode($subsubSpecialty->type))) { ?>
                  <?php echo $lbskg . ' LBS or KG'; ?>
                <?php } else if(in_array('lbs', json_decode($subsubSpecialty->type))) { ?>
                  <?php echo $lbs . ' LBS'; ?>
                <?php } else if(in_array('reps', json_decode($subsubSpecialty->type))) { ?>
                  <?php echo $reps . ' REPS'; ?>
                <?php } else if(in_array('minutes', json_decode($subsubSpecialty->type)) || in_array('seconds', json_decode($subsubSpecialty->type))) {  ?>
                  <?php echo $minutes . ' minutes ' . $seconds . ' seconds'; ?>
                <?php } ?>
              </span>
            </div>    
          <?php } ?>
        </div>  
      <?php } ?>
  	</div>
  </li>
<?php } ?>