<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfbstyle
 * @package    Sesfbstyle
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2017-09-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $selectedLanguage = $this->translate()->getLocale(); ?>
<?php if(count($this->languageNameList) > 1){ ?>
	<div class="sesfbstyle_language_chooser sesbasic_bxs">
      <div style="display:none;">
      <?php $selectedLanguage = $this->translate()->getLocale() ?>
        <form method="post" id="sesfb_lan_<?php echo $this->identity; ?>" action="<?php echo $this->url(array('controller' => 'utility', 'action' => 'locale'), 'default', true) ?>" style="display:none;">
          <?php echo $this->formHidden('return', $this->url()) ?>
          <?php echo $this->formHidden('language', $selectedLanguage) ?>
          <input type="submit" id="language_submit_frm_<?php echo $this->identity; ?>" value="Submit">
        </form>
      </div>          
       <a href="javascript:;" class="disabled" ><?php echo $this->languageNameList[$selectedLanguage]; ?></a>          
      <?php 
      $counter = 0;
      foreach($this->languageNameList as $key=>$value){
      if($selectedLanguage == $key)
        continue; 
        if($counter == $this->language_count)
          break;
        $counter++;
      ?>
      <a href="javascript:;" class="lan_selected_<?php echo $this->identity; ?><?php if($key == $selectedLanguage){ ?> disabled<?php } ?>" data-rel="<?php echo $key; ?>" ><?php echo $value; ?></a>
      <?php 
        }
       ?>
       <?php
        if(count($this->languageNameList) > $this->language_count){ ?>
          <a href="javascript:;" class="sesbasic_button _more sessmoothbox" data-url="sesfbstyle/index/language/identity/<?php echo $this->identity; ?>" ><i class="fa fa-plus"></i></a>
        <?php } 
       ?>
  </div>
<?php } ?>
<script type="application/javascript">
sesJqueryObject(document).on('click','.lan_selected_<?php echo $this->identity; ?>',function(){
  var rel = sesJqueryObject(this).data('rel');
  sesJqueryObject('#sesfb_lan_<?php echo $this->identity; ?>').find('#language').val(rel);
  sesJqueryObject('#language_submit_frm_<?php echo $this->identity; ?>').trigger('click');
  if(sesJqueryObject('#sessmoothbox_container').length > 0)
  sessmoothboxclose();
})
</script>