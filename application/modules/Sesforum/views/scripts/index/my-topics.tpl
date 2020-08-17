<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my-topics.tpl 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if($this->paginator->getTotalItemCount() > 0) { ?>
<div class="sesforum_topics_listing sesbasic_bxs">
  <ul id="sesforum_topics">
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
              <div class="_title<?php if( $topic->closed ): ?> closed<?php endif; ?><?php if( $topic->sticky ): ?> sticky<?php endif; ?>">
                <?php echo $this->htmlLink($topic->getHref(), $topic->getTitle());?>
              </div>
              <p class="sesforum_date sesbasic_font_small sesbasic_text_light">
                <span><?php echo $this->timestamp($topic->creation_date); ?></span>
              	<span><i class="sesbasic_icon_like"></i> <?php echo $this->translate(array('%s like', '%s likes', $topic->like_count), $this->locale()->toNumber($topic->like_count)); ?></span>
              	<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesforum.rating', 1)) { ?>
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
              <p class="sesbasic_font_small"><?php echo $this->pageLinks($topic, $this->sesforum_topic_pagelength, null, 'sesforum_pagelinks') ?></p>
            </div>
          </div>
          <div class="sesforum_stats">
            <div class="sesforum_views">
              <span>
                <?php echo $this->translate(array('%1$s %2$s view', '%1$s %2$s views', $topic->view_count), $this->locale()->toNumber($topic->view_count), '</span><span class="_label sesbasic_text_light">') ?>
              </span>
            </div>
            <div class="sesforum_replies">
              <span>
                <?php echo $this->translate(array('%1$s %2$s reply', '%1$s %2$s replies', $topic->post_count-1), $this->locale()->toNumber($topic->post_count-1), '</span><span class="_label sesbasic_text_light">') ?>
              </span>
            </div>
          </div>

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
      </li>
    <?php endforeach; ?>
  </ul>
</div>
<?php } else { ?>
  <div class="tip">
    <span>
      <?php echo $this->translate('There are no topics.') ?>
    </span>
  </div>
<?php } ?>

<script>
en4.core.runonce.add(function() {
  changeTabContent('my-topics');
});
		var defaultOpenTab = '<?php echo $this->defaultOpenTab; ?>';
		var requestViewMore_<?php echo $randonNumber; ?>;
		var params<?php echo $randonNumber; ?> = <?php echo json_encode($this->params); ?>;
		var identity<?php echo $randonNumber; ?>  = '<?php echo $randonNumber; ?>';
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
				 sendRequest(selectedTab,data);
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
