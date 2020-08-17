<?php
 /**
 * SocialEngineSolutions
 *
 * @category Application_Sesultimateslide
 * @package Sesultimateslide
 * @copyright Copyright 2018-2019 SocialEngineSolutions
 * @license http://www.socialenginesolutions.com/license/
 * @version $Id: index.tpl 2018-07-05 00:00:00 SocialEngineSolutions $
 * @author SocialEngineSolutions
 */
?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesultimateslide/externals/styles/styles.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesultimateslide/externals/scripts/typed.js'); ?>
<script type="text/javascript">
  var body = document.body;
    <?php  $identity = $this->identity;
    if($this->header_insight_out == 1){ ?>
            body.classList.add("header_transparency");
    <?php }elseif($this->header_insight_out == 2){ ?>
      body.classList.add("header_transparency");

// for header work
      var logoSeshtml<?php echo "_".$identity ?> = sesJqueryObject('.layout_core_menu_logo').html();
      if(!logoSeshtml<?php echo "_".$identity ?>)
      logoSeshtml<?php echo "_".$identity ?> = sesJqueryObject('.header_logo').html();
    <?php if($this->main_navigation): ?>
      sesJqueryObject('#global_header').hide();
      sesJqueryObject('.header_mini_menu').remove();
      sesJqueryObject('.core_menu_mini_menu').remove();
    <?php endif; ?>
    <?php if($this->main_navigation): ?>
      sesJqueryObject('#global_wrapper').css('padding-top','0px');
    <?php endif; ?>
// end header work

   <?php }?>

     <?php if($this->banner_full_width == 1){ ?>
            var body = document.body;
            body.classList.add("sesultimateslide_full_width");
    <?php }?>
    sesJqueryObject(document).ready(function (e) {
        var elem = sesJqueryObject('.typed-strings').not('.build');
        for (i = 0; i < elem.length; i++) {
            sesJqueryObject(elem[i]).attr('id', 'typed-' + i);
            sesJqueryObject(elem[i]).parent().find('._ct').addClass('typed-' + i);
            typedString('typed-' + i);
             var obj = sesJqueryObject(elem[i]).parent().find('.typed-strings');
            sesJqueryObject(elem[i]).parent().find('._ct').css({'color':obj.css('color'),'font-size':obj.css('font-size'),'font-family':obj.css('font-family')});
            break;
        }
    });
    var typedJS;
    function typedString(id) {
        typedJS = new Typed('.' + id, {
            stringsElement: '#' + id,
            typeSpeed: 150,
            backSpeed: 20,
            startDelay: 0,
            loop: false,
            loopCount: Infinity,
            cursorChar: "",
            onComplete: function (self) {
                prettyLog('onComplete ' + self)
            },
            preStringTyped: function (pos, self) {
                prettyLog('preStringTyped ' + pos + ' ' + self);
            },
            onStringTyped: function (pos, self) {
                prettyLog('onStringTyped ' + pos + ' ' + self)
            },
            onLastStringBackspaced: function (self) {
                prettyLog('onLastStringBackspaced ' + self)
            },
            onTypingPaused: function (pos, self) {
                prettyLog('onTypingPaused ' + pos + ' ' + self)
            },
            onTypingResumed: function (pos, self) {
                prettyLog('onTypingResumed ' + pos + ' ' + self)
            },
            onReset: function (self) {
                prettyLog('onReset ' + self)
            },
            onStop: function (pos, self) {
                prettyLog('onStop ' + pos + ' ' + self)
            },
            onStart: function (pos, self) {
                prettyLog('onStart ' + pos + ' ' + self)
            },
            onDestroy: function (self) {
                prettyLog('onDestroy ' + self)
            }
        });
    }
    function prettyLog(str) {
        //console.log('%c ' + str);
    }
</script>

