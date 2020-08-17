<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: left-bar.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/dashboard.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Epetition/externals/styles/styles.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Epetition/externals/styles/style_dashboard.css'); ?>
<?php if (Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('epetitionpackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('epetitionpackage.enable.package', 1) && isset($this->petition->package_id) && $this->petition->package_id) {
  $package = Engine_Api::_()->getItem('epetitionpackage_package', $this->petition->package_id);
  $modulesEnable = json_decode($package->params, true);
}
$slug=Engine_Api::_()->core()->getSubject('epetition');
?>
<div class="layout_middle epetition_dashboard_main_nav">
  <?php echo $this->content()->renderWidget('epetition.browse-menu'); ?>
</div>
<div class="layout_middle">
    <div class="epetition_dashboard_menu_list">
        <div class="sesbasic_dashboard_container sesbasic_clearfix">
            <div class="epetition_dashboard_top_section sesbasic_dashboard_top_section sesbasic_clearfix sesbm">
                <div class="sesbasic_dashboard_top_section_left">
                    <div class="sesbasic_dashboard_top_section_item_photo"> <?php echo $this->htmlLink($this->petition->getHref(), $this->itemPhoto($this->petition, 'thumb.icon')) ?> </div>
                    <div class="sesbasic_dashboard_top_section_item_title"> <?php echo $this->htmlLink($this->petition->getHref(), $this->petition->getTitle()); ?> </div>
                </div>
                <div class="sesbasic_dashboard_top_section_btns">
                    <a href="<?php echo $this->petition->getHref(); ?>"
                       class="sesbasic_link_btn"><?php echo $this->translate("View Petition"); ?></a>
                  <?php if ($this->petition->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'delete')) { ?>
                      <a href="<?php echo $this->url(array('epetition_id' => $this->petition->epetition_id, 'action' => 'delete'), 'epetition_specific', true); ?>"
                         class="sesbasic_link_btn smoothbox"><?php echo $this->translate("Delete Petition"); ?></a>
                  <?php } ?>
                </div>
            </div>
        </div>
        <div class="epetition_dashboard_tabs sesbasic_dashboard_tabs sesbasic_bxs">
            <ul class="sesbm">
                <li class="sesbm">
                  <?php $manage_petition = Engine_Api::_()->getDbtable('dashboards', 'epetition')->getDashboardsItems(array('type' => 'manage_petition')); ?>
                    <a href="#Manage" class="sesbasic_dashboard_nopropagate"> Manage Petition</a>
                    <?php
                    $viewer = Engine_Api::_()->user()->getViewer();
                    if(Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'epetition', 'edit')) {
                        if(Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'epetition', 'edit')!=1 || $viewer->getIdentity()==$slug['owner_id']) {
                        ?>
                  <?php $edit_petition = Engine_Api::_()->getDbtable('dashboards', 'epetition')->getDashboardsItems(array('type' => 'edit_petition')); ?>
                       <?php } } ?>
                  <?php $edit_photo = Engine_Api::_()->getDbtable('dashboards', 'epetition')->getDashboardsItems(array('type' => 'edit_photo')); ?>
                  <?php $petition_roles = Engine_Api::_()->getDbtable('dashboards', 'epetition')->getDashboardsItems(array('type' => 'petition_role')); ?>
                  <?php $petition_decisionmakers = Engine_Api::_()->getDbtable('dashboards', 'epetition')->getDashboardsItems(array('type' => 'petition_decisionmaker')); ?>
                  <?php $petition_announcement = Engine_Api::_()->getDbtable('dashboards', 'epetition')->getDashboardsItems(array('type' => 'petition_announcement')); ?>
                  <?php $petition_letter = Engine_Api::_()->getDbtable('dashboards', 'epetition')->getDashboardsItems(array('type' => 'petition_letter')); ?>
                  <?php $petition_close = Engine_Api::_()->getDbtable('dashboards', 'epetition')->getDashboardsItems(array('type' => 'petition_close')); ?>
                  <?php $petition_victory = Engine_Api::_()->getDbtable('dashboards', 'epetition')->getDashboardsItems(array('type' => 'petition_victory')); ?>
                  <?php $petition_signature = Engine_Api::_()->getDbtable('dashboards', 'epetition')->getDashboardsItems(array('type' => 'petition_signature')); ?>
                  <?php $contact_information = Engine_Api::_()->getDbtable('dashboards', 'epetition')->getDashboardsItems(array('type' => 'contact_information')); ?>
                  <?php $seo = Engine_Api::_()->getDbtable('dashboards', 'epetition')->getDashboardsItems(array('type' => 'seo')); ?>
                 <?php   if(Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'epetition', 'style')) {  ?>
                  <?php $style = Engine_Api::_()->getDbtable('dashboards', 'epetition')->getDashboardsItems(array('type' => 'edit_style')); ?>
                        <?php  } ?>
                  <?php $editLocation = Engine_Api::_()->getDbtable('dashboards', 'epetition')->getDashboardsItems(array('type' => 'edit_location')); ?>
                  <?php $fields = Engine_Api::_()->getDbtable('dashboards', 'epetition')->getDashboardsItems(array('type' => 'fields')); ?>
                  <?php $upgrade = Engine_Api::_()->getDbtable('dashboards', 'epetition')->getDashboardsItems(array('type' => 'upgrade')); ?>
                  <?php $mainphoto = Engine_Api::_()->getDbtable('dashboards', 'epetition')->getDashboardsItems(array('type' => 'mainphoto')); ?>
                    <ul class="sesbm" style="display:none">

                      <?php if (!empty($edit_petition) && $edit_petition->enabled): ?>
                          <li>
                              <a href="<?php echo $this->url(array('epetition_id' => $this->petition->custom_url), 'epetition_dashboard', true); ?>"
                                 class="dashboard_a_link"><i
                                          class="fa  fa-edit"></i> <?php echo $this->translate($edit_petition->title); ?>
                              </a></li>
                      <?php endif; ?>

                      <?php if ((!empty($edit_photo) && $edit_photo->enabled && empty($modulesEnable)) || ((isset($modulesEnable) && array_key_exists('modules', $modulesEnable) && in_array('photo', $modulesEnable['modules'])))): ?>
                          <li>
                              <a href="<?php echo $this->url(array('epetition_id' => $this->petition->custom_url, 'action' => 'edit-photo'), 'epetition_dashboard', true); ?>"
                                 class="dashboard_a_link"><i
                                          class="fa fa-photo"></i> <?php echo $this->translate($edit_photo->title); ?>
                              </a></li>
                      <?php endif; ?>

                      <?php if (!empty($petition_roles) && $petition_roles->enabled): ?>
                          <li>
                              <a href="<?php echo $this->url(array('epetition_id' => $this->petition->custom_url, 'action' => 'petition-role'), 'epetition_dashboard', true); ?>"
                                 class="dashboard_a_link"><i
                                          class="fa fa-user-plus "></i> <?php echo $this->translate($petition_roles->title); ?>
                              </a></li>
                      <?php endif; ?>


                      <?php if (!empty($petition_decisionmakers) && $petition_decisionmakers->enabled): ?>
                          <li>
                              <a href="<?php echo $this->url(array('epetition_id' => $this->petition->custom_url, 'action' => 'petition-decisionmaker'), 'epetition_dashboard', true); ?>"
                                 class="dashboard_a_link"><i
                                          class="fa fa-check"></i> <?php echo $this->translate($petition_decisionmakers->title); ?>
                              </a></li>
                      <?php endif; ?>


                      <?php if (!empty($petition_announcement) && $petition_announcement->enabled): ?>
                          <li>
                              <a href="<?php echo $this->url(array('epetition_id' => $this->petition->custom_url, 'action' => 'petition-announcement'), 'epetition_dashboard', true); ?>"
                                 class="dashboard_a_link"><i
                                          class="fa fa-bullhorn"></i> <?php echo $this->translate($petition_announcement->title); ?>
                              </a></li>
                      <?php endif; ?>



                      <?php if (!empty($petition_letter) && $petition_letter->enabled): ?>
                          <li>
                              <a href="<?php echo $this->url(array('epetition_id' => $this->petition->custom_url, 'action' => 'petition-letter'), 'epetition_dashboard', true); ?>"
                                 class="dashboard_a_link"><i
                                          class="fa fa-file-text-o"></i> <?php echo $this->translate($petition_letter->title); ?>
                              </a></li>
                      <?php endif; ?>


                      <?php if (!empty($petition_close) && $petition_close->enabled): ?>
                          <li>
                              <a href="<?php echo $this->url(array('epetition_id' => $this->petition->custom_url, 'action' => 'petition-close'), 'epetition_dashboard', true); ?>"
                                 class="dashboard_a_link"><i
                                          class="fa fa-times"></i> <?php echo $this->translate($petition_close->title); ?>
                              </a></li>
                      <?php endif; ?>

                      <?php if (!empty($petition_victory) && $petition_victory->enabled): ?>
                          <li>
                              <a href="<?php echo $this->url(array('epetition_id' => $this->petition->custom_url, 'action' => 'petition-victory'), 'epetition_dashboard', true); ?>"
                                 class="dashboard_a_link"><i
                                          class="fa fa-trophy"></i> <?php echo $this->translate($petition_victory->title); ?>
                              </a></li>

                      <?php endif; ?>


                      <?php if (!empty($petition_signature) && $petition_signature->enabled): ?>
                          <li>
                              <a href="<?php echo $this->url(array('epetition_id' => $this->petition->custom_url, 'action' => 'petition-signature'), 'epetition_dashboard', true); ?>"
                                 class="dashboard_a_link"><i
                                          class="fa fa-pencil-square"></i> <?php echo $this->translate($petition_signature->title); ?>
                              </a></li>
                      <?php endif; ?>



                      <?php if ((!empty($fields) && $fields->enabled && empty($modulesEnable)) || (isset($modulesEnable) && isset($modulesEnable['custom_fields']) && $modulesEnable['custom_fields'] && $package->custom_fields_params != '[]')): ?>
                          <li>
                              <a href="<?php echo $this->url(array('epetition_id' => $this->petition->custom_url, 'action' => 'fields'), 'epetition_dashboard', true); ?>"
                                 class="dashboard_a_link"><?php echo $this->translate($fields->title); ?></a></li>
                      <?php endif; ?>
                      <?php if ((!empty($upgrade) && $upgrade->enabled && !empty($modulesEnable))): ?>
                          <li>
                              <a href="<?php echo $this->url(array('epetition_id' => $this->petition->custom_url, 'action' => 'upgrade'), 'epetition_dashboard', true); ?>"
                                 class="dashboard_a_link"><i
                                          class="fa fa-refresh "></i> <?php echo $this->translate($upgrade->title); ?>
                              </a></li>
                      <?php endif; ?>
                      <?php if (!empty($contact_information) && $contact_information->enabled): ?>
                          <li>
                              <a href="<?php echo $this->url(array('epetition_id' => $this->petition->custom_url, 'action' => 'contact-information'), 'epetition_dashboard', true); ?>"
                                 class="sesbasic_dashboard_nopropagate_content dashboard_a_link"><i
                                          class="fa fa-envelope "></i> <?php echo $this->translate($contact_information->title); ?>
                              </a></li>
                      <?php endif; ?>

                      <?php if (!empty($seo) && $seo->enabled): ?>
                          <li>
                              <a href="<?php echo $this->url(array('epetition_id' => $this->petition->custom_url, 'action' => 'seo'), 'epetition_dashboard', true); ?>"
                                 class="sesbasic_dashboard_nopropagate_content dashboard_a_link"><i
                                          class="fa fa-file-text"></i> <?php echo $this->translate($seo->title); ?>
                              </a></li>
                      <?php endif; ?>

                      <?php if (@$style->enabled): ?>
                          <li>
                              <a href="<?php echo $this->url(array('epetition_id' => $this->petition->custom_url, 'action' => 'style'), 'epetition_dashboard', true); ?>"
                                 class="sesbasic_dashboard_nopropagate_content dashboard_a_link"><i
                                          class="fa fa-pencil "></i> <?php echo $this->translate($style->title); ?>
                              </a></li>
                      <?php endif; ?>

                      <?php if (@$editLocation->enabled && !empty($this->petition->location)): ?>
                          <li>
                              <a href="<?php echo $this->url(array('epetition_id' => $this->petition->custom_url, 'action' => 'edit-location'), 'epetition_dashboard', true); ?>"
                                 class="dashboard_a_link"><i
                                          class="fa fa-map-marker "></i> <?php echo $this->translate($editLocation->title); ?>
                              </a></li>
                      <?php endif; ?>

                      <?php if (@$mainphoto->enabled): ?>
                          <li><a class="dashboard_a_link"
                                 href="<?php echo $this->url(array('epetition_id' => $this->petition->custom_url, 'action' => 'mainphoto'), 'epetition_dashboard', true); ?>"><?php echo $this->translate($mainphoto->title); ?></a>
                          </li>
                      <?php endif; ?>

                    </ul>
                </li>
            </ul>
          <?php if (isset($this->petition->cover_photo) && $this->petition->cover_photo != 0 && $this->petition->cover_photo != '') {
            $petitionCover = Engine_Api::_()->storage()->get($this->petition->cover_photo, '')->getPhotoUrl();
          } else
            $petitionCover = '';
          ?>
            <div class="epetition_dashboard_petition_info sesbasic_clearfix">
              <?php if (isset($this->petition->cover_photo) && $this->petition->cover_photo != 0 && $this->petition->cover_photo != ''){ ?>
                  <div class="epetition_dashboard_petition_info_cover">
                      <img src="<?php echo $petitionCover; ?>"/>
                      
                    <?php if ($this->petition->featured || $this->petition->sponsored) { ?>
                        <div class="epetition_listing_label">
                          <?php if ($this->petition->featured) { ?>
                              <p class="epetition_label_featured"><?php echo $this->translate("FEATURED"); ?></p>
                          <?php } ?>
                          <?php if ($this->petition->sponsored) { ?>
                              <p class="epetition_label_sponsored"><?php echo $this->translate("SPONSORED"); ?></p>
                          <?php } ?>
                          <?php if ($this->petition->verified) { ?>
                              <p class="epetition_verified_label"><?php echo $this->translate("VERIFIED"); ?></p>
                    <?php } ?>
                        </div>
                    <?php } ?>
                   
                      <div class="epetition_dashboard_petition_main_photo sesbm">
                          <img src="<?php echo $this->petition->getPhotoUrl(); ?>"/>
                      </div>
                  </div>
              <?php } else { ?>
                <div class="epetition_dashboard_petition_photo sesbm">
                        <img src="<?php echo $this->petition->getPhotoUrl(); ?>"/>
                      <?php if ($this->petition->featured || $this->petition->sponsored) { ?>
                        <div class="epetition_listing_label">
                          <?php if ($this->petition->featured) { ?>
                              <p class="epetition_label_featured"><?php echo $this->translate("FEATURED"); ?></p>
                          <?php } ?>
                          <?php if ($this->petition->sponsored) { ?>
                              <p class="epetition_label_sponsored"><?php echo $this->translate("SPONSORED"); ?></p>
                          <?php } ?>
                          <?php if ($this->petition->verified) { ?>
                              <p class="epetition_label_verified"><?php echo $this->translate("VERIFIED"); ?></p>
                    <?php } ?>
                        </div>
                    <?php } ?>
                    </div>
                    <div class="epetition_dashboard_petition_info_content sesbasic_clearfix sesbm">
                        <div class="epetition_dashboard_petition_details">
                            <div class="epetition_dashboard_petition_title">
                                <a href="<?php echo $this->petition->getHref(); ?>"><b><?php echo $this->petition->getTitle(); ?></b></a>
                            </div>
                          <?php if ($this->petition->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition_enable_location', 1)): ?>
                            <?php $locationText = $this->translate('Location'); ?>
                            <?php $locationvalue = $this->petition->location; ?>
                            <?php echo $location = "<div class=\"epetition_list_stats epetition_list_location\">
                    <span class=\"widthfull\">
                      <i class=\"fa fa-map-marker sesbasic_text_light\" title=\"$locationText\"></i>
                      <span title=\"$locationvalue\"><a href='" . $this->url(array('resource_id' => $this->petition->epetition_id, 'resource_type' => 'epetition', 'action' => 'get-direction'), 'sesbasic_get_direction', true) . "' class=\"openSmoothbox\">" . $this->petition->location . "</a></span>
                    </span>
                  </div>";
                            ?>
                          <?php endif; ?>
                          <?php if ($this->petition->category_id) {
                            $category = Engine_Api::_()->getItem('epetition_category', $this->petition->category_id);
                            ?>
                            <?php if ($category) { ?>
                                  <div class="epetition_list_stats">
                    <span><i class="fa fa-folder-open sesbasic_text_light"></i> 
                    <a href="<?php echo $category->getHref(); ?>"><?php echo $category->getTitle(); ?></a> 
                    </span>
                                  </div>
                            <?php } ?>
                          <?php } ?>
                          <?php if (Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('epetitionpackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('epetitionpackage.enable.package', 1)) { ?>
                              <div class="epetition_list_stats epetition_list_payment">
                  <span class="widthfull">
                  <i class="fa fa-credit-card-alt sesbasic_text_light" title="<?php echo ''; ?>"></i></span>
                                <?php echo $this->content()->renderWidget('epetitionpackage.petition-renew-button', array('epetition' => $this->petition)); ?>
                              </div>
                          <?php } ?>
                        </div>
                    </div>
                  <?php }; ?>
                </div>
                <?php echo $this->content()->renderWidget('epetition.advance-share', array('dashboard' => true)); ?>
            </div>
           <script type="application/javascript">
            sesJqueryObject(document).ready(function () {
                var totalLinks = sesJqueryObject('.dashboard_a_link');
                for (var i = 0; i < totalLinks.length; i++) {
                    var data_url = sesJqueryObject(totalLinks[i]).attr('href');
                    var linkurl = window.location.href;
                    if (linkurl.indexOf(data_url) > 0) {
                        sesJqueryObject(totalLinks[i]).parent().addClass('active');
                        sesJqueryObject(totalLinks[i]).parent().parent().parent().find('a.sesbasic_dashboard_nopropagate').trigger('click');
                    }
                }
            });

            var sendParamInSearch = '';
            sesJqueryObject(document).on('click', '.sesbasic_dashboard_nopropagate, .sesbasic_dashboard_nopropagate_content', function (e) {
                e.preventDefault();
                //ajax request
                if (sesJqueryObject(this).hasClass('sesbasic_dashboard_nopropagate_content')) {
                    if (!sesJqueryObject(this).parent().hasClass('active'))
                        getDataThroughAjax(sesJqueryObject(this).attr('href'));
                    sesJqueryObject(".sesbasic_dashboard_tabs > ul li").each(function () {
                        sesJqueryObject(this).removeClass('active');
                    });
                    sesJqueryObject('.sesbasic_dashboard_tabs > ul > li ul > li').each(function () {
                        sesJqueryObject(this).removeClass('active');
                    });
                    sesJqueryObject(this).parent().addClass('active');
                    sesJqueryObject(this).parent().parent().parent().addClass('active');
                }
            });
            var ajaxRequest;

            //get data through ajax
            function getDataThroughAjax(url) {
                if (!url)
                    return;
                history.pushState(null, null, url);
                if (typeof ajaxRequest != 'undefined')
                    ajaxRequest.cancel();
                sesJqueryObject('.sesbasic_dashboard_content').html('<div class="sesbasic_loading_container"></div>');
                ajaxRequest = new Request.HTML({
                    method: 'post',
                    url: url,
                    data: {
                        format: 'html',
                        is_ajax: true,
                        dataAjax: sendParamInSearch,
                        is_ajax_content: true,
                    },
                    onComplete: function (response) {
                        sesJqueryObject('.sesbasic_dashboard_content').html(response);
                        if (typeof executeAfterLoad == 'function') {
                            executeAfterLoad();
                        }
                        if (sesJqueryObject('#loadingimgepetition-wrapper').length)
                            sesJqueryObject('#loadingimgepetition-wrapper').hide();
                    }
                });
                ajaxRequest.send();
            }

            sesJqueryObject(".sesbasic_dashboard_tabs > ul li a").each(function () {
                var c = sesJqueryObject(this).attr("href");
                sesJqueryObject(this).click(function () {
                    if (sesJqueryObject(this).hasClass('sesbasic_dashboard_nopropagate')) {
                        if (sesJqueryObject(this).parent().find('ul').is(":visible")) {
                            sesJqueryObject(this).parent().find('ul').slideUp()
                        } else {
                            sesJqueryObject(".sesbasic_dashboard_tabs ul ul").each(function () {
                                sesJqueryObject(this).slideUp();
                            });
                            sesJqueryObject(this).parent().find('ul').slideDown()
                        }
                        return false
                    }
                })
            });
            var error = false;
            var objectError;
            var counter = 0;
            var customAlert;

            function validateForm() {
                var errorPresent = false;
                if (sesJqueryObject('#epetition_ajax_form_submit').length > 0)
                    var submitFormVal = 'epetition_ajax_form_submit';
                else
                    return false;
                objectError;
                sesJqueryObject('#' + submitFormVal + ' input, #' + submitFormVal + ' select,#' + submitFormVal + ' checkbox,#' + submitFormVal + ' textarea,#' + submitFormVal + ' radio').each(
                    function (index) {
                        customAlert = false;
                        var input = sesJqueryObject(this);
                        if (sesJqueryObject(this).closest('div').parent().css('display') != 'none' && sesJqueryObject(this).closest('div').parent().find('.form-label').find('label').first().hasClass('required') && sesJqueryObject(this).prop('type') != 'hidden' && sesJqueryObject(this).closest('div').parent().attr('class') != 'form-elements') {
                            if (sesJqueryObject(this).prop('type') == 'checkbox') {
                                value = '';
                                if (sesJqueryObject('input[name="' + sesJqueryObject(this).attr('name') + '"]:checked').length > 0) {
                                    value = 1;
                                }
                                if (value == '')
                                    error = true;
                                else
                                    error = false;
                            } else if (sesJqueryObject(this).prop('type') == 'select-multiple') {
                                if (sesJqueryObject(this).val() === '' || sesJqueryObject(this).val() == null)
                                    error = true;
                                else
                                    error = false;
                            } else if (sesJqueryObject(this).prop('type') == 'select-one' || sesJqueryObject(this).prop('type') == 'select') {
                                if (sesJqueryObject(this).val() === '')
                                    error = true;
                                else
                                    error = false;
                            } else if (sesJqueryObject(this).prop('type') == 'radio') {
                                if (sesJqueryObject("input[name='" + sesJqueryObject(this).attr('name').replace('[]', '') + "']:checked").val() === '')
                                    error = true;
                                else
                                    error = false;
                            } else if (sesJqueryObject(this).prop('type') == 'textarea') {
                                if (sesJqueryObject(this).val() === '' || sesJqueryObject(this).val() == null)
                                    error = true;
                                else
                                    error = false;
                            } else {
                                if (sesJqueryObject(this).val() === '' || sesJqueryObject(this).val() == null)
                                    error = true;
                                else
                                    error = false;
                            }
                            if (error) {
                                if (counter == 0) {
                                    objectError = this;
                                }
                                counter++
                            } else {
                            }
                            if (error)
                                errorPresent = true;
                            error = false;
                        }
                    }
                );
                return errorPresent;
            }

            var ajaxDeleteRequest;
            sesJqueryObject(document).on('click', '.epetition_ajax_delete', function (e) {
                e.preventDefault();
                var object = sesJqueryObject(this);
                var url = object.attr('href');
                if (typeof ajaxDeleteRequest != 'undefined')
                    ajaxDeleteRequest.cancel();
                if (confirm("Are you sure want to delete?")) {
                    new Request.HTML({
                        method: 'post',
                        url: url,
                        data: {
                            format: 'html',
                            is_ajax: true,
                        },
                        onComplete: function (response) {
                            if (response)
                                sesJqueryObject(object).parent().parent().remove();
                            else
                                alert('Something went wrong,please try again later');
                        }
                    }).send();
                }
            });
            var submitFormAjax;
            sesJqueryObject(document).on('submit', '#epetition_ajax_form_submit', function (e) {
                e.preventDefault();
                //validate form
                var validation = validateForm();
                //if error comes show alert message and exit.
                if (validation) {
                    if (!customAlert) {
                        alert('<?php echo $this->translate("Please complete the red mark fields"); ?>');

                    }
                    if (typeof objectError != 'undefined') {
                        var errorFirstObject = sesJqueryObject(objectError).parent().parent();
                        sesJqueryObject('html, body').animate({
                            scrollTop: errorFirstObject.offset().top
                        }, 2000);
                    }
                    return false;
                } else {
                    if (!sesJqueryObject('#sesdashboard_overlay_content').length)
                        sesJqueryObject('#epetition_ajax_form_submit').before('<div class="sesbasic_loading_cont_overlay" id="sesdashboard_overlay_content"></div>');
                    else
                        sesJqueryObject('#sesdashboard_overlay_content').show();
                    //submit form
                    var form = sesJqueryObject('#epetition_ajax_form_submit');
                    var formData = new FormData(this);
                    formData.append('is_ajax', 1);
                    submitFormAjax = sesJqueryObject.ajax({
                        type: 'POST',
                        url: sesJqueryObject(this).attr('action'),
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            sesJqueryObject('#sesdashboard_overlay_content').hide();

                            var dataJson = data;
                            try {
                                var dataJson = JSON.parse(data);
                            } catch (err) {
                                //silence
                            }
                            if (dataJson.redirect) {
                                sesJqueryObject('#' + dataJson.redirect).trigger('click');

                            } else {
                                if (data) {
                                    sesJqueryObject('.sesbasic_dashboard_content').html(data);
                                } else {
                                    alert('Something went wrong,please try again later');
                                }
                            }
                        },
                        error: function (data) {
                            //silence
                        }
                    });
                }
            });
        </script>