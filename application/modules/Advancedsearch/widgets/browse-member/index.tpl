<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Advancedsearch
 * @package    Advancedsearch
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $randonNumber = "browseMember1276"; ?>
<div class='browsemembers_results' id='browsemembers_results'>
  <?php if ($this->isAjaxSearch): ?>
  <h3>
    <?php echo $this->translate(array('%s member found.', '%s members found.', $this->totalUsers),$this->locale()->toNumber($this->totalUsers)) ?>
  </h3>
  <?php endif;?>
  <?php $viewer = Engine_Api::_()->user()->getViewer();?>
  <?php if( count($this->users)): ?>
  <?php
    $ulClass = '';
    $excludedLevels = array(1, 2, 3);
    $isAdmin = false;
    if(!$this->viewer()->getIdentity()){
      $ulClass = 'public_user';
    }else{
      $viewerId = $viewer->getIdentity();
      if( in_array($viewer->level_id, $excludedLevels) ) {
        $isAdmin = true;
      } else {
        $registeredPrivacy = array('everyone', 'registered');
        $friendsIds = $viewer->membership()->getMembersIds();
      }
    }
  ?>
  <ul id="browsemembers_ul" class="grid_wrapper <?php echo $ulClass;?>">
    <?php foreach( $this->users as $user ): ?>
    <li>
      <?php
          $showPhoto = false;
          $viewPrivacy = $user->view_privacy;

      if( !isset($viewerId) ) {
      if( $viewPrivacy == 'everyone' ) {
      $showPhoto = true;
      }
      } elseif( $isAdmin
      || $viewerId == $user->getIdentity()
      || in_array($viewPrivacy, $registeredPrivacy)
      || ($viewPrivacy == 'member' && in_array($user->getIdentity(), $friendsIds))) {
      $showPhoto = true;
      } elseif($viewPrivacy == 'network' ) {
      $netMembershipTable = Engine_Api::_()->getDbtable('membership', 'network');
      $viewerNetwork = $netMembershipTable->getMembershipsOfIds($viewer);
      $userNetwork = $netMembershipTable->getMembershipsOfIds($user);

      if( in_array($user->getIdentity(), $friendsIds)
      || !empty(array_intersect($userNetwork, $viewerNetwork)) ) {
      $showPhoto = true;
      }
      }

      if( $showPhoto ){
      $profileImg = $this->itemBackgroundPhoto($user, 'thumb.profile');
      } else {
      $profileImg = '<span class="bg_item_photo bg_thumb_profile bg_item_photo_user bg_item_nophoto" '.
      'style=background-image:url("' . $this->baseUrl() . '/application/modules/User/externals/images/privatephoto_user_thumb_profile.png");></span>';
      }

      ?>
      <?php echo $this->htmlLink($user->getHref(), $profileImg) ?>
      <div class='browsemembers_results_info'>
        <?php echo $this->htmlLink($user->getHref(), $user->getTitle()) ?>
        <span>
              <?php echo $user->status; ?>
          <?php if( $user->status != "" ): ?>
            </span>
        <div>
          <?php echo $this->timestamp($user->status_date) ?>
        </div>
        <?php endif; ?>
      </div>
      <?php if( isset($viewerId) && $viewerId != $user->getIdentity() ): ?>
      <div class='browsemembers_results_links'>
        <?php echo '<span>'.$this->partial('_addfriend_button.tpl', 'sesbasic', array('subject' => $user)).'</span>'; ?>
        <?php if( 0 ) :?>
        <?php echo '<a href ="'. $this->url(array(
                    'controller' => 'block',
                    'action' => 'add',
                    'user_id' => $user->getIdentity()
                    ),'user_extended',true)
                    . '" class = "buttonlink icon_user_block smoothbox"> Block Member </a>'; ?>
        <?php endif; ?>
      </div>
      <?php endif; ?>
    </li>
    <?php endforeach; ?>
  </ul>
  <?php endif ?>
  <?php if( $this->users ): ?>
  <div class='browsemembers_viewmore' id="browsemembers_viewmore">
    <?php echo $this->paginationControl($this->users, null, array("_pagging.tpl", "advancedsearch"),array('identityWidget'=>$randonNumber)); ?>
  </div>
  <?php endif; ?>
  <script type="text/javascript">
      page = '<?php echo sprintf('%d', $this->page) ?>';
      totalUsers = '<?php echo sprintf('%d', $this->totalUsers) ?>';
      userCount = '<?php echo sprintf('%d', $this->userCount) ?>';
  </script>
</div>
<script type="text/javascript">

    function paggingNumber<?php echo $randonNumber; ?>(pageNum){
        sesJqueryObject ('.overlay_<?php echo $randonNumber ?>').css('display','block');
        (new Request.HTML({
              method: 'post',
              'url': en4.core.baseUrl + "widget/index/mod/advancedsearch/name/browse-member?type=user",
              'data': {
              format: 'html',
              page: pageNum,
              query : "<?php echo $this->query; ?>",
              ajax:1,
              searchParams : <?php echo json_encode($this->formValues); ?>,
         },
        onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
            sesJqueryObject('#browsemembers_results').html(responseHTML);
        }
    })).send();
        return false;
    }

  en4.core.runonce.add(function() {
    var url = en4.core.baseUrl + "widget/index/mod/advancedsearch/name/browse-member?type=user";
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
            //history.replaceState( {}, document.title, url + (currentSearchParams ? '?'+currentSearchParams : '') );
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
