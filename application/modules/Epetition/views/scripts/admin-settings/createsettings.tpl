<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: createsettings.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php include APPLICATION_PATH .  '/application/modules/Epetition/views/scripts/dismiss_message.tpl';?>
<script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>  <!-- Ckeditor cdn -->

<div class="settings sesbasic_admin_form">
      <?php   echo $this->form->render(); ?>
</div>


<script>
CKEDITOR.replace('epetcre_enter_guid');
window.onload = function(){
      changeenablecategory();
      changeenabledescriptition();
      changepetitioncreationguidelines();
};
function changepetitioncreationguidelines() 
{
    var values=document.querySelector('input[name="epetcre_cre_guid"]:checked').value;
    if (parseInt(values) == 1)
    {
      document.getElementById("epetcre_enter_guid-wrapper").style.display='block';
    } 
    else
    {
      document.getElementById("epetcre_enter_guid-wrapper").style.display= 'none';
    }
}
function changeenablecategory() 
{
    var values=document.querySelector('input[name="epetcre_enb_category"]:checked').value;
    if (parseInt(values) == 1)
    {
      document.getElementById("epetcre_cat_req-wrapper").style.display='block';
    }
    else
    {
      document.getElementById("epetcre_cat_req-wrapper").style.display='none';
    }
}
function changeenabledescriptition() 
{
    var values=document.querySelector('input[name="epetcre_enb_des"]:checked').value;
    if (parseInt(values) == 1)
    {
      document.getElementById("epetcre_des_req-wrapper").style.display='block';
    }
    else
    {
      document.getElementById("epetcre_des_req-wrapper").style.display='none';
    }
}

</script>
