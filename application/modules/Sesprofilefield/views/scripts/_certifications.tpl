<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _certifications.tpl  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $viewer_id = $this->viewer_id; ?>
<?php foreach($this->certificationEntries as $certificationEntrie) { ?>
  <li id="sesprofilefield_certification_<?php echo $certificationEntrie->certification_id; ?>">
    <div class="certifiction_details_main">
      <div class="certifiction_details">
        <p class="certifiction_name"><?php echo $certificationEntrie->name; ?></p>
        <p class="date">
          <?php if($certificationEntrie->fromyear && $certificationEntrie->frommonth) { ?>
            <span><?php echo $certificationEntrie->frommonth; ?> <?php echo $certificationEntrie->fromyear; ?></span>
          <?php } ?>
          <?php if($certificationEntrie->toyear && $certificationEntrie->tomonth && empty($certificationEntrie->notexpire)) { ?>
            <span><?php echo " - "; ?><?php echo $certificationEntrie->tomonth; ?> <?php echo $certificationEntrie->toyear; ?>
            </span>
            <?php } else if(!empty($certificationEntrie->notexpire)) { ?>
            <span><?php echo $this->translate(" - Not Expire"); ?><span>
          <?php } ?>
          <?php if($certificationEntrie->license_number) { ?>
            <span>, <?php echo $this->translate('License '), $certificationEntrie->license_number; ?></span>
          <?php } ?>
        </p>
        <?php if($certificationEntrie->authority) { ?>
          <?php $authorityId = Engine_Api::_()->getDbTable('authorities', 'sesprofilefield')->getColumnValue(array('name' => $certificationEntrie->authority));
          if($authorityId) {
            $authority = Engine_Api::_()->getItem('sesprofilefield_authority', $authorityId);
            if($authority) {
              $photo = Engine_Api::_()->storage()->get($authority->photo_id, '');
              if($photo) {
                $photo = $photo->getPhotoUrl();
                $path = 'http://' . $_SERVER['HTTP_HOST'] . $photo;
              } else {
                $path = 'application/modules/Sesprofilefield/externals/images/authority.png';
              }
            }
          } else {
            $path = 'application/modules/Sesprofilefield/externals/images/authority.png';
          }
          
          ?>
          <p class="certifiction_autority">
            <img src="<?php echo $path; ?>" />
            <span><?php echo $certificationEntrie->authority; ?></span>
          </p>
        <?php } ?>
        <?php if($certificationEntrie->url) { ?>
          <?php $URL = (preg_match("#https?://#", $certificationEntrie->url) === 0) ? 'http://'.$certificationEntrie->url : $certificationEntrie->url; ?>
          <p class="certification_link"><a href="<?php echo $URL; ?>">See Certificate</a></p>
        <?php } ?>
      </div>
      <div class="field_option">
        <?php if($viewer_id == $certificationEntrie->owner_id) { ?>
      <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesprofilefield', 'controller' => 'index', 'action' => 'edit-certification', 'certification_id' => $certificationEntrie->certification_id), $this->translate(''), array('class' => 'sessmoothbox fa fa-pencil')); ?>
      <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesprofilefield', 'controller' => 'index', 'action' => 'delete-certification', 'certification_id' => $certificationEntrie->certification_id), $this->translate('	'), array('class' => 'sessmoothbox fa fa-trash')); ?>
    <?php } ?>
      </div>
    </div>
  </li>
<?php } ?>