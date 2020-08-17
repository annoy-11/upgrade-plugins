<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesmember/externals/styles/styles.css'); ?>
<?php include APPLICATION_PATH . '/application/modules/Sesmember/views/scripts/_profileCompliments.tpl'; ?>
<script type="text/javascript">
  var tabId_pE2 = '<?php echo $this->identity?>';
  window.addEvent('domready', function() {
    tabContainerHrefSesbasic(tabId_pE2);	
  });
</script>
