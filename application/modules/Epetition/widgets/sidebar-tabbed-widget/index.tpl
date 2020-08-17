<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php
$viewer = Engine_Api::_()->user()->getViewer();
$viewer_id=$viewer->getIdentity();
if(!empty($viewer_id)) {
  $setting = Engine_Api::_()->getApi('settings', 'core');
    ?>

  <ul class="sidebar-tabbed-ul">
      <li class="sidebar-tabbed-li dashboard"><a  href="javaScript:void(0)" onclick="redirectfunction('petitions/dashboard/edit/<?php echo $this->slug_url; ?>')"><?php  echo $this->translate('Dashboard'); ?></a></li>
      <li class="sidebar-tabbed-li create"><a onclick="redirectfunction('petitions/create')" href="javaScript:void(0)"><?php  echo $this->translate('Create Petition'); ?></a></li>
      <li class="sidebar-tabbed-li Signature"><a id="signpopup" href="javaScript:void(0)"><?php  echo $this->translate('Signature'); ?></a></li>
  </ul>

<?php }  ?>

<script>
    function redirectfunction(lasturl)
    {
        window.location.href = en4.core.baseUrl+lasturl;
    }
    sesJqueryObject("#signpopup").click(function () {
        var url=en4.core.baseUrl+"epetition/index/popsignpetition?id=<?php echo $this->epetition_id; ?>";
        opensmoothboxurl(url);
    });
</script>
