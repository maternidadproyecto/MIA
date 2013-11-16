<?php
/**
* @title		SP Image rotator module
* @website		http://www.joomshaper.com
* @copyright	Copyright (C) 2010 -2013 JoomShaper.com. All rights reserved.
* @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.framework');
// Include helper.php
if( !defined('DS') ) define('DS', DIRECTORY_SEPARATOR);
require_once (dirname(__FILE__).DS.'helper.php');
$lists 					= modSPImageRotatorHelper::getList($params);
$uri 					= JURI::getInstance();
$uniqid					= $module->id;
$width					= $params->get('width', "320");
$height					= $params->get('height', "200");
$showButtons			= $params->get('showButtons', 1);
$autoPlay 				= ($params->get("autoPlay", 1)  == 0) ? "false" : "true";
$interval 				= $params->get("interval", 5000);
$speed 					= $params->get("speed", 1000);
$transition 			= $params->get("transition", "Expo.easeOut");
$items					= count($lists);
$document 				= JFactory::getDocument();
$document->addStylesheet('modules/mod_sp_image_rotator/assets/css/style.css');
$document->addScript('modules/mod_sp_image_rotator/assets/script/_class.noobSlide.js');
require(JModuleHelper::getLayoutPath('mod_sp_image_rotator'));