<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesytube
 * @package    Sesytube
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: landing-page-settings.tpl  2019-02-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js'); ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesytube/views/scripts/dismiss_message.tpl';?>
<h3><?php echo "Manage Landing Page Content"; ?></h3>
<p><?php echo "Here, you can configure the content to be shown in various blocks on landing page of your website. The content added below will display in their respective widgets. You can also place the widgets on other pages of your website."; ?> </p>
<br />
<div class='sesytube_lp_settings_wrapper'>
    <div class="sesytube_lp_settings_tabs">
      <ul class="nav_cnt">
       <li <?php if($this->param == 'banner'): ?> class="active" <?php endif; ?>><a href="javascript:;">Banner Image</a></li>
       <li <?php if($this->param == 'membercloud'): ?> class="active" <?php endif; ?>><a href="javascript:;">Member Cloud</a></li>
       <li <?php if($this->param == 'htmlblock'): ?> class="active" <?php endif; ?>><a href="javascript:;">HTML Block</a></li>
      </ul>
    </div>
    
    <?php
      $banner_options = array(''=>'');
    $path = new DirectoryIterator(APPLICATION_PATH . '/public/admin/');
    foreach ($path as $file) {
      if ($file->isDot() || !$file->isFile())
        continue;
      $base_name = basename($file->getFilename());
      if (!($pos = strrpos($base_name, '.')))
        continue;
      $extension = strtolower(ltrim(substr($base_name, $pos), '.'));
      if (!in_array($extension, array('gif', 'jpg', 'jpeg', 'png')))
        continue;
      $banner_options['public/admin/' . $base_name] = $base_name;
    }
    $fileLink = $this->baseUrl() . '/admin/files/';
    ?>
    <?php $settings = Engine_Api::_()->getApi('settings', 'core'); ?>
    <div class="landing_page_widget_container sesytube_lp_settings_content sesbasic_admin_form">
      <div class="container" id="banner_widget">
        <form action="admin/sesytube/manage/landing-page-settings/param/banner" method="post">
        <h3><?php echo "Manage Banner Image Content"; ?></h3>
        <p><?php echo "In this section, you can manage the banner image content - upload the banner image, small image on banner, add title and description to be added on the banner image."; ?> </p>
        <br />
         <div class="settings">
          <div class="form-wrapper">
            <div class="form-label"><label>Banner Image</label></div>
            <div class="form-element">
            	<p class="description">Choose from below the banner image. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="<?php echo $fileLink ?>" target="_blank">File & Media Manager</a>.]</p>
            	<?php if(count($banner_options)){ ?>
            		<select name="sesytube_banner_bgimage">
                  <?php foreach($banner_options as $key=>$banner_option){ ?>
                  <option value="<?php echo $key; ?>" <?php if($settings->getSetting('sesytube.banner.bgimage', '') == $key){ echo "selected"; } ?>><?php echo $banner_option; ?></option>
                	<?php } ?>
            		</select>
           		<?php } ?>
          	</div> 
          </div>
          <div class="form-wrapper">
            <div class="form-label"><label>Banner Caption</label></div>
            <div class="form-element">
              <p class="description">Enter the caption to be shown on the banner image.</p>
            	<input type="text" name="sesytube_staticcontent" value="<?php echo $settings->getSetting('sesytube.staticcontent', ''); ?>">
            </div>  
          </div>
          <div class="form-wrapper">
            <div class="form-label"><label>Banner Description</label></div>
            <div class="form-element">
              <p class="description">Enter the description to be shown on the banner image.</p>
            	<input type="text" name="sesytube_banerdes" value="<?php echo $settings->getSetting('sesytube.banerdes', ''); ?>">
            </div>  
          </div>
          <div class="form-wrapper">
          	<button type="submit" name="">Save Changes</button>
          </div>
         </div>
        </form>
      </div>
      
      <div style="display:none;" id="membercloud_widget" class="container">
        <form action="admin/sesytube/manage/landing-page-settings/param/membercloud" method="post">
          <h3><?php echo "Manage Member Cloud Section"; ?></h3>
          <p><?php echo "In this section, you can manage the member cloud settings - choose height, width, caption, description, etc to be shown in this block."; ?> </p>
          <br />
          <div class="settings">
            <div class="form-wrapper">
              <div class="form-label"><label>Caption</label></div>
              <div class="form-element">
                <p><?php echo "Enter the caption to be shown on the member cloud block."; ?> </p>
              	<input type="text" name="sesytube_memeber_heading" value="<?php echo $settings->getSetting('sesytube.memeber.heading', ''); ?>">
              </div>  
            </div>
            <div class="form-wrapper">
            	<div class="form-label">
              	<label>Description</label>
              </div>
              <div class="form-element">
                <p><?php echo "Enter the descriptions to be shown on the member cloud block."; ?> </p>
              	<input type="text" name="sesytube_memeber_caption" value="<?php echo $settings->getSetting('sesytube.memeber.caption', ''); ?>">
              </div>  
            </div>
            <div class="form-wrapper">
            	<div class="form-label">
              	<label>Enable Links to Profile</label>
              </div>
              <div class="form-element">
              	<p class="description">Do you want to enable the links on member profile, so that when users click on member photos, they redirect to their profiles?</p>  
              	<select name="sesytube_member_link">
                  <?php 
                  $designs = array('1'=>'Yes','2'=>'No');
                  foreach($designs as $key=>$link){ ?>
                    <option value="<?php echo $key; ?>" <?php if($settings->getSetting('sesytube.member.link', '') == $key){ echo "selected"; } ?>><?php echo $link; ?></option>
                  <?php } ?>
                </select>
              </div>  
            </div>
            <div class="form-wrapper">
            	<div class="form-label">
              	<label>Show Info Tooltip</label>
              </div>
              <div class="form-element">
              	<p class="description">Do you want to show the Info tooltip when users mouse over on Member Profile pictures?</p>  
              	<select name="sesytube_member_infotooltip">
                  <?php 
                  $designs = array('1'=>'Yes','2'=>'No');
                  foreach($designs as $key=>$link){ ?>
                    <option value="<?php echo $key; ?>" <?php if($settings->getSetting('sesytube.member.infotooltip', 1) == $key){ echo "selected"; } ?>><?php echo $link; ?></option>
                  <?php } ?>
                </select>
              </div>  
            </div>
            <div class="form-wrapper">
              <div class="form-label"><label>Enter Limit</label></div>
              <div class="form-element">
                <p><?php echo "Enter the limit of member that you want to show on the member cloud block."; ?> </p>
              	<input type="text" name="sesytube_memeber_count" value="<?php echo $settings->getSetting('sesytube.memeber.count', '30'); ?>">
              </div>  
            </div>
            <div class="form-wrapper">
            <button type="submit" name="">Submit</button>
            </div>
          </div>
        </form>
      </div>
      
      <div class="container" id="htmlblock_widget">
        <form action="admin/sesytube/manage/landing-page-settings/param/htmlblock" method="post">
        <h3><?php echo "Landing Page Html Block"; ?></h3>
        <p><?php echo "In this section, you can manage the HTML Block Content"; ?> </p>
        <br />
         <div class="settings">
          <div class="form-wrapper">
            <div class="form-label"><label>Heading</label></div>
            <div class="form-element">
              <p class="description">Enter heading of this HTML Block Widget.</p>
            	<input type="text" name="sesytube_htmlheading" value="<?php echo $settings->getSetting('sesytube.htmlheading', ''); ?>">
            </div>  
          </div>
          <div class="form-wrapper">
            <div class="form-label"><label>Description</label></div>
            <div class="form-element">
              <p class="description">Enter the description to be shown on the banner image.</p>
            	<input type="text" name="sesytube_htmldescription" value="<?php echo $settings->getSetting('sesytube.htmldescription', ''); ?>">
            </div>  
          </div>

          <div class="form-wrapper">
            <div class="form-label"><label>Block - 1 Title</label></div>
            <div class="form-element">
              <p class="description">Enter block - 1 title.</p>
            	<input type="text" name="sesytube_htmlblock1title" value="<?php echo $settings->getSetting('sesytube.htmlblock1title', ''); ?>">
            </div>  
          </div>
          <div class="form-wrapper">
            <div class="form-label"><label>Block - 1 Description</label></div>
            <div class="form-element">
              <p class="description">Enter the Block - 1 description.</p>
            	<input type="text" name="sesytube_htmlblock1description" value="<?php echo $settings->getSetting('sesytube.htmlblock1description', ''); ?>">
            </div>  
          </div>
          <div class="form-wrapper">
            <div class="form-label"><label>Block - 2 Title</label></div>
            <div class="form-element">
              <p class="description">Enter block - 2 title.</p>
            	<input type="text" name="sesytube_htmlblock2title" value="<?php echo $settings->getSetting('sesytube.htmlblock2title', ''); ?>">
            </div>  
          </div>
          <div class="form-wrapper">
            <div class="form-label"><label>Block - 2 Description</label></div>
            <div class="form-element">
              <p class="description">Enter the Block - 2 description.</p>
            	<input type="text" name="sesytube_htmlblock2description" value="<?php echo $settings->getSetting('sesytube.htmlblock2description', ''); ?>">
            </div>  
          </div>
          <div class="form-wrapper">
            <div class="form-label"><label>Block - 3 Title</label></div>
            <div class="form-element">
              <p class="description">Enter block - 3 title.</p>
            	<input type="text" name="sesytube_htmlblock3title" value="<?php echo $settings->getSetting('sesytube.htmlblock3title', ''); ?>">
            </div>  
          </div>
          <div class="form-wrapper">
            <div class="form-label"><label>Block - 3 Description</label></div>
            <div class="form-element">
              <p class="description">Enter the Block - 3 description.</p>
            	<input type="text" name="sesytube_htmlblock3description" value="<?php echo $settings->getSetting('sesytube.htmlblock3description', ''); ?>">
            </div>  
          </div>
          <div class="form-wrapper">
          	<button type="submit" name="">Save Changes</button>
          </div>
         </div>
        </form>
      </div>
    </div>
    
  </div>
