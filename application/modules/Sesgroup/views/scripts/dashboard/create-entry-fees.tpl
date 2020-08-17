<?php
echo $this->partial('dashboard/left-bar.tpl', 'sesgroup', array(
	'group' => $this->group,
      ));	
?>
<div class="sesgroup_dashboard_content sesbm sesbasic_clearfix">
  <div class="sesgroup_dashboard_form">
<?php echo $this->form->render($this) ?>
  </div>
</div>
<script type="application/javascript">
sesJqueryObject('#currency').hide();
sesJqueryObject('#currency-wrapper').hide();

<?php if(Engine_Api::_()->egroupjoinfees()->isMultiCurrencyAvailable()){ ?>
	sesJqueryObject('#entry_fees-element').append('<span class="fa fa-retweet sesgroup_convert_icon sesbasic_link_btn" id="sesgroup_currency_coverter" title="<?php echo $this->translate("Convert to %s",Engine_Api::_()->getApi("settings","core")->getSetting("sesmultiplecurrency.defaultcurrency","USD"));?>"></span>');
	sesJqueryObject('#entry_fees-label').append('<span> (<?php echo Engine_Api::_()->getApi("settings","core")->getSetting("sesmultiplecurrency.defaultcurrency","USD"); ?>)</span>');
<?php }else{ ?>
	sesJqueryObject('#entry_fees-label').append('<span> (<?php echo Engine_Api::_()->egroupjoinfees()->defaultCurrency(); ?>)</span>');
<?php } ?>

</script>
