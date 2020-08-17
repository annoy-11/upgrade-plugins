<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<ul>
  <?php foreach( $this->gutterNavigation as $link ): $class = explode(' ', $link->class); ?>
    <?php if(end($class) == 'edocument_gutter_download' && $this->subject->download) {  ?>
      <li>
        <a href="https://drive.google.com/uc?id=<?php echo $this->subject->file_id_google; ?>&export=download" class="buttonlink buttonlink icon_edocument_download menu_edocument_gutter edocument_gutter_download" style="" target=""><?php echo $this->translate("Download Document"); ?></a>
      </li>
    <?php } else { ?>
      <li>
        <?php echo $this->htmlLink($link->getHref(), $this->translate($link->getLabel()), array(
          'class' => 'buttonlink' . ( $link->getClass() ? ' ' . $link->getClass() : '' ),
          'style' => $link->get('icon') ? 'background-image: url('.$link->get('icon').');' : '',
          'target' => $link->get('target'),
        )) ?>
      </li>
    <?php } ?>
  <?php endforeach; ?>
</ul>
