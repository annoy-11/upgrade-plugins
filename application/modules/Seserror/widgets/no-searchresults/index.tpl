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
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700,700i" rel="stylesheet">
<?php
$error_id = $this->ses_error_results->error_id;
$default = $this->ses_error_results->default;
$params = unserialize($this->ses_error_results->params);
?>
<?php if($default): ?>
<?php
if(!empty($params['photo_id'])):
$photo_id = $params['photo_id'];
$img_path = Engine_Api::_()->storage()->get($photo_id, '')->getPhotoUrl();
$path = 'http://' . $_SERVER['HTTP_HOST'] . $img_path;
?>
<img src="<?php echo $path ?>" />
<?php else: ?>
<?php $path = $this->layout()->staticBaseUrl . 'application/modules/Seserror/externals/images/error.jpg'; ?>
<img src="<?php echo $path ?>" />
<?php endif; ?>

<?php if(!empty($params['text1'])): ?>
<span style='color:<?php echo $params["text1_color"] ?>;font-size:<?php echo $params["text1_font"] ?>px;'><?php echo $params['text1']; ?></span><br />
<?php endif; ?>

<?php if(!empty($params['text2'])): ?>
<span style='color:<?php echo $params["text2_color"] ?>;font-size:<?php echo $params["text2_font"] ?>px;'><?php echo $params['text2']; ?></span><br />
<?php endif; ?>

<?php if(!empty($params['text3'])): ?>
<span style='color:<?php echo $params["text3_color"] ?>;font-size:<?php echo $params["text3_font"] ?>px;'><?php echo $params['text3']; ?></span><br />
<?php endif; ?>

<?php if(!empty($params['button1_url']) && !empty($params['button1_text'])): ?>
<div>
  <a href="<?php echo $params['button1_url'] ?>"  target='_blank'><button style="background-color:<?php echo $params['button1color'] ?>;border-color:<?php echo $params['button1border_color'] ?>"><span style="color:<?php echo $params['button1text_color'] ?>"><?php echo $params['button1_text'] ?></button></a>
</div>
<?php endif; ?>

<?php if(!empty($params['button2_url']) && !empty($params['button2_text'])): ?>
<div>
  <a href="<?php echo $params['button2_url'] ?>"  target='_blank'><button style="background-color:<?php echo $params['button2color'] ?>;border-color:<?php echo $params['button2border_color'] ?>"><span style="color:<?php echo $params['button2text_color'] ?>"><?php echo $params['button2_text'] ?></button></a>
</div>
<?php endif; ?>

<div>
  <?php if($params['search_width']): ?>
  <input placeholder="Search" type="text" style="width:<?php echo $params['search_width'] ?>px;" />
  <?php endif; ?>
  <?php if($params['searchbutton_text']): ?>
  <button style="background-color:<?php echo $params['searchbuttoncolor'] ?>;border-color:<?php echo $params['searchbuttonborder_color'] ?>"><span style="color:<?php echo $params['searchbuttontext_color'] ?>"><?php echo $params['searchbutton_text'] ?></button>
  <?php endif; ?>
</div>
<?php endif; ?>