<?php $viewer = Engine_Api::_()->user()->getViewer(); ?>
<div class="sesslider_wrapper" style="height:<?php echo $this->sesslider_wrapper_height?>px;">
    <div class="sesslider_main" style="height:<?php echo $this->sesslider_wrapper_height?>px;">
      <?php // Header Start Here ?>
      <?php if($this->header_insight_out == 2){ ?>
        <div class="sesultimateslide_header sesbasic_bxs">
          <header class="sesbasic_clearfix">
            <?php if(!$this->sesspectromedia && $this->mini_navigation && count($this->menumininavigation)){ ?>
              <div class="sesultimateslide_slider_mini_menu">
                <div id='core_menu_mini_menu' class="_self">
                  <?php $count = count($this->menumininavigation);
                  foreach( $this->menumininavigation->getPages() as $item ) $item->setOrder(--$count); ?>
                    <ul>
                      <?php if( $this->viewer->getIdentity()) :?>
                      <li id='core_menu_mini_menu_update'>
                        <span onclick="toggleUpdatesPulldown<?php echo "_".$identity ?>(event, this, '4');" style="display:block;" class="updates_pulldown">
                        <div class="pulldown_contents_wrapper">
                          <div class="pulldown_contents">
                            <ul class="notifications_menu" id="notifications_menu">
                              <div class="notifications_loading" id="notifications_loading">
                                <img src='<?php echo $this->layout()->staticBaseUrl ?>application/modules/Core/externals/images/loading.gif' style='float:left; margin-right: 5px;' />
                                <?php echo $this->translate("Loading ...") ?>
                              </div>
                            </ul>
                          </div>
                          <div class="pulldown_options">
                            <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'activity', 'controller' => 'notifications'),
                            $this->translate('View All Updates'),
                            array('id' => 'notifications_viewall_link')) ?>
                            <?php echo $this->htmlLink('javascript:void(0);', $this->translate('Mark All Read'), array(
                            'id' => 'notifications_markread_link',
                            )) ?>
                          </div>
                        </div>
                        <a href="javascript:void(0);" id="updates_toggle" <?php if( $this->notificationCount ):?> class="new_updates"<?php endif;?>><?php echo $this->translate(array('%s Update', '%s Updates', $this->notificationCount), $this->locale()->toNumber($this->notificationCount)) ?></a>
                        </span>
                      </li>
                      <?php endif; ?>
                      <?php foreach( $this->menumininavigation as $item ): ?>
                        <li><?php echo $this->htmlLink($item->getHref(), $this->translate($item->getLabel()), array_filter(array(
                          'class' => ( !empty($item->class) ? $item->class : null ),
                          'alt' => ( !empty($item->alt) ? $item->alt : null ),
                          'target' => ( !empty($item->target) ? $item->target : null ),
                          ))) ?>
                        </li>
                      <?php endforeach; ?>
                    </ul>
                </div>
              </div>
            <?php }else if($this->sesspectromedia && $this->mini_navigation){ ?>
            	<div class="sesultimateslide_slider_mini_menu">
              	<div class="_supported"> <?php echo $this->content()->renderWidget($this->moduleEnable.'.menu-mini');?></div>
            	</div>
            <?php } ?>
            <div class="sesultimateslide_slider_logo" id="sesultimateslide_slider_logo<?php echo "_".$identity ?>"></div>
            <?php if($this->main_navigation && count($this->navigation) && ($this->show_menu)): ?>
              <nav class="sesultimateslide_slider_nav sesultimateslide_slider_nav<?php echo "_".$identity ?>">
              	<div class="_browsermenu">
                	<ul><?php  $countMenu = 0; ?>
                    <?php foreach( $this->navigation as $navigationMenu ): ?>
                      <?php if($countMenu <  $this->max): ?>
                        <?php if ($navigationMenu->action): ?>
                            <li><a class="<?php echo $navigationMenu->class ?>" href='<?php echo empty($navigationMenu->uri) ? $this->url(array('action' =>
                              $navigationMenu->action), $navigationMenu->route, true) : $navigationMenu->uri ?>'><span><?php echo $this->translate($navigationMenu->label); ?></span></a></li>
                        <?php else: ?>
                              <?php $classArray = explode(' ', $navigationMenu->class); ?>
                              <?php if($classArray[1] == 'core_main_home' && $this->viewer->getIdentity() != 0): ?>
                                  <li><a class="<?php echo $navigationMenu->class ?>" href='<?php echo $this->url(array('action' => 'home'),
                                    $navigationMenu->route, true) ?>'><span><?php echo $this->translate($navigationMenu->label); ?></span></a></li>
                              <?php elseif($classArray[1] == 'core_main_invite' && $this->viewer->getIdentity() != 0) : ?>
                                  <li><a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $this->url(array('module' => 'invite'),
                                    $navigationMenu->route, true) ?>'><span><?php echo $this->translate($navigationMenu->label); ?></span></a></li>
                              <?php else: ?>
                                  <li><a class= "<?php echo $navigationMenu->getClass() ?>" href='<?php echo $navigationMenu->getHref() ?>'><span><?php echo
                                  $this->translate($navigationMenu->label); ?></span></a></li>
                              <?php endif; ?>
                        <?php endif; ?>
                        <?php  $countMenu ++; ?>
                      <?php endif; ?>
                    <?php endforeach; ?>
                    <?php if(count($this->navigation)> $this->max) : ?>
                  	<li class="_more">
                      <a href="javascript:void(0);" class="_toggle_btn">
                        <span><?php echo $this->translate("More"); ?></span>
                        <i class="fa fa-angle-down"></i>
                      </a>
                      <ul class="sesultimateslide_slider_nav_dropdown">
                        <?php  $countMenu = 0; ?>
                        <?php foreach( $this->navigation as $navigationMenu ): ?>
                          <?php if($countMenu >= $this->max):  ?>
                            <li>
                            <?php if ($navigationMenu->action):  ?>
                              <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo empty($navigationMenu->uri) ? $this->url(array('action' => $navigationMenu->action), $navigationMenu->route, true) : $navigationMenu->uri ?>'><?php echo $this->translate($navigationMenu->label); ?></a>
                            <?php else : ?>
                              <?php $classArray = explode(' ', $navigationMenu->class); ?>
                              <?php if($classArray[1] == 'core_main_home' && $this->viewer->getIdentity() != 0):  ?>
                                <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $this->url(array('action' => 'home'), $navigationMenu->route, true) ?>'><?php echo $this->translate($navigationMenu->label); ?></a>
                              <?php elseif($classArray[1] == 'core_main_invite' && $this->viewer->getIdentity() != 0): ?>
                                <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $this->url(array('module' => 'invite'), $navigationMenu->route, true) ?>'><?php echo $this->translate($navigationMenu->label); ?></a>
                              <?php else: ?>
                                <a class= "<?php echo $navigationMenu->getClass() ?>" href='<?php echo $navigationMenu->getHref() ?>'><?php echo $this->translate($navigationMenu->label); ?></a>
                            <!--<a class= "<?php echo $navigationMenu->class ?>" href='<?php echo empty($navigationMenu->uri) ? $this->url(array(), $navigationMenu->route, true) : $navigationMenu->uri ?>'><?php echo $this->translate($navigationMenu->label); ?></a>-->
                              <?php endif; ?>
                            <?php endif; ?>
                            </li>
                          <?php endif; ?>
                        <?php  $countMenu ++;  ?>
                        <?php endforeach; ?>
                      </ul>
                    </li>
                    <?php endif; ?>
                  </ul>
                </div>
                <div class="_mobilemenu">
                  <a href="javascript:void(0);" class="_mobiletoggle_btn">
                    <i class="fa fa-bars"></i>
                  </a>
                  <ul class="sesultimateslide_slider_nav_dropdown">
                    <?php foreach( $this->navigation as $navigationMenu ): ?>
                      <li>
                      <?php if ($navigationMenu->action):  ?>
                      <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo empty($navigationMenu->uri) ? $this->url(array('action' => $navigationMenu->action), $navigationMenu->route, true) : $navigationMenu->uri ?>'><?php echo $this->translate($navigationMenu->label); ?></a>
                      <?php else : ?>
                      <?php $classArray = explode(' ', $navigationMenu->class);
                      if($classArray[1] == 'core_main_home' && $this->viewer->getIdentity() != 0):  ?>
                      <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $this->url(array('action' => 'home'), $navigationMenu->route, true) ?>'><?php echo $this->translate($navigationMenu->label); ?></a>
                      <?php elseif($classArray[1] == 'core_main_invite' && $this->viewer->getIdentity() != 0): ?>
                      <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $this->url(array('module' => 'invite'), $navigationMenu->route, true) ?>'><?php echo $this->translate($navigationMenu->label); ?></a>
                      <?php else: ?>
                      <a class= "<?php echo $navigationMenu->getClass() ?>" href='<?php echo $navigationMenu->getHref() ?>'><?php echo $this->translate($navigationMenu->label); ?></a>
                      <!--<a class= "<?php echo $navigationMenu->class ?>" href='<?php echo empty($navigationMenu->uri) ? $this->url(array(), $navigationMenu->route, true) : $navigationMenu->uri ?>'><?php echo $this->translate($navigationMenu->label); ?></a>-->
                      <?php endif; ?>
                      <?php endif; ?>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                </div>  
              </nav>
            <?php endif; ?>
        </header>
        </div>
      <?php } ?>
      <?php // Header Start Here ?>    
        <ul class="sesslider">
            <?php $counter = 0; foreach($this->paginator as $slide){ 

                if(($slide->show_non_loged_in) || (!$slide->show_non_loged_in && $viewer->getIdentity()>0)){
					
      if($slide->large_image_for_slide){
        $backgroundImageSrc = Engine_Api::_()->storage()->get($slide->large_image_for_slide, '')->getPhotoUrl();
          $bcimage ='background-image:url('. $backgroundImageSrc.')';
    }else{
        $backgroundImageSrc = '';
          $bcimage ='';
    }

    if($slide->dbslide_double_slide_image){
        $ImageSrc = Engine_Api::_()->storage()->get($slide->dbslide_double_slide_image, '')->getPhotoUrl();
    }else{
        $ImageSrc = '';
    }
$activeClass = '';
    if($counter == 0){
        $activeClass = 'sesslide_active';
    }

          if($slide->enable_gradient == 1)
          $style = 'background:linear-gradient(135deg, #'.$slide->gradient_background_color.' 0%, #'
          .$slide->background_color. ' 98%);'. $bcimage;
          else
          $style = 'background-color:#'.$slide->background_color.'; '. $bcimage;
  ?>
            <li class="sesslider_slide <?php if(!$slide->enable_double_slide == 1 ){ ?>_nodivice<?php }?> <?php if
            ($activeClass) echo $activeClass ?>" style="<?php echo $style; ?>">
                <div class="slide_overlay"  style="<?php if($slide->enable_overlay){ ?> opacity:<?php echo $slide->slide_opacity ?>;background-color:#<?php echo $slide->slide_overlaycolor ?>;<?php } ?>"></div>
                <?php if($slide->enable_double_slide == 1 ){ ?>
                  <div class="slidecontent">
                      <section>
                          <div class="<?php echo $slide->dbslide_frame_for_slide ?>" style="transform: rotate(<?php echo $slide->dbslide_frame_rotation ?>deg);">
                              <div class="_framcont"><img src="<?php echo $ImageSrc ?>" alt="" /></div>
                          </div>
                      </section>
                  </div>
                <?php }?>
                <div class="txtcontent">
                    <section>
                        <div class="_heading">
                            <span class="_ft"  style='color:#<?php echo $slide->fixed_caption_font_color  ?>;
                            font-size:<?php echo $slide->fixed_caption_font_size ?>px;font-family: <?php echo
                            $slide->fixed_caption_font_family; ?>'><?php echo $this->translate($slide->fixed_caption_text)?></span>
                            <span class="typed-strings" style='display:none; color:#<?php echo $slide->floating_caption_font_color ?>;font-size:<?php echo $slide->floating_caption_font_size ?>px;font-family:<?php echo $slide->floating_caption_font_family ?>;'>
                                <span><?php echo $this->translate($slide->floating_caption_text)?></span>
                            </span>
                            <span class="_ct"></span>
                        </div>
                        <div class="_subheading" style='color:#<?php echo $slide->description_font_color  ?>;
                        font-size:<?php echo $slide->description_font_size ?>px;font-family: <?php echo $slide->description_font_family; ?>'><?php echo $this->translate($slide->description_text) ?></div>
                        <div class="_btns">
                            <?php if($slide->enable_cta_Button_1 == 1) { ?>
                            <a href="<?php echo $slide->cta1_button_url; ?>"  target="<?php echo
                            $slide->cta1_cta_button_target?_blank:'' ?>" onMouseOut="this.style.backgroundColor='#<?php echo $slide->cta1_background_color ?>'; this.style.color='#<?php echo $slide->cta1_text_color ?>';" onMouseOver="this.style.backgroundColor='#<?php echo $slide->cta1_mouseover_background_color ?>'; this.style.color='#<?php echo $slide->cta1_mouseover_text_color ?>'" style='background-color:#<?php echo $slide->cta1_background_color ?> ;color:#<?php echo $slide->cta1_text_color ?> ; ' class="_mb button1"><?php if($slide->cta1_button_icon != null){ ?><i class="fa <?php echo $slide->cta1_button_icon; ?>"></i><?php } echo $this->translate($slide->cta1_button_label) ?></a>
                            <?php }?>
                            <?php if($slide->enable_cta_button_2 == 1) { ?>
                            <a href="<?php echo $slide->cta2_button_url; ?>" target="<?php echo
                            $slide->cta2_cta_button_target?_blank:'' ?>" onMouseOut="this.style.backgroundColor='#<?php echo $slide->cta2_background_color ?>'; this.style.color='#<?php echo $slide->cta2_text_color ?>';"  onMouseOver="this.style.backgroundColor='#<?php echo $slide->cta2_mouseover_background_color ?>'; this.style.color='#<?php echo $slide->cta2_mouseover_text_color ?>'" style='background-color:#<?php echo $slide->cta2_background_color ?> ;color:#<?php echo $slide->cta2_text_color ?> ; '  class="_mb button2"><?php if($slide->cta2_button_icon != null){ ?><i class="fa <?php echo $slide->cta2_button_icon; ?>"></i> <?php } echo $this->translate($slide->cta2_cta_button_label) ?></a>
                              <?php }?>
                              <?php if($slide->enable_watch_video_button == 1) { ?>
                            <a  id="<?php echo $slide->video_video_url;  ?>" data-rel='<?php if($slide->file_id &&
                            $slide->video_video_url ==4 ){ echo json_encode(Engine_Api::_()->storage()->get
                            ($slide->file_id, "")->map());}else if($slide->video_video_url !=4 ){ echo json_encode
                            ($slide->video_video_file_url);  }else{ echo " "; } ?>' class="_mb sesultimateslide_video_button" onMouseOut="this.style.backgroundColor='#<?php echo $slide->video_background_color ?>'; this.style.color='#<?php echo $slide->video_text_color ?>';"  onmouseover="this.style.backgroundColor='#<?php echo $slide->video_mouseover_background_color ?>'; this.style.color='#<?php echo $slide->video_mouseover_text_color ?>'" style='background-color:#<?php echo $slide->video_background_color ?> ;color:#<?php echo $slide->video_text_color ?> ; ' ><i class="fa fa-play"></i><?php echo $this->translate($slide->video_Button_label) ?></a>
                            <?php }?>
                        </div>
                    </section>
                </div>

            </li>
            <?php $counter++;
                }
     } ?>
        </ul>
      <?php if($this->enable_navigation){ ?>
			<div class="sesslider_navigation">
      	<a href="javascript:void(0)" id="previous" class="_prev"><i class="fa fa-angle-left"></i></a>
        <a href="javascript:void(0)" id="next" class="_nxt"><i class="fa fa-angle-right"></i></a>
      </div>
      <?php } ?>
    </div>
