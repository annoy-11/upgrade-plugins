<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesteam
 * @package    Sesteam
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: browse-members.tpl 2015-02-20 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>

<div class='browsemembers_results' id='browsemembers_results'>
  <?php echo $this->render('_browseUsers.tpl') ?>
</div>

<script type="text/javascript">
  en4.core.runonce.add(function() {
    var url = '<?php echo $this->url(array(), 'sesteam_general', true) ?>';
    var requestActive = false;
    var browseContainer, formElement, page, totalUsers, userCount, currentSearchParams;

    formElement = $$('.layout_user_browse_search .field_search_criteria')[0];
    browseContainer = $('browsemembers_results');


    var searchMembers = window.searchMembers = function() {
      if( requestActive ) return;
      requestActive = true;

      currentSearchParams = formElement ? formElement.toQueryString() : null;

      var param = (currentSearchParams ? currentSearchParams + '&' : '') + 'ajax=1&format=html';
      if (history.replaceState){
            history.replaceState( {}, document.title, url + (currentSearchParams ? '?'+currentSearchParams : '') );
        }
      var request = new Request.HTML({
        url: url,
        onComplete: function(requestTree, requestHTML) {
          requestTree = $$(requestTree);
          browseContainer.empty();
          requestTree.inject(browseContainer);
          requestActive = false;
          Smoothbox.bind();
        }
      });
      request.send(param);
    }

    var browseMembersViewMore = window.browseMembersViewMore = function() {
      if( requestActive ) return;
      $('browsemembers_loading').setStyle('display', '');
      $('browsemembers_viewmore').setStyle('display', 'none');

      var param = (currentSearchParams ? currentSearchParams + '&' : '') + 'ajax=1&format=html&page=' + (parseInt(page) + 1);

      var request = new Request.HTML({
        url: url,
        onComplete: function(requestTree, requestHTML) {
          requestTree = $$(requestTree);
          browseContainer.empty();
          requestTree.inject(browseContainer);
          requestActive = false;
          Smoothbox.bind();
        }
      });
      request.send(param);
    }
  });
</script>
