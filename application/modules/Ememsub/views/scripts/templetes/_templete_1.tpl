<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js'); ?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespagepackage/externals/styles/styles.css'); ?>
<?php //$this->form->getPackagesDetails(); ?>


<form method="post" action="<?php echo $this->escape($this->form->getAction()) ?>"
      class="global_form" enctype="application/x-www-form-urlencoded">
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
            <?php if($this->price_header):?>
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
            <?php if($this->description_header):?>
        <div class="sespagebuilder_pricing_table_hint" style="background-color:#<?php echo $column->column_color?>;color:#<?php echo $column->column_text_color;?>;height:<?php echo $this->tableDescriptionHeight?>px;">
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
          <li class="sesbasic_custom_scroll" style="height:<?php echo $this->tableRowHeight;?>px; background-color:#<?php echo $column->column_row_color;?>">
            <?php if($column->$fileIdColumn):?>
        <img src="<?php echo Engine_Api::_()->storage()->get($column->$fileIdColumn)->getPhotoUrl(); ?>"  align="middle" />
            <?php endif;?>
            <?php if($column->$descriptionColumn):?><i class="fa fa-question-circle sespagebuilder_custom_tip_show sespagebuilder_custom_tip_show" title="<?php echo $column->$descriptionColumn;?>"></i><?php endif;?>
            <span style="color:#<?php echo $column->column_row_text_color;?>"><?php echo $column->$textColumn;?></span>	
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

</form>

<!--<form method="post" action="<?php //echo $this->escape($this->form->getAction()) ?>" class="" enctype="application/x-www-form-urlencoded" id="signup" name="signup">
  <div class="sespage_packages_main sesbasic_clearfix sesbasic_bxs">
  	<div class="sespage_packages_main_header">
      <h2><?php //echo $this->translate("Choose A Package")?></h2>
      <p><?php //echo $this->translate('Select a package that suits you most to start creating pages on this website.');?></p>
    </div>
    <div class="sespage_packages_table_container">
      <ul class="sespage_packages_table" id="package">
        <li class="sespage_packages_table_item">
          <section>
              <div class="_title sesbasic_clearfix">
              <h5></h5>
                <span></span>
                <span><?php //echo $this->translate("FREE"); ?></span>
            </div>
            <div class="_cont">
              <ul class="package_capabilities">
                <li class="sesbasic_clearfix ">
                    <span class="_label">Featured</span>
                  <span class="_value"><i class="_icon"></i></span>
                </li>
                <li class="sesbasic_clearfix">
                    <span class="_label">Sponsored</span>
                    <span class="_value"><i class="_icon "></i></span>
                </li>
                <li class="sesbasic_clearfix ">
                    <span class="_label">Verified</span>
                    <span class="_value"><i class="_icon"></i></span>
                </li>
                <li class="sesbasic_clearfix ">
                    <span class="_label">Hot</span>
                    <span class="_value"><i class="_icon "></i></span>
                </li>
                <li class="sesbasic_clearfix">
                  <span class="_label"><?php //echo $this->translate('Background Photo');?></span>
                  <span class="_value"><i class="_icon "></i></span>
                </li>
                <li class="sesbasic_clearfix">
                  <span class="_label"><?php //echo $this->translate('Main Photo');?></span>
                  <span class="_value"><i class="_icon "></i></span>
                </li>
                <li class="sesbasic_clearfix">
                  <span class="_label"><?php //echo $this->translate('Cover Photo');?></span>
                  <span class="_value"><i class="_icon "></i></span>
                </li>
                <li class="sesbasic_clearfix">
                  <span class="_label"><?php //echo $this->translate('Select Design Layout');?></span>
                  <span class="_value"><i class="_icon "></i></span>
                </li>
              </ul>
            </div>
            <input type="radio" name="package_id" id="package_id_1" value="1">
            <div id="submit-wrapper" class="form-wrapper">
              <div id="submit-label" class="form-label">&nbsp;</div>
              <div id="submit-element" class="form-element">
                <button name="btn" id="1" onclick="submitForm(this.id)"><?php //echo $this->translate('Continue'); ?></button>
              </div>
            </div>
          </section>
        </li>   
      </ul>
		</div>
  </div> 
</form>-->
<script>
//   var packages = JSON.parse('<?php //echo $this->form->getPackagesDetails(); ?>'.replace(/(\r\n|\n|\r)/gm, ""));
//   en4.core.runonce.add(function()
//   { 
//     for(packages in )
//   });
</script>
<script type="text/javascript">
  function submitForm($id)
  {
    sesJqueryObject("#package_id").val($id);
    sesJqueryObject("signup").submit();
  }
</script>
 
