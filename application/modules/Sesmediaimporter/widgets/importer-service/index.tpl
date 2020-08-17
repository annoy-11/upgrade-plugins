<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmediaimporter
 * @package    Sesmediaimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2017-06-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
$allowService = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('sesmediaimporter',Engine_Api::_()->user()->getViewer(), 'allow_service');
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesmediaimporter/externals/styles/styles.css'); ?> 
<!--Facebook Page-->
<div class="sesmdimp_app_view_wrapper sesbasic_clearfix sesbasic_bxs">
	<div class="sesmdimp_app_view_main_tabs">
  	<h2><?php echo $this->translate("Social Media Importer") ?></h2>
    <ul id="sesmediaimportermainmenu">
    <?php if(!empty($_SESSION['sesmediaimporter_fb_enable'])){ ?>
    	<li data-type="facebook" class="sesmdimp_tab_facebook <?php echo $this->type == 'facebook'  ? 'active' : ''; ?>"><a href="<?php echo $this->url(array('action'=>'service','type'=>'facebook','direct'=>1),'sesmediaimporter_general',true); ?>"><i></i><span><?php echo $this->translate('Facebook'); ?></span></a></li>
     <?php } ?>
     
     <?php if(!empty($_SESSION['sesmediaimporter_int_enable'])){ ?>
      <li data-type="instagram"  class="sesmdimp_tab_instagram <?php echo $this->type == 'instagram'  ? 'active' : ''; ?>"><a href="<?php echo $this->url(array('action'=>'service','type'=>'instagram','direct'=>1),'sesmediaimporter_general',true); ?>"><i></i><span><?php echo $this->translate('Intagram'); ?></span></a></li>
     <?php } ?>
     <?php if(!empty($_SESSION['sesmediaimporter_flr_enable'])){ ?>
      <li data-type="flickr"  class="sesmdimp_tab_flickr <?php echo $this->type == 'flickr'  ? 'active' : ''; ?>"><a href="<?php echo $this->url(array('action'=>'service','type'=>'flickr','direct'=>1),'sesmediaimporter_general',true); ?>"><i></i><span><?php echo $this->translate('Flickr'); ?></span></a></li>
     <?php } ?>
     <?php if(!empty($_SESSION['sesmediaimporter_gll_enable'])){ ?>
      <li data-type="google"  class="sesmdimp_tab_google <?php echo $this->type == 'google'  ? 'active' : ''; ?>"><a href="<?php echo $this->url(array('action'=>'service','type'=>'google','direct'=>1),'sesmediaimporter_general',true); ?>"><i></i><span><?php echo $this->translate('Google'); ?></span></a></li>
     <?php } ?>
     <?php if(!empty($_SESSION['sesmediaimporter_px_enable'])){ ?>
      <li data-type="500px"  class="sesmdimp_tab_500px <?php echo $this->type == 'px500'  ? 'active' : ''; ?>"><a href="<?php echo $this->url(array('action'=>'service','type'=>'px500','direct'=>1),'sesmediaimporter_general',true); ?>"><i></i><span><?php echo $this->translate('500px'); ?></span></a></li>
     <?php } ?>
     <?php if(!empty($_SESSION['sesmediaimporter_zip_enable'])){ ?>
      <li data-type="zip"  class="sesmdimp_tab_zip <?php echo $this->type == 'zip'  ? 'active' : ''; ?>"><a href="<?php echo $this->url(array('action'=>'service','type'=>'zip','direct'=>1),'sesmediaimporter_general',true); ?>"><i></i><span><?php echo $this->translate('Zip Upload'); ?></span></a></li>
     <?php } ?>
    </ul>
  </div>
  <?php if($this->type == 'facebook'){ ?>
  <?php echo $this->partial('_facebook.tpl','sesmediaimporter',array()); ?>
  <?php }else if($this->type == 'instagram'){  ?>
    <?php echo $this->partial('_instagram.tpl','sesmediaimporter',array()); ?>
  <?php }else if($this->type == 'flickr'){  ?>
    <?php echo $this->partial('_flickr.tpl','sesmediaimporter',array()); ?>
  <?php }else if($this->type == 'google'){  ?>
    <?php echo $this->partial('_google.tpl','sesmediaimporter',array()); ?>
  <?php }else if($this->type == 'px500'){  ?>
    <?php echo $this->partial('_500px.tpl','sesmediaimporter',array()); ?>
  <?php }else if($this->type == 'zip'){  ?>
    <?php echo $this->partial('_zip.tpl','sesmediaimporter',array()); ?>
  <?php } ?>
</div>



