<?php
/**
 * @package    DD_Disable_Bootstrap
 *
 * @author     HR IT-Solutions Florian Häusler <info@hr-it-solutions.com>
 * @copyright  Copyright (C) 2011 - 2017 Didldu e.K. | HR IT-Solutions
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

	protected $app;

	/**
	 * onBeforeCompileHead
	 *
	 * @since Version 1.0.0.0
	 */
	public function onBeforeCompileHead()
	{
		// Front end
		if ($this->app instanceof JApplicationSite)
		{
			$doc = JFactory::getDocument();

			// Remove default bootstrap
			unset($doc->_scripts[JURI::root(true) . '/media/jui/js/bootstrap.min.js']);
		}
	}

	/**
	 * onAfterRender
	 *
	 * @since Version 1.0.0.0
	 */
	public function onAfterRender()
	{
		// Front end
		if ($this->app instanceof JApplicationSite)
		{
			// Check plugin parameter to replace
			if ($this->params->get('remove_hastooltip_class', 1)
				&& $this->params->get('toreplace') !== '{"html": true,"container": "body"}')
			{
				// Securety fix, remove braces
				$value = array("(",")");

				$toreplace = str_replace($value, "", $this->params->get('toreplace'));

				// Remove bootstrap associated .tooltip global from <head> which is added by JHtml::_('behavior.tooltip');
				$html = str_replace('jQuery(\'.hasTooltip\').tooltip(' . $toreplace . ');', '', $this->app->getBody());
			}
			else
			{
				// Remove bootstrap associated .tooltip global from <head> which is added by JHtml::_('behavior.tooltip');
				$html = preg_replace("/jQuery(.+)\.tooltip\(.+\)\;/i", "<!-- Removed tooltip -->", $this->app->getBody());
			}

			// Check plugin parameter to remove hasTooltip CSS class
			if ($this->params->get('remove_hastooltip_class', 1))
			{
				// Try to remove all associated JS CSS .tooltip classes to avoid TypeError: $(...).tooltip is not a function.
				$html = preg_replace("/\shasTooltip\"/", ' "', $html);
			}

			$this->app->setBody($html);
		}
	}
}
