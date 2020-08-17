<?php

/**
 */
 
 ?>
<?php $allParams = $this->allParams; ?>
<?php
	$baseUrl = $this->layout()->staticBaseUrl;
	$this->headLink()->appendStylesheet($baseUrl . 'application/modules/Seslandingpage/externals/styles/styles.css');
?>
<div class="seslp_section_spacing sesbasic_bxs seslp_counters_container" style="background-image:url(<?php echo Engine_Api::_()->seslandingpage()->getFileUrl($this->backgroundimage); ?>);">
  <div class="seslp_blocks_container seslp_counters_section">
    <?php if($allParams['counter1'] && $allParams['counter1text']) { ?>
      <div class="counter_item">
        <span class="_value"> 
          <span class="counter"><?php echo str_replace('+','',$allParams['counter1']); ?></span>
          <?php if(strpos($allParams['counter1'],'+') !== false ){ ?>
            <span class="counterplus">+</span>
          <?php } ?>
        </span>
        <span class="_title"><?php echo $allParams['counter1text']; ?></span>
      </div>
     <?php } ?>
    <?php if($allParams['counter2'] && $allParams['counter2text']) { ?>
      <div class="counter_item">
      	<span class="_value">
          <span class="counter"><?php echo str_replace('+','',$allParams['counter2']); ?></span>
          <?php if(strpos($allParams['counter2'],'+') !== false ){ ?>
            <span class="counterplus">+</span>
          <?php } ?>
        </span>
        <span class="_title"><?php echo $allParams['counter2text']; ?></span>
      </div>
     <?php } ?>
    <?php if($allParams['counter3'] && $allParams['counter3text']) { ?>
      <div class="counter_item">
      	<span class="_value">
          <span class="counter"><?php echo str_replace('+','',$allParams['counter3']); ?></span>
          <?php if(strpos($allParams['counter3'],'+') !== false ){ ?>
            <span class="counterplus">+</span>
          <?php } ?>
        </span>  
        <span class="_title"><?php echo $allParams['counter3text']; ?></span>
      </div>
     <?php } ?>
    <?php if($allParams['counter4'] && $allParams['counter4text']) { ?>
      <div class="counter_item">
      	<span class="_value">
          <span class="counter"><?php echo str_replace('+','',$allParams['counter4']); ?></span>
          <?php if(strpos($allParams['counter4'],'+') !== false ){ ?>
            <span class="counterplus">+</span>
          <?php } ?>
        </span>  
        <span class="_title"><?php echo $allParams['counter4text']; ?></span>
      </div>
     <?php } ?>
  </div>
</div>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Seslandingpage/externals/scripts/jquery.min.js'); ?>
<script type="text/javascript">
    counterlandingpage(document).ready(function($) {
        $('.counter').counterUp({
            delay: 10,
            time: 1000
        });
    });
</script>
<?php  $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Seslandingpage/externals/scripts/waypoints.min.js'); ?>
<?php  $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Seslandingpage/externals/scripts/jquery.counterup.min.js'); ?>


