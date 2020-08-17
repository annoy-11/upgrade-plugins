<?php

?>

<?php
  if (APPLICATION_ENV == 'production')
    $this->headScript()
      ->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.min.js');
  else
    $this->headScript()
      ->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Observer.js')
      ->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.js')
      ->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.Local.js')
      ->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.Request.js');
?>

<script type="text/javascript">
  en4.core.runonce.add(function()
  {
    new Autocompleter.Request.JSON('tags', '<?php echo $this->url(array('controller' => 'tag', 'action' => 'suggest'), 'default', true) ?>', {
      'postVar' : 'text',
      'customChoices' : true,
      'minLength': 1,
      'selectMode': 'pick',
      'autocompleteType': 'tag',
      'className': 'tag-autosuggest',
      'filterSubset' : true,
      'multiple' : true,
      'injectChoice': function(token){
        var choice = new Element('li', {'class': 'autocompleter-choices', 'value':token.label, 'id':token.id});
        new Element('div', {'html': this.markQueryValue(token.label),'class': 'autocompleter-choice'}).inject(choice);
        choice.inputValue = token;
        this.addChoiceEvents(choice).inject(this.choices);
        choice.store('autocompleteChoice', token);
      }
    });
  });
</script>
<?php echo $this->form->render($this);?>
<script type="text/javascript">

  function attachlink() {
    
    if(document.getElementById('link').value == '')
      return;
      
    var linkValue = document.getElementById('link').value;

    document.getElementById('loading_image').style.display = '';
    
    var url = en4.core.baseUrl + 'seslink/index/preview';
    new Request.JSON({
      url: url,
      data: {
        'format' : 'json',
				'uri': linkValue,
      },
      onSuccess: function(responseJSON, responseText) {
        
        if(responseJSON.status == 1) {
          document.getElementById('loading_image').style.display = 'none';
          if(responseJSON.title) {
            document.getElementById('title').value = responseJSON.title;
          } 
          if(responseJSON.description) {  
            tinyMCE.get('body').setContent(responseJSON.description);
          }

          
          if(responseJSON.image && !responseJSON.richHtml) {
            document.getElementById('link_preview').style.display = 'block';
            document.getElementById('link_preview').innerHTML = '<img src="'+responseJSON.image+'" />';
            
            document.getElementById('imagelink').value = responseJSON.image;
          } else {
            document.getElementById('link_preview').style.display = 'block';
            document.getElementById('link_preview').innerHTML = responseJSON.richHtml;

          }
        } 
      }
    }).send();
  }

  $$('.core_main_seslink').getParent().addClass('active');
</script>