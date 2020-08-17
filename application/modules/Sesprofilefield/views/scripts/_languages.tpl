<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _languages.tpl  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $viewer_id = $this->viewer_id; ?>
<?php foreach($this->languages as $language) { ?>
  <li id="sesprofilefield_language_<?php echo $language->language_id; ?>">
    <div class="language_details_main">
      <div class="language_details">
        <p class="language_name"><?php echo $language->languagename; ?></p>
        <p class="date">
          <?php if($language->proficiency) { ?>
            <span>
            <?php if($language->proficiency == 1) { ?>
              <?php echo $this->translate('Elementary proficiency'); ?>
            <?php } elseif($language->proficiency == 2) { ?>
              <?php echo $this->translate('Limited working proficiency'); ?>
            <?php } elseif($language->proficiency == 3) { ?>
              <?php echo $this->translate('Professional working proficiency'); ?>
            <?php } elseif($language->proficiency == 4) { ?>
              <?php echo $this->translate('Full professional proficiency'); ?>
            <?php } elseif($language->proficiency == 5) { ?>
              <?php echo $this->translate('Native or bilingual proficiency'); ?>
            <?php } ?>
            </span>
          <?php } ?>
        </p>
      </div>
      <div class="field_option">
        <?php if($viewer_id == $language->user_id) { ?>
      <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesprofilefield', 'controller' => 'index', 'action' => 'edit-language', 'language_id' => $language->language_id), $this->translate(''), array('class' => 'sessmoothbox fa fa-pencil')); ?>
      <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesprofilefield', 'controller' => 'index', 'action' => 'delete-language', 'language_id' => $language->language_id), $this->translate('	'), array('class' => 'sessmoothbox fa fa-trash')); ?>
    <?php } ?>
      </div>
    </div>
  </li>
<?php } ?>
