<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php 
$this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesjob/externals/styles/styles.css'); 
?>

<div class="sesjob_company_view">
<div class="sesjob_comp_pic"><?php echo $this->htmlLink($this->company->getHref(), $this->itemPhoto($this->company)); ?></div>
<div class="sesjob_comp_info sesbasic_bg"> <span><?php echo $this->company->company_name; ?></span>
  <div class="sesjob_company_view_web"> <a href="<?php echo $this->company->company_websiteurl; ?>"><span><?php echo $this->translate('<i class="fa fa-globe sesbasic_text_light"></i>'); ?></span><?php echo $this->company->company_websiteurl; ?></a> <span title="<?php echo $this->translate(array('%s subscriber', '%s subscribers', $this->company->subscribe_count), $this->locale()->toNumber($this->company->subscribe_count)); ?>"><i class="fa fa-check-square-o  sesbasic_text_light"></i><?php echo $this->company->subscribe_count; ?></span> 
    <?php if($this->company->industry_id) { ?>
  <?php $industry = Engine_Api::_()->getItem('sesjob_industry', $this->company->industry_id); ?>
  <?php if($industry) { ?>
  <div class="sesjob_view_ind_type"> <span><?php echo $this->translate('Industry Type: '); ?></span><?php echo $industry->industry_name; ?> </div>
  <?php } ?>
  </div>
  <!--Subscribe Button-->
    <?php if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.subscription', 0) && !empty($this->viewer_id) && $this->company->owner_id != $this->viewer_id): ?>
    <a class="sesjob_company_unsubscribe" id="<?php echo $this->company->getType(); ?>_unsubscribe_<?php echo $this->company->getIdentity(); ?>" style ='display:<?php echo $this->isCpnysubscribe ? "inline-block" : "none" ?>' href = "javascript:void(0);" onclick = "cpnySubscribe('<?php echo $this->company->getIdentity(); ?>', '<?php echo $this->company->getType(); ?>');" title="<?php echo $this->translate("UnSubscribe") ?>"><i class="fa fa-times"></i> <?php echo $this->translate("UnSubscribe") ?></a> <a class="sesjob_company_subscribe" id="<?php echo $this->company->getType(); ?>_subscribe_<?php echo $this->company->getIdentity(); ?>" style ='display:<?php echo $this->isCpnysubscribe ? "none" : "inline-block" ?>' href = "javascript:void(0);" onclick = "cpnySubscribe('<?php echo $this->company->getIdentity(); ?>', '<?php echo $this->company->getType(); ?>');" title="<?php echo $this->translate("Subscribe") ?>"><i class="fa fa-check"></i> <?php echo $this->translate("Subscribe") ?></a>
    <input type="hidden" id="<?php echo $this->company->getType(); ?>_subscribehidden_<?php echo $this->company->getIdentity(); ?>" value='<?php echo $this->isCpnysubscribe ? $this->isCpnysubscribe : 0; ?>' />
    <?php endif; ?>
    <!--Subscribe Button--> 
</div>
<div class="sesjob_company_view_bottom">
 <div class="sesjob_company_view_des"><?php echo $this->company->company_description; ?></div>
  <?php if($this->company->owner_id == $this->viewer_id) { ?>
  <div class="sesjob_view_edit_dis"> <a class="smoothbox" href="<?php echo $this->url(array('module'=>'sesjob', 'controller' => 'company', 'action' => 'edit', 'company_id' => $this->company->company_id), 'default', 'true');?>"><i class="fa fa-edit"></i><?php echo $this->translate('Edit');?></a> <a class="smoothbox" href="<?php echo $this->url(array('module'=>'sesjob', 'controller' => 'company', 'action' => 'enable', 'company_id' => $this->company->company_id), 'default', 'true');?>"><i class="fa fa-ban"></i>
    <?php if($this->company->enable){ ?>
    <?php echo $this->translate('Disable');?>
    <?php } else { ?>
    <?php echo $this->translate("Enable"); ?>
    <?php } ?>
    </a> </div>
   </div>
  <?php } ?>
<?php } ?>
</div>
