<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Quicksignup
 * @package    Quicksignup
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-11-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Quicksignup/views/scripts/dismiss_message.tpl';?>
<h2>Profile Questions Settings</h2>
<p>Below, you can enable / disable the profile fields for each profile type on your website individually.</p><br />
<?php
  // Render the admin js
  echo $this->render('_jsAdmin.tpl')
?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
<div class="admin_fields_options" style="display: none;">
    <a href="javascript:void(0);" onclick="void(0);" class="buttonlink admin_fields_options_saveorder">Save Order</a>
</div>
<div class="admin_fields_type">
    <h3>Editing Profile Type:</h3>
    <?php echo $this->formSelect('profileType', $this->topLevelOption->option_id, array(), $this->topLevelOptions) ?>
</div>

<br />
<ul class="admin_fields">
    <?php foreach( $this->secondLevelMaps as $map ): ?>
    <?php echo $this->adminFieldMeta($map) ?>
    <?php endforeach; ?>
</ul>
