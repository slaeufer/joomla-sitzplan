# Joomla Sitzplan Component

A complete seating planner component for Joomla 4.x that allows you to manage event seating arrangements with support for gender-based rules, special zones, and overflow handling.

## Features

✅ **Flexible Seating Configuration**
- Customizable number of rows and seats per side
- Adjustable aisle width
- Create special zones (front/back, gender-specific)

✅ **Gender-Based Seating Rules**
- Automatic gender segregation (Men left, Women right)
- Overflow handling for women to left side when needed
- Special zones with gender restrictions

✅ **Admin & Helper Modes**
- Admin: Full control to assign seats
- Helper: View-only mode for volunteers

✅ **Real-Time Statistics**
- Live participant count (men/women/free seats)
- Overflow warnings
- Visual seating overview

✅ **Demo Data Included**
- Pre-loaded with 18 sample participants
- Demo zones (Ehrenreihe, Orchester)
- Ready to use out of the box

## Installation

### Step 1: Download
- Clone or download this repository as ZIP

### Step 2: Create ZIP Package
If cloning, compress the entire folder as `com_sitzplan.zip`

### Step 3: Install in Joomla
1. Login to Joomla Admin Panel
2. Go to **System → Install Extensions**
3. Upload the ZIP file
4. Component will automatically:
   - Create database tables
   - Insert sample data
   - Set default configuration

### Step 4: Access Component
Go to **Components → Sitzplan** in the admin menu

## Usage

### Configuration
1. Adjust room layout:
   - **Rows**: Number of seating rows
   - **Seats left**: Male section seats per row
   - **Seats right**: Female section seats per row
   - **Aisle**: Gap between sections in pixels

### Creating Special Zones
1. Enter zone name (e.g., "Ehrenreihe", "Orchester")
2. Set number of seats
3. Choose position (front/back)
4. Apply gender rule (open/men only/women only)
5. Click "Bereich hinzufügen"

### Assigning Seats
1. Click on any empty seat
2. Select participant from dropdown
3. System shows warnings for rule violations
4. Click "Zuweisen" to assign

### Modes
- **Admin Mode**: Assign/free seats, create/delete zones, configure room
- **Helper Mode**: View only, useful for checking-in participants

## Database Schema

### Tables Created
- `#__sitzplan_config` - Room configuration settings
- `#__sitzplan_participants` - List of attendees
- `#__sitzplan_zones` - Special seating areas
- `#__sitzplan_seats` - Individual seat assignments

## Requirements
- Joomla 4.0+
- PHP 7.4+
- MySQL 5.7+ / MariaDB 10.2+

## File Structure
```
joomla-sitzplan/
├── sitzplan.xml              # Component manifest
├── script.php                # Installation script
├── admin/
│   ├── sitzplan.php         # Main entry point
│   ├── controller.php       # Request handler
│   ├── models/
│   │   └── dashboard.php    # Data model
│   ├── views/
│   │   └── dashboard/
│   │       ├── view.html.php
│   │       └── tmpl/
│   │           └── default.php
│   ├── language/
│   │   ├── de-DE/
│   │   └── en-GB/
│   ├── sql/
│   │   └── mysql/
│   │       ├── install.sql
│   │       └── uninstall.sql
│   └── assets/
│       ├── sitzplan.css
│       └── sitzplan.js
└── README.md
```

## Sample Data

The component comes pre-loaded with 18 sample participants and 2 demo zones:

**Participants**: Mix of German and international names with M/F gender distribution

**Demo Zones**:
- Ehrenreihe (6 seats, front, open)
- Orchester (8 seats, back, men only)

## Support

For issues, questions, or suggestions, please create an issue in this repository.

## License

GNU General Public License v2 and later

## Version
1.0.0 (2026-02-18)