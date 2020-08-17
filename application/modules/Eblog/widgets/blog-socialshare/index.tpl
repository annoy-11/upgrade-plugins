<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div class="eblog_social_share_blog<?php echo $this->design_type; ?> sesbasic_bxs">
  <?php 
    if(in_array($this->design_type, array(3,4)))
      $param = 'photoviewpage'; 
    else 
      $param = ''; 
  ?>
  <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->subject, 'param' => $param)); ?>
</div>
