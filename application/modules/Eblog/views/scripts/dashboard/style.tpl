<?php/** * SocialEngineSolutions * * @category   Application_Eblog * @package    Eblog * @copyright  Copyright 2015-2016 SocialEngineSolutions * @license    http://www.socialenginesolutions.com/license/ * @version    $Id: style.tpl 2016-07-23 00:00:00 SocialEngineSolutions $ * @author     SocialEngineSolutions */?><?php if(!$this->is_ajax){ echo $this->partial('dashboard/left-bar.tpl', 'eblog', array(	'blog' => $this->blog,      ));	?>	<div class="sesbasic_dashboard_content sesbm sesbasic_clearfix"><?php } 	?>    	<div class="sesbasic_dashboard_form">      <div class="eblog_edit_style_blog">    		<?php echo $this->form->render() ?>        </div>      </div>    <?php if(!$this->is_ajax){ ?>  </div></div></div><?php  } ?><?php if($this->is_ajax) die; ?>