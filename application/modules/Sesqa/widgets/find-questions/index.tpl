<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesqa/externals/scripts/Picker.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesqa/externals/scripts/Picker.Attach.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesqa/externals/scripts/Picker.Date.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesqa/externals/scripts/Picker.Date.Range.js'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesqa/externals/styles/bootstrap-datepicker.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesqa/externals/styles/datepicker.css'); ?>
<div class="sesqa_find_qa_block sesbasic_bxs">
  <div class="_dayswrapper sesbasic_clearfix">
    <?php if(isset($this->todayActive)):?>
      <div class="_day">
        <a href="<?php echo $this->url(array('action' => 'browse'),'sesqa_general',true);?>?show=today" style="background-color:#<?php echo $this->params['today'];?>;">
          <img src="application/modules/Sesqa/externals/images/today-icon.png">
          <span style="color:#<?php echo $this->params['todayTextColor'];?>"><?php echo $this->translate('SESToday');?></span>
        </a>
      </div>
    <?php endif;?>
    <?php if(isset($this->weekActive)):?>
      <div class="_day">
          <a href="<?php echo $this->url(array('action' => 'browse'),'sesqa_general',true);?>?show=week" style="background-color:#<?php echo $this->params['thisweek'];?>;">
          <img src="application/modules/Sesqa/externals/images/week-icon.png">
          <span style="color:#<?php echo $this->params['thisweekTextColor'];?>"><?php echo $this->translate('SESThis Week');?></span>
        </a>
      </div>
    <?php endif;?>
    <?php if(isset($this->monthActive)):?>
    <div class="_day">
      <a href="<?php echo $this->url(array('action' => 'browse'),'sesqa_general',true);?>?show=month" style="background-color:#<?php echo $this->params['thismonth'];?>;">
      <img src="application/modules/Sesqa/externals/images/calendar-icon.png">
      <span style="color:#<?php echo $this->params['thismonthTextColor'];?>"><?php echo $this->translate('SESThis Month');?></span>
      </a>
    </div>
    <?php endif;?>
    <?php if(isset($this->dateCriteriaActive)):?>
      <div class="_day">
        <input class="choose_date_input" type ="text" id="ses-show-calendar">
        <a href="javascript:;" style="background-color:#<?php echo $this->params['choosedate'];?>;">
          <img src="application/modules/Sesqa/externals/images/calendar-plus-icon.png">
          <span style="color:#<?php echo $this->params['choosedateTextColor'];?>"><?php echo $this->translate('SESChoose Date');?></span>
        </a>
      </div>
    <?php endif;?>
  </div>
  <?php if(isset($this->categoryActive)):?>
    <?php $count = 1;?>
     <?php $countMore = 1;?>
    <div class="_categories">
      <ul>
        <?php foreach($this->categories as $category):?>
          <?php if($count <= $this->params['limit_data']):?>
            <?php if($count == 1):?>
              <ul>
            <?php endif;?>
                <li class="_cat"><a href="<?php echo $this->url(array('action' => 'browse'),'sesqa_general',true);?>?category_id=<?php echo $category->category_id;?>">
                <?php if($category->colored_icon){
                      $str = Engine_Api::_()->getItem('storage_file',$category->colored_icon);
                      if($str){
                 ?>
                	<i><img src="<?php echo $str->getPhotoUrl(); ?>" /></i>
                <?php } } ?>
								<?php if(empty($str)){ ?>
                  <i><img src="application/modules/Sesbasic/externals/images/category.png" alt="" /></i>
                 <?php } ?>
                  <span><?php echo $category->category_name;?></span></a>
                </li>
          <?php else:?>
            <?php if($countMore == 1):?>
              <?php if($this->params['viewMore'] == 'yes'):?>
                <li id="show-more" class="more"><a href="javascript:;" onclick="showMoreLessCategory('more');"><span><?php echo $this->translate('SESMore');?></span><i class="fa fa-caret-down"></i></a></li>
              <?php endif;?>
               </ul>
                <ul id="show_all_cat" style="display:none;">
              <?php endif;?>
              <li class="_cat">
              	<a href="<?php echo $this->url(array('action' => 'browse'),'sesqa_general',true);?>?category_id=<?php echo $category->category_id;?>">
               		<?php if($category->colored_icon){
                      $str = Engine_Api::_()->getItem('storage_file',$category->colored_icon);
                      if($str){
                 ?>
                	<i><img src="<?php echo $str->getPhotoUrl(); ?>" /></i>
                <?php } } ?>
								<?php if(empty($str)){ ?>
                  <i><img src="application/modules/Sesbasic/externals/images/category.png" alt="" /></i>
                <?php } ?>  
                <span><?php echo $category->category_name;?></span></a>
              </li>
              <?php if($count == count($this->categories)):?>
              <?php if($this->params['viewMore'] == 'yes'):?>
                <li id="show-less"  class="more"><a href="javascript:;" onclick="showMoreLessCategory('less');"><span><?php echo $this->translate('SESLess');?></span><i class="fa fa-caret-up"></i></a></li>
              <?php endif;?>
            </ul>
            <?php endif;?>
            <?php $countMore++;?>
          <?php endif;?>
          <?php $count++;?>
        <?php endforeach;?>
      </ul>
    </div>
  <?php endif;?>
</div>
<script>
	sesJqueryObject(document).ready(function(){
		var inputwidth =sesJqueryObject('.choose_date_input').width();
		var pickerposition =(425 - inputwidth);
		var picker = new Picker.Date.Range($('ses-show-calendar'), {
				timePicker: false,
				columns: 2,
				positionOffset: {x: -pickerposition, y: 0}
		});
		var picker2 = new Picker.Date.Range('range_hidden', {
				toggle: $$('#range_select'),
				columns: 2,
				onSelect: function(){
						$('range_text').set('text', Array.map(arguments, function(date){
								return date.format('%e %B %Y');
						}).join(' - '))
				}
		});
	});
  function selectedDateRedirect(){
     var dateRange = sesJqueryObject('#ses-show-calendar').val();
    var explodedData = dateRange.split('-');
    var starttime = explodedData[0];
    var endtime = explodedData[1];
    var url = "<?php echo $this->url(array('action' => 'browse'),'sesqa_general',true);?>"+'?starttime='+starttime+'&endtime='+endtime;
    window.location.href =url;
  }
  
  function showMoreLessCategory(type) {
    if(type == 'less'){
      sesJqueryObject('#show_all_cat').hide();
      sesJqueryObject('#show-more').show();
    }
    else {
      sesJqueryObject('#show_all_cat').show();
      sesJqueryObject('#show-more').hide();
    }
  }
</script>
<style>
  .datepicker .footer button.apply:before{content:"Search";}
  .datepicker .footer button.cancel:before{content:"Cancel";}
</style>