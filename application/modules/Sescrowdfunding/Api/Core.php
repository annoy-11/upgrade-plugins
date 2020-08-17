<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_Api_Core extends Core_Api_Abstract {


  public function getWidgetPageId($widgetId) {

    $db = Engine_Db_Table::getDefaultAdapter();
    $params = $db->select()
            ->from('engine4_core_content', 'page_id')
            ->where('`content_id` = ?', $widgetId)
            ->query()
            ->fetchColumn();
    return json_decode($params, true);
  }
  
  /* get other module compatibility code as per module name given */
  public function getPluginItem($moduleName) {
		//initialize module item array
    $moduleType = array();
    $filePath =  APPLICATION_PATH . "/application/modules/" . ucfirst($moduleName) . "/settings/manifest.php";
		//check file exists or not
    if (is_file($filePath)) {
			//now include the file
      $manafestFile = include $filePath;
			$resultsArray =  Engine_Api::_()->getDbtable('integrateothermodules', 'sescrowdfunding')->getResults(array('module_name'=>$moduleName));
      if (is_array($manafestFile) && isset($manafestFile['items'])) {
        foreach ($manafestFile['items'] as $item)
          if (!in_array($item, $resultsArray))
            $moduleType[$item] = $item.' ';
      }
    }
    return $moduleType;
  }
  
  public function getIdentityWidget($name, $type, $corePages) {
    $widgetTable = Engine_Api::_()->getDbTable('content', 'core');
    $widgetPages = Engine_Api::_()->getDbTable('pages', 'core')->info('name');
    $identity = $widgetTable->select()
            ->setIntegrityCheck(false)
            ->from($widgetTable, 'content_id')
            ->where($widgetTable->info('name') . '.type = ?', $type)
            ->where($widgetTable->info('name') . '.name = ?', $name)
            ->where($widgetPages . '.name = ?', $corePages)
            ->joinLeft($widgetPages, $widgetPages . '.page_id = ' . $widgetTable->info('name') . '.page_id')
            ->query()
            ->fetchColumn();
    return $identity;
  }

  public function getWidgetParams($widgetId) {
      if(!$widgetId)
          return array();
    $db = Engine_Db_Table::getDefaultAdapter();
    $params = $db->select()
            ->from('engine4_core_content', 'params')
            ->where('`content_id` = ?', $widgetId)
            ->query()
            ->fetchColumn();
    return json_decode($params, true);
  }
    public function defaultCurrency() {
        if(!empty($_SESSION['ses_multiple_currency']['multipleCurrencyPluginActivated'])){
            return Engine_Api::_()->sesmultiplecurrency()->defaultCurrency();
        }else{
            return Engine_Api::_()->getApi('settings', 'core')->getSetting('payment.currency', 'USD');
        }
    }

    public function getCurrentCurrency(){
        if(!empty($_SESSION['ses_multiple_currency']['multipleCurrencyPluginActivated'])){
            return Engine_Api::_()->sesmultiplecurrency()->getCurrentCurrency();
        }else{
            return Engine_Api::_()->getApi('settings', 'core')->getSetting('payment.currency', 'USD');
        }
    }

    //return price with symbol and change rate param for payment history.
    public function getCurrencyPrice($price = 0, $givenSymbol = '', $change_rate = '') {
        $precisionValue = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmultiplecurrency.precision', 2);
        $defaultParams['precision'] = $precisionValue;
        if(!empty($_SESSION['ses_multiple_currency']['multipleCurrencyPluginActivated'])){
            return Engine_Api::_()->sesmultiplecurrency()->getCurrencyPrice($price, $givenSymbol, $change_rate);
        } else {
            return Zend_Registry::get('Zend_View')->locale()->toCurrency($price, $givenSymbol, $defaultParams);
        }
    }

    public function deleteCrowdfunding($sescrowdfunding = null) {

		if(!$sescrowdfunding)
			return false;

		$crowdfunding_id = $sescrowdfunding->crowdfunding_id;

		//Delete album
		$sescrowdfundingAlbumTable = Engine_Api::_()->getDbTable('albums', 'sescrowdfunding');
		$sescrowdfundingAlbumTable->delete(array('crowdfunding_id = ?' => $crowdfunding_id));

		//Delete Photos
		$sescrowdfundingPhotosTable = Engine_Api::_()->getDbTable('photos', 'sescrowdfunding');
		$sescrowdfundingPhotosTable->delete(array('crowdfunding_id = ?' => $crowdfunding_id));

        //Delete Announcements
		$announcementsTable = Engine_Api::_()->getDbTable('announcements', 'sescrowdfunding');
		$announcementsTable->delete(array('crowdfunding_id = ?' => $crowdfunding_id));

        //Delete Announcements
		$recentlyviewitemsTable = Engine_Api::_()->getDbTable('recentlyviewitems', 'sescrowdfunding');
		$recentlyviewitemsTable->delete(array('resource_id = ?' => $crowdfunding_id));

        //Delete Ratings
		$ratingsTable = Engine_Api::_()->getDbTable('ratings', 'sescrowdfunding');
		$ratingsTable->delete(array('crowdfunding_id = ?' => $crowdfunding_id));

        //Delete Rewards
		$rewardsTable = Engine_Api::_()->getDbTable('rewards', 'sescrowdfunding');
		$rewardsTable->delete(array('crowdfunding_id = ?' => $crowdfunding_id));

		$sescrowdfunding->delete();
	}

	public function isMultiCurrencyAvailable(){
		if(!empty($_SESSION['ses_multiple_currency']['multipleCurrencyPluginActivated'])){
            return Engine_Api::_()->sesmultiplecurrency()->isMultiCurrencyAvailable();
        } else{
            return false;
        }
	}

  public function checkRated($crowdfunding_id, $user_id) {

    $table  = Engine_Api::_()->getDbTable('ratings', 'sescrowdfunding');

    $rName = $table->info('name');
    $select = $table->select()
                 ->setIntegrityCheck(false)
                    ->where('crowdfunding_id = ?', $crowdfunding_id)
                    ->where('user_id = ?', $user_id)
                    ->limit(1);
    $row = $table->fetchAll($select);

    if (count($row)>0) return true;
    return false;
  }

  public function getRating($crowdfunding_id) {

    $table  = Engine_Api::_()->getDbTable('ratings', 'sescrowdfunding');
    $rating_sum = $table->select()
                      ->from($table->info('name'), new Zend_Db_Expr('SUM(rating)'))
                      ->group('crowdfunding_id')
                      ->where('crowdfunding_id = ?', $crowdfunding_id)
                      ->query()
                      ->fetchColumn(0);

    $total = $this->ratingCount($crowdfunding_id);
    if ($total) $rating = $rating_sum/$this->ratingCount($crowdfunding_id);
    else $rating = 0;

    return $rating;
  }

  public function setRating($crowdfunding_id, $user_id, $rating) {

    $table  = Engine_Api::_()->getDbTable('ratings', 'sescrowdfunding');
    $rName = $table->info('name');

    $select = $table->select()
                    ->from($rName)
                    ->where($rName.'.crowdfunding_id = ?', $crowdfunding_id)
                    ->where($rName.'.user_id = ?', $user_id);
    $row = $table->fetchRow($select);
    if (empty($row)) {
      Engine_Api::_()->getDbTable('ratings', 'sescrowdfunding')->insert(array(
        'crowdfunding_id' => $crowdfunding_id,
        'user_id' => $user_id,
        'rating' => $rating
      ));
    }
  }

  public function ratingCount($crowdfunding_id) {

    $table  = Engine_Api::_()->getDbTable('ratings', 'sescrowdfunding');
    $rName = $table->info('name');
    $select = $table->select()
                    ->from($rName)
                    ->where($rName.'.crowdfunding_id = ?', $crowdfunding_id);
    $row = $table->fetchAll($select);
    $total = count($row);
    return $total;
  }

  function tagCloudItemCore($fetchtype = '', $crowdfunding_id = '') {

    $tableTagmap = Engine_Api::_()->getDbTable('tagMaps', 'core');
    $tableTagName = $tableTagmap->info('name');
    $tableTag = Engine_Api::_()->getDbTable('tags', 'core');
    $tableMainTagName = $tableTag->info('name');
    $selecttagged_photo = $tableTagmap->select()
            ->from($tableTagName)
            ->setIntegrityCheck(false)
            ->where('resource_type =?', 'crowdfunding')
            ->where('tag_type =?', 'core_tag')
            ->joinLeft($tableMainTagName, $tableMainTagName . '.tag_id=' . $tableTagName . '.tag_id', array('text'))
            ->group($tableTagName . '.tag_id');
    if($crowdfunding_id) {
      $selecttagged_photo->where($tableTagName.'.resource_id =?', $crowdfunding_id);
    }
    $selecttagged_photo->columns(array('itemCount' => ("COUNT($tableTagName.tagmap_id)")));
    if ($fetchtype == '')
      return Zend_Paginator::factory($selecttagged_photo);
    else
      return $tableTagmap->fetchAll($selecttagged_photo);
  }

  public function getLikeStatusCrowdfunding($crowdfunding_id = '', $moduleName = '') {

    if ($moduleName == '')
      $moduleName = 'crowdfunding';

    if ($crowdfunding_id != '') {
      $userId = Engine_Api::_()->user()->getViewer()->getIdentity();
      if ($userId == 0)
        return false;
      $coreLikeTable = Engine_Api::_()->getDbTable('likes', 'core');
      $total_likes = $coreLikeTable->select()
              ->from($coreLikeTable->info('name'), new Zend_Db_Expr('COUNT(like_id) as like_count'))
              ->where('resource_type =?', $moduleName)
              ->where('poster_id =?', $userId)
              ->where('poster_type =?', 'user')
              ->where('	resource_id =?', $crowdfunding_id)
              ->query()
              ->fetchColumn();
      if ($total_likes > 0)
        return true;
      else
        return false;
    }
    return false;
  }
  function checkPaymentGatewayEnable(){
      $paymentMethods = array();
      $noPaymentGatewayEnableByAdmin = false;
      //payment to site admin
      $table = Engine_Api::_()->getDbTable('gateways','payment');
      $select = $table->select()->where('plugin =?','Payment_Plugin_Gateway_PayPal')->where('enabled =?',1);
      $paypal = $table->fetchRow($select);
      $select = $table->select()->where('plugin =?','Sesadvpmnt_Plugin_Gateway_Stripe')->where('enabled =?',1);
      $stripe = $table->fetchRow($select);
      $select = $table->select()->where('plugin =?','Epaytm_Plugin_Gateway_Paytm')->where('enabled =?',1);
      $paytm = $table->fetchRow($select);
      $givenSymbol = Engine_Api::_()->sescrowdfunding()->getCurrentCurrency();;
      if($paypal){
          $paymentMethods['paypal'] = 'PayPal';
      }
      if($stripe){
        $gatewayObject = $stripe->getGateway();
        $stripeSupportedCurrencies = $gatewayObject->getSupportedCurrencies();
        if(in_array($givenSymbol,$stripeSupportedCurrencies))
          $paymentMethods['stripe'] = 'Stripe';
      }
      if($paytm){
        $gatewayObject = $paytm->getGateway();
        $paytmSupportedCurrencies = $gatewayObject->getSupportedCurrencies();
        if(in_array($givenSymbol,$paytmSupportedCurrencies))
            $paymentMethods['paytm'] = 'Paytm';
      }
      if(!count($paymentMethods)){
          $noPaymentGatewayEnableByAdmin = true;
      }
      return array('methods'=>$paymentMethods,'noPaymentGatewayEnableByAdmin'=>$noPaymentGatewayEnableByAdmin,'paypal'=>$paypal);
  }
}
