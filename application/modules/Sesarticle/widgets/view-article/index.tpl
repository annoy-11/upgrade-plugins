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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesarticle/externals/styles/styles.css'); ?>
<?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $this->sesarticle->getHref()); ?>
<?php $isArticleAdmin = Engine_Api::_()->sesarticle()->isArticleAdmin($this->sesarticle, 'edit');?>
<?php $reviewCount = Engine_Api::_()->sesarticle()->getTotalReviews($this->sesarticle->article_id);?>
<?php $canComment =  $this->sesarticle->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
<?php $LikeStatus = Engine_Api::_()->sesarticle()->getLikeStatus($this->sesarticle->article_id,$this->sesarticle->getType()); ?> 
<?php $likeClass = (!$LikeStatus) ? 'fa-thumbs-up' : 'fa-thumbs-down' ;?>
<?php $likeText = ($LikeStatus) ?  $this->translate('Unlike') : $this->translate('Like');?>
<?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesarticle')->isFavourite(array('resource_type'=>'sesarticle','resource_id'=>$this->sesarticle->article_id)); ?>
<?php $enableSharng = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.sharing', 1);?>
<?php if($this->sesarticle->style == 1):?>
	<div class="sesarticle_layout_contant sesbasic_clearfix sesbasic_bxs">
	  <?php if(isset($this->titleActive)):?>
			<h2><?php echo $this->sesarticle->getTitle() ?></h2>
		<?php endif;?>
		<div class="sesarticle_entrylist_entry_date">
    	<p><?php echo $this->translate('<i>Posted by -</i>');?> <?php echo $this->htmlLink($this->owner->getHref(), $this->owner->getTitle()) ?> &nbsp;-&nbsp;</p>
			<p><?php echo $this->translate('<i>on - </i>') ?><?php echo $this->timestamp($this->sesarticle->creation_date) ?><?php if( $this->category ): ?>&nbsp;-&nbsp;</p>
				<p><?php echo $this->translate('<i>Filed in - </i>') ?>
				<a href="<?php echo $this->category->getHref(); ?>"><?php echo $this->translate($this->category->category_name) ?></a><?php endif; ?>&nbsp;-&nbsp;</p>
			<p><?php if (count($this->sesarticleTags )):?>
				<?php foreach ($this->sesarticleTags as $tag): ?>
					<a href='javascript:void(0);' onclick='javascript:tagAction(<?php echo $tag->getTag()->tag_id; ?>);'><?php echo $tag->getTag()->text?></a>&nbsp;
				<?php endforeach; ?>
			<?php endif; ?>
			<?php if(isset($this->staticsActive)):?>
				&nbsp;-&nbsp;</p>
				<p>
					<?php if(isset($this->viewActive)):?>
						<span><?php echo $this->translate(array('%s View', '%s Views', $this->sesarticle->view_count), $this->locale()->toNumber($this->sesarticle->view_count)) ?>&nbsp;-&nbsp;</span>
					<?php endif;?>
					<?php if(isset($this->commentActive)):?>
						<span><?php echo $this->translate(array('%s Comment', '%s Comments', $this->sesarticle->comment_count), $this->locale()->toNumber($this->sesarticle->comment_count)) ?>&nbsp;-&nbsp;</span>
					<?php endif;?>
					<?php if(isset($this->likeActive)):?>
						<span><?php echo $this->translate(array('%s Like', '%s Likes', $this->sesarticle->like_count), $this->locale()->toNumber($this->sesarticle->like_count)) ?>&nbsp;-&nbsp;</span>
					<?php endif;?>
					<?php if(isset($this->reviewActive)):?>
						<span><?php echo $this->translate(array('%s Review', '%s Reviews', $reviewCount), $this->locale()->toNumber($reviewCount)) ?></span>
					<?php endif;?>
				</p>
			<?php endif;?>
		</div>
		<div class="sesarticle_entrylist_entry_body">
		  <?php if(isset($this->photoActive) && $this->sesarticle->photo_id):?>
				<div  class="sesarticle_image clear" style="height: <?php echo $this->image_height ?>px;overflow: hidden;">
					<img  src="<?php echo Engine_Api::_()->storage()->get($this->sesarticle->photo_id)->getPhotoUrl('thumb.main'); ?>" alt="">
				</div>
			<?php endif;?>
			<?php if(isset($this->descriptionActive)):?>
				<?php if($this->sesarticle->cotinuereading){
					$check = true;
				}else{
					$check = false;
				} ?>
				<div class="sesarticle_entrylist_entry_body rich_content_body" style="visibility:hidden"><?php echo $this->sesarticle->body;?></div>
				<?php if($check): ?>
					<div class="sesarticle_morebtn" style="display:none"><a href="javascript:void(0);" onclick="continuereading();"><?php echo $this->translate("Continue Reading"); ?></a></div>
				<?php endif; ?>
			<?php endif;?>
		</div>
    <div class="sesarticle_footer_two_article clear">
      <?php if(isset($this->ratingActive)):?>
				<div class="sesbasic_rating_star floatL">
					<?php $ratingCount = $this->sesarticle->rating; $x=0; ?>
					<?php if( $ratingCount > 0 ): ?>
						<?php for( $x=1; $x<=$ratingCount; $x++ ): ?>
							<span id="" class="sesarticle_rating_star"></span>
						<?php endfor; ?>
						<?php if( (round($ratingCount) - $ratingCount) > 0){ ?>
						<span class="sesarticle_rating_star sesarticle_rating_star_half"></span>
						<?php }else{ $x = $x - 1;} ?>
						<?php if($x < 5){ 
						for($j = $x ; $j < 5;$j++){ ?>
						<span class="sesarticle_rating_star sesarticle_rating_star_disable"></span>
						<?php }   	
						} ?>
					<?php endif; ?>
				</div>
			<?php endif;?>
			<div class="sesarticle_deshboard_article floatR">
				<ul>
					<?php if(isset($this->ownerOptionsActive)):?>
          	<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.subarticle', 1)){ ?>
						<li><a href="<?php echo $this->url(array('action' => 'create', 'parent_id' => $this->sesarticle->article_id), 'sesarticle_general', 'true');?>"><i class="fa fa-edit"></i><?php echo $this->translate('Create Sub Article');?></a></li>
           <?php } ?>
					 <?php if($this->sesarticle->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'edit')): ?>
						<li><a href="<?php echo $this->url(array('action' => 'edit', 'article_id' => $this->sesarticle->custom_url), 'sesarticle_dashboard', 'true');?>"><i class="fa fa-edit"></i><?php echo $this->translate('Dashboard');?></a></li>
						<?php endif; ?>
						<?php if($this->sesarticle->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'delete')): ?>
							<li><a href="<?php echo $this->url(array('action' => 'delete', 'article_id' => $this->sesarticle->getIdentity()), 'sesarticle_specific', true);?>" class="smoothbox"><i class="fa fa-trash "></i><?php echo $this->translate('Delete This Article');?></a></li>
						<?php endif; ?>
						
					<?php endif;?>
					<?php if($this->viewer_id && isset($this->smallShareButtonActive) && $enableSharng):?>
						<li><a href="<?php echo $this->url(array("module" => "activity","controller" => "index","action" => "share", "type" => $this->sesarticle->getType(), "id" => $this->sesarticle->getIdentity(), "format" => "smoothbox"), 'default', true);?>" class="smoothbox share_icon"><i class="fa fa-share "></i> <?php echo $this->translate('Share');?></a></li>
					<?php endif;?>
					<?php if($this->viewer_id && $this->viewer_id != $this->sesarticle->owner_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.report', 1)):?>
						<li><a href="<?php echo $this->url(array("module" => "core","controller" => "report","action" => "create", 'subject' => $this->sesarticle->getGuid()),'default', true);?>" class="smoothbox report_link"><i class="fa fa-flag"></i><?php echo $this->translate('Report');?></a></li>
					<?php endif;?>
					<?php if(isset($this->postCommentActive) && $canComment):?>
						<li><a href="javascript:void(0);" class="sesarticle_comment"><i class="sesarticle_comment fa fa-commenting"></i><?php echo $this->translate('Post Comment');?></a></li>
          <?php endif;?>
				</ul>
			</div>
      <div class="sesarticle_shear_article sesbasic_bxs">
        <?php if(isset($this->socialShareActive) && $enableSharng):?>
        
          <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->sesarticle, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
			  <?php endif;?>
				<?php if($this->viewer_id && $enableSharng && isset($this->shareButtonActive)):?>
						<a href="<?php echo $this->url(array("module" => "activity","controller" => "index","action" => "share", "type" => $this->sesarticle->getType(), "id" => $this->sesarticle->getIdentity(), "format" => "smoothbox"), 'default', true);?>" class="share_icon sesbasic_icon_btn smoothbox"><i class="fa fa-share "></i><span><?php echo $this->translate('Share');?></span></a>
				<?php endif;?>
				<?php if($this->viewer_id):?>
					<?php if(isset($this->likeButtonActive) && $canComment):?>
							<a href="javascript:;" data-url="<?php echo $this->sesarticle->article_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_like_btn  sesarticle_like_sesarticle_<?php echo $this->sesarticle->article_id ?> sesarticle_like_sesarticle_view <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"><i class="fa <?php echo $likeClass;?>"></i><span><?php echo $this->translate($likeText);?></span></a>
					<?php endif;?>
					<?php if(isset($this->favouriteButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.favourite', 1)):?>
							<a href="javascript:;" data-url="<?php echo $this->sesarticle->article_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_fav_btn  sesarticle_favourite_sesarticle_<?php echo $this->sesarticle->article_id ?> sesarticle_favourite_sesarticle_view <?php echo ($favStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-heart"></i><span><?php if($favStatus):?><?php echo $this->translate('Un-Favourite');?><?php else:?><?php echo $this->translate('Favourite');?><?php endif;?></span></a>
					<?php endif;?>
        <?php endif;?>
			</div>
		</div>
	</div>
<?php elseif($this->sesarticle->style == 2):?>
	<!--second profile article start-->
	<div class="sesarticle_profile_layout_second sesbasic_clearfix sesbasic_bxs">

    <?php if(isset($this->photoActive) && $this->sesarticle->photo_id):?>
      <div class="sesarticle_profile_layout_second_image clear">
        <img src="<?php echo Engine_Api::_()->storage()->get($this->sesarticle->photo_id)->getPhotoUrl('thumb.main'); ?>" alt="">
      </div>
    <?php endif;?>
		
	  <?php if( $this->category ): ?>
    				<?php echo $this->translate('') ?>
  	<div class="sesarticle_category_teg">
     <p>   
				<a href="<?php echo $this->category->getHref(); ?>"><?php echo $this->translate($this->category->category_name) ?></a>
			</p>
		</div><?php endif; ?>
		<?php if(isset($this->titleActive)):?>
			<h2><?php echo $this->sesarticle->getTitle() ?></h2>
		<?php endif;?>
		<div class="sesarticle_entrylist_entry_date">
			<p><?php echo $this->translate('<i>Posted by -</i>');?> <?php echo $this->htmlLink($this->owner->getHref(), $this->owner->getTitle()) ?> &nbsp;\&nbsp;</p>
      <p><?php echo $this->translate('<i class="fa fa-calendar-o"></i>') ?>&nbsp;
			<?php echo $this->timestamp($this->sesarticle->publish_date) ?>
			<?php  ?>
			<?php if (count($this->sesarticleTags )):?> &nbsp;\&nbsp;
				</p>
        <p><?php echo $this->translate('<i>Filed in - </i>') ?>
				<a href="<?php echo $this->category->getHref(); ?>"><?php echo $this->translate($this->category->category_name) ?></a>
        &nbsp;\&nbsp;</p>
        <p>
        <?php foreach ($this->sesarticleTags as $tag): ?>
					<a href='javascript:void(0);' onclick='javascript:tagAction(<?php echo $tag->getTag()->tag_id; ?>);'><?php echo $tag->getTag()->text?></a>&nbsp;
				<?php endforeach; ?>
			<?php endif; ?>
			<?php if(isset($this->staticsActive)):?>
				&nbsp;\&nbsp;</p>
				<p>
				<?php if(isset($this->viewActive)):?>
					<span><i class="fa fa-eye"></i>&nbsp;
					<?php echo $this->translate(array('%s view', '%s views', $this->sesarticle->view_count), $this->locale()->toNumber($this->sesarticle->view_count)) ?>&nbsp;\&nbsp;</span>
				<?php endif;?>
				<?php if(isset($this->commentActive)):?>
					<span><i class="fa fa-comment"></i>&nbsp;<?php echo $this->translate(array('%s comment', '%s comments', $this->sesarticle->comment_count), $this->locale()->toNumber($this->sesarticle->comment_count)) ?>&nbsp;\&nbsp;</span>
				<?php endif;?>
				<?php if(isset($this->likeActive)):?>
					<span><i class="fa fa-thumbs-up"></i>&nbsp;<?php echo $this->translate(array('%s like', '%s likes', $this->sesarticle->like_count), $this->locale()->toNumber($this->sesarticle->like_count)) ?>&nbsp;\&nbsp;</span>
				<?php endif;?>
				<?php if(isset($this->reviewActive)):?>
					<span><i class="fa fa-edit"></i>&nbsp;<?php echo $this->translate(array('%s review', '%s reviews', $reviewCount), $this->locale()->toNumber($reviewCount)) ?></span>
				<?php endif;?>
				</p>
      <?php endif;?>
		</div>
		<?php if(isset($this->descriptionActive)):?>
			<?php if($this->sesarticle->cotinuereading){
					$check = true;
					$style = 'style="height:400px; overflow:hidden;"';
				}else{
					$check = false;
					$style = '';
				} ?>
				<div class="sesarticle_entrylist_entry_body rich_content_body" style="visibility:hidden"><?php echo $this->sesarticle->body;?></div>
				<?php if($check): ?>
					<div class="sesarticle_morebtn" style="display:none"><a href="javascript:void(0);" onclick="continuereading();"><?php echo $this->translate("Continue Reading"); ?></a></div>
				<?php endif; ?>
		<?php endif;?>
    <div class="sesarticle_view_footer_top clear sesbasic_clearfix">
      <?php if(isset($this->ratingActive)):?>
				<div class="sesbasic_rating_star floatL">
					<?php $ratingCount = $this->sesarticle->rating; $x=0; ?>
					<?php if( $ratingCount > 0 ): ?>
						<?php for( $x=1; $x<=$ratingCount; $x++ ): ?>
							<span id="" class="sesarticle_rating_star"></span>
						<?php endfor; ?>
						<?php if( (round($ratingCount) - $ratingCount) > 0){ ?>
						<span class="sesarticle_rating_star sesarticle_rating_star_half"></span>
						<?php }else{ $x = $x - 1;} ?>
						<?php if($x < 5){ 
						for($j = $x ; $j < 5;$j++){ ?>
						<span class="sesarticle_rating_star sesarticle_rating_star_disable"></span>
						<?php }   	
						} ?>
					<?php endif; ?>
				</div>
			<?php endif;?>
      <div class="sesarticle_view_footer_links floatR">
				<ul>
					<?php if(isset($this->ownerOptionsActive)):?>
          <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.subarticle', 1)){ ?>
						<li><a href="<?php echo $this->url(array('action' => 'create', 'parent_id' => $this->sesarticle->article_id), 'sesarticle_general', 'true');?>"><i class="fa fa-edit"></i><?php echo $this->translate('Create Sub Article');?>
            </a></li>
          <?php } ?>
						<?php if($this->sesarticle->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'edit')): ?>
							<li><a href="<?php echo $this->url(array('action' => 'edit', 'article_id' => $this->sesarticle->custom_url), 'sesarticle_dashboard', 'true');?>"><i class="fa fa-edit"></i><?php echo $this->translate('Dashboard');?></a></li>
						<?php endif; ?>	
						<?php if($this->sesarticle->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'delete')): ?>
							<li><a href="<?php echo $this->url(array('action' => 'delete', 'article_id' => $this->sesarticle->getIdentity()), 'sesarticle_specific', true);?>" class="smoothbox"><i class="fa fa-trash "></i><?php echo $this->translate('Delete This Article');?></a></li>
						<?php endif; ?>
					<?php endif;?>
					<?php if($this->viewer_id):?>
						<li><a href="<?php echo $this->url(array("module" => "activity","controller" => "index","action" => "share", "type" => $this->sesarticle->getType(), "id" => $this->sesarticle->getIdentity(), "format" => "smoothbox"), 'default', true);?>" class="smoothbox share_icon"><i class="fa fa-share "></i><?php echo $this->translate('Share');?></a></li>
					<?php endif;?>
					<?php if($this->viewer_id && $this->viewer_id != $this->sesarticle->owner_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.report', 1)):?>
						<li><a href="<?php echo $this->url(array("module" => "core","controller" => "report","action" => "create", 'subject' => $this->sesarticle->getGuid()),'default', true);?>" class="smoothbox report_link"><i class="fa fa-flag"></i><?php echo $this->translate('Report');?></a></li>
					<?php endif;?>
				</ul>
			</div>
    </div>
    <div class="sesarticle_view_footer_top_bottom clear sesbasic_clearfix">
			<div class="sesarticle_view_footer_links floatL">
        <ul>
          <?php if($this->viewer_id):?>
						<?php if(isset($this->likeButtonActive) && $canComment):?>
							<li><a href="javascript:;" data-url="<?php echo $this->sesarticle->article_id ; ?>" class="sesarticle_like_link  sesarticle_like_sesarticle_<?php echo $this->sesarticle->article_id ?> sesarticle_like_sesarticle_view"><i class="<?php if($LikeStatus):?>fa fa-thumbs-down<?php else:?>fa fa-thumbs-up<?php endif;?>"></i><span><?php if($LikeStatus):?><?php echo $this->translate('Unlike');?><?php else:?><?php echo $this->translate('Like');?><?php endif;?></span></a>&nbsp;/&nbsp;</li>
						<?php endif;?>
						<?php if(isset($this->favouriteButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.favourite', 1)):?>
							<li><a href="javascript:;" data-url="<?php echo $this->sesarticle->article_id ; ?>" class="sesarticle_fav_link sesarticle_favourite_sesarticle_<?php echo $this->sesarticle->article_id ?> sesarticle_favourite_sesarticle_view"><i class="fa fa-heart"></i><span><?php if($favStatus):?><?php echo $this->translate('Un-Favourite');?><?php else:?><?php echo $this->translate('Favourite');?><?php endif;?></span></a>&nbsp;/&nbsp;</li>
						<?php endif;?>
					<?php endif;?>
					<?php if(isset($this->postCommentActive) && $canComment):?>
						<li><a href="javascript:void(0);" class="sesarticle_comment"><i class="sesarticle_comment fa fa-commenting"></i><span><?php echo $this->translate('Post Comment');?></span></a></li>
          <?php endif;?>
        </ul>
			</div>
			<?php if(isset($this->socialShareActive)):?>
				<div class="sesarticle_view_footer_social_share floatR">
					<?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->sesarticle, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
				</div>
			<?php endif;?>
		</div>
	</div>
	<!--second profile article end-->
<?php elseif($this->sesarticle->style == 3):?>
	<!--three profile article start-->
	<div class="sesarticle_profile_layout_three sesbasic_clearfix sesbasic_bxs">
		<?php if(isset($this->ratingActive)):?>
			<div class="sesbasic_rating_star floatR">
				<?php $ratingCount = $this->sesarticle->rating; $x=0; ?>
				<?php if( $ratingCount > 0 ): ?>
					<?php for( $x=1; $x<=$ratingCount; $x++ ): ?>
						<span id="" class="sesarticle_rating_star"></span>
					<?php endfor; ?>
					<?php if( (round($ratingCount) - $ratingCount) > 0){ ?>
					<span class="sesarticle_rating_star sesarticle_rating_star_half"></span>
					<?php }else{ $x = $x - 1;} ?>
					<?php if($x < 5){ 
					for($j = $x ; $j < 5;$j++){ ?>
					<span class="sesarticle_rating_star sesarticle_rating_star_disable"></span>
					<?php }   	
					} ?>
				<?php endif; ?>
			</div>
		<?php endif;?>
    <?php if(isset($this->titleActive)):?>
			<h2><?php echo $this->sesarticle->getTitle() ?></h2>
		<?php endif;?>
		<div class="sesarticle_entrylist_entry_date">
      <?php if( $this->category ): ?>
				<p class="catogery floatR">
				<?php echo $this->translate('<i class="fa fa-folder"></i>') ?>
				<a href="<?php echo $this->category->getHref(); ?>"><?php echo $this->translate($this->category->category_name) ?></a>
				</p>
      <?php endif; ?>
			<p class="">
      	<span><i class=" fa fa-user"></i> <?php echo $this->translate('');?> <?php echo $this->htmlLink($this->owner->getHref(), $this->owner->getTitle()) ?></span>
      	<span><?php echo $this->translate('<i class="fa fa-calendar-o"></i>') ?>&nbsp;<?php echo $this->timestamp($this->sesarticle->publish_date) ?></span>
      	<?php if(isset($this->staticsActive)):?>
      	  <?php if(isset($this->viewActive)):?>
						<span><i class="fa fa-eye"></i> <?php echo $this->translate(array('%s view', '%s views', $this->sesarticle->view_count), $this->locale()->toNumber($this->sesarticle->view_count)) ?></span>
					<?php endif;?>
					<?php if(isset($this->commentActive)):?>
						<span><i class="fa fa-comment"></i><?php echo $this->translate(array('%s Comment', '%s Comments', $this->sesarticle->comment_count), $this->locale()->toNumber($this->sesarticle->comment_count)) ?></span>
					<?php endif;?>
					<?php if(isset($this->likeActive)):?>
						<span><i class="fa fa-thumbs-up"></i><?php echo $this->translate(array('%s Like', '%s Likes', $this->sesarticle->like_count), $this->locale()->toNumber($this->sesarticle->like_count)) ?></span>
					<?php endif;?>
					<?php if(isset($this->reviewActive)):?>
					<span><i class="fa fa-edit"></i><?php echo $this->translate(array('%s Review', '%s Reviews', $reviewCount), $this->locale()->toNumber($reviewCount)) ?></span>
					<?php endif;?>
				<?php endif;?>
				<?php if (count($this->sesarticleTags )):?>
					<span>
						<i class="fa fa-tag"></i>
						<?php foreach ($this->sesarticleTags as $tag): ?>
						<a href='javascript:void(0);' onclick='javascript:tagAction(<?php echo $tag->getTag()->tag_id; ?>);'><?php echo $tag->getTag()->text?></a>&nbsp;
					<?php endforeach; ?>
					</span>
				<?php endif; ?>
			</p>
		</div>
		<div class="sesarticle_entrylist_entry_body">
		  <?php if(isset($this->photoActive) && $this->sesarticle->photo_id):?>
				<div class="sesarticle_image clear" style="height: <?php echo $this->image_height ?>px;overflow: hidden;">
					<img src="<?php echo Engine_Api::_()->storage()->get($this->sesarticle->photo_id)->getPhotoUrl('thumb.main'); ?>" alt="">
				</div>
			<?php endif;?>
			<?php if(isset($this->descriptionActive)):?>
				<?php if($this->sesarticle->cotinuereading){
					$check = true;
					$style = 'style="height:400px; overflow:hidden;"';
				}else{
					$check = false;
					$style = '';
				} ?>
				<div class="rich_content_body" style="visibility:hidden"><?php echo $this->sesarticle->body;?></div>
				<?php if($check): ?>
					<div class="sesarticle_morebtn" style="display:none"><a href="javascript:void(0);" onclick="continuereading();"><?php echo $this->translate("Continue Reading"); ?></a></div>
				<?php endif; ?>
			<?php endif;?>	
		</div>
		<div class="sesarticle_three_article_footer">
    	<div class="sesarticle_three_article_footer_links floatL">
      <ul>
        <?php if(isset($this->likeButtonActive) && $canComment):?>
					<li><a href="javascript:;" data-url="<?php echo $this->sesarticle->article_id ; ?>" class="sesarticle_like_link sesarticle_like_sesarticle_<?php echo $this->sesarticle->article_id ?> sesarticle_like_sesarticle_view"><i class="<?php if($LikeStatus):?>fa fa-thumbs-down<?php else:?>fa fa-thumbs-up<?php endif;?>"></i><span><?php if($LikeStatus):?><?php echo $this->translate('Unlike');?><?php else:?><?php echo $this->translate('Like');?><?php endif;?></span></a>&nbsp;|&nbsp;</li>
        <?php endif;?>
        <?php if(isset($this->favouriteButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.favourite', 1)):?>
					<li><a href="javascript:;" data-url="<?php echo $this->sesarticle->article_id ; ?>" class="sesarticle_fav_link sesarticle_favourite_sesarticle_<?php echo $this->sesarticle->article_id ?> sesarticle_favourite_sesarticle_view"><i class="fa fa-heart"></i><span><?php if($favStatus):?><?php echo $this->translate('Un-Favourite');?><?php else:?><?php echo $this->translate('Favourite');?><?php endif;?></span></a>&nbsp;|&nbsp;	</li>
        <?php endif;?>
        <?php if(isset($this->postCommentActive) && $canComment):?>
					<li><a href="javascript:void(0);" class="sesarticle_comment"><i class="sesarticle_comment fa fa-commenting"></i><span><?php echo $this->translate('Post Comment');?></span></a></li>
        <?php endif;?>
      </ul>
			</div>
      <div class="sesarticle_three_article_footer_links floatR">
				<ul>
					<?php if(isset($this->ownerOptionsActive)):?>
          <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.subarticle', 1)){ ?>
						<li><a href="<?php echo $this->url(array('action' => 'create', 'parent_id' => $this->sesarticle->article_id), 'sesarticle_general', 'true');?>" class=""><i class="fa fa-edit"></i><?php echo $this->translate('Create Sub Article');?>
            </a>&nbsp;|&nbsp;</li>
          <?php } ?>
						<?php if($this->sesarticle->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'edit')): ?>
							<li><a href="<?php echo $this->url(array('action' => 'edit', 'article_id' => $this->sesarticle->custom_url), 'sesarticle_dashboard', 'true');?>" class=""><i class="fa fa-edit"></i><?php echo $this->translate('Dashboard');?></a>&nbsp;|&nbsp;</li>
						<?php endif; ?>
						<?php if($this->sesarticle->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'delete')): ?>
							<li><a href="<?php echo $this->url(array('action' => 'delete', 'article_id' => $this->sesarticle->getIdentity()), 'sesarticle_specific', true);?>" class="smoothbox"><i class="fa fa-trash "></i><?php echo $this->translate('Delete This Article');?></a>&nbsp;|&nbsp;</li>
						<?php endif; ?>
					<?php endif;?>
					<?php if($this->viewer_id):?>
						<li><a href="<?php echo $this->url(array("module" => "activity","controller" => "index","action" => "share", "type" => $this->sesarticle->getType(), "id" => $this->sesarticle->getIdentity(), "format" => "smoothbox"), 'default', true);?>" class="smoothbox share_icon"><i class="fa fa-share "></i><?php echo $this->translate('Share');?></a></li>
					<?php endif;?>
					<?php if($this->viewer_id && $this->viewer_id != $this->sesarticle->owner_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.report', 1)):?>
						<li><a href="<?php echo $this->url(array("module" => "core","controller" => "report","action" => "create", 'subject' => $this->sesarticle->getGuid()),'default', true);?>" class="smoothbox report_link"><i class="fa fa-flag"></i><?php echo $this->translate('Report');?></a></li>
					<?php endif;?>
				</ul>
			</div>
    </div>
    <?php if(isset($this->socialShareActive)):?>
			<div class="sesarticle_footer_article clear">
				<p><?php echo $this->translate('SHARE THIS STORY');?></p>
				<div class="sesarticle_footer_article_social_share sesbasic_clearfix">
            <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->sesarticle, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
				</div>
			</div>
		<?php endif;?>
	</div>
	<!--three profile article start-->
<?php elseif($this->sesarticle->style == 4):?>
	<div class="sesarticle_profile_layout_four sesbasic_clearfix sesbasic_bxs">
	 <?php if(isset($this->ratingActive)):?>
			<div class="sesbasic_rating_star floatR">
				<?php $ratingCount = $this->sesarticle->rating; $x=0; ?>
				<?php if( $ratingCount > 0 ): ?>
					<?php for( $x=1; $x<=$ratingCount; $x++ ): ?>
						<span id="" class="sesarticle_rating_star"></span>
					<?php endfor; ?>
					<?php if( (round($ratingCount) - $ratingCount) > 0){ ?>
					<span class="sesarticle_rating_star sesarticle_rating_star_half"></span>
					<?php }else{ $x = $x - 1;} ?>
					<?php if($x < 5){ 
					for($j = $x ; $j < 5;$j++){ ?>
					<span class="sesarticle_rating_star sesarticle_rating_star_disable"></span>
					<?php }   	
					} ?>
				<?php endif; ?>
			</div>
		<?php endif;?>
    <?php if(isset($this->titleActive)):?>
			<h2><?php echo $this->sesarticle->getTitle() ?></h2>
		<?php endif;?>
		<div class="sesarticle_entrylist_entry_date">
			<span class="sesarticle_entry_border"></span>
			<p>
				<span>
        <?php echo $this->translate('');?>&nbsp; <?php echo $this->htmlLink($this->owner->getHref(), 
        $this->itemPhoto($this->owner),
				array('class' => 'sesarticles_gutter_photo')) ?> <?php echo $this->htmlLink($this->owner->getHref(), $this->owner->getTitle()) ?> &nbsp;-&nbsp;</span>
				<span>
					<?php echo $this->translate('<i class="fa fa-calendar-o"></i>') ?>
					<?php echo $this->timestamp($this->sesarticle->creation_date) ?>
					&nbsp;-&nbsp;
        </span>
        <?php  ?>
				<?php if( $this->category ): ?>
					<span>
					<?php echo $this->translate('<i class="fa fa-tag"></i>') ?>
					<a href="<?php echo $this->category->getHref(); ?>"><?php echo $this->translate($this->category->category_name) ?></a>
				</span>
        <?php endif; ?>
        <?php if (count($this->sesarticleTags )):?>
					<span>
          <?php foreach ($this->sesarticleTags as $tag): ?>
						<a href='javascript:void(0);' onclick='javascript:tagAction(<?php echo $tag->getTag()->tag_id; ?>);'><?php echo $tag->getTag()->text?></a>&nbsp;
					<?php endforeach; ?>
					&nbsp;-&nbsp;
        </span>
        <?php endif; ?>
				<?php if(isset($this->staticsActive)):?>
				  <?php if(isset($this->viewActive)):?>
						<span><i class="fa fa-eye"></i>
						<?php echo $this->translate(array('%s view', '%s views', $this->sesarticle->view_count), $this->locale()->toNumber($this->sesarticle->view_count)) ?>
						&nbsp;-&nbsp;
						</span>
          <?php endif;?>
          <?php if(isset($this->commentActive)):?>
						<span><i class="fa fa-comment-o"></i><?php echo $this->translate(array('%s Comment', '%s Comments', $this->sesarticle->comment_count), $this->locale()->toNumber($this->sesarticle->comment_count)) ?>&nbsp;-&nbsp;</span>
					<?php endif;?>
					<?php if(isset($this->likeActive)):?>
						<span><i class="fa fa-thumbs-o-up"></i><?php echo $this->translate(array('%s Like', '%s Likes', $this->sesarticle->like_count), $this->locale()->toNumber($this->sesarticle->like_count)) ?>&nbsp;-&nbsp;</span>
					<?php endif;?>
					<?php if(isset($this->reviewActive)):?>
						<span><i class="fa fa-edit"></i><?php echo $this->translate(array('%s Review', '%s Reviews', $reviewCount), $this->locale()->toNumber($reviewCount)) ?></span>
					<?php endif;?>
				<?php endif;?>
			</p>
		</div>
		<div class="sesarticle_entrylist_entry_body">
		  <?php if(isset($this->photoActive) && $this->sesarticle->photo_id):?>
				<div class="sesarticle_image clear" style="height: <?php echo $this->image_height ?>px;overflow: hidden;">
					<img src="<?php echo Engine_Api::_()->storage()->get($this->sesarticle->photo_id)->getPhotoUrl('thumb.main'); ?>" alt="">
				</div>
			<?php endif;?>
		<div class="sesarticle_social_tabs sesbasic_clearfix">
				<?php if(isset($this->postCommentActive) && $canComment):?>
					<a href="javascript:void(0);" class="sesarticle_comment commenting"><i class="sesarticle_comment fa fa-comment"></i><?php echo ' '.$this->sesarticle->comment_count;?></a>
				<?php endif;?>
				<?php if(isset($this->likeButtonActive)):?>
					<a href="javascript:;" data-url="<?php echo $this->sesarticle->article_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesarticle_like_sesarticle_<?php echo $this->sesarticle->article_id ?> sesarticle_like_sesarticle <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $this->sesarticle->like_count; ?></span></a>
				<?php endif;?>
				<?php if(isset($this->favouriteButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.favourite', 1)):?>
						<a href="javascript:;" data-url="<?php echo $this->sesarticle->article_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sesarticle_favourite_sesarticle_<?php echo $this->sesarticle->article_id ?> sesarticle_favourite_sesarticle <?php echo ($favStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-heart"></i><span><?php echo $this->sesarticle->favourite_count; ?></span></a>
				<?php endif;?>
				<?php if(isset($this->socialShareActive)):?>
          <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->sesarticle, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
				<?php endif;?>
		</div>
			<?php if(isset($this->descriptionActive)):?>
				<?php if($this->sesarticle->cotinuereading){
					$check = true;
					$style = 'style="height:400px; overflow:hidden;"';
				}else{
					$check = false;
					$style = '';
				} ?>
				<div class="rich_content_body" style="visibility:hidden"><?php echo $this->sesarticle->body; ?></div>
				<?php if($check): ?>
					<div class="sesarticle_morebtn" style="display:none"><a href="javascript:void(0);" onclick="continuereading();"><?php echo $this->translate("Continue Reading"); ?></a></div>
				<?php endif; ?>
			<?php endif;?>
		</div>
    <div class="sesarticle_deshboard_links ">
        <?php if(isset($this->postCommentActive) && $canComment):?>
					<p class="profile_layout_fore_post_com floatL"><a href="javascript:void(0);" class="sesarticle_comment"><i class="sesarticle_comment fa fa-commenting"></i><span><?php echo $this->translate('Post Comment');?></span></a></p>
				<?php endif;?>
				<ul class="floatR">
					<?php if(isset($this->ownerOptionsActive)):?>
          <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.subarticle', 1)){ ?>
						<li><a href="<?php echo $this->url(array('action' => 'create', 'parent_id' => $this->sesarticle->article_id), 'sesarticle_general', 'true');?>" class="sesbasic_button "><i class="fa fa-edit"></i><?php echo $this->translate('Create Sub Article');?>
            </a></li>
          <?php } ?>
						<?php if($this->sesarticle->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'edit')): ?>
							<li><a href="<?php echo $this->url(array('action' => 'edit', 'article_id' => $this->sesarticle->custom_url), 'sesarticle_dashboard', 'true');?>" class="sesbasic_button "><i class="fa fa-edit"></i><?php echo $this->translate('Dashboard');?></a></li>
						<?php endif; ?>	
						<?php if($this->sesarticle->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'delete')): ?>
							<li><a href="<?php echo $this->url(array('action' => 'delete', 'article_id' => $this->sesarticle->getIdentity()), 'sesarticle_specific', true);?>" class="smoothbox sesbasic_button "><i class="fa fa-trash "></i><?php echo $this->translate('Delete This Article');?></a></li>
						<?php endif; ?>
					<?php endif;?>
					<?php if($this->viewer_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.sharing', 1)):?>
						<li><a href="<?php echo $this->url(array("module" => "activity","controller" => "index","action" => "share", "type" => $this->sesarticle->getType(), "id" => $this->sesarticle->getIdentity(), "format" => "smoothbox"), 'default', true);?>" class="smoothbox sesbasic_button  share_icon"><i class="fa fa-share "></i><?php echo $this->translate('Share');?></a></li>
					<?php endif;?>
					<?php if($this->viewer_id && $this->viewer_id != $this->sesarticle->owner_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.report', 1)):?>
						<li><a href="<?php echo $this->url(array("module" => "core","controller" => "report","action" => "create", 'subject' => $this->sesarticle->getGuid()),'default', true);?>" class="smoothbox sesbasic_button report_link"><i class="fa fa-flag"></i><?php echo $this->translate('Report');?></a></li>
					<?php endif;?>
				</ul>
			</div>
	</div>

<?php endif;?>

<script type="text/javascript">

	window.addEvent('domready', function() {
		var height = sesJqueryObject('.rich_content_body').height();
		<?php if($this->sesarticle->cotinuereading && $this->sesarticle->continue_height) { ?>
      if(height > '<?php echo $this->sesarticle->continue_height; ?>'){
        sesJqueryObject('.sesarticle_morebtn').css("display","block");
        sesJqueryObject('.rich_content_body').css("height",'<?php echo $this->sesarticle->continue_height; ?>');
        sesJqueryObject('.rich_content_body').css("overflow","hidden");
      }
		<?php } ?>
		sesJqueryObject('.rich_content_body').css("visibility","visible");
  });
  

  $$('.core_main_sesarticle').getParent().addClass('active');
  sesJqueryObject('.sesarticle_comment').click(function() {
    sesJqueryObject('.comments_options').find('a').eq(0).trigger('click');
    sesJqueryObject('#adv_comment_subject_btn_<?php echo $this->sesarticle->article_id; ?>').trigger('click');
  });
	
	function tagAction(tag_id){
		window.location.href = '<?php echo $this->url(array("action"=>"browse"),"sesarticle_general",true); ?>'+'?tag_id='+tag_id;
	}

	var logincheck = '<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.login.continuereading', 1); ?>';
	var viwerId = <?php echo $this->viewer_id ?>;
	function continuereading(){
		if(logincheck>0 && !viwerId){
			window.location.href = en4.core.baseUrl +'login';
		}else{
			sesJqueryObject('.rich_content_body').css('height', 'auto');
			sesJqueryObject('.sesarticle_morebtn').hide();
		}
	}
</script>
