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

require_once JPATH_SITE.'/components/com_content/helpers/route.php';
jimport( 'joomla.plugin.helper');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_content/models', 'ContentModel');

abstract class modFSSP1Helper
{	

	public static function getList($params){
		
		$app			= JFactory::getApplication();
		$db				= JFactory::getDbo();
		
		//Parameters
		$count			= $params->get('count', 5);
		$titleas		= $params->get('titleas');
		$desclimitas	= $params->get('desclimitas');
		$titlelimit		= (int) $params->get('titlelimit');
		$desclimit		= (int) $params->get('desclimit');
		$catids			= $params->get('catid', array());

		// Get an instance of the generic articles model
		$model = JModelLegacy::getInstance('Articles', 'ContentModel', array('ignore_request' => true));

		// Set application parameters in model
		$appParams = $app->getParams();
		$model->setState('params', $appParams);
		
		// Set the filters based on the module params
		$model->setState('list.start', 0);
		$model->setState('list.limit', (int) $count);
		$model->setState('filter.published', 1);		
		
		// Access filter
		$access = !JComponentHelper::getParams('com_content')->get('show_noauth');
		$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
		$model->setState('filter.access', $access);				

		// Category filter
		$model->setState('filter.category_id', $catids);		

				// User filter
		$userId = JFactory::getUser()->get('id');
		switch ($params->get('user_id'))
		{
			case 'by_me':
				$model->setState('filter.author_id', (int) $userId);
				break;
			case 'not_me':
				$model->setState('filter.author_id', $userId);
				$model->setState('filter.author_id.include', false);
				break;

			case '0':
				break;

			default:
				$model->setState('filter.author_id', (int) $params->get('user_id'));
				break;
		}
		
		// Filter by language
		$model->setState('filter.language', $app->getLanguageFilter());		
		
		//  Featured switch
		switch ($params->get('show_featured'))
		{
			case '1':
				$model->setState('filter.featured', 'only');
				break;
			case '0':
				$model->setState('filter.featured', 'hide');
				break;
			default:
				$model->setState('filter.featured', 'show');
				break;
		}
		
		// Set ordering		
		$ordering 				= $params->get('ordering');
		$ordering_direction		= $params->get('ordering_direction', 'ASC');
		$model->setState('list.ordering', $ordering);
		$model->setState('list.direction', $ordering_direction);		

		//	Retrieve Content
		$items = $model->getItems();
		
		foreach ($items as &$item) {
			$item->slug 		= $item->id.':'.$item->alias;
			$item->catslug 		= $item->catid.':'.$item->category_alias;
			$item->created 		= $item->created;
			$item->title 		= self::cText(htmlspecialchars($item->title),$titlelimit,$titleas);
			$item->image		= self::getImage($item->introtext,$item->images);			
			$item->introtext 	= self::cText(JHtml::_('content.prepare', $item->introtext),$desclimit,$desclimitas);	
			$item->link 		= JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug));
		}	
		
		return $items;
		
	}	
	
	private static function cText($text, $limit, $limitas) {
		
		switch ($limitas) {
			case 0 :
				$text = JFilterOutput::cleanText($text);
				$text = explode(' ',$text);
				$sep = (count($text)>$limit) ? '...' : '';
				$text=implode(' ', array_slice($text,0,$limit)) . $sep;
				break;
			case 1 :
				$text = JFilterOutput::cleanText($text);
				$sep  = (strlen($text)>$limit) ? '...' : '';
				$text =utf8_substr($text,0,$limit) . $sep;
				break;
			case 2 :
				$allowed_tags = '<b><i><a><small><h1><h2><h3><h4><h5><h6><sup><sub><em><strong><u><br>';
				$text = strip_tags( $text, $allowed_tags );
				$text = $text;
				break;
			default :
				$text = JFilterOutput::cleanText($text);
				$text = explode(' ',$text);
				$sep = (count($text)>$limit) ? '...' : '';
				$text=implode(' ', array_slice($text,0,$limit)) . $sep;
				break;
		}		
		
		return $text;
	}
	
	private static function getImage($text, $image_src="") {
		$image_src = json_decode($image_src);		
		if (JVERSION>=2.5 && @$image_src->image_intro) {
			return $image_src->image_intro;
		} elseif (JVERSION>=2.5 && @$image_src->image_fulltext) {
			return $image_src->image_fulltext;
		} else {
			preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', $text, $matches);
			if (!isset($matches[1])) { 
				$matches[1]='modules/mod_freeslider_sp1/assets/images/no-image.jpg';
			}

			if (!file_exists($matches[1])) {
				$matches[1]='modules/mod_freeslider_sp1/assets/images/no-image.jpg';
			}	
			 
			return $matches[1];
		}
	}
}