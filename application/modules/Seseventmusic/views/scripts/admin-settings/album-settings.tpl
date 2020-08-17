<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventmusic
 * @package    Seseventmusic
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: album-settings.tpl 2015-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<script type="text/javascript">
  
  window.addEvent('domready', function() {
      albumCover("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('seseventmusic.show.albumcover', 1); ?>");
  });
  
  function albumCover(value) {
    if (value == 1) {
      if ($('seseventmusic_albumcover_photo-wrapper'))
        $('seseventmusic_albumcover_photo-wrapper').style.display = 'block';
            if($('album_cover-wrapper'))
        $('album_cover-wrapper').style.display = 'block';
    } else {
      if ($('seseventmusic_albumcover_photo-wrapper'))
        $('seseventmusic_albumcover_photo-wrapper').style.display = 'none';
            if($('album_cover-wrapper'))
        $('album_cover-wrapper').style.display = 'none';
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
  function rating_album(value) {
    if (value == 1) {
      document.getElementById('seseventmusic_ratealbum_own-wrapper').style.display = 'block';
      document.getElementById('seseventmusic_ratealbum_again-wrapper').style.display = 'block';
      document.getElementById('seseventmusic_ratealbum_show-wrapper').style.display = 'none';
    } else {
      document.getElementById('seseventmusic_ratealbum_show-wrapper').style.display = 'block';
      document.getElementById('seseventmusic_ratealbum_own-wrapper').style.display = 'none';
      document.getElementById('seseventmusic_ratealbum_again-wrapper').style.display = 'none';
    }
  }

  if (document.querySelector('[name="seseventmusic_album_rating"]:checked').value == 0) {
    document.getElementById('seseventmusic_ratealbum_own-wrapper').style.display = 'none';
    document.getElementById('seseventmusic_ratealbum_again-wrapper').style.display = 'none';
    document.getElementById('seseventmusic_ratealbum_show-wrapper').style.display = 'block';
  } else {
    document.getElementById('seseventmusic_ratealbum_show-wrapper').style.display = 'none';
  }
</script>