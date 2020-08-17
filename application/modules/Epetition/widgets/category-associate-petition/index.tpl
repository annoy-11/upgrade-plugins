<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/customscrollbar.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); ?>
<?php $allsetting = $this->allParams;  ?>
<?php if (isset($this->identityForWidget) && !empty($this->identityForWidget)): ?>
	<?php $randonNumber = $this->identityForWidget; ?>
<?php else: ?>
	<?php $randonNumber = $this->identity; ?>
<?php endif; ?>
<?php if (!$this->is_ajax): ?>
<div id="scrollHeightDivSes_<?php echo $randonNumber; ?>" class="sesbasic_bxs">
    <div id="category-petition-widget_<?php echo $randonNumber; ?>" class="sesbasic_clearfix">
			<?php endif; ?>
			<?php foreach ($this->paginatorCategory as $item): ?>
          <div class="epetition_category_petition sesbasic_clearfix">
              <div class="epetition_category_header sesbasic_clearfix">
                  <p class="floatL"><a
                              href="<?php echo $item->getBrowsePetitionHref(); ?>?category_id=<?php echo $item->category_id ?>"
                              title="<?php echo $this->translate($item->category_name); ?>"><?php echo $this->translate($item->category_name); ?></a>
                  </p>
								<?php if (isset($this->seemore_text) && $this->seemore_text != ''): ?>
                    <span <?php echo $this->allignment_seeall == 'right' ? 'class="floatR"' : ''; ?>><a
                                class="sesbasic_link_btn"
                                href="<?php echo $item->getBrowsePetitionHref(); ?>?category_id=<?php echo $item->category_id ?>"><?php $seemoreTranslate = $this->translate($this->seemore_text); ?>
												<?php echo str_replace('[category_name]', $this->translate($item->category_name), $seemoreTranslate); ?></a></span>
								<?php endif; ?>
              </div>


						<?php if (isset($this->resultArray['petition_data'][$item->category_id])): ?>
						<?php $bigBlg = 0; ?>
						<?php foreach ($this->resultArray['petition_data'][$item->category_id] as $item): ?>
						<?php $categorycount = Engine_Api::_()->getDbTable('categories', 'epetition')->getCategory(array('category_id'=>$item->category_id,'countPetitions'=>1,'criteria'=>'most_petition'));    ?>
						<?php if (!$bigBlg): ?>
              <div class="epetition_category_item_single">
                  <div class="epetition_category_item_single_info">
                      <div class="epetition_entry_img">
                          <a href="<?php echo $item->getHref(); ?>"><img
                                      src="<?php echo $item->getPhotoUrl('thumb.main'); ?>"/></a>
                      </div>
                      <div class="epetition_category_item_single_content sesbasic_bxs sesbasic_clearfix">
												<?php if (isset($this->titleActive)): ?>
                            <p class="title"><a
                                        href="<?php echo $item->getHref(); ?>"><?php echo $item->getTitle(); ?></a></p>
												<?php endif; ?>
												<?php if (Engine_Api::_()->getApi('core', 'epetition')->allowSignatureRating() && isset($this->ratingStarActive)): ?>
													<?php echo $this->partial('_petitionRating.tpl', 'epetition', array('rating' => $item->rating, 'class' => 'epetition_list_rating epetition_list_view_ratting', 'style' => 'margin-bottom:0px;')); ?>
												<?php endif; ?>
                          <div class="entry_meta">
														<?php if (isset($this->creationDateActive)): ?>
                                <div class="entry_meta-date sesbasic_text_light floatL"><i
                                            class="fa fa-clock-o"></i> <?php echo date('M d, Y', strtotime($item->publish_date)); ?>
                                </div>
														<?php endif; ?>
														<?php if(in_array('by', $allsetting['show_criteria'])) {
															$user = Engine_Api::_()->getItem('user', $item->owner_id);
															?>
                                <div class="owner_name">
                                    <a href="<?php echo $user->getHref(); ?>"><i class="fa fa-user-o"></i> <?php echo $this->translate($user->getTitle()); ?></a>
                                </div>
														<?php } ?>
                              <div class="entry_meta-comment sesbasic_text_light floatR">
																<?php if (isset($this->likeActive) && isset($item->like_count)) { ?>
                                    <span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i
                                                class="sesbasic_icon_like_o"></i><?php echo $item->like_count; ?></span>
																<?php } ?>
																<?php if (isset($this->commentActive) && isset($item->comment_count)) { ?>
                                    <span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count)) ?>"><i
                                                class="sesbasic_icon_comment_o"></i><?php echo $item->comment_count; ?></span>
																<?php } ?>
																<?php if (isset($this->favouriteActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.enable.favourite', 1)) { ?>
                                    <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count)) ?>"><i
                                                class="sesbasic_icon_favourite_o"></i><?php echo $item->favourite_count; ?></span>
																<?php } ?>
																<?php if (isset($this->viewActive) && isset($item->view_count)) { ?>
                                    <span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count)) ?>"><i
                                                class="sesbasic_icon_view"></i><?php echo $item->view_count; ?></span>
																<?php } ?>
																<?php include APPLICATION_PATH . '/application/modules/Epetition/views/scripts/_petitionRatingStat.tpl'; ?>
                              </div>
                          </div>
                          <div class="read_more">
														<?php if (in_array('readmore', $allsetting['show_criteria'])) { ?>
                                <a href="<?php echo $item->getHref(); ?>"> <?php echo $this->translate('Read More >>'); ?></a>
														<?php } ?>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="epetition-category_item_list sesbasic_custom_scroll">
								<?php else: ?>
                    <div class="epetition_category_item sesbasic_clearfix">
                        <div class="wrapper_list sesbasic_clearfix">
                            <div class="epetition_entry_img">
                                <a href="<?php echo $item->getHref(); ?>"><img
                                            src="<?php echo $item->getPhotoUrl('thumb.main'); ?>"/></a>
                            </div>
													<?php if (isset($this->titleActive)): ?>
                              <a href="<?php echo $item->getHref(); ?>"><p
                                          class="title"><?php echo $item->getTitle(); ?></p></a>
													<?php endif; ?>
													<?php if (Engine_Api::_()->getApi('core', 'epetition')->allowSignatureRating() && isset($this->ratingStarActive)): ?>
														<?php echo $this->partial('_petitionRating.tpl', 'epetition', array('rating' => $item->rating, 'class' => 'epetition_list_rating epetition_list_view_ratting', 'style' => 'margin-bottom:0px;')); ?>
													<?php endif; ?>
                            <div class="entry_meta">
															<?php if (isset($this->creationDateActive)): ?>
                                  <div class="entry_meta-date sesbasic_text_light">
                                      <i class="fa fa-clock-o"></i> <?php echo date('M d, Y', strtotime($item->publish_date)); ?>
                                  </div>
															<?php endif; ?>
                              <?php    $user = Engine_Api::_()->getItem('user', $item->owner_id);                            ?>
                                  <div class="owner_name">
                                      <a href="<?php echo $user->getHref(); ?>"><i class="fa fa-user-o"></i> <?php echo $this->translate($user->getTitle()); ?></a>
                                  </div>
                                <div class="entry_meta-comment sesbasic_text_light">
																	<?php if (isset($this->likeActive) && isset($item->like_count)) { ?>
                                      <span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i
                                                  class="sesbasic_icon_like_o"></i><?php echo $item->like_count; ?></span>
																	<?php } ?>
																	<?php if (isset($this->commentActive) && isset($item->comment_count)) { ?>
                                      <span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count)) ?>"><i
                                                  class="sesbasic_icon_comment_o"></i><?php echo $item->comment_count; ?></span>
																	<?php } ?>
																	<?php if (isset($this->favouriteActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.enable.favourite', 1)) { ?>
                                      <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count)) ?>"><i
                                                  class="sesbasic_icon_favourite_o"></i><?php echo $item->favourite_count; ?></span>
																	<?php } ?>
																	<?php if (isset($this->viewActive) && isset($item->view_count)) { ?>
                                      <span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count)) ?>"><i
                                                  class="sesbasic_icon_view"></i><?php echo $item->view_count; ?></span>
																	<?php } ?>

																	<?php if (in_array('featuredLabelActive', $allsetting['show_criteria']) || in_array('sponsoredLabelActive', $allsetting['show_criteria']) || in_array('verifiedLabelActive', $allsetting['show_criteria']) || in_array('victoryLabelActive', $allsetting['show_criteria'])) { ?>
                                      <div class="epetition_list_labels sesbasic_animation">
																				<?php if (in_array('featuredLabelActive', $allsetting['show_criteria']) && isset($item->featured) && $item->featured) { ?>
                                            <span class="epetition_label_featured"
                                                  title="<?php echo $this->translate('Featured'); ?>"><i
                                                        class="fa fa-star"></i></span>
																				<?php } ?>
																				<?php if (in_array('sponsoredLabelActive', $allsetting['show_criteria']) && isset($item->sponsored) && $item->sponsored) { ?>
                                            <span class="epetition_label_sponsored"
                                                  title="<?php echo $this->translate('Sponsored'); ?>"><i
                                                        class="fa fa-star"></i></span>
																				<?php } ?>
																				<?php if (in_array('verifiedLabelActive', $allsetting['show_criteria']) && isset($item->verified) && $item->verified) { ?>
                                            <span class="epetition_label_verified"
                                                  title="<?php echo $this->translate('Varified'); ?>"><i
                                                        class="fa fa-star"></i></span>
																				<?php } ?>
																				<?php if (in_array('victoryLabelActive', $allsetting['show_criteria']) && isset($item->victory) && $item->victory == 1) { ?>
                                            <span class="epetition_label_victory"
                                                  title="<?php echo $this->translate('Victory'); ?>"><i
                                                        class="fa fa-star"></i></span>
																				<?php } ?>
                                      </div>
																	<?php } ?>
																	<?php include APPLICATION_PATH . '/application/modules/Epetition/views/scripts/_petitionRatingStat.tpl'; ?>
                                </div>
                            </div>
                            <div class="read_more">
															<?php if (in_array('readmore', $allsetting['show_criteria'])) { ?>
                                  <a href="<?php echo $item->getHref(); ?>"> <?php echo $this->translate('Read More >>'); ?></a>
															<?php } ?>
                            </div>
                        </div>
                    </div>
								<?php endif; ?>
								<?php $bigBlg++; ?>
								<?php endforeach; ?>
								<?php $bigBlg = 0; ?>
								<?php endif; ?>
              </div>
          </div>
			<?php endforeach; ?>
			<?php if ($this->paginatorCategory->getTotalItemCount() == 0 && !$this->is_ajax): ?>
          <div class="tip">
			<span>
				<?php echo $this->translate('Nobody has created an petition yet.'); ?>
								<?php if ($this->can_create): ?>
									<?php echo $this->translate('Be the first to %1$screate%2$s one!', '<a href="' . $this->url(array('action' => 'create', 'module' => 'epetition'), "epetition_general", true) . '">', '</a>'); ?>
								<?php endif; ?>
			</span>
          </div>
			<?php endif; ?>
			<?php if ($this->loadOptionData == 'pagging'): ?>
				<?php echo $this->paginationControl($this->paginatorCategory, null, array("_pagging.tpl", "epetition"), array('identityWidget' => $randonNumber)); ?>
			<?php endif; ?>
			<?php if (!$this->is_ajax){ ?>
    </div>
</div>
<?php if ($this->loadOptionData != 'pagging') { ?>
    <div class="sesbasic_view_more" id="view_more_<?php echo $randonNumber; ?>"
         onclick="viewMore_<?php echo $randonNumber; ?>();"> <?php echo $this->htmlLink('javascript:void(0);', $this->translate('View More'), array('id' => "feed_viewmore_link_$randonNumber", 'class' => 'buttonlink icon_viewmore')); ?> </div>
    <div class="sesbasic_view_more_loading" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"><img
                src="<?php echo $this->layout()->staticBaseUrl; ?>application/modules/Sesbasic/externals/images/loading.gif"/>
    </div>
<?php } ?>
<?php } ?>