</div>

<div id="videopopup" class="sesdoublebnr_videobox sesultimateslide_video_cnt">
   <div class="sesdoublebnr_videobox_inner">

   </div>
<div class="cross_btn"><i class="fa fa-times cancel-video"></i></div>
</div>

<?php if($this->mini_navigation && !$this->sesspectromedia){ ?>
<script type='text/javascript'>
  var notificationUpdater<?php echo "_".$identity ?>;
  en4.core.runonce.add(function(){
    if($('global_search_field')){
      new OverText($('global_search_field'), {
        poll: true,
        pollInterval: 500,
        positionOptions: {
          position: ( en4.orientation == 'rtl' ? 'upperRight' : 'upperLeft' ),
          edge: ( en4.orientation == 'rtl' ? 'upperRight' : 'upperLeft' ),
          offset: {
            x: ( en4.orientation == 'rtl' ? -4 : 4 ),
            y: 2
          }
        }
      });
    }

    if($('notifications_markread_link')){
      $('notifications_markread_link').addEvent('click', function() {
        //$('notifications_markread').setStyle('display', 'none');
        en4.activity.hideNotifications('<?php echo $this->string()->escapeJavascript($this->translate("0 Updates"));?>');
      });
    }

  <?php if ($this->updateSettings && $this->viewer->getIdentity()): ?>
    notificationUpdater<?php echo "_".$identity ?> = new NotificationUpdateHandler({
      'delay' : <?php echo $this->updateSettings;?>
  });
    notificationUpdater<?php echo "_".$identity ?>.start();
    window._notificationUpdater = notificationUpdater<?php echo "_".$identity ?>;
  <?php endif;?>
  });


  var toggleUpdatesPulldown<?php echo "_".$identity ?> = function(event, element, user_id) {
    if( element.className=='updates_pulldown' ) {
      element.className= 'updates_pulldown_active';
      showNotifications<?php echo "_".$identity ?>();
    } else {
      element.className='updates_pulldown';
    }
  }

  var showNotifications<?php echo "_".$identity ?> = function() {
    en4.activity.updateNotifications();
    new Request.HTML({
      'url' : en4.core.baseUrl + 'activity/notifications/pulldown',
      'data' : {
        'format' : 'html',
        'page' : 1
      },
      'onComplete' : function(responseTree, responseElements, responseHTML, responseJavaScript) {
        if( responseHTML ) {
          // hide loading icon
          if($('notifications_loading')) $('notifications_loading').setStyle('display', 'none');

          $('notifications_menu').innerHTML = responseHTML;
          $('notifications_menu').addEvent('click', function(event){
            event.stop(); //Prevents the browser from following the link.

            var current_link = event.target;
            var notification_li = $(current_link).getParent('li');

            // if this is true, then the user clicked on the li element itself
            if( notification_li.id == 'core_menu_mini_menu_update' ) {
              notification_li = current_link;
            }

            var forward_link;
            if( current_link.get('href') ) {
              forward_link = current_link.get('href');
            } else{
              forward_link = $(current_link).getElements('a:last-child').get('href');
            }

            if( notification_li.get('class') == 'notifications_unread' ){
              notification_li.removeClass('notifications_unread');
              en4.core.request.send(new Request.JSON({
                url : en4.core.baseUrl + 'activity/notifications/markread',
                data : {
                  format     : 'json',
                  'actionid' : notification_li.get('value')
                },
                onSuccess : function() {
                  window.location = forward_link;
                }
              }));
            } else {
              window.location = forward_link;
            }
          });
        } else {
          $('notifications_loading').innerHTML = '<?php echo $this->string()->escapeJavascript($this->translate("You have no new updates."));?>';
        }
      }
    }).send();
  };
  <?php  if($this->logo)
          {
            if($this->logo_url){ ?>
                  sesJqueryObject('#sesultimateslide_slider_logo<?php echo "_".$identity ?>').html('<div id="sesultimateslide_slider_logo" class="logo"><div><a href="/"><img src="<?php echo $this->logo_url; ?>"></a></div></div>');
            <?php }
          }
          else{ ?>
              sesJqueryObject('#sesultimateslide_slider_logo<?php echo "_".$identity ?>').html(logoSeshtml<?php echo "_".$identity ?>);
          <?php } ?>
</script>
<?php } ?>


