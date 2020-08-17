<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessportz
 * @package    Sessportz
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-04-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $settings = Engine_Api::_()->getApi('settings', 'core'); 
$email = $settings->getSetting('sessportz.he.email', 'info@abc.com');
$phone = $settings->getSetting('sessportz.he.phone', '+91-1234567890');
$ads = $settings->getSetting('sessportz_he_ads', '');

?>
<?php $responseiveLayoutCheck = Engine_Api::_()->sessportz()->getContantValueXML('sessportz_responsive_layout'); ?>
<div class="sessportz_header">
 <div class="header_inner">
  <div class="header_top clearfix">
    <?php if($email || $phone) { ?>
      <div class="header_info">
        <ul> 
          <?php if($phone) { ?>
            <li><a href="#"><i class="fa fa-phone" aria-hidden="true"></i><?php echo $phone ?></a></li>
          <?php } ?>
          <?php if($email) { ?>
            <li><a href="mailto:<?php echo $email ?>"><i class="fa fa-envelope-o" aria-hidden="true"></i><?php echo $email; ?></a></li>
          <?php } ?>
        </ul>
      </div>
    <?php } ?>
    <?php if($this->show_mini):?>
    <div class="header_mini_menu">
      <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvminimenu')) { ?>
        <?php echo $this->content()->renderWidget("sesadvminimenu.menu-mini"); ?>
      <?php } else { ?>
        <?php echo $this->content()->renderWidget("sessportz.menu-mini"); ?>
      <?php } ?>
    </div>
    <?php endif; ?>
    </div>
    <div class="header_middle">
       <div class="header_middle_inner">
          <?php if($this->show_logo):?>
            <div class="header_logo" >
              <?php echo $this->content()->renderWidget('sessportz.menu-logo'); ?>
            </div>
          <?php endif; ?>
          <?php if($ads) { ?>
            <div class="header_google_ads">
                <img src="<?php echo $ads ?>" />
            </div>
           <?php } ?>
           <?php if($this->show_search):?>
           <div class="header_search">
              <?php echo $this->content()->renderWidget("sessportz.search"); ?>
           </div>
           <?php endif; ?>
       </div>
    </div>
    <div class="header_main">
    <div class="header_main_inner">
     <?php if($this->show_menu):?>
    <div class="sessportz_header_main_menu">
      <?php echo $this->content()->renderWidget("sessportz.menu-main"); ?>
    </div>
  <?php endif;?>
    <?php if($responseiveLayoutCheck == '1' && $this->show_menu): ?>
      <div class="sessportz_mobile_menu">
        <?php include 'mobile-menu.tpl'; ?>
      </div>
    <?php endif; ?>
  </div>
</div>
</div>
</div>
<script>
	jqueryObjectOfSes(document).ready(function(e){
	var height =  jqueryObjectOfSes('.seshtmlbackground_slideshow_wrapper').height();
		if($('layout_right')) {
	    $('layout_right').setStyle('margin-top', height+"px");
	  }
	});
</script>
<script>
  sesJqueryObject(window).scroll(function() {    
      var scroll = sesJqueryObject(window).scrollTop();

      if (scroll >= 100) {
          sesJqueryObject("#global_header").addClass("sticky");
      } else {
          sesJqueryObject("#global_header").removeClass("sticky");
      }
  });
</script>
