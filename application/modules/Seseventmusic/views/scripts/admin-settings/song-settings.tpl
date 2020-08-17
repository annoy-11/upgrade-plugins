<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventmusic
 * @package    Seseventmusic
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: song-settings.tpl 2015-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<script type="text/javascript">
  
  window.addEvent('domready', function() {
      songCover("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('seseventmusic.show.songcover', 1); ?>");
  });
  
  function songCover(value) {
    if (value == 1) {
      if ($('seseventmusic_songcover_photo-wrapper'))
        $('seseventmusic_songcover_photo-wrapper').style.display = 'block';
            if($('albumsong_cover-wrapper'))
        $('albumsong_cover-wrapper').style.display = 'block';
    } else {
      if ($('seseventmusic_songcover_photo-wrapper'))
        $('seseventmusic_songcover_photo-wrapper').style.display = 'none';
      if($('albumsong_cover-wrapper'))
        $('albumsong_cover-wrapper').style.display = 'none';
    }

  }
</script>
<?php include APPLICATION_PATH .  '/application/modules/Seseventmusic/views/scripts/dismiss_message.tpl';?>
<div class="sesbasic-form">
  <div>
    <?php if( count($this->subNavigation) ): ?>
      <div class='sesbasic-admin-sub-tabs'>
        <?php
        echo $this->navigation()->menu()->setContainer($this->subNavigation)->render()
        ?>
      </div>
    <?php endif; ?>
    <div class='sesbasic-form-cont'>
      <div class='clear'>
        <div class='settings sesbasic_admin_form'>
          <?php echo $this->form->render($this); ?>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  function ratingAlbumSongs(value) {
    if (value == 1) {
      document.getElementById('seseventmusic_ratealbumsong_own-wrapper').style.display = 'block';
      document.getElementById('seseventmusic_ratealbumsong_again-wrapper').style.display = 'block';
      document.getElementById('seseventmusic_ratealbumsong_show-wrapper').style.display = 'none';
    } else {
      document.getElementById('seseventmusic_ratealbumsong_show-wrapper').style.display = 'block';
      document.getElementById('seseventmusic_ratealbumsong_own-wrapper').style.display = 'none';
      document.getElementById('seseventmusic_ratealbumsong_again-wrapper').style.display = 'none';
    }
  }

  if (document.querySelector('[name="seseventmusic_albumsong_rating"]:checked').value == 0) {
    document.getElementById('seseventmusic_ratealbumsong_own-wrapper').style.display = 'none';
    document.getElementById('seseventmusic_ratealbumsong_again-wrapper').style.display = 'none';
    document.getElementById('seseventmusic_ratealbumsong_show-wrapper').style.display = 'block';
  } else {
    document.getElementById('seseventmusic_ratealbumsong_show-wrapper').style.display = 'none';
  }
</script>