<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div class="sesqa_sidebar_tags sesbasic_clearfix sesbasic_bxs">
	<ul class="sesqa_tags_list">
		<?php 
     foreach($this->tags as $tagMap){ 
      $tag = $tagMap->getTag();
        if (!isset($tag->text))
          continue;
        ?>
      <li><a class="sesqa_tag" href="<?php echo $this->url(array('action'=>'browse'),'sesqa_general',true).'?tag_id='.$tag->getIdentity(); ?>" class="sesqa_tag"><?php echo $tag->text; ?></a></li>
		<?php } ?>
	</li>
</div>
