<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescontest
 * @package    Sescontest
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2017-12-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div class="sesbasic_clearfix sesbasic_bxs sescontest_browse_search <?php echo $this->view_type=='horizontal' ? 'sescontest_browse_search_horizontal' : 'sescontest_browse_search_vertical'; ?>">
  <?php echo $this->form->render($this) ?>
</div>
<?php $pageName = 'sescontest_profile_index_'.Engine_Api::_()->core()->getSubject()->conteststyle;?>
<?php $widgetName = 'sescontest.contest-entries';?>
<?php $identity = Engine_Api::_()->sesbasic()->getIdentityWidget($widgetName,'widget',$pageName); ?>

<script type="application/javascript">
  sesJqueryObject('#entry_filter_form').submit(function(e){
    e.preventDefault();
    if(sesJqueryObject('.sescontest_winners_listing').length > 0){
      sesJqueryObject('#tabbed-widget_<?php echo $identity; ?>').html('');
      sesJqueryObject('#loading_image_<?php echo $identity; ?>').show();
      sesJqueryObject('#loadingimgsescontest-wrapper').show();
      is_search_<?php echo $identity; ?> = 1;
      if(typeof paggingNumber<?php echo $identity; ?> == 'function'){
        isSearch = true;
        e.preventDefault();
        searchParams<?php echo $identity; ?> = sesJqueryObject(this).serialize();
        paggingNumber<?php echo $identity; ?>(1);
      }else if(typeof viewMore_<?php echo $identity; ?> == 'function'){
        isSearch = true;
        e.preventDefault();
        searchParams<?php echo $identity; ?> = sesJqueryObject(this).serialize();
        page<?php echo $identity; ?> = 1;
        viewMore_<?php echo $identity; ?>();
      }
    }
  });	
  function searchData() {
    sesJqueryObject('#entry_filter_form').submit();
  }
</script>
