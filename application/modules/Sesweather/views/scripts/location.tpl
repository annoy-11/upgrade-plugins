<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesweather
 * @package    Sesweather
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: location.tpl  2018-08-24 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesweather/externals/scripts/core.js');?>
<?php $this->headScript()->appendFile('https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=' . Engine_Api::_()->getApi('settings', 'core')->getSetting('ses.mapApiKey', ''));?>
<script type="application/javascript">
window.addEvent('load', function() {
	document.getElementById('lng-wrapper').style.display = 'none';
	document.getElementById('lat-wrapper').style.display = 'none';
	mapLoad = false;
	initializeSesArticleAdminMapList();
});
</script>