<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seselegant
 * @package    Seselegant
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-04-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seselegant/externals/styles/styles.css'); ?>
<div class="sesbasic_html_block" style="<?php if(!empty($this->height)):?>height:<?php echo $this->height;?>px;<?php endif;?><?php if(!empty($this->width)):?>width:<?php echo $this->width;?>px;<?php endif;?>">
  <?php echo $this->content;?>
</div>

