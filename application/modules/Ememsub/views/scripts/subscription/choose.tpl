<?php
/**
 * SocialEngine
 *
 * @category   Application_Core
 * @package    Payment
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: choose.tpl 9747 2012-07-26 02:08:08Z john $
 * @author     John Boehr <j@webligo.com>
 */
?>

<?php
  	$templeteId = Engine_Api::_()->getDbTable('templates','Snsmemsub')->getSelectedTempleteId();
    include_once APPLICATION_PATH."/application/modules/Snsmemsub/views/scripts/templetes/_templete".$templeteId.".tpl";
?>
