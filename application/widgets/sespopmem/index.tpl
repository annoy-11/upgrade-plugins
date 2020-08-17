<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesspectromedia
 * @package    Sesspectromedia
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<style>
/*Members*/
.sespopmem_members_block{margin:40px 0;overflow:hidden;}
.sespopmem_members_block_content{margin:0 auto;}
.sespopmem_members_block_content h2{font-size:30px;font-weight:normal;margin-bottom:25px;text-align:center;text-transform:uppercase;}
.sespopmem_members_thumb{border-width:1px;float:left;height:150px;position:relative;width:148px;overflow:hidden;margin:1px;}
[dir="rtl"] .sespopmem_members_thumb{float:right;}
.sespopmem_members_thumb > a{float:left;height:100%;width:100%;}
.sespopmem_members_thumb span{background-position:center center;background-size:cover;height:100%;display:block;width:100%;-webkit-transition:all 500ms ease 0s;-moz-transition:all 500ms ease 0s;-o-transition:all 500ms ease 0s;transition:all 500ms ease 0s;}
.sespopmem_members_thumb:hover span{transform:scale(1.1);-webkit-filter: grayscale(1);filter: grayscale(1);filter:alpha(opacity=70);}
.sespopmem_members_thumb .member_info{background-color:rgba(0, 0, 0, 0.6);bottom:-50px;color:#ffffff;font-size:12px;padding:5px;position:absolute;text-align:center;width:100%;z-index:1;-webkit-transition:all 500ms ease 0s;-moz-transition:all 500ms ease 0s;-o-transition:all 500ms ease 0s;transition:all 500ms ease 0s;}
.sespopmem_members_thumb:hover .member_info{bottom:0;}
</style>

<?php $baseUrl = $this->layout()->staticBaseUrl; ?>
<div class="sespopmem_members_block sesbasic_bxs">
	<div class="sespopmem_members_block_content">
    <?php if($this->heading): ?>
      <h2><?php echo $this->translate("%s members and counting ...", $this->member_count); ?></h2>
    <?php endif; ?>
    <?php if(!$this->showType): ?>
	    <ul class="clearfix sespopmem_members_block_list">
	      <?php foreach( $this->paginator as $user ): ?>
	        <li class="sespopmem_members_thumb" style="height:<?php echo $this->height ?>px; width:<?php echo $this->width ?>px;">
	          <a href="<?php echo $user->getHref() ?>" class ="item_thumb" title="<?php echo $user->displayname ?>">
	            <?php $url = $user->getPhotoUrl('thumb.profile'); ?>
	            <?php if ($url == ''){$url = $this->layout()->staticBaseUrl ."application/modules/User/externals/images/nophoto_user_thumb_profile.png";
	            } ?>
	            <span style="background-image:url(<?php echo $url; ?>);"></span>
	          </a>
	          <?php if($this->showTitle): ?>
		          <div class='member_info'>
		            <?php echo $user->displayname; ?>
		          </div>
	          <?php endif; ?>
	        </li>
	      <?php endforeach; ?>
	    </ul>
    <?php endif; ?>
  </div>
</div>
