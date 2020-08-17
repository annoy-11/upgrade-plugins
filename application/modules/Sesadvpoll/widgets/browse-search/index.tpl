<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvpoll
 * @package    Sesadvpoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-12-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if( $this->form ): ?>
  <?php echo $this->form->render($this) ?>
<?php endif ?>

<?php $request = Zend_Controller_Front::getInstance()->getRequest();?>
<?php $controllerName = $request->getControllerName();?>
<?php $actionName = $request->getActionName();?>

<?php if($controllerName == 'index' && $actionName == 'browse') { ?>

  <?php $identity = Engine_Api::_()->sesadvpoll()->getIdentityWidget('sesadvpoll.browse-polls','widget','sesadvpoll_index_browse'); ?>
  
  <script type="application/javascript">
    sesJqueryObject(document).ready(function() {
      sesJqueryObject('#filter_form').submit(function(e) {
        e.preventDefault();
        if(sesJqueryObject('.sesadvpoll_poll_listing').length > 0) {
          sesJqueryObject('#tabbed-widget_<?php echo $identity; ?>').html('');
          document.getElementById("tabbed-widget_<?php echo $identity; ?>").innerHTML = "<div class='clear sesbasic_loading_container' id='loading_images_browse_<?php echo $identity; ?>'></div>";
          sesJqueryObject('#loading_image_<?php echo $identity; ?>').show();
          sesJqueryObject('#loadingimgsesadvpoll-wrapper').show();
          
          if(typeof paggingNumber<?php echo $identity; ?> == 'function'){
            e.preventDefault();
            searchParams<?php echo $identity; ?> = sesJqueryObject(this).serialize();
            paggingNumber<?php echo $identity; ?>(1);
            sesJqueryObject('#loading_image_<?php echo $identity; ?>').hide();
          } else if(typeof viewMore_<?php echo $identity; ?> == 'function'){
            e.preventDefault();
            searchParams<?php echo $identity; ?> = sesJqueryObject(this).serialize();
            page<?php echo $identity; ?> = 1;
            viewMore_<?php echo $identity; ?>();
            sesJqueryObject('#loading_image_<?php echo $identity; ?>').hide();
          }
        }
        return true;
      });
    });
  </script>
<?php } ?>
