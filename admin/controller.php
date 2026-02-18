<?php
defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Factory;

class SitzplanController extends BaseController
{
	protected $default_view = 'dashboard';

	public function display($cachable = false, $urlparams = [])
	{
		$view = $this->input->get('view', 'dashboard');
		$this->getModel($view);

		return parent::display($cachable, $urlparams);
	}

	public function saveSeat()
	{
		$this->checkToken();

		$model = $this->getModel('dashboard');
		$data = $this->input->post->getArray([
			'seat_key' => 'string',
			'person_id' => 'int',
			'person_name' => 'string',
			'person_gender' => 'word'
		]);

		if ($model->saveSeat($data)) {
			echo json_encode(['success' => true]);
		} else {
			echo json_encode(['success' => false, 'error' => 'Failed to save seat']);
		}
		exit;
	}

	public function freeSeat()
	{
		$this->checkToken();

		$seatKey = $this->input->post->get('seat_key', '', 'string');
		$model = $this->getModel('dashboard');

		if ($model->freeSeat($seatKey)) {
			echo json_encode(['success' => true]);
		} else {
			echo json_encode(['success' => false]);
		}
		exit;
	}

	public function addZone()
	{
		$this->checkToken();

		$model = $this->getModel('dashboard');
		$data = $this->input->post->getArray([
			'name' => 'string',
			'count' => 'int',
			'position' => 'word',
			'gender_rule' => 'word'
		]);

		if ($id = $model->addZone($data)) {
			echo json_encode(['success' => true, 'id' => $id]);
		} else {
			echo json_encode(['success' => false]);
		}
		exit;
	}

	public function removeZone()
	{
		$this->checkToken();

		$zoneId = $this->input->post->get('zone_id', 0, 'int');
		$model = $this->getModel('dashboard');

		if ($model->removeZone($zoneId)) {
			echo json_encode(['success' => true]);
		} else {
			echo json_encode(['success' => false]);
		}
		exit;
	}

	public function updateConfig()
	{
		$this->checkToken();

		$model = $this->getModel('dashboard');
		$data = $this->input->post->getArray([
			'rows' => 'int',
			'seats_left' => 'int',
			'seats_right' => 'int',
			'aisle_width' => 'int',
			'event_name' => 'string'
		]);

		if ($model->updateConfig($data)) {
			echo json_encode(['success' => true]);
		} else {
			echo json_encode(['success' => false]);
		}
		exit;
	}
}