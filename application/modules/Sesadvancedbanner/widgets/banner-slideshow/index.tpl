<?php
/**
 * SocialEngineSolutions
 *
 * @category Application_Sesadvancedbanner
 * @package Sesadvancedbanner
 * @copyright Copyright 2018-2019 SocialEngineSolutions
 * @license http://www.socialenginesolutions.com/license/
 * @version $Id: index.tpl 2018-07-26 00:00:00 SocialEngineSolutions $
 * @author SocialEngineSolutions
 */
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesadvancedbanner/externals/styles/styles.css'); ?>
<?php $identity = $this->identity; ?>
<style>
    #slideshow_container	{ width:512px; height:384px; position:relative; }
    #slideshow_container img { display:block; position:absolute; top:0; left:0; z-index:1; }
    .sesadvancedbanner_banner_slides{display:block !important;}
</style>
<script>
    var htmlElement = document.getElementsByTagName("body")[0];
    <?php if($this->inside_outside == 1){ ?>
        htmlElement.addClass('header_transparency');
    <?php } ?>
    window.addEvent('domready',function() {
        /* settings */
        var showDuration = <?php echo $this->duration ; ?>;

        var currentIndex<?php echo $identity; ?> = 0;
        var interval;
        /* worker */
        var showBannerImages = function() {
            var elem = sesJqueryObject('.sesadvancedbanner_banner_container_<?php echo $identity ?>').children();
            elem.eq(currentIndex<?php echo $identity; ?>).animate({ opacity: 0 });
            currentIndex<?php echo $identity; ?> = currentIndex<?php echo $identity; ?> < elem.length - 1 ? currentIndex<?php echo $identity; ?>+1 : 0;
            sesJqueryObject(elem).eq(currentIndex<?php echo $identity; ?>).animate({ opacity: 1 })
        };
        sesJqueryObject(document).on('click','.banner_previous_<?php echo $identity; ?>',function(e){
            clearInterval(interval);
            sesJqueryObject('.sesadvancedbanner_banner_container_<?php echo $identity ?>').children().eq(currentIndex<?php echo $identity; ?>).animate({ opacity: 0 });
            sesJqueryObject('.sesadvancedbanner_banner_container_<?php echo $identity ?>').children().eq(currentIndex<?php echo $identity; ?> = currentIndex<?php echo $identity; ?> == 0 ? sesJqueryObject('.sesadvancedbanner_banner_container_<?php echo $identity ?>').children().length - 1 : currentIndex<?php echo $identity; ?>-1).animate({ opacity: 1 });
            interval = showBannerImages.periodical(showDuration);
        });
        sesJqueryObject(document).on('click','.banner_next_<?php echo $identity; ?>',function(e){
            clearInterval(interval);
            var elem = sesJqueryObject('.sesadvancedbanner_banner_container_<?php echo $identity ?>').children();
            elem.eq(currentIndex<?php echo $identity; ?>).animate({ opacity: 0 });
            currentIndex<?php echo $identity; ?> = currentIndex<?php echo $identity; ?> < elem.length - 1 ? currentIndex<?php echo $identity; ?>+1 : 0;
            sesJqueryObject(elem).eq(currentIndex<?php echo $identity; ?>).animate({ opacity: 1 })
            interval = showBannerImages.periodical(showDuration);
        });
    <?php if(count($this->paginator) > 1){ ?>
            /* start once the page is finished loading */
            window.addEvent('load',function(){
                interval = showBannerImages.periodical(showDuration);
            });
        <?php } ?>
    });
