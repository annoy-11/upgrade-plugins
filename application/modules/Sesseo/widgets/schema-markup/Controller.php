<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesseo
 * @package    Sesseo
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-03-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesseo_Widget_SchemaMarkupController extends Engine_Content_Widget_Abstract {

    public function indexAction() {

        $settings = Engine_Api::_()->getApi('settings', 'core');

        $this->view->schema_type = $schema_type = $settings->getSetting('sesseo.schema.type', 1);

        if(in_array($schema_type, array('1', '2'))) {
            if($schema_type == 1) {
                $this->view->type = 'Website';
            } elseif($schema_type == 2) {
                $this->view->type = 'Organization';
            }

            $this->view->sitetitle = $settings->getSetting('sesseo.sitetitle', Engine_Api::_()->getApi('settings', 'core')->getSetting('core.general.site.title'));

            $this->view->alternatetitle = $settings->getSetting('sesseo.alternatetitle', '');

            $this->view->facebook = $settings->getSetting('sesseo.facebook', '');
            $this->view->twitter = $settings->getSetting('sesseo.twitter', '');
            $this->view->linkdin = $settings->getSetting('sesseo.linkdin', '');
            $this->view->googleplus = $settings->getSetting('sesseo.googleplus', '');
            $this->view->instagram = $settings->getSetting('sesseo.instagram', '');
            $this->view->youtube = $settings->getSetting('sesseo.youtube', '');

            $socialmediaURL = array($this->view->facebook, $this->view->twitter, $this->view->linkdin, $this->view->googleplus, $this->view->instagram, $this->view->youtube);

            $othermediaurl = $settings->getSetting('sesseo.othermediaurl', '');
            $othermediaurl = explode(',', $othermediaurl);

            $socialmediaURL = array_merge($socialmediaURL, $othermediaurl);
            $socialmediaURL = array_filter(array_map('trim', $socialmediaURL));

            $scheme_array = array(
                '@context' => 'http://schema.org',
                '@type' => $this->view->type,
                "name" => $this->view->sitetitle,
                "alternateName" => $this->view->alternatetitle,
                "url" => $this->view->absoluteUrl($this->view->url()),
                "sameAs" => $socialmediaURL, //URL of a reference Web page that unambiguously indicates the item's identity. E.g. the URL of the item's Wikipedia page, Wikidata entry, or official website. Ex: https://schema.org/sameAs
            );
            $schememarkup_array = array_filter($scheme_array);
            $this->view->schema_markup = $schema_markup = json_encode($schememarkup_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
         } else {
            $this->view->schema_markup = $schema_markup = $settings->getSetting('sesseo.customschema', '');
        }

        if(empty($schema_markup))
            return $this->setNoRender();

    }
}