</div>

<script type="application/javascript">

  var landingpageparam = '<?php echo $this->param; ?>';
  if(landingpageparam == 'banner') {
    $('banner_widget').style.display = 'block';
    $('membercloud_widget').style.display = 'none';
    $('htmlblock_widget').style.display = 'none';
  
  } else if(landingpageparam == 'membercloud') {
    $('banner_widget').style.display = 'none';
    $('htmlblock_widget').style.display = 'none';
    $('membercloud_widget').style.display = 'block';
  } else if(landingpageparam == 'htmlblock') {
    $('banner_widget').style.display = 'none';
    $('htmlblock_widget').style.display = 'block';
    $('membercloud_widget').style.display = 'none';
  }
 
  sesJqueryObject('.add_banner_widget').click(function(){
    var html = '<div style="cursor:move" class="item_label"><input type="text" name="sesytube_banner_content[]">&nbsp;<span><a href="javascript:;" class="delete_input_field_banner_txt fa fa-trash"></a></span></div>';
    sesJqueryObject('.input_field_banner_txt').append(html);
    SortablesInstance = new SortablesSes('menu_list', {
      clone: true,
      constrain: false,
      handle: '.item_label',
      onComplete: function(e) {
      }
    });
  });
  sesJqueryObject(document).on('click','.delete_input_field_banner_txt',function(){
    sesJqueryObject(this).parent().parent().remove();
  });  
  sesJqueryObject(document).on('click','ul.nav_cnt li a',function(){
    sesJqueryObject('ul.nav_cnt').find('li').removeClass('active');
    sesJqueryObject(this).parent().addClass('active');
    sesJqueryObject('.landing_page_widget_container').find('div.container').hide();
    sesJqueryObject('.landing_page_widget_container').children().eq(sesJqueryObject(this).parent().index()).show();
  });
