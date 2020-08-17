<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesforum/externals/styles/styles.css'); ?>
<?php if(isset($this->identityForWidget) && !empty($this->identityForWidget)):?>
	<?php $randonNumber = $this->identityForWidget;?>
<?php else:?>
	<?php $randonNumber = $this->identity; ?>
<?php endif;?>
<?php $moduleName = 'sesforum';?>

<?php $user = $this->subject; ?>
<?php if(!$this->is_ajax){  ?>
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
              <?php if(isset($this->topic)) { ?> 
                <span class="_title sesbasic_text_light"><?php echo $this->translate('%1$s', $topic->__toString()) ?></span>
              <?php } ?>
              <?php if(isset($this->creationDetails)) { ?> 
                <span class="sesbasic_text_light sesbasic_font_small"><?php echo $this->locale()->toDateTime(strtotime($post->creation_date));?></span>
              <?php } ?>
            </div>
            <div class="_right sesbasic_text_light">
              <?php if(isset($this->likeCount)) { ?> 
                <span title="<?php echo $this->translate(array('%s like', '%s likes', $post->like_count), $this->locale()->toNumber($post->like_count)); ?>"><i class="sesbasic_icon_like_o"></i> <?php echo $post->like_count ?></span>
              <?php } ?>
                <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesforum.thanks', 1) && isset($this->thanksCount)) { ?>
                <?php $thanks = Engine_Api::_()->getDbTable('thanks', 'sesforum')->getAllUserThanks($post->user_id); ?>
                <span title="<?php echo $this->translate(array('%s thank(s)', '%s thank(s)', $thanks), $this->locale()->toNumber($thanks)); ?>"><i class="sesforum_icon_thanks"></i> <?php echo $thanks; ?></span>
              <?php } ?>
            </div>
          </div> 
          <div class="sesforum_profile_post_item_body">
          
            <?php if( $this->decode_bbcode ) {
               if(strlen(nl2br($this->BBCode($post->body))) > $this->title_truncation_limit):
                  $title = mb_substr(nl2br($this->BBCode($post->body)),0,$this->title_truncation_limit).'...';
                      echo $title;
                   else: 
                      echo nl2br($this->BBCode($post->body));
                  endif;
              
            } else {
              if(strlen($post->getDescription()) > $this->title_truncation_limit):
                  $title = mb_substr($post->getDescription(),0,$this->title_truncation_limit).'...';
                      echo $title;
                   else: 
                      echo $post->getDescription();
                  endif;
            } ?>
            <?php if( $post->edit_id ): ?>
            	<p><i><?php echo $this->translate('This post was edited by %1$s at %2$s', $this->user($post->edit_id)->__toString(), $this->locale()->toDateTime(strtotime($post->creation_date))); ?></i><?php endif;?>
          </div>
          <?php if($post->file_id ): ?>
            <div class="sesforum_profile_post_item_photos">
              <?php echo $this->itemPhoto($post, null, '', array('class'=>'sesforum_post_photo'));?>
            </div>
          <?php endif;?>
      	</article>    
      </li>
    <?php endforeach;?>
<?php if(!$this->is_ajax){  ?>
    </ul>
    <div class="sesbasic_clearfix">
        <?php if($this->load_content != 'pagging'): ?>
            <div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" > <?php echo $this->htmlLink('javascript:void(0);', $this->translate('View More'), array('id' => "feed_viewmore_link_$randonNumber", 'class' => 'buttonlink icon_viewmore sesbasic_animation sesbasic_link_btn')); ?> </div>
            <div class="sesbasic_view_more_loading sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"> <img src="<?php echo $this->layout()->staticBaseUrl; ?>application/modules/Sesbasic/externals/images/loading.gif" /> </div>
        <?php endif;?>
    </div>
<?php } ?>
<?php if(!$this->is_ajax){  ?>
  </div>
<?php } ?>
<script type="text/javascript">
  
</script>
<script type="text/javascript">

    var isSearch = false;
		var defaultOpenTab = '<?php echo $this->defaultOpenTab; ?>';
		var requestViewMore_<?php echo $randonNumber; ?>;
		var params<?php echo $randonNumber; ?> = <?php echo json_encode($this->params); ?>;
		var identity<?php echo $randonNumber; ?>  = '<?php echo $randonNumber; ?>';
		var page<?php echo $randonNumber; ?> = '<?php echo $this->page + 1; ?>';
		var searchParams<?php echo $randonNumber; ?> ;
		var is_search_<?php echo $randonNumber;?> = 0;
		<?php if($this->load_content != 'pagging'){ ?>
			viewMoreHide_<?php echo $randonNumber; ?>();	
			function viewMoreHide_<?php echo $randonNumber; ?>() {
				if ($('view_more_<?php echo $randonNumber; ?>'))
				$('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->paginator->count() == 0 ? 'none' : ($this->paginator->count() == $this->paginator->getCurrentPageNumber() ? 'none' : '' )) ?>";
			}
			function viewMore_<?php echo $randonNumber; ?> (){ 
				sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').hide();
				sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').show(); 
				var openTab_<?php echo $randonNumber; ?> = '<?php echo $this->defaultOpenTab; ?>';
				requestViewMore_<?php echo $randonNumber; ?> = new Request.HTML({
					method: 'post',
					'url': en4.core.baseUrl + "widget/index/mod/"+"<?php echo $moduleName;?>"+"/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
					'data': {
						format: 'html',
						page: page<?php echo $randonNumber; ?>,    
						params : params<?php echo $randonNumber; ?>,
						is_ajax : 1,
						is_search:is_search_<?php echo $randonNumber;?>,
						view_more:1,
						identity : '<?php echo $randonNumber; ?>',
					},
					onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
						if($('loading_image_<?php echo $randonNumber; ?>'))
						sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').hide();
						if(!isSearch) { 
							document.getElementById('forums-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('forums-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
						} 
						else {
							document.getElementById('forums-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('forums-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
							oldMapData_<?php echo $randonNumber; ?> = [];
							isSearch = false;
						}
					}
				});
				requestViewMore_<?php echo $randonNumber; ?>.send();
				return false;
			}
		<?php }  ?>
    var requestTab_<?php echo $randonNumber; ?>;
    var valueTabData ;
    // globally define available tab array
    var requestTab_<?php echo $randonNumber; ?>;
		<?php if($this->load_content == 'auto_load'){ ?>
			window.addEvent('load', function() {
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
