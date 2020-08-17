<?php 
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: getAccordionmenuShortcode.tpl 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */ 
 ?>
<?php $this->accordionmenu = Engine_Api::_()->getItem('sespagebuilder_content', $this->menu_id);?>
<?php $this->accordions = Engine_Api::_()->getDbtable('accordions', 'sespagebuilder')->getAccordion($this->menu_id);?>

<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sespagebuilder/externals/scripts/jquery-1.11.3.min.js'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespagebuilder/externals/styles/styles.css'); ?>

<style type="text/css">
  #accordion_<?php echo $this->menu_id ?>{
    width:<?php echo $this->accordionmenu->width ?>px;
  }
  #accordion_<?php echo $this->menu_id ?> .sespagebuilder_accordion_menu_link{
    background-color:<?php echo $this->accordionmenu->accTabBgColor;?>;
  }
  #accordion_<?php echo $this->menu_id ?> .sespagebuilder_accordion_menu_link a{
    color:<?php echo $this->accordionmenu->accTabTextColor;?>;
    font-size:<?php echo $this->accordionmenu->accTabTextFontSize;?>px;
  }
  #accordion_<?php echo $this->menu_id ?> .sespagebuilder_accordion_submenu a{
    background-color:<?php echo $this->accordionmenu->subaccTabBgColor;?>;
    color:<?php echo $this->accordionmenu->subaccTabTextColor;?>;
    font-size:<?php echo $this->accordionmenu->subaccTabTextFontSize;?>px;
  }
</style>
<ul id="accordion_<?php echo $this->menu_id ?>" class="sespagebuilder_accordion_menu sesbasic_clearfix sesbasic_bxs <?php if($this->accordionmenu->show_accordian):?>isvertical<?php else:?>ishorizontal<?php endif;?>">
  <?php foreach($this->accordions as $accordion): ?>
  <?php $subaccordions = Engine_Api::_()->getDbtable('accordions', 'sespagebuilder')->getModuleSubaccordion($accordion->accordion_id); ?>
  <li>
    <div class="sespagebuilder_accordion_menu_link <?php if(empty($this->accordionmenu->accorImage)):?>noicon<?php endif;?>">
      <?php if($accordion->accordion_icon): ?>
        <img alt="" src="<?php echo Engine_Api::_()->storage()->get($accordion->accordion_icon, '')->getPhotoUrl(); ?>" />
      <?php endif; ?>
      <a target="<?php if($accordion->accordion_url) :?><?php if($this->urlOpen): ?>_blank<?php else: ?>_parent<?php endif; ?><?php endif; ?>" href="<?php if($accordion->accordion_url) :?><?php echo $accordion->accordion_url ?><?php else: ?>javascript:void(0);<?php endif; ?>"><?php echo $accordion->accordion_name; ?></a>
      <?php if(count($subaccordions) > 0): ?>
        <i class="fa fa-chevron-down sesbasic_text_light"></i>
      <?php endif; ?>
    </div>
    <?php if(count($subaccordions) > 0): ?>
    <ul class="sespagebuilder_accordion_submenu">
      <?php foreach ($subaccordions as $subaccordion):  ?>
      <li>
        <a href="<?php if($subaccordion->accordion_url) echo $subaccordion->accordion_url ?>" target="<?php if($this->urlOpen): ?>_blank<?php else: ?>_parent<?php endif; ?>">
          <?php if(empty($this->accordionmenu->subaccorImage)): ?>
            <i class="fa fa-circle sesbasic_text_light"></i>
          <?php else: ?>
            <?php if($subaccordion->accordion_icon): ?>
              <img src="<?php echo Engine_Api::_()->storage()->get($subaccordion->accordion_icon, '')->getPhotoUrl(); ?>" alt=""  />
            <?php endif; ?>
          <?php endif; ?>
          <?php echo $subaccordion->accordion_name; ?>
        </a>
      <?php endforeach; ?>
    </ul>  
    <?php endif; ?>
  </li>
 <?php endforeach; ?>
</ul>

<script>
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
    var accordion = new Accordion(sesAccordion("#accordion_<?php echo $this->menu_id ?>"), false);
  });
</script>