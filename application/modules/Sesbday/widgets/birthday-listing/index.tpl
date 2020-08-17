<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbday
 * @package    Sesbday
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-12-20 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbday/externals/styles/styles.css'); ?>
<?php if(empty($this->is_ajax)){ ?>
<div class="sesbday_listing sesbasic_bxs" id="sesbday_listing">
 <?php 
	include_once(APPLICATION_PATH.'/application/modules/Sesbday/widgets/birthday-listing/todays-birthday.tpl');
	include_once(APPLICATION_PATH.'/application/modules/Sesbday/widgets/birthday-listing/upcoming-birthday.tpl');
	if(!empty($this->laterBirthday['data']) && count($this->laterBirthday['data']))
		include_once(APPLICATION_PATH.'/application/modules/Sesbday/widgets/birthday-listing/later-birthday.tpl'); 
	?>

	  <?php } ?>	
	<section class="sesbday_month_section">
  	<div class="sesbday_listing_head">
	<?php 
		$month=(int)$this->comingBirthday['date'];
		$month_names=array('','January','February','March','April','May','June','July','August','September','October','November','December');
	?>
		<span id="monthName<?php echo $month; ?>">
			
			<?php	
				echo $month_names[$month];
			?>
		</span>
		<span id="startMonth" style="display:none;"><?php echo date('m',strtotime("-1 month",time()));?></span>
	</div>
    <div class="sesbday_listing_content sesbday_listing_thumbs">
	<span>
		<?php	
				$counter = 1;
				$countBirthday = count($this->comingBirthday['data']);
				$namestr = "";
				$seprator = " , ";
				if($countBirthday == 2)
					$seprator = " and ";
				foreach($this->comingBirthday['data'] as $birthdayData)
				{
					$namestr .="<a href=".$birthdayData->getHref().">".$birthdayData->getTitle()."</a> ".$seprator;
					if($counter == 2)
					{
						break;
					}
					$counter++;
				}
				
				if(!$countBirthday){ ?>
					<div class="tip">
						<span><?php echo $this->translate("No user has birthday in this month."); ?></span>
					</div>
				<?php
				}else{ ?>
					<div class="sesbday_members_list">
				<?php
					if($namestr){
						$namestr =  trim($namestr,' , ');
						if($countBirthday == 2)
						$namestr =  substr($namestr,0,strlen-3);
						echo $namestr;
						
					}
					if($countBirthday > 2){ ?>
						<?php echo $this->translate(array('and %s other ', 'and %s others ', $countBirthday - 2), $this->locale()->toNumber($countBirthday - 2)); ?>
					<?php	
					}
				}				
		?>
    </div>
		
		</span>
    	<?php if(count($this->comingBirthday['data'])) { ?>
    	<ul id="birthdays">
	

		<?php foreach($this->comingBirthday['data'] as $birthdayData) { 
			 
			if($birthdayData->getIdentity())
			{
		?>
			<li class="_item sesbasic_clearfix">
				<a href="<?php echo $birthdayData->getHref(); ?>"><span class="bg_item_photo" style="background-image:url(<?php echo $birthdayData->getPhotoUrl(); ?>); ?>"></span></a>
				 <p><?php echo $birthdayData->getTitle()." (".(int)date('m',strtotime($birthdayData['value']))."/".(int)date('d',strtotime($birthdayData['value'])).")";?></p> 
			</li>
		<?php
			}
			} 
		?>
		</ul>
    	<?php } ?>
    </div>

	
  </section>
   <div class="sesbasic_load_btn" id="view_more_container">
      <a href="javascript:void(0);" class="sesbasic_animation sesbasic_link_btn sesbday_view_more_cnt" id="view_more<?php echo $this->comingBirthday['date'];?>" onclick="showMore('<?php echo $this->comingBirthday['date'];?>',this)"><i class="fa fa-repeat"></i><span><?php echo $this->translate('View More');?></span></a>
    </div>  
	<?php if(empty($this->is_ajax)){ ?>
</div>
<script>
    window.addEvent('load', function() {
        sesJqueryObject(window).scroll( function() {
            var heightOfContentDiv = sesJqueryObject('#sesbday_listing').offset().top;
            var fromtop = sesJqueryObject(this).scrollTop();
            if(fromtop > heightOfContentDiv - 100 && sesJqueryObject('#view_more_container').css('display') == 'block' ){
                sesJqueryObject('.sesbday_view_more_cnt').trigger('click');
            }
        });
    });

var requestTab;
	function showMore(date,obj)
	{
		sesJqueryObject(obj).html("<img src='application/modules/Core/externals/images/loading.gif'>");
		//view_more_container
		var startMonth = parseInt(sesJqueryObject("#startMonth").html());
		var nextMonth = date < 12 ? parseInt(date)+1 : 1;
		if(typeof requestTab != 'undefined'){
			requestTab.cancel();
		}
        requestTab = (new Request.HTML({
		  method: 'post',
		  'url': en4.core.baseUrl + 'widget/index/mod/sesbday/name/birthday-listing',
		  'data': {
			comingBirthday: nextMonth,
			is_ajax : 1,
			
		  },
		  onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {			  
			  sesJqueryObject("#sesbday_listing").append(responseHTML);
			  sesJqueryObject("#view_more"+date).parent().remove();
			  if(startMonth==nextMonth)
			  {
				 sesJqueryObject("#view_more_container").hide();				
			  }
		  }
		})).send();
	}

</script>
<?php } ?>

<?php if(!empty($this->is_ajax)){  die; } ?>
