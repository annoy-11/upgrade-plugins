
<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfbstyle
 * @package    Sesfbstyle
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2017-09-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
  
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesfbstyle/externals/styles/component.css'); ?>
<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesfbstyletheme.fixleftright', 0)){ ?>
<script type="application/javascript">
    var leftContainerWidth = 0;
    var rightContainerWidth = 0;
    var middleContainerWidth = 0;
    var marginLeftContainerValue = 0;
    var marginRightContainerValue = 0;
    var globalContentContainer = "";
    var leftContainer = "";
    var rightContainer = "";
    var middleContainer = "";
    sesJqueryObject(window).load(function(e){
        globalContentContainer = sesJqueryObject('#global_content').find('div').eq(0).find('.layout_main');
        leftContainer = globalContentContainer.find('.layout_<?php echo $left; ?>');
        rightContainer = globalContentContainer.find('.layout_<?php echo $right; ?>');
        middleContainer = globalContentContainer.find('.layout_middle');
        if(globalContentContainer && globalContentContainer.width() >= 1024){
            leftContainerWidth = leftContainer.outerWidth( true );
            rightContainerWidth = rightContainer.outerWidth( true );
            middleContainerWidth = middleContainer.outerWidth( true );
            marginLeftContainerValue = leftContainer.outerWidth( true );
            marginRightContainerValue = (leftContainerWidth + middleContainerWidth);
            //set margin right on middle container
            if (leftContainer && middleContainer) {
                middleContainer.css('margin-left', leftContainerWidth);
            }
            //set margin left on middle container
            if (rightContainer && middleContainer) {
                middleContainer.css( 'margin-right',rightContainerWidth);
            }
            sesJqueryObject(window).scroll(function(){
                setContentPosition();
            });
        }
    });
    function setContentPosition(){
        var scrolling = window.getScrollTop();
        var leftContainerHeight = leftContainer.outerHeight(true);
        var rightContainerHeight = rightContainer.outerHeight(true);
        var middleContainerHeight = middleContainer.outerHeight(true);
        var visibleWindowHeight = window.getCoordinates().height;
        var footerContainerHeight = sesJqueryObject('#global_footer').outerHeight(true);
        var headerContainerHeight = sesJqueryObject('#global_header').find('div').eq(0).outerHeight(true);
        var mainContainerTopPosition = sesJqueryObject(globalContentContainer).offset().top
        var largestHeightLayout = 0;
        largestHeightLayout = leftContainer && (largestHeightLayout < leftContainerHeight) ? leftContainerHeight : largestHeightLayout;
        largestHeightLayout = middleContainer && (largestHeightLayout < middleContainerHeight) ? middleContainerHeight : largestHeightLayout;
        largestHeightLayout = rightContainer && (largestHeightLayout < rightContainerHeight) ? rightContainerHeight : largestHeightLayout;
        //fixed left container if layout height less than higest height
        if(leftContainer && leftContainerHeight < largestHeightLayout &&  scrolling > 9){
            var scrollPositionLeft = (mainContainerTopPosition > 100 ) ?  mainContainerTopPosition + leftContainerHeight - visibleWindowHeight : leftContainerHeight - visibleWindowHeight;
            if((mainContainerTopPosition - 100) < window.getScrollTop() &&  scrollPositionLeft < scrolling && window.getScrollTop() > 10){
                if(!leftContainer.hasClass('fixed'))
                    leftContainer.addClass('fixed');
            <?php if($orientation == 'rtl') { ?>
                    leftContainer.css('margin-right',rightContainerWidth+middleContainerWidth);
                <?php } ?>
            }else {
                leftContainer.removeClass('fixed');
            <?php if($orientation == 'rtl') { ?>
                    leftContainer.css('margin-right',0);
                <?php } ?>
            }
            //set bottom height for footer
            var heightLeft = leftContainerHeight;
            if((visibleWindowHeight - headerContainerHeight ) < heightLeft) {
                bottomHeight = 0;
            } else {
                bottomHeight = visibleWindowHeight - leftContainerHeight - headerContainerHeight;
            }
            if((window.getScrollHeight() - footerContainerHeight - visibleWindowHeight) < scrolling && (leftContainerHeight > (visibleWindowHeight - headerContainerHeight))) {
                bottomHeight = footerContainerHeight;
            }
            leftContainer.css( 'bottom',bottomHeight - 5);
        }else{
            //remove fixed class
            if(leftContainer && leftContainer.hasClass('fixed')) {
                leftContainer.removeClass('fixed');
                <?php if($orientation == 'rtl') { ?>
                    leftContainer.css('margin-right',0);
                <?php } ?>
            }
        }

        //fixed right container if layout height less than higest height
        if(rightContainer && rightContainerHeight < largestHeightLayout){
            var scrollPositionRight = (mainContainerTopPosition > 100 ) ? mainContainerTopPosition + rightContainerHeight - visibleWindowHeight : rightContainerHeight - visibleWindowHeight;
            if((mainContainerTopPosition - 100) < window.getScrollTop() && scrollPositionRight < scrolling &&  scrolling > 9){
                if(!rightContainer.hasClass('fixed')){
                    rightContainer.addClass('fixed');
                    rightContainer.css('margin-left',marginRightContainerValue);
                }
                var bottomHeight = 0;
                //set bottom height for footer
                var heightRight = rightContainerHeight;
                if((visibleWindowHeight - headerContainerHeight ) < heightRight) {
                    bottomHeight = 0;
                } else {
                    bottomHeight = visibleWindowHeight - rightContainerHeight - headerContainerHeight;
                }
                if((window.getScrollHeight() - footerContainerHeight - visibleWindowHeight) < scrolling && (rightContainerHeight > (visibleWindowHeight - headerContainerHeight))) {
                    bottomHeight = footerContainerHeight;
                }
                rightContainer.css( 'bottom',bottomHeight - 5);

            }else{
                rightContainer.removeClass('fixed');
                rightContainer.css('margin-left','');
            }
        }else{
            //remove fixed class
            if(rightContainer && rightContainer.hasClass('fixed')) {
                rightContainer.removeClass('fixed');
                rightContainer.css('margin-left','');
            }
        }


        // middle layout
        if (middleContainer && (middleContainerHeight < largestHeightLayout)) {
            var scrollPositionMiddle =  (mainContainerTopPosition > 100 ) ? mainContainerTopPosition + middleContainerHeight - visibleWindowHeight : middleContainerHeight - visibleWindowHeight;
            if((mainContainerTopPosition - 100) < window.getScrollTop() && scrollPositionMiddle < scrolling &&  scrolling > 9){
                if(!middleContainer.hasClass('fixed')){
                    middleContainer.addClass('fixed');
                    middleContainer.css('width',middleContainerWidth);
                }

                var bottomHeight = 0;
                //set bottom height for footer
                var heightRight = middleContainerHeight;
                if((visibleWindowHeight - headerContainerHeight ) < heightRight) {
                    bottomHeight = 0;
                } else {
                    bottomHeight = visibleWindowHeight - middleContainerHeight - headerContainerHeight;
                }
                if((window.getScrollHeight() - footerContainerHeight - visibleWindowHeight) < scrolling && (middleContainerHeight > (visibleWindowHeight - headerContainerHeight))) {
                    bottomHeight = footerContainerHeight;
                }
                middleContainer.css( 'bottom',bottomHeight - 5);

            }else{
                middleContainer.removeClass('fixed');
                middleContainer.css('width','');
            }
        }else{
            //remove fixed class
            if(middleContainer && middleContainer.hasClass('fixed')) {
                middleContainer.removeClass('fixed');
                middleContainer.css('width','');
            }
        }


    }
