<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesinterest
 * @package    Sesinterest
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-11 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $viewer = Engine_Api::_()->user()->getViewer();
      $subject = Engine_Api::_()->core()->getSubject('user');
      if (empty($this->fieldValueLoop($this->subject(), $this->fieldStructure)) &&
        $subject->getOwner()->isSelf($viewer)) {
        $href = Zend_Registry::get('Zend_View')->url(array(
          'controller' => 'edit',
          'action' => 'profile'
        ),'user_extended',true);
        echo '
           <div class="tip">
             <span>
               '. $this->translate(sprintf("Fill your profile details %1shere%2s.",
                  "<a href='$href'>",
                  "</a>"
                )) .'
             </span>
           </div>';
        return;
      }
      echo $this->fieldValueLoop($this->subject(), $this->fieldStructure)
?>
<div class="sesinterest_profile_info_interest sesbasic_clearfix sesbasic_bxs">
	<ul>
      <?php foreach($this->userinterests as $result) { ?>
        <?php if($result->interest_name == ' ' || empty($result->interest_name)):?>
          <?php continue; ?>
        <?php endif;?>
        <?php $count = Engine_Api::_()->getDbTable('userinterests', 'sesinterest')->isInterestCount(array('userinterest_id' => $result->getIdentity()));  ?>
        <li id="sesinterest_<?php echo $result->getIdentity(); ?>" class="sesbasic_clearfix"><?php echo $result->interest_name ?><?php if(!empty($count)) { ?><sup><?php echo $count; ?></sup><?php } ?><span class="del_int"><a class="sessmoothbox" href="<?php echo $this->url(array('module' => 'sesinterest', 'controller' => 'index', 'action' => 'delete', 'userinterest_id' => $result->getIdentity()), 'default', true); ?>"><i class="fa fa-times"></i></a></span></li>
			<?php } ?>
	</ul>
</div>
