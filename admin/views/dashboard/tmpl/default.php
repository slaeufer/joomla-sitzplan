<?php
defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;

HTMLHelper::_('behavior.keepalive');
?>

<div id="sitzplan-app">
    <div class="sitzplan-header">
        <div>
            <h1><?php echo Text::_('COM_SITZPLAN'); ?> Dashboard</h1>
            <div class="sub" id="eventName">Musterveranstaltung 2025</div>
        </div>
        <div class="mode-row">
            <button class="mode-btn admin active" onclick="setMode('admin')">Admin-Modus</button>
            <button class="mode-btn helfer" onclick="setMode('helfer')">Helfer-Ansicht</button>
        </div>
    </div>

    <div class="layout">
        <aside id="sidebar">
            <!-- Configuration Section -->
            <div id="configSection">
                <h2>Raumkonfiguration</h2>
                <div class="cfg-grid">
                    <div>
                        <label>Reihen</label>
                        <input id="cR" type="number" value="8" min="1" max="30">
                    </div>
                    <div>
                        <label>Sitze links</label>
                        <input id="cL" type="number" value="6" min="1" max="20">
                    </div>
                    <div>
                        <label>Sitze rechts</label>
                        <input id="cRR" type="number" value="6" min="1" max="20">
                    </div>
                    <div>
                        <label>Gang (px)</label>
                        <input id="cG" type="number" value="44" min="10" max="120">
                    </div>
                </div>
                <button class="btn-build" onclick="rebuild()">↻ Saal neu aufbauen</button>
            </div>

            <!-- Zone Management Section -->
            <div id="zoneAddSection">
                <h2>Sonderbereiche</h2>
                <div id="zoneList"></div>
                <div class="add-zone-form" style="margin-top:10px">
                    <div>
                        <label>Bezeichnung</label>
                        <input id="zName" type="text" placeholder="z.B. Ehrenreihe, Orchester">
                    </div>
                    <div class="cfg-grid">
                        <div>
                            <label>Anzahl Stühle</label>
                            <input id="zCount" type="number" value="5" min="1" max="30">
                        </div>
                        <div>
                            <label>Position</label>
                            <select id="zPos">
                                <option value="vorne">Vorne</option>
                                <option value="hinten">Hinten</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label>Geschlecht-Regel</label>
                        <select id="zGender">
                            <option value="offen">Offen (M & F)</option>
                            <option value="M">Nur Männer</option>
                            <option value="F">Nur Frauen</option>
                        </select>
                    </div>
                    <button class="btn-addzone" onclick="addZone()">+ Bereich hinzufügen</button>
                </div>
            </div>

            <!-- Legend Section -->
            <div id="legendSection">
                <h2>Legende</h2>
                <div class="legend">
                    <div class="leg">
                        <div class="ldot" style="background:#dde1e9"></div>
                        Frei (Hauptraster)
                    </div>
                    <div class="leg">
                        <div class="ldot" style="background:#2980b9"></div>
                        Mann (links)
                    </div>
                    <div class="leg">
                        <div class="ldot" style="background:#c0392b"></div>
                        Frau (rechts)
                    </div>
                    <div class="leg">
                        <div class="ldot" style="background:#e67e22"></div>
                        Frau links (Überlauf)
                    </div>
                    <div class="leg">
                        <div class="ldot" style="background:#8e44ad"></div>
                        Sonderbereich vorne
                    </div>
                    <div class="leg">
                        <div class="ldot" style="background:#16a085"></div>
                        Sonderbereich hinten
                    </div>
                </div>
            </div>

            <!-- Statistics (will be dynamically inserted) -->
            <div id="statsSection"></div>

            <!-- Participant List (will be dynamically inserted) -->
            <div id="plistSection"></div>
        </aside>

        <main>
            <div class="stage">Bühne</div>
            <div id="svg-wrap">
                <!-- SVG seating chart will be rendered here by JavaScript -->
            </div>
        </main>
    </div>

    <!-- Popup Overlay -->
    <div id="overlay" class="overlay">
        <div class="popup">
            <h3 id="pTitle">Sitzplatz zuweisen</h3>
            <div class="pinfo" id="pInfo">Reihe 1, Platz 1 links</div>
            <div id="pBody">
                <!-- Popup content will be dynamically inserted here -->
            </div>
        </div>
    </div>
</div>

<style>
    .page-title {
        display: none;
    }
    
    #sitzplan-app {
        margin: -15px -15px 0 -15px;
    }
</style>