<script type="text/javascript">
	<?php if($this->loadOptionData == 'auto_load'){ ?>
  window.addEvent('load', function () {
      sesJqueryObject(window).scroll(function () {
          var heightOfContentDiv_<?php echo $randonNumber; ?> = sesJqueryObject('#scrollHeightDivSes_<?php echo $randonNumber; ?>').offset().top;
          var fromtop_<?php echo $randonNumber; ?> = sesJqueryObject(this).scrollTop();
          if (fromtop_<?php echo $randonNumber; ?> > heightOfContentDiv_<?php echo $randonNumber; ?> - 100 && sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').css('display') == 'block') {
              document.getElementById('feed_viewmore_link_<?php echo $randonNumber; ?>').click();
          }
      });
  });
	<?php } ?>
  viewMoreHide_<?php echo $randonNumber; ?>();

  function viewMoreHide_<?php echo $randonNumber; ?>() {
      if ($('view_more_<?php echo $randonNumber; ?>'))
          $('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo($this->paginatorCategory->count() == 0 ? 'none' : ($this->paginatorCategory->count() == $this->paginatorCategory->getCurrentPageNumber() ? 'none' : '')) ?>";
  }

  function viewMore_<?php echo $randonNumber; ?> () {
      document.getElementById('view_more_<?php echo $randonNumber; ?>').style.display = 'none';
      document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = '';
      en4.core.request.send(new Request.HTML({
          method: 'post',
          'url': en4.core.baseUrl + "widget/index/mod/epetition/name/<?php echo $this->widgetName; ?>",
          'data': {
              format: 'html',
              page: <?php echo $this->page + 1; ?>,
              params: '<?php echo json_encode($this->params); ?>',
              is_ajax: 1,
              identity: '<?php echo $randonNumber; ?>',
          },
          onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
              document.getElementById('category-petition-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('category-petition-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
              document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';
              jqueryObjectOfSes(".sesbasic_custom_scroll").mCustomScrollbar({
                  theme: "minimal-dark"
              });

          }
      }));
      return false;
  }
	<?php if(!$this->is_ajax){ ?>
  function paggingNumber<?php echo $randonNumber; ?>(pageNum) {
      sesJqueryObject('.sesbasic_loading_cont_overlay').css('display', 'block');
      en4.core.request.send(new Request.HTML({
          method: 'post',
          'url': en4.core.baseUrl + "widget/index/mod/epetition/name/<?php echo $this->widgetName; ?>",
          'data': {
              format: 'html',
              page: pageNum,
              params: '<?php echo json_encode($this->params); ?>',
              is_ajax: 1,
              identity: '<?php echo $randonNumber; ?>',
              type: '<?php echo $this->view_type; ?>'
          },
          onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
              sesJqueryObject('.sesbasic_loading_cont_overlay').css('display', 'none');
              document.getElementById('category-petition-widget_<?php echo $randonNumber; ?>').innerHTML = responseHTML;
              jqueryObjectOfSes(".sesbasic_custom_scroll").mCustomScrollbar({
                  theme: "minimal-dark"
              });
              // dynamicWidth();
          }
      }));
      return false;
  }
	<?php } ?>
</script>
