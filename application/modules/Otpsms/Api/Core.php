<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Otpsms
 * @package    Otpsms
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Otpsms_Api_Core extends Core_Api_Abstract {
  function generateMessage($phone_number,$code,$type = "signup_template"){
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $suration = $settings->getSetting("otpsms.duration",600);
    $username = Engine_Api::_()->user()->getViewer()->getIdentity() ? Engine_Api::_()->user()->getViewer()->getTitle() : '';
    $website = $settings->getSetting('core.general.site.title', '');
    $teplateTable = Engine_Api::_()->getDbtable('templates', 'otpsms');
    $language = Zend_Registry::get('Locale')->getLanguage();
    $select = $teplateTable->select()->where('language=?', $language);
    $template = $teplateTable->fetchRow($select);
    if( empty($param) ) {
      $select = $teplateTable->select()->where('language=?', 'en');
      $template = $teplateTable->fetchRow($select);
    }
    $timestring = $this->secondsToTime($suration);
    $message = str_replace(array("[code]", "[website_name]","[expirytime]", "[username]"), array($code, $website, $timestring, $username), $template->{$type});
    return $message;
  }
  function secondsToTime($seconds) {
    // extract hours
    $hours = floor($seconds / (60 * 60));
    // extract minutes
    $divisor_for_minutes = $seconds % (60 * 60);
    $minutes = floor($divisor_for_minutes / 60);  
    // extract the remaining seconds
    $divisor_for_seconds = $divisor_for_minutes % 60;
    $seconds = ceil($divisor_for_seconds);
    // return the final array
    $string = "";
    if($hours > 0)
      $string .= $hours.($hours != 1 ? " hours " : " hour ");
    if($minutes > 0)
      $string .= $minutes.($minutes != 1 ? " minutes " : " minute ");
    if($seconds > 0)
      $string .= $seconds.($seconds != 1 ? " seconds " : " second ");
    return trim($string," ");
  }
  function sendMessage($phone_number, $code,$type = "signup_template"){
    $message = $this->generateMessage($phone_number,$code,$type);
    $this->sedMessageCode($phone_number,$message,$code,false,$type);
  }
  function sedMessageCode($phone_number,$message,$code,$user = 0,$type,$direct = false){
    $service = Engine_Api::_()->getApi('settings', 'core')->getSetting('otpsms.integration');
    if( $service == "twilio" && $this->twillio()) {
      $status = $this->sendMessageUsingTwilo($phone_number, $message);
    }elseif( $service == "amazon"  && $this->amazon()) {
      $status = $this->sendMessageUsingAmazon($phone_number, $message);
    }
	if($direct){
		  $statistictable = Engine_Api::_()->getDbtable('statistics', 'otpsms');
		  $statistictable->insert(array(
			'type' => 'admin',
			'service' => $service,
			'code' => $code,
			'user_id' => $user ? $user->getIdentity() : 0,
			'creation_date' => date('Y-m-d H:i:s'),
		  ));
		return;
	}
    //if success
    if( $status ) {
      $statistictable = Engine_Api::_()->getDbtable('statistics', 'otpsms');
      $statistictable->insert(array(
        'type' => $type,
        'service' => $service,
        'code' => $code,
        'user_id' => $user ? $user->getIdentity() : 0,
        'creation_date' => date('Y-m-d H:i:s'),
      ));
    }
    return $status;  
  }
  function isServiceEnable(){
     return $this->amazon() || $this->twillio();  
  }
  function amazon(){
    $settingsAmazon = (array) Engine_Api::_()->getApi('settings', 'core')->otpsms_amazon;
    $clientId = isset($settingsAmazon['clientId']) ? $settingsAmazon['clientId'] : 0;
    $clientSecret = isset($settingsAmazon['clientSecret']) ? $settingsAmazon['clientSecret'] : 0;
    
    return !empty($clientId) && !empty($clientSecret);
  }
  function twillio(){
    $settingsTwillio = (array) Engine_Api::_()->getApi('settings', 'core')->otpsms_twilio;
    $clientId = isset($settingsTwillio['clientId']) ? $settingsTwillio['clientId'] : 0;
    $phoneNumber = isset($settingsTwillio['phoneNumber']) ? $settingsTwillio['phoneNumber'] : 0;
    $clientSecret = isset($settingsTwillio['clientSecret']) ? $settingsTwillio['clientSecret'] : 0;
    
    return !empty($clientId) && !empty($phoneNumber) && !empty($clientSecret);
  }
  function sendMessageUsingAmazon($phone_number, $message){
    $settingsAmazon = (array) Engine_Api::_()->getApi('settings', 'core')->otpsms_amazon;
    $clientId = $settingsAmazon['clientId'];
    $clientSecret = $settingsAmazon['clientSecret'];
    require_once APPLICATION_PATH . '/application/modules/Otpsms/Api/Aws/autoloader.php';
    try {
      $client = new \Aws\Sns\SnsClient([
        'credentials' => array(
          'key' => $clientId,
          'secret' => $clientSecret,
        ),
        'version' => '2010-03-31',
        'region' => 'us-west-2',
        
      ]);
      $array = array('attributes' => array('DefaultSenderID' => 'test', 'DefaultSMSType' => 'Transactional'));
      //$client->setSMSAttributes($array);
      $client->publish(array(
        "SenderID" => "SenderName",
        "SMSType" => "Transational",
        'Message' => $message, // REQUIRED
        'PhoneNumber' => $phone_number,
        'Subject' => 'Test',
      ));
      return true;
    } catch( Exceptions $e ) {
      return false;
    }
  }
  function sendMessageUsingTwilo($phone_number, $message){
    require_once APPLICATION_PATH . '/application/modules/Otpsms/Api/Twilio/autoload.php';
    $settingsTwillio = (array) Engine_Api::_()->getApi('settings', 'core')->otpsms_twilio;
    $clientId = $settingsTwillio['clientId'];
    $clientSecret = $settingsTwillio['clientSecret'];
    $phoneNumber = $settingsTwillio['phoneNumber'];
    try {
      $client = new \Twilio\Rest\Client($clientId, $clientSecret);
      // Use the client to do fun stuff like send text messages!
      $client->messages->create(
        // the number you'd like to send the message to
        $phone_number, array(
        // A Twilio phone number you purchased at twilio.com/console
        'from' => $phoneNumber,
        // the body of the text message you'd like to send
        'body' => $message
        )
      );
      return true;
    } catch( Exceptions $e ) {
      return false;
    }  
  }
  function generateCode(){
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $length = $settings->getSetting('otpsms.code.length', 6);

    do {
      $maxNbrStr = str_repeat('9', $codelength);
      $maxNbr = intval($maxNbrStr);
      $n = mt_rand(0, $maxNbr);
      $code = str_pad($n, $codelength, "0", STR_PAD_LEFT);
      $chars = "abcdefghijkmnopqrstuvwxyz023456789"; 
      srand((double)microtime()*1000000); 
      $i = 0; 
      $pass = '' ; 
      while ($i < $length) { 
          $num = rand() % 33; 
          $tmp = substr($chars, $num, 1); 
          $pass = $pass . $tmp; 
          $i++; 
      }
      //store code in table
      $forgotTable = Engine_Api::_()->getDbtable('codes', 'otpsms');
      $forgotSelect = $forgotTable->select()
        ->where('code = ?', $pass);
      $forgotRow = $forgotTable->fetchRow($forgotSelect);
    } while( !empty($forgotRow) );

    return $pass;  
  }
  function getCountryCodes(){
     return array (
         'AF' =>
             array (
                 'code' => '93',
                 'name' => 'AFGHANISTAN',
             ),
         'AL' =>
             array (
                 'code' => '355',
                 'name' => 'ALBANIA',
             ),
         'DZ' =>
             array (
                 'code' => '213',
                 'name' => 'ALGERIA',
             ),
         'AS' =>
             array (
                 'code' => '1684',
                 'name' => 'AMERICAN SAMOA',
             ),
         'AD' =>
             array (
                 'code' => '376',
                 'name' => 'ANDORRA',
             ),
         'AO' =>
             array (
                 'code' => '244',
                 'name' => 'ANGOLA',
             ),
         'AI' =>
             array (
                 'code' => '1264',
                 'name' => 'ANGUILLA',
             ),
         'AQ' =>
             array (
                 'code' => '672',
                 'name' => 'ANTARCTICA',
             ),
         'AG' =>
             array (
                 'code' => '1268',
                 'name' => 'ANTIGUA AND BARBUDA',
             ),
         'AR' =>
             array (
                 'code' => '54',
                 'name' => 'ARGENTINA',
             ),
         'AM' =>
             array (
                 'code' => '374',
                 'name' => 'ARMENIA',
             ),
         'AW' =>
             array (
                 'code' => '297',
                 'name' => 'ARUBA',
             ),
         'AU' =>
             array (
                 'code' => '61',
                 'name' => 'AUSTRALIA',
             ),
         'AT' =>
             array (
                 'code' => '43',
                 'name' => 'AUSTRIA',
             ),
         'AZ' =>
             array (
                 'code' => '994',
                 'name' => 'AZERBAIJAN',
             ),
         'BS' =>
             array (
                 'code' => '1242',
                 'name' => 'BAHAMAS',
             ),
         'BH' =>
             array (
                 'code' => '973',
                 'name' => 'BAHRAIN',
             ),
         'BD' =>
             array (
                 'code' => '880',
                 'name' => 'BANGLADESH',
             ),
         'BB' =>
             array (
                 'code' => '1246',
                 'name' => 'BARBADOS',
             ),
         'BY' =>
             array (
                 'code' => '375',
                 'name' => 'BELARUS',
             ),
         'BE' =>
             array (
                 'code' => '32',
                 'name' => 'BELGIUM',
             ),
         'BZ' =>
             array (
                 'code' => '501',
                 'name' => 'BELIZE',
             ),
         'BJ' =>
             array (
                 'code' => '229',
                 'name' => 'BENIN',
             ),
         'BM' =>
             array (
                 'code' => '1441',
                 'name' => 'BERMUDA',
             ),
         'BT' =>
             array (
                 'code' => '975',
                 'name' => 'BHUTAN',
             ),
         'BO' =>
             array (
                 'code' => '591',
                 'name' => 'BOLIVIA',
             ),
         'BA' =>
             array (
                 'code' => '387',
                 'name' => 'BOSNIA AND HERZEGOVINA',
             ),
         'BW' =>
             array (
                 'code' => '267',
                 'name' => 'BOTSWANA',
             ),
         'BR' =>
             array (
                 'code' => '55',
                 'name' => 'BRAZIL',
             ),
         'BN' =>
             array (
                 'code' => '673',
                 'name' => 'BRUNEI DARUSSALAM',
             ),
         'BG' =>
             array (
                 'code' => '359',
                 'name' => 'BULGARIA',
             ),
         'BF' =>
             array (
                 'code' => '226',
                 'name' => 'BURKINA FASO',
             ),
         'BI' =>
             array (
                 'code' => '257',
                 'name' => 'BURUNDI',
             ),
         'KH' =>
             array (
                 'code' => '855',
                 'name' => 'CAMBODIA',
             ),
         'CM' =>
             array (
                 'code' => '237',
                 'name' => 'CAMEROON',
             ),
         'CA' =>
             array (
                 'code' => '1',
                 'name' => 'CANADA',
             ),
         'CV' =>
             array (
                 'code' => '238',
                 'name' => 'CAPE VERDE',
             ),
         'KY' =>
             array (
                 'code' => '1345',
                 'name' => 'CAYMAN ISLANDS',
             ),
         'CF' =>
             array (
                 'code' => '236',
                 'name' => 'CENTRAL AFRICAN REPUBLIC',
             ),
         'TD' =>
             array (
                 'code' => '235',
                 'name' => 'CHAD',
             ),
         'CL' =>
             array (
                 'code' => '56',
                 'name' => 'CHILE',
             ),
         'CN' =>
             array (
                 'code' => '86',
                 'name' => 'CHINA',
             ),
         'CX' =>
             array (
                 'code' => '61',
                 'name' => 'CHRISTMAS ISLAND',
             ),
         'CC' =>
             array (
                 'code' => '61',
                 'name' => 'COCOS (KEELING) ISLANDS',
             ),
         'CO' =>
             array (
                 'code' => '57',
                 'name' => 'COLOMBIA',
             ),
         'KM' =>
             array (
                 'code' => '269',
                 'name' => 'COMOROS',
             ),
         'CG' =>
             array (
                 'code' => '242',
                 'name' => 'CONGO',
             ),
         'CD' =>
             array (
                 'code' => '243',
                 'name' => 'CONGO, THE DEMOCRATIC REPUBLIC OF THE',
             ),
         'CK' =>
             array (
                 'code' => '682',
                 'name' => 'COOK ISLANDS',
             ),
         'CR' =>
             array (
                 'code' => '506',
                 'name' => 'COSTA RICA',
             ),
         'CI' =>
             array (
                 'code' => '225',
                 'name' => 'COTE D IVOIRE',
             ),
         'HR' =>
             array (
                 'code' => '385',
                 'name' => 'CROATIA',
             ),
         'CU' =>
             array (
                 'code' => '53',
                 'name' => 'CUBA',
             ),
         'CY' =>
             array (
                 'code' => '357',
                 'name' => 'CYPRUS',
             ),
         'CZ' =>
             array (
                 'code' => '420',
                 'name' => 'CZECH REPUBLIC',
             ),
         'DK' =>
             array (
                 'code' => '45',
                 'name' => 'DENMARK',
             ),
         'DJ' =>
             array (
                 'code' => '253',
                 'name' => 'DJIBOUTI',
             ),
         'DM' =>
             array (
                 'code' => '1767',
                 'name' => 'DOMINICA',
             ),
         'DO' =>
             array (
                 'code' => '1809',
                 'name' => 'DOMINICAN REPUBLIC',
             ),
         'EC' =>
             array (
                 'code' => '593',
                 'name' => 'ECUADOR',
             ),
         'EG' =>
             array (
                 'code' => '20',
                 'name' => 'EGYPT',
             ),
         'SV' =>
             array (
                 'code' => '503',
                 'name' => 'EL SALVADOR',
             ),
         'GQ' =>
             array (
                 'code' => '240',
                 'name' => 'EQUATORIAL GUINEA',
             ),
         'ER' =>
             array (
                 'code' => '291',
                 'name' => 'ERITREA',
             ),
         'EE' =>
             array (
                 'code' => '372',
                 'name' => 'ESTONIA',
             ),
         'ET' =>
             array (
                 'code' => '251',
                 'name' => 'ETHIOPIA',
             ),
         'FK' =>
             array (
                 'code' => '500',
                 'name' => 'FALKLAND ISLANDS (MALVINAS)',
             ),
         'FO' =>
             array (
                 'code' => '298',
                 'name' => 'FAROE ISLANDS',
             ),
         'FJ' =>
             array (
                 'code' => '679',
                 'name' => 'FIJI',
             ),
         'FI' =>
             array (
                 'code' => '358',
                 'name' => 'FINLAND',
             ),
         'FR' =>
             array (
                 'code' => '33',
                 'name' => 'FRANCE',
             ),
         'PF' =>
             array (
                 'code' => '689',
                 'name' => 'FRENCH POLYNESIA',
             ),
         'GA' =>
             array (
                 'code' => '241',
                 'name' => 'GABON',
             ),
         'GM' =>
             array (
                 'code' => '220',
                 'name' => 'GAMBIA',
             ),
         'GE' =>
             array (
                 'code' => '995',
                 'name' => 'GEORGIA',
             ),
         'DE' =>
             array (
                 'code' => '49',
                 'name' => 'GERMANY',
             ),
         'GH' =>
             array (
                 'code' => '233',
                 'name' => 'GHANA',
             ),
         'GI' =>
             array (
                 'code' => '350',
                 'name' => 'GIBRALTAR',
             ),
         'GR' =>
             array (
                 'code' => '30',
                 'name' => 'GREECE',
             ),
         'GL' =>
             array (
                 'code' => '299',
                 'name' => 'GREENLAND',
             ),
         'GD' =>
             array (
                 'code' => '1473',
                 'name' => 'GRENADA',
             ),
         'GU' =>
             array (
                 'code' => '1671',
                 'name' => 'GUAM',
             ),
         'GT' =>
             array (
                 'code' => '502',
                 'name' => 'GUATEMALA',
             ),
         'GN' =>
             array (
                 'code' => '224',
                 'name' => 'GUINEA',
             ),
         'GW' =>
             array (
                 'code' => '245',
                 'name' => 'GUINEA-BISSAU',
             ),
         'GY' =>
             array (
                 'code' => '592',
                 'name' => 'GUYANA',
             ),
         'HT' =>
             array (
                 'code' => '509',
                 'name' => 'HAITI',
             ),
         'VA' =>
             array (
                 'code' => '39',
                 'name' => 'HOLY SEE (VATICAN CITY STATE)',
             ),
         'HN' =>
             array (
                 'code' => '504',
                 'name' => 'HONDURAS',
             ),
         'HK' =>
             array (
                 'code' => '852',
                 'name' => 'HONG KONG',
             ),
         'HU' =>
             array (
                 'code' => '36',
                 'name' => 'HUNGARY',
             ),
         'IS' =>
             array (
                 'code' => '354',
                 'name' => 'ICELAND',
             ),
         'IN' =>
             array (
                 'code' => '91',
                 'name' => 'INDIA',
             ),
         'ID' =>
             array (
                 'code' => '62',
                 'name' => 'INDONESIA',
             ),
         'IR' =>
             array (
                 'code' => '98',
                 'name' => 'IRAN, ISLAMIC REPUBLIC OF',
             ),
         'IQ' =>
             array (
                 'code' => '964',
                 'name' => 'IRAQ',
             ),
         'IE' =>
             array (
                 'code' => '353',
                 'name' => 'IRELAND',
             ),
         'IM' =>
             array (
                 'code' => '44',
                 'name' => 'ISLE OF MAN',
             ),
         'IL' =>
             array (
                 'code' => '972',
                 'name' => 'ISRAEL',
             ),
         'IT' =>
             array (
                 'code' => '39',
                 'name' => 'ITALY',
             ),
         'JM' =>
             array (
                 'code' => '1876',
                 'name' => 'JAMAICA',
             ),
         'JP' =>
             array (
                 'code' => '81',
                 'name' => 'JAPAN',
             ),
         'JO' =>
             array (
                 'code' => '962',
                 'name' => 'JORDAN',
             ),
         'KZ' =>
             array (
                 'code' => '7',
                 'name' => 'KAZAKSTAN',
             ),
         'KE' =>
             array (
                 'code' => '254',
                 'name' => 'KENYA',
             ),
         'KI' =>
             array (
                 'code' => '686',
                 'name' => 'KIRIBATI',
             ),
         'KP' =>
             array (
                 'code' => '850',
                 'name' => 'KOREA DEMOCRATIC PEOPLES REPUBLIC OF',
             ),
         'KR' =>
             array (
                 'code' => '82',
                 'name' => 'KOREA REPUBLIC OF',
             ),
         'XK' =>
             array (
                 'code' => '381',
                 'name' => 'KOSOVO',
             ),
         'KW' =>
             array (
                 'code' => '965',
                 'name' => 'KUWAIT',
             ),
         'KG' =>
             array (
                 'code' => '996',
                 'name' => 'KYRGYZSTAN',
             ),
         'LA' =>
             array (
                 'code' => '856',
                 'name' => 'LAO PEOPLES DEMOCRATIC REPUBLIC',
             ),
         'LV' =>
             array (
                 'code' => '371',
                 'name' => 'LATVIA',
             ),
         'LB' =>
             array (
                 'code' => '961',
                 'name' => 'LEBANON',
             ),
         'LS' =>
             array (
                 'code' => '266',
                 'name' => 'LESOTHO',
             ),
         'LR' =>
             array (
                 'code' => '231',
                 'name' => 'LIBERIA',
             ),
         'LY' =>
             array (
                 'code' => '218',
                 'name' => 'LIBYAN ARAB JAMAHIRIYA',
             ),
         'LI' =>
             array (
                 'code' => '423',
                 'name' => 'LIECHTENSTEIN',
             ),
         'LT' =>
             array (
                 'code' => '370',
                 'name' => 'LITHUANIA',
             ),
         'LU' =>
             array (
                 'code' => '352',
                 'name' => 'LUXEMBOURG',
             ),
         'MO' =>
             array (
                 'code' => '853',
                 'name' => 'MACAU',
             ),
         'MK' =>
             array (
                 'code' => '389',
                 'name' => 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF',
             ),
         'MG' =>
             array (
                 'code' => '261',
                 'name' => 'MADAGASCAR',
             ),
         'MW' =>
             array (
                 'code' => '265',
                 'name' => 'MALAWI',
             ),
         'MY' =>
             array (
                 'code' => '60',
                 'name' => 'MALAYSIA',
             ),
         'MV' =>
             array (
                 'code' => '960',
                 'name' => 'MALDIVES',
             ),
         'ML' =>
             array (
                 'code' => '223',
                 'name' => 'MALI',
             ),
         'MT' =>
             array (
                 'code' => '356',
                 'name' => 'MALTA',
             ),
         'MH' =>
             array (
                 'code' => '692',
                 'name' => 'MARSHALL ISLANDS',
             ),
         'MR' =>
             array (
                 'code' => '222',
                 'name' => 'MAURITANIA',
             ),
         'MU' =>
             array (
                 'code' => '230',
                 'name' => 'MAURITIUS',
             ),
         'YT' =>
             array (
                 'code' => '262',
                 'name' => 'MAYOTTE',
             ),
         'MX' =>
             array (
                 'code' => '52',
                 'name' => 'MEXICO',
             ),
         'FM' =>
             array (
                 'code' => '691',
                 'name' => 'MICRONESIA, FEDERATED STATES OF',
             ),
         'MD' =>
             array (
                 'code' => '373',
                 'name' => 'MOLDOVA, REPUBLIC OF',
             ),
         'MC' =>
             array (
                 'code' => '377',
                 'name' => 'MONACO',
             ),
         'MN' =>
             array (
                 'code' => '976',
                 'name' => 'MONGOLIA',
             ),
         'ME' =>
             array (
                 'code' => '382',
                 'name' => 'MONTENEGRO',
             ),
         'MS' =>
             array (
                 'code' => '1664',
                 'name' => 'MONTSERRAT',
             ),
         'MA' =>
             array (
                 'code' => '212',
                 'name' => 'MOROCCO',
             ),
         'MZ' =>
             array (
                 'code' => '258',
                 'name' => 'MOZAMBIQUE',
             ),
         'MM' =>
             array (
                 'code' => '95',
                 'name' => 'MYANMAR',
             ),
         'NA' =>
             array (
                 'code' => '264',
                 'name' => 'NAMIBIA',
             ),
         'NR' =>
             array (
                 'code' => '674',
                 'name' => 'NAURU',
             ),
         'NP' =>
             array (
                 'code' => '977',
                 'name' => 'NEPAL',
             ),
         'NL' =>
             array (
                 'code' => '31',
                 'name' => 'NETHERLANDS',
             ),
         'AN' =>
             array (
                 'code' => '599',
                 'name' => 'NETHERLANDS ANTILLES',
             ),
         'NC' =>
             array (
                 'code' => '687',
                 'name' => 'NEW CALEDONIA',
             ),
         'NZ' =>
             array (
                 'code' => '64',
                 'name' => 'NEW ZEALAND',
             ),
         'NI' =>
             array (
                 'code' => '505',
                 'name' => 'NICARAGUA',
             ),
         'NE' =>
             array (
                 'code' => '227',
                 'name' => 'NIGER',
             ),
         'NG' =>
             array (
                 'code' => '234',
                 'name' => 'NIGERIA',
             ),
         'NU' =>
             array (
                 'code' => '683',
                 'name' => 'NIUE',
             ),
         'MP' =>
             array (
                 'code' => '1670',
                 'name' => 'NORTHERN MARIANA ISLANDS',
             ),
         'NO' =>
             array (
                 'code' => '47',
                 'name' => 'NORWAY',
             ),
         'OM' =>
             array (
                 'code' => '968',
                 'name' => 'OMAN',
             ),
         'PK' =>
             array (
                 'code' => '92',
                 'name' => 'PAKISTAN',
             ),
         'PW' =>
             array (
                 'code' => '680',
                 'name' => 'PALAU',
             ),
         'PA' =>
             array (
                 'code' => '507',
                 'name' => 'PANAMA',
             ),
         'PG' =>
             array (
                 'code' => '675',
                 'name' => 'PAPUA NEW GUINEA',
             ),
         'PY' =>
             array (
                 'code' => '595',
                 'name' => 'PARAGUAY',
             ),
         'PE' =>
             array (
                 'code' => '51',
                 'name' => 'PERU',
             ),
         'PH' =>
             array (
                 'code' => '63',
                 'name' => 'PHILIPPINES',
             ),
         'PN' =>
             array (
                 'code' => '870',
                 'name' => 'PITCAIRN',
             ),
         'PL' =>
             array (
                 'code' => '48',
                 'name' => 'POLAND',
             ),
         'PT' =>
             array (
                 'code' => '351',
                 'name' => 'PORTUGAL',
             ),
         'PR' =>
             array (
                 'code' => '1',
                 'name' => 'PUERTO RICO',
             ),
         'QA' =>
             array (
                 'code' => '974',
                 'name' => 'QATAR',
             ),
         'RO' =>
             array (
                 'code' => '40',
                 'name' => 'ROMANIA',
             ),
         'RU' =>
             array (
                 'code' => '7',
                 'name' => 'RUSSIAN FEDERATION',
             ),
         'RW' =>
             array (
                 'code' => '250',
                 'name' => 'RWANDA',
             ),
         'BL' =>
             array (
                 'code' => '590',
                 'name' => 'SAINT BARTHELEMY',
             ),
         'SH' =>
             array (
                 'code' => '290',
                 'name' => 'SAINT HELENA',
             ),
         'KN' =>
             array (
                 'code' => '1869',
                 'name' => 'SAINT KITTS AND NEVIS',
             ),
         'LC' =>
             array (
                 'code' => '1758',
                 'name' => 'SAINT LUCIA',
             ),
         'MF' =>
             array (
                 'code' => '1599',
                 'name' => 'SAINT MARTIN',
             ),
         'PM' =>
             array (
                 'code' => '508',
                 'name' => 'SAINT PIERRE AND MIQUELON',
             ),
         'VC' =>
             array (
                 'code' => '1784',
                 'name' => 'SAINT VINCENT AND THE GRENADINES',
             ),
         'WS' =>
             array (
                 'code' => '685',
                 'name' => 'SAMOA',
             ),
         'SM' =>
             array (
                 'code' => '378',
                 'name' => 'SAN MARINO',
             ),
         'ST' =>
             array (
                 'code' => '239',
                 'name' => 'SAO TOME AND PRINCIPE',
             ),
         'SA' =>
             array (
                 'code' => '966',
                 'name' => 'SAUDI ARABIA',
             ),
         'SN' =>
             array (
                 'code' => '221',
                 'name' => 'SENEGAL',
             ),
         'RS' =>
             array (
                 'code' => '381',
                 'name' => 'SERBIA',
             ),
         'SC' =>
             array (
                 'code' => '248',
                 'name' => 'SEYCHELLES',
             ),
         'SL' =>
             array (
                 'code' => '232',
                 'name' => 'SIERRA LEONE',
             ),
         'SG' =>
             array (
                 'code' => '65',
                 'name' => 'SINGAPORE',
             ),
         'SK' =>
             array (
                 'code' => '421',
                 'name' => 'SLOVAKIA',
             ),
         'SI' =>
             array (
                 'code' => '386',
                 'name' => 'SLOVENIA',
             ),
         'SB' =>
             array (
                 'code' => '677',
                 'name' => 'SOLOMON ISLANDS',
             ),
         'SO' =>
             array (
                 'code' => '252',
                 'name' => 'SOMALIA',
             ),
         'ZA' =>
             array (
                 'code' => '27',
                 'name' => 'SOUTH AFRICA',
             ),
         'ES' =>
             array (
                 'code' => '34',
                 'name' => 'SPAIN',
             ),
         'LK' =>
             array (
                 'code' => '94',
                 'name' => 'SRI LANKA',
             ),
         'SD' =>
             array (
                 'code' => '249',
                 'name' => 'SUDAN',
             ),
         'SR' =>
             array (
                 'code' => '597',
                 'name' => 'SURINAME',
             ),
         'SZ' =>
             array (
                 'code' => '268',
                 'name' => 'SWAZILAND',
             ),
         'SE' =>
             array (
                 'code' => '46',
                 'name' => 'SWEDEN',
             ),
         'CH' =>
             array (
                 'code' => '41',
                 'name' => 'SWITZERLAND',
             ),
         'SY' =>
             array (
                 'code' => '963',
                 'name' => 'SYRIAN ARAB REPUBLIC',
             ),
         'TW' =>
             array (
                 'code' => '886',
                 'name' => 'TAIWAN, PROVINCE OF CHINA',
             ),
         'TJ' =>
             array (
                 'code' => '992',
                 'name' => 'TAJIKISTAN',
             ),
         'TZ' =>
             array (
                 'code' => '255',
                 'name' => 'TANZANIA, UNITED REPUBLIC OF',
             ),
         'TH' =>
             array (
                 'code' => '66',
                 'name' => 'THAILAND',
             ),
         'TL' =>
             array (
                 'code' => '670',
                 'name' => 'TIMOR-LESTE',
             ),
         'TG' =>
             array (
                 'code' => '228',
                 'name' => 'TOGO',
             ),
         'TK' =>
             array (
                 'code' => '690',
                 'name' => 'TOKELAU',
             ),
         'TO' =>
             array (
                 'code' => '676',
                 'name' => 'TONGA',
             ),
         'TT' =>
             array (
                 'code' => '1868',
                 'name' => 'TRINIDAD AND TOBAGO',
             ),
         'TN' =>
             array (
                 'code' => '216',
                 'name' => 'TUNISIA',
             ),
         'TR' =>
             array (
                 'code' => '90',
                 'name' => 'TURKEY',
             ),
         'TM' =>
             array (
                 'code' => '993',
                 'name' => 'TURKMENISTAN',
             ),
         'TC' =>
             array (
                 'code' => '1649',
                 'name' => 'TURKS AND CAICOS ISLANDS',
             ),
         'TV' =>
             array (
                 'code' => '688',
                 'name' => 'TUVALU',
             ),
         'UG' =>
             array (
                 'code' => '256',
                 'name' => 'UGANDA',
             ),
         'UA' =>
             array (
                 'code' => '380',
                 'name' => 'UKRAINE',
             ),
         'AE' =>
             array (
                 'code' => '971',
                 'name' => 'UNITED ARAB EMIRATES',
             ),
         'GB' =>
             array (
                 'code' => '44',
                 'name' => 'UNITED KINGDOM',
             ),
         'US' =>
             array (
                 'code' => '1',
                 'name' => 'UNITED STATES',
             ),
         'UY' =>
             array (
                 'code' => '598',
                 'name' => 'URUGUAY',
             ),
         'UZ' =>
             array (
                 'code' => '998',
                 'name' => 'UZBEKISTAN',
             ),
         'VU' =>
             array (
                 'code' => '678',
                 'name' => 'VANUATU',
             ),
         'VE' =>
             array (
                 'code' => '58',
                 'name' => 'VENEZUELA',
             ),
         'VN' =>
             array (
                 'code' => '84',
                 'name' => 'VIET NAM',
             ),
         'VG' =>
             array (
                 'code' => '1284',
                 'name' => 'VIRGIN ISLANDS, BRITISH',
             ),
         'VI' =>
             array (
                 'code' => '1340',
                 'name' => 'VIRGIN ISLANDS, U.S.',
             ),
         'WF' =>
             array (
                 'code' => '681',
                 'name' => 'WALLIS AND FUTUNA',
             ),
         'YE' =>
             array (
                 'code' => '967',
                 'name' => 'YEMEN',
             ),
         'ZM' =>
             array (
                 'code' => '260',
                 'name' => 'ZAMBIA',
             ),
         'ZW' =>
             array (
                 'code' => '263',
                 'name' => 'ZIMBABWE',
             ),
     );
  } 
}
