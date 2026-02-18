<?php
defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Factory;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Language\Text;

class SitzplanController extends BaseController
{
    protected $default_view = 'dashboard';

    public function display($cachable = false, $urlparams = [])
    {
        return parent::display($cachable, $urlparams);
    }

    public function saveSeat()
    {
        Session::checkToken() or jexit(Text::_('JINVALID_TOKEN'));

        $app = Factory::getApplication();
        $input = $app->input;
        
        $seatKey = $input->getString('seat_key');
        $personId = $input->getInt('person_id');
        $personName = $input->getString('person_name');
        $personGender = $input->getString('person_gender');

        $db = Factory::getDbo();
        $query = $db->getQuery(true);

        // Check if seat already exists
        $query->select('id')
            ->from($db->quoteName('#__sitzplan_seats'))
            ->where($db->quoteName('seat_key') . ' = ' . $db->quote($seatKey));
        $db->setQuery($query);
        $existingId = $db->loadResult();

        if ($existingId) {
            // Update existing seat
            $query = $db->getQuery(true);
            $query->update($db->quoteName('#__sitzplan_seats'))
                ->set($db->quoteName('person_id') . ' = ' . $db->quote($personId))
                ->set($db->quoteName('person_name') . ' = ' . $db->quote($personName))
                ->set($db->quoteName('person_gender') . ' = ' . $db->quote($personGender))
                ->set($db->quoteName('assigned_date') . ' = NOW()')
                ->where($db->quoteName('id') . ' = ' . $db->quote($existingId));
        } else {
            // Insert new seat
            $query = $db->getQuery(true);
            $columns = ['seat_key', 'person_id', 'person_name', 'person_gender', 'assigned_date'];
            $values = [
                $db->quote($seatKey),
                $db->quote($personId),
                $db->quote($personName),
                $db->quote($personGender),
                'NOW()'
            ];
            $query->insert($db->quoteName('#__sitzplan_seats'))
                ->columns($db->quoteName($columns))
                ->values(implode(',', $values));
        }

        $db->setQuery($query);
        $db->execute();

        echo json_encode(['success' => true]);
        $app->close();
    }

    public function freeSeat()
    {
        Session::checkToken() or jexit(Text::_('JINVALID_TOKEN'));

        $app = Factory::getApplication();
        $input = $app->input;
        
        $seatKey = $input->getString('seat_key');

        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->delete($db->quoteName('#__sitzplan_seats'))
            ->where($db->quoteName('seat_key') . ' = ' . $db->quote($seatKey));
        
        $db->setQuery($query);
        $db->execute();

        echo json_encode(['success' => true]);
        $app->close();
    }

    public function addZone()
    {
        Session::checkToken() or jexit(Text::_('JINVALID_TOKEN'));

        $app = Factory::getApplication();
        $input = $app->input;
        
        $name = $input->getString('name');
        $count = $input->getInt('count');
        $position = $input->getString('position');
        $genderRule = $input->getString('gender_rule');

        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        
        $columns = ['name', 'count', 'position', 'gender_rule', 'created_date'];
        $values = [
            $db->quote($name),
            $db->quote($count),
            $db->quote($position),
            $db->quote($genderRule),
            'NOW()'
        ];
        
        $query->insert($db->quoteName('#__sitzplan_zones'))
            ->columns($db->quoteName($columns))
            ->values(implode(',', $values));
        
        $db->setQuery($query);
        $db->execute();
        
        $newId = $db->insertid();

        echo json_encode(['success' => true, 'id' => $newId]);
        $app->close();
    }

    public function removeZone()
    {
        Session::checkToken() or jexit(Text::_('JINVALID_TOKEN'));

        $app = Factory::getApplication();
        $input = $app->input;
        
        $zoneId = $input->getInt('zone_id');

        $db = Factory::getDbo();
        
        // Delete seats in this zone first
        $query = $db->getQuery(true);
        $query->delete($db->quoteName('#__sitzplan_seats'))
            ->where($db->quoteName('seat_key') . ' LIKE ' . $db->quote('Z' . $zoneId . '_%'));
        $db->setQuery($query);
        $db->execute();
        
        // Delete the zone
        $query = $db->getQuery(true);
        $query->delete($db->quoteName('#__sitzplan_zones'))
            ->where($db->quoteName('id') . ' = ' . $db->quote($zoneId));
        
        $db->setQuery($query);
        $db->execute();

        echo json_encode(['success' => true]);
        $app->close();
    }
}