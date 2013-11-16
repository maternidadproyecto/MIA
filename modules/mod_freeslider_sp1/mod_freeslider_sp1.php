<?php
/*
# ------------------------------------------------------------------------
# Free Slide SP1 - Slideshow module for Joomla
# ------------------------------------------------------------------------
# Copyright (C) 2010 - 2013 JoomShaper.com. All Rights Reserved.
# @license - GNU/GPL, see LICENSE.php,
# Author: JoomShaper.com
# Websites:  http://www.joomshaper.com
# ------------------------------------------------------------------------
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.framework', true);
$document 				= JFactory::getDocument();
$uniqid					= $module->id;
$showtitle				= $params->get('showtitle',1) ? true : false;
$titlelinked			= $params->get('titlelinked',1) ? true : false;
$showarticle			= $params->get('showarticle',1) ? true : false;
$showimage				= $params->get('showimage',1) ? true : false;
$imagelinked			= $params->get('imagelinked',1) ? true : false;
$showmore				= $params->get('showmore',1) ? true : false;
$showarrows				= $params->get('showarrows',1) ? true : false;
$autoplay				= $params->get('autoplay',1) ? true : false;
$titlelimit				= $params->get('titlelimit',20);
$desclimit				= $params->get('desclimit',30);
$moretext				= $params->get('moretext', 'Read More...');
$width					= $params->get('width', 320);
$height					= $params->get('height', 200);
$interval 				= $params->get("interval", 5000);
$speed 					= $params->get('speed', 1000);
$effects				= $params->get('effects','cover-inplace-fade');
$transition 			= $params->get("transition", "Sine.easeOut");

// Include the syndicate functions only once
require_once (dirname(__FILE__).'/helper.php');
$list = modFSSP1Helper::getList($params);

//Load Layout Style
$document->addScript(JURI::base(true) . '/modules/mod_freeslider_sp1/assets/js/script.js');
$document->addStylesheet(JURI::base(true) . '/modules/mod_freeslider_sp1/assets/css/style.css');

require(JModuleHelper::getLayoutPath('mod_freeslider_sp1'));