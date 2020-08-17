<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespopupbuilder
 * @package    Sespopupbuilder
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php  2018-11-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$db = Zend_Db_Table_Abstract::getDefaultAdapter();

$db->query('INSERT IGNORE INTO `engine4_sespopupbuilder_popups` (`user_id`, `is_deleted`, `is_visit`, `title`, `creation_date`, `popup_type`,`image`, `html`,`video_url`, `video_code`, `iframe_url`, `facebook_url`, `pdf_file`, `age_verification`, `notification_text`, `notification_button_label`, `notification_button_link`, `notification_button_target`, `text_verifiaction`, `is_button_text`, `first_button_verifiaction`, `second_button_verifiaction`, `cookies_description`, `cookies_button`, `cookies_button_title`, `coundown_description`, `countdown_endtime`, `christmas_description`, `christmas_image1_check`, `christmas_image1_upload`, `christmas_image1_select`, `christmas_image2_check`, `christmas_image2_upload`, `christmas_image2_select`, `level_id`, `devices`, `page_visit_count`, `networks`,`when_show_popup`,`profile_type`, `whenshow`,`showspecicurl`,`after_inactivity_time`, `when_close_popup`, `close_time`, `date_display_setting`, `starttime`, `endtime`, `how_long_show`, `background`, `background_photo`,`background_color`, `backgroundoverlay_opicity`, `popup_responsive_mode`, `responsive_size`, `custom_width`, `custom_height`, `max_width`, `max_height`, `min_width`, `min_height`, `close_button`, `close_button_width`, `close_button_height`, `close_button_position`, `opening_popup_sound`,`popup_sound_file`,`popup_opening_animation`, `opening_type_animation`, `opening_speed_animation`, `closing_speed_animation`)
VALUES
((select user_id from `engine4_users` where level_id = 1),"0","0","Last upto 60% Discount of the year 2018 !",NOW(),"html",NULL,\'<div style="padding: 5px;">
<h1 class="entry-title" style="margin: 10px 0; text-align: center; font-size: 25px; line-height: 30px; font-weight: 600; text-transform: none; color: #303133;">[Final Hours] Last up to 60% Discount of the year 2018!</h1>
<div class="entry-content ">
<p class="_is" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-weight: 400; font-size: 14px; line-height: 24px; text-transform: none; color: #222222; text-align: center;">We are glad to inform you that year 2018 is going to be passed out soon and we are expeditiously stepping towards the another &lsquo;New Year 2019&rsquo; which may give you success, prosperity &amp; new achievements to all your goals. So with everything exciting &amp; glorious, we want to make your coming year more joyful by giving <strong>up to 60% Discount on our Mobile Apps &amp; Certified Products till the 31st Dec 2018.</strong></p>
<div class="offer_details" style="margin-bottom: 15px;">
<h4 style="font-size: 20px; line-height: 22px; text-align: center; text-transform: none; font-weight: 600; letter-spacing: 0px; border: 0; color: #303133;">Exclusive Flat 60% Discount on Native Mobile Apps:</h4>
<p class="_is" style="padding: 10px; text-align: center; border: 2px dashed #15a9e5; margin: 10px auto;">60% Discount Coupon Code: <strong>mobileapps_60</strong></p>
</div>
<div class="notice-message" style="border: 1px solid #e1f2fb; padding: 15px; margin-bottom: 15px; background-color: rgba(183, 233, 255, 0.21);">
<p style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-weight: 400; font-size: 14px; line-height: 24px; margin: 5px 0; text-align: center;"><strong><a href="https://www.socialenginesolutions.com/the-pre-2019-and-christmas-sale-flat-30-off-on-all-our-products/" target="_blank" rel="noopener noreferrer">Flat 30% Discount on Everything else</a></strong></p>
<p style="margin: 5px 0; text-align: center; text-transform: none; color: #222222;"><span style="font-weight: 400;">30% Discount Coupon Code: </span><strong style="color: #f00;">Xmas_NewYear2019_30%</strong></p>
</div>
<p style="text-align: center; font-weight: bold;"><a href="https://www.socialengine.com/experts/profile/socialenginesolutions#products-php" target="_blank" rel="noopener noreferrer">Certified Plugins</a> | <a href="https://www.socialenginesolutions.com/socialengine-category/plugins/" target="_blank" rel="noopener noreferrer">Plugins</a> | <a href="https://www.socialenginesolutions.com/socialengine-category/themes/" target="_blank" rel="noopener noreferrer">Themes</a> | <a href="https://www.socialenginesolutions.com/socialengine-category/packages/" target="_blank" rel="noopener noreferrer">Packages</a> | <a href="https://www.socialenginesolutions.com/socialengine-category/packs/" target="_blank" rel="noopener noreferrer">Packs</a> | <a href="https://www.socialenginesolutions.com/support-mobile-apps-subscriptions/" target="_blank" rel="noopener noreferrer">Subscriptions</a> | <a href="https://www.socialenginesolutions.com/socialengine-category/widgets/" target="_blank" rel="noopener noreferrer">Widgets</a></p>
<p class="_is" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-weight: 400; font-size: 14px; line-height: 24px; text-transform: none; color: #222222; text-align: center;"><a class="cl-btn btn-style-material_square btn-layout-extra-large btn-font-medium" style="margin-top: 15px; background-color: #fd8422; border: 0; padding: 14px 34px; font-size: 13px; letter-spacing: 0px; font-weight: 600; text-transform: uppercase; color: #ffffff; display: inline-block; border-radius: 5px;" href="https://www.socialenginesolutions.com/contact-us/" target="_blank" rel="noopener noreferrer">I need Custom Discount</a></p>
<p dir="ltr" style="clear: both; text-align: center; background-color: #f9f9f9; padding: 20px; margin-bottom: 0; border: 1px solid #ddd; margin-top: 20px; float: left; width: 100%;">To stay tuned to our latest updates <br> <span style="font-size: small; line-height: 20px;"><a href="https://twitter.com/SocialEngineSol" target="_blank" rel="noopener noreferrer">Follow us on Twitter</a>,&nbsp;<a href="https://www.facebook.com/SocialEngineSolutions" target="_blank" rel="noopener noreferrer">Like us on Facebook</a></span> <br> <span style="font-size: small; line-height: 20px;">You can subscribe to our Newsletter from the footer of our website.</span> <br> <strong style="line-height: 20px;">For urgent issues reach out to us at:</strong> <br> <strong style="line-height: 20px;"><a href="https://api.whatsapp.com/send?phone=919950682999"> +91-9950682999</a></strong> | <strong><a> vaibhav.sesolution</a></strong></p>
<p>&nbsp;</p>
</div>
</div>\',Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,"1,2,3,4,5,6,7","0","0","1,2,3,4,5,6,7",Null,Null,"1",Null,"400","1","0","0",
"2018-12-31 10:00:00","2018-12-31 10:00:00","everytime","2",Null,"FFFFFF","7","1","10","700","500","900","550","500","300","1","40","40","1","0",Null,"1","mfp-move-from-top",
"2","2"),
((select user_id from `engine4_users` where level_id = 1),"0","0","Like Our Page",NOW(),"facebook_like",Null,Null,Null,Null,Null,\'<iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2FSocialEngineSolutions%2F&tabs=timeline&width=340&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=1470102876425817" width="340" height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>\',Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,"1,2,3,4,5,6,7","0","0","1,2,3,4,5,6,7",Null,Null,"1",Null,"0","1","0","0",
NOW(),NOW(),"firsttime","2",Null,"FFFBFA","7","1","5","340","500","340","500","300","300","1","40","40","1","0",Null,"1","mfp-zoom-in", "2","3"),
((select user_id from `engine4_users` where level_id = 1),"0","0","Watch Our Video Demo",NOW(),"video",Null,Null,"https://www.youtube.com/watch?v=sQe3rnfDyS4",\'<div><div style="left: 0; width: 100%; height: 0; position: relative; padding-bottom: 56.2493%;"><iframe src="https://www.youtube.com/embed/sQe3rnfDyS4?feature=oembed" style="border: 0; top: 0; left: 0; width: 100%; height: 100%; position: absolute;" allowfullscreen scrolling="no"></iframe></div></div>\',Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,"1,2,3,4,5,6,7","0","0","1,2,3,4,5,6,7",Null,Null,"1",Null,"0","1","0","0",
NOW(),NOW(),"firsttime","2",Null,"FFFFFF","7","1","5","700","500","700","382","500","300","1","40","40","1","0",Null,"1","mfp-newspaper",
"2","2"),
((select user_id from `engine4_users` where level_id = 1),"0","0","Watch Iframe Popup",NOW(),"iframe",Null,Null,Null,Null,\'<iframe width="1040" height="507" src="https://www.youtube.com/embed/CN0wiDwp7so" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>\',Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,"1,2,3,4,5,6,7","0","0","1,2,3,4,5,6,7",Null,Null,"1",Null,"0","1","0","0",
NOW(),NOW(),"firsttime","2",Null,"FFFFFF","7","1","5","700","500","700","500","500","300","1","40","40","2","0",Null,"1","mfp-zoom-in",
"2","3"),
((select user_id from `engine4_users` where level_id = 1),"0","0","Watch our Age verification popup",NOW(),"age_verification",Null,Null,Null,Null,Null,Null,Null,"18",Null,Null,Null,Null,"This website requires you to be 15 years or older to enter. Please comfirm your age or ignore if you are 18+.","1","I am over 18","Not Now",Null,Null,Null,Null,Null,Null,"0",Null,Null,"0",Null,Null,"1,2,3,4,5,6,7","0","0","1,2,3,4,5,6,7",Null,Null,"1",Null,"0","1","0","0",
NOW(),NOW(),"firsttime","2",Null,"FFFFFF","7","1","5","400","150","700","500","400","150","1","40","40","1","0",Null,"1","mfp-move-horizontal",
"2","2"),
((select user_id from `engine4_users` where level_id = 1),"0","0","Enter Notification Popup",NOW(),"notification_bar",Null,Null,Null,Null,Null,Null,Null,Null,"Clicking yes will make Comic Sans you new system default font. Seriously have you thought this through?","Yes do it Now!","https://www.socialenginesolutions.com/","1",Null,"1",Null,Null,Null,Null,Null,Null,Null,Null,"0",Null,Null,"0",Null,Null,"1,2,3,4,5,6,7","0","0","1,2,3,4,5,6,7",Null,Null,"1",Null,"0","1","0","0",
NOW(),NOW(),"firsttime","2",Null,"FFFFFF","7","1","5","400","150","700","500","400","150","1","40","40","1","0",Null,"1","mfp-move-from-top",
"2","2"),
((select user_id from `engine4_users` where level_id = 1),"0","0","Watch Cookie Consent Popup",NOW(),"cookie_consent",Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,Null,\'<div class="cookie_consent" style="padding: 10px;">
<h3 style="color: #ec4b5c; font-size: 24px; font-weight: bold; margin-bottom: 10px;">Cookies &amp; Privacy</h3>
<p style="color: #fff; font-size: 15px; line-height: 24px; margin-bottom: 15px;">I use cookies only to track visits to my website and for some small design elements - no personal details are stored.</p>
</div>\',"0",Null,Null,Null,Null,"0",Null,Null,"0",Null,Null,"1,2,3,4,5,6,7","0","0","1,2,3,4,5,6,7",Null,Null,"1",Null,"0","1","0","0",
NOW(),NOW(),"firsttime","2",Null,"3B3645","7","1","5","400","200","700","500","400","200","1","40","40","1","0",Null,"1","mfp-move-horizontal",
"2","2");');
$db->query('ALTER TABLE `engine4_sespopupbuilder_popups` ADD `popup_visibility_duration` INT(11) DEFAULT NULL;');
$db->query('ALTER TABLE `engine4_sespopupbuilder_visits` ADD `popup_visit_date` datetime DEFAULT NULL;');
$db->query('ALTER IGNORE TABLE `engine4_sespopupbuilder_visits` ADD UNIQUE (user_id,popup_id);');



//Header
$pageId = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'header')
    ->limit(1)
    ->query()
    ->fetchColumn();
if($pageId){
    $contentId = $db->select()
                    ->from('engine4_core_content', 'content_id')
                    ->where('page_id = ?', $pageId)
                    ->where('name = ?', 'main')
                    ->limit(1)
                    ->query()
                    ->fetchColumn();
    if($contentId){
        $db->insert('engine4_core_content', array(
            'page_id' => $pageId,
            'type' => 'widget',
            'name' => 'sespopupbuilder.popup',
            'parent_content_id'=>$contentId,
        ));
    }
}

