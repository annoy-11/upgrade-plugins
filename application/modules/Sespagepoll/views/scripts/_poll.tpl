<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagepoll
 * @package    Sespagepoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _poll.tpl  2018-10-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php 
    $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespagepoll/externals/styles/styles.css');
  ?>
<?php
  $this->headScript()
    ->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sespagepoll/externals/scripts/core.js');
  $this->headTranslate(array(
    'Show Questions', 'Show Results', '%1$s%%', '%1$s vote',
  ));
 $isvoteShow = in_array("vote_count", $this->show_criteria)?true:false;
?>


<script type="text/javascript">
  //<![CDATA[

  en4.core.runonce.add(function() {
    var initializePoll = function() {
      en4.sespagepoll.urls.vote = '<?php echo $this->url(array('action' => 'vote'), 'sespagepoll_general') ?>';
      en4.sespagepoll.urls.login = '<?php echo $this->url(array(), 'user_login') ?>';
      en4.sespagepoll.addPollData(<?php echo $this->sespagepoll->getIdentity() ?>, {
        canVote : <?php echo $this->canVote ? 'true' : 'false' ?>,
        canChangeVote : <?php echo $this->canChangeVote ? 'true' : 'false' ?>,
        hasVoted : <?php echo $this->hasVoted ? 'true' : 'false' ?>,
        csrfToken : '<?php echo $this->sesVoteHash($this->sespagepoll)->generateHash()?>',
        isClosed : <?php echo $this->sespagepoll->closed ? 'true' : 'false' ?>
      });
	   $$('#sespagepoll_form_<?php echo $this->sespagepoll->getIdentity() ?> .sespagepoll_vote').removeEvents('click').addEvent('click', function(event) {
		  var isVoteShow = <?php echo $isvoteShow ? 'true' : 'false' ?>;
		en4.sespagepoll.vote(<?php echo $this->sespagepoll->getIdentity() ?>, $("sespagepoll_option_"+this.get("id")) , isVoteShow);
      });
    }
    // Dynamic loading for feed
    if( $type(en4) == 'object' && 'sespagepoll' in en4 ) {
      initializePoll();
    } else {
      new Asset.javascript(en4.core.staticBaseUrl + 'application/modules/Sespagepoll/externals/scripts/core.js', {
        onload: function() {
          initializePoll();
        }
      });
    }
  });
  //]]>
