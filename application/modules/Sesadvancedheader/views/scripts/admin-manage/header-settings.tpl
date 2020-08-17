<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvancedheader
 * @package    Sesadvancedheader
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: header-settings.tpl  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php
  $this->headScript()->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/jscolor/jscolor.js');
  $this->headScript()->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');	
?>
<style type="text/css">
	/*Color Scheme Form*/
.sesadvance_headers_settings_form .form-label{
	margin-bottom:5px;
}
.sesadvance_headers_settings_form #sesadvheader_design-label{
	border-bottom-width:1px;
	font-size:15px;
	padding-bottom:15px;
	text-align:center;
	width:100%;
}
.sesadvance_headers_settings_form #sesadvheader_design-wrapper .form-element{
	clear:both;
	text-align:center;
}
.sesadvance_headers_settings_form #sesadvheader_design-wrapper .form-element p.hint{
	max-width:100%;
}
.sesadvance_headers_settings_form #sesadvheader_design-wrapper .form-element li{
	box-sizing:border-box;
	float:left;
	margin:10px 10px 0 0;
	padding-bottom:30px;
	position:relative;
	width:275px;
}
.sesadvance_headers_settings_form #sesadvheader_design-wrapper .form-element li input{
	bottom:0;
	float:none;
	left:50%;
	margin-bottom:10px;
	position:absolute;
}
.sesadvance_headers_settings_form #sesadvheader_design-wrapper .form-element li label{
	cursor:pointer;
}
.sesadvance_headers_settings_form #sesadvheader_design-wrapper .form-element li img{
	width:100%;
}
.sesadvance_headers_settings_form #header_settings-wrapper,
.sesadvance_headers_settings_form #footer_settings-wrapper,
.sesadvance_headers_settings_form #body_settings-wrapper{
	border-bottom-width:1px;
}
.sesadvance_headers_settings_form #header_settings-wrapper .form-label,
.sesadvance_headers_settings_form #footer_settings-wrapper .form-label,
.sesadvance_headers_settings_form #body_settings-wrapper .form-label{
	font-size:15px;
	width:auto;
}
.sesadvance_headers_settings_form #header_settings_group > fieldset > div,
.sesadvance_headers_settings_form #footer_settings_group > fieldset > div,
.sesadvance_headers_settings_form #body_settings_group > fieldset > div{
  margin-right:3%;
	display:inline-block;
	width:30%;
}
.sesadvance_headers_settings_form #header_settings_group > fieldset > div > div,
.sesadvance_headers_settings_form #footer_settings_group > fieldset > div > div,
.sesadvance_headers_settings_form #body_settings_group > fieldset > div > div{
	width:100%;
}
.sesadvance_headers_settings_form #sesariana_footer_heading_color-wrapper{
	display:none !important;
}

</style>
<?php include APPLICATION_PATH .  '/application/modules/Sesadvancedheader/views/scripts/dismiss_message.tpl';?>
<div class='tabs'>
  <ul class="navigation">
    <li class="active">
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesadvancedheader', 'controller' => 'manage', 'action' => 'header-settings'), $this->translate('Header Settings')) ?>
    </li>
     <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesadvancedheader', 'controller' => 'settings', 'action' => 'manage-search'), $this->translate('Manage Module for Search')) ?>
    </li>
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesadvancedheader', 'controller' => 'manage', 'action' => 'index'), $this->translate('Main Menu Icons')) ?>
    </li>
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesadvancedheader', 'controller' => 'manage', 'action' => 'mini-menu-icons'), $this->translate('Mini Menu icons')) ?>
    </li>
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesadvancedheader', 'controller' => 'menu'), $this->translate('Mini Menu')) ?>
    </li>
  </ul>
