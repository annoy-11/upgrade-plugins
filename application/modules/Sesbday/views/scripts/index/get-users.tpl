<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbday
 * @package    Sesbday
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: get-users.tpl  2018-12-20 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<script type="text/javascript">
Sessmoothbox.css.push("<?php echo $this->layout()->staticBaseUrl . 'application/modules/Sesbday/externals/styles/styles.css'; ?>");
  function viewMore() {
    if ($('view_more'))
    $('view_more').style.display = "<?php echo ( $this->paginator->count() == $this->paginator->getCurrentPageNumber() || $this->count == 0 ? 'none' : '' ) ?>";       
    document.getElementById('view_more').style.display = 'none';
    document.getElementById('loading_image').style.display = '';
    (new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + 'sesbday/index/get-users/',
      'data': {
        format: 'html',
        page: "<?php echo sprintf('%d', $this->paginator->getCurrentPageNumber() + 1) ?>",
        viewmore: 1,
				params:"<?php echo $this->currentDay; ?>",     
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
				document.getElementById('view_more').destroy();
				document.getElementById('loading_image').destroy();
        document.getElementById('like_results').innerHTML = document.getElementById('like_results').innerHTML + responseHTML;
				resizesessmoothbox();
      }
    })).send();
    return false;
  }
<?php if(empty($this->viewmoreT) && empty($this->viewmore)) { ?>
sesJqueryObject(document).on('click','#selectedDay',function(){
	sesJqueryObject(this).addClass('disabled');
	var that = this;
	var params = sesJqueryObject(this).attr('rel');
(new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + 'sesbday/index/get-users/',
      'data': {
        format: 'html',
        page: "1",
				params:params,
				viewmoreT:1,
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
				sesJqueryObject(that).removeClass('disabled');
			 if(document.getElementById('view_more'))
			  document.getElementById('view_more').destroy();
			 if(document.getElementById('loading_image'))
				document.getElementById('loading_image').destroy();
        document.getElementById('sessmoothbox_container').innerHTML = responseHTML;
				resizesessmoothbox();
      }
    })).send();
    return false;	
})
<?php } ?>
</script>
<?php if (empty($this->viewmore)){ ?>
  <div class="sesbday_list_popup sesbasic_bxs sesbasic_clearfix">
    <div class="sesbday_list_popup_header sesbm">
      <?php echo date('l, F j, Y',strtotime($this->currentDay)); ?>
    </div>
    <div class="sesbday_list_popup_top_btns sesbasic_clearfix sesbm">    
      <!-- PREVIOUS DAY -->
      <?php $previousDay = date('Y-m-d H:i:s',strtotime('-1 day',strtotime($this->currentDay))); ?>
      <a href="javascript:;" id="selectedDay" rel="<?php echo date('Y-m-d',strtotime('-1 day',strtotime($this->currentDay))); ?>" class="sesbasic_button floatL "><i class="fa fa-angle-left"></i><?php echo $this->translate(date('l',strtotime($previousDay))).' '.date('j',strtotime($previousDay)); ?></a>
      <!-- NEXT DAY -->
      <?php $nextDay = date('Y-m-d H:i:s',strtotime('+1 day',strtotime($this->currentDay))); ?>
      <a href="javascript:;" id="selectedDay" rel="<?php echo date('Y-m-d',strtotime('+1 day',strtotime($this->currentDay))); ?>" class="sesbasic_button floatL"><?php echo $this->translate(date('l',strtotime($nextDay))).' '.date('j',strtotime($nextDay)); ?><i class="fa fa-angle-right right"></i></a>
    </div>
    <div id="like_results" class="sesbday_list_popup_content">
<?php } ?>
    <?php if (count($this->paginator) > 0) { ?>
      <?php foreach ($this->paginator as $value){ ?>
        <div class="item_list sesbm sesbasic_clearfix">
          <div class="item_list_thumb floatL">
            <?php echo $this->htmlLink($value->getHref(), $this->itemPhoto($value, 'thumb.profile'), array('title' => $value->getTitle(), 'target' => '_parent')); ?>
          </div>
          <div class="item_list_info">
            <div class="item_list_title">
              <?php echo $this->htmlLink($value->getHref(), $value->getTitle(), array('title' => $value->getTitle(), 'target' => '_parent')); ?>
            </div>
          </div>
        </div>
      <?php } ?> 
      <?php } else { ?>
        <div class="tip">
					<span><?php echo $this->translate("No birthday on the selected date."); ?></span>          
        </div>
      <?php }?>     
    <?php if (!empty($this->paginator) && $this->paginator->count() > 1){ ?>
      <?php if ($this->paginator->getCurrentPageNumber() < $this->paginator->count()){ ?>        
         <div class="sesbasic_load_btn" id="view_more" onclick="viewMore();" > 
  <?php echo $this->htmlLink('javascript:void(0);', $this->translate('View More'), array('id' => "feed_viewmore_link", 'class' => 'sesbasic_animation sesbasic_link_btn fa fa-repeat')); ?> </div>
  <div class="sesbasic_load_btn" id="loading_image" style="display: none;"><span class="sesbasic_link_btn"><i class="fa fa-spinner fa-spin"></i></span> </div>  
        
  <?php } ?>
    <?php } ?>
  <?php if (empty($this->viewmore)){ ?>
  	</div>
  </div>
<?php } ?>
<?php if($this->viewmoreT || $this->viewmore){ die;} ?>