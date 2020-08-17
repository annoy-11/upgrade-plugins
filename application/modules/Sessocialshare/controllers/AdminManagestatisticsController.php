<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialshare
 * @package    Sessocialshare
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManagestatisticsController.php 2017-07-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessocialshare_AdminManagestatisticsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    if (isset($_POST['params']) && $_POST['params'])
      parse_str($_POST['params'], $values);

    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', null);

    $pageurl1 = $this->_getParam('pageurl1', 0);

    $this->view->linksaves = $linksavesTable = Engine_Api::_()->getDbTable('linksaves', 'sessocialshare');

    if(empty($is_ajax)) {
      $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sessocialshare_admin_main', array(), 'sessocialshare_admin_main_managelinks');

      $select = $linksavesTable->select()->order('share_count DESC')->limit(10)->group('pageurl');

      $results = $linksavesTable->fetchAll($select);

      $admin_defaultURL = ((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $this->view->baseUrl() . '/members/home';

      $linksArray = array($admin_defaultURL => $admin_defaultURL);

      foreach($results as $result) {
        $linksArray[$result->pageurl] = $result->pageurl;
      }

      $this->view->filterForm = $filterForm = new Sessocialshare_Form_Admin_Statistics();
      $filterForm->pageurl->setMultiOptions($linksArray);
      $this->view->URL = $URL = $admin_defaultURL;

    } else {

      if(!empty($values['pageurl1'])) {
        $this->view->URL = $URL = $values['pageurl1'];

        $select = $linksavesTable->select()->where('pageurl =?', $URL);

        if($values['from_date'] && $values['to_date']) {
          $select->where("DATE(creation_date) between ('".$values['from_date']."') and ('".$values['to_date']."')");
        }
        //$select->group('title');

        $results = $linksavesTable->fetchAll($select);
        if(count($results) == 0)
          $this->view->pageurlcount = 0;

      } else {
        $this->view->URL = $URL = $values['pageurl'];
        $this->view->pageurlcount = 1;
      }

    }

    $this->view->facebook = $facebook =  $this->view->linksaves->socialShareCounter(array('pageurl' => $URL, 'title' => 'facebook', 'from_date' => @$values['from_date'], 'to_date' => @$values['to_date']));

    $this->view->twitter = $twitter =  $this->view->linksaves->socialShareCounter(array('pageurl' => $URL, 'title' => 'twitter', 'from_date' => @$values['from_date'], 'to_date' => @$values['to_date']));

    $this->view->pinterest = $pinterest =  $this->view->linksaves->socialShareCounter(array('pageurl' => $URL, 'title' => 'pinterest', 'from_date' => @$values['from_date'], 'to_date' => @$values['to_date']));

    $this->view->googleplus = $googleplus =  $this->view->linksaves->socialShareCounter(array('pageurl' => $URL, 'title' => 'googleplus', 'from_date' => @$values['from_date'], 'to_date' => @$values['to_date']));

    $this->view->linkedin = $linkedin =  $this->view->linksaves->socialShareCounter(array('pageurl' => $URL, 'title' => 'linkedin', 'from_date' => @$values['from_date'], 'to_date' => @$values['to_date']));

    $this->view->gmail = $gmail =  $this->view->linksaves->socialShareCounter(array('pageurl' => $URL, 'title' => 'gmail', 'from_date' => @$values['from_date'], 'to_date' => @$values['to_date']));

    $this->view->tumblr = $tumblr =  $this->view->linksaves->socialShareCounter(array('pageurl' => $URL, 'title' => 'tumblr', 'from_date' => @$values['from_date'], 'to_date' => @$values['to_date']));

    $this->view->digg = $digg =  $this->view->linksaves->socialShareCounter(array('pageurl' => $URL, 'title' => 'digg'));

    $this->view->stumbleupon = $stumbleupon =  $this->view->linksaves->socialShareCounter(array('pageurl' => $URL, 'title' => 'stumbleupon', 'from_date' => $values['from_date'], 'to_date' => $values['to_date']));

    $this->view->myspace = $myspace =  $this->view->linksaves->socialShareCounter(array('pageurl' => $URL, 'title' => 'myspace', 'from_date' => $values['from_date'], 'to_date' => $values['to_date']));

    $this->view->facebookmessager = $facebookmessager =  $this->view->linksaves->socialShareCounter(array('pageurl' => $URL, 'title' => 'facebookmessager', 'from_date' => $values['from_date'], 'to_date' => $values['to_date']));

    $this->view->rediff =  $rediff =  $this->view->linksaves->socialShareCounter(array('pageurl' => $URL, 'title' => 'rediff', 'from_date' => $values['from_date'], 'to_date' => $values['to_date']));

    $this->view->googlebookmark = $googlebookmark =  $this->view->linksaves->socialShareCounter(array('pageurl' => $URL, 'title' => 'googlebookmark', 'from_date' => $values['from_date'], 'to_date' => $values['to_date']));

    $this->view->flipboard = $flipboard =  $this->view->linksaves->socialShareCounter(array('pageurl' => $URL, 'title' => 'flipboard', 'from_date' => $values['from_date'], 'to_date' => $values['to_date']));

    $this->view->skype = $skype =  $this->view->linksaves->socialShareCounter(array('pageurl' => $URL, 'title' => 'skype', 'from_date' => $values['from_date'], 'to_date' => $values['to_date']));

    $this->view->whatsapp = $whatsapp =  $this->view->linksaves->socialShareCounter(array('pageurl' => $URL, 'title' => 'whatsapp', 'from_date' => $values['from_date'], 'to_date' => $values['to_date']));

    $this->view->email = $email =  $this->view->linksaves->socialShareCounter(array('pageurl' => $URL, 'title' => 'email', 'from_date' => $values['from_date'], 'to_date' => $values['to_date']));

    $this->view->vk = $vk =  $this->view->linksaves->socialShareCounter(array('pageurl' => $URL, 'title' => 'vk'));

    $this->view->yahoo = $yahoo =  $this->view->linksaves->socialShareCounter(array('pageurl' => $URL, 'title' => 'yahoo', 'from_date' => $values['from_date'], 'to_date' => $values['to_date']));

    $this->view->totalCount = $facebook + $twitter + $pinterest + $googleplus + $linkedin + $gmail + $tumblr + $digg + $stumbleupon + $myspace + $facebookmessager + $rediff + $googlebookmark + $flipboard + $skype + $whatsapp + $email + $vk + $yahoo;
  }
}
