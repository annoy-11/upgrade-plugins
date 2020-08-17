<?php

/**
 */
 
 ?>
<?php $allParams = $this->allParams; ?>
<?php
	$baseUrl = $this->layout()->staticBaseUrl;
	$this->headLink()->appendStylesheet($baseUrl . 'application/modules/Sespawsnclaws/externals/styles/styles.css');
?>
<div class="sespawsnclaws_counters_section_wrapper sesbasic_bxs sespawsnclaws_section_spacing" style="background-image:url(<?php echo $this->backgroundimage; ?>);">
  <div class="sespawsnclaws_counters_section sespawsnclaws_section_container">
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
  </div>
</div>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sespawsnclaws/externals/scripts/jquery.min.js'); ?>
<script type="text/javascript">
    counterpawsnclaws(document).ready(function($) {
        $('.counter').counterUp({
            delay: 10,
            time: 1000
        });
    });
</script>
<?php  $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sespawsnclaws/externals/scripts/waypoints.min.js'); ?>
<?php  $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sespawsnclaws/externals/scripts/jquery.counterup.min.js'); ?>


