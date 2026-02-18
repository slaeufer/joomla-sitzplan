<?php
defined('_JEXEC') or die;

use Joomla\CMS\Installer\InstallerScript;

class com_sitzplanInstallerScript extends InstallerScript
{
    protected $minimumPhp = '7.4.0';
    protected $minimumJoomla = '4.0.0';

    public function preflight($type, $parent)
    {
        if (version_compare(PHP_VERSION, $this->minimumPhp, '<')) {
            throw new RuntimeException('This extension requires PHP ' . $this->minimumPhp . ' or higher.');
        }

        if (version_compare(JVERSION, $this->minimumJoomla, '<')) {
            throw new RuntimeException('This extension requires Joomla ' . $this->minimumJoomla . ' or higher.');
        }

        return true;
    }

    public function install($parent)
    {
        echo '<p>Sitzplan component installed successfully!</p>';
        return true;
    }

    public function update($parent)
    {
        echo '<p>Sitzplan component updated successfully!</p>';
        return true;
    }

    public function uninstall($parent)
    {
        echo '<p>Sitzplan component uninstalled successfully!</p>';
        return true;
    }

    public function postflight($type, $parent)
    {
        if ($type === 'install' || $type === 'update') {
            echo '<h3>Welcome to Sitzplan - Seating Planner</h3>';
            echo '<p>A complete seating arrangement solution with:</p>';
            echo '<ul>';
            echo '<li>SVG-based seat visualization</li>';
            echo '<li>Gender-based seating rules (M left, F right)</li>';
            echo '<li>Zone management (VIP areas, orchestra, etc.)</li>';
            echo '<li>Real-time statistics</li>';
            echo '<li>Admin & Helper viewing modes</li>';
            echo '<li>18 pre-loaded sample participants</li>';
            echo '</ul>';
            echo '<p>Navigate to Components > Sitzplan to get started.</p>';
        }

        return true;
    }
}
