<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: endorsement.tpl  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesprofilefield/externals/styles/styles.css'); ?>
<script type="text/javascript">
  en4.core.runonce.add(function() {
	  seeMoreHideLink();
  });
  
  function getNextSeeMoreMembers(){
	  return <?php echo sprintf('%d', $this->paginator->getCurrentPageNumber() + 1) ?>
  }

  function seeMoreHideLink(){
    if($('seeMorePopUp'))
	    $('seeMorePopUp').style.display = '<?php echo ( $this->paginator->count() == $this->paginator->getCurrentPageNumber() || $this->count == 0 ? 'none' : '' ) ?>';
  }

  function viewMoreEndsorUsers() {
  
		var resource_id = '<?php echo $this->resource_id; ?>';
		document.getElementById('seeMorePopUp').style.display ='none';
		document.getElementById('seeMoreLoadingImage').style.display ='';
		en4.core.request.send(new Request.HTML({
			method : 'post',
			'url' : en4.core.baseUrl + 'sesprofilefield/index/endorsement/resource_id/' + resource_id,
			'data' : {
					format : 'html',
					showViewMore : 1,
					page: getNextSeeMoreMembers()
			},
			onSuccess : function(responseTree, responseElements, responseHTML, responseJavaScript) {
				document.getElementById('endorsement_results').innerHTML = document.getElementById('endorsement_results').innerHTML + responseHTML;
				document.getElementById('seeMorePopUp').destroy();
				document.getElementById('seeMoreLoadingImage').style.display ='none';
			}
		}));
		return false;
  }
</script>

<?php if (empty($this->showViewMore)): ?>
<div class="sesprofilefield_users_popup sesbasic_clearfix users_popup_small sesbasic_bxs">
  <div class="sesprofilefield_users_popup_header">
  	<?php echo $this->translate('Endorsed by users')?>
  </div>
  <div class="sesprofilefield_users_popup_cont" id="endorsement_results">
<?php endif; ?>
<?php if (count($this->paginator) > 0) : ?>
	<?php foreach( $this->paginator as $value ):  ?>
    <?php $user = Engine_Api::_()->getItem('user', $value->poster_id); ?>
		<div class="sesprofilefield_users_popup_item_list sesbasic_clearfix">
			<div class="sesprofilefield_users_popup_item_list_user_thumb">
				<?php echo $this->htmlLink($user->getHref(), $this->itemPhoto($user, 'thumb.icon'), array('class' => 'profile_friends_icon', 'title' => $user->getTitle())) ?>
			</div>
			<div class="sesprofilefield_users_popup_item_list_info">
				<div class="sesprofilefield_users_popup_item_list_title">
					<?php echo $this->htmlLink($user->getHref(), $user->getTitle()) ?>
				</div>
			</div>
		</div>
	<?php endforeach;?>
<?php else : ?>
  <div class="tip">
    <span>
    <?php echo $this->translate('No members found.');?>
    </span>
  </div>
<?php endif; ?>
<?php if (empty($this->showViewMore)):  ?>
	<div class="sesbasic_view_more" id="seeMorePopUp" onclick="viewMoreEndsorUsers()" >
		<?php echo $this->htmlLink('javascript:void(0);', $this->translate('View More'), array('id' => 'feed_viewmore_link', 'class' => 'buttonlink icon_viewmore' )); ?>
	</div>
	<div class="sesbasic_view_more_loading" id="seeMoreLoadingImage" style="display: none;">
		<img src='<?php echo $this->layout()->staticBaseUrl ?>application/modules/Core/externals/images/loading.gif' style='margin-right: 5px;' />
	</div>
	</div>
  <div class="users_popup_footer">
		<button  onclick='sessmoothboxclose();' ><?php echo $this->translate('Close') ?></button>
  </div>
</div>  
<?php endif; ?>
<script type="text/javascript">
 function smoothboxclose () {
  parent.Smoothbox.close () ;
 }
</script>