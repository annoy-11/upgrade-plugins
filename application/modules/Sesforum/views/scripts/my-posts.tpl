<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my-posts.tpl 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if($this->paginator->getTotalItemCount() > 0) { ?>
<?php if(!$this->request_ajax){  ?>
<div class="sesforum_profile_posts">
  <ul id="forums-widget_<?php echo $randonNumber;?>">
<?php } ?>
    <?php foreach( $this->paginator as $post ):
      if( !isset($signature) ) $signature = $post->getSignature();
      $topic = $post->getParent();
      $sesforum = $topic->getParent();
      ?>
      <li class="sesforum_profile_post_item">
      	<article>
        	<div class="sesforum_profile_post_header">
          	<div class="_left">
             <span class="_title sesbasic_text_light"><?php echo $this->translate('in the topic %1$s', $topic->__toString()) ?></span>
             <span class="sesbasic_text_light sesbasic_font_small"><?php echo $this->locale()->toDateTime(strtotime($post->creation_date));?></span>
            </div>
            <div class="_right sesbasic_text_light">
              <span title="<?php echo $this->translate(array('%s like', '%s likes', $post->like_count), $this->locale()->toNumber($post->like_count)); ?>"><i class="sesbasic_icon_like_o"></i> <?php echo $post->like_count ?></span>
              <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesforum.thanks', 1)) { ?>
              <?php $thanks = Engine_Api::_()->getDbTable('thanks', 'sesforum')->getAllUserThanks($post->user_id); ?>
              	<span title="<?php echo $this->translate(array('%s thank(s)', '%s thank(s)', $thanks), $this->locale()->toNumber($thanks)); ?>"><i class="sesforum_icon_thanks"></i> <?php echo $thanks; ?></span>
              <?php } ?>
            </div>
          </div>  
          <div class="sesforum_profile_post_item_body">
            <?php if( $this->decode_bbcode ) {
              echo nl2br($this->BBCode($post->body));
            } else {
              echo $post->getDescription();
            } ?>
            <?php if( $post->edit_id ): ?>
              <i>
                <?php echo $this->translate('This post was edited by %1$s at %2$s', $this->user($post->edit_id)->__toString(), $this->locale()->toDateTime(strtotime($post->creation_date))); ?>
              </i>
            <?php endif;?>
          </div>
          <?php if( $post->file_id ): ?>
            <div class="sesforum_profile_post_item_photos">
              <?php echo $this->itemPhoto($post, null, '', array('class'=>'sesforum_post_photo'));?>
            </div>
          <?php endif;?>
        </article>
      </li>
    <?php endforeach;?>
<?php if(!$this->request_ajax){  ?>
  </ul>
</div>
<?php } ?>
<?php } else { ?>
  <?php if(!$this->request_ajax){  ?>
    <div class="tip">
      <span><?php echo $this->translate('There are no posts.') ?></span>
    </div>
  <?php } ?>
<?php } ?>
<script>
    var isSearch = false;
		var defaultOpenTab = '<?php echo $this->defaultOpenTab; ?>';
		var requestViewMore_<?php echo $randonNumber; ?>;
		var params<?php echo $randonNumber; ?> = <?php echo json_encode($this->params); ?>;
		var identity<?php echo $randonNumber; ?>  = '<?php echo $randonNumber; ?>';
    var liked<?php echo $randonNumber; ?>  = '<?php echo $this->liked; ?>';
		var page<?php echo $randonNumber; ?> = '<?php echo $this->page + 1; ?>';
		var searchParams<?php echo $randonNumber; ?> ;
		<?php if($this->load_content != 'pagging'){ ?>
			viewMoreHide_<?php echo $randonNumber; ?>();	
			function viewMoreHide_<?php echo $randonNumber; ?>() {
				if ($('view_more_<?php echo $randonNumber; ?>'))
				$('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->paginator->count() == 0 ? 'none' : ($this->paginator->count() == $this->paginator->getCurrentPageNumber() ? 'none' : '' )) ?>";
			}
			function viewMore_<?php echo $randonNumber; ?> (){ 
				sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').hide();
				sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').show();
        requestViewMore_<?php echo $randonNumber; ?> = (new Request.HTML({
					method: 'post',
					'url': en4.core.baseUrl + "widget/index/mod/"+"<?php echo $moduleName; ?>"+"/name/<?php echo $this->widgetName; ?>/openTab/",
					'data': {
						format: 'html',
						params : params<?php echo $randonNumber; ?>,
						liked : liked<?php echo $randonNumber; ?>,
						request_ajax : 1,
            is_ajax : 1,
            page: page<?php echo $randonNumber; ?>,    
						type:'<?php echo $this->view_type; ?>',
						identity : '<?php echo $randonNumber; ?>',
					},
					onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
						if($('loading_image_<?php echo $randonNumber; ?>'))
                sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').hide();
						sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','none'); 
						document.getElementById('forums-widget_<?php echo $randonNumber; ?>').innerHTML =  document.getElementById('forums-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
						if(isSearch){
							oldMapData_<?php echo $randonNumber; ?> = [];
							isSearch = false;
						}
					}
				}));
				requestViewMore_<?php echo $randonNumber; ?>.send();
				return false;
			}
		<?php } ?>
		  var requestTab_<?php echo $randonNumber; ?>;
    var valueTabData ;
    // globally define available tab array
    var requestTab_<?php echo $randonNumber; ?>;
		<?php if($this->load_content == 'auto_load'){ ?>
			window.addEvent('load', function() {
        function viewMoreHide_<?php echo $randonNumber; ?>() {
            if ($('view_more_<?php echo $randonNumber; ?>'))
            $('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->paginator->count() == 0 ? 'none' : ($this->paginator->count() == $this->paginator->getCurrentPageNumber() ? 'none' : '' )) ?>";
        }
        viewMoreHide_<?php echo $randonNumber; ?>();	
				sesJqueryObject(window).scroll( function() {
					var heightOfContentDiv_<?php echo $randonNumber; ?> = sesJqueryObject('#forums-widget_<?php echo $randonNumber; ?>').offset().top;
					var fromtop_<?php echo $randonNumber; ?> = sesJqueryObject(this).scrollTop();
					if(fromtop_<?php echo $randonNumber; ?> > heightOfContentDiv_<?php echo $randonNumber; ?> - 100 && sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').css('display') == 'block' ){
						document.getElementById('feed_viewmore_link_<?php echo $randonNumber; ?>').click();
					}
				});
			});
<?php } ?>
</script>
