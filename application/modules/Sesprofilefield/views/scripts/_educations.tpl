<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _educations.tpl  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $viewer_id = $this->viewer_id; ?>
<?php foreach($this->educationEntries as $educationEntrie) { ?>
  <li id="sesprofilefield_education_<?php echo $educationEntrie->education_id; ?>" class="sesbasic_clearfix">
    <?php $schoolId = Engine_Api::_()->getDbTable('schools', 'sesprofilefield')->getColumnValue(array('name' => $educationEntrie->school));
    if($schoolId) {
      $school = Engine_Api::_()->getItem('sesprofilefield_school', $schoolId);
      if($school) {
        $photo = Engine_Api::_()->storage()->get($school->photo_id, '');
        if($photo) {
          $photo = $photo->getPhotoUrl();
          $path = 'http://' . $_SERVER['HTTP_HOST'] . $photo;
        } else {
          $path = 'application/modules/Sesprofilefield/externals/images/school.png';
        }
      }
    } else {
      $path = 'application/modules/Sesprofilefield/externals/images/school.png';
    }
    
    ?>
    <div class="education_details_logo">
      <img src="<?php echo $path; ?>" />
    </div>
    <div class="education_details_main">
      <div class="education_details">
        <p class="school"><?php echo $educationEntrie->school; ?></p>	
      <p class="degree">
        <?php if($educationEntrie->degree) { ?>
        <span><?php echo $educationEntrie->degree; ?>,</span>
        <?php } ?>
        <?php if($educationEntrie->field_of_study) { ?>
          <span><?php echo $educationEntrie->field_of_study; ?>,</span>
        <?php } ?>
        <?php if($educationEntrie->grade) { ?>
          <span><?php echo $educationEntrie->grade; ?></span>
        <?php } ?>
      </p>
      <p class="from_years sesbasic_text_light">
      	<?php if($educationEntrie->fromyear) { ?>
          <?php echo $educationEntrie->fromyear; ?>
        <?php } ?>
        <?php if($educationEntrie->fromyear && $educationEntrie->toyear) { ?>
          <?php echo " - "; ?>
        <?php } ?>
        <?php if($educationEntrie->toyear) { ?>
          <?php echo $educationEntrie->toyear; ?>
        <?php } ?>
      </p>
      <?php if($educationEntrie->activities) { ?>
        <p class="education_activities">Activities and Societies: <?php echo nl2br($educationEntrie->activities); ?></p>
      <?php } ?>        
      <?php if($educationEntrie->description) { ?>
        <p class="education_des sesbasic_text_light"><?php echo nl2br($educationEntrie->description); ?></p>
      <?php } ?>
      <div class="_gallery sesbasic_clearfix">
        <?php for($i=1;$i<=3;$i++) { ?>
          <?php $uplaod = 'upload_'.$i; ?>
          <?php if($educationEntrie->$uplaod) { ?>
            <?php $storage = Engine_Api::_()->getItem('storage_file',$educationEntrie->$uplaod); ?>
            <div class="_galleryitem">
              <a target="_blank" href="<?php echo $storage->map(); ?>">
                <?php if($storage->extension == 'PDF') { ?>
                  <span class="bg_item_photo" style="background-image:url(application/modules/Sesprofilefield/externals/images/pdf-icon.png);"></span>
                <?php } else { ?>
                  <span class="bg_item_photo" style="background-image:url(application/modules/Sesprofilefield/externals/images/doc.png);"></span>
                <?php } ?>
              </a>
            </div>
          <?php } ?>
        <?php } ?>
      </div>
      <div class="field_option">
        <?php if($viewer_id == $educationEntrie->owner_id) { ?>
          <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesprofilefield', 'controller' => 'index', 'action' => 'edit-education', 'education_id' => $educationEntrie->education_id), $this->translate(''), array('class' => 'sessmoothbox fa fa-pencil')); ?>
          <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesprofilefield', 'controller' => 'index', 'action' => 'delete-education', 'education_id' => $educationEntrie->education_id), $this->translate(''), array('class' => 'sessmoothbox fa fa-trash')); ?>
        <?php } ?>
      </div>
    </div>
  </li>
<?php } ?>