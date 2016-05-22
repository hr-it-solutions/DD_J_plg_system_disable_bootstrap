# DD_J_plg_system_disable-bootstrap
is a Joomla! system plugin to disable Bootstrap from the front end!

-
In the the front end of Joomla! some extensions is calling the function JHTML::_('behavior.tooltip'),
which adds javascript code to html head. In some cases hasTooltip is associated and runns in browser console errors.
This Plugin unsets bootstrap js files and also removes bootstraps hasTooltip function from front end, to avoid console errror.

This Plugin use the following snippet to remove:

    jQuery('.hasTooltip').tooltip({"html": true,"container": "body"});
If you know what you're doing, you can change the text in the plugin settings if it differs from your version!

# System requirements
Joomla 3.5.+                                                                                <br>
PHP 5.6.13 or newer is recommended.

# DD_ Namespace
DD_ stands for  **D**idl**d**u e.K. | HR IT-Solutions (Brand recognition)                   <br>
It is a namespace prefix, provided to avoid element name conflicts.

<br>
Author: Didldu e.K. Florian Häusler https://www.hr-it-solution.com                          <br>
Copyright: (C) 2011 - 2016 Didldu e.K. | HR IT-Solutions                                    <br>
http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