</script>
<span class="sespagepoll_view_single sesbasic_bxs">
  <form id="sespagepoll_form_<?php echo $this->sespagepoll->getIdentity() ?>" action="<?php echo $this->url() ?>" method="POST" onsubmit="return false;">
    <ul id="sespagepoll_options_<?php echo $this->sespagepoll->getIdentity() ?>" class="sespagepoll_options">
     <?php // <div style="display:flex;"> ?>
	<?php foreach( $this->pollOptions as $i => $option ):?>
	  <?php if($option->file_id >0 && $option->image_type>0): ?>
     <?php //<div class="sespagepoll_img_box"> ?>
      <li id="sespagepoll_item_option_<?php echo $option->poll_option_id ?>" class="sespagepoll_with_img ">
        <div class="sespagepoll_has_voted" <?php echo ( $this->hasVoted ? '' : 'style="display:none;"' ) ?>>
					<div class="sespagepoll_has_voted_inner">
						<?php $pct = $this->sespagepoll->vote_count? floor(100*($option->votes/$this->sespagepoll->vote_count)): 0;
						if (!$pct)
							$pct = 1;?>
						<?php if($option->file_id >0){
						$gifUrl = ($storage = Engine_Api::_()->storage()->get($option->file_id, '')) ? $storage->map() : "";?>
						<div class="sespagepoll_img">
							<img src ="<?php echo $gifUrl ?>">
							<div class="sespagepoll_img_overlay_inner">
								<div class="sespagepoll_img_overlay">
									<div class="sespagepoll_percent">
										<div id="sespagepoll-answer-<?php echo $option->poll_option_id ?>" class='sespagepoll_answer sespagepoll-answer-<?php echo (($i%8)+1) ?>'
												style='width: <?php echo 1*$pct; ?>%;'>
													&nbsp;
										</div>
									</div>
									<div class="sespagepoll_answer_total">
										<?php echo $this->translate(array('%1$s vote', '%1$s votes', $option->votes), $this->locale()->toNumber($option->votes)) ?>
										(<?php echo $this->translate('%1$s%%', $this->locale()->toNumber($option->votes ? $pct : 0)) ?>)
									</div>
								</div>
							</div>
							<?php } ?>
						</div>
            <div class="sespagepoll_img_users">
              <div class="sespagepoll_optioncontent">
                <div class="sespagepoll_option">
                  <?php echo $option->poll_option ?>
                </div>
              </div>
						<div class="sespagepoll_answer_user" id="sespagepoll_user_photo_<?php echo $option->poll_option_id ?>">
							<?php
							$tables = Engine_Api::_()->getDbtable('votes', 'sespagepoll')->getVotesPaginator($option->poll_option_id)->setItemCountPerPage(5)->setCurrentPageNumber(1);
							$pagecount = $tables->getPages()->pageCount;
							foreach($tables as $table){
								$user = Engine_Api::_()->getItem('user', $table->user_id);
								if($user->getPhotoUrl('thumb.normal')){
								?>
								<div>
									<a href="<?php echo $user->getHref();?>"><span class="bg_item_photo" style="background-image:url(<?php echo $user->getPhotoUrl('thumb.normal'); ?>);"></span></a>
								</div>
								<?php }
							}
							if($pagecount >1 ){ ?>
								<div>
									<a class="more_user" id="<?php echo $option->poll_option_id ?>"><i class="fa fa-ellipsis-h"></i></a>
								</div>
							<?php }  ?>
						</div>
					</div>
        </div>
        </div>
        <div class="sespagepoll_not_voted" <?php echo ($this->hasVoted?'style="display:none;"':'') ?> >
          <div class="sespagepoll_not_voted_inner">
						<div class ="sespagepoll_vote" style="cursor: pointer;" id="<?php echo $option->poll_option_id ?>" >
							<div class="sespagepoll_imginfo" >
								<?php if($option->file_id){
								$gifUrl = ($storage = Engine_Api::_()->storage()->get($option->file_id, '')) ? $storage->map() : "";
								?>
								<div class="sespagepoll_img">
									<img src ="<?php echo $gifUrl ?>">
								</div>
								<?php } ?>
								<div class="sespagepoll_optioncontent">
									<div class="sespagepoll_radio" id="sespagepoll_radio_<?php echo $option->poll_option_id ?>">
										<input id="sespagepoll_option_<?php echo $option->poll_option_id ?>"
											 type="radio" name="sespagepoll_options" value="<?php echo $option->poll_option_id ?>"
											 <?php if( $this->hasVoted == $option->poll_option_id ): ?>checked="true"<?php endif; ?>
											 <?php if( ($this->hasVoted && !$this->canChangeVote) || $this->sespagepoll->closed ): ?>disabled="true"<?php endif; ?>
											 />
											 <span class="checkmark"></span>
									</div>
									<label for="sespagepoll_option_<?php echo $option->poll_option_id ?>">
										<?php echo $option->poll_option ?>
									</label>
								</div>
							</div>
						</div>
					</div>
      </li>
    <?php //  </div> ?>
		<?php else: ?>
			<li id="sespagepoll_item_option_<?php echo $option->poll_option_id ?>" class="sespagepoll_resultview">
				<div class="sespagepoll_has_voted" <?php echo ( $this->hasVoted ? '' : 'style="display:none;"' ) ?>>
					<div class="sespagepoll_option">
						<?php echo $option->poll_option ?>
					</div>
					<?php $pct = $this->sespagepoll->vote_count? floor(100*($option->votes/$this->sespagepoll->vote_count)):0;if (!$pct)
						$pct = 1;?>
					<div class="sespagepoll_percentage_bar">
						<div id="sespagepoll-answer-<?php echo $option->poll_option_id ?>" class='sespagepoll_answer sespagepoll-answer-<?php echo (($i%8)+1) ?>' style='width: <?php echo 1*$pct; ?>%;'>
						&nbsp;
						</div>
					</div>
					<div class="sespagepoll_answer_total">
					 <?php echo $this->translate(array('%1$s vote', '%1$s votes', $option->votes), $this->locale()->toNumber($option->votes)) ?>
						(<?php echo $this->translate('%1$s%%', $this->locale()->toNumber($option->votes ? $pct : 0)) ?>)
					</div>
					<div class="sespagepoll_answer_user" id="sespagepoll_user_photo_<?php echo $option->poll_option_id ?>">
						<?php
						$tables = Engine_Api::_()->getDbtable('votes', 'sespagepoll')->getVotesPaginator($option->poll_option_id)->setItemCountPerPage(5)->setCurrentPageNumber(1);
						$pagecount = $tables->getPages()->pageCount;
						foreach($tables as $table){
							$user = Engine_Api::_()->getItem('user', $table->user_id);
							if($user->getPhotoUrl('thumb.notmal')){
							?>
								<div>
									<a href="<?php echo $user->getHref();?>"><span class="bg_item_photo" style="background-image:url(<?php echo $user->getPhotoUrl('thumb.notmal'); ?>);"></span></a>
								</div><?php }}
						if($pagecount >1 ){ ?>
							<div>
								<a class="more_user" id="<?php echo $option->poll_option_id ?>"><i class="fa fa-ellipsis-h"></i></a>
							</div>
						<?php }  ?>
					</div>
				</div>
				<div class="sespagepoll_not_voted" <?php echo ($this->hasVoted?'style="display:none;"':'') ?> >
					<div class="sespagepoll_simpleview">
						<div class ="sespagepoll_vote" style="cursor: pointer;" id="<?php echo $option->poll_option_id ?>" >
							<div class="sespagepoll_radio" id="sespagepoll_radio_<?php echo $option->poll_option_id ?>">
								<input id="sespagepoll_option_<?php echo $option->poll_option_id ?>" type="radio" name="sespagepoll_options" value="<?php echo $option->poll_option_id ?>"
								<?php if( $this->hasVoted == $option->poll_option_id ): ?>checked="true"<?php endif; ?><?php if( ($this->hasVoted && !$this->canChangeVote) || $this->sespagepoll->closed ): ?>disabled="true"<?php endif; ?>/>
								<span class="checkmark"></span>
							</div>
                                                </div>
							<label for="sespagepoll_option_<?php echo $option->poll_option_id ?>">
								<?php echo $option->poll_option ?>
							</label>
						</div>
					
					<?php if($option->file_id){
					$gifUrl = Engine_Api::_()->storage()->get($option->file_id, '')->map();?>
						<img src ="<?php echo $gifUrl ?>">
					<?php } ?>
				</div>
			</li>
	  <?php endif ?>
	<?php endforeach; ?>
