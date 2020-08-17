<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/customscrollbar.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); ?>

<?php if(isset($this->identityForWidget) && !empty($this->identityForWidget)):?>
	<?php $randonNumber = $this->identityForWidget;?>
<?php else:?>
	<?php $randonNumber = $this->identity;?>
<?php endif;?>

<?php if(!$this->is_ajax):?>
  <div id="scrollHeightDivSes_<?php echo $randonNumber;?>" class="sesbasic_bxs"> 
		<div id="category-article-widget_<?php echo $randonNumber; ?>" class="sesbasic_clearfix">
<?php endif;?>
  <?php foreach( $this->paginatorCategory as $item): ?>
  	<div class="sesarticle_category_article sesbasic_clearfix">
      <div class="sesarticle_category_header sesbasic_clearfix">
        <p class="floatL"><a href="<?php echo $item->getBrowseArticleHref(); ?>?category_id=<?php echo $item->category_id ?>" title="<?php echo $item->category_name; ?>"><?php echo $item->category_name; ?></a></p>
				<?php if(isset($this->seemore_text) && $this->seemore_text != ''): ?>
					<span <?php echo $this->allignment_seeall == 'right' ?  'class="floatR"' : ''; ?>><a  class="sesbasic_link_btn" href="<?php echo $item->getBrowseArticleHref(); ?>?category_id=<?php echo $item->category_id ?>"><?php $seemoreTranslate = $this->translate($this->seemore_text); ?>
					<?php echo str_replace('[category_name]',$item->category_name,$seemoreTranslate); ?></a></span>
				<?php endif;?>
      </div>
      <?php if(isset($this->resultArray['article_data'][$item->category_id])):?>
        <?php $bigBlg = 0;?>
        <?php	foreach($this->resultArray['article_data'][$item->category_id] as $item):?>
            <?php if(!$bigBlg):?>
            <div class="sesarticle_category_item_single" style="width:<?php echo $this->width; ?>px;height:<?php echo $this->width; ?>px;">
              <div class="sesarticle_category_item_single_info">
                <div class="sesarticle_entry_img" >
                  <a href="<?php echo $item->getHref();?>"><img style="width:<?php echo $this->width; ?>px;height:<?php echo $this->width; ?>px;" src="<?php echo $item->getPhotoUrl('thumb.main'); ?>" /></a>
                </div>
                <div class="sesarticle_category_item_single_content">
                <?php if(isset($this->titleActive)): ?>
                  <p class="title"><a href="<?php echo $item->getHref();?>"><?php echo $item->getTitle(); ?></a></p>
                <?php endif;?>
                <?php if(isset($this->byActive)): ?>
                  <p class="entry_owner">
                    <?php $owner = $item->getOwner(); ?>
                    <?php echo $this->translate('By');?> <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle()) ?>
                  </p>
                <?php endif; ?>
                <?php if(Engine_Api::_()->getApi('core', 'sesarticle')->allowReviewRating() && isset($this->ratingStarActive)):?>
                  <?php echo $this->partial('_articleRating.tpl', 'sesarticle', array('rating' => $item->rating, 'class' => 'sesarticle_list_rating sesarticle_list_view_ratting', 'style' => 'margin-bottom:0px;'));?>
                <?php endif;?>
                <div class="entry_meta">
                  <?php if(isset($this->creationDateActive)):?>
                    <div class="entry_meta-date floatL"><?php echo date('M d, Y',strtotime($item->publish_date));?></div>
                  <?php endif;?>
                  <div class="entry_meta-comment floatR">
                    <?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
                      <span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $item->like_count; ?></span>
                    <?php } ?>
                    <?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>
                      <span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment"></i><?php echo $item->comment_count;?></span>
                    <?php } ?>
                    <?php if(isset($this->favouriteActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.favourite', 1)) { ?>
                      <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart"></i><?php echo $item->favourite_count;?></span>
                    <?php } ?>
                    <?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
                      <span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye"></i><?php echo $item->view_count; ?></span>
                    <?php } ?>
                    <?php include APPLICATION_PATH .  '/application/modules/Sesarticle/views/scripts/_articleRatingStat.tpl';?>
                  </div>
                </div>
                <?php if(isset($this->readmoreActive)):?>
                  <div class="entry_more clear"><a href="<?php echo $item->getHref();?>"><?php echo $this->translate("Read More");?> &raquo;</a></div>
                <?php endif; ?>
              </div>
              </div>
            </div>
            <div class="sesarticle-category_item_list sesbasic_custom_scroll">
            <?php else:?>
              <div class="sesarticle_category_item sesbasic_clearfix">
                <div class="wrapper_list sesbasic_clearfix">
                  <div class="sesarticle_entry_img">
                    <a href="<?php echo $item->getHref();?>"><img src="<?php echo $item->getPhotoUrl('thumb.main'); ?>" /></a>
                  </div>
                  <div class="sesarticle_entry_info">
                    <?php if(isset($this->titleActive)):?>
                      <p class="title"><a href="<?php echo $item->getHref();?>"><?php echo $item->getTitle();?></a></p>          
                    <?php endif;?>
                    <?php if(isset($this->byActive)): ?>
                      <p class="entry_owner">
                        <?php $owner = $item->getOwner(); ?>
                        <?php echo $this->translate('By');?> <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle()) ?>
                      </p>
                    <?php endif; ?>
                    <?php if(Engine_Api::_()->getApi('core', 'sesarticle')->allowReviewRating() && isset($this->ratingStarActive)):?>
                      <?php echo $this->partial('_articleRating.tpl', 'sesarticle', array('rating' => $item->rating, 'class' => 'sesarticle_list_rating sesarticle_list_view_ratting', 'style' => 'margin-bottom:0px;'));?>
                    <?php endif;?>
                    <div class="entry_meta">
                      <?php if(isset($this->creationDateActive)):?>
                        <div class="entry_meta-date floatL">
                          <?php echo date('M d, Y',strtotime($item->publish_date));?>
                        </div>
                      <?php endif; ?>
                      <div class="entry_meta-comment floatR">
                        <?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
                          <span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $item->like_count; ?></span>
                        <?php } ?>
                        <?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>
                          <span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment"></i><?php echo $item->comment_count;?></span>
                        <?php } ?>
                        <?php if(isset($this->favouriteActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.favourite', 1)) { ?>
                          <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart"></i><?php echo $item->favourite_count;?></span>
                        <?php } ?>
                        <?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
                          <span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye"></i><?php echo $item->view_count; ?></span>
                        <?php } ?>
                        <?php include APPLICATION_PATH .  '/application/modules/Sesarticle/views/scripts/_articleRatingStat.tpl';?>
                      </div>
                  	</div>
                    <?php if(isset($this->readmoreActive)):?>
                    	<div class="entry_more clear"><a href="<?php echo $item->getHref();?>"><?php echo $this->translate("Read More");?> &raquo;</a></div>
                    <?php endif; ?>
                  </div>
                </div>
                </div>
            <?php endif;?>
          <?php $bigBlg++;?>
        <?php endforeach;?>
        <?php $bigBlg = 0;?>
      <?php endif;?>
      </div>
		</div>
  <?php endforeach;?>
	<?php if($this->paginatorCategory->getTotalItemCount() == 0 && !$this->is_ajax):?>
		<div class="tip">
			<span>
				<?php echo $this->translate('Nobody has created an article yet.');?>
				<?php if ($this->can_create):?>
					<?php echo $this->translate('Be the first to %1$screate%2$s one!', '<a href="'.$this->url(array('action' => 'create','module'=>'sesarticle'), "sesarticle_general",true).'">', '</a>'); ?>
				<?php endif; ?>
			</span>
		</div>
	<?php endif; ?> 
	<?php if($this->loadOptionData == 'pagging'): ?>
		<?php echo $this->paginationControl($this->paginatorCategory, null, array("_pagging.tpl", "sesarticle"),array('identityWidget'=>$randonNumber)); ?>
	<?php endif; ?>
