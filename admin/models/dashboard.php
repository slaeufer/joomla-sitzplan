<?php
defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\CMS\Factory;

class SitzplanModelDashboard extends BaseDatabaseModel
{
    /**
     * Get configuration settings
     *
     * @return object Configuration object
     */
    public function getConfig()
    {
        $db = $this->getDbo();
        $query = $db->getQuery(true);
        
        $query->select('setting_key, setting_value')
            ->from($db->quoteName('#__sitzplan_config'));
        
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        
        $config = new stdClass();
        foreach ($rows as $row) {
            $config->{$row->setting_key} = $row->setting_value;
        }
        
        return $config;
    }

    /**
     * Get all zones
     *
     * @return array Array of zone objects
     */
    public function getZones()
    {
        $db = $this->getDbo();
        $query = $db->getQuery(true);
        
        $query->select('*')
            ->from($db->quoteName('#__sitzplan_zones'))
            ->order('ordering ASC, id ASC');
        
        $db->setQuery($query);
        return $db->loadObjectList();
    }

    /**
     * Get all seat assignments
     *
     * @return array Associative array of seat assignments
     */
    public function getSeats()
    {
        $db = $this->getDbo();
        $query = $db->getQuery(true);
        
        $query->select('*')
            ->from($db->quoteName('#__sitzplan_seats'));
        
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        
        $seats = [];
        foreach ($rows as $row) {
            $seats[$row->seat_key] = [
                'person_id' => $row->person_id,
                'person_name' => $row->person_name,
                'person_gender' => $row->person_gender
            ];
        }
        
        return $seats;
    }

    /**
     * Get all participants
     *
     * @return array Array of participant objects
     */
    public function getParticipants()
    {
        $db = $this->getDbo();
        $query = $db->getQuery(true);
        
        $query->select('*')
            ->from($db->quoteName('#__sitzplan_participants'))
            ->order('name ASC');
        
        $db->setQuery($query);
        return $db->loadObjectList();
    }

    /**
     * Get statistics
     *
     * @return object Statistics object
     */
    public function getStatistics()
    {
        $db = $this->getDbo();
        
        // Count male participants assigned
        $query = $db->getQuery(true);
        $query->select('COUNT(*)')
            ->from($db->quoteName('#__sitzplan_seats'))
            ->where($db->quoteName('person_gender') . ' = ' . $db->quote('M'));
        $db->setQuery($query);
        $maleCount = (int) $db->loadResult();
        
        // Count female participants assigned
        $query = $db->getQuery(true);
        $query->select('COUNT(*)')
            ->from($db->quoteName('#__sitzplan_seats'))
            ->where($db->quoteName('person_gender') . ' = ' . $db->quote('F'));
        $db->setQuery($query);
        $femaleCount = (int) $db->loadResult();
        
        // Get total participants
        $query = $db->getQuery(true);
        $query->select('COUNT(*)')
            ->from($db->quoteName('#__sitzplan_participants'));
        $db->setQuery($query);
        $totalParticipants = (int) $db->loadResult();
        
        $stats = new stdClass();
        $stats->assigned_male = $maleCount;
        $stats->assigned_female = $femaleCount;
        $stats->assigned_total = $maleCount + $femaleCount;
        $stats->total_participants = $totalParticipants;
        $stats->unassigned = $totalParticipants - $stats->assigned_total;
        
        return $stats;
    }
}
