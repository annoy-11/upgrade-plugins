<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesteam
 * @package    Sesteam
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _tematemplate4.tpl 2015-02-20 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesteam/externals/styles/styles.css'); ?>
<?php if (empty($this->viewmore)) { ?>
<div class="sesteam_temp4_wrap">
  <?php if(!$this->is_ajax){ ?>
    <?php if($this->teampage_title): ?>
      <div class="team_page_heading<?php if ($this->center_heading): ?> iscenter<?php endif; ?>"><?php echo $this->translate($this->teampage_title); ?></div>
    <?php endif; ?>
    <?php if($this->teampage_description): ?>
      <p class="team_page_description<?php if ($this->center_description): ?> iscenter<?php endif; ?>"><?php echo $this->translate($this->teampage_description); ?></p>
    <?php endif; ?>
  <?php } ?>
  <div id="browse-team-widget" class="sesteam_temp4_list sesbasic_clearfix<?php if ($this->center_block): ?> iscenter<?php endif; ?>">
<?php } ?>
    <?php foreach( $this->paginator as $user ):
    if($this->type == 'teammember') {
      $user_item = $this->item('user', $user->user_id);
    } else {
      $user_item = $user; //$this->item('user', $user->user_id);
    }
     ?>
      <div class="team_box" style="width:<?php echo $this->width ?>px;">
        <div class="team_box_inner">
          <div class="team_member_thumbnail" style="height:<?php echo $this->height ?>px;width:<?php echo $this->width ?>px;">
            <?php if($user->photo_id && $this->type == 'teammember'): ?>
              <?php echo $this->htmlLink($user_item->getHref(), $this->itemPhoto($user, 'thumb.profile', $user_item->getTitle()), array('title' => $user_item->getTitle())); ?>
            <?php else: ?>
              <?php echo $this->htmlLink($user_item->getHref(), $this->itemPhoto($user_item, 'thumb.profile', $user_item->getTitle()), array('title' => $user_item->getTitle())); ?>
            <?php endif; ?>
            
            <?php if(in_array('featured', $this->content_show) || in_array('sponsored', $this->content_show)): ?>
              <span class="sesteam_labels_container">
                <?php if($user->featured && in_array('featured', $this->content_show)): ?>
                <span class="sesteam_label sesteam_label_featured"><?php echo $this->translate("FEATURED"); ?></span>
                <?php endif; ?>
                <?php if($user->sponsored && in_array('sponsored', $this->content_show)): ?>
                <span class="sesteam_label sesteam_label_sponsored"><?php echo $this->translate("SPONSORED"); ?></span>
                <?php endif; ?>
              </span>
            <?php endif; ?>
          </div>
          
          <?php if(!empty($this->content_show) && in_array('displayname', $this->content_show)): ?>
            <p class='team_member_name'>
              <?php if($this->type == 'teammember'): ?>
                <?php echo $this->htmlLink($user_item->getHref(), $user_item->getTitle(), array('title' => $user_item->getTitle())) ?>
              <?php else: ?>
                <?php echo $this->htmlLink($user_item->getHref(), $user_item->name, array('title' => $user_item->name)) ?>
              <?php endif; ?>              
            </p>
          <?php endif; ?>
          <?php if($user->designation_id && $user->designation && !empty($this->content_show) &&  in_array('designation', $this->content_show)): ?>
            <p class='team_member_role sesbasic_text_light'>
              <?php echo $this->translate($user->designation); ?>
            </p>
          <?php endif; ?>
          <p class="team_member_contact_info sesbasic_text_light">
            <?php if($user->email && !empty($this->content_show) && in_array('email', $this->content_show)): ?>
              <span>
                <i class="fas fa-envelope sesbasic_text_light"></i>
                <a href="mailto:<?php echo $user->email ?>" title="<?php echo $user->email ?>">
                  <?php echo $user->email ?>
                </a> 
              </span>
            <?php endif; ?>
            <?php if($user->phone && !empty($this->content_show) && in_array('phone', $this->content_show)): ?>
              <span>
                <i class="fa fa-phone sesbasic_text_light"></i>
                <?php echo $user->phone ?>
              </span>
            <?php endif; ?>            
            <?php if($user->location && !empty($this->content_show) && in_array('location', $this->content_show)): ?>
              <span>
                <i class="fas fa-map-marker-alt sesbasic_text_light"></i>
                <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) { ?>
                    <?php echo $this->htmlLink('http://maps.google.com/?q='.urlencode($user->location), $user->location, array('target' => 'blank')) ?>
                  <?php } else { ?>
                    <?php echo $user->location; ?>
                  <?php } ?>
              </span>
            <?php endif; ?>
          </p>
          <?php if($user->description && !empty($this->content_show) &&  in_array('description', $this->content_show)): ?>
            <p class='team_member_des'>
              <?php echo $this->translate($user->description); ?>              
              <?php if(!empty($this->content_show) && in_array('viewMore', $this->content_show)): ?>
                <span class="team_member_more_link">
                  <?php if(!empty($this->viewMoreText)): ?>
                    <?php $viewMoreText = $this->translate($this->viewMoreText) . ' &raquo;'; ?>
                  <?php else: ?>
                    <?php $viewMoreText = $this->translate("more") . '&raquo;'; ?>
                  <?php endif; ?>
                  <?php if($user->detail_description && $this->type == 'teammember'): ?>
                    <?php echo $this->htmlLink($user_item->getHref(), $viewMoreText, array()) ?>
                  <?php elseif($user->detail_description): ?>
                    <?php echo $this->htmlLink($user_item->getHref(), $viewMoreText, array()) ?>
                  <?php endif; ?>
                </span>
              <?php endif; ?>
            </p>
          <?php endif; ?>
          <div class="sesteam-social-icon <?php if(empty($this->sesteam_social_border)): ?>bordernone<?php endif; ?>">
            <?php if($user->email && !empty($this->content_show) && in_array('email', $this->content_show)): ?>
             <a href="mailto:<?php echo $user->email ?>" title="<?php echo $user->email ?>">
               <i class="fas fa-envelope sesbasic_text_light"></i>
             </a> 
           <?php endif; ?>

           <?php if($user->website && !empty($this->content_show) && in_array('website', $this->content_show)): ?>
            <?php $website = (preg_match("#https?://#", $user->website) === 0) ? 'http://'.$user->website : $user->website; ?>
             <a href="<?php echo $website ?>" target="_blank" title="<?php echo $website ?>">
               <i class="fas fa-globe sesbasic_text_light"></i>
             </a> 
           <?php endif; ?>
            <?php if($user->facebook && !empty($this->content_show) &&  in_array('facebook', $this->content_show)): ?>
             <?php $facebook = (preg_match("#https?://#", $user->facebook) === 0) ? 'http://'.$user->facebook : $user->facebook; ?>
              <a href="<?php echo $facebook ?>" target="_blank" title="<?php echo $facebook ?>">
                <i class="fab fa-facebook-f sesbasic_text_light"></i>
              </a> 
            <?php endif; ?>
            <?php if($user->twitter && !empty($this->content_show) &&  in_array('twitter', $this->content_show)): ?>
              <?php $twitter = (preg_match("#https?://#", $user->twitter) === 0) ? 'http://'.$user->twitter : $user->twitter; ?>
              <a href="<?php echo $twitter ?>" target="_blank" title="<?php echo $twitter ?>">
                <i class="fab fa-twitter sesbasic_text_light"></i>
              </a>
            <?php endif; ?>
            <?php if($user->linkdin && !empty($this->content_show) &&  in_array('linkdin', $this->content_show)): ?>
              <?php $linkdin = (preg_match("#https?://#", $user->linkdin) === 0) ? 'http://'.$user->linkdin : $user->linkdin; ?>
              <a href="<?php echo $linkdin ?>" target="_blank" title="<?php echo $linkdin ?>">
                <i class="fab fa-linkedin-in sesbasic_text_light"></i>
              </a>
            <?php endif; ?>
            <?php if($user->googleplus && !empty($this->content_show) &&  in_array('googleplus', $this->content_show)): ?>
              <?php $googleplus = (preg_match("#https?://#", $user->googleplus) === 0) ? 'http://'.$user->googleplus : $user->googleplus; ?>
              <a href="<?php echo $googleplus ?>" target="_blank" title="<?php echo $googleplus ?>">
                <i class="fab fa-google-plus-g sesbasic_text_light"></i>
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
    <?php if (!empty($this->paginator) && $this->paginator->count() > 1): ?>
      <?php if ($this->paginator->getCurrentPageNumber() < $this->paginator->count()): ?>
        <div class="clr" id="loadmore_list"></div>
        <div class="sesbasic_view_more sesbasic_load_btn" id="view_more" onclick="loadMore();" style="display: block;">
          <a href="javascript:void(0);" class="sesbasic_animation sesbasic_link_btn" ><i class="fa fa-sync"></i><span><?php echo $this->translate('View More');?></span></a>
        </div>
        <div class="sesbasic_view_more_loading" id="loading_image" style="display: none;">
          <span class="sesbasic_link_btn"><i class="fa fa-spinner fa-spin"></i></span>
        </div>
      <?php endif; ?>
    <?php endif; ?>
<?php if (empty($this->viewmore)) { ?>
  </div>
</div>
<?php } ?>
