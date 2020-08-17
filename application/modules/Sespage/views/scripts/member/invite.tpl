<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: invite.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespage/externals/styles/styles.css'); ?>
<script type="text/javascript">
  function hideViewMore() {
    if($('view_more'))
    $('view_more').style.display = "<?php echo ($this->paginator->count() == 0 ? 'none' : ($this->paginator->count() == $this->paginator->getCurrentPageNumber() ? 'none' : '' )) ?>";
  }
  hideViewMore();
  function viewMore() {
    document.getElementById('view_more').style.display = 'none';
    document.getElementById('loading_image').style.display = '';
    (new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + 'sespage/member/invite/page_id/' + '<?php echo $this->page->page_id; ?>' ,
      'data': {
        format: 'html',
        page: "<?php echo sprintf('%d', $this->paginator->getCurrentPageNumber() + 1) ?>",
        viewmore: 1        
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        document.getElementById('user_results').innerHTML = document.getElementById('user_results').innerHTML + responseHTML;
        //document.getElementById('view_more').destroy();
         hideViewMore();
        document.getElementById('loading_image').style.display = 'none';
      }
    })).send();
    return false;
  }
</script>
<script type="text/javascript">
  en4.core.runonce.add(function(){
    sesJqueryObject(document).on('click', '#selectall',function(e) {
      var el = $(e.target);
      $$('input[type=checkbox]').set('checked', el.get('checked'));
    });
  });
</script>
<?php if( $this->paginator->getTotalItemcount() > 0 ): ?>
  <?php if (empty($this->viewmore)): ?>
  <form method="post" id="sespageinviteform" data-src="<?php echo $this->page->page_id; ?>">
    <div class="sespage_invite_popup sesbasic_bxs">
      <div class="_header"><?php echo $this->translate('Invite Members') ?></div>
      <div class="_content">
       <p class="_des"><?php echo $this->translate('Choose the people you want to invite to this page.') ?></p>
      <?php if( $this->paginator->getTotalItemcount() > 1 ): ?>
				<div class="_btn sesbasic_clearfix">
          <span class="sesbasic_button _sabtn">
        		<input type="checkbox" id="selectall" value="" />
            <label for="selectall">Select All</label>
        	</span>
        </div>
      <?php endif;?>
      <div class="_memberslistcontainer">
      	<div class="_memberslist clear" id="user_results">
    <?php endif; ?>
      <?php if (count($this->paginator) > 0) : ?>
        <?php foreach ($this->paginator as $user): ?>
          <div class="item_list">
          	<div class="_input">
            	<input type="checkbox" name="user_id[]" class="selectmember" value="<?php echo $user->user_id; ?>" />
            </div>
            <div class="item_list_thumb">
              <?php echo $this->htmlLink($user->getHref(), $this->itemPhoto($user, 'thumb.icon'), array('title' => $user->getTitle(), 'target' => '_parent')); ?>
            </div>
            <div class="item_list_info">
              <div class="item_list_title">
                <?php echo $this->htmlLink($user->getHref(), $user->getTitle(), array('title' => $user->getTitle(), 'target' => '_parent')); ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?> 
      <?php endif; ?>     
    <?php if (empty($this->viewmore)): ?>
    			</div>
          <?php if (!empty($this->paginator) && $this->paginator->count() > 1 && $this->paginator->getCurrentPageNumber() < $this->paginator->count()): ?>
            <div class="sesbasic_load_btn" id="view_more" onclick="viewMore();" >
               <a href="javascript:void(0);" class="sesbasic_animation sesbasic_link_btn" id="feed_viewmore_link"><i class="fa fa-repeat"></i><span><?php echo $this->translate('View More');?></span></a>
            </div>
            <div class="sesbasic_load_btn" id="loading_image" style="display: none;">
            	<span class="sesbasic_link_btn"><i class="fa fa-spinner fa-spin"></i></span>
            </div>
          <?php endif; ?>
        </div>
      </div>
    	<div class="_footer"><button type='submit'><?php echo $this->translate("Invite Members") ?></button></div>
   	</div> 
   </form>
  <?php endif;?>
<?php else:?>
  <div class="sespage_invite_popup sesbasic_bxs">
    <div class="_header">
      <?php echo $this->translate('Invite Members') ?>
    </div>
    <div class="_content"><div class="_msg"><?php echo $this->translate('You have no friends you can invite.');?></div></div>
     <div class="_footer">
    	<button onclick="javascript:sessmoothboxclose();"><?php echo $this->translate("Close");?></button>
    </div>
  </div>
<?php endif; ?>