<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesvideoimporter
 * @package    Sesvideoimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: play.tpl 2016-04-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesvideoimporter/externals/styles/styles.css'); ?>

<div class="sesimp_popup">
  <div class="sesimp_popup_video_player">
    <iframe
    title="YouTube video player"
    id="videoFrame1"
    class=""
    src="//www.youtube.com/embed/<?php echo $this->video_id ?>?wmode=opaque&autoplay=1"
    frameborder="0"
    allowfullscreen=""
    scrolling="no"
    width="560"
    height="340"
    >
    </iframe>
    <script type="text/javascript">
        en4.core.runonce.add(function() {
        var doResize = function() {
            var aspect = 16 / 9;
            var el = document.id("videoFrame1");
            var parent = el.getParent();
            var parentSize = parent.getSize();
            el.set("width", parentSize.x);
            el.set("height", parentSize.x / aspect);
        }
        window.addEvent("resize", doResize);
        doResize();
        });
    </script>
  </div>
  <div class="sesimp_popup_close sesbasic_clearfix">
  	<button onclick="parent.Smoothbox.close();">Close</button>
      <?php $urlNam =  $this->url(array('action' => 'create', 'vid' => $this->video_id), 'sesvideo_general', true); ?>
    <button onclick="parent.createVideo('<?php echo $urlNam; ?>');parent.Smoothbox.close();">Add Video</button>
  </div>
</div>
