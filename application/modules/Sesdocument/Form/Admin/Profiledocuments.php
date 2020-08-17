<?php

class Sesdocument_Form_Admin_Profiledocuments extends Engine_Form
{
  public function init()
  {
		$this->addElement('MultiCheckbox', "enableTabs", array(
			'label' => "Choose the View Type.",
			'multiOptions' => array(
                'list' => 'List View',
                'grid' => 'Grid View',				
            ),
        ));

		$this->addElement('Select', "openViewType", array(
             'label' => "Default open View Type (apply if select Both View option in above tab)?",
             'multiOptions' => array(
            'list' => 'List View',
            'grid' => 'Grid View',
            
        ),
             'value' => 'list',
    ));

		$this->addElement('MultiCheckbox', "show_criteria", array(
		    'label' => "Data show in widget ?",
			'multiOptions' => array(
                'featuredLabel' => 'Featured Label',
                'sponsoredLabel' => 'Sponsored Label',
				'verifiedLabel' => 'Verified Label',
                'favouriteButton' => 'Favourite Button',
                'likeButton' => 'Like Button',
				'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
				'like' => 'Likes',					
                'comment' => 'Comments',
                'favourite' => 'Favourite Count',
						
                'rating' => 'Ratings',
                'view' => 'Views',
                'title' => 'Titles',
						
                'category' => 'Category',
                'by' => 'Item Owner Name',
				'docType' => 'Document Type',
                'creationDate' => 'Creation Date',		
                'listdescription' => 'Description (List View)',
				
        ),
        'escape' => false,
    ));

    //Social Share Plugin work
    if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sessocialshare')) {
      
      $this->addElement('Select', "socialshare_enable_plusicon", array(
        'label' => "Enable plus (+) Icon for social share buttons?",
          'multiOptions' => array(
          '1' => 'Yes',
          '0' => 'No',
        ),
        'value' => 1,
      ));
      
      $this->addElement('Text', "socialshare_icon_limit", array(
          'label' => 'Count (number of social sites to show). If you enable More Icon, then other social sharing icons will display on clicking this plus icon.',
          'value' => 2,
          'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
          )
      ));
    }
    //Social Share Plugin work
    
		
		$this->addElement('Text',
			'list_title_truncation',
			array(
					'label' => 'Title truncation limit for List View.',
					'value' => 45,
					'validators' => array(
							array('Int', true),
							array('GreaterThan', true, array(0)),
					)
			)
		);
		
		$this->addElement(
			'Text',
    'grid_title_truncation',
    array(
        'label' => 'Title truncation limit for Grid View.',
        'value' => 45,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    	)
		);
		
		
		$this->addElement(
			 'Text',
    'list_description_truncation',
    array(
        'label' => 'Description truncation limit for List View.',
        'value' => 45,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    )
		);
		
	/*	$this->addElement(
		'Text',
    'grid_description_truncation',
    array(
        'label' => 'Description truncation limit for Grid View.',
        'value' => 45,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    )
		);*/
		
		$this->addElement(
		'Text',
    'height',
    array(
        'label' => 'Enter the height of List block (in pixels).',
        'value' => '160',
    )
		);
		$this->addElement(
		'Text',
    'width',
    array(
        'label' => 'Enter the width of List block (in pixels).',
        'value' => '250',
    )
		);
		 
		$this->addElement(
			'Text',
    'photo_height',
    array(
        'label' => 'Enter the height of grid photo block (in pixels).',
        'value' => '160',
    )
		);
		$this->addElement(
			'Text',
    'photo_width',
    array(
        'label' => 'Enter the width of grid photo block (in pixels).',
        'value' => '250',
    )
		);
	/*	$this->addElement(
			'Text',
    'info_height',
    array(
        'label' => 'Enter the height of grid info block (in pixels).',
        'value' => '160',
    )
		);*/
		
		$this->addElement('MultiCheckbox', "search_type", array(
			 'label' => "Choose from below the Tabs that you want to show in this widget.",
			'multiOptions' => array(
				    'recentlySPcreated' => 'Recently Created',      
                    'mostSPliked' => 'Most Liked',
                    'mostSPcommented' => 'Most Commented',
                    'mostSPrated' => 'Most Rated',      
                    'featured' => 'Featured',
                    'sponsored' => 'Sponsored',
                    'verified' => 'Verified',
                    'mostSPfavourite' =>'Most Favourite',
                    'mostSPviewed' => 'Most Viewed',
                ),
		));
		
        $counter =1;
        
        
    // setting for Recently Updated
    $this->addElement('Text', "recentlySPcreated_order", array(
        'label' => "Enter The order & text for tabs to be shown in this widget. ",
        'value' => $counter++,
    ));
    $this->addElement('Text', "recentlySPcreated_label", array(
        'value' => 'Recently Created',
    ));
  
    // setting for Most Liked
    $this->addElement('Text', "mostSPliked_order", array(
        'label' => 'Most Liked',
        'value' => $counter++,
    ));
    $this->addElement('Text', "mostSPliked_label", array(
        'value' => 'Most Liked',
    ));
    // setting for Most Commented
    $this->addElement('Text', "mostSPcommented_order", array(
        'label' => 'Most Commented',
        'value' => $counter++,
    ));
    $this->addElement('Text', "mostSPcommented_label", array(
        'value' => 'Most Commented',
    ));
    // setting for Most Rated
    $this->addElement('Text', "mostSPrated_order", array(
        'label' => 'Most Rated',
        'value' => $counter++,
    ));
    $this->addElement('Text', "mostSPrated_label", array(
        'value' => 'Most Rated',
    ));

    // setting for Most Favourite
    $this->addElement('Text', "mostSPfavourite_order", array(
        'label' => 'Most Favourite',
        'value' => $counter++,
    ));
    $this->addElement('Text', "mostSPfavourite_label", array(
        'value' => 'Most Favourite',
    ));
    
    // setting for Featured
    $this->addElement('Text', "featured_order", array(
        'label' => 'Featured',
        'value' => $counter++,
    ));
    $this->addElement('Text', "featured_label", array(
        'value' => 'Featured',
    ));
    // setting for Sponsored
    $this->addElement('Text', "sponsored_order", array(
        'label' => 'Sponsored',
        'value' => $counter++,
    ));
    $this->addElement('Text', "sponsored_label", array(
        'value' => 'Sponsored',
    ));
        // setting for Verified
    $this->addElement('Text', "verified_order", array(
        'label' => 'Verified',
        'value' => $counter++,
    ));
    $this->addElement('Text', "verified_label", array(
        'value' => 'Verified',
    ));
  }
}