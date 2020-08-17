<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seserror
 * @package    Seserror
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2017-05-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php if ($this->getResults) : ?>
  <?php
  $photo_id = $this->getResults[0]['photo_id'];
  $img_path = Engine_Api::_()->storage()->get($photo_id, '')->getPhotoUrl();
  $path = 'http://' . $_SERVER['HTTP_HOST'] . $img_path;
  ?>
  <img src="<?php echo $path ?>" />
  <?php if ($this->getResults[0]['link1'] && $this->getResults[0]['link1_text']) : ?>
    <a href="<?php echo $this->getResults[0]['link1']; ?>" ><?php echo $this->getResults[0]['link1_text'] ?>	</a>
  <?php endif; ?>
  <?php if ($this->getResults[0]['link2'] && $this->getResults[0]['link2_text']) : ?>
    <a href="<?php echo $this->getResults[0]['link2']; ?>" ><?php echo $this->getResults[0]['link2_text'] ?>	</a>
  <?php endif; ?>
  <?php if ($this->getResults[0]['link3'] && $this->getResults[0]['link3_text']) : ?>
    <a href="<?php echo $this->getResults[0]['link3']; ?>" ><?php echo $this->getResults[0]['link1_text'] ?>	</a>
  <?php endif; ?>
<?php else: ?>
  <?php $path = $this->layout()->staticBaseUrl . 'application/modules/Seserror/externals/images/error.jpg'; ?>
  <img src="<?php echo $path ?>" />
<?php endif; ?>
