<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventvideo
 * @package    Seseventvideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: external.tpl 2016-07-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seseventvideo/externals/styles/styles.css'); ?>
<?php if( $this->error == 1 ): ?>
  <?php echo $this->translate('Embedding of videos has been disabled.') ?>
  <?php return ?>
<?php elseif( $this->error == 2 ): ?>
  <?php echo $this->translate('Embedding of videos has been disabled for this video.') ?>
  <?php return ?>
<?php elseif( !$this->video || $this->video->status != 1 ): ?>
  <?php echo $this->translate('The video you are looking for does not exist or has not been processed yet.') ?>
  <?php return ?>
<?php endif; ?>

<?php if( $this->video->type == 3 ):
  $this->headScript()
      ->appendFile($this->layout()->staticBaseUrl . 'externals/flowplayer/flashembed-1.0.1.pack.js');
   $flowplayer = Engine_Api::_()->sesbasic()->checkPluginVersion('core', '4.8.10') ? 'externals/flowplayer/flowplayer-3.2.18.swf' : 'externals/flowplayer/flowplayer-3.1.5.swf';  
  ?>
  <script type='text/javascript'>
		
    flashembed("video_embed", {
      src: "<?php echo $this->layout()->staticBaseUrl . $flowplayer; ?>",
      width: 480,
      height: 386,
      wmode: 'transparent'
    }, {
      config: {
        clip: {
          url: "<?php echo $this->video_location;?>",
          autoPlay: false,
          duration: "<?php echo $this->video->duration ?>",
          autoBuffering: true
        },
        plugins: {
          controls: {
            background: '#000000',
            bufferColor: '#333333',
            progressColor: '#444444',
            buttonColor: '#444444',
            buttonOverColor: '#666666'
          }
        },
        canvas: {
          backgroundColor:'#000000'
        }
      }
    });
  </script>
<?php endif ?>

<script type="text/javascript">
  var pre_rate = <?php echo $this->video->rating;?>;
  var video_id = <?php echo $this->video->video_id;?>;
  var total_votes = <?php echo $this->rating_count;?>;
  
  function set_rating() {
    var rating = pre_rate;
    $('rating_text').innerHTML = "<?php echo $this->translate(array('%s rating', '%s ratings', $this->rating_count),$this->locale()->toNumber($this->rating_count)) ?>";
    for(var x=1; x<=parseInt(rating); x++) {
        $('rate_'+x).set('class', 'fa fa-star');
      }

      for(var x=parseInt(rating)+1; x<=5; x++) {
        $('rate_'+x).set('class', 'fa fa fa-star-o star-disable');
      }

      var remainder = Math.round(rating)-rating;
      if (remainder <= 0.5 && remainder !=0){
        var last = parseInt(rating)+1;
        $('rate_'+last).set('class', 'fa fa-star-half-o');
      }
  }

  en4.core.runonce.add(set_rating);
</script>

<div class="seseventvideo_video_view_container clear sesbasic_clearfix sesbasic_bxs seseventvideo_external_video_preview sesbm">
  <?php if( $this->video->type == 3 ): ?>
    <div id="video_embed" class="seseventvideo_view_embed clear sesbasic_clearfix"></div>
  <?php else: ?>
    <div class="seseventvideo_view_embed clear sesbasic_clearfix">
      <?php echo $this->videoEmbedded ?>
    </div>
  <?php endif; ?> 
