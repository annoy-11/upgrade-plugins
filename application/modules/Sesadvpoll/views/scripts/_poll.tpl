<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvpoll
 * @package    Sesadvpoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _poll.tpl  2018-12-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php 
    $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesadvpoll/externals/styles/styles.css');
  ?>
<?php
  $this->headScript()
    ->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesadvpoll/externals/scripts/core.js');
  $this->headTranslate(array(
    'Show Questions', 'Show Results', '%1$s%%', '%1$s vote',
  ));
 $isvoteShow = in_array("vote_count", $this->show_criteria)?true:false;
?>


<script type="text/javascript">
  //<![CDATA[

  en4.core.runonce.add(function() {
    var initializePoll = function() {
      en4.sesadvpoll.urls.vote = '<?php echo $this->url(array('action' => 'vote'), 'sesadvpoll_general') ?>';
      en4.sesadvpoll.urls.login = '<?php echo $this->url(array(), 'user_login') ?>';
      en4.sesadvpoll.addPollData(<?php echo $this->sesadvpoll->getIdentity() ?>, {
        canVote : <?php echo $this->canVote ? 'true' : 'false' ?>,
        canChangeVote : <?php echo $this->canChangeVote ? 'true' : 'false' ?>,
        hasVoted : <?php echo $this->hasVoted ? 'true' : 'false' ?>,
        csrfToken : '<?php echo $this->sesadvpollVoteHash($this->sesadvpoll)->generateHash()?>',
        isClosed : <?php echo $this->sesadvpoll->closed ? 'true' : 'false' ?>
      });
	   $$('#sesadvpoll_form_<?php echo $this->sesadvpoll->getIdentity() ?> .sesadvpoll_vote').removeEvents('click').addEvent('click', function(event) {
		  var isVoteShow = <?php echo $isvoteShow ? 'true' : 'false' ?>;
		en4.sesadvpoll.vote(<?php echo $this->sesadvpoll->getIdentity() ?>, $("sesadvpoll_option_"+this.get("id")) , isVoteShow);
      });
    }
    // Dynamic loading for feed
    if( $type(en4) == 'object' && 'sesadvpoll' in en4 ) {
      initializePoll();
    } else {
      new Asset.javascript(en4.core.staticBaseUrl + 'application/modules/Sesadvpoll/externals/scripts/core.js', {
        onload: function() {
          initializePoll();
        }
      });
    }
  });
  //]]>
