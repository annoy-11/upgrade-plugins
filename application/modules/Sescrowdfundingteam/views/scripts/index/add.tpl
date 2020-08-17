<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfundingteam
 * @package    Sescrowdfundingteam
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: add.tpl  2018-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headScript()->appendFile("https://maps.googleapis.com/maps/api/js?libraries=places&sensor=true"); ?>
<script type="application/javascript">

  en4.core.runonce.add(function() {
    if (document.getElementById('location')) {
      new google.maps.places.Autocomplete(document.getElementById('location'));
    }
  });
  
  <?php if($this->type == 'sitemember') { ?>
    sesJqueryObject(document).on('click','#name',function(e) {
      profileOptionAutoComplete('name', "<?php echo $this->url(array('module' =>'sescrowdfundingteam','controller' => 'index', 'action' => 'get-data', 'crowdfunding_id' => $this->crowdfunding_id),'default',true); ?>");
    });
  <?php } ?>
    
  function addTeam(formObject) {
  
    var validateTeamForm = validateTeamform();
    
    if(validateTeamForm) {
      
      var input = sesJqueryObject(formObject);
      alert('<?php echo $this->translate("Please fill the red mark fields"); ?>');
      if(typeof objectError != 'undefined') {
        var errorFirstObject = sesJqueryObject(objectError).parent().parent();
          sesJqueryObject('html, body').animate({
          scrollTop: errorFirstObject.offset().top
        }, 2000);
      }

      return false;
    } else {
      submitCompliment(formObject);
    }
  }

  function submitCompliment(formObject) {
  
    sesJqueryObject('#sescrowdfundingteam_team_overlay').show();
    var formData = new FormData(formObject);
    formData.append('is_ajax', 1);
    formData.append('crowdfunding_id', '<?php echo $this->crowdfunding_id ?>');
    formData.append('type', '<?php echo $this->type ?>');
    sesJqueryObject.ajax({
      url: "sescrowdfundingteam/index/add/",
      type: "POST",
      contentType:false,
      processData: false,
      cache: false,
      data: formData,
      success: function(response) {
      
        var result = sesJqueryObject.parseJSON(response);
        if(result.status == 1) {
        
          sesJqueryObject('#sescrowdfundingteam_team_overlay').hide();
          sesJqueryObject('#sessmoothbox_container').html("<div id='teamsuccess_message' class='sescrowdfundingteam_success_message teamsuccess_message'><i class='fa-check-circle-o'></i><span>Your team is successfully added.</span></div>");

          sesJqueryObject('#teamsuccess_message').fadeOut("slow", function(){
            setTimeout(function() {
              sessmoothboxclose();
            }, 1000);
          });
//           if(sesJqueryObject('#team_count').length) {
//             sesJqueryObject('#team_count').html(result.count);
//           }
          if(sesJqueryObject('#sescrowdfundingteam_teams').length) {
            if(sesJqueryObject('#team_tip').length)
              sesJqueryObject('#team_tip').hide();
            sesJqueryObject('#sescrowdfundingteam_teams').show();
            sesJqueryObject('#sescrowdfundingteam_teams').html(result.message);
          }
        }
      }
    });
  }

</script>
<div class="sescrowdfunding_dashboard_create_popup sescrowdfunding_add_team_popup sesbasic_bxs">
  <div class="sesbasic_loading_cont_overlay" id="sescrowdfundingteam_team_overlay"></div>
  <?php if(empty($this->is_ajax) ) { ?>
    <?php echo $this->form->render($this);?>
  <?php } ?>
</div>
