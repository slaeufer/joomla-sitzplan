<?php
// admin/sitzplan.php
// This file serves as the main entry point for the admin component of the Joomla Sitzplan application.

defined('_JEXEC') or die;

// Load the necessary framework
require_once JPATH_COMPONENT . '/helpers/sitzplan.php';

// Get the task from the request
$task = JFactory::getApplication()->input->getCmd('task', 'display');

// Dispatch the task
SitzplanHelper::executeTask($task);