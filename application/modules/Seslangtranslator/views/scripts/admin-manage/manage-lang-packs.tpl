<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslangtranslator
 * @package    Seslangtranslator
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage-lang-packs.tpl 2017-08-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Seslangtranslator/views/scripts/dismiss_message.tpl';?>

<h3><?php echo $this->translate("Manage Language Packs") ?></h3>

<p>
  <?php echo $this->translate('The layout of your community includes hundreds of phrases of text which are stored in a language pack. And this page list down all the language packs on your website which you have created from the Language Manager or this plugin. <br />
You can download or delete these packs from below and edit phrases in each pack from the Language Manager. You can also create new language pack for selected plugin’s csv files in selected language by clicking on “Create New Pack” link, which will redirect you to Manage Language Translations section.
') ?>
</p>
<br />
<script type="text/javascript">
  var changeDefaultLanguage = function(locale) {
    var url = '<?php echo $this->url(array('module'=>'core','controller'=>'language','action'=>'default')) ?>';

    var request = new Request.JSON({
      url : url,
      data : {
        locale : locale,
        format : 'json'
      },
      onComplete : function() {
        window.location.replace( window.location.href );
      }
    });
    request.send();
  }
</script>
<div class="admin_language_options">
  <a href="<?php echo $this->url(array('action' => 'index')) ?>" class="buttonlink admin_language_options_new"><?php echo $this->translate("Create New Pack") ?></a>
</div>

<br />

<table class="admin_table admin_languages">
  <thead>
    <tr>
      <th><?php echo $this->translate("Language") ?></th>
      <th><?php echo $this->translate("Options") ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach( $this->languageNameList as $locale => $translatedLanguageTitle ): ?>
      <tr>
        <td>
          <?php echo $translatedLanguageTitle ?>
        </td>
        <td class="admin_table_options">
          <a target="_blank" href="<?php echo $this->url(array('module' => 'core', "controller" => 'language', 'action' => 'edit', 'locale' => $locale)) ?>"><?php echo $this->translate("Edit Phrases") ?></a>
          | <a href="<?php echo $this->url(array('module' => 'core', "controller" => 'language', 'action' => 'export', 'locale' => $locale)) ?>"><?php echo $this->translate("Download") ?></a>
          <?php if( $this->defaultLanguage != $locale ): ?>
            | <?php echo $this->htmlLink(array('module'=>'core','controller'=>'language','action'=>'delete',  'locale'=>$locale), $this->translate('Delete'), array('class'=>'smoothbox')) ?>
          <?php else: ?>
            | <?php echo $this->translate("default") ?>
          <?php endif; ?>
          
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>