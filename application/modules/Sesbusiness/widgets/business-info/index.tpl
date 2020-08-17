<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.enable.location', 1)):?>
  <?php $headScript = new Zend_View_Helper_HeadScript();?>
  <?php $headScript->appendFile('https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=' . Engine_Api::_()->getApi('settings', 'core')->getSetting('ses.mapApiKey', ''));?>
<?php endif;?>
<?php $viewerId = $this->viewer()->getIdentity();?>
<?php if(isset($this->locationActive) && !empty($this->location) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.enable.location', 1)):?>
<script type="text/javascript">
	var latLngSes;
	function initializeMapSes() {
		var latLngSes = new google.maps.LatLng(<?php echo $this->location->lat; ?>,<?php echo $this->location->lng; ?>);
		var myOptions = {
			zoom: 13,
			center: latLngSes,
			navigationControl: true,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		}
		var map = new google.maps.Map(document.getElementById("sesbusiness_map_container"), myOptions);
		var marker = new google.maps.Marker({
			position: latLngSes,
			map: map,
		});
		//trigger map resize on every call
		sesJqueryObject(document).on('click','ul#main_tabs li.tab_layout_sesbusiness_business_map',function (event) {
			google.maps.event.trigger(map, 'resize');
			map.setZoom(13);
			map.setCenter(latLngSes);
		});
		google.maps.event.addListener(map, 'click', function() {
			google.maps.event.trigger(map, 'resize');
			map.setZoom(13);
			map.setCenter(latLngSes);
		});
	}
</script>
<?php endif; ?>
<div class='sesbusiness_profile_info sesbasic_clearfix sesbasic_bxs'>
	<div class="sesbusiness_profile_info_col">
    <?php if(isset($this->infoActive)):?>
      <div class="sesbusiness_profile_info_row">
        <div class="sesbusiness_profile_info_head"><?php echo $this->translate("Basic Info"); ?></div>
        <ul class="sesbusiness_profile_info_row_info">
          <li class="sesbasic_clearfix">
            <span class="_l"><?php echo $this->translate("Created by"); ?></span>
            <span class="_v"><a href="<?php echo $this->subject->getOwner()->getHref(); ?>"><?php echo $this->subject->getOwner()->getTitle(); ?></a></span>
          </li>
          <li class="sesbasic_clearfix">
            <span class="_l"><?php echo $this->translate("Created on"); ?></span>
            <span class="_v"><?php echo $this->translate('%1$s', $this->timestamp($this->subject->creation_date)); ?></span>
          </li>
          <li class="sesbasic_clearfix">
            <span class="_l"><?php echo $this->translate("Stats"); ?></span>
            <span class="basic_info_stats _v">
              <span><?php echo $this->translate(array('<b>%s</b> Like', '<b>%s</b> Likes', $this->subject->like_count), $this->locale()->toNumber($this->subject->like_count)) ?>, </span>
              <span><?php echo $this->translate(array('<b>%s</b> Comment', '<b>%s</b> Comments', $this->subject->comment_count), $this->locale()->toNumber($this->subject->comment_count)) ?>, </span>
              <span><?php echo $this->translate(array('<b>%s</b> View', '<b>%s</b> Views', $this->subject->view_count), $this->locale()->toNumber($this->subject->view_count)) ?>, </span>
              <span><?php echo $this->translate(array('<b>%s</b> Favourite', '<b>%s</b> Favourites', $this->subject->favourite_count), $this->locale()->toNumber($this->subject->favourite_count)) ?></span>
              <span><?php echo $this->translate(array('<b>%s</b> Follower', '<b>%s</b> Followers', $this->subject->follow_count), $this->locale()->toNumber($this->subject->follow_count)) ?></span>
            </span>
          </li>
          <?php if($this->subject->category_id){ ?>
            <?php $category = Engine_Api::_()->getItem('sesbusiness_category',$this->subject->category_id); ?>
            <?php if($category){ ?>
              <li class="sesbasic_clearfix">
                <span class="_l"><?php echo $this->translate("Category"); ?></span>
                <span class="_v"><a href="<?php echo $category->getHref(); ?>"><?php echo $category->category_name; ?></a>
                  <?php $subcategory = Engine_Api::_()->getItem('sesbusiness_category',$this->subject->subcat_id); ?>
                  <?php if($subcategory && $this->subject->subcat_id != 0){ ?>
                     &nbsp;&raquo;&nbsp;<a href="<?php echo $subcategory->getHref(); ?>"><?php echo $subcategory->category_name; ?></a>
                    <?php $subsubcategory = Engine_Api::_()->getItem('sesbusiness_category',$this->subject->subsubcat_id); ?>
                    <?php if($subsubcategory && $this->subject->subsubcat_id != 0){ ?>
                     &nbsp;&raquo;&nbsp;<a href="<?php echo $subsubcategory->getHref(); ?>"><?php echo $subsubcategory->category_name; ?></a>
                    <?php } ?>
                  <?php } ?>
                </span>
              </li>
            <?php } ?>
          <?php } ?>
          <?php if(count($this->businessTags)){ ?>
            <li class="sesbasic_clearfix">
              <span class="_l"><?php echo $this->translate("Tags"); ?></span>
              <span class="_v">
                <?php 
                    $counter = 1;
                     foreach($this->businessTags as $tag):
                    if($tag->getTag()->text != ''){ ?>
                      <a href='javascript:void(0);' onclick='javascript:tagAction(<?php echo $tag->getTag()->tag_id; ?>,"<?php echo $tag->getTag()->text; ?>");'>#<?php echo $tag->getTag()->text ?></a>
                      <?php if(count($this->businessTags) != $counter){ 
                        echo ",";	
                       } ?>
              <?php } $counter++; endforeach;  ?>
              </span>
            </li>
          <?php } ?>
        </ul>
      </div>
    <?php endif;?>
    <?php if(!empty($this->sesbasicFieldValueLoop($this->subject)) && isset($this->profilefieldActive)):?>
      <div class="sesbusiness_profile_info_row" id="sesbusiness_custom_fields_val">
        <div class="sesbusiness_profile_info_head"><?php echo $this->translate("Other Info"); ?></div>
        <div class="sesbusiness_view_custom_fields sesbusiness_profile_info_row_info">
          <?php echo $this->sesbasicFieldValueLoop($this->subject);?>
        </div>
      </div>
    <?php endif;?>
    <?php if(!empty($this->subject->business_contact_phone) || !empty($this->subject->business_contact_email) || !empty($this->subject->business_contact_website) || !empty($this->subject->business_contact_facebook) || !empty($this->subject->business_contact_twitter) || !empty($this->subject->business_contact_linkedin) || !empty($this->subject->business_contact_instagram) || !empty($this->subject->business_contact_pinterest)):?>
      <div class="sesbusiness_profile_info_row">
        <div class="sesbusiness_profile_info_head"><?php echo $this->translate("Contact Information");?></div>
        <div class="sesbusiness_profile_info_contact_info">
          <ul>
            <?php if(!empty($this->subject->business_contact_phone)):?>
              <li class="sesbasic_clearfix">
                <i class="fa fa-mobile sesbasic_text_light"></i>
                <span>
                  <?php if(SESBUSINESSSHOWCONTACTDETAIL == 1):?>
                    <a href="javascript:void(0);" onclick="sessmoothboxDialoge('<?php echo $this->subject->business_contact_phone ;?>');"><?php echo $this->translate("View Phone No")?></a>
                  <?php else:?>
                    <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sesbusiness_general',true);?>" class="smoothbox"><?php echo $this->translate("View Phone No")?></a>
                  <?php endif;?>
                </span>
              </li>
            <?php endif;?>
            <?php if(!empty($this->subject->business_contact_email)):?>
              <li class="sesbasic_clearfix">
                <i class="fa fa-envelope sesbasic_text_light"></i>  
                <span>
                  <?php if(SESBUSINESSSHOWCONTACTDETAIL == 1):?>
                    <a href='mailto:<?php echo $this->subject->business_contact_email ?>'><?php echo $this->translate("Send Email")?></a>
                  <?php else:?>
                    <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sesbusiness_general',true);?>" class="smoothbox"><?php echo $this->translate("Send Email")?></a>
                  <?php endif;?>
                </span>
              </li>
            <?php endif;?>
            <?php if(!empty($this->subject->business_contact_website)):?>
              <li class="sesbasic_clearfix">
                <i class="fa fa-globe sesbasic_text_light"></i>
                <span>
                  <?php if(SESBUSINESSSHOWCONTACTDETAIL == 1):?>
                    <a href="<?php echo parse_url($this->subject->business_contact_website, PHP_URL_SCHEME) === null ? 'http://' . $this->subject->business_contact_website : $this->subject->business_contact_website; ?>" target="_blank"><?php echo $this->translate("Visit Website")?></a>
                  <?php else:?>
                    <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sesbusiness_general',true);?>" class="smoothbox"><?php echo $this->translate("Visit Website")?></a>
                  <?php endif;?>
                </span>
              </li>
            <?php endif;?>
            <?php if(!empty($this->subject->business_contact_facebook)):?>
              <li class="sesbasic_clearfix">
                <i class="fa fa-facebook sesbasic_text_light"></i>
                <span><a href="<?php echo parse_url($this->subject->business_contact_facebook, PHP_URL_SCHEME) === null ? 'http://' . $this->subject->business_contact_facebook : $this->subject->business_contact_facebook; ?>" target="_blank"><?php echo $this->translate("facebook.com")?></a></span>
              </li>
            <?php endif;?>
            <?php if(!empty($this->subject->business_contact_twitter)):?>
              <li class="sesbasic_clearfix">
                <i class="fa fa-twitter sesbasic_text_light"></i>
                <span><a href="<?php echo parse_url($this->subject->business_contact_twitter, PHP_URL_SCHEME) === null ? 'http://' . $this->subject->business_contact_twitter : $this->subject->business_contact_twitter; ?>" target="_blank"><?php echo $this->translate("twitter.com")?></a></span>
              </li>
            <?php endif;?>
            <?php if(!empty($this->subject->business_contact_linkedin)):?>
              <li class="sesbasic_clearfix">
                <i class="fa fa-linkedin sesbasic_text_light"></i>
                <span><a href="<?php echo parse_url($this->subject->business_contact_linkedin, PHP_URL_SCHEME) === null ? 'http://' . $this->subject->business_contact_linkedin : $this->subject->business_contact_linkedin; ?>" target="_blank"><?php echo $this->translate("linkedin.com")?></a></span>
              </li>
            <?php endif;?>
            <?php if(!empty($this->subject->business_contact_instagram)):?>
              <li class="sesbasic_clearfix">
                <i class="fa fa-instagram sesbasic_text_light"></i>
                <span><a href="<?php echo parse_url($this->subject->business_contact_instagram, PHP_URL_SCHEME) === null ? 'http://' . $this->subject->business_contact_instagram : $this->subject->business_contact_instagram; ?>" target="_blank"><?php echo $this->translate("instagram.com")?></a></span>
              </li>
            <?php endif;?>
            <?php if(!empty($this->subject->business_contact_pinterest)):?>
              <li class="sesbasic_clearfix">
                <i class="fa fa-pinterest sesbasic_text_light"></i>
                <span><a href="<?php echo parse_url($this->subject->business_contact_pinterest, PHP_URL_SCHEME) === null ? 'http://' . $this->subject->business_contact_pinterest : $this->subject->business_contact_pinterest; ?>" target="_blank"><?php echo $this->translate("pinterest.com")?></a></span>
              </li>
            <?php endif;?>
          </ul>	
        </div>
      </div>
    <?php endif;?>
  </div>  
	<div class="sesbusiness_profile_info_col">
    <?php if( !empty($this->subject->description) && isset($this->descriptionActive)): ?>
    	<div class="sesbusiness_profile_info_row">
      	<div class="sesbusiness_profile_info_head"><?php echo $this->translate("Details"); ?></div>
        <ul class="sesbusiness_profile_info_row_info">
          <li class="sesbasic_clearfix"><?php echo nl2br($this->subject->description) ?></li>
        </ul>
      </div>
    <?php endif; ?>
  </div>
  <?php if(isset($this->locationActive) && !empty($this->location) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.enable.location', 1)):?>
    <div class="sesbusiness_profile_info_row clear">
      <div class="sesbusiness_profile_info_row_info_map" id="sesbusiness_map_container"></div>
    </div>
  <?php endif;?>
</div> 
<script type="application/javascript">
  sesJqueryObject(document).ready(function(e){
    //var lengthCustomFi	= sesJqueryObject('#sesbusiness_profile_info_row_info').children().length;
    if(!sesJqueryObject('.sesbusiness_view_custom_fields').html()){
        sesJqueryObject('#sesbusiness_custom_fields_val').hide();
    } 
  });
  var tabId_info = <?php echo $this->identity; ?>;
  window.addEvent('domready', function() {
      tabContainerHrefSesbasic(tabId_info);	
      <?php if(isset($this->locationActive) && !empty($this->location) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.enable.location', 1)):?>
        initializeMapSes();
      <?php endif; ?>
  });
  var tagAction = window.tagAction = function(tag,value){
      var url = "<?php echo $this->url(array('module' => 'sesbusiness','action'=>'browse'), 'sesbusiness_general', true) ?>?tag_id="+tag+'&tag_name='+value;
   window.location.href = url;
  }
  
  function showPhoneNumber(phoneNo) {
    alert(phoneNo);
  }
</script>