</script>
<script type="text/javascript"> 
  window.addEvent('load', function() {
    
     new SortablesSes('menu_list', {
      clone: true,
      constrain: false,
      handle: '.item_label',
      onComplete: function(e) {
      }
    });
  });
</script>
<script type="application/javascript">

var SortablesSes = new Class({

	Implements: [Events, Options],

	options: {/*
		onSort: function(element, clone){},
		onStart: function(element, clone){},
		onComplete: function(element){},*/
		opacity: 1,
		clone: false,
		revert: false,
		handle: false,
		dragOptions: {}/*<1.2compat>*/,
		snap: 4,
		constrain: false,
		preventDefault: false
		/*</1.2compat>*/
	},

	initialize: function(lists, options){
		this.setOptions(options);

		this.elements = [];
		this.lists = [];
		this.idle = true;

		this.addLists($$(document.id(lists) || lists));

		if (!this.options.clone) this.options.revert = false;
		if (this.options.revert) this.effect = new Fx.Morph(null, Object.merge({
			duration: 250,
			link: 'cancel'
		}, this.options.revert));
	},

	attach: function(){
		this.addLists(this.lists);
		return this;
	},

	detach: function(){
		this.lists = this.removeLists(this.lists);
		return this;
	},

	addItems: function(){
		Array.flatten(arguments).each(function(element){
			this.elements.push(element);
			var start = element.retrieve('sortables:start', function(event){
				this.start.call(this, event, element);
			}.bind(this));
			(this.options.handle ? element.getElement(this.options.handle) || element : element).addEvent('mousedown', start);
		}, this);
		return this;
	},

	addLists: function(){
		Array.flatten(arguments).each(function(list){
			this.lists.include(list);
			this.addItems(list.getChildren());
		}, this);
		return this;
	},

	removeItems: function(){
		return $$(Array.flatten(arguments).map(function(element){
			this.elements.erase(element);
			var start = element.retrieve('sortables:start');
			(this.options.handle ? element.getElement(this.options.handle) || element : element).removeEvent('mousedown', start);

			return element;
		}, this));
	},

	removeLists: function(){
		return $$(Array.flatten(arguments).map(function(list){
			this.lists.erase(list);
			this.removeItems(list.getChildren());

			return list;
		}, this));
	},

	getClone: function(event, element){
		if (!this.options.clone) return new Element(element.tagName).inject(document.body);
		if (typeOf(this.options.clone) == 'function') return this.options.clone.call(this, event, element, this.list);
		var clone = element.clone(true).setStyles({
			margin: 0,
			position: 'absolute',
			visibility: 'hidden',
			width: element.getStyle('width')
		}).addEvent('mousedown', function(event){
			element.fireEvent('mousedown', event);
		});
		//prevent the duplicated radio inputs from unchecking the real one
		if (clone.get('html').test('radio')){
			clone.getElements('input[type=radio]').each(function(input, i){
				input.set('name', 'clone_' + i);
				if (input.get('checked')) element.getElements('input[type=radio]')[i].set('checked', true);
			});
		}

		return clone.inject(this.list).setPosition(element.getPosition(element.getOffsetParent()));
	},

	getDroppables: function(){
		var droppables = this.list.getChildren().erase(this.clone).erase(this.element);
		if (!this.options.constrain) droppables.append(this.lists).erase(this.list);
		return droppables;
	},

	insert: function(dragging, element){
		var where = 'inside';
		if (this.lists.contains(element)){
			this.list = element;
			this.drag.droppables = this.getDroppables();
		} else {
			where = this.element.getAllPrevious().contains(element) ? 'before' : 'after';
		}
		this.element.inject(element, where);
		this.fireEvent('sort', [this.element, this.clone]);
	},

	start: function(event, element){
		if (
			!this.idle ||
			event.rightClick ||
			['button', 'input', 'a', 'textarea', 'select'].contains(event.target.get('tag'))
		) return;

		this.idle = false;
		this.element = element;
		this.opacity = element.getStyle('opacity');
		this.list = element.getParent();
		this.clone = this.getClone(event, element);

		this.drag = new Drag.Move(this.clone, Object.merge({
			/*<1.2compat>*/
			preventDefault: this.options.preventDefault,
			snap: this.options.snap,
			container: this.options.constrain && this.element.getParent(),
			/*</1.2compat>*/
			droppables: this.getDroppables()
		}, this.options.dragOptions)).addEvents({
			onSnap: function(){
				event.stop();
				this.clone.setStyle('visibility', 'visible');
				this.element.setStyle('opacity', this.options.opacity || 0);
				this.fireEvent('start', [this.element, this.clone]);
			}.bind(this),
			onEnter: this.insert.bind(this),
			onCancel: this.end.bind(this),
			onComplete: this.end.bind(this)
		});

		this.clone.inject(this.element, 'before');
		this.drag.start(event);
	},

	end: function(){
		this.drag.detach();
		this.element.setStyle('opacity', this.opacity);
		if (this.effect){
			var dim = this.element.getStyles('width', 'height'),
				clone = this.clone,
				pos = clone.computePosition(this.element.getPosition(this.clone.getOffsetParent()));

			var destroy = function(){
				this.removeEvent('cancel', destroy);
				clone.destroy();
			};

			this.effect.element = clone;
			this.effect.start({
				top: pos.top,
				left: pos.left,
				width: dim.width,
				height: dim.height,
				opacity: 0.25
			}).addEvent('cancel', destroy).chain(destroy);
		} else {
			this.clone.destroy();
		}
		this.reset();
	},

	reset: function(){
		this.idle = true;
		this.fireEvent('complete', this.element);
	},

	serialize: function(){
		var params = Array.link(arguments, {
			modifier: Type.isFunction,
			index: function(obj){
				return obj != null;
			}
		});
		var serial = this.lists.map(function(list){
			return list.getChildren().map(params.modifier || function(element){
				return element.get('id');
			}, this);
		}, this);

		var index = params.index;
		if (this.lists.length == 1) index = 0;
		return (index || index === 0) && index >= 0 && index < this.lists.length ? serial[index] : serial;
	}

});</script>
