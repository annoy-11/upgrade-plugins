<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagethm
 * @package    Sespagethm
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<script type="application/javascript">
sesJqueryObject(document).ready(function(e){
	sesJqueryObject('<div class="lp_header_menu">'+ sesJqueryObject('.sespagethm_main_navigation').html() + '</div>').insertBefore(sesJqueryObject('#core_menu_mini_menu'));
	sesJqueryObject('<li class="sespagethm_minimenu_link minimenu_add_btn"><a href="/page-directories/create"><i class="fa fa-plus"></i><span>Add Page</a></a></li>').insertAfter(sesJqueryObject('.sespagethm_minimenu_link_signup'));
});
</script>