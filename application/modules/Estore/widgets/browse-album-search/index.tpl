<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php
$base_url = $this->layout()->staticBaseUrl;
$this->headScript()
    ->appendFile($base_url . 'externals/autocompleter/Observer.js')
    ->appendFile($base_url . 'externals/autocompleter/Autocompleter.js')
    ->appendFile($base_url . 'externals/autocompleter/Autocompleter.Local.js')
    ->appendFile($base_url . 'externals/autocompleter/Autocompleter.Request.js');
?>
<div class="estore_album_search sesbasic_browse_search <?php echo $this->view_type=='horizontal' ? 'sesbasic_browse_search_horizontal' : ''; ?>">
  <?php echo $this->searchForm->render($this) ?>
</div>
<?php $request = Zend_Controller_Front::getInstance()->getRequest();?>
<?php $controllerName = $request->getControllerName(); ?>
<?php $actionName = $request->getActionName();?>
<script>var Searchurl = "<?php echo $this->url(array('module' =>'estore','controller' => 'album', 'action' => 'get-album'),'default',true); ?>";</script>
<?php if($controllerName == 'album' && $actionName == 'browse') { ?>
  <?php $identity = Engine_Api::_()->estore()->getIdentityWidget('estore.browse-albums','widget','estore_album_browse'); ?>
  <?php if($identity){ ?>
    <script type="application/javascript">
      sesJqueryObject(document).ready(function(){
        sesJqueryObject('#filter_form').submit(function(e){
          if(sesJqueryObject('.estore_browse_album_listings').length > 0){
            sesJqueryObject('#loadingimgestore-wrapper').show();
            if(typeof paggingNumber<?php echo $identity; ?> == 'function'){
              e.preventDefault();
              searchParams<?php echo $identity; ?> = sesJqueryObject(this).serialize();
              paggingNumber<?php echo $identity; ?>(1);
            }else if(typeof viewMore_<?php echo $identity; ?> == 'function'){
              e.preventDefault();
              searchParams<?php echo $identity; ?> = sesJqueryObject(this).serialize();
              page<?php echo $identity; ?> = 1;
              viewMore_<?php echo $identity; ?>();
            }
          }
        return true;
        });
      });
    </script>
  <?php } ?>
<?php } ?>
<script type="text/javascript">
  sesJqueryObject('#loadingimgestore-wrapper').hide();
</script>
