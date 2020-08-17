<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesytube
 * @package    Sesytube
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-02-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $allParams = $this->allParams; ?>
<div class="sesytube_text_block_wrapper">
  <div class="sesytube_text_block sesbasic_bxs">
    <div class="sesytube_text_block_header">
      <?php if($this->htmlheading) { ?>
      <h2><?php echo $this->htmlheading; ?></h2>
      <?php } ?>
      <?php if($this->htmldescription) { ?>
      <p><?php echo $this->htmldescription; ?></p>
      <?php } ?>
    </div>
    <div class="sesytube_text_block_content">
      <ul>
        <?php if($this->htmlblock1title || $this->htmlblock1description) { ?>
          <li>
            <article>
              <?php if($this->htmlblock1title) { ?>
                <div class="_title"><?php echo $this->translate($this->htmlblock1title)?></div>
              <?php } ?>
              <?php if($this->htmlblock1description) { ?>
                <div class="_des"><?php echo $this->translate($this->htmlblock1description)?></div>
              <?php } ?>
            </article>
          </li>
        <?php } ?>
        <?php if($this->htmlblock2title || $this->htmlblock2description) { ?>
          <li>
            <article>
              <?php if($this->htmlblock2title) { ?>
                <div class="_title"><?php echo $this->translate($this->htmlblock2title)?></div>
              <?php } ?>
              <?php if($this->htmlblock2description) { ?>
                <div class="_des"><?php echo $this->translate($this->htmlblock2description)?></div>
              <?php } ?>
            </article>
          </li>
        <?php } ?>
        <?php if($this->htmlblock3title || $this->htmlblock3description) { ?>
          <li>
            <article>
              <?php if($this->htmlblock3title) { ?>
                <div class="_title"><?php echo $this->translate($this->htmlblock3title)?></div>
              <?php } ?>
              <?php if($this->htmlblock3description) { ?>
                <div class="_des"><?php echo $this->translate($this->htmlblock3description)?></div>
              <?php } ?>
            </article>
          </li>
        <?php } ?>
      </ul>
    </div>
  </div>
</div>
