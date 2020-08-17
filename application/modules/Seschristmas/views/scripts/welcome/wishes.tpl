<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seschristmas
 * @package    Seschristmas
 * @copyright  Copyright 2014-2015 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: wishes.tpl 2014-11-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>     
<script type="text/javascript">
  
  var showviewmore  = "<?php echo $this->showviewmore ?>";
  
  en4.core.runonce.add(function() {
    noneviewmorelink();
  });
  
  function noneviewmorelink() {
  
    if(showviewmore == 1) {
      if ($('view_more')) 
      $('view_more').style.display = "<?php echo ( $this->paginator->count() == $this->paginator->getCurrentPageNumber() || $this->count == 0 ? 'none' : '' ) ?>";
     } else if(showviewmore == 2) {
        if ($('view_more'))
          $('view_more').style.display = 'none';
        var totalCount = '<?php echo $this->paginator->count(); ?>';
        var currentPageNumber = '<?php echo $this->paginator->getCurrentPageNumber(); ?>';
        function doOnScrollLoadPage() {
         if ($('window_bar_height')) {
           if (typeof($('window_bar_height').offsetParent) != 'undefined') {
             var elementPostionY = $('window_bar_height').offsetTop;
           } else {
             var elementPostionY = $('window_bar_height').y;
           }
           if (elementPostionY <= window.getScrollTop() + (window.getSize().y - 20)) {
             if ((totalCount != currentPageNumber) && (totalCount != 0))
               viewMore();
           }
         }
       }
       //if ((totalCount != currentPageNumber) && (totalCount != 0))
       window.onscroll = doOnScrollLoadPage;
    }
  }
  
  function nextResult() {
    return <?php echo sprintf('%d', $this->paginator->getCurrentPageNumber() + 1) ?>
  }

  function viewMore() {
    
    if(document.getElementById('view_more'))
    document.getElementById('view_more').style.display = 'none';  
  
    document.getElementById('loading_image').style.display = '';
    
    en4.core.request.send(new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + 'seschristmas/welcome/wishes/',
      'data': {
        format: 'html',
        page: nextResult(),
        viewmore: 1        
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {      
        
        document.getElementById('member_wishes').innerHTML = document.getElementById('member_wishes').innerHTML + responseHTML;
        document.getElementById('view_more').destroy();        
        document.getElementById('loading_image').style.display = 'none';
        document.getElementById('loading_image').destroy();
      }
    }));
    return false;
  }
</script>

<?php if (empty($this->viewmore)): ?>
  <div class="seschristmas_wish_board" id="member_wishes"> 
      <?php if($this->viewer_id && empty($this->has_wish)): ?>
        <div class="seschristmas_button_wrap">
          <?php echo $this->htmlLink(array('route' => 'seschristmas_general', 'module' => 'seschristmas', 'controller' => 'welcome', 'action' => 'create', 'format' => 'smoothbox'), $this->translate('Make a Wish'), array('onclick' => 'smoothbox_ajax(this);return false', 'class' => 'seschristmas_button')) ?>
        </div>
      <?php endif; ?>
      <?php if(!empty($this->has_wish) && $this->viewer_id == $this->owner_id): ?>
        <div class="seschristmas_button_wrap">
          <?php echo $this->htmlLink(array('route' => 'seschristmas_general', 'action' => 'edit', 'christmas_id' => $this->has_wish), $this->translate('Edit your Wish'), array('onclick' => 'smoothbox_ajax(this);return false', 'class' => 'seschristmas_button')) ?>
        </div>
      <?php endif; ?>
    <?php endif; ?>
    <?php if (count($this->paginator) > 0) : ?>
      <?php foreach ($this->paginator as $wish): ?>
    	<div class="seschristmas_wish_list ">
        <div class="seschristmas_wish_list_inner">
          <div class='seschristmas_wish_txt'>
            <?php echo $this->string()->truncate($this->string()->stripTags($wish->description), 500) ?>
          </div>
          <div class='seschristmas_wish_list_btm'>
            <?php echo $this->htmlLink($wish->getOwner()->getHref(), $this->itemPhoto($wish->getOwner(), 'thumb.icon')) ?>
            <div class="seschristmas_wish_list_btm_info">
              <div class="seschristmas_wish_list_name">
                <?php echo $this->htmlLink($wish->getOwner()->getHref(), $wish->getOwner()->getTitle()) ?>
              </div>
              <div class="seschristmas_wish_list_date">
                <?php echo $this->timestamp(strtotime($wish->creation_date)); ?>
                
                <?php if($this->viewer_id == $wish->owner_id): ?>
                  <?php echo $this->htmlLink(array('route' => 'seschristmas_general', 'action' => 'edit', 'christmas_id' => $wish->getIdentity()), $this->translate(''), array('onclick' => 'smoothbox_ajax(this);return false', 'class' => 'seschristmas_icon seschristmas_icon_edit')) ?>
                  <?php echo $this->htmlLink(array('route' => 'seschristmas_general', 'action' => 'delete', 'christmas_id' => $wish->getIdentity(), 'format' => 'smoothbox'), $this->translate(''), array('onclick' => 'smoothbox_ajax(this);return false', 'class' => 'seschristmas_icon seschristmas_icon_delete')) ?>
              <?php endif; ?>
              </div>
            </div>
        </div>    
        </div>
    	</div>
      <?php endforeach; ?>
    <?php else : ?>
      <div class="tip">
        <span>
          <?php echo $this->translate('There are currently no wishes.');?>
        </span>
      </div>
    <?php endif; ?>
    <?php if (!empty($this->paginator) && $this->paginator->count() > 1): ?>
      <?php if ($this->paginator->getCurrentPageNumber() < $this->paginator->count()): ?>
        <?php if($this->showviewmore == 2) : ?>
        <div class="clr" id="window_bar_height"></div>
        <?php endif; ?>
        <div class="sesbasic_view_more" id="view_more" onclick="viewMore();" >
          <?php echo $this->htmlLink('javascript:void(0);', $this->translate('View More'), array('id' => 'feed_viewmore_link', 'class' => 'buttonlink icon_viewmore')); ?>
        </div>
        <div class="sesbasic_view_more_loading" id="loading_image" style="display: none;">
          <img src='<?php echo $this->layout()->staticBaseUrl ?>application/modules/Core/externals/images/loading.gif' />
          <span><?php echo $this->translate("Loading ...") ?></span>
        </div>
  <?php endif; ?>
<?php endif; ?>
<?php if (empty($this->viewmore)): ?>
  </div>
<?php endif; ?>
<script type="text/javascript" >
	function smoothbox_ajax(thisobj) {
		var Obj_Url = thisobj.href ;
		Smoothbox.open(Obj_Url);
	}
</script>
<script type="text/javascript">
  $$('.core_main_seschristmas').getParent().addClass('active');
</script>