</script>
<?php } ?>
<?php $request = Zend_Controller_Front::getInstance()->getRequest();?>
<?php $controllerName = $request->getControllerName();?>
<?php $actionName = $request->getActionName();?>
<?php $moduleName = $request->getModuleName();?>
<?php if($this->viewer->getIdentity()){ ?>
<div class="header sesbasic_bxs sesbasic_clearfix">
  <?php if($this->show_logo) { ?>
    <?php if($this->headerlogo): ?>
      <div class="header_logo">
        <?php $headerlogo = $this->baseUrl() . '/' . $this->headerlogo; ?>
        <a href=""><img alt="" src="<?php echo $headerlogo ?>"></a>
      </div>
    <?php else: ?>
      <div class="header_logo">
        <a href=""><?php echo $this->siteTitle; ?></a>
      </div>
    <?php endif; ?>
  <?php } ?>
  <?php if($this->show_search) { ?>
    <div class="header_searchbox">
      <?php
          if(defined('sesadvancedsearch')){
            echo $this->content()->renderWidget("advancedsearch.search");
      }else{ ?>
      <input autocomplete="off" placeholder="<?php echo $this->translate('Search'); ?>" id="sesfbstyle_search" type="text" name="name" />
      <button onclick="javascript:showAllSearchResults();"><i class="fa fa-search"></i></button>
      <?php } ?>
    </div>
  <?php } ?>
  <div class="header_menus sesbasic_bxs sesbasic_clearfix">
    <?php if($this->show_mini) { ?>
      <div class="header_menu_left">
        <ul>
          <?php if($this->viewer_id) { ?>
            <li class="user_profile_link">
              <a href="<?php echo $this->viewer->getHref(); ?>">
                <?php if($this->viewer->photo_id) { ?>
                  <img src="<?php echo $this->viewer->getPhotoUrl('thumb.icon'); ?>" />
                <?php } else { ?>
                  <img src="application/modules/User/externals/images/nophoto_user_thumb_icon.png" />
                <?php } ?>
              <span><?php echo $this->viewer->getTitle(); ?></span></a>
            </li>
          <?php } ?>
          <li><a href=""><?php echo $this->translate("Home") ;?></a></li>
        </ul>
      </div>
      <div class="menu_middle">
        <?php
          // Reverse the navigation order (they are floating right)
          $count = count($this->navigation);
          foreach( $this->navigation->getPages() as $item ) $item->setOrder(--$count);
        ?>
        <ul>
          <?php foreach( $this->navigation as $item ) { ?>
            <?php $className = explode(' ', $item->class); ?>
            
            <?php if(end($className) == 'core_mini_signup'):?>
              <li class="sesfbstyle_minimenu_link sesfbstyle_minimenu_signup">
                <?php if($controllerName != 'signup') { ?>
                  <a id="popup-signup" href="signup">
                    <span><?php echo $this->translate($item->getLabel());?></span>
                  </a>
                <?php } ?>
              </li>
              
            <?php elseif(end($className) == 'core_mini_auth' && $this->viewer->getIdentity() == 0): ?>
              <?php if($controllerName != 'auth'  && $actionName != 'login') { ?>
                <li class="sesfbstyle_minimenu_link sesfbstyle_minimenu_login">
                  <a id="popup-login" href="login">
                    <span><?php echo $this->translate($item->getLabel());?></span>
                  </a>
                </li>
              <?php } ?>
            <?php elseif(end($className) == 'core_mini_auth' && $this->viewer->getIdentity() != 0):?>
              <?php continue;?>

            <?php elseif(end($className) == 'core_mini_friends'):?>
              <?php if($this->viewer->getIdentity()):?>
                <li class="sesfbstyle_minimenu_request sesfbstyle_minimenu_icon">
                  <?php if($this->requestCount):?>
                    <span id="request_count_new" class="sesfbstyle_minimenu_count"><?php echo $this->requestCount ?></span>
                  <?php else:?>
                    <span id="request_count_new"></span>
                  <?php endif;?>
                  <span onclick="toggleUpdatesPulldown(event, this, '4', 'friendrequest');" style="display:block;" class="friends_pulldown">
                    <div id="friend_request" class="sesfbstyle_pulldown_contents_wrapper">
                      <div class="dropdown_caret"><span class="caret_outer"></span><span class="caret_inner"></span></div>
                      <div class="sesfbstyle_pulldown_header">
                        <?php echo $this->translate('Requests'); ?>
                      </div>
                      <div id="sesfbstyle_friend_request_content" class="sesfbstyle_pulldown_contents clearfix">
                        <div class="pulldown_loading" id="friend_request_loading">
                          <img src='<?php echo $this->layout()->staticBaseUrl ?>application/modules/Core/externals/images/loading.gif' alt="<?php echo $this->translate('Loading'); ?>" />
                        </div>
                      </div>
                    </div>
                    <?php
                      $minimenu_frrequest_normal = Engine_Api::_()->getApi('settings', 'core')->getSetting('minimenu.frrequest.normal', 0); 
                      $minimenu_frrequest_mouseover = Engine_Api::_()->getApi('settings', 'core')->getSetting('minimenu.frrequest.mouseover', 0);
                    ?>
                    <?php if(empty($minimenu_frrequest_normal) && empty($minimenu_frrequest_mouseover)):?>
                      <a href="javascript:void(0);" id="show_request" class="fa fa-user-plus" title="<?php echo $this->translate("Friend Requests");?>"></a>
                    <?php else:?>
                      <a href="javascript:void(0);" class="sesfbstyle_mini_menu_friendrequest" id="show_request" title="<?php echo $this->translate("Friend Requests");?>"><i id="show_request"></i></a>
                    <?php endif;?>
                  </span>
                </li>
              <?php endif;?>
              <?php if(isset($_COOKIE['ses_login_users'])) { ?>
                 <li class="sesfbstyle_minimenu_switchuser sesfbstyle_minimenu_icon switch_user_pulldown " id="switch_user_pulldown">
                 <a href="javascript:void(0);" onclick="showRecentloginPopup();" class="fa fa-recent-user" title="<?php echo $this->translate("Recent Logins"); ?>"></a>
                 <div id="sesfbstyle_switch_user" class="sesfbstyle_pulldown_contents_wrapper" style="display:none;">
                 <div class="dropdown_caret"><span class="caret_outer"></span><span class="caret_inner"></span></div>
                
                  <div class="recent_login_section">
                  <div class="recent_login_head">
                      <h2><?php echo $this->translate("Log Into Another Account"); ?></h2>
                      <p class="sesbasic_text_light"><?php echo $this->translate("You'll be logged out first. Then someone else can log in or add their account."); ?></p>
                  </div>
                  <div class="recent_members_data">
                    <?php $recent_login = Zend_Json::decode($_COOKIE['ses_login_users']); ?>
                      <?php if(count($recent_login) > 0) { ?>
                        <?php foreach($recent_login as $users) {
                          $userArray = explode("_", $users);
                          $user = Engine_Api::_()->getItem('user', $userArray[0]);
                        ?>
                        <div id="recent_login_<?php echo $user->getIdentity(); ?>" class="member_item">
                         <!-- <a <?php /*if($this->viewer->getIdentity() == $user->getIdentity()) { */?> class="recent_login_disable" <?php /*} */?> onclick="loginAsFbstyleUser('<?php /*echo $user->user_id */?>','<?php /*echo $user->password */?>'); return false;" href="javascript:void(0);" >-->
                          <a <?php if($this->viewer->getIdentity() == $user->getIdentity()) { ?> class="recent_login_disable" <?php }else { ?>   <?php } ?> href="<?php echo $this->baseUrl()."/sesfbstyle/index/poploginfb?user_id=".$user->user_id."&type=".true;  ?>" >
                            <div class="members_tab_item">
                                <div class="_img">
                                  <?php echo $this->itemPhoto($user, 'thumb.profile'); ?>
                                </div>
                                <div class="_cont sesbasic_bg">
                                  <span class="_name"><?php echo $user->getTitle(); ?></span>
                                </div>
                            </div>
                          </a>
                          <?php if($this->viewer->getIdentity() != $user->getIdentity()) { ?>
                            <a href="javascript:void(0);" onclick="removeRecentUser('<?php echo $user->getIdentity(); ?>');" class="close-btn"><i class="fa fa-times"></i></a>
                          <?php } ?>
                          </div>
                      <?php } ?>
                      <div class="member_item">
                          <a href="<?php echo $this->baseUrl()."/sesfbstyle/index/poploginfb?user_id=newuseradd&type=".true;  ?>" >
                            <div class="members_tab_item">
                                <div class="_img">
                                  <i class="fa fa-plus"></i>
                                </div>
                                <div class="_cont sesbasic_bg">
                                  <span class="_name add_user"><?php echo $this->translate("Add Account"); ?></span>
                                </div>
                            </div>
                          </a>
                          </div>
                      </div>
                      </div>
                      </div>
                    <?php } ?>
                  
              </li>
              <?php }  ?>
            <?php elseif(end($className) == 'core_mini_notification'):?>
              <?php if($this->viewer->getIdentity()):?>
                <li id='core_menu_mini_menu_update' class="sesfbstyle_minimenu_updates sesfbstyle_minimenu_icon">
                  <?php if($this->notificationCount):?>
                    <span id="notification_count_new" class="sesfbstyle_minimenu_count">
                      <?php echo $this->notificationCount ?>
                    </span>
                  <?php else:?>
                    <span id="notification_count_new"></span>
                  <?php endif;?>
                  <span onclick="toggleUpdatesPulldown(event, this, '4', 'notifications');" style="display:block;" class="updates_pulldown">
                    <div class="sesfbstyle_pulldown_contents_wrapper">
                      <div class="dropdown_caret"><span class="caret_outer"></span><span class="caret_inner"></span></div>
                      <div class="sesfbstyle_pulldown_header">
                        <?php echo $this->translate('Notifications'); ?>
                      </div>
                      <div class="sesfbstyle_pulldown_contents pulldown_content_list">
                        <ul class="notifications_menu" id="notifications_menu">
                          <div class="pulldown_loading" id="notifications_loading">
                            <img src='<?php echo $this->layout()->staticBaseUrl ?>application/modules/Core/externals/images/loading.gif' alt="<?php echo $this->translate('Loading'); ?>" />
                          </div>
                        </ul>
                      </div>
                      <div class="pulldown_options">
                        <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'activity', 'controller' => 'notifications'), $this->translate('View All Updates'), array('id' => 'notifications_viewall_link')) ?>
                        <?php echo $this->htmlLink('javascript:void(0);', $this->translate('Mark All Read'), array('id' => 'notifications_markread_link')); ?>
                      </div>
                    </div>
                    <?php 
                      $minimenu_notification_normal = Engine_Api::_()->getApi('settings', 'core')->getSetting('minimenu.notification.normal', ''); 
                      $minimenu_notification_mouseover = Engine_Api::_()->getApi('settings', 'core')->getSetting('minimenu.notification.mouseover', 0);
                    ?>
                    <?php if(empty($minimenu_notification_normal) && empty($minimenu_notification_mouseover)):?>
                      <a href="javascript:void(0);"  id="show_update" class="fa fa-bell" title="<?php echo $this->translate("Notificatons");?>">
                        <span <?php if($this->notificationCount == 0) { ?> style="display:none" <?php } ?>  id="updates_toggle"><?php echo $this->translate($this->locale()->toNumber($this->notificationCount)) ?></span>
                      </a>
                    <?php else:?>
                      <a href="javascript:void(0);" id="show_update" class="<?php if( $this->notificationCount ):?>new_updates<?php endif;?> sesfbstyle_mini_menu_notification" title="<?php echo $this->translate("Notificatons");?>"><i id="show_update"></i>
                      <span <?php if($this->notificationCount == 0) { ?> style="display:none" <?php } ?> id="updates_toggle"><?php echo $this->translate($this->locale()->toNumber($this->notificationCount)) ?></span></a>
                    <?php endif;?>
                  </span>
                </li>
              <?php endif;?>
            <?php elseif(end($className) == 'core_mini_settings'):?>
              <li class="sesfbstyle_minimenu_setting sesfbstyle_minimenu_icon">
                <span style="display:block;" class="settings_pulldown" onclick="toggleUpdatesPulldown(event, this, '4', 'settings');">
                  <div id="user_settings" class="sesfbstyle_pulldown_contents_wrapper ariana-mini-menu-settings-pulldown">
                    <div class="dropdown_caret"><span class="caret_outer"></span><span class="caret_inner"></span></div>
                    <div class="sesfbstyle_pulldown_header">
                      <?php echo $this->translate('Account & Settings');?>
                    </div>
                    <div id="sesfbstyle_user_settings_content" class="sesfbstyle_pulldown_contents clearfix">
                      <ul>
                        <li><a href="<?php echo $this->viewer->getHref(); ?>"><?php echo $this->translate("My Profile");?></a></li>
                      </ul>
                      <ul>
                        <?php foreach( $this->settingNavigation as $link ): ?>
                          <li>
                            <?php echo $this->htmlLink($link->getHref(), $this->translate($link->getLabel()), array(
                              'class' => 'buttonlink' . ( $link->getClass() ? ' ' . $link->getClass() : '' ),
                              'style' => $link->get('icon') ? 'background-image: url('.$link->get('icon').');' : '',
                              'target' => $link->get('target'),
                            )) ?>
                          </li>
                        <?php endforeach; ?>
                      </ul>
                      <?php //echo $this->navigation()->menu()->setContainer($this->settingNavigation)->render();?>
                      <ul>
                        <?php if($this->viewer->level_id == 1 || $this->viewer->level_id == 2):?>
                          <li>
                            <a href="<?php echo $this->url(array(), 'admin_default', true)?>"><?php echo $this->translate('Administrator');?></a>
                          </li>
                        <?php endif;?>
                        <li>
                          <a href="<?php echo $this->url(array(), 'user_logout', true)?>"><?php echo $this->translate('Logout');?></a>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <a href="javascript:void(0);" id="show_settings_img" title="<?php echo $this->translate('Account & Settings');?>"><i id='' class="fa fa-caret-down"></i></a>
                </span>
              </li>
            
            <?php elseif(end($className) == 'core_mini_messages'):?>
              <li class="sesfbstyle_minimenu_message sesfbstyle_minimenu_icon">
                <?php if($this->messageCount):?>
                  <span id="message_count_new" class="sesfbstyle_minimenu_count"><?php echo $this->messageCount ?></span>
                <?php else:?>
                  <span id="message_count_new"></span>
                <?php endif;?>
                <span onclick="toggleUpdatesPulldown(event, this, '4', 'message');" style="display:block;" class="messages_pulldown">
                  <div id="sesfbstyle_user_messages" class="sesfbstyle_pulldown_contents_wrapper ariana-mini-menu-messages-pulldown">
                    <div class="dropdown_caret"><span class="caret_outer"></span><span class="caret_inner"></span></div>
                    <div class="sesfbstyle_pulldown_header">
                      <?php echo $this->translate('Messages'); ?>
                      <a class="icon_message_new righticon fa fa-plus" title="<?php echo $this->translate('Compose New Message'); ?>" href="<?php echo $this->url(array('action' => 'compose'), 'messages_general') ?>"></a>
                    </div>
                    <div id="sesfbstyle_user_messages_content" class="sesfbstyle_pulldown_contents clearfix">
                      <div class="pulldown_loading">
                        <img src='<?php echo $this->layout()->staticBaseUrl ?>application/modules/Core/externals/images/loading.gif' alt="<?php echo $this->translate('Loading'); ?>" />
                      </div>
                    </div>
                  </div>
                  <?php
                    $minimenu_message_normal = Engine_Api::_()->getApi('settings', 'core')->getSetting('minimenu.message.normal', 0); 
                    $minimenu_message_mouseover = Engine_Api::_()->getApi('settings', 'core')->getSetting('minimenu.message.mouseover', 0);
                  ?>
                  <?php if(empty($minimenu_message_normal) && empty($minimenu_message_mouseover)):?>
                    <a href="javascript:void(0);" id="show_message" class="fa fa-comments" title="<?php echo $this->translate("Messages");?>"></a>
                  <?php else:?>
                    <a href="javascript:void(0);" class="sesfbstyle_mini_menu_message" id="show_message" title="<?php echo $this->translate("Messages");?>"><i id="show_message"></i></a>
                  <?php endif;?>
                </span>
              </li>
            <?php elseif(end($className) == 'core_mini_admin'):?>
              <?php continue;?>
            <?php else:?>
              <li class="sesfbstyle_minimenu_link">
                <?php echo $this->htmlLink($item->getHref(), $this->translate($item->getLabel()), array_filter(array( 'class' => ( !empty($item->class) ? $item->class : null ), 'alt' => ( !empty($item->alt) ? $item->alt : null ), 'target' => ( !empty($item->target) ? $item->target : null )))); ?>
              </li>
            <?php endif;?>
          <?php } ?>
        </ul>
      </div>
    <?php } ?>
    <?php if($this->show_menu) { ?>
      <div class="menu_right">
        <ul>
          <li id="st-trigger-effects" class="main_menu_link st-pusher">
            <a onclick="showMenu();" href="javascript:void(0);" class="slide_btn" id="slide_btn" data-effect="st-effect-4"><i class="fa fa-bars"></i></a>
          </li>
          <li class="searc_icon">
            <a onclick="showSearch();" href="javascript:void(0);"><i class="fa fa-search"></i></a>
            <div class="responsive_search" id="show_fbstyle_search" style="display:none;">
                <!--<input type="search" placeholder="Search" />-->
                <input autocomplete="off" placeholder="<?php echo $this->translate('Search'); ?>" id="sesfbstyle_search" type="text" name="name" />
                <a onclick="javascript:showAllSearchResultsSide();" href="javascript:void(0);"><i class="fa fa-search"></i></a>
            </div>
          </li>
        </ul>
      </div>
    <?php } ?>
  </div>