</div>
<div class='clear sesbasic_admin_form sesadvance_headers_settings_form'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script type="application/javascript">
  function headerFixed(value){
    if(value == 1){
      document.getElementById('sesadvancedheader_fixed_height-wrapper').style.display = "block";
      document.getElementById('sesadvancedheader_fixed_margintop-wrapper').style.display = "block";
      
      document.getElementById('sesadvancedheader_fixed_limit-wrapper').style.display = "block";
      document.getElementById('sesadvancedheader_fixed_moretext-wrapper').style.display = "block";
      
      document.getElementById('sesadvancedheader_fixed_logo-wrapper').style.display = "block";
      document.getElementById('sesadvancedheader_header_opacity-wrapper').style.display = "block";
      document.getElementById('sesadvancedheader_header_bgcolor-wrapper').style.display = "block";
			document.getElementById('sesadvancedheader_header_textcolor-wrapper').style.display = "block";
    }else{
      document.getElementById('sesadvancedheader_fixed_height-wrapper').style.display = "none";
      document.getElementById('sesadvancedheader_fixed_margintop-wrapper').style.display = "none";
      document.getElementById('sesadvancedheader_fixed_limit-wrapper').style.display = "none";
      document.getElementById('sesadvancedheader_fixed_moretext-wrapper').style.display = "none";
      document.getElementById('sesadvancedheader_fixed_logo-wrapper').style.display = "none";
      document.getElementById('sesadvancedheader_header_opacity-wrapper').style.display = "none";
      document.getElementById('sesadvancedheader_header_bgcolor-wrapper').style.display = "none";
			document.getElementById('sesadvancedheader_header_textcolor-wrapper').style.display = "none";
    }  
  }
  
  function mainmenueffect(value) {
    
    if(value == 'slide') {
      document.getElementById('sesadvancedheader_slideeffect-wrapper').style.display = "block";
    } else {
      document.getElementById('sesadvancedheader_slideeffect-wrapper').style.display = "none";
    }
    
  }
  function ctaaction(value){
    $('sesadvancedheader_cta_url-wrapper').style.display = "none";
    $('sesadvancedheader_cta_text-wrapper').style.display = "none";
    if(value == 1){
      $('sesadvancedheader_cta_url-wrapper').style.display = "block";
      $('sesadvancedheader_cta_text-wrapper').style.display = "block";
    }
  }
  function showOptions(value) {
    $('sesadvancedheader_cta_enable-wrapper').style.display = "none";
    $('sesadvancedheader_cta_url-wrapper').style.display = "none";
    $('sesadvancedheader_cta_text-wrapper').style.display = "none";
    if(value == 1 || value == 5 || value == 7 || value == 12){
       $('sesadvancedheader_cta_enable-wrapper').style.display = "block";
       if($('sesadvancedheader_cta_enable').value == 1){
        $('sesadvancedheader_cta_url-wrapper').style.display = "block";
        $('sesadvancedheader_cta_text-wrapper').style.display = "block";
       }
    }
    if(value == 15) {
      $('sesadvancedheader_mainmenueffect-wrapper').style.display = 'block';
      $('sesadvancedheader_overlayeffect-wrapper').style.display = 'block';
      $('sesadvancedheader_pushereffect-wrapper').style.display = 'block';
      $('sesadvancedheader_mainmenualignment-wrapper').style.display = 'none';
      document.getElementById('sesadvancedheader_mainmenueffect-wrapper').style.display = "block";
      
      $('sesadvancedheader_menuinformation_img-wrapper').style.display = 'block';
      $('sesadvancedheader_menu_img-wrapper').style.display = 'block';
    } else {
      $('sesadvancedheader_mainmenueffect-wrapper').style.display = 'none';
      $('sesadvancedheader_overlayeffect-wrapper').style.display = 'none';
      $('sesadvancedheader_pushereffect-wrapper').style.display = 'none';
      $('sesadvancedheader_mainmenualignment-wrapper').style.display = 'block';
      document.getElementById('sesadvancedheader_mainmenueffect-wrapper').style.display = "none";
      
      $('sesadvancedheader_menuinformation_img-wrapper').style.display = 'none';
      $('sesadvancedheader_menu_img-wrapper').style.display = 'none';
    }
  }
  mainmenueffect("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesadvancedheader.mainmenueffect', 'overlay'); ?>");
  showOptions("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesadvheader.design', '10'); ?>");
  headerFixed(document.getElementById('sesadvancedheader_header_fixed').value);
</script>
