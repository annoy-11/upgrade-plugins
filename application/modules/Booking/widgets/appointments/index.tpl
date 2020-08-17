<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Booking
 * @package    Booking
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-19 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Booking/externals/styles/styles.css'); ?>

<?php if(!$this->is_ajax){ if($this->tab_option == 'default'){ ?>
  <!--Default Tabs-->
  <div class="layout_core_container_tabs">
    <div class="tabs_alt tabs_parent" <?php if(count($this->defaultOptions) ==1){ ?> style="display:none" <?php } ?>>
<?php } ?>
<!--Advance Tabs-->
<?php if($this->tab_option == 'advance'){ ?>
  <div class="sesbasic_tabs_container sesbasic_clearfix sesbasic_bxs">
    <div class="sesbasic_tabs sesbasic_clearfix" <?php if(count($this->defaultOptions) ==1){ ?> style="display:none" <?php } ?>>
<?php } ?>
<!--Filter Tabs-->
<?php if($this->tab_option == 'filter'){ ?>
  <div class="sesbasic_filter_tabs_container sesbasic_clearfix sesbasic_bxs">
    <div class="sesbasic_filter_tabs sesbasic_clearfix" <?php if(count($this->defaultOptions) ==1){ ?> style="display:none" <?php } ?>>
<?php } ?>
<!--Vertical Tabs-->
<?php if($this->tab_option == 'vertical'){ ?>
  <div class="sesbasic_v_tabs_container sesbasic_clearfix sesbasic_bxs">
		<div class="sesbasic_v_tabs sesbasic_clearfix" <?php if(count($this->defaultOptions) ==1){ ?> style="display:none" <?php } ?>>
<?php } ?>
  <ul id="tab-widget-sesevent">
    <?php 
    foreach($this->defaultOptions as $key=>$valueOptions){ 
    ?>
  		<li <?php if($this->defaultOpenTab == $key){ ?>class="active"<?php } ?> id="sesTabContainer_<?php echo $key; ?>">
  			<a href="javascript:;" data-src="<?php echo $key; ?>" onclick="changeTabSes('<?php echo $key; ?>')"><?php echo $this->translate(($valueOptions)); ?></a>
  		</li>
  	<?php } ?>
  </ul>
</div>
<div class="sesbasic_tabs_content sesbasic_clearfix" id="appointmentData">
<?php } ?>
	<?php if($this->is_ajax){  ?>
  	<div class="sesapmt_myappointments_list"><?php include APPLICATION_PATH . '/application/modules/Booking/views/scripts/_appointments.tpl'; ?></div>
   <?php } ?> 
   <?php if(!$this->is_ajax){ ?>
</div>

<script>
    var hash = window.location.hash;
    var active =hash.replace("#","");
    var appointmentType=(hash) ? active : "<?php echo $this->defaultOpenTab; ?>";
    en4.core.runonce.add(function() {
        changeTabSes(appointmentType)
    });
    function changeTabSes(appointmentType){
        sesJqueryObject("#appointmentData").html("<div class='appointment_load sesbasic_loading_container'></div>");
        <?php foreach($this->defaultOptions as $key => $tabs){ ?>
        if(appointmentType=="<?php echo $key; ?>"){
            <?php if($key=="given" || $key=="taken" || $key=="cancelled" || $key=="completed" || $key=="reject"){ ?>
        sesJqueryObject("#sesTabContainer_<?php echo $key; ?>").addClass("active");
            <?php }if($key!="given" || $key!="taken" || $key!="cancelled" || $key!="completed" || $key!="reject"){ foreach($this->defaultOptions as $keys => $tabs){ if($keys!=$key){ ?>
        sesJqueryObject("#sesTabContainer_<?php echo $keys; ?>").removeClass("active"); <?php }}} ?>
        }
        <?php } ?>
        (new Request.HTML({
        method: 'post',
        'url': en4.core.baseUrl + "widget/index/mod/booking/name/appointments",
        'data': {
          format: 'html',
          is_ajax:1,
          appointmentType:appointmentType,
        },
        onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
            sesJqueryObject("#appointmentData").html(responseHTML);
            return true;
            }
        })).send();
    }
</script>
<?php } ?>