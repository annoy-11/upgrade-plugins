<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesconstpackage	
 * @package    Sesconstpackage
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-09-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesconstpackage/views/scripts/dismiss_message.tpl';?>

<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <form enctype="application/x-www-form-urlencoded" class="global_form" action="/plugins/admin/sesconstpackage/settings" method="post">
      <div>
        <div>
          <h3>Plugins Included in This Package</h3>
          <p class="form-description">This page lists all the plugins which are included in the Advanced Contests Package. You can find the button to configure each plugin along with their names below.<br />
          To get started, please click on "<strong>Configure</strong>" button for each and Activate the plugins. Once you have activated the plugins, you can configure the settings as per your requirements.</p>
					<p>If you need any further assistance in using or configure the plugin, then please contact our support team.</p>
          <div class="sespkg_plugin_list">
          	<table class="admin_table">
            	<tr>
              	<td class="_title"><a href="https://www.socialenginesolutions.com/social-engine/advanced-contests-plugin/" target="_blank">Advanced Contests Plugin</a></td>
                <td><a href="admin/sescontest/settings/" class="_confbtn"><?php echo $this->translate("Configure")?></a></td>
              </tr>
            	<tr>
              	<td class="_title"><a href="https://www.socialenginesolutions.com/social-engine/group-communities-plugin/" target="_blank">Group Communities Plugin</a></td>
                <td><a href="admin/sesgroup/settings/" class="_confbtn"><?php echo $this->translate("Configure")?></a></td>
              </tr>
            	<tr>
              	<td class="_title"><a href="https://www.socialenginesolutions.com/social-engine/responsivevertical-theme/"  target="_blank">Responsive Vertical Theme</a></td>
                <td><a href="admin/sesariana/settings/" class="_confbtn"><?php echo $this->translate("Configure")?></a></td>
              </tr>
            	<tr>
              	<td class="_title"><a href="https://www.socialenginesolutions.com/social-engine/page-directories-plugin/"  target="_blank">Page Directories Plugin</a></td>
                <td><a href="admin/sespage/settings/" class="_confbtn"><?php echo $this->translate("Configure")?></a></td>
              </tr>
            	<tr>
              	<td class="_title"><a href="https://www.socialenginesolutions.com/social-engine/professional-gdpr-plugin/"  target="_blank">Professional GDPR Plugin</a></td>
                <td><a href="admin/sesgdpr/settings/" class="_confbtn"><?php echo $this->translate("Configure")?></a></td>
              </tr>
            	<tr>
              	<td class="_title"><a href="https://www.socialenginesolutions.com/social-engine/professional-music-plugin/"  target="_blank">Professional Music Plugin</a></td>
                <td><a href="admin/sesmusic/settings/" class="_confbtn"><?php echo $this->translate("Configure")?></a></td>
              </tr>
            	<tr>
              	<td class="_title"><a href="https://www.socialenginesolutions.com/social-engine/professional-share-plugin/"  target="_blank">Professional Share Plugin</a></td>
                <td><a href="admin/sessocialshare/settings/" class="_confbtn"><?php echo $this->translate("Configure")?></a></td>
              </tr>
            	<tr>
              	<td class="_title"><a href="https://www.socialenginesolutions.com/social-engine/social-media-login-1-click-social-connect-plugin/"  target="_blank">Social Media Login Plugin</a></td>
                <td><a href="admin/sessociallogin/settings/" class="_confbtn"><?php echo $this->translate("Configure")?></a></td>
              </tr>
            	<tr>
              	<td class="_title"><a href="https://www.socialenginesolutions.com/social-engine/social-meta-tags-plugin/"  target="_blank">Social Meta Tags Plugin</a></td>
                <td><a href="admin/sesmetatag/settings/" class="_confbtn"><?php echo $this->translate("Configure")?></a></td>
              </tr>
            	<tr>
              	<td class="_title"><a href="https://www.socialenginesolutions.com/social-engine/social-photo-media-importer-plugin/"  target="_blank">Social Photo Media Importer Plugin</a></td>
                <td><a href="admin/sesmediaimporter/settings/" class="_confbtn"><?php echo $this->translate("Configure")?></a></td>
              </tr>
            	<tr>
              	<td class="_title"><a href="https://www.socialenginesolutions.com/social-engine/js-css-minify-plugin/"  target="_blank">JS & CSS Minify Plugin</a></td>
                <td><a href="admin/sesminify/settings/" class="_confbtn"><?php echo $this->translate("Configure")?></a></td>
              </tr>
            	<tr>
              	<td class="_title"><a href="https://www.socialenginesolutions.com/social-engine/advanced-error-pages-plugin-private-page-page-not-found-maintenance-mode-coming-soon/"  target="_blank">Advanced Error Pages Plugin</a></td>
                <td><a href="admin/seserror/settings/" class="_confbtn"><?php echo $this->translate("Configure")?></a></td>
              </tr>
            	<tr>
              	<td class="_title"><a href="https://www.socialenginesolutions.com/social-engine/advanced-footer-plugin/"  target="_blank">Advanced Footer Plugin</a></td>
                <td><a href="admin/sesfooter/settings/" class="_confbtn"><?php echo $this->translate("Configure")?></a></td>
              </tr>
            	<tr>
              	<td class="_title"><a href="https://www.socialenginesolutions.com/social-engine/step-by-step-webpage-introduction-tour-plugin/"  target="_blank">Step by Step Webpage Tour</a></td>
                <td><a href="admin/sestour/settings/" class="_confbtn"><?php echo $this->translate("Configure")?></a></td>
              </tr>
            	<tr>
              	<td class="_title"><a href="https://www.socialenginesolutions.com/social-engine/multi-use-faqs-plugin/"  target="_blank">Multi-Use FAQs Plugin</a></td>
                <td><a href="admin/sesfaq/settings/" class="_confbtn"><?php echo $this->translate("Configure")?></a></td>
              </tr>
            	<tr>
              	<td class="_title"><a href="https://www.socialenginesolutions.com/social-engine/browser-push-notifications-plugin/"  target="_blank">Browser Push Notifications Plugin</a></td>
                <td><a href="admin/sesbrowserpush/settings/" class="_confbtn"><?php echo $this->translate("Configure")?></a></td>
              </tr>
            	<tr>
              	<td class="_title"><a href="https://www.socialenginesolutions.com/social-engine/all-in-one-multiple-forms-plugin-advanced-contact-us-feedback-query-forms-etc/"  target="_blank">All in One Multiple Forms Plugin</a></td>
                <td><a href="admin/sesmultipleform/settings/" class="_confbtn"><?php echo $this->translate("Configure")?></a></td>
              </tr>
            	<tr>
              	<td class="_title"><a href="https://www.socialenginesolutions.com/social-engine/members-verification-by-other-members-plugin/"  target="_blank">Members Verification by Other Members Plugin</a></td>
                <td><a href="admin/sesmemveroth/settings/" class="_confbtn"><?php echo $this->translate("Configure")?></a></td>
              </tr>
            	<tr>
              	<td class="_title"><a href="https://www.socialenginesolutions.com/social-engine/custom-short-member-profile-urls-plugin/"  target="_blank">Custom & Short Profile URLs Plugin</a></td>
                <td><a href="admin/sesmembershorturl/settings/" class="_confbtn"><?php echo $this->translate("Configure")?></a></td>
              </tr>
            	<tr>
              	<td class="_title"><a href="https://www.socialenginesolutions.com/social-engine/letter-avatar-of-member-name-plugin/"  target="_blank">Letter Avatar of Member Name Plugin</a></td>
                <td><a href="admin/sesletteravatar/settings/" class="_confbtn"><?php echo $this->translate("Configure")?></a></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<style type="text/css">
.sespkg_plugin_list{
	border-width:1px;
	margin-top:15px;
	width:60%;
}
.sespkg_plugin_list table{
	width:100%;
}
.sespkg_plugin_list table td{
	vertical-align:middle !important;
}
.sespkg_plugin_list table td._title a{
	font-weight:bold;
}
.sespkg_plugin_list table td + td{
	text-align:right;
}
.sespkg_plugin_list table ._confbtn{
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
	border-radius: 3px;
	padding: .5em 1em;
	font-weight: bold;
	border: none;
	background-color: #45ab0e;
	border: 1px solid #36880a;
	color: #fff;
	display: inline-block;
}
.sespkg_plugin_list table ._confbtn:hover{
	text-decoration:none;
	background-color:#3f9a0e;
}
</style>
