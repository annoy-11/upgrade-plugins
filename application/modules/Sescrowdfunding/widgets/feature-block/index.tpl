<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<div class="sescf_feature_block sesbasic_bxs sesbasic_clearfix">
  <div class="sescf_feature_block_inner">
  	<div class="feature_inner_blk">
  		<div class="_icon">
  			<img src="application/modules/Sescrowdfunding/externals/images/fund.png"/>
      </div>
  			<h4><?php echo $this->translate("Start A Campaign"); ?></h4>
  			<p><?php echo $this->translate("If you're taking charge of yourself or being a kind soul to a loved one in need. Start a campaign."); ?></p>
        <a href="<?php echo $this->url(array('action' => 'create'), 'sescrowdfunding_general', true); ?>" class="donate_btn"><?php echo $this->translate("Create Crowdfunding"); ?></a>
  	</div>
  	<div class="feature_inner_blk">
  		<div class="_icon">
  			<img src="application/modules/Sescrowdfunding/externals/images/promote.png"/>
      </div>
  			<h4><?php echo $this->translate("Promote Your Campaign"); ?></h4>
  			<p><?php echo $this->translate("Promote Your Campaign with Social Media. Take time and invest in growing your social media presence."); ?></p>
        <a href="<?php echo $this->url(array('action' => 'browse'), 'sescrowdfunding_general', true); ?>" class="donate_btn"><?php echo $this->translate("Browse Crowdfundings"); ?></a>
  	</div>
  	<div class="feature_inner_blk">
  		<div class="_icon">
  			<img src="application/modules/Sescrowdfunding/externals/images/money.png"/>
      </div>
  			<h4><?php echo $this->translate("Raise Maximum Funds"); ?></h4>
  			<p><?php echo $this->translate("Raise funds online for yourself, loved ones, charities and more on world's largest Crowdfunding Network."); ?></p>
        <a href="<?php echo $this->url(array('action' => 'browse'), 'sescrowdfunding_category', true); ?>" class="donate_btn"><?php echo $this->translate("Browse Categories"); ?></a>
  	</div>
  	<div class="feature_inner_blk">
      <span class="uppercase"><?php echo $this->translate("BE USEFUL TO OTHERS"); ?></span>
      <h3><?php echo $this->translate("We help thousands of People"); ?></h3>
      <p><?php echo $this->translate("Our team of volunteers does more than ensuring that each needy should get a chance to get over. Get started with your campaign Today and get funds for it."); ?></p>
  	</div>
  </div>
</div>