</div>
<?php }else{?>
  <div class="header_guest sesbasic_bxs">
    <div class="header_guest_main">
      <?php if($this->show_logo) { ?>
        <div class="_logo">
         <?php if($this->headerlogo){ ?>
            <?php $headerlogo = $this->baseUrl() . '/' . $this->headerlogo; ?>
            <a href=""><img alt="" src="<?php echo $headerlogo ?>"></a>
          <?php } else { ?>
            <a href=""><?php echo $this->siteTitle; ?></a>
          <?php } ?>
        </div>
      <?php } ?>
      <?php if($this->show_menu){ ?>
        <div id="st-trigger-effects" class="main_toggle st-pusher">
          <a onclick="showMenu();" href="javascript:void(0);" class="slide_btn" id="slide_btn" data-effect="st-effect-4"><i class="fa fa-bars"></i></a>
        </div>
      <?php } ?>
      <?php if($this->show_mini) { ?>
        <?php if($this->viewer->getIdentity() == 0): ?>
          <?php if($controllerName != 'signup') { ?>
            <div class="menu_signup">
              <a href="signup"><?php echo $this->translate("Sign Up");?></a>
            </div>
          <?php } ?>
        <?php endif; ?>
        <?php if($this->viewer->getIdentity() == 0): ?>
          <?php if($controllerName != 'auth'  && $actionName != 'login') { ?>
            <div class="_loginform">
              <div class="_links">
                <a id="login_link" href="javascript:void(0);" class="login_link"><?php echo $this->translate("Sign In"); ?></a>
              </div>
              <?php echo $this->content()->renderWidget("sesfbstyle.login-or-signup")?>
            </div>
          <?php } ?>
        <?php endif; ?>
      <?php } ?>
    </div>
  </div>
<script type='text/javascript'>
  sesJqueryObject(document).on('click','#login_link',function(){
  if(sesJqueryObject (this).hasClass('active')){
   sesJqueryObject (this).removeClass('active');
   sesJqueryObject ('#sesabasic_form_login').removeClass('_showform');
  }else{
   sesJqueryObject (this).addClass('active');
   sesJqueryObject ('#sesabasic_form_login').addClass('_showform');
  }
});
</script>
<?php };?>
<div id="update_count" style="display:none;"></div>
<nav class="st-menu st-effect-4" id="show_main_menu">
  <div class="menus_searh_close">
    <div class="menu_search_box">
      <input autocomplete="off" placeholder="<?php echo $this->translate('Search'); ?>" id="sesfbstyleside_search" type="text" name="name" />
      <a onclick="javascript:showAllSearchResultsSide();" href="javascript:void(0);"><i class="fa fa-search"></i></a>      
    </div>
    <div class="closer_button">
  		<a onclick="hideSidePanel();" href="javascript:void(0);" class="close_menu"><i class="fa fa-close"></i></a>  
    </div>
  </div>
  
  <div id="menu_left_panel" class="menu_right_panel mCustomScrollbar" data-mcs-theme="minimal-dark">
  
    <ul class="menu_right_list_links">
      <?php foreach( $this->mainMenuNavigation as $navigationMenu ): ?>
        <?php $class = explode(' ', $navigationMenu->class); ?>
        <?php $navClass = end($class); ?>
        <li <?php if ($navigationMenu->active): ?><?php echo "class='active'";?><?php endif; ?>>
          <?php if($navClass == 'core_main_invite'):?>
            <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $this->url(array('module' => 'invite'), $navigationMenu->route, true) ?>'>
          <?php elseif($navClass == 'core_main_home' && ($this->viewer->getIdentity() != 0)):?>
            <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $this->url(array('action' => 'home'), $navigationMenu->route, true) ?>'>
          <?php else:?>
            <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo empty($navigationMenu->uri) ? $this->url(array(), $navigationMenu->route, true) : $navigationMenu->uri ?>'>
          <?php endif;?>
          <i class="fa <?php echo $navigationMenu->get('icon') ? $navigationMenu->get('icon') : 'fa-star' ?>"></i>
          <span><?php echo $this->translate($navigationMenu->label); ?></span>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
    <?php if($this->footersidepanel) { ?>
      <div class="menu_footer">
        <div class="menu_footer_links">
          <ul>
            <?php foreach( $this->footerNavigation as $item ): ?>
              <li><a href="<?php echo $item->getHref(); ?>"><?php echo $this->translate($item->getLabel()); ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <div class="menu_copy_lang">
          <p class="menu_copyright"><?php echo $this->translate('Copyright &copy; %s', date('Y')) ?></p>
          <?php if( 1 !== count($this->languageNameList) ): ?>
            <div class="footer_lang">
              <form method="post" action="<?php echo $this->url(array('controller' => 'utility', 'action' => 'locale'), 'default', true) ?>" style="display:inline-block">
                <?php $selectedLanguage = $this->translate()->getLocale() ?>
                <?php echo $this->formSelect('language', $selectedLanguage, array('onchange' => '$(this).getParent(\'form\').submit();'), $this->languageNameList) ?>
                <?php echo $this->formHidden('return', $this->url()) ?>
              </form>
            </div>
          <?php endif; ?>
        </div>
      </div>
    <?php } ?>
    
  </div>
