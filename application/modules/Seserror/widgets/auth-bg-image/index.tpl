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
<?php if($this->authpagebgimage): ?>
  <?php 
    $photoUrl = $this->baseUrl() . '/' . $this->authpagebgimage;
    ?>
  <?php else: ?>
	<?php 
    $photoUrl = $this->baseUrl() . '/application/modules/Seserror/externals/images/background-7.jpg';
	?>
  <?php endif; ?>
<style>
.layout_seserror_auth_bg_image{
	padding:0px !important; 
	margin:0px !important;
	border:none !important;
}
#global_footer{
	margin-top:0px !important;
}
#global_wrapper{
	background-image: url(<?php echo $photoUrl?>);
	background-size:cover;
}
</style>