<?php if(!$this->isMap){ ?>
  <div class="seseventvideo_external_video_btn_cont clear sesbasic_clearfix">   
    <h2 class="seseventvideo_view_title sesbasic_clearfix">
      <?php echo $this->video->getTitle() ?>
    </h2>
    <div class="seseventvideo_view_author">
      <div class="seseventvideo_view_author_photo">  
        <?php echo $this->htmlLink($this->video->getParent(), $this->itemPhoto($this->video->getParent(), 'thumb.icon')); ?>
      </div>
      <div class="seseventvideo_view_author_info">
        <div class="seseventvideo_view_author_name sesbasic_text_light">
          <?php echo $this->translate('By') ?>
          <?php echo $this->htmlLink($this->video->getParent(), $this->video->getParent()->getTitle()) ?>
        </div>
        <div class="seseventvideo_view_date sesbasic_text_light">
          <?php echo $this->translate('Posted') ?>
          <?php echo $this->timestamp($this->video->creation_date) ?>
        </div>
      </div>
    </div>
    <div class="seseventvideo_view_statics">
      <div id="album_rating" class="sesbasic_rating_star seseventvideo_view_rating">
        <span id="rate_1" class="fa fa-star"></span>
        <span id="rate_2" class="fa fa-star" ></span>
        <span id="rate_3" class="fa fa-star" ></span>
        <span id="rate_4" class="fa fa-star" ></span>
        <span id="rate_5" class="fa fa-star" ></span>
        <span id="rating_text" class="sesbasic_rating_text"><?php echo $this->translate('click to rate');?></span>
      </div>
      <div class="seseventvideo_view_stats seseventvideo_list_stats sesbasic_text_light">
        <span><i class="fa fa-thumbs-up"></i><?php echo $this->translate(array('%s like', '%s likes', $this->video->like_count), $this->locale()->toNumber($this->video->like_count)); ?></span>
        <span><i class="fa fa-comment"></i><?php echo $this->translate(array('%s comment', '%s comments', $this->video->comment_count), $this->locale()->toNumber($this->video->comment_count))?></span>
        <span><i class="fa fa-eye"></i><?php echo $this->translate(array('%s view', '%s views', $this->video->view_count), $this->locale()->toNumber($this->video->view_count)) ?></span>
      </div>
    </div>
    <div class="seseventvideo_view_meta seseventvideo_list_stats sesbasic_text_light clear sesbasic_clearfix">

      <?php if (count($this->videoTags) ): ?>
        <span>
          <i class="fa fa-tag"></i> 
          <?php foreach ($this->videoTags as $tag): ?>
            <a href='javascript:void(0);'>#<?php echo $tag->getTag()->text?></a>&nbsp;
          <?php endforeach; ?>
        </span>
      <?php endif; ?>
    </div>
    <div class="seseventvideo_view_desc clear " >
      <?php echo $this->video->description;?>
    </div>
  
    <?php /*
      <div class='seseventvideo_view_options seseventvideo_options_buttons'>
        <?php if( $this->can_edit ): ?>
          <?php echo $this->htmlLink(array(
            'route' => 'default',
            'module' => 'seseventvideo',
            'controller' => 'index',
            'action' => 'edit',
            'video_id' => $this->video->video_id
          ), $this->translate('Edit Video'), array(
            'class' => 'sesbasic_button fa fa-pencil'
          )) ?>
          &nbsp;|&nbsp;
        <?php endif;?>
        <?php if( $this->can_delete && $this->video->status != 2 ): ?>
          <?php echo $this->htmlLink(array(
            'route' => 'default',
            'module' => 'seseventvideo',
            'controller' => 'index',
            'action' => 'delete',
            'video_id' => $this->video->video_id,
            'format' => 'smoothbox'
          ), $this->translate('Delete Video'), array(
            'class' => 'sesbasic_button smoothbox fa fa-trash'
          )) ?>
          &nbsp;|&nbsp;
        <?php endif;?>
        <?php echo $this->htmlLink(array(
          'module'=> 'activity',
          'controller' => 'index',
          'action' => 'share',
          'route' => 'default',
          'type' => 'seseventvideo_video',
          'id' => $this->video->getIdentity(),
          'format' => 'smoothbox'
        ), $this->translate("Share"), array(
          'class' => 'sesbasic_button smoothbox fa fa-comment'
        )); ?>
        &nbsp;|&nbsp;
        <?php echo $this->htmlLink(array(
          'module'=> 'core',
          'controller' => 'report',
          'action' => 'create',
          'route' => 'default',
          'subject' => $this->video->getGuid(),
          'format' => 'smoothbox'
        ), $this->translate("Report"), array(
          'class' => 'sesbasic_button smoothbox fa fa-flag'
        )); ?>
      	<?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesadvancedcomment')){ ?>
      <?php echo $this->action("list", "comment", "sesadvancedcomment", array("type" => "video", "id" => $this->video->getIdentity(),'is_ajax_load'=>true)); 
        }else{ echo $this->action("list", "comment", "core", array("type"=>"video", "id"=>$this->video->video_id)); } ?>
     * 
     */ ?>
    </div>
<?php } ?>
	</div>
</div>