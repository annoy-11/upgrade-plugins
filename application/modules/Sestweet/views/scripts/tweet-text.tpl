<?php 
$twitter_handler = Engine_Api::_()->getApi('settings', 'core')->getSetting('sestweet.twitterhandler', 'yourname');

$enabletwitter = Engine_Api::_()->getApi('settings', 'core')->getSetting('sestweet.enabletwitter', 1);
$enablefacebook = Engine_Api::_()->getApi('settings', 'core')->getSetting('sestweet.enablefacebook', 1);

?>
<div id="sestweet_twilighter_div" class="sestweet_tweet_popup sesbasic_bxs" style="display: none;">
  <textarea id="sestweet_twilighter_input" class="sestweet_twilighter_textarea"></textarea>
  <?php if($enablefacebook || $enabletwitter): ?>
    <div class="sestweet_tweet_popup_btns floatL">
      <?php if($enabletwitter) { ?>
      <span class="sestweet_tweet_popup_tweet_btn">
        <a class="socialSharingPopUpTweet" data-type= "twitter" href="javascript:void(0);" alt="Tweet this">
          <i class="fa fa-twitter"></i>
          <span class="btn-text">Tweet</span>
        </a>
      </span>
      <?php } ?>
      <?php if($enablefacebook) { ?>
        <span class="sestweet_tweet_popup_fb_btn">
          <a  class="socialSharingPopUpTweet" data-type= "fb" href="javascript:void(0);" alt="Facebook Share This">
            <i class="fa fa-facebook"></i>
            <span class="btn-text">Facebook</span>
          </a>
        </span>
      <?php } ?>
    </div>
	<?php endif; ?>
	<?php if($twitter_handler): ?>
  	<div class="sestweet_tweet_popup_ckbx floatL">
    	<input onclick="showHideTwitterHandler();" id="twitter_handler" type="checkbox" name="twitter_handler" checked="checked"><span>Include via?</span>
  	</div>
  <?php endif; ?>
  <div class="sestweet_twilighter_remaining floatR"></div>
  <a href="javascript:void(0);" onclick="closeSestweetBox();" class="sestweet_tweet_popup_close fa fa-close"></a>
</div>