</script>
<div id="slideshow_container_<?php echo $identity; ?>"  class="sesadvancedbanner_banner_container_wrapper sesadvancedbanner_bxs<?php if($this->full_width){ ?> isfull<?php } ?> sesbasic_bxs" style="height:<?php echo $this->height.'px'; ?>;">
    <div class="sesadvancedbanner_banner_main" style="height:<?php echo $this->height.'px'; ?>;">
        <div class="sesadvancedbanner_banner_container_<?php echo $identity ?>">
            <?php
      $counter = 1;
      foreach($this->paginator as $item): ?>
            <div class="sesadvancedbanner_banner_slides" style="height:<?php echo $this->height.'px'; ?>;opacity:<?php echo $counter == 1 ? '1' : '0'; ?>">
                <div class="sesadvancedbanner_banner_img_container<?php if($this->bgimg_move){ ?> ismove<?php } ?>" style="height:<?php echo $this->height.'px'; ?>;">
                    <span style="background-image:url(<?php echo $item->getFilePath('file_id'); ?>);"></span>
                </div>
                <?php if($item->overlay_type == '1'){
                $style = 'style="background-color:#'.$item->slide_overlaycolor.';opacity:'.$item->slide_opacity .';"';
                }else{
                $style = 'style="background: url(./application/modules/Sesadvancedbanner/externals/images/'.$item->overlay_pettern .') repeat center center;opacity: '.$item->slide_opacity .';"';
                }
                ?>
                <div class="sesadvancedbanner_banner_content_overlay" <?php echo $style; ?>></div>
            <div class="sesadvancedbanner_banner_content" style="height:<?php echo $this->height.'px'; ?>;">
                <div class="sesadvancedbanner_banner_content_inner <?php echo $item->text_description_allignment; ?>">
                    <?php if($item->title != '' || $item->description  != '') { ?>
                    <?php if($item->title != ''){ ?>
                    <h2 class="sesadvancedbanner_banner_title" style='color:#<?php echo $item->title_button_color; ?>;font-size:<?php echo $item->title_font_size ?>px;font-family:<?php echo $item->title_font_family ?>;'><?php echo $item->title; ?></h2>
                    <?php } ?>
                    <?php } ?>
                    <?php if(!empty($item->description)){ ?>
                    <p class="sesadvancedbanner_banner_des" style='color:#<?php echo $item->description_button_color; ?>;font-size:<?php echo $item->description_font_size; ?>px;font-family:<?php echo $item->description_font_family; ?>;'><?php echo $item->description ; ?></p>
                    <?php } ?>
                    <?php if($item->extra_button || $item->extra_button1){ ?>
                    <div class="sesadvancedbanner_banner_btns <?php echo $item->text_buttons_allignment; ?>">
                        <?php if($item->extra_button){ ?>
                        <a href="<?php echo $item->extra_button_link != '' ? $item->extra_button_link : 'javascript:void(0)'; ?>" class="sesadvancedbanner_banner_btn<?php echo !$item->button_type ? ' sesadvancedbanner_button_transparent' : ''; ?>" style="background-color:<?php echo !$item->button_type ? ' transparent' : '#'.$item->extra_button_backgroundcolor; ?>;color:#<?php echo $item->extra_button_textcolor; ?>;border-radius:<?php echo $item->extra_button_cornerradius.'px'; ?>;" onMouseOver="this.style.backgroundColor='#<?php echo $item->extra_button_backgroundactivecolor; ?>'; this.style.color='#<?php echo $item->extra_button_textcoloractive; ?>';" onMouseOut="this.style.backgroundColor='<?php echo !$item->button_type ? ' transparent' : '#'. $item->extra_button_backgroundcolor ?>'; this.style.color='#<?php echo $item->extra_button_textcolor; ?>';" <?php if($item->extra_button_linkopen){ ?> target="_blank" <?php } ?>><?php echo $this->translate($item->extra_button_text); ?></a>
                        <?php } ?>
                        <?php if($item->extra_button1){ ?>
                        <a href="<?php echo $item->extra_button1_link != '' ? $item->extra_button1_link : 'javascript:void(0)'; ?>" class="sesadvancedbanner_banner_btn<?php echo !$item->button_type ? ' sesadvancedbanner_button_transparent' : ''; ?>" style="background-color:<?php echo !$item->button_type ? ' transparent' : '#'.$item->extra_button1_backgroundcolor ?>;color:#<?php echo $item->extra_button1_textcolor; ?>;border-radius:<?php echo $item->extra_button1_cornerradius.'px'; ?>;" onMouseOver="this.style.backgroundColor='#<?php echo $item->extra_button1_backgroundactivecolor; ?>'; this.style.color='#<?php echo $item->extra_button1_textcoloractive; ?>';" onMouseOut="this.style.backgroundColor='<?php echo !$item->button_type ? ' transparent' : '#'. $item->extra_button1_backgroundcolor ?>'; this.style.color='#<?php echo $item->extra_button1_textcolor; ?>';" <?php if($item->extra_button1_linkopen){ ?> target="_blank" <?php } ?>><?php echo $this->translate($item->extra_button1_text); ?></a>
                        <?php } ?>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php $counter++;
      endforeach; ?>
    </div>
    <?php if($this->scrollbottom == 1 ){ ?>
    <div class="sesadvancedbanner_mouse_wheel">
        <div class="mouse">
            <div class="frame">
                <svg version="1.1" id="mouse" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 54.9 91" style="enable-background:new 0 0 54.9 91;" xml:space="preserve">
            <path id="XMLID_173_" class="st0" linejoin="round" stroke-linecap="round" stroke-miterlimit="10" d="M27.4,3.6L27.4,3.6C14.2,3.6,3.5,14.3,3.5,27.5v36c0,13.2,10.7,23.9,23.9,23.9h0
            c13.2,0,23.9-10.7,23.9-23.9v-36C51.4,14.3,40.7,3.6,27.4,3.6z"></path>
          </svg>
            </div>
            <div class="mouse-left">
                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 27.4 91" style="enable-background:new 0 0 27.4 91;" xml:space="preserve">
          <path linejoin="round" stroke-linecap="round" stroke-miterlimit="10" class="Draw-Frame Animate-Draw" d="M27.4,87.5L27.4,87.5c-13.2,0-23.9-10.7-23.9-23.9v-36c0-13.2,10.7-23.9,23.9-23.9h0"></path>
          </svg>
            </div>
            <div class="mouse-right">
                <svg version="1.1" id="Layer_2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 27.4 91" style="enable-background:new 0 0 27.4 91;" xml:space="preserve">
          <path linejoin="round" stroke-linecap="round" stroke-miterlimit="10" class="Draw-Frame Animate-Draw" d="M0,3.6L0,3.6c13.2,0,23.9,10.7,23.9,23.9v36c0,13.2-10.7,23.9-23.9,23.9h0"></path>
          </svg>
            </div>
        </div>
    </div>
    <?php } else if($this->scrollbottom == 2 ){ ?>
    <div class="sesadvancedbanner_scrollbtn_btm scrolltonxtsection"><a href="javascript:;" class="fa fa-chevron-down"></a></div>
    <?php } ?>
    <?php
      if($this->nav && count($this->paginator) > 1){ ?>
    <div class="sesadvancedbanner_nav">
        <a href="javascript:;" class="banner_previous_<?php echo $identity; ?> fa fa-angle-left"></a>
        <a href="javascript:;" class="banner_next_<?php echo $identity; ?> fa fa-angle-right"></a>
    </div>
    <?php } ?>
</div>
</div>
<?php if($this->full_width){ ?>
<script type="application/javascript">
    sesJqueryObject(document).ready(function(){
        sesJqueryObject('#global_content').css('padding-top',0);
        sesJqueryObject('#global_wrapper').css('padding-top',0);
    });
</script>

<?php } ?>
