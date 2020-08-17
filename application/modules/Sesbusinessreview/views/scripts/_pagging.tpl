<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessreview
 * @package    Sesbusinessreview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _pagging.tpl  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if ($this->businessCount && $this->businessCount > 1):$numBusinesses = $this->businessCount;?>
 <?php 
 if(isset($this->identityWidget)){
 	$idFunction = 'paggingNumber'.$this->identityWidget;
 }else
 	$idFunction = 'paggingNumber';  
 ?>
<div id="ses_pagging_<?php echo $this->identityWidget?>">
  <div class="sesbasic_loading_cont_overlay" style="display:none" id="sesbasic_loading_cont_overlay_<?php echo $this->identityWidget?>"></div>
  <div class="sesbasic_paging clear sesbasic_clearfix sesbasic_bxs" id="ses_pagging">
    <ul>
      <li style="display:none;"><span><?php echo $this->current; ?> of <?php echo $this->businessCount; ?></span></li>
      <?php if (isset($this->previous)): ?>
	<li><a href="javascript:;" onclick="<?php echo $idFunction ?>('<?php echo $this->previous; ?>')"  title="<?php echo $this->previous; ?>"> <?php echo $this->translate('Previous') ?></a></li>
      <?php else: ?>
	<li class="sesbasic_paging_disabled"><span><?php echo $this->translate('Previous') ?></span></li>
      <?php endif; ?>
      <?php 
      $pagingEcho = '';
      $selectBusinessNum = $this->current;
      for($runBusiness=1;$runBusiness<=$numBusinesses;$runBusiness++){
	  if($selectBusinessNum == $runBusiness){
	    $pagingEcho .= "<li class=\"sesbasic_paging_current_business\"><a href=\"javascript:;\">".$runBusiness."</a></li>";
	  }else{
	    $pagingEcho .= "<li class=\"businesses\"><a href=\"javascript:;\" onclick=\"".$idFunction."(".$runBusiness.")\">".$runBusiness."</a></li>";
	  }
	  if($runBusiness < ($selectBusinessNum - 3) && ($runBusiness+3) < $numBusinesses){
	    $pagingEcho .= "<li class=\"sesbasic_paging_disabled\"><span>[&sdot;&sdot;&sdot;]</span></li>";
	    $runBusiness = $selectBusinessNum - 3;
	  }
	  if($runBusiness > ($selectBusinessNum + 2) && ($runBusiness+2) < $numBusinesses){
	    $pagingEcho .= "<li class=\"sesbasic_paging_disabled\"><span>[&sdot;&sdot;&sdot;]</span></li>";
	    $runBusiness = $numBusinesses-1;
	  }
      }
	echo $pagingEcho;
      ?>
      <?php if (isset($this->next)): ?>
	<li><a href="javascript:;" onclick="<?php echo $idFunction ?>('<?php echo $this->next; ?>')"  title="<?php echo $this->next; ?>"> <?php echo $this->translate('Next') ?> </a> </li>
      <?php else: ?>
	<li class="sesbasic_paging_disabled"><span><?php echo $this->translate('Next') ?></span></li>
      <?php endif; ?>
    </ul>
  </div>
</div>
<?php endif; ?>