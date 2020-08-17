<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesteam
 * @package    Sesteam
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _tematemplate6.tpl 2015-02-20 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesteam/externals/styles/styles.css'); ?>

<div class="sesteam_temp6_wrap">
  <?php if(!$this->is_ajax){ ?>
    <?php if($this->teampage_title): ?>
      <div class="team_page_heading<?php if ($this->center_heading): ?> iscenter<?php endif; ?>"><?php echo $this->translate($this->teampage_title); ?></div>
    <?php endif; ?>
    <?php if($this->teampage_description): ?>
      <p class="team_page_description<?php if ($this->center_description): ?> iscenter<?php endif; ?>"><?php echo $this->translate($this->teampage_description); ?></p>
    <?php endif; ?>
  <?php } ?>
  <div id="browse-team-widget" class="sesteam_temp6_list">
    <table>
        <?php foreach( $this->paginator as $user ):
              if($this->type == 'teammember') {
                $user_item = $this->item('user', $user->user_id);
              } else {
                $user_item = $user;
              }
        ?>
        <tr>
          <td class="team_member_thumbnail">
             <?php if($user->photo_id && $this->type == 'teammember'): ?>
              <?php echo $this->htmlLink($user_item->getHref(), $this->itemPhoto($user, 'thumb.icon', $user_item->getTitle()), array('title' => $user_item->getTitle())); ?>
            <?php else: ?>
              <?php echo $this->htmlLink($user_item->getHref(), $this->itemPhoto($user_item, 'thumb.icon', $user_item->getTitle()), array('title' => $user_item->getTitle())); ?>
            <?php endif; ?>
            <?php //echo $this->htmlLink($user_item->getHref(), $this->itemPhoto($user_item, 'thumb.icon', $user_item->getTitle()), array('title' => $user_item->getTitle())); ?>
          </td>
          <?php if(!empty($this->content_show) && in_array('displayname', $this->content_show)): ?>
            <td class='team_member_name'>
                <?php if($this->type == 'teammember'): ?>
                  <?php echo $this->htmlLink($user_item->getHref(), $user_item->getTitle(), array('title' => $user_item->getTitle())) ?>
                <?php else: ?>
                  <?php echo $this->htmlLink($user_item->getHref(), $user_item->name, array('title' => $user_item->name)) ?>
                <?php endif; ?> 
            </td>
          <?php endif; ?>
          <?php if(!empty($this->content_show) && in_array('designation', $this->content_show)): ?>
            <td class='team_member_contact_info team_member_role sesbasic_text_light'>
              <?php if($user->designation_id && $user->designation): ?>
                <?php echo $this->translate($user->designation); ?>
              <?php endif; ?>
            </td>
          <?php endif; ?>
          <?php if(!empty($this->content_show) && in_array('location', $this->content_show)): ?>
            <td class="team_member_contact_info">
              <?php if($user->location): ?>
                <i class="fa fa-map-marker sesbasic_text_light"></i>
                <?php echo $this->htmlLink('http://maps.google.com/?q='.urlencode($user->location), $user->location, array('target' => 'blank')) ?>
              <?php endif; ?>
            </td>
          <?php endif; ?>
          <?php if(!empty($this->content_show) && in_array('phone', $this->content_show)): ?>
            <td class="team_member_contact_info">
              <?php if($user->phone): ?>
                <i class="fa fa-phone sesbasic_text_light"></i>
                <?php echo $user->phone ?>
              <?php endif; ?>  
            </td>
          <?php endif; ?>
          <?php if(!empty($this->content_show)): ?>
            <td class="sesteam-social-icon <?php if(empty($this->sesteam_social_border)): ?>bordernone<?php endif; ?>">
              <?php if($user->email && !empty($this->content_show) && in_array('email', $this->content_show)): ?>
                <a href="mailto:<?php echo $user->email ?>" title="<?php echo $user->email ?>">
                  <i class="fa fa-envelope sesbasic_text_light"></i>
                </a> 
              <?php endif; ?>
              <?php if($user->website && !empty($this->content_show) && in_array('website', $this->content_show)): ?>
                <?php $website = (preg_match("#https?://#", $user->website) === 0) ? 'http://'.$user->website : $user->website; ?>
                <a href="<?php echo $website ?>" target="_blank" title="<?php echo $website ?>">
                  <i class="fa fa-globe sesbasic_text_light"></i>
                </a> 
              <?php endif; ?>
              <?php if($user->facebook && !empty($this->content_show) && in_array('facebook', $this->content_show)): ?>
                <?php $facebook = (preg_match("#https?://#", $user->facebook) === 0) ? 'http://'.$user->facebook : $user->facebook; ?>
                <a href="<?php echo $facebook ?>" target="_blank" title="<?php echo $facebook ?>">
                  <i class="fa fa-facebook sesbasic_text_light"></i>
                </a> 
              <?php endif; ?>
              <?php if($user->twitter && !empty($this->content_show) && in_array('twitter', $this->content_show)): ?>
                <?php $twitter = (preg_match("#https?://#", $user->twitter) === 0) ? 'http://'.$user->twitter : $user->twitter; ?>
                <a href="<?php echo $twitter ?>" target="_blank" title="<?php echo $twitter ?>">
                  <i class="fa fa-twitter sesbasic_text_light"></i>
                </a>
              <?php endif; ?>
              <?php if($user->linkdin && !empty($this->content_show) && in_array('linkdin', $this->content_show)): ?>
                <?php $linkdin = (preg_match("#https?://#", $user->linkdin) === 0) ? 'http://'.$user->linkdin : $user->linkdin; ?>
                <a href="<?php echo $linkdin ?>" target="_blank" title="<?php echo $linkdin ?>">
                  <i class="fa fa-linkedin sesbasic_text_light"></i>
                </a>
              <?php endif; ?>
              <?php if($user->googleplus && !empty($this->content_show) && in_array('googleplus', $this->content_show)): ?>
                <?php $googleplus = (preg_match("#https?://#", $user->googleplus) === 0) ? 'http://'.$user->googleplus : $user->googleplus; ?>
                <a href="<?php echo $googleplus ?>" target="_blank" title="<?php echo $googleplus ?>">
                  <i class="fa fa-google-plus sesbasic_text_light"></i>
                </a>
              <?php endif; ?>
            </td>
          <?php endif; ?>
          <?php if(!empty($this->content_show) && in_array('viewMore', $this->content_show) && in_array('description', $this->content_show) && $user->description): ?>
            <td class="team_member_more_link">
              <?php if(!empty($this->viewMoreText)): ?>
                <?php $viewMoreText = $this->translate($this->viewMoreText) . ' &raquo;'; ?>
              <?php else: ?>
                <?php $viewMoreText = $this->translate("View Details") . '&raquo;'; ?>
              <?php endif; ?>
              <?php if($user->detail_description && $this->type == 'teammember'): ?>
                <?php echo $this->htmlLink($user_item->getHref(), $viewMoreText, array()) ?>
              <?php elseif($user->detail_description): ?>
                <?php echo $this->htmlLink($user_item->getHref(), $viewMoreText, array()) ?>
              <?php endif; ?>
            </td>
          <?php endif; ?>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>
</div>
