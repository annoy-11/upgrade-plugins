<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfooter
 * @package    Sesfooter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php 2015-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$db = Zend_Db_Table_Abstract::getDefaultAdapter();
$default_constants = array(
'ses_footer_width' => '1200px',
'ses_footer_background_color' => '#2D2D2D',
'ses_footer_border_color' => '#0186BF',
'ses_footer_headings_color' => '#999',
'ses_footer_text_color' => '#999',
'ses_footer_link_color' => '#999',
'ses_footer_link_hover_color' => '#fff',
'ses_footer_design' => '6',
'ses_footer_button_color' => '#00a8f2',
'ses_footer_button_hover_color' => '#0090cd',
'ses_footer_button_text_color' => '#fff',
'ses_footer_background_image' => 'public/admin/blank.png',
'sesfooter_heading_fontfamily' =>  'Arial, Helvetica, sans-serif',
'sesfooter_heading_fontsize' =>  '17px',
'sesfooter_text_fontfamily' =>  'Arial, Helvetica, sans-serif',
'sesfooter_text_fontsize' =>  '15px',
);
Engine_Api::_()->sesfooter()->readWriteXML('', '', $default_constants);

$db->query("INSERT INTO `engine4_sesfooter_footerlinks` (`footerlink_id`, `name`, `url`, `enabled`, `sublink`, `nonloginenabled`, `nonlogintarget`, `loginurl`, `loginenabled`, `logintarget`, `footer_headingicon`) VALUES
(1, 'Information', '', 1, 0, 0, 0, '', 0, 0, ''),
(2, 'Explore', '', 1, 0, 0, 0, '', 0, 0, '0'),
(3, 'Resources', '', 1, 0, 0, 0, '', 0, 0, '0'),
(4, 'Quick Links', '', 0, 0, 0, 0, '', 0, 0, '0'),
(5, 'Articles', '', 0, 0, 0, 0, '', 0, 0, '0'),
(6, 'Our Demos', '', 0, 0, 0, 0, '', 0, 0, '0'),
(7, 'Videos', 'videos', 1, 2, 1, 0, 'videos', 1, 0, ''),
(8, 'Music', 'music/album/home', 1, 2, 1, 0, 'music/album/home', 1, 0, ''),
(9, 'Photo Albums', 'albums', 1, 2, 1, 0, 'albums', 1, 0, ''),
(10, 'Channels', 'videos/channels', 1, 2, 1, 0, 'videos/channels', 1, 0, ''),
(11, 'Photos', 'albums/browse-photo', 1, 3, 1, 0, 'albums/browse-photo', 1, 0, ''),
(12, 'Songs', 'music/songs/browse', 1, 3, 1, 0, 'music/songs/browse', 1, 0, ''),
(13, 'Members', 'members', 1, 3, 1, 0, 'members', 1, 0, ''),
(14, 'Groups', 'groups', 1, 3, 1, 0, 'groups', 1, 0, ''),
(15, 'SocialEngineSolutions Site', 'http://www.socialenginesolutions.com', 0, 4, 1, 1, 'http://www.socialenginesolutions.com', 1, 1, ''),
(16, 'How to build a social network', 'http://blog.socialengine.com/2012/10/03/how-to-build-a-social-network/?_ga=1.223546139.1423006792.1449921875', 0, 5, 1, 1, 'http://blog.socialengine.com/2012/10/03/how-to-build-a-social-network/?_ga=1.223546139.1423006792.1449921875', 1, 1, ''),
(17, 'SpectroMedia Theme', 'http://spectromedia.socialenginesolutions.com', 0, 6, 1, 1, 'http://spectromedia.socialenginesolutions.com', 1, 1, ''),
(18, 'Christmas & New Year', 'http://christmas.socialenginesolutions.com', 0, 6, 1, 1, 'http://christmas.socialenginesolutions.com', 1, 1, ''),
(19, 'HTML5 Backgrounds', 'html5-videos-photos-backgrounds', 0, 6, 1, 0, 'html5-videos-photos-backgrounds', 1, 0, ''),
(20, 'Video Locations', 'videos/locations', 0, 6, 1, 0, 'videos/locations', 1, 0, ''),
(21, 'Building an online community', 'http://blog.socialengine.com/2012/09/10/building-an-online-community/?_ga=1.237707776.1423006792.1449921875', 0, 5, 1, 1, 'http://blog.socialengine.com/2012/09/10/building-an-online-community/?_ga=1.237707776.1423006792.1449921875', 1, 1, ''),
(22, 'We at SocialEngine', 'https://www.socialengine.com/experts/profile/socialenginesolutions', 0, 4, 1, 1, 'https://www.socialengine.com/experts/profile/socialenginesolutions', 1, 1, '');");

//Footer Default Work
$select = new Zend_Db_Select($db);
$select
        ->from('engine4_core_content', 'name')
        ->where('page_id = ?', 2)
        ->where('name LIKE ?', '%menu-footer%')
        ->limit(1);
$info = $select->query()->fetch();
if (!empty($info)) {
  $db->update('engine4_core_content', array(
      'name' => 'sesfooter.footer',
          ), array(
      'name = ?' => $info['name'],
  ));
}

$db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES ("sesfooter_admin_main_typography", "sesfooter", "Typography", "", \'{"route":"admin_default","module":"sesfooter","controller":"settings", "action":"typography"}\', "sesfooter_admin_main", "", 50);');
