<?php
/**
* @title		SP Image rotator module
* @website		http://www.joomshaper.com
* @copyright	Copyright (C) 2010 -2013 JoomShaper.com. All rights reserved.
* @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.filesystem.file');
jimport( 'joomla.filesystem.folder' );
if( !defined('DS') ) define('DS', DIRECTORY_SEPARATOR);
abstract class modSPImageRotatorHelper {

	static function getList($params) {
		$filter = '\.png$|\.gif$|\.jpg$|\.bmp$';
		$path		= $params->get('path');
		$files 		= JFolder::files(JPATH_BASE.$path,$filter);
		
		$i=0;
		$lists = array();
		
		foreach ($files as $file) {
			$lists[$i]['title']	= JFile::stripExt($file);
			$lists[$i]['image']	= JURI::base().str_replace(DS,'/',substr($path,1)).'/'.$file;
			$i++;
		}
		return $lists; 
	}	
}		