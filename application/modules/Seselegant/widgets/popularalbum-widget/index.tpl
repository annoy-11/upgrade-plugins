<?php

/**

 * SocialEngineSolutions

 *

 * @category   Application_Seselegant

 * @package    Seselegant

 * @copyright  Copyright 2015-2016 SocialEngineSolutions

 * @license    http://www.socialenginesolutions.com/license/

 * @version    $Id: index.tpl 2016-04-18 00:00:00 SocialEngineSolutions $

 * @author     SocialEngineSolutions

 */

?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seselegant/externals/styles/styles.css'); ?>

<ul class="lp_album_listing sesbasic_bxs sesbasic_clearfix" >

  <?php foreach( $this->paginator as $album ): ?>

    <li id="thumbs-photo-<?php echo $album->photo_id ?>" class="lp_album_thumb" style="width:<?php //echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;">

    	<div class="lp_album_thumb_img">  

        <span style="background-image: url(<?php echo $album->getPhotoUrl('thumb.normalmain'); ?>);"></span>

      </div>

      <?php if(isset($this->like) || isset($this->comment) || isset($this->view) || isset($this->title) || isset($this->by)){ ?>

        <div class="lp_album_thumb_info">

          <?php if(isset($this->title)) { ?>

            <div class="lp_album_thumb_info_title">

              <?php echo $album->getTitle(); ?>

            </div>

          <?php } ?>

          <div class="lp_album_thumb_info_bottom">



            <?php if(isset($this->by)) { ?>

              <div class="lp_album_thumb_info_owner">

                <?php echo $this->translate('By');?>

              	<?php echo $album->getOwner()->getTitle(), array('class' => 'thumbs_author'); ?>

              </div>

            <?php }?>

            <div class="lp_album_thumb_stats">

              <?php if(isset($this->like)) { ?>

                <span title="<?php echo $this->translate(array('%s like', '%s likes', $album->like_count), $this->locale()->toNumber($album->like_count))?>">

                  <i class="fa fa-thumbs-up"></i>

                  <?php echo $album->like_count;?>

                </span>

              <?php } ?>

              <?php if(isset($this->comment)) { ?>

                <span title="<?php echo $this->translate(array('%s comment', '%s comments', $album->comment_count), $this->locale()->toNumber($album->comment_count))?>">

                  <i class="fa fa-comment"></i>

                  <?php echo $album->comment_count;?>

                </span>

            <?php } ?>

            <?php if(isset($this->view)) { ?>

                <span title="<?php echo $this->translate(array('%s view', '%s views', $album->view_count), $this->locale()->toNumber($album->view_count))?>">

                  <i class="fa fa-eye"></i>

                  <?php echo $album->view_count;?>

                </span>

            <?php } ?>




            </div>

          </div>

        </div>

      <?php } ?>

      <a href="<?php echo $album->getHref(); ?>" class="lp_album_thumb_link"></a>

    </li>

  <?php endforeach; ?>

</ul>