</nav>

<script type='text/javascript'>

  function scrollingFbStyle() {

    var height = sesJqueryObject( window ).height();
    if(document.getElementById("menu_left_panel")) {
      document.getElementById("menu_left_panel").setStyle("max-height", height+"px");
    }
    var heightPannel = sesJqueryObject("#menu_left_panel").height() - 51;
    sesJqueryObject('#global_content').css('min-height',heightPannel+'px');
  }
  
  sesJqueryObject(document).ready(function(){
    scrollingFbStyle();
  });

  function showSearch() { 
    if(document.getElementById('show_fbstyle_search').style.display == 'block') {
      document.getElementById('show_fbstyle_search').style.display = 'none';
    }
    else {
      document.getElementById('show_fbstyle_search').style.display = 'block';
    }
  }

  function showMenu() {
    if(document.getElementById('show_main_menu').style.display != 'block') {
      <?php if($this->sidepaneldesign == 1) { ?>
        $(document.body).addClass("st-menu-open-design1");
      <?php } else { ?>
        $(document.body).addClass("st-menu-open-design2");
      <?php } ?>
      
    }
  }
  function hideSidePanel() {
    <?php if($this->sidepaneldesign == 1) { ?>
      $(document.body).removeClass("st-menu-open-design1");
    <?php } else { ?>
      $(document.body).removeClass("st-menu-open-design2");
    <?php } ?>
  }
	
		window.addEvent('domready', function() {
		
			$(document.body).addEvent('click', function(event) {
	
				if(event.target.className != 'fa fa-bars' && event.target.id != 'sesfbstyleside_search' && event.target.className != 'menu_footer_links' && event.target.className != 'fa fa-bars' && event.target.id != 'language') {
					//$(document.body).removeClass("st-menu-open");
					<?php if($this->sidepaneldesign == 1) { ?>
						$(document.body).removeClass("st-menu-open-design1");
					<?php } else { ?>
						$(document.body).removeClass("st-menu-open-design2");
					<?php } ?>
				}
			});
		});
  
	<?php if($this->viewer->getIdentity()){?>
		var notificationUpdater;
		en4.core.runonce.add(function(){
	
			if($('notifications_markread_link')){
				$('notifications_markread_link').addEvent('click', function() {
					$('notification_count_new').setStyle('display', 'none');
					en4.activity.hideNotifications('<?php echo $this->string()->escapeJavascript($this->translate("0 Updates"));?>');
				});
			}
	
			<?php if ($this->updateSettings && $this->viewer->getIdentity()): ?>
				notificationUpdater = new NotificationUpdateHandler({
					'delay' : <?php echo $this->updateSettings;?>
				});
				notificationUpdater.start();
				window._notificationUpdater = notificationUpdater;
			<?php endif;?>
		});
		
		var previousMenu;
		var abortRequest;
		var toggleUpdatesPulldown = function(event, element, user_id, menu) {
		
			if (typeof(abortRequest) != 'undefined') {
				abortRequest.cancel();
			}
	
			if(event.target.className == 'sesfbstyle_pulldown_header')
				return;
		 
			var hideNotification = 0;
			var hideMessage = 0;
			var hideSettings = 0;
			var hideFriendRequests = 0;
			
			if($$(".updates_pulldown_selected").length > 0) {
				$$('.updates_pulldown_selected').set('class', 'updates_pulldown');
				var hideNotification = 1;
			}
	
			if($$(".messages_pulldown_selected").length > 0) {
				$$('.messages_pulldown_selected').set('class', 'messages_pulldown');
				hideMessage = 1;
			}
			if($$(".settings_pulldown_selected").length > 0) {
				$$('.settings_pulldown_selected').set('class', 'settings_pulldown');
				hideSettings = 1;
			}
			if($$(".settings_pulldown_selected").length > 0) {
				$$('.settings_pulldown_selected').set('class', 'settings_pulldown');
				hideSettings = 1;
			}
			
			if($$(".friends_pulldown_selected").length > 0) {
				$$('.friends_pulldown_selected').set('class', 'friends_pulldown');
				hideFriendRequests = 1;
			}
		
			if(menu == 'notifications' && hideNotification == 0) {
				
				if(element.className=='updates_pulldown') {
					element.className= 'updates_pulldown_selected';
					showNotifications();
				} else
					element.className='updates_pulldown';
			}
			else if(menu == 'message' && hideMessage == 0) {
				if( element.className=='messages_pulldown' ) {
					element.className= 'messages_pulldown_selected';
					showMessages();
				} else {
					element.className='messages_pulldown';
				}
			}
			else if(menu == 'settings' && hideSettings == 0) {
	
				if( element.className=='settings_pulldown' ) {
					element.className = 'settings_pulldown_selected';
				} else {
					element.className='settings_pulldown';
				}
			}
			else if(menu == 'friendrequest' && hideFriendRequests == 0) {
				if( element.className=='friends_pulldown' ) {
					element.className= 'friends_pulldown_selected';
					showFriendRequests();
				} else {
					element.className='friends_pulldown';
				}
			}
			previousMenu = menu;
		}
		
		var showNotifications = function() {
	
			en4.activity.updateNotifications();
			abortRequest = new Request.HTML({
				'url' : en4.core.baseUrl + 'sesfbstyle/notifications/pulldown',
				'data' : {
					'format' : 'html',
					'page' : 1
				},
				'onComplete' : function(responseTree, responseElements, responseHTML, responseJavaScript) {
					if( responseHTML ) {
						// hide loading iconsignup
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
					document.getElementById('notification_count_new').innerHTML = '';
					document.getElementById('notification_count_new').removeClass('sesfbstyle_minimenu_count');
				}
			});
			en4.core.request.send(abortRequest, {
				'force': true
			});
		}
	
		function showMessages() {
	
			abortRequest = new Request.HTML({
				url : en4.core.baseUrl + 'sesfbstyle/index/inbox',
				data : {
					format : 'html'
				},
				onSuccess : function(responseTree, responseElements, responseHTML, responseJavaScript)
				{
				 document.getElementById('sesfbstyle_user_messages_content').innerHTML = responseHTML;
				 document.getElementById('message_count_new').innerHTML = '';
				 document.getElementById('message_count_new').removeClass('sesfbstyle_minimenu_count');
				}
			}); 
			en4.core.request.send(abortRequest, {
			'force': true
			});
		}
	
		function showFriendRequests() {
	
			abortRequest = new Request.HTML({
				url : en4.core.baseUrl + 'sesfbstyle/index/friendship-requests',
				data : {
					format : 'html'
				},
				onSuccess : function(responseTree, responseElements, responseHTML, responseJavaScript)
				{
				 if(responseHTML) {
					 document.getElementById('sesfbstyle_friend_request_content').innerHTML = responseHTML;
					 document.getElementById('request_count_new').innerHTML = '';
					 document.getElementById('request_count_new').removeClass('sesfbstyle_minimenu_count');
				 }
				 else {
					$('friend_request_loading').innerHTML = '<?php echo $this->string()->escapeJavascript($this->translate("You have no new friend request."));?>';
				 }
				}
			}); 
			en4.core.request.send(abortRequest, {
				'force': true
			});
		}
	
		window.addEvent('domready', function() {
		
			$(document.body).addEvent('click', function(event) {
	

				
				if(event.target.className != 'fa fa-search' && event.target.id != 'sesfbstyle_search') {
					if($('show_fbstyle_search').style.display == 'block') {
						$('show_fbstyle_search').style.display = 'none';
					}
				}
				
				if(event.target.id != 'show_message' && event.target.id != 'show_request' && event.target.id != 'show_update' &&  event.target.id != 'show_settings_img' && event.target.className != 'sesfbstyle_pulldown_header' && event.target.className != 'pulldown_loading' && event.target.className != 'fa fa-caret-down') {
					if($$(".updates_pulldown_selected").length > 0)
						$$('.updates_pulldown_selected').set('class', 'updates_pulldown');
	
					if($$(".messages_pulldown_selected").length > 0)
						$$('.messages_pulldown_selected').set('class', 'messages_pulldown');
	
					if($$(".settings_pulldown_selected").length > 0)
						$$('.settings_pulldown_selected').set('class', 'settings_pulldown');
				
					if($$(".friends_pulldown_selected").length > 0)
						$$('.friends_pulldown_selected').set('class', 'friends_pulldown');  
				}
			});
			
			<?php if($this->viewer->getIdentity() != 0) : ?>
				setInterval(function() {
					newUpdates();
				},20000);
			
				window.setInterval(function() {
					newMessages();
				},30000);
			
				window.setInterval(function() {
					newFriendRequests();
				},10000);
			<?php endif; ?>
		});
	
		
		function newFriendRequests() {
	
			en4.core.request.send(new Request.JSON({
				url : en4.core.baseUrl + 'sesfbstyle/index/new-friend-requests',
				method : 'POST',
				data : {
					format : 'json'
				},
				onSuccess : function(responseJSON) {
					if( responseJSON.requestCount && $("request_count_new") ) {
						$('updates_toggle').addClass('new_updates');
						$("request_count_new").style.display = 'block';
						if(responseJSON.requestCount > 0 && responseJSON.requestCount != '')
							$("request_count_new").addClass('sesfbstyle_minimenu_count');
						$("request_count_new").innerHTML = responseJSON.requestCount;
					}
				}
			}));
		}
		
		function newUpdates() {
			en4.core.request.send(new Request.JSON({
				url : en4.core.baseUrl + 'sesfbstyle/index/new-updates',
				method : 'POST',
				data : {
					format : 'json'
				},
				onSuccess : function(responseJSON) {
					if( responseJSON.notificationCount && $("notification_count_new") ) {
						$('updates_toggle').addClass('new_updates');
						$("notification_count_new").style.display = 'block';
						$("notification_count_new").innerHTML = responseJSON.notificationCount;
						if(responseJSON.notificationCount > 0 && responseJSON.notificationCount != '')
							$("notification_count_new").addClass('sesfbstyle_minimenu_count');
					}
				}
			}));
		}
		
		function newMessages() {
			en4.core.request.send(new Request.JSON({
				url : en4.core.baseUrl + 'sesfbstyle/index/new-messages',
				method : 'POST',
				data : {
					format : 'json'
				},
				onSuccess : function(responseJSON) {
	
					if( responseJSON.messageCount && $("message_count_new") ) {
						$('updates_toggle').addClass('new_updates');
						$("message_count_new").style.display = 'block';
						if(responseJSON.messageCount > 0 && responseJSON.messageCount != '')
						$("message_count_new").addClass('sesfbstyle_minimenu_count');
						$("message_count_new").innerHTML = responseJSON.messageCount;
					}
				}
			}));
		}
		
		//Search
		en4.core.runonce.add(function() {
			var searchAutocomplete = new Autocompleter.Request.JSON('sesfbstyleside_search', "<?php echo $this->url(array('module' => 'sesfbstyle', 'controller' => 'index', 'action' => 'search'), 'default', true) ?>", {
				'postVar': 'text',
				'delay' : 250,
				'minLength': 1,
				'selectMode': 'pick',
				'autocompleteType': 'tag',
				'customChoices': true,
				'filterSubset': true,
				'multiple': false,
				'className': 'sesbasic-autosuggest',
				'indicatorClass':'input_loading',
				'injectChoice': function(token) {
				if(token.url != 'all') {
					var choice = new Element('li', {
						'class': 'autocompleter-choices',
						'html': token.photo,
						'id': token.label
					});
					new Element('div', {
						'html': this.markQueryValue(token.label),
						'class': 'autocompleter-choice'
					}).inject(choice);
					new Element('div', {
						'html': this.markQueryValue(token.resource_type),
						'class': 'autocompleter-choice bold'
					}).inject(choice);
					choice.inputValue = token;
					this.addChoiceEvents(choice).inject(this.choices);
					choice.store('autocompleteChoice', token);
				}
				else {
				 var choice = new Element('li', {
						'class': 'autocompleter-choices',
						'html': '',
						'id': 'all'
					});
					new Element('div', {
						'html': 'Show All Results',
						'class': 'autocompleter-choice',
						onclick: 'javascript:showAllSearchResults();'
					}).inject(choice);
					choice.inputValue = token;
					this.addChoiceEvents(choice).inject(this.choices);
					choice.store('autocompleteChoice', token);
				}
				}
			});
			searchAutocomplete.addEvent('onSelection', function(element, selected, value, input) {
				var url = selected.retrieve('autocompleteChoice').url;
				window.location.href = url;
			});
		});
		
		en4.core.runonce.add(function() {
			var searchAutocomplete = new Autocompleter.Request.JSON('sesfbstyle_search', "<?php echo $this->url(array('module' => 'sesfbstyle', 'controller' => 'index', 'action' => 'search'), 'default', true) ?>", {
				'postVar': 'text',
				'delay' : 250,
				'minLength': 1,
				'selectMode': 'pick',
				'autocompleteType': 'tag',
				'customChoices': true,
				'filterSubset': true,
				'multiple': false,
				'className': 'sesbasic-autosuggest',
				'indicatorClass':'input_loading',
				'injectChoice': function(token) {
				if(token.url != 'all') {
					var choice = new Element('li', {
						'class': 'autocompleter-choices',
						'html': token.photo,
						'id': token.label
					});
					new Element('div', {
						'html': this.markQueryValue(token.label),
						'class': 'autocompleter-choice'
					}).inject(choice);
					new Element('div', {
						'html': this.markQueryValue(token.resource_type),
						'class': 'autocompleter-choice bold'
					}).inject(choice);
					choice.inputValue = token;
					this.addChoiceEvents(choice).inject(this.choices);
					choice.store('autocompleteChoice', token);
				}
				else {
				 var choice = new Element('li', {
						'class': 'autocompleter-choices',
						'html': '',
						'id': 'all'
					});
					new Element('div', {
						'html': 'Show All Results',
						'class': 'autocompleter-choice',
						onclick: 'javascript:showAllSearchResults();'
					}).inject(choice);
					choice.inputValue = token;
					this.addChoiceEvents(choice).inject(this.choices);
					choice.store('autocompleteChoice', token);
				}
				}
			});
			searchAutocomplete.addEvent('onSelection', function(element, selected, value, input) {
				var url = selected.retrieve('autocompleteChoice').url;
				window.location.href = url;
			});
		});
		
		function showAllSearchResults() {
			if($('all'))
				$('all').removeEvents('click');
			window.location.href= '<?php echo $this->url(array("controller" => "search"), "default", true); ?>' + "?query=" + $('sesfbstyle_search').value;
		}
		
		function showAllSearchResultsSide() {
			if($('all'))
				$('all').removeEvents('click');
			window.location.href= '<?php echo $this->url(array("controller" => "search"), "default", true); ?>' + "?query=" + $('sesfbstyleside_search').value;
		}
		
		sesJqueryObject(document).ready(function() {
			sesJqueryObject('#sesfbstyle_search').keydown(function(e) {
				if (e.which === 13) {
					showAllSearchResults();
				}
			});
			sesJqueryObject('#sesfbstyleside_search').keydown(function(e) {
				if (e.which === 13) {
					showAllSearchResultsSide();
				}
			});
		});
   <?php } ?>
	
	sesJqueryObject(window).ready(function(e){
		var height = sesJqueryObject(".layout_page_header").height();
		if($("global_wrapper")) {
			$("global_wrapper").setStyle("margin-top", height+"px");
		}
	});
	
	function showRecentloginPopup() {
    if($('sesfbstyle_switch_user').style.display == 'block') {
      $('sesfbstyle_switch_user').style.display = 'none';
      sesJqueryObject('#switch_user_pulldown').removeClass('switch_user_pulldown_selected');
    } else {
      $('sesfbstyle_switch_user').style.display = 'block';
      sesJqueryObject('#switch_user_pulldown').addClass('switch_user_pulldown_selected');
    }
	}
	
  function removeRecentUser(user_id) {
  
    var url = en4.core.baseUrl + 'sesfbstyle/index/removerecentlogin';
    sesJqueryObject('#recent_login_'+user_id).fadeOut("slow", function(){
      setTimeout(function() {
        sesJqueryObject('#recent_login_'+user_id).remove();
      }, 2000);
    });
    (new Request.JSON({
      url: url,
      data: {
          format: 'json',
          user_id: user_id,
      },
      onSuccess: function () {
          window.location.replace('<?php echo $this->url(array(), 'default', true) ?>');
      }
    })).send();
  }
  
  function loginAsFbstyleUser(user_id, password) {
    var url = en4.core.baseUrl + 'sesfbstyle/index/login';
    (new Request.JSON({
      url : url,
      data : {
        format : 'json',
        user_id : user_id,
        password: password,
      },
      onSuccess : function() {
        window.location.replace('members/home/');
      }
    })).send();
  }
</script>
