<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _pagging.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>

<?php if ($this->groupCount && $this->groupCount > 1):
				$numGroups = $this->groupCount;
 ?>
 <?php 
 if(isset($this->identityWidget)){
 	$idFunction = 'paggingNumber'.$this->identityWidget;
 }else
 	$idFunction = 'paggingNumber';  
 ?>
 
<div id="ses_pagging_128738hsdkfj" style="width:100%;">
  <div class="sesbasic_loading_cont_overlay" style="display:none"></div>
  <div class="sesbasic_paging clear sesbasic_clearfix sesbasic_bxs" id="ses_pagging">
    <ul>
      <li style="display:none;"><span><?php echo $this->current; ?> of <?php echo $this->groupCount; ?></span></li>
      <?php if (isset($this->previous)): ?>
        <li><a href="javascript:;" onclick="<?php echo $idFunction ?>('<?php echo $this->previous; ?>')"  title="<?php echo $this->previous; ?>"> <?php echo $this->translate('Previous') ?></a></li>
      <?php else: ?>
        <li class="sesbasic_paging_disabled"><span><?php echo $this->translate('Previous') ?></span></li>
      <?php endif; ?>
      <?php 
      $pagingEcho = '';
      $selectGroupNum = $this->current;
      for($runGroup=1;$runGroup<=$numGroups;$runGroup++){
          if($selectGroupNum == $runGroup){
            $pagingEcho .= "<li class=\"sesbasic_paging_current_page\"><a href=\"javascript:;\">".$runGroup."</a></li>";
          }else{
            $pagingEcho .= "<li class=\"pages\"><a href=\"javascript:;\" onclick=\"".$idFunction."(".$runGroup.")\">".$runGroup."</a></li>";
          }
          if($runGroup < ($selectGroupNum - 3) && ($runGroup+3) < $numGroups){
            $pagingEcho .= "<li class=\"sesbasic_paging_disabled\"><span>[&sdot;&sdot;&sdot;]</span></li>";
            $runGroup = $selectGroupNum - 3;
          }
          if($runGroup > ($selectGroupNum + 2) && ($runGroup+2) < $numGroups){
            $pagingEcho .= "<li class=\"sesbasic_paging_disabled\"><span>[&sdot;&sdot;&sdot;]</span></li>";
            $runGroup = $numGroups-1;
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