<?php // </div> ?>
</ul>
    <?php if( empty($this->hideStats) ): ?>
    <div class="sespagepoll_stats">
    <div class="sespage_poll_icons">
      <a href='javascript:void(0);' onClick='en4.sespagepoll.toggleResults(<?php echo $this->sespagepoll->getIdentity() ?>); this.blur();' class="sespagepoll_toggleResultsLink">
        <?php echo $this->translate($this->hasVoted ? 'Show Questions' : 'Show Results' ) ?>
      </a>
      <div class="sespagepoll_option_view">
      <a href="javascript:;" class="sesbasic_pulldown_toggle"><i class="fa fa-ellipsis-h"></i></a>
      <div class="sesbasic_pulldown_options">
      <?php if( empty($this->hideLinks) ): ?>

      <?php echo $this->htmlLink(array(
        'module'=>'core',
        'controller'=>'report',
        'action'=>'create',
        'route'=>'default',
        'subject'=>$this->sespagepoll->getGuid(),
        'format' => 'smoothbox'
      ), $this->translate("Report"), array('class' => 'smoothbox sespagepoll_report')); ?>
      <?php endif; ?>
      <?php if( $this->canEdit && !$this->sespagepoll->vote_count>0 ): ?>

      <?php echo $this->htmlLink(array(
            'route' => 'sespagepoll_specific',
            'action' => 'edit',
            'poll_id' => $this->sespagepoll->getIdentity(),
            'reset' => true,
          ), $this->translate('Edit Poll'), array(
            'class' => 'sespagepoll_privacy',
			'id'=>'sespagepoll_edit_link'
          )) ?>
      <?php endif; ?>
      <?php if( $this->canDelete && !$this->sespagepoll->vote_count>0 ) : ?>
      <?php echo $this->htmlLink(array(
            'route' => 'sespagepoll_specific',
            'action' => 'delete',
            'poll_id' => $this->sespagepoll->getIdentity(),
            'format' => 'smoothbox'
          ), $this->translate('Delete Poll'), array(
            'class' => 'smoothbox sespagepoll_del',
			'id'=>'sespagepoll_delete_link'
          )) ?>
      <?php endif; ?>
			<?php 
			$poll = $this->sespagepoll;
			$viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
			$owner_id = $poll->getOwner()->getIdentity();
			?>
			<?php if($owner_id == $viewer_id): ?>
			 <?php if( !$poll->closed ): ?>
            <?php echo $this->htmlLink(array(
              'route' => 'sespagepoll_specific',
              'action' => 'close',
              'poll_id' => $this->sespagepoll->getIdentity(),
              'closed' => 1,
            ), $this->translate('Close Poll'), array(
              'class' => 'buttonlink icon_poll_close'
            )) ?>
          <?php else: ?>
            <?php echo $this->htmlLink(array(
              'route' => 'sespagepoll_specific',
              'action' => 'close',
              'poll_id' => $this->sespagepoll->getIdentity(),
              'closed' => 0,
            ), $this->translate('Open Poll'), array(
              'class' => 'buttonlink icon_poll_open'
            )) ?>
          <?php endif; ?>
			<?php endif ?>
	  </div>
    </div>
      <?php
      $value['resource_type'] = 'sespagepoll_poll';
      $value['resource_id'] = $this->sespagepoll->poll_id;
       $tableFav = Engine_Api::_()->getDbTable('favourites', 'sespagepoll')->isFavourite($value);
      ?>
        <!-- polls like favourite -->
		<div class="_btnsleft">
		  <?php $viewer = Engine_Api::_()->user()->getViewer();?>
            <?php $viewerId = $viewer->getIdentity();?>
            <?php if($viewerId ):?>
            <?php $canComment = Engine_Api::_()->authorization()->isAllowed('sespagepoll_poll', $viewer, 'create');?>
            <?php  if($canComment && in_array("likeButton", $this->show_criteria)):?>
            <?php $likeStatus = Engine_Api::_()->sespage()->getLikeStatus($this->sespagepoll->poll_id,$this->sespagepoll->getType()); ?>
			  <a href="javascript:;" data-type="like_view" data-url="<?php echo $this->sespagepoll->poll_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sespagepoll_like sespagepoll_like_<?php echo $this->sespagepoll->poll_id ?> sespagepoll_likefavfollow <?php echo ($likeStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-thumbs-up"></i><span><?php echo $this->sespagepoll->like_count;?></span></a>
            <?php endif;?>
            <?php if( Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagepoll.allow.favourite', 1) && in_array("favouriteButton", $this->show_criteria)):?>
            <?php 	$value['resource_type'] = $this->sespagepoll->getType();
						$value['resource_id'] = $this->sespagepoll->poll_id;
						$favouriteStatus = Engine_Api::_()->getDbTable('Favourites', 'sespagepoll')->isFavourite($value);
				$favouriteStatus = Engine_Api::_()->getDbTable('favourites', 'sespagepoll')->isFavourite(array('resource_id' => $this->sespagepoll->poll_id,'resource_type' => $this->sespagepoll->getType())); ?>
				<a href="javascript:;" data-type="favourite_view" data-url="<?php echo $this->sespagepoll->poll_id ; ?>" class="sesbasic_icon_btn favrite sesbasic_icon_btn_count sespagepoll_fav sesbasic_icon_fav_btn sespagepoll_favourite_<?php echo $this->sespagepoll->poll_id ?> sespagepoll_likefavfollow <?php echo ($favouriteStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-heart"></i><span><?php echo $this->sespagepoll->favourite_count;?></span></a>
            <?php endif;?>
            <?php endif;?>
            <?php  // endif;?>
	
        <!-- polls end  polls like favourite -->
        <?php $shareType = Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagepoll.allow.share', 1);?>
        <!-- social share -->
        <?php if($shareType && in_array("socialSharing", $this->show_criteria)):?>
        <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->sespagepoll, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
        <?php endif;?>
        	</div>
          </div>
        <!-- social share end -->
				<?php $item = $this->sespagepoll; ?>
      <div class="stats sesbasic_text_light">
				<?php if(in_array("likecount", $this->show_criteria)): ?>
				<span class="like_count" title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber(	$item->like_count)) ?>">
										<i class="fa fa-thumbs-up"></i> <span><?php echo $item->like_count ;?></span>
									</span>
				<?php endif; ?>
				<?php if(in_array("votecount", $this->show_criteria)): ?>
					<span class="sespagepoll_vote_total"  title="<?php echo $this->translate(array('%s vote', '%s votes', $item->vote_count), $this->locale()->toNumber($item->vote_count)) ?>">
						<i class="fa fa-hand-o-up"></i> <span><?php echo $item->vote_count ;?></span>
					</span>
				<?php endif; ?>
				<?php if(in_array("viewcount", $this->show_criteria)): ?>
					<span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber(	$item->view_count)) ?>">
						<i class="fa fa-eye"></i> <span><?php echo $item->view_count ;?></span>
					</span>
				<?php endif; ?>
				<?php if(in_array("favouritecount", $this->show_criteria)): ?>
					<span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber(	$item->favourite_count)) ?>">
						<i class="fa fa-heart-o"></i> <span><?php echo $item->favourite_count ;?></span>
					</span>
				<?php endif; ?>
			</div>
    </div>
    <?php endif; ?>
  </form>
</span>

