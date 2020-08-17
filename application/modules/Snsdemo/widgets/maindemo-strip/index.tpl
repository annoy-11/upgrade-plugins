<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestour
 * @package    Sestour
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2017-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $allParams = $this->allParams; ?>
<?php $this->headLink()->appendStylesheet($staticBaseUrl . 'application/modules/Snsdemo/externals/styles/styles.css'); ?>
<div class="snsdemo_header_strip">
	<section>
  	<div class="snsdemo_header_strip_logo">
    	<a href="https://socialnetworking.solutions" target="_blank"><img src="application/modules/Snsdemo/externals/images/sns-icon.png" alt="" /></a>
    </div>
    <div class="snsdemo_header_demos_list_wrap snsdemo_header_dropdown_wrap" id="snsdemo_header_demos_list_wrap">
     	<a href="javascript:void(0);" id="demo_list_toggle"><?php echo $this->title; ?> <i class="fa"></i></a>
  		<div class="snsdemo_header_demos_list snsdemo_header_dropdown">
      	<ul>
          <?php foreach($this->themes as $theme) { ?>
            <li>
              <a href="<?php echo $theme->demolink; ?>" target="_blank"><?php echo $theme->theme_name; ?></a>
            </li>
          <?php } ?>
        </ul>
      </div>
    </div>
    <div class="snsdemo_header_strip_main"> 
      <?php if($allParams['button1text']) { ?>
      <div>
        <a href="<?php echo $allParams['button1link']; ?>" class="btn_main" target="_blank"><i class="fa fa-shopping-cart"></i><span><?php echo $allParams['button1text']; ?> - <b>$<?php echo $allParams['button1price']; ?></b></span></a>
      </div>
      <?php } ?>
      <?php if($allParams['button2text']) { ?>
        <div>
          <a href="<?php echo $allParams['button2link']; ?>" class="btn_main btn_sec" target="_blank"><i class="fa fa-shopping-cart"></i><span><?php echo $allParams['button2text']; ?> - <b>$<?php echo $allParams['button2price']; ?></b></span></a>
        </div>
      <?php } ?>
      <div class="snsdemo_header_strip_contact">
      	<a href="mailto:sales@socialnetworking.solutions"><i class="fa fa-envelope"></i></a>
        <a href="skype:vaibhav.sesolutions?chat"><i class="fa fa-skype"></i></a>
        <a href="tel:+12132677939"><i class="fa fa-phone-square"></i></a>
        <a href="https://wa.me/919950682999" target="_blank"><i class="fa fa-whatsapp"></i></a>
      </div>
    </div>
		<div class="snsdemo_header_services_list_wrap snsdemo_header_dropdown_wrap" id="snsdemo_header_demos_list_wrap">
     	<a href="javascript:void(0);" id="services_list_toggle">Popular Services <i class="fa"></i></a>
  		<div class="snsdemo_header_services_list snsdemo_header_dropdown">
      	<ul>
          <?php foreach($this->services as $service) { ?>
            <li>
              <a href="<?php echo $service->servicelink; ?>" target="_blank"><?php echo $service->service_name; ?></a>
            </li>
          <?php } ?>
        </ul>
      </div>
    </div>
    <div class="snsdemo_header_strip_btn">
    	<a href="javascript:void();" id="snsdemo_header_strip_btn"><i class="fa"></i></a>
    </div>
  </section>
</div>

<script type="text/javascript">
sesJqueryObject(document).on('click','#demo_list_toggle',function(){
	if(sesJqueryObject (this).hasClass('selected')){
	 sesJqueryObject (this).removeClass('selected');
	 sesJqueryObject ('.snsdemo_header_demos_list_wrap').removeClass('open_list');
	}else{
	 sesJqueryObject (this).addClass('selected');
	 sesJqueryObject ('.snsdemo_header_demos_list_wrap').addClass('open_list');
	}
});

sesJqueryObject(document).on('click','#services_list_toggle',function(){
	if(sesJqueryObject (this).hasClass('selected')){
	 sesJqueryObject (this).removeClass('selected');
	 sesJqueryObject ('.snsdemo_header_services_list_wrap').removeClass('open_list');
	}else{
	 sesJqueryObject (this).addClass('selected');
	 sesJqueryObject ('.snsdemo_header_services_list_wrap').addClass('open_list');
	}
});

sesJqueryObject(document).on('click','#snsdemo_header_strip_btn',function(){
	if(sesJqueryObject (this).hasClass('selected')){
	 sesJqueryObject (this).removeClass('selected');
	 sesJqueryObject ('html').removeClass('hide_strip');
	}else{
	 sesJqueryObject (this).addClass('selected');
	 sesJqueryObject ('html').addClass('hide_strip');
	}
});
</script>
<script>
	sesJqueryObject(document).ready(function(e){
		var height = sesJqueryObject('.snsdemo_header_strip').height();
		sesJqueryObject('html').css('padding-top', height+"px");
	});
</script>
