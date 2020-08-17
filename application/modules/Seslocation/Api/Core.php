<?php
class Seslocation_Api_Core extends Core_Api_Abstract {
  public function getWidgetText($module = ""){    
    return "Do you want to show content in this widget based on the Location chosen by users on your website? (This is dependent on the “Location Based Member & Content Display Plugin”. Also, make sure location is enabled and entered for the content in this plugin. If setting is enabled and the content does not have a location, then such content will not be shown in this widget.)";
  }
}