<script>
    sesJqueryObject('.sesultimateslide_video_button').on('click', function () {
        var videobuttonurl = sesJqueryObject.parseJSON(sesJqueryObject(this).attr("data-rel"));
        var videotype = sesJqueryObject(this).attr("id");
        if(!videobuttonurl)
            return;
            if(videotype == 4){
                sesJqueryObject('.sesultimateslide_video_cnt').show();
                sesJqueryObject('.sesultimateslide_video_cnt').find('.sesdoublebnr_videobox_inner').append('<iframe src="'+videobuttonurl+'"></iframe>');
            }else{
                sesJqueryObject('.sesultimateslide_video_cnt').show();
                sesJqueryObject('.sesultimateslide_video_cnt').find('.sesdoublebnr_videobox_inner').append(videobuttonurl);
            }
         });
         sesJqueryObject('.cancel-video, .sesdoublebnr_videobox').on('click', function () {
           sesJqueryObject('.sesdoublebnr_videobox_inner').html('');
           sesJqueryObject('.sesultimateslide_video_cnt').hide();
        });
    sesJqueryObject('.sesslider').on('click', function () {
        var element = "";
        var totalSlides = sesJqueryObject('.sesslider_slide');     
        if (sesJqueryObject('.sesslide_active').next('.sesslider_slide').length) {
            element = sesJqueryObject('.sesslide_active').removeClass('sesslide_active').next('.sesslider_slide');
        element.addClass('sesslide_active');
        } else {
            sesJqueryObject('.sesslide_active').removeClass('sesslide_active');
            element = totalSlides.first();
            element.addClass('sesslide_active');
        }
        var index = totalSlides.index(element);
        var typedElem = sesJqueryObject(element).find('.txtcontent').find('section').find('._heading').find('.typed-strings');
        if (typedElem.length > 0) {
            typedJS.destroy();
            var obj = sesJqueryObject(typedElem).parent().find('.typed-strings');
            sesJqueryObject(typedElem).parent().find('._ct').css({'color':obj.css('color'),'font-size':obj.css('font-size'),'font-family':obj.css('font-family')});
            sesJqueryObject(typedElem).attr('id', 'typed-' + index);
            sesJqueryObject(typedElem).parent().find('._ct').addClass('typed-' + index);
            typedString('typed-' + index);
        }
    });
    sesJqueryObject('#previous').on('click', function () {
        var element = "";
        var totalSlides = sesJqueryObject('.sesslider_slide');
        if (sesJqueryObject('.sesslide_active').prev('.sesslider_slide').length){
            element = sesJqueryObject('.sesslide_active').removeClass('sesslide_active').prev('.sesslider_slide');
            element.addClass('sesslide_active');
        }else{
            sesJqueryObject('.sesslide_active').removeClass('sesslide_active');
            element = totalSlides.last();
            element.addClass('sesslide_active');
        }
    });
    sesJqueryObject('#next').on('click', function () {
        var element = "";
        var totalSlides = sesJqueryObject('.sesslider_slide');
        if (sesJqueryObject('.sesslide_active').next('.sesslider_slide').length){
            element = sesJqueryObject('.sesslide_active').removeClass('sesslide_active').next('.sesslider_slide');
            element.addClass('sesslide_active');
        }else{
            sesJqueryObject('.sesslide_active').removeClass('sesslide_active');
            element = totalSlides.first();
            element.addClass('sesslide_active');
        }

    });

    sesJqueryObject(document).ready(function () {
        var setintvalslider = setInterval(function () {
            slider("");
        }, <?php echo $this->transition_delay ?>);
    });
    function slider() {
        var slide = sesJqueryObject('.sesslider_slide.active');
        var totalSlide = sesJqueryObject('.sesslider_slide');
        var index = totalSlide.index(totalSlide);
        if (index == totalSlide.length - 1) {
            sesJqueryObject(totalSlide[0]).trigger('click');
        } else {
            sesJqueryObject(totalSlide[index + 1]).trigger('click');
        }
    }
</script>
