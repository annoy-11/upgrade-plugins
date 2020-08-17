<?php 
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */ 
 ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sespagebuilder/externals/scripts/jquery-1.11.3.min.js'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespagebuilder/externals/styles/styles.css'); ?>

<style type="text/css">
  #accordion_<?php echo $this->identity ?>{
    width:<?php echo $this->width ?>px;
    float:<?php echo $this->tab_position;?>
  }
 
  <?php if($this->customcolor){ ?>
		#accordion_<?php echo $this->identity ?>,
    #accordion_<?php echo $this->identity ?> .sespagebuilder_accordion_menu_link{
      background-color:#<?php echo $this->accTabBgColor;?>;
    }
    #accordion_<?php echo $this->identity ?> .sespagebuilder_accordion_menu_link a{
      color:#<?php echo $this->accTabTextColor;?>;
			font-size:<?php echo $this->accTabTextFontSize;?>px;
    }
		#accordion_<?php echo $this->identity ?> li i.fa-chevron-down:before{
			color:#<?php echo $this->accTabTextColor;?>;
		}
    #accordion_<?php echo $this->identity ?> .sespagebuilder_accordion_submenu a{
      background-color:#<?php echo $this->subaccTabBgColor;?>;
      color:#<?php echo $this->subaccTabTextColor;?>;
			font-size:<?php echo $this->subaccTabTextFontSize;?>px;
    }
		#accordion_<?php echo $this->identity ?>  .sespagebuilder_accordion_submenu a i:before{
			color:#<?php echo $this->subaccTabTextColor;?>;
		}
  <?php }else{ ?> 
		#accordion_<?php echo $this->identity ?> .sespagebuilder_accordion_menu_link a{
			font-size:<?php echo $this->accTabTextFontSize;?>px;
    }
		#accordion_<?php echo $this->identity ?> .sespagebuilder_accordion_submenu a{
			font-size:<?php echo $this->subaccTabTextFontSize;?>px;
    }
	<?php } ?>
</style>
<ul id="accordion_<?php echo $this->identity ?>" class="sespagebuilder_accordion_menu sesbasic_clearfix sesbasic_bxs <?php if($this->accordian_type):?>isvertical<?php else:?>ishorizontal<?php endif;?>">
  <?php foreach($this->accordions as $accordion): ?>
  <?php $subaccordions = Engine_Api::_()->getDbtable('accordions', 'sespagebuilder')->getModuleSubaccordion($accordion->accordion_id); ?>
  <li>
    <div class="sespagebuilder_accordion_menu_link <?php if(empty($this->accorImage)):?>noicon<?php endif;?>">
      <?php if($accordion->accordion_icon): ?>
        <img alt="" src="<?php echo Engine_Api::_()->storage()->get($accordion->accordion_icon, '')->getPhotoUrl(); ?>" />
      <?php endif; ?>
      <a target="<?php if($accordion->accordion_url) :?><?php if($this->urlOpen): ?>_blank<?php else: ?>_parent<?php endif; ?><?php endif; ?>" href="<?php if($accordion->accordion_url) :?><?php echo $accordion->accordion_url ?><?php else: ?>javascript:void(0);<?php endif; ?>"><?php echo $this->translate($accordion->accordion_name); ?></a>
      <?php if(count($subaccordions) > 0): ?>
        <i class="fa fa-chevron-down sesbasic_text_light"></i>
      <?php endif; ?>
    </div>
    <?php if(count($subaccordions) > 0): ?>
    <ul class="sespagebuilder_accordion_submenu">
      <?php foreach ($subaccordions as $subaccordion):  ?>
      <li>
        <a target="<?php if($subaccordion->accordion_url):?><?php if($this->urlOpen): ?>_blank<?php else: ?>_parent<?php endif; ?><?php endif;?>" href="<?php if($subaccordion->accordion_url):?><?php echo $subaccordion->accordion_url ?><?php else: ?>javascript:void(0);<?php endif; ?>">
          <?php if(empty($this->subaccorImage)): ?>
            <i class="fa fa-circle sesbasic_text_light"></i>
          <?php else: ?>
            <?php if($subaccordion->accordion_icon): ?>
              <img src="<?php echo Engine_Api::_()->storage()->get($subaccordion->accordion_icon, '')->getPhotoUrl(); ?>" alt=""  />
            <?php endif; ?>
          <?php endif; ?>
          <?php echo $this->translate($subaccordion->accordion_name); ?>
        </a>
      <?php endforeach; ?>
    </ul>  
    <?php endif; ?>
  </li>
 <?php endforeach; ?>
</ul>

<script>

sesAccordion(document).ready(function(){
	var allelem = document.getElementsByTagName('a');
for(var i =0;i<allelem.length;i++){
	if(sesAccordion(allelem[i]).attr('href') == document.URL){
	 	if(sesAccordion(allelem[i]).parent().hasClass('sespagebuilder_accordion_menu_link'))
			sesAccordion(allelem[i]).parent().addClass('active');
	}
}
})
  //jquery1.11.1.min.js
  sesAccordion(function() {
    var Accordion = function(el, multiple) {
      this.el = el || {};
      this.multiple = multiple || false;

      // Variables privadas
      var links = this.el.find('.sespagebuilder_accordion_menu_link');
      // Evento
      links.on('click', {el: this.el, multiple: this.multiple}, this.dropdown)
    }

    Accordion.prototype.dropdown = function(e) {
      var $el = e.data.el;
      $this = sesAccordion(this),
      $next = $this.next();

      $next.slideToggle();
      $this.parent().toggleClass('open');

      if (!e.data.multiple) {
        $el.find('.sespagebuilder_accordion_submenu').not($next).slideUp().parent().removeClass('open');
      }
      ;
    }
    var accordion = new Accordion(sesAccordion("#accordion_<?php echo $this->identity ?>"), false);
  });
</script>
