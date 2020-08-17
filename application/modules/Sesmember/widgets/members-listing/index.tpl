<?php

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesmember/externals/styles/styles.css'); ?>

<?php $alphabets = array('A' => 'A','B' => 'B','C' => 'C','D' => 'D','E' => 'E','F' => 'F','G' => 'G','H' => 'H','I' => 'I','J' => 'J','K' => 'K','L' => 'L','M' => 'M','N' => 'N','O' => 'O','P' => 'P','Q' => 'Q','R' => 'R','S' => 'S','T' => 'T','U' => 'U','V' => 'V','W' => 'W','X' => 'X','Y' => 'Y','Z' => 'Z'); ?>

<div class="iwr_members_listing_main sesbasic_bxs">
	<section class="filter_section">
    <div class="section_heading"><span class="_title"><?php echo $this->translate("Profile Directory Listings"); ?></span></div>
    <div class="alf_filters" id="alf_filters">
      <ul class="search_directory">
        <?php foreach($alphabets as $key => $alphabet) { ?>
          <li><a href="member/alphabetic-members-search/#list<?php echo $key ?>"><?php echo $this->translate($alphabet); ?></a></li>
        <?php } ?>
        <li><a href="#list0-9">0-9</a></li>
      </ul>
    </div>
  </section>
  <?php foreach($alphabets as $key => $alphabet) { ?>
    <section class="user_section">
      <div class="section_heading sesbasic_clearfix" id="list<?php echo $key ?>">
      	<span class="_title"><?php echo $this->translate($alphabet); ?></span>
      	<span class="_link"><a href="member/alphabetic-members-search/#alf_filters">&uarr; <?php echo $this->translate("Back to top");?></a></span>
      </div>
      <?php $members = Engine_Api::_()->getDbTable('members', 'sesmember')->getMemberSelect(array('alphbetorder' => $alphabet, 'fetchAll' => 1)); ?>
      <?php include APPLICATION_PATH .  '/application/modules/Sesmember/views/scripts/_profile_directory_listing.tpl'; ?>
    </section>
  <?php } ?>
</div>
