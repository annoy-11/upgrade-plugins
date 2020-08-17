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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesqa/externals/styles/styles.css'); ?>
<div class="sesqa_total_stats sesbasic_bxs">
	<ul>
    <li><a href="<?php echo $this->url(array('action'=>'browse'),'sesqa_general',true);?>"><i class="fa fa-question sesbasic_text_hl"></i> <?php echo $this->translate(array('Question (%s)', 'Questions (%s)',  $this->totalQuestion), $this->locale()->toNumber( $this->totalQuestion));?> </a> </li>
    <li><a href="<?php echo $this->url(array('action'=>'browse'),'sesqa_general',true);?>"><i class="fa fa-comments sesbasic_text_hl"></i> <?php echo $this->translate(array('Answer (%s)', 'Answers (%s)',  $this->totalAnswers), $this->locale()->toNumber( $this->totalAnswers));?> </a> </li>
    <li><a href="<?php echo $this->url(array('action'=>'browse'),'sesqa_general',true);?>"><i class="fa fa-star sesbasic_text_hl"></i> <?php echo $this->translate(array('Best Answer (%s)', 'Best Answers (%s)',  $this->totalBestAnswers), $this->locale()->toNumber( $this->totalBestAnswers));?> </a> 	</li>
	</ul>
</div>
