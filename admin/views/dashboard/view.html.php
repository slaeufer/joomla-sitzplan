<?php
defined('_JEXEC') or die;

use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Session\Session;

class SitzplanViewDashboard extends HtmlView
{
    protected $config;
    protected $zones;
    protected $seats;
    protected $participants;
    protected $statistics;

    public function display($tpl = null)
    {
        // Get data from the model
        $model = $this->getModel();
        $this->config = $model->getConfig();
        $this->zones = $model->getZones();
        $this->seats = $model->getSeats();
        $this->participants = $model->getParticipants();
        $this->statistics = $model->getStatistics();

        // Add toolbar
        $this->addToolbar();

        // Load assets
        $this->loadAssets();

        // Display the template
        parent::display($tpl);
    }

    protected function addToolbar()
    {
        ToolbarHelper::title(Text::_('COM_SITZPLAN') . ': ' . Text::_('Dashboard'), 'grid-2');
        
        // Add help button
        ToolbarHelper::help('', false, 'https://github.com/slaeufer/joomla-sitzplan');
    }

    protected function loadAssets()
    {
        $document = Factory::getDocument();
        $wa = $document->getWebAssetManager();

        // Add CSS
        $document->addStyleSheet('../administrator/components/com_sitzplan/assets/sitzplan.css');

        // Prepare data for JavaScript
        $participantsArray = [];
        foreach ($this->participants as $participant) {
            $participantsArray[] = [
                'id' => (int) $participant->id,
                'name' => $participant->name,
                'gender' => $participant->gender
            ];
        }

        $zonesArray = [];
        foreach ($this->zones as $zone) {
            $zonesArray[] = [
                'id' => (int) $zone->id,
                'name' => $zone->name,
                'count' => (int) $zone->count,
                'position' => $zone->position,
                'gender_rule' => $zone->gender_rule
            ];
        }

        $configArray = [
            'rows' => $this->config->rows ?? 8,
            'seats_left' => $this->config->seats_left ?? 6,
            'seats_right' => $this->config->seats_right ?? 6,
            'aisle_width' => $this->config->aisle_width ?? 44,
            'event_name' => $this->config->event_name ?? 'Musterveranstaltung 2025'
        ];

        // Add data options for JavaScript
        $document->addScriptOptions('sitzplan', [
            'participants' => $participantsArray,
            'zones' => $zonesArray,
            'seats' => $this->seats,
            'config' => $configArray,
            'token' => Session::getFormToken()
        ]);

        // Add JavaScript
        $document->addScript('../administrator/components/com_sitzplan/assets/sitzplan.js');
    }
}
