<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seselegant
 * @package    Seselegant
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-04-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<a href="javascript:void(0);" class="header_searchbox_toggle" id="header_searchbox_toggle"><i class="fa fa-search"></i></a>
<div class="header_searchbox">
  <form id="global_search_form" action="<?php echo $this->url(array('controller' => 'search'), 'default', true) ?>" method="get">
    <input placeholder="<?php echo $this->translate("Search"); ?>" type="text" name="query" />
    <button onclick=""><i class="fa fa-search"></i></button>
  </form>
</div>
<script type="text/javascript">
  sesJqueryObject(document).on('click','#header_searchbox_toggle',function(){
    if(sesJqueryObject (this).hasClass('active')){
     sesJqueryObject (this).removeClass('active');
     sesJqueryObject ('.header_searchbox').removeClass('open_search');
    }else{
     sesJqueryObject (this).addClass('active');
     sesJqueryObject ('.header_searchbox').addClass('open_search');
    }
 });
</script>
		
   
