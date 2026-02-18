<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;

if (!Factory::getApplication()->getIdentity()->authorise('core.manage', 'com_sitzplan')) {
    throw new \Exception('Access Denied', 403);
}

require_once JPATH_COMPONENT . '/controller.php';
$controller = new SitzplanController();
$controller->execute(Factory::getApplication()->input->get('task', 'display', 'cmd'));
$controller->redirect();