<?php if(!$this->is_ajax){ ?>
		</div>
	</div>
	<?php if($this->loadOptionData != 'pagging') { ?>
		<div class="sesbasic_view_more" id="view_more_<?php echo $randonNumber; ?>" onclick="viewMore_<?php echo $randonNumber; ?>();" > <?php echo $this->htmlLink('javascript:void(0);', $this->translate('View More'), array('id' => "feed_viewmore_link_$randonNumber", 'class' => 'buttonlink icon_viewmore')); ?> </div>
		<div class="sesbasic_view_more_loading" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"> <img src="<?php echo $this->layout()->staticBaseUrl; ?>application/modules/Sesbasic/externals/images/loading.gif" /> </div>
	<?php  } ?>
<?php } ?>

<script type="text/javascript">
	<?php if($this->loadOptionData == 'auto_load'){ ?>
		window.addEvent('load', function() {
			sesJqueryObject(window).scroll( function() {
				var heightOfContentDiv_<?php echo $randonNumber; ?> = sesJqueryObject('#scrollHeightDivSes_<?php echo $randonNumber; ?>').offset().top;
				var fromtop_<?php echo $randonNumber; ?> = sesJqueryObject(this).scrollTop();
				if(fromtop_<?php echo $randonNumber; ?> > heightOfContentDiv_<?php echo $randonNumber; ?> - 100 && sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').css('display') == 'block' ){
					document.getElementById('feed_viewmore_link_<?php echo $randonNumber; ?>').click();
				}
			});
		});
	<?php } ?>
	viewMoreHide_<?php echo $randonNumber; ?>();
	function viewMoreHide_<?php echo $randonNumber; ?>() {
		if ($('view_more_<?php echo $randonNumber; ?>'))
		$('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->paginatorCategory->count() == 0 ? 'none' : ($this->paginatorCategory->count() == $this->paginatorCategory->getCurrentPageNumber() ? 'none' : '' )) ?>";
	}
	function viewMore_<?php echo $randonNumber; ?> (){
		document.getElementById('view_more_<?php echo $randonNumber; ?>').style.display = 'none';
		document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = '';    
		en4.core.request.send(new Request.HTML({
			method: 'post',
			'url': en4.core.baseUrl + "widget/index/mod/sesarticle/name/<?php echo $this->widgetName; ?>",
			'data': {
			format: 'html',
			page: <?php echo $this->page + 1; ?>,    
			params :'<?php echo json_encode($this->params); ?>', 
			is_ajax : 1,
			identity : '<?php echo $randonNumber; ?>',
			},
			onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
				document.getElementById('category-article-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('category-article-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
				document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';
        jqueryObjectOfSes(".sesbasic_custom_scroll").mCustomScrollbar({
          theme:"minimal-dark"
          });
        
			}
		}));
		return false;
	}
	<?php if(!$this->is_ajax){ ?>
		function paggingNumber<?php echo $randonNumber; ?>(pageNum){
			sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','block');
			en4.core.request.send(new Request.HTML({
				method: 'post',
				'url': en4.core.baseUrl + "widget/index/mod/sesarticle/name/<?php echo $this->widgetName; ?>",
				'data': {
					format: 'html',
					page: pageNum,    
					params :'<?php echo json_encode($this->params); ?>', 
					is_ajax : 1,
					identity : '<?php echo $randonNumber; ?>',
					type:'<?php echo $this->view_type; ?>'
				},
				onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
					sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','none');
					document.getElementById('category-article-widget_<?php echo $randonNumber; ?>').innerHTML =  responseHTML;
          jqueryObjectOfSes(".sesbasic_custom_scroll").mCustomScrollbar({
          theme:"minimal-dark"
          });
					dynamicWidth();
				}
			}));
			return false;
		}
	<?php } ?>
</script>