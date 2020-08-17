<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: _listView.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<li class="epetition_petition_list_item sesbasic_clearfix clear">
    <article class="sesbasic_clearfix sesbasic_bg">
        <div class="epetition_item_thumb epetition_listing_thumb"
             style="height:<?php echo is_numeric($this->height_list) ? $this->height_list . 'px' : $this->height_list ?>;width:<?php echo is_numeric($this->width_list) ? $this->width_list . 'px' : $this->width_list ?>;">
          <?php $href = $item->getHref();
          $imageURL = $photoPath; ?>
	        <?php if(isset($this->imageLabelActive)) { ?>
            <a href="<?php echo $href; ?>" data-url="<?php echo $item->getType() ?>" class="epetition_thumb_img">
                <span style="background-image:url(<?php echo $imageURL; ?>);"></span>
            </a>
            <?php } ?>
          <?php if (isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabel)): ?>
              <div class="epetition_listing_label sesbasic_animation">
                <?php if (isset($this->featuredLabelActive) && $item->featured == 1): ?>
                    <p class="epetition_label_featured"><?php echo $this->translate('FEATURED'); ?></p>
                <?php endif; ?>
                <?php if (isset($this->sponsoredLabelActive) && $item->sponsored == 1): ?>
                    <p class="epetition_label_sponsored"><?php echo $this->translate('SPONSORED'); ?></p>
                <?php endif; ?>
                <?php if (isset($this->verifiedLabelActive) && $item->verified == 1): ?>
                    <p class="epetition_label_verified"><?php echo $this->translate('VERIFIED'); ?></p>
                <?php endif; ?>
              </div>
          <?php endif; ?>
          <?php if (isset($this->likeButtonActive) || isset($this->favouriteButtonActive)): ?>
              <div class="epetition_item_thumb_over sesbasic_animation">
                  <a class="epetition_item_thumb_over_link" href="<?php echo $href; ?>"
                     data-url="<?php echo $item->getType() ?>"></a>
                  <div class="epetition_item_thumb_over_btns">

                    <?php if (Engine_Api::_()->user()->getViewer()->getIdentity() != 0): ?>
                      <?php $canComment = $item->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment'); ?>
                      <?php if (isset($this->likeButtonActive) && $canComment): ?>
                            <!--Like Button-->
                        <?php $LikeStatus = Engine_Api::_()->epetition()->getLikeStatus($item->epetition_id, $item->getType()); ?>
                            <a href="javascript:" data-url="<?php echo $item->epetition_id; ?>"
                               class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn epetition_like_epetition_<?php echo $item->epetition_id ?> epetition_like_epetition <?php echo ($LikeStatus) ? 'button_active' : ''; ?>">
                                <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>
                      <?php endif; ?>
                      <?php if (isset($this->favouriteButtonActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.enable.favourite', 1)): ?>
                        <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'epetition')->isFavourite(array('resource_type' => 'epetition', 'resource_id' => $item->epetition_id)); ?>
                            <a href="javascript:"
                               class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn epetition_favourite_epetition_<?php echo $item->epetition_id ?> epetition_favourite_epetition <?php echo ($favStatus) ? 'button_active' : '' ?>"
                               data-url="<?php echo $item->epetition_id; ?>"><i
                                        class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>
                      <?php endif; ?>
                    <?php endif; ?>
                  </div>
              </div>
          <?php endif; ?>
        </div>
        <div class="epetition_item_info">
            <div class="epetition_item_title">
              <?php if (isset($this->titleActive)): ?>
                <?php if (strlen($item->getTitle()) > $this->title_truncation_list): ?>
                  <?php $title = mb_substr($item->getTitle(), 0, $this->title_truncation_list) . '...'; ?>
                  <?php echo $this->htmlLink($item->getHref(), $title, array('title' => $item->getTitle())); ?>
                <?php else: ?>
                  <?php echo $this->htmlLink($item->getHref(), $item->getTitle(), array('title' => $item->getTitle())) ?>
                <?php endif; ?>
              <?php endif; ?>
            </div>
            <div class="epetition_item_details">
              <?php if (isset($this->byActive)) { ?>
                  <div class="epetition_item_owner sesbasic_text_light">
                    <?php $owner = $item->getOwner(); ?>
                    <?php echo $this->htmlLink($item->getOwner()->getParent(), $this->itemPhoto($item->getOwner()->getParent(), 'thumb.icon')); ?>
                      <span>
							<?php echo $this->translate("by"); ?><?php echo $this->htmlLink($owner->getHref(), $owner->getTitle()) ?>
						</span>
                  </div>
              <?php } ?>
              <?php if (isset($this->creationDateActive)) { ?>
                  <div class="epetition_item_stats sesbasic_text_light">
						<span>
							<i class="fa fa-clock-o"></i>
							<span>
								<?php if ($item->publish_date): ?>
                                  <?php echo date('M d, Y', strtotime($item->publish_date)); ?>
                                <?php else: ?>
                                  <?php echo date('M d, Y', strtotime($item->creation_date)); ?>
                                <?php endif; ?>
							</span>
						</span>
                  </div>
              <?php } ?>
                <div class="epetition_item_stats sesbasic_text_light">
                  <?php if (isset($this->likeActive) && isset($item->like_count)) { ?>
                      <span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>" class="epetition_like_count_<?php echo $item->epetition_id; ?>"><i
                                  class="sesbasic_icon_like_o"></i><span><?php echo $item->like_count; ?></span></span>
                  <?php } ?>
                  <?php if (isset($this->commentActive) && isset($item->comment_count)) { ?>
                      <span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count)) ?>"><i
                                  class="sesbasic_icon_comment_o"></i><span><?php echo $item->comment_count; ?></span></span>
                  <?php } ?>
                  <?php if (isset($this->favouriteActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.enable.favourite', 1)) { ?>
                      <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count)) ?>" class="epetition_favourite_count_<?php echo $item->epetition_id; ?>"><i
                                  class="sesbasic_icon_favourite_o"></i><span><?php echo $item->favourite_count; ?></span></span>
                  <?php } ?>
                  <?php if (isset($this->viewActive) && isset($item->view_count)) { ?>
                      <span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count)) ?>"><i
                                  class="sesbasic_icon_view"></i><span><?php echo $item->view_count; ?></span></span>
                  <?php } ?>
                  <?php //include APPLICATION_PATH .  '/application/modules/Epetition/views/scripts/_petitionRatingStat.tpl';?>
                </div>
            </div>
            <div class="epetition_item_details">
              <?php if (isset($this->categoryActive)) { ?>
                <?php if ($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)): ?>
                  <?php $categoryItem = Engine_Api::_()->getItem('epetition_category', $item->category_id); ?>
                  <?php if ($categoryItem): ?>
                          <div class="epetition_item_stats sesbasic_text_light">
								<span>
									<i class="fa fa-folder-open"
                                       title="<?php echo $this->translate('Category'); ?>"></i>
									<span><a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a></span>
								</span>
                          </div>
                  <?php endif; ?>
                <?php endif; ?>
              <?php } ?>
              <?php if (isset($this->locationActive) && isset($item->location) && $item->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.enable.location', 1)) { ?>
                  <div class="epetition_item_stats sesbasic_text_light epetition_list_location">
						<span>
							<i class="fa fa-map-marker"></i>
							<span><a href="<?php echo $this->url(array('resource_id' => $item->epetition_id, 'resource_type' => 'epetition', 'action' => 'get-direction'), 'sesbasic_get_direction', true); ?>"
                                     class="opensmoothboxurl"
                                     title="<?php echo $item->location; ?>"><?php echo $item->location; ?></a></span>
						</span>
                  </div>
              <?php } ?>
            </div>
          <?php if (isset($this->descriptionlistActive)) { ?>
              <div class="epetition_item_des">
                <?php echo $item->getDescription($this->description_truncation_list); ?>
              </div>
          <?php } ?>

          <?php if (isset($this->signatureLableActive) &&  !empty($item->signature_goal) && $item->signature_goal <= $signpet) { ?>
            <?php if ($this->victory == 1) { ?>
                  <div class="epetition-victory">
                      <p><?php echo $this->translate("Victory! This petition made change with %s supporters!",$this->sign_goal); ?></p>
                  </div>
            <?php } else { ?>
                  <div class="epetition-near-victory">
                      <p><?php echo $this->translate("This petition made change with %s supporters!.",$this->sign_goal); ?></p>
                  </div>

            <?php }
          } else if (isset($this->signatureLableActive) &&  $this->victory == 2) { ?>
              <div class="epetition-near-close">
                  <p><?php echo $this->translate("This petition is closed");?></p>
              </div>
          <?php } else { ?>
              <div class="epetition_item_footer">
                <?php if (isset($this->signatureLableActive) && isset($item->signature_goal) && !empty($item->signature_goal)) { ?>
                    <div class="epetition_signature_bar_container">
                        <div class="epetition_signature_bar">
                            <div class="epetition_signature_bar_filled per<?php echo $item->epetition_id; ?>"
                                 style="width: <?php echo $percent_width; ?>;"></div>
                        </div>
                        <div class="epetition_signature_text"><b
                                    class="countincrease acv<?php echo $item->epetition_id; ?>"><?php echo $signpet; ?></b>
                          <?php echo $this->translate("signed of"); ?> <?php echo $item->signature_goal; ?> <?php echo $this->translate("goal"); ?>
                        </div>
                    </div>
                <?php } ?>
                  <div class="epetition_item_btns">
	                  <?php if(isset($this->signatureLableActive)) { ?>
                    <?php if ($user_check && (!isset($item->startdate) || (strtotime(date("Y-m-d H:i:s")) >= strtotime($item->startdate))) && (!isset($item->enddate) || (strtotime(date("Y-m-d H:i:s")) <= strtotime($item->enddate)))) { ?>
                        <div><a href="<?php echo $this->baseUrl()."/epetition/index/popsignpetition?id=".$item->epetition_id;  ?>"   class="epetition_button_outline sesbasic_animation sessmoothbox">Sign This</a></div>
                    <?php } } ?>
                    <?php if ((isset($this->socialSharingActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.enable.sharing', 1))): ?>
                      <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
                        <div class="epetition_list_share_wrap">
                            <a href="" class="epetition_button_toggle epetition_button_outline sesbasic_animation"><i
                                        class="sesbasic_icon_share"></i></a>
                            <div class="epetition_listing_share_box sesbasic_bg">
                                <div class="_head centerT">
                                  <?php echo $this->translate("Share This Petition") ?>
                                </div>
                                <div class="_btns centerT">
                                  <?php if (isset($this->socialSharingActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.enable.sharing', 1)): ?>
                                   <a href="<?php echo $this->url(array("module" => "activity", "controller" => "index", "action" => "share", "type" => $item->getType(), "id" => $item->getIdentity(), "format" => "smoothbox"), 'default', true); ?>"
                             class="share_icon sesbasic_icon_btn smoothbox"><i
                                      class="sesbasic_icon_share"></i><span><?php echo $this->translate('Share'); ?></span></a>
                                      
                                    <?php if ($this->socialshare_icon_limit): ?>
                                      <?php echo $this->partial('_socialShareIcons.tpl', 'sesbasic', array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
                                    <?php else: ?>
                                      <?php echo $this->partial('_socialShareIcons.tpl', 'sesbasic', array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_listview1plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_listview1limit)); ?>
                                    <?php endif; ?>
                                  <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                  </div>
              </div>
          <?php } ?>
        </div>
    </article>
</li>
