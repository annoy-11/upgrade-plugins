<?php 
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: getshortcode.tpl 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */ 
 ?>
 
 <?php 
  $languageColumn = '';
  $local_language = $this->locale()->getLocale()->__toString();
  if($local_language != 'en' && $local_language != 'en_US') {
    $languageColumn = $local_language.'_';
  }
?>
 
<?php $tableId = $this->table_id;?>
<?php $this->table = Engine_Api::_()->getItem('sespagebuilder_content', $tableId);?>
<?php $this->columns = Engine_Api::_()->getDbtable('pricingtables', 'sespagebuilder')->getPricingTable($tableId);?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespagebuilder/externals/styles/styles.css'); ?>

<div class="sespagebuilder_pricing_table sesbasic_bxs sesbasic_clearfix">
  <p class="sespagebuilder_pricing_table_heading"><?php echo $this->table->title;?></p>
  <p class="sespagebuilder_pricing_table_des"><?php echo $this->table->description;?></p>
  <?php foreach($this->columns as $column):?>
    <div class="sesfp-pt-block<?php if(!empty($column->show_highlight)):?> heighlighted<?php endif;?>" style="width:<?php echo is_numeric($column->column_width) ? $column->column_width.'px' : $this->width ?>; <?php if($column->column_margin):?>margin-left:<?php echo $column->column_margin - 4;?>px;margin-right:<?php echo $column->column_margin;?>px;<?php endif;?>">
      <div>
	<div class="sespagebuilder_pricing_table_title" style="background-color:#<?php echo $column->column_color?>;">
          <?php if(!empty($column->column_name)):?>
	    <span style="color:#<?php echo $column->column_text_color;?>" ><?php echo $column->column_name;?></span>
          <?php endif;?>
          </div>
        <!-- CONTENT -->
        <?php $exploded = explode('0', $this->locale()->toCurrency('0',$column->currency));?>
        <?php if($this->table->price_header):?>
	  <div class="sespagebuilder_pricing_table_content" style="background-color:#<?php echo $column->column_color?>;color:#<?php echo $column->column_text_color;?>">
	    <?php if(!empty($column->currency_value)):?>
	      <p class="price">
        	<sup><?php echo $exploded[0]; ?></sup>
                <span><?php echo $column->currency_value;?></span>
                <?php if($column->currency_duration):?><sub>/&nbsp;<?php echo $column->currency_duration;?></sub><?php endif;?>
              </p>
	    <?php endif;?>
	  </div>
        <?php endif;?>
        <?php if($this->table->description_header):?>
	  <div class="sespagebuilder_pricing_table_hint" style="background-color:#<?php echo $column->column_color?>;color:#<?php echo $column->column_text_color;?>;height:<?php echo $this->table->description_height?>px;">
	    <?php if(!empty($column->column_description)):?>
              <?php echo $column->column_description;?>
	    <?php endif;?>
	  </div>
        <?php endif;?>
        <!-- /CONTENT --> 
        <!-- FEATURES -->
        <ul class="sespagebuilder_pricing_table_features <?php if($column->icon_position):?>iscenter<?php endif;?>">
          <?php $rowCount = $this->table->num_row;
	    $tabs_count = array();
	    for ($i = 1; $i <= $rowCount; $i++) {
	      $tabs_count[] =  $i;
	    } 
	  ?>
	  <?php foreach($tabs_count as $tab):?>
	    <?php $fileIdColumn = 'row'.$tab.'_file_id';?>
	    <?php $descriptionColumn = $languageColumn.'row'.$tab.'_description';?>
	    <?php $textColumn = $languageColumn.'row'.$tab.'_text';?>
	    <li class="sesbasic_custom_scroll" style="height:<?php echo $this->row_height;?>px; background-color:#<?php echo $column->column_row_color;?>">
	      <?php if(isset($column->$fileIdColumn) && $column->$fileIdColumn):?>
		<img src="<?php echo Engine_Api::_()->storage()->get($column->$fileIdColumn)->getPhotoUrl(); ?>"  align="middle" />
	      <?php endif;?>
	      <?php if(isset($column->$descriptionColumn) && $column->$descriptionColumn):?><i class="fa fa-question-circle sespagebuilder_custom_tip_show sespagebuilder_custom_tip_show" title="<?php echo $column->$descriptionColumn;?>"></i><?php endif;?>
	      <?php if(isset($column->$textColumn)):?><span style="color:#<?php echo $column->column_row_text_color;?>"><?php echo $column->$textColumn;?></span><?php endif;?>
	    </li>
	  <?php endforeach;?>
	</ul>
        <!-- /FEATURES --> 

        <!-- PT-FOOTER -->
        <?php $footerURL = (preg_match("#https?://#", $column->text_url) === 0) ? 'http://'.$column->text_url : $column->text_url; ?>
        <div class="sespagebuilder_pricing_table_footer" style="background-color:#<?php echo $column->footer_bg_color?>;color:#<?php echo $column->footer_text_color;?>"> <?php if($column->text_url):?><a href="<?php echo $footerURL;?>" style="color:#<?php echo $column->footer_text_color;?>"><?php echo $column->footer_text;?></a><?php else:?><?php echo $column->footer_text;?><?php endif;?></div>
        <!-- /PT-FOOTER --> 
        <!--PT-Ribion-->
        <?php if($column->show_label):?>
	  <div class="<?php if($column->label_position):?>sespagebuilder_pricing_table_label right<?php else:?>sespagebuilder_pricing_table_label left<?php endif;?>">
	    <?php if($column->label_text):?><div style="color:#<?php echo $column->label_text_color;?>;background-color:#<?php echo $column->label_color;?>;"><?php echo $column->label_text;?></div><?php endif;?>
	  </div>
        <?php endif;?>
        <!--PT-Ribion-->
      </div>
    </div>
  <?php endforeach;?>
</div>
<script type="text/javascript">
/* Tips 4 */
var Tips4 = new Tips($$('.sespagebuilder_custom_tip_show'), {
	className: 'sespagebuilder_custom_tip'
});
</script>
