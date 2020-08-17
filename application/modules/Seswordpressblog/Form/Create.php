<?php 
class Seswordpressblog_Form_Create extends Engine_Form
{
  public function init() {
  	$this->setTitle('Write New Entry')
      ->setDescription('Compose your new blog entry below, then click "Post Entry" to publish the entry to your blog.');
  	$this->addElement('Text', 'title', array(
      'label' => 'Title',
      'allowEmpty' => true,
      'required' => true,
      'filters' => array(
        new Engine_Filter_Censor(),
        'StripTags',
        new Engine_Filter_StringLength(array('max' => '224'))
      ),
    ));
  	
  	$categories=Engine_Api::_()->getDbtable('categories','seswordpressblog');
  	$cat=$categories->getCategory();
  	
  	$this->addElement('Select', 'category_id', array(
	    'label' => 'Category',
	    'description' => 'Separate tags with commas.',
	    'multiOptions' => $cat,
	    'allowEmpty' => true,
	    'required' => true,
	));

	$this->addElement('Text', 'tags', array(
        'label' => 'Tags (Keywords)',
        'description' => 'Separate tags with commas.',
        'allowEmpty' => true,
	    'required' => true,
    ));

    $this->addElement('Text','url',array(
    	'label'=>'Enter Image Url',
    	'description'=>'Enter image url',
    	'allowEmpty'=>true,
    	'required'=>true
    ));
    $editorOptions['plugins'] = array(
        'table', 'fullscreen', 'media', 'preview', 'paste',
        'code', 'image', 'textcolor', 'jbimages', 'link'
      );
      $editorOptions['toolbar1'] = array(
        'undo', 'redo', 'removeformat', 'pastetext', '|', 'code',
        'media', 'image', 'jbimages', 'link', 'fullscreen',
        'preview'
      );
      $editorOptions['toolbar2'] = array(
        'fontselect','fontsizeselect','bold','italic','underline','strikethrough','forecolor','backcolor','|','alignleft','aligncenter','alignright','alignjustify','|','bullist','numlist','|','outdent','indent','blockquote',
      );
    $this->addElement('TinyMce', 'body', array(
      'label' => 'Blog Description',
      'description'=>'description',
      'required' => true,
      'allowEmpty' => true,
      'class'=>'tinymce',
      'editorOptions' => $editorOptions,
    ));

    $this->addElement('Button', 'submit', array(
        'label' => 'Post Entry',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array(
            'ViewHelper',
        ),
    ));
  }
}