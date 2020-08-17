<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _work_experience.tpl  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $viewer_id = $this->viewer_id; ?>
<?php foreach($this->experienceEntries as $experience) { ?>
  <li id="sesprofilefield_experience_<?php echo $experience->experience_id; ?>" class="sesbasic_clearfix">
    <?php $companies = Engine_Api::_()->getDbTable('companies', 'sesprofilefield')->getColumnValue(array('name' => $experience->company));
    if($companies) {
      $company = Engine_Api::_()->getItem('sesprofilefield_company', $companies);
      if($company) {
        $photo = Engine_Api::_()->storage()->get($company->photo_id, '');
        if($photo) {
          $photo = $photo->getPhotoUrl();
          $path = 'http://' . $_SERVER['HTTP_HOST'] . $photo;
        } else {
          $path = 'application/modules/Sesprofilefield/externals/images/company.png';
        }
      }
    } else {
      $path = 'application/modules/Sesprofilefield/externals/images/company.png';
    }
    
    ?>
    <div class="experience_details_logo">
      <img src="<?php echo $path; ?>" />
    </div>
    <div class="experience_details_main">
      <div class="experience_details">
        <p class="experience_title">
          <?php echo $experience->title; ?>
        </p>
        <p class="experience_company">
          <?php if($experience->company) { ?>
          	<span><?php echo $experience->company; ?></span>
          <?php } ?>
        </p>
        <p class="experience_time sesbasic_text_light">
          <?php if($experience->fromyear) { ?>
            <?php echo $experience->fromyear; ?>
          <?php } ?>
          <?php if($experience->fromyear && $experience->toyear) { ?>
            <?php echo " - "; ?>
          <?php } ?>
          <?php if($experience->toyear) { ?>
            <?php echo $experience->toyear; ?>
          <?php } ?>
        </p>
        <p class="experience_location sesbasic_text_light">
         <?php if($experience->location) { ?>
            <span><?php echo $experience->location; ?></span>
          <?php } ?>
        </p>
        
        <?php if($experience->description) { ?>
          <p class="experience_des"><?php echo nl2br($experience->description); ?></p>
        <?php } ?>
        <?php if($experience->photo_id) { ?>
        <?php 
          $storage = Engine_Api::_()->getItem('storage_file',$experience->photo_id);     
        ?>
        <div class="_gallery sesbasic_clearfix">
        	<div class="_galleryitem">
            <a target="_blank" href="<?php echo $storage->map(); ?>">
              <?php if(in_array($storage->extension, array('PDF', 'pdf'))) { ?>
                <span class="bg_item_photo" style="background-image:url(application/modules/Sesprofilefield/externals/images/pdf-icon.png);"></span>
              <?php } else { ?>
                <span class="bg_item_photo" style="background-image:url(application/modules/Sesprofilefield/externals/images/doc.png);"></span>
              <?php } ?>
            </a>
        	</div>
        </div>
        <?php } ?>
      </div>
      <div class="field_option">
        <?php if($viewer_id == $experience->owner_id) { ?>
          <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesprofilefield', 'controller' => 'index', 'action' => 'edit-experience', 'experience_id' => $experience->experience_id), $this->translate(''), array('class' => 'sessmoothbox fa fa-pencil')); ?>
          <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesprofilefield', 'controller' => 'index', 'action' => 'delete-experience', 'experience_id' => $experience->experience_id), $this->translate(''), array('class' => 'sessmoothbox fa fa-trash')); ?>
        <?php } ?>
      </div>
    </div>
  </li>
<?php } ?>