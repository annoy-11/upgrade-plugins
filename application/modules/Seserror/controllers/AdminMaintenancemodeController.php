<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seserror
 * @package    Seserror
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminMaintenancemodeController.php 2017-05-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seserror_AdminMaintenancemodeController extends Core_Controller_Action_Admin {


  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();
    
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('seserror_admin_main', array(), 'seserror_admin_main_maintenancemode');

    $this->view->form = $form = new Seserror_Form_Admin_Maintenancemode_Add();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();
      $maintenancemodeID = Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.maintenancemodeID', 0);
      if(empty($values['seserror_maintenanceenable'])) {
        $finalHTML = $this->finalHTML(9, $maintenancemodeID);
        $global_settings_file = APPLICATION_PATH . '/application/maintenance.html';
        if( file_exists($global_settings_file) ) {
          $generalConfig = include $global_settings_file;
        } else {
          $generalConfig = array();
        }
        if((is_file($global_settings_file) && is_writable($global_settings_file)) ||         (is_dir(dirname($global_settings_file)) && is_writable(dirname($global_settings_file)))) {
          file_put_contents($global_settings_file, $finalHTML);
        }
      } else {
        $maintenancemodeactivate = Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.maintenancemodeactivate', 1);
        $finalHTML = $this->finalHTML($maintenancemodeactivate, $maintenancemodeID, $values);
        $global_settings_file = APPLICATION_PATH . '/application/maintenance.html';
        if( file_exists($global_settings_file) ) {
          $generalConfig = include $global_settings_file;
        } else {
          $generalConfig = array();
        }
        if((is_file($global_settings_file) && is_writable($global_settings_file)) ||         (is_dir(dirname($global_settings_file)) && is_writable(dirname($global_settings_file)))) {
          file_put_contents($global_settings_file, $finalHTML);
        }
      }
      
      foreach ($values as $key => $value) {
        Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
      }
      $form->addNotice('Your changes have been saved.');
    }
  }


  public function designsAction() {

    $db = Engine_Db_Table::getDefaultAdapter();
    
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seserror_admin_main', array(), 'seserror_admin_main_maintenancemode');

    $this->view->form = $form = new Seserror_Form_Admin_Maintenancemode_Design();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();
      
      if (empty($values['seserror_maintenancemodeID']))
        unset($values['seserror_maintenancemodeID']);
        
      if (isset($_FILES['seserror_maintenancemodeID'])) {
        $photoFileIcon = Engine_Api::_()->seserror()->setPhoto($form->seserror_maintenancemodeID);

        if (!empty($photoFileIcon->file_id)) {
          $values['seserror_maintenancemodeID'] = $photoFileIcon->file_id;
        }
      }
      if($values['remove_image'] == 1) {
        $values['seserror_maintenancemodeID'] = 0;
      }
      
      
      foreach ($values as $key => $value) {
        //if($value != '')
        Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
      }
      
      $maintenancemodeID = Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.maintenancemodeID', 0);
      
      //Write code of activate template
      if($values['seserror_maintenancemodeactivate']) {
      
        $finalHTML = $this->finalHTML($values['seserror_maintenancemodeactivate'], $maintenancemodeID);
        
        $global_settings_file = APPLICATION_PATH . '/application/maintenance.html';
        
        if( file_exists($global_settings_file) ) {
          $generalConfig = include $global_settings_file;
        } else {
          $generalConfig = array();
        }
        
        if((is_file($global_settings_file) && is_writable($global_settings_file)) ||         (is_dir(dirname($global_settings_file)) && is_writable(dirname($global_settings_file)))) {
          file_put_contents($global_settings_file, $finalHTML);
        }
      }
      $form->addNotice('Your changes have been saved.');
    }
  }

  public function finalHTML($error_id, $maintenancemodeID, $values = array()) {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    if($values) { 
      $text1 = $values['seserror_maintenancetext1'];
      $text2 = $values['seserror_maintenancetext2'];
      $text3 = $values['seserror_maintenancetext3'];
    } else {
      $text1 = $settings->getSetting('seserror.maintenancetext1', "Maintenance Mode");
      $text2 = $settings->getSetting('seserror.maintenancetext2', "This site is under construction, may be you see it soon");
      $text3 = $settings->getSetting('seserror.maintenancetext3', "We apologize for the inconvenience, we''re doing our best to get things back to working order for you");
    }
    $maintenanceenablesocial = Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.maintenanceenablesocial', 1);
    
    $facebook = Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.facebook', '');
    $facebook = (preg_match("#https?://#", $facebook) === 0) ? 'http://'.$facebook : $facebook;
    $googleplus = Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.googleplus','');
    $googleplus = (preg_match("#https?://#", $googleplus) === 0) ? 'http://'.$googleplus : $googleplus;
    $twitter = Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.twitter', '');
    $twitter = (preg_match("#https?://#", $twitter) === 0) ? 'http://'.$twitter : $twitter;
    $youtube = Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.youtube', '');
    $youtube = (preg_match("#https?://#", $youtube) === 0) ? 'http://'.$youtube : $youtube;
    $linkedin = Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.linkedin', '');
    $linkedin = (preg_match("#https?://#", $linkedin) === 0) ? 'http://'.$linkedin : $linkedin;
    
    if($maintenancemodeID) {
      $photo = Engine_Api::_()->storage()->get($maintenancemodeID, '');
      if($photo)
        $photo = $photo->getPhotoUrl();
    }
    
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    
    
    if($error_id == 1) {
      $finalHTML = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
        <html>
          <head>
          <title></title>
          <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
          <link href="'.$view->baseUrl().'/application/modules/Seserror/externals/styles/maintenance.css" type="text/css" rel="stylesheet">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
          <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
          </head>
          <body>
            <div class="maintenance_mode_main_container">
              <div class="maintenance_mode_one_container">
                <div class="container_row">';
                  if($text1) {
                    $finalHTML .= '<div class="main_tittle">
                      <h2>'.$text1.'</h2>
                    </div>';
                  }
                  if($text2) {
                    $finalHTML .= '<div class="small_tittle">
                      <p>'.$text2.'</p>
                    </div>';
                  }
                  
                  if($photo) {
                    $finalHTML .= '<div class="maintenance_icon"><img src="'.$photo.'"></div>';
                  } else {
                    $finalHTML .= '<div class="maintenance_icon">
                        <img src="application/modules/Seserror/externals/images/maintenance/design_1_icon.png">
                      </div>';
                  }

                  $finalHTML .= '<div class="footer_section">
                  <form id="code" method="get">
                  <span>
                    Access Code:
                  </span>
                    <input type="password" class="codebox" name="en4_maint_code" value="">
                    <input type="submit" class="submit" value="Log In">
                  </form>';
									
									if($text3) {
                    $finalHTML .= '<div class="discrtiption">
                    <p>'.$text3.'</p>
                    </div>';
                  }
                  if($maintenanceenablesocial) {
                    if($facebook || $googleplus || $twitter || $youtube || $linkedin) {
                    $finalHTML .= '
                      <div class="social_icons">
                        <ul>';
                        if($facebook) {
                          $finalHTML .= '<li><a target="_blank" target="_blank" href='.$facebook.'><i class="fa fa-facebook"></i></a></li>';
                        }
                        if($googleplus) {
                          $finalHTML .= '<li><a target="_blank" target="_blank" href='.$googleplus.'><i class="fa fa-google-plus"></i></a></li>';
                        }
                        if($twitter) {
                          $finalHTML .= '<li><a target="_blank" target="_blank" href='.$twitter.'><i class="fa fa-twitter"></i></a></li>';
                        }
                        if($youtube) {
                          $finalHTML .= '<li><a target="_blank" target="_blank" href='.$youtube.'><i class="fa fa-youtube"></i></a></li>';
                        }
                        if($linkedin) {
                          $finalHTML .= '<li><a target="_blank" target="_blank" href='.$linkedin.'><i class="fa fa-linkedin"></i></a></li>';
                        }
                        $finalHTML .= '</ul>
                      </div>';
                    }  
                  }
                $finalHTML .= '</div>
								</div>
              </div>
            </div>
          </body>
        </html>';
    } elseif($error_id == '2') {
    
        $finalHTML = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
        <html>
          <head>
          <title></title>
          <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
          <link href="'.$view->baseUrl().'/application/modules/Seserror/externals/styles/maintenance.css" type="text/css" rel="stylesheet">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
          <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
          </head>
          <body>
            <div class="maintenance_mode_main_container">
              <div class="maintenance_mode_two_container">
                <div class="container_row">
                  <div class="middle_section">';
                    if($text1) {
                      $finalHTML .= '<div class="main_tittle">
                        <h2>'.$text1.'</h2>
                      </div>';
                    }
                    if($text2) {
                      $finalHTML .= '<div class="small_tittle">
                        <p>'.$text2.'</p>
                      </div>';
                    }
                    if($text3) {
                      $finalHTML .= '<div class="discrtiption">
                        <p>'.$text3.'</p>
                      </div>';
                    }
                  $finalHTML .= '<form id="code" method="get">
                      <span>
                        Access Code:
                      </span>
                        <input type="password" class="codebox" name="en4_maint_code" value="">
                        <input type="submit" class="submit" value="Log In">
                      </form></div>';
                      if($maintenanceenablesocial) {
                  if($facebook || $googleplus || $twitter || $youtube || $linkedin) {
                  $finalHTML .= '<div class="footer_section">
                    <div class="social_icons">
                      <ul>';
                      if($facebook) {
                        $finalHTML .= '<li><a target="_blank" href='.$facebook.'><i class="fa fa-facebook"></i></a></li>';
                      }
                      if($googleplus) {
                        $finalHTML .= '<li><a target="_blank" href='.$googleplus.'><i class="fa fa-google-plus"></i></a></li>';
                      }
                      if($twitter) {
                        $finalHTML .= '<li><a target="_blank" href='.$twitter.'><i class="fa fa-twitter"></i></a></li>';
                      }
                      if($youtube) {
                        $finalHTML .= '<li><a target="_blank" href='.$youtube.'><i class="fa fa-youtube"></i></a></li>';
                      }
                      if($linkedin) {
                        $finalHTML .= '<li><a target="_blank" href='.$linkedin.'><i class="fa fa-linkedin"></i></a></li>';
                      }
                      $finalHTML .= '</ul>
                    </div>
                  </div>';
                  }
                  }
                $finalHTML .= '</div>
              </div>
            </div>
          </body>
        </html>';
    } elseif($error_id == '3') {
    
      $finalHTML .= '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
        <html>
          <head>
          <title></title>
          <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
          <link href="'.$view->baseUrl().'/application/modules/Seserror/externals/styles/maintenance.css" type="text/css" rel="stylesheet">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
          <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
          </head>
          <body>
            <div class="maintenance_mode_main_container">
              <div class="maintenance_mode_three_container">
                <div class="container_row">
                  <div class="middle_section">';
									if($photo) {
                    $finalHTML .= '<div class="maintenance_icon"><img src="'.$photo.'"></div>';
                  } else {
                    $finalHTML .= '<div class="maintenance_icon">
                        <img src="application/modules/Seserror/externals/images/maintenance/design_3_icon.png">
                      </div>';
                  }
                    if($text1) {
                      $finalHTML .= '<div class="main_tittle">
                        <h2>'.$text1.'</h2>
                      </div>';
                    }
                    $finalHTML .= '<form id="code" method="get">
						<span>
							Access Code:
						</span>
						<input type="password" class="codebox" name="en4_maint_code" value="">
						<input type="submit" class="submit" value="Log In">
					</form>';
                    if($text2) {
                      $finalHTML .= '<div class="small_tittle">
                        <p>'.$text2.'</p>
                      </div>';
                    }
                    if($text3) {
                      $finalHTML .= '<div class="discrtiption">
                        <p>'.$text3.'</p>
                      </div>';
					  
                    }
                  $finalHTML .= '</div>';
                  if($maintenanceenablesocial) {
                    if($facebook || $googleplus || $twitter || $youtube || $linkedin) {
                    $finalHTML .= '<div class="footer_section">
                      <div class="social_icons">
                        <ul>';
                        if($facebook) {
                          $finalHTML .= '<li><a target="_blank" href='.$facebook.'><i class="fa fa-facebook"></i></a></li>';
                        }
                        if($googleplus) {
                          $finalHTML .= '<li><a target="_blank" href='.$googleplus.'><i class="fa fa-google-plus"></i></a></li>';
                        }
                        if($twitter) {
                          $finalHTML .= '<li><a target="_blank" href='.$twitter.'><i class="fa fa-twitter"></i></a></li>';
                        }
                        if($youtube) {
                          $finalHTML .= '<li><a target="_blank" href='.$youtube.'><i class="fa fa-youtube"></i></a></li>';
                        }
                        if($linkedin) {
                          $finalHTML .= '<li><a target="_blank" href='.$linkedin.'><i class="fa fa-linkedin"></i></a></li>';
                        }
                        $finalHTML .= '</ul>
                      </div>
                    </div>';
                    }
                  }
                $finalHTML .= '</div>
              </div>
            </div>
          </body>
        </html>';

    } elseif($error_id == '4') {
        $finalHTML .= '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
        <html>
          <head>
          <title></title>
          <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
          <link href="'.$view->baseUrl().'/application/modules/Seserror/externals/styles/maintenance.css" type="text/css" rel="stylesheet">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
          <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
          </head>
          <body>
            <div class="maintenance_mode_main_container">
              <div class="maintenance_mode_four_container">
                <div class="container_row">
                  <div class="middle_section">';
                  if($text1) {
                    $finalHTML .= '<div class="main_tittle">
                      <h2>'.$text1.'</h2>
                    </div>';
                  }
                  if($text2) {
                    $finalHTML .= '<div class="small_tittle">
                      <p>'.$text2.'</p>
                    </div>';
                  }
									if($photo) {
                    $finalHTML .= '<div class="maintenance_icon_2"><img src="'.$photo.'"></div>';
                  } else {
                    $finalHTML .= '<div class="maintenance_icon_2">
                        <img src="application/modules/Seserror/externals/images/maintenance/design_4_icon2.png">
                      </div>';
                  }
                  if($text3) {
                    $finalHTML .= '<div class="discrtiption">
                      <p>'.$text3.'</p>
                    </div>';
                  }
                  $finalHTML .= '<form id="code" method="get">
					<span>
						Access Code:
					</span>
						<input type="password" class="codebox" name="en4_maint_code" value="">
						<input type="submit" class="submit" value="Log In">
					</form></div>';
                  if($maintenanceenablesocial) {
                    if($facebook || $googleplus || $twitter || $youtube || $linkedin) {
                    $finalHTML .= '<div class="footer_section">
                      <div class="social_icons">
                        <ul>';
                        if($facebook) {
                          $finalHTML .= '<li><a target="_blank" href='.$facebook.'><i class="fa fa-facebook"></i></a></li>';
                        }
                        if($googleplus) {
                          $finalHTML .= '<li><a target="_blank" href='.$googleplus.'><i class="fa fa-google-plus"></i></a></li>';
                        }
                        if($twitter) {
                          $finalHTML .= '<li><a target="_blank" href='.$twitter.'><i class="fa fa-twitter"></i></a></li>';
                        }
                        if($youtube) {
                          $finalHTML .= '<li><a target="_blank" href='.$youtube.'><i class="fa fa-youtube"></i></a></li>';
                        }
                        if($linkedin) {
                          $finalHTML .= '<li><a target="_blank" href='.$linkedin.'><i class="fa fa-linkedin"></i></a></li>';
                        }
                        $finalHTML .= '</ul>
                      </div>
                    </div>';
                    }
                  }
                $finalHTML .= '</div>
              </div>
            </div>
          </body>
        </html>';

    } elseif($error_id == '5') {
        $finalHTML .= '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
        <html>
          <head>
          <title></title>
          <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
          <link href="'.$view->baseUrl().'/application/modules/Seserror/externals/styles/maintenance.css" type="text/css" rel="stylesheet">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
          <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
          </head>
          <body>
            <div class="maintenance_mode_main_container">
              <div class="maintenance_mode_five_container">
                <div class="container_row">
                  <div class="middle_section">';
                    if($text1) {
                      $finalHTML .= '<div class="main_tittle">
                        <h2>'.$text1.'</h2>
                      </div>';
                    }
                    if($text2) {
                      $finalHTML .= '<div class="small_tittle">
                        <p>'.$text2.'</p>
                      </div>';
                    }
                    if($text3) {
                      $finalHTML .= '<div class="discrtiption">
                        <p>'.$text3.'</p>
                      </div>';
                    }
                    $finalHTML .= '<form id="code" method="get">
					<span>
						Access Code:
					</span>
						<input type="password" class="codebox" name="en4_maint_code" value="">
						<input type="submit" class="submit" value="Log In">
					</form><div class="maintenance_icon">
                      <img src="application/modules/Seserror/externals/images/maintenance/design_5_icon.png">
                    </div>
                  </div>';
                  if($maintenanceenablesocial) {
                    if($facebook || $googleplus || $twitter || $youtube || $linkedin) {
                    $finalHTML .= '<div class="footer_section">
                      <div class="social_icons">
                        <ul>';
                        if($facebook) {
                          $finalHTML .= '<li><a target="_blank" target="_blank" href='.$facebook.'><i class="fa fa-facebook"></i></a></li>';
                        }
                        if($googleplus) {
                          $finalHTML .= '<li><a target="_blank" href='.$googleplus.'><i class="fa fa-google-plus"></i></a></li>';
                        }
                        if($twitter) {
                          $finalHTML .= '<li><a target="_blank" href='.$twitter.'><i class="fa fa-twitter"></i></a></li>';
                        }
                        if($youtube) {
                          $finalHTML .= '<li><a target="_blank" href='.$youtube.'><i class="fa fa-youtube"></i></a></li>';
                        }
                        if($linkedin) {
                          $finalHTML .= '<li><a target="_blank" href='.$linkedin.'><i class="fa fa-linkedin"></i></a></li>';
                        }
                        $finalHTML .= '</ul>
                      </div>
                    </div>';
                    }
                  }
                $finalHTML .= '</div>
              </div>
            </div>
          </body>
        </html>';
    } elseif($error_id == '6') {
        $finalHTML .= '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
        <html>
          <head>
          <title></title>
          <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
          <link href="'.$view->baseUrl().'/application/modules/Seserror/externals/styles/maintenance.css" type="text/css" rel="stylesheet">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
          <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
          </head>
          <body>
            <div class="maintenance_mode_main_container">
              <div class="maintenance_mode_six_container">
                <div class="container_row">
                  <div class="middle_section">';
                    if($text1) {
                      $finalHTML .= '<div class="main_tittle">
                        <h2>'.$text1.'</h2>
                      </div>';
                    }
                    if($text2) {
                      $finalHTML .= '<div class="small_tittle">
                        <p>'.$text2.'</p>
                      </div>';
                    }
                    if($text3) {
                      $finalHTML .= '<div class="discrtiption">
                        <p>'.$text3.'</p>
                      </div>';
                    }
                    $finalHTML .= '<form id="code" method="get">
					<span>
						Access Code:
					</span>
						<input type="password" class="codebox" name="en4_maint_code" value="">
						<input type="submit" class="submit" value="Log In">
					</form><div class="maintenance_icon">
                      <img src="application/modules/Seserror/externals/images/maintenance/design_6_icon.png">
                    </div>
                  </div>';
                  if($maintenanceenablesocial) {
                    if($facebook || $googleplus || $twitter || $youtube || $linkedin) {
                    $finalHTML .= '<div class="footer_section">
                      <div class="social_icons">
                        <ul>';
                        if($facebook) {
                          $finalHTML .= '<li><a target="_blank" target="_blank" href='.$facebook.'><i class="fa fa-facebook"></i></a></li>';
                        }
                        if($googleplus) {
                          $finalHTML .= '<li><a target="_blank" href='.$googleplus.'><i class="fa fa-google-plus"></i></a></li>';
                        }
                        if($twitter) {
                          $finalHTML .= '<li><a target="_blank" href='.$twitter.'><i class="fa fa-twitter"></i></a></li>';
                        }
                        if($youtube) {
                          $finalHTML .= '<li><a target="_blank" href='.$youtube.'><i class="fa fa-youtube"></i></a></li>';
                        }
                        if($linkedin) {
                          $finalHTML .= '<li><a target="_blank" href='.$linkedin.'><i class="fa fa-linkedin"></i></a></li>';
                        }
                        $finalHTML .= '</ul>
                      </div>
                    </div>';
                    }
                  }
                $finalHTML .= '</div>
								<div class="footer_bottom_section">
									
								</div>
              </div>
            </div>
          </body>
        </html>';
    } elseif($error_id == '7') {
        $finalHTML .= '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
        <html>
          <head>
          <title></title>
          <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
          <link href="'.$view->baseUrl().'/application/modules/Seserror/externals/styles/maintenance.css" type="text/css" rel="stylesheet">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
          <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
          </head>
          <body>
            <div class="maintenance_mode_main_container">
              <div class="maintenance_mode_seven_container">
                <div class="container_row">
                  <div class="middle_section">';
                    if($text1) {
                      $finalHTML .= '<div class="main_tittle">
                        <h2>'.$text1.'</h2>
                      </div>';
                    }
                    if($text2) {
                      $finalHTML .= '<div class="small_tittle">
                        <p>'.$text2.'</p>
                      </div>';
                    }
                    if($text3) {
                      $finalHTML .= '<div class="discrtiption">
                        <p>'.$text3.'</p>
                      </div>';
                    }
                    $finalHTML .= '<form id="code" method="get">
					<span>
						Access Code:
					</span>
						<input type="password" class="codebox" name="en4_maint_code" value="">
						<input type="submit" class="submit" value="Log In">
					</form>
                  </div>';
                  if($maintenanceenablesocial) {
                    if($facebook || $googleplus || $twitter || $youtube || $linkedin) {
                    $finalHTML .= '<div class="footer_section">
                      <div class="social_icons">
                        <ul>';
                        if($facebook) {
                          $finalHTML .= '<li><a target="_blank" target="_blank" href='.$facebook.'><i class="fa fa-facebook"></i></a></li>';
                        }
                        if($googleplus) {
                          $finalHTML .= '<li><a target="_blank" href='.$googleplus.'><i class="fa fa-google-plus"></i></a></li>';
                        }
                        if($twitter) {
                          $finalHTML .= '<li><a target="_blank" href='.$twitter.'><i class="fa fa-twitter"></i></a></li>';
                        }
                        if($youtube) {
                          $finalHTML .= '<li><a target="_blank" href='.$youtube.'><i class="fa fa-youtube"></i></a></li>';
                        }
                        if($linkedin) {
                          $finalHTML .= '<li><a target="_blank" href='.$linkedin.'><i class="fa fa-linkedin"></i></a></li>';
                        }
                        $finalHTML .= '</ul>
                      </div>
                    </div>';
                    }
                  }
                $finalHTML .= '</div>
              </div>
            </div>
          </body>
        </html>';
    } elseif($error_id == '8') {
        $finalHTML .= '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
        <html>
          <head>
          <title></title>
          <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
          <link href="'.$view->baseUrl().'/application/modules/Seserror/externals/styles/maintenance.css" type="text/css" rel="stylesheet">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
          <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
          </head>
          <body>
            <div class="maintenance_mode_main_container">
              <div class="maintenance_mode_eight_container">
							<div class="contant_bg_img"></div>
                <div class="container_row">
                  <div class="middle_section">';
                    if($text1) {
                      $finalHTML .= '<div class="main_tittle">
                        <h2>'.$text1.'</h2>
                      </div>';
                    }
                    if($text2) {
                      $finalHTML .= '<div class="small_tittle">
                        <p>'.$text2.'</p>
                      </div>';
                    }
                    if($text3) {
                      $finalHTML .= '<div class="discrtiption">
                        <p>'.$text3.'</p>
                      </div>';
                    }
									if($photo) {
                    $finalHTML .= '<div class="maintenance_icon"><img src="'.$photo.'"></div>';
                  } else {
                    $finalHTML .= '<div class="maintenance_icon">
                        <img src="application/modules/Seserror/externals/images/maintenance/design_8_icon5.png">
                      </div>';
                  }		
                    $finalHTML .= '<form id="code" method="get">
										<span>
											Access Code:
										</span>
										<input type="password" class="codebox" name="en4_maint_code" value="">
										<input type="submit" class="submit" value="Log In">
									</form>
								
						 
                  </div>';
                  if($maintenanceenablesocial) {
                    if($facebook || $googleplus || $twitter || $youtube || $linkedin) {
                    $finalHTML .= '<div class="footer_section">
                      <div class="social_icons">
                        <ul>';
                        if($facebook) {
                          $finalHTML .= '<li><a target="_blank" target="_blank" href='.$facebook.'><i class="fa fa-facebook"></i></a></li>';
                        }
                        if($googleplus) {
                          $finalHTML .= '<li><a target="_blank" href='.$googleplus.'><i class="fa fa-google-plus"></i></a></li>';
                        }
                        if($twitter) {
                          $finalHTML .= '<li><a target="_blank" href='.$twitter.'><i class="fa fa-twitter"></i></a></li>';
                        }
                        if($youtube) {
                          $finalHTML .= '<li><a target="_blank" href='.$youtube.'><i class="fa fa-youtube"></i></a></li>';
                        }
                        if($linkedin) {
                          $finalHTML .= '<li><a target="_blank" href='.$linkedin.'><i class="fa fa-linkedin"></i></a></li>';
                        }
                        $finalHTML .= '</ul>
                      </div>
                    </div>';
                    }
                  }
                $finalHTML .= '</div>
              </div>
            </div>
          </body>
        </html>';
    }
		elseif($error_id == '10') {
        $finalHTML .= '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
        <html>
          <head>
          <title></title>
          <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
          <link href="'.$view->baseUrl().'/application/modules/Seserror/externals/styles/maintenance.css" type="text/css" rel="stylesheet">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
          <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,700" rel="stylesheet">
          </head>
          <body>
            <div class="maintenance_mode_main_container">
              <div class="maintenance_mode_nine_container">
                <div class="container_row">
                  <div class="middle_section">';
                    if($text1) {
                      $finalHTML .= '<div class="main_tittle">
                        <h2>'.$text1.'</h2>
                      </div>';
                    }
                    if($text2) {
                      $finalHTML .= '<div class="small_tittle">
                        <p>'.$text2.'</p>
                      </div>';
                    }
                    
									if($photo) {
                    $finalHTML .= '<div class="maintenance_icon"><img src="'.$photo.'"></div>';
                  } else {
                    $finalHTML .= '<div class="maintenance_icon">
                        <img src="application/modules/Seserror/externals/images/maintenance/design_9_icon1.png">
                      </div>';
                  }		
									if($text3) {
                      $finalHTML .= '<div class="discrtiption">
                        <p>'.$text3.'</p>
                      </div>';
                    }
                    $finalHTML .= '<form id="code" method="get">
										<span>
											Access Code:
										</span>
										<input type="password" class="codebox" name="en4_maint_code" value="">
										<input type="submit" class="submit" value="Log In">
									</form>
								
						 
                  </div>';
                  if($maintenanceenablesocial) {
                    if($facebook || $googleplus || $twitter || $youtube || $linkedin) {
                    $finalHTML .= '<div class="footer_section">
                      <div class="social_icons">
                        <ul>';
                        if($facebook) {
                          $finalHTML .= '<li><a target="_blank" target="_blank" href='.$facebook.'><i class="fa fa-facebook"></i></a></li>';
                        }
                        if($googleplus) {
                          $finalHTML .= '<li><a target="_blank" href='.$googleplus.'><i class="fa fa-google-plus"></i></a></li>';
                        }
                        if($twitter) {
                          $finalHTML .= '<li><a target="_blank" href='.$twitter.'><i class="fa fa-twitter"></i></a></li>';
                        }
                        if($youtube) {
                          $finalHTML .= '<li><a target="_blank" href='.$youtube.'><i class="fa fa-youtube"></i></a></li>';
                        }
                        if($linkedin) {
                          $finalHTML .= '<li><a target="_blank" href='.$linkedin.'><i class="fa fa-linkedin"></i></a></li>';
                        }
                        $finalHTML .= '</ul>
                      </div>
                    </div>';
                    }
                  }
                $finalHTML .= '</div>
              </div>
            </div>
          </body>
        </html>';
    } 
		elseif($error_id == '11') {
        $finalHTML .= '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
        <html>
          <head>
          <title></title>
          <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
          <link href="'.$view->baseUrl().'/application/modules/Seserror/externals/styles/maintenance.css" type="text/css" rel="stylesheet">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
          <link href="https://fonts.googleapis.com/css?family=Raleway:300i,400,600,700" rel="stylesheet">
          </head>
          <body>
            <div class="maintenance_mode_main_container">
              <div class="maintenance_mode_ten_container">
                <div class="container_row">
								<div class="left_section">';
                    
                    
									if($photo) {
                    $finalHTML .= '<div class="maintenance_icon"><img src="'.$photo.'"></div>';
                  } else {
                    $finalHTML .= '<div class="maintenance_icon">
                        <img src="application/modules/Seserror/externals/images/maintenance/design_10_icon1.png">
                      </div>';
                  }		
									
                    $finalHTML .= '</div>
                  <div class="right_section">';
                    if($text1) {
                      $finalHTML .= '<div class="main_tittle">
                        <h2>'.$text1.'</h2>
                      </div>';
                    }
                    if($text2) {
                      $finalHTML .= '<div class="small_tittle">
                        <p>'.$text2.'</p>
                      </div>';
                    }
									if($text3) {
                      $finalHTML .= '<div class="discrtiption">
                        <p>'.$text3.'</p>
                      </div>';
                    }
                    $finalHTML .= '<form id="code" method="get">
										<span>
											Access Code:
										</span>
										<input type="password" class="codebox" name="en4_maint_code" value="">
										<input type="submit" class="submit" value="Log In">
									</form>
								
						 
                  </div>';
                  if($maintenanceenablesocial) {
                    if($facebook || $googleplus || $twitter || $youtube || $linkedin) {
                    $finalHTML .= '<div class="footer_section">
                      <div class="social_icons">
                        <ul>';
                        if($facebook) {
                          $finalHTML .= '<li><a target="_blank" target="_blank" href='.$facebook.'><i class="fa fa-facebook"></i></a></li>';
                        }
                        if($googleplus) {
                          $finalHTML .= '<li><a target="_blank" href='.$googleplus.'><i class="fa fa-google-plus"></i></a></li>';
                        }
                        if($twitter) {
                          $finalHTML .= '<li><a target="_blank" href='.$twitter.'><i class="fa fa-twitter"></i></a></li>';
                        }
                        if($youtube) {
                          $finalHTML .= '<li><a target="_blank" href='.$youtube.'><i class="fa fa-youtube"></i></a></li>';
                        }
                        if($linkedin) {
                          $finalHTML .= '<li><a target="_blank" href='.$linkedin.'><i class="fa fa-linkedin"></i></a></li>';
                        }
                        $finalHTML .= '</ul>
                      </div>
                    </div>';
                    }
                  }
                $finalHTML .= '</div>
              </div>
            </div>
          </body>
        </html>';
    }
			elseif($error_id == '12') {
        $finalHTML .= '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
        <html>
          <head>
          <title></title>
          <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
          <link href="'.$view->baseUrl().'/application/modules/Seserror/externals/styles/maintenance.css" type="text/css" rel="stylesheet">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
         <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,700" rel="stylesheet">
          </head>
          <body>
            <div class="maintenance_mode_main_container">
              <div class="maintenance_mode_eleven_container">
                <div class="container_row">
								<div class="left_section">';
                    
                    
									if($photo) {
                    $finalHTML .= '<div class="maintenance_icon"><img src="'.$photo.'"></div>';
                  } else {
                    $finalHTML .= '<div class="maintenance_icon">
                        <img src="application/modules/Seserror/externals/images/maintenance/design_11_icon1.png">
                      </div>';
                  }		
									
                    $finalHTML .= '</div>
                  <div class="right_section">';
                    if($text1) {
                      $finalHTML .= '<div class="main_tittle">
                        <h2>'.$text1.'</h2>
                      </div>';
                    }
                    if($text2) {
                      $finalHTML .= '<div class="small_tittle">
                        <p>'.$text2.'</p>
                      </div>';
                    }
									if($text3) {
                      $finalHTML .= '<div class="discrtiption">
                        <p>'.$text3.'</p>
                      </div>';
                    }
                    $finalHTML .= '<form id="code" method="get">
										<span>
											Access Code:
										</span>
										<input type="password" class="codebox" name="en4_maint_code" value="">
										<input type="submit" class="submit" value="Log In">
									</form>
								
						 
                  </div>';
                  if($maintenanceenablesocial) {
                    if($facebook || $googleplus || $twitter || $youtube || $linkedin) {
                    $finalHTML .= '<div class="footer_section">
                      <div class="social_icons">
                        <ul>';
                        if($facebook) {
                          $finalHTML .= '<li><a target="_blank" target="_blank" href='.$facebook.'><i class="fa fa-facebook"></i></a></li>';
                        }
                        if($googleplus) {
                          $finalHTML .= '<li><a target="_blank" href='.$googleplus.'><i class="fa fa-google-plus"></i></a></li>';
                        }
                        if($twitter) {
                          $finalHTML .= '<li><a target="_blank" href='.$twitter.'><i class="fa fa-twitter"></i></a></li>';
                        }
                        if($youtube) {
                          $finalHTML .= '<li><a target="_blank" href='.$youtube.'><i class="fa fa-youtube"></i></a></li>';
                        }
                        if($linkedin) {
                          $finalHTML .= '<li><a target="_blank" href='.$linkedin.'><i class="fa fa-linkedin"></i></a></li>';
                        }
                        $finalHTML .= '</ul>
                      </div>
                    </div>';
                    }
                  }
                $finalHTML .= '</div>
              </div>
            </div>
          </body>
        </html>';
    }
		elseif($error_id == '13') {
        $finalHTML .= '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
        <html>
          <head>
          <title></title>
          <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
          <link href="'.$view->baseUrl().'/application/modules/Seserror/externals/styles/maintenance.css" type="text/css" rel="stylesheet">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
          <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700" rel="stylesheet">
          </head>
          <body>
            <div class="maintenance_mode_main_container">
              <div class="maintenance_mode_twelve_container">
                <div class="container_row">
								<div class="left_section">';
                    
                    
									if($photo) {
                    $finalHTML .= '<div class="maintenance_icon"><img src="'.$photo.'"></div>';
                  } else {
                    $finalHTML .= '<div class="maintenance_icon">
                        <img src="application/modules/Seserror/externals/images/maintenance/design_12_icon1.png">
                      </div>';
                  }		
									
                    $finalHTML .= '</div>
                  <div class="right_section">';
                    if($text1) {
                      $finalHTML .= '<div class="main_tittle">
                        <h2>'.$text1.'</h2>
                      </div>';
                    }
                    if($text2) {
                      $finalHTML .= '<div class="small_tittle">
                        <p>'.$text2.'</p>
                      </div>';
                    }
									if($text3) {
                      $finalHTML .= '<div class="discrtiption">
                        <p>'.$text3.'</p>
                      </div>';
                    }
                    $finalHTML .= '<form id="code" method="get">
										<span>
											Access Code:
										</span>
										<input type="password" class="codebox" name="en4_maint_code" value="">
										<input type="submit" class="submit" value="Log In">
									</form>
								
						 
                  </div>';
                  if($maintenanceenablesocial) {
                    if($facebook || $googleplus || $twitter || $youtube || $linkedin) {
                    $finalHTML .= '<div class="footer_section">
                      <div class="social_icons">
                        <ul>';
                        if($facebook) {
                          $finalHTML .= '<li><a target="_blank" target="_blank" href='.$facebook.'><i class="fa fa-facebook"></i></a></li>';
                        }
                        if($googleplus) {
                          $finalHTML .= '<li><a target="_blank" href='.$googleplus.'><i class="fa fa-google-plus"></i></a></li>';
                        }
                        if($twitter) {
                          $finalHTML .= '<li><a target="_blank" href='.$twitter.'><i class="fa fa-twitter"></i></a></li>';
                        }
                        if($youtube) {
                          $finalHTML .= '<li><a target="_blank" href='.$youtube.'><i class="fa fa-youtube"></i></a></li>';
                        }
                        if($linkedin) {
                          $finalHTML .= '<li><a target="_blank" href='.$linkedin.'><i class="fa fa-linkedin"></i></a></li>';
                        }
                        $finalHTML .= '</ul>
                      </div>
                    </div>';
                    }
                  }
                $finalHTML .= '</div>
              </div>
            </div>
          </body>
        </html>';
    }
		elseif($error_id == '14') {
        $finalHTML .= '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
        <html>
          <head>
          <title></title>
          <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
          <link href="'.$view->baseUrl().'/application/modules/Seserror/externals/styles/maintenance.css" type="text/css" rel="stylesheet">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
          <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700" rel="stylesheet">
          </head>
          <body>
            <div class="maintenance_mode_main_container">
              <div class="maintenance_mode_thirteen_container">
                <div class="container_row">
								<div class="left_section">';
                    
                    
									if($photo) {
                    $finalHTML .= '<div class="maintenance_icon"><img src="'.$photo.'"></div>';
                  } else {
                    $finalHTML .= '<div class="maintenance_icon">
                        <img src="application/modules/Seserror/externals/images/maintenance/design_13_icon2.png">
                      </div>';
                  }		
									
                    $finalHTML .= '</div>
                  <div class="right_section">';
                    if($text1) {
                      $finalHTML .= '<div class="main_tittle">
                        <h2>'.$text1.'</h2>
                      </div>';
                    }
                    if($text2) {
                      $finalHTML .= '<div class="small_tittle">
                        <p>'.$text2.'</p>
                      </div>';
                    }
									if($text3) {
                      $finalHTML .= '<div class="discrtiption">
                        <p>'.$text3.'</p>
                      </div>';
                    }
                    $finalHTML .= '<form id="code" method="get">
										<span>
											Access Code:
										</span>
										<input type="password" class="codebox" name="en4_maint_code" value="">
										<input type="submit" class="submit" value="Log In">
									</form>
								
						 
                  </div>';
                  if($maintenanceenablesocial) {
                    if($facebook || $googleplus || $twitter || $youtube || $linkedin) {
                    $finalHTML .= '<div class="footer_section">
                      <div class="social_icons">
                        <ul>';
                        if($facebook) {
                          $finalHTML .= '<li><a target="_blank" target="_blank" href='.$facebook.'><i class="fa fa-facebook"></i></a></li>';
                        }
                        if($googleplus) {
                          $finalHTML .= '<li><a target="_blank" href='.$googleplus.'><i class="fa fa-google-plus"></i></a></li>';
                        }
                        if($twitter) {
                          $finalHTML .= '<li><a target="_blank" href='.$twitter.'><i class="fa fa-twitter"></i></a></li>';
                        }
                        if($youtube) {
                          $finalHTML .= '<li><a target="_blank" href='.$youtube.'><i class="fa fa-youtube"></i></a></li>';
                        }
                        if($linkedin) {
                          $finalHTML .= '<li><a target="_blank" href='.$linkedin.'><i class="fa fa-linkedin"></i></a></li>';
                        }
                        $finalHTML .= '</ul>
                      </div>
                    </div>';
                    }
                  }
                $finalHTML .= '</div>
              </div>
            </div>
          </body>
        </html>';
    }
		elseif($error_id == '15') {
        $finalHTML .= '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
        <html>
          <head>
          <title></title>
          <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
          <link href="'.$view->baseUrl().'/application/modules/Seserror/externals/styles/maintenance.css" type="text/css" rel="stylesheet">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
          <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700" rel="stylesheet">
          </head>
          <body>
            <div class="maintenance_mode_main_container">
              <div class="maintenance_mode_fourteen_container">
                <div class="container_row">
                  <div class="middle_section">';
                    if($text1) {
                      $finalHTML .= '<div class="main_tittle">
                        <h2>'.$text1.'</h2>
                      </div>';
                    }
                    if($text2) {
                      $finalHTML .= '<div class="small_tittle">
                        <p>'.$text2.'</p>
                      </div>';
                    }
                    
									if($photo) {
                    $finalHTML .= '<div class="maintenance_icon"><img src="'.$photo.'"></div>';
                  } else {
                    $finalHTML .= '<div class="maintenance_icon">
                        <img src="application/modules/Seserror/externals/images/maintenance/design_14_icon1.png">
                      </div>';
                  }		
									if($text3) {
                      $finalHTML .= '<div class="discrtiption">
                        <p>'.$text3.'</p>
                      </div>';
                    }
                    $finalHTML .= '<form id="code" method="get">
										<span>
											Access Code:
										</span>
										<input type="password" class="codebox" name="en4_maint_code" value="">
										<input type="submit" class="submit" value="Log In">
									</form>
								
						 
                  </div>';
                  if($maintenanceenablesocial) {
                    if($facebook || $googleplus || $twitter || $youtube || $linkedin) {
                    $finalHTML .= '<div class="footer_section">
                      <div class="social_icons">
                        <ul>';
                        if($facebook) {
                          $finalHTML .= '<li><a target="_blank" target="_blank" href='.$facebook.'><i class="fa fa-facebook"></i></a></li>';
                        }
                        if($googleplus) {
                          $finalHTML .= '<li><a target="_blank" href='.$googleplus.'><i class="fa fa-google-plus"></i></a></li>';
                        }
                        if($twitter) {
                          $finalHTML .= '<li><a target="_blank" href='.$twitter.'><i class="fa fa-twitter"></i></a></li>';
                        }
                        if($youtube) {
                          $finalHTML .= '<li><a target="_blank" href='.$youtube.'><i class="fa fa-youtube"></i></a></li>';
                        }
                        if($linkedin) {
                          $finalHTML .= '<li><a target="_blank" href='.$linkedin.'><i class="fa fa-linkedin"></i></a></li>';
                        }
                        $finalHTML .= '</ul>
                      </div>
                    </div>';
                    }
                  }
                $finalHTML .= '</div>
              </div>
            </div>
          </body>
        </html>';
    } 
		elseif($error_id == 9) {
    
      $finalHTML = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
        <html>
          <!-- $Id: maintenance.html 7539 2010-10-04 04:41:38Z john $ -->
          <head>
            <title></title>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <style type="text/css">
              *
              {
                font-family: tahoma, arial, sans-serif;
                margin: 0px;
                padding: 0px;
              }
              #content
              {
                width: 500px;
                margin: 250px auto 0px auto;
              }
              #message
              {
                display: block;
                font-size: 18pt;
                font-weight: bold;
                letter-spacing: -1px;
                text-align: center;
              }
              #message .caption
              {
                display: block;
                font-size: .8em;
              }
              #code
              {
                margin-top: 20px;
                padding: 20px;
                background: #fff9e2;
                border: 3px dashed #dad1b0;
                text-align: center;
                -moz-border-radius: 5px;
                -webkit-border-radius: 5px;
                border-radius: 5px;
              }
              #code > span
              {
                font-weight: bold;
                font-size: 1.1em;
                letter-spacing: -1px;
              }
              #code .codebox
              {
                padding: 3px;
              }
              #code .submit
              {
                padding: 5px;
                font-weight: bold;
                margin-left: 3px;
              }
              #code .submit:hover
              {
                cursor: pointer;
              }
            </style>
          </head>
          <body>
            <div id="content">';
              if($text1 || $text2) {
                $finalHTML .= '<span id="message">';
                if($text1) {
                  $finalHTML .= $text1;
                }
                if($text2) {
                  $finalHTML .= '<span class="caption">'.$text2.'</span>';
                }
                $finalHTML .= '</span>';
              }
              $finalHTML .= '<form id="code" method="get">
                <span>
                  Access Code:
                </span>
                <input type="password" class="codebox" name="en4_maint_code" value="">
                <input type="submit" class="submit" value="Log In">
              </form>
            </div>
          </body>
        </html>';
    }
		
    return $finalHTML;  
  }
}