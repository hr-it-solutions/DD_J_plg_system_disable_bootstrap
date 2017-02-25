<?php
/**
 * @version    1-3-0-1 // Y-m-d 2016-05-14
 * @author     HR IT-Solutions Florian Häusler https://www.hr-it-solutions.com
 * @copyright  Copyright (C) 2011 - 2016 Didldu e.K. | HR IT-Solutions
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 **/

defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');
jimport('joomla.access.access');

/**
 * Joomla! system plugin to disable Bootstrap from the front end!
 */
class plgSystemDD_Disable_Bootstrap extends JPlugin
{

	/**
	 * @var string
	 * Joomla 3.x
	 * JHtml::_('behavior.tooltip') JavaScript jQuery snipped
	 */
	private $behavior_tooltip = '{"html": true,"container": "body"}';
	
	public function onBeforeCompileHead()
	{
		$app = JFactory::getApplication();

		// Front end
		if ($app instanceof JApplicationSite)
		{
			$doc = JFactory::getDocument();
			// Remove default bootstrap
			unset($doc->_scripts[JURI::root(true) . '/media/jui/js/bootstrap.min.js']);
		}
	}

	public function onAfterRender()
	{
		$app = JFactory::getApplication();

		// Front end
		if ($app instanceof JApplicationSite)
		{
			// check plugin parameter to replace
			if ($this->params->get('toreplace') !== '{"html": true,"container": "body"}'){
				$value = array("(",")"); // Securety fix, remove opening braces
				$toreplace = str_replace($value,"",$this->params->get('toreplace'));
			} else {
				$toreplace = $this->behavior_tooltip;
			}

			// Remove bootstrap associated .tooltip global from <head> which is added by JHtml::_('behavior.tooltip');
			$html = preg_replace("/jQuery(.+)\.tooltip\(.+\)\;/i", "<!-- Removed tooltip -->", $app->getBody());

			$app->setBody($html);
		}
	}
}