</script>
<span class="sesadvpoll_view_single sesbasic_bxs">
  <form id="sesadvpoll_form_<?php echo $this->sesadvpoll->getIdentity() ?>" action="<?php echo $this->url() ?>" method="POST" onsubmit="return false;">
    <ul id="sesadvpoll_options_<?php echo $this->sesadvpoll->getIdentity() ?>" class="sesadvpoll_options">
     <?php // <div style="display:flex;"> ?>
	<?php foreach( $this->pollOptions as $i => $option ):?>
	  <?php if($option->file_id >0 && $option->image_type>0): ?>
     <?php //<div class="sesadvpoll_img_box"> ?>
      <li id="sesadvpoll_item_option_<?php echo $option->poll_option_id ?>" class="sesadvpoll_with_img ">
        <div class="sesadvpoll_has_voted" <?php echo ( $this->hasVoted ? '' : 'style="display:none;"' ) ?>>
					<div class="sesadvpoll_has_voted_inner">
						<?php $pct = $this->sesadvpoll->vote_count? floor(100*($option->votes/$this->sesadvpoll->vote_count)): 0;
						if (!$pct)
							$pct = 1;?>
						<?php if($option->file_id >0){
						$gifUrl = ($storage = Engine_Api::_()->storage()->get($option->file_id, '')) ? $storage->map() : "";?>
						<div class="sesadvpoll_img">
							<img src ="<?php echo $gifUrl ?>">
							<div class="sesadvpoll_img_overlay_inner">
								<div class="sesadvpoll_img_overlay">
									<div class="sesadvpoll_percent">
										<div id="sesadvpoll-answer-<?php echo $option->poll_option_id ?>" class='sesadvpoll_answer sesadvpoll-answer-<?php echo (($i%8)+1) ?>'
												style='width: <?php echo 1*$pct; ?>%;'>
													&nbsp;
										</div>
									</div>
									<div class="sesadvpoll_answer_total">
										<?php echo $this->translate(array('%1$s vote', '%1$s votes', $option->votes), $this->locale()->toNumber($option->votes)) ?>
										(<?php echo $this->translate('%1$s%%', $this->locale()->toNumber($option->votes ? $pct : 0)) ?>)
									</div>
								</div>
							</div>
							<?php } ?>
						</div>
            <div class="sesadvpoll_img_users">
              <div class="sesadvpoll_optioncontent">
                <div class="sesadvpoll_option">
                  <?php echo $option->poll_option ?>
                </div>
              </div>
						<div class="sesadvpoll_answer_user" id="sesadvpoll_user_photo_<?php echo $option->poll_option_id ?>">
							<?php
							$tables = Engine_Api::_()->getDbtable('votes', 'sesadvpoll')->getVotesPaginator($option->poll_option_id)->setItemCountPerPage(5)->setCurrentPageNumber(1);
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
        <div class="sesadvpoll_not_voted" <?php echo ($this->hasVoted?'style="display:none;"':'') ?> >
          <div class="sesadvpoll_not_voted_inner">
						<div class ="sesadvpoll_vote" style="cursor: pointer;" id="<?php echo $option->poll_option_id ?>" >
							<div class="sesadvpoll_imginfo" >
								<?php if($option->file_id){
								$gifUrl = ($storage = Engine_Api::_()->storage()->get($option->file_id, '')) ? $storage->map() : "";
								?>
								<div class="sesadvpoll_img">
									<img src ="<?php echo $gifUrl ?>">
								</div>
								<?php } ?>
								<div class="sesadvpoll_optioncontent">
                  <?php if($this->canVote) { ?>
									<div class="sesadvpoll_radio" id="sesadvpoll_radio_<?php echo $option->poll_option_id ?>">
										<input id="sesadvpoll_option_<?php echo $option->poll_option_id ?>"
											 type="radio" name="sesadvpoll_options" value="<?php echo $option->poll_option_id ?>"
											 <?php if( $this->hasVoted == $option->poll_option_id ): ?>checked="true"<?php endif; ?>
											 <?php if( ($this->hasVoted && !$this->canChangeVote) || $this->sesadvpoll->closed ): ?> disabled="true"<?php endif; ?>
											 />
											 <span class="checkmark"></span>
									</div>
									<?php } ?>
									<label for="sesadvpoll_option_<?php echo $option->poll_option_id ?>">
										<?php echo $option->poll_option ?>
									</label>
								</div>
							</div>
						</div>
					</div>
      </li>
    <?php //  </div> ?>
		<?php else: ?>
			<li id="sesadvpoll_item_option_<?php echo $option->poll_option_id ?>" class="sesadvpoll_resultview">
				<div class="sesadvpoll_has_voted" <?php echo ( $this->hasVoted ? '' : 'style="display:none;"' ) ?>>
					<div class="sesadvpoll_option">
						<?php echo $option->poll_option ?>
					</div>
					<?php $pct = $this->sesadvpoll->vote_count? floor(100*($option->votes/$this->sesadvpoll->vote_count)):0;if (!$pct)
						$pct = 1;?>
					<div class="sesadvpoll_percentage_bar">
						<div id="sesadvpoll-answer-<?php echo $option->poll_option_id ?>" class='sesadvpoll_answer sesadvpoll-answer-<?php echo (($i%8)+1) ?>' style='width: <?php echo 1*$pct; ?>%;'>
						&nbsp;
						</div>
					</div>
					<div class="sesadvpoll_answer_total">
					 <?php echo $this->translate(array('%1$s vote', '%1$s votes', $option->votes), $this->locale()->toNumber($option->votes)) ?>
						(<?php echo $this->translate('%1$s%%', $this->locale()->toNumber($option->votes ? $pct : 0)) ?>)
					</div>
					<div class="sesadvpoll_answer_user" id="sesadvpoll_user_photo_<?php echo $option->poll_option_id ?>">
						<?php
						$tables = Engine_Api::_()->getDbtable('votes', 'sesadvpoll')->getVotesPaginator($option->poll_option_id)->setItemCountPerPage(5)->setCurrentPageNumber(1);
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
				<div class="sesadvpoll_not_voted" <?php echo ($this->hasVoted?'style="display:none;"':'') ?> >
					<div class="sesadvpoll_simpleview">
            <?php if($this->canVote) { ?>
              <div class ="sesadvpoll_vote" style="cursor: pointer;" id="<?php echo $option->poll_option_id ?>" >
                <div class="sesadvpoll_radio" id="sesadvpoll_radio_<?php echo $option->poll_option_id ?>">
                  <input id="sesadvpoll_option_<?php echo $option->poll_option_id ?>" type="radio" name="sesadvpoll_options" value="<?php echo $option->poll_option_id ?>"
                  <?php if( $this->hasVoted == $option->poll_option_id ): ?> checked="true"<?php endif; ?><?php if( ($this->hasVoted && !$this->canChangeVote) || $this->sesadvpoll->closed ): ?>disabled="true"<?php endif; ?>/>
                  <span class="checkmark"></span>
                </div>
              </div>
            <?php } ?>
							<label for="sesadvpoll_option_<?php echo $option->poll_option_id ?>">
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
    <div class="sesadvpoll_stats">
    <div class="sesadvpoll_icons">
      <a href='javascript:void(0);' onClick='en4.sesadvpoll.toggleResults(<?php echo $this->sesadvpoll->getIdentity() ?>); this.blur();' class="sesadvpoll_toggleResultsLink">
        <?php echo $this->translate($this->hasVoted ? 'Show Questions' : 'Show Results' ) ?>
      </a>
      <div class="sesadvpoll_option_view">
      <a href="javascript:;" class="sesbasic_pulldown_toggle"><i class="fa fa-ellipsis-h"></i></a>
      <div class="sesbasic_pulldown_options">
      <?php if( empty($this->hideLinks) ): ?>

      <?php echo $this->htmlLink(array(
        'module'=>'core',
        'controller'=>'report',
        'action'=>'create',
        'route'=>'default',
        'subject'=>$this->sesadvpoll->getGuid(),
        'format' => 'smoothbox'
      ), $this->translate("Report"), array('class' => 'smoothbox sesadvpoll_report')); ?>
      <?php endif; ?>
      <?php if( $this->canEdit && !$this->sesadvpoll->vote_count > 0 ): ?>

      <?php echo $this->htmlLink(array(
            'route' => 'sesadvpoll_specific',
            'action' => 'edit',
            'poll_id' => $this->sesadvpoll->getIdentity(),
            'reset' => true,
          ), $this->translate('Edit Poll'), array(
            'class' => 'sesadvpoll_privacy',
			'id'=>'sesadvpoll_edit_link'
          )) ?>
      <?php endif; ?>
      <?php if( $this->canDelete && !$this->sesadvpoll->vote_count>0 ) : ?>
      <?php echo $this->htmlLink(array(
            'route' => 'sesadvpoll_specific',
            'action' => 'delete',
            'poll_id' => $this->sesadvpoll->getIdentity(),
            'format' => 'smoothbox'
          ), $this->translate('Delete Poll'), array(
            'class' => 'smoothbox sesadvpoll_del',
			'id'=>'sesadvpoll_delete_link'
          )) ?>
      <?php endif; ?>
			<?php 
			$poll = $this->sesadvpoll;
			$viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
			$owner_id = $poll->getOwner()->getIdentity();
			?>
			<?php if($owner_id == $viewer_id): ?>
			 <?php if( !$poll->closed ): ?>
            <?php echo $this->htmlLink(array(
              'route' => 'sesadvpoll_specific',
              'action' => 'close',
              'poll_id' => $this->sesadvpoll->getIdentity(),
              'closed' => 1,
            ), $this->translate('Close Poll'), array(
              'class' => 'buttonlink icon_poll_close'
            )) ?>
          <?php else: ?>
            <?php echo $this->htmlLink(array(
              'route' => 'sesadvpoll_specific',
              'action' => 'close',
              'poll_id' => $this->sesadvpoll->getIdentity(),
              'closed' => 0,
            ), $this->translate('Open Poll'), array(
              'class' => 'buttonlink icon_poll_open'
            )) ?>
          <?php endif; ?>
			<?php endif ?>
	  </div>
    </div>
      <?php
      $value['resource_type'] = 'sesadvpoll_poll';
      $value['resource_id'] = $this->sesadvpoll->poll_id;
       $tableFav = Engine_Api::_()->getDbTable('favourites', 'sesadvpoll')->isFavourite($value);
      ?>
        <!-- polls like favourite -->
		<div class="_btnsleft">
		  <?php $viewer = Engine_Api::_()->user()->getViewer();?>
            <?php $viewerId = $viewer->getIdentity();?>
            <?php if($viewerId ):?>
            <?php $canComment = Engine_Api::_()->authorization()->isAllowed('sesadvpoll_poll', $viewer, 'create');?>
            <?php  if($canComment && in_array("likeButton", $this->show_criteria)):?>
            <?php $likeStatus = Engine_Api::_()->sesbasic()->getLikeStatus($this->sesadvpoll->poll_id,$this->sesadvpoll->getType()); ?>
            <a href="javascript:;" data-type="like_view" data-url="<?php echo $this->sesadvpoll->poll_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesadvpoll_like sesadvpoll_like_<?php echo $this->sesadvpoll->poll_id ?> sesadvpoll_likefavfollow <?php echo ($likeStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-thumbs-up"></i><span><?php echo $this->sesadvpoll->like_count;?></span></a>
            <?php endif;?>
            <?php if( Engine_Api::_()->getApi('settings', 'core')->getSetting('sesadvpoll.allow.favourite', 1) && in_array("favouriteButton", $this->show_criteria)):?>
            <?php 	$value['resource_type'] = $this->sesadvpoll->getType();
						$value['resource_id'] = $this->sesadvpoll->poll_id;
						$favouriteStatus = Engine_Api::_()->getDbTable('Favourites', 'sesadvpoll')->isFavourite($value);
            $favouriteStatus = Engine_Api::_()->getDbTable('favourites', 'sesadvpoll')->isFavourite(array('resource_id' => $this->sesadvpoll->poll_id,'resource_type' => $this->sesadvpoll->getType())); ?>
            <a href="javascript:;" data-type="favourite_view" data-url="<?php echo $this->sesadvpoll->poll_id ; ?>" class="sesbasic_icon_btn favrite sesbasic_icon_btn_count sesadvpoll_fav sesbasic_icon_fav_btn sesadvpoll_favourite_<?php echo $this->sesadvpoll->poll_id ?> sesadvpoll_likefavfollow <?php echo ($favouriteStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-heart"></i><span><?php echo $this->sesadvpoll->favourite_count;?></span></a>
            <?php endif;?>
            <?php endif;?>
            <?php  // endif;?>
	
            <!-- polls end  polls like favourite -->
            <?php $shareType = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesadvpoll.allow.share', 1);?>
            <?php if(in_array($shareType, array('1', '2'))) { ?>
              <a href="activity/index/share/type/sesadvpoll_poll/id/<?php echo $this->sesadvpoll->getIdentity();?>/format/smoothbox" class="sesbasic_icon_btn smoothbox" title="Share"><i class="fa fa-share"></i></a>
            <?php } ?>
            <!-- social share -->
            <?php if($shareType == 2 && in_array("socialSharing", $this->show_criteria)):?>
            <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->sesadvpoll, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
            <?php endif;?>
        	</div>
          </div>
        <!-- social share end -->
				<?php $item = $this->sesadvpoll; ?>
      <div class="stats sesbasic_text_light">
				<?php if(in_array("likecount", $this->show_criteria)): ?>
				<span class="like_count" title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber(	$item->like_count)) ?>">
										<i class="fa fa-thumbs-up"></i> <span><?php echo $item->like_count ;?></span>
									</span>
				<?php endif; ?>
				<?php if(in_array("votecount", $this->show_criteria)): ?>
					<span class="sesadvpoll_vote_total"  title="<?php echo $this->translate(array('%s vote', '%s votes', $item->vote_count), $this->locale()->toNumber($item->vote_count)) ?>">
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

