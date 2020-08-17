<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescommunityads
 * @package    Sescommunityads
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: get-boost-post-feed.tpl  2018-10-09 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesadvancedactivity/externals/styles/styles.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesadvancedcomment/externals/styles/styles.css'); ?>
<style>
.sesadvcmt_comments{display:none;}
</style>
<?php
  $widgetId = Engine_Api::_()->sescommunityads()->getIdentityWidget('sesadvancedactivity.feed','widget','user_index_home');
  
  echo $this->content()->renderWidget('sesadvancedactivity.feed', array('action_id'=>$this->action->getIdentity(),'widgetIds'=>$widgetId));
?>