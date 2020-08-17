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
<script type="text/javascript">
  en4.core.runonce.add(function(){

    <?php if( !$this->renderOne ): ?>
    var anchor = $('sesforum_topics').getParent().getParent();
    $('sesforum_topics_previous').style.display = '<?php echo ( $this->paginator->getCurrentPageNumber() == 1 ? 'none' : '' ) ?>';
    $('sesforum_topics_next').style.display = '<?php echo ( $this->paginator->count() == $this->paginator->getCurrentPageNumber() ? 'none' : '' ) ?>';

    $('sesforum_topics_previous').removeEvents('click').addEvent('click', function(){
      en4.core.request.send(new Request.HTML({
        url : en4.core.baseUrl + 'widget/index/content_id/' + <?php echo sprintf('%d', $this->identity) ?>,
        data : {
          format : 'html',
          subject : en4.core.subject.guid,
          is_ajax:1,
          page : <?php echo sprintf('%d', $this->paginator->getCurrentPageNumber() - 1) ?>
        }
      }), {
        'element' : anchor
      })
    });

    $('sesforum_topics_next').removeEvents('click').addEvent('click', function(){
      en4.core.request.send(new Request.HTML({
        url : en4.core.baseUrl + 'widget/index/content_id/' + <?php echo sprintf('%d', $this->identity) ?>,
        data : {
          format : 'html',
          subject : en4.core.subject.guid,
          is_ajax:1,
          page : <?php echo sprintf('%d', $this->paginator->getCurrentPageNumber() + 1) ?>
        }
      }), {
        'element' : anchor
      })
    });
    <?php endif; ?>
  });
</script>

<?php if(isset($this->identityForWidget) && !empty($this->identityForWidget)):?>
	<?php $randonNumber = $this->identityForWidget;?>
<?php else:?>
	<?php $randonNumber = $this->identity; ?>
<?php endif;?>
<?php $moduleName = 'sesforum';?>
 
<?php if(!$this->is_ajax){  ?>
<div id = "sesforum_topics_listing_<?php echo $randonNumber;?>">
<div class="sesforum_topics_listing sesbasic_bxs">
  <ul id="forums-widget_<?php echo $randonNumber;?>">
<?php } ?>

    <?php foreach( $this->paginator as $topic ):
      $last_post = $topic->getLastCreatedPost();
      if( $last_post ) {
        $last_user = $this->user($last_post->user_id);
      } else {
        $last_user = $this->user($topic->user_id);
      }
      ?>
        <li>
          <div class="sesforum_deatails">
            <div class="sesforum_owner">
              <?php echo $this->htmlLink($topic->getOwner()->getHref(), $this->itemPhoto($topic->getOwner(), 'thumb.icon')) ?>
            </div>
            <div class="sesforum_info">
            <?php 
                if(strlen($topic->getTitle()) > $this->title_truncation_limit):
                    $title = mb_substr($topic->getTitle(),0,$this->title_truncation_limit).'...';
                 else: 
                   $title = $topic->getTitle();
                endif;
            ?>
              <div class="_title<?php if( $topic->closed ): ?> closed<?php endif; ?><?php if( $topic->sticky ): ?> sticky<?php endif; ?>">
                <?php echo $this->htmlLink($topic->getHref(), $title);?>
              </div>
              <p class="sesforum_date sesbasic_font_small sesbasic_text_light">
                <?php if(isset($this->creationDetails)) { ?> 
                    <span><?php echo $this->timestamp($topic->creation_date); ?></span>
                <?php } ?>
                <?php if(isset($this->likeCount)) { ?> 
                    <span><i class="sesbasic_icon_like"></i> <?php echo $this->translate(array('%s like', '%s likes', $topic->like_count), $this->locale()->toNumber($topic->like_count)); ?></span>
              	<?php } ?>
                 <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesforum.rating', 1) && isset($this->rating)) { ?>
                  <span class="sesforum_rating_star">
                    <?php for( $x=1; $x<=$topic->rating; $x++ ): ?>
                      <span class="sesbasic_rating_star_small fa fa-star rating_star"></span>
                    <?php endfor; ?>
                    <?php if( (round($topic->rating) - $topic->rating) > 0): ?>
                      <span class="sesbasic_rating_star_small fa fa-star-half-o"></span>
                    <?php endif; ?>
                    <?php for( $x=5; $x>round($topic->rating); $x-- ): ?>
                      <span class="sesbasic_rating_star_small fa fa-star sesbasic_rating_star_small_disable"></span>
                    <?php endfor; ?>
                  </span>
                  <?php } ?>
              </p>
              <?php $valueTags = Engine_Api::_()->sesforum()->tagCloudItemCore('fetchAll',null,$topic->getIdentity()); ?>
              <?php if(isset($this->tags) && count($valueTags) > 0): ?> 
                <div class="sesbasic_tags" >
                  <?php foreach($valueTags as $valueTag): ?>
                    <a href="<?php echo $this->url(array('module' => 'sesforum', 'controller' => 'index', 'action' => 'search'), 'default', true).'?tag_id='.$valueTag['tag_id'].'&tag_name='.$valueTag['text']  ;?>" ><?php echo $valueTag['text'] ?></sup></a>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
              <p class="sesbasic_font_small"><?php echo $this->pageLinks($topic, $this->sesforum_topic_pagelength, null, 'sesforum_pagelinks') ?></p>
            </div>
          </div>
            <?php if(isset($this->viewsCount) || isset($this->repliesCount)) { ?>
          <div class="sesforum_stats">
           <?php if(isset($this->viewsCount)) { ?>
                <div class="sesforum_views">
                    <span>
                        <?php echo $this->translate(array('%1$s %2$s view', '%1$s %2$s views', $topic->view_count), $this->locale()->toNumber($topic->view_count), '</span><span class="_label sesbasic_text_light">') ?>
                    </span>
                </div>
             <?php } ?>
             <?php if(isset($this->repliesCount)) { ?>
                <div class="sesforum_replies">
                <span>
                    <?php echo $this->translate(array('%1$s %2$s reply', '%1$s %2$s replies', $topic->post_count-1), $this->locale()->toNumber($topic->post_count-1), '</span><span class="_label sesbasic_text_light">') ?>
                </span>
                </div>
             <?php } ?>
          </div>
         <?php } ?>
          <?php if(isset($this->latestPostDetails)) { ?>
          <div class="sesforum_lastpost">
          	<div class="sesforum_lastpost_owner_thumb">
            	<?php echo $this->htmlLink($last_post->getHref(), $this->itemPhoto($last_user, 'thumb.icon')) ?>
            </div>
            <div class="sesforum_topics_lastpost_info">
            	<div class="sesforum_lastpost_ownerinfo sesbasic_text_light sesbasic_font_small">
                <?php if( $last_post):
                  list($openTag, $closeTag) = explode('-----', $this->htmlLink($last_post->getHref(array('slug' => $topic->getSlug())), '-----'));
                  ?>
                  <?php echo $this->translate(
                    '%1$sLast post%2$s by %3$s',
                    $openTag,
                    $closeTag,
                    $this->htmlLink($last_user->getHref(), $last_user->getTitle())
                  )?>
                </div>
                <div class="sesforum_lastpost_post sesbasic_text_light sesbasic_font_small">
                	<?php echo $this->timestamp($topic->modified_date, array('class' => 'sesforum_topics_lastpost_date')) ?>
              	</div>
              <?php endif; ?>
          </div>
        </div>
        <?php } ?>
      </li>
    <?php endforeach; ?>
<?php if(!$this->is_ajax){  ?>
    </ul>
    <div class="sesbasic_clearfix">
        <?php if($this->load_content != 'pagging'): ?>
            <div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" > <?php echo $this->htmlLink('javascript:void(0);', $this->translate('View More'), array('id' => "feed_viewmore_link_$randonNumber", 'class' => 'buttonlink icon_viewmore sesbasic_animation sesbasic_link_btn')); ?> </div>
            <div class="sesbasic_view_more_loading sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"> <img src="<?php echo $this->layout()->staticBaseUrl; ?>application/modules/Sesbasic/externals/images/loading.gif" /> </div>
        <?php endif;?>
    </div>
</div>

<?php } ?>
<?php if(!$this->is_ajax){  ?>
</div>
<?php } ?>
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
		<?php } ?>
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
