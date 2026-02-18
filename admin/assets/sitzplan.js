// sitzplan.js

class SeatingZone {
    constructor(name) {
        this.name = name;
        this.seats = [];
    }

    addSeat(seat) {
        this.seats.push(seat);
    }

    getAvailableSeats() {
        return this.seats.filter(seat => !seat.isOccupied);
    }
}

class Seat {
    constructor(id) {
        this.id = id;
        this.isOccupied = false;
    }

    occupy() {
        this.isOccupied = true;
    }

    vacate() {
        this.isOccupied = false;
    }
}

class SeatingConfiguration {
    constructor() {
        this.zones = [];
    }

    addZone(zone) {
        this.zones.push(zone);
    }

    getAllAvailableSeats() {
        return this.zones.reduce((availableSeats, zone) => 
            availableSeats.concat(zone.getAvailableSeats()), []);
    }
}

// Sample Interactive Functionality
document.addEventListener('DOMContentLoaded', () => {
    const config = new SeatingConfiguration();

    // Example of creating zones and seats
    const zoneA = new SeatingZone('Zone A');
    zoneA.addSeat(new Seat(1));
    zoneA.addSeat(new Seat(2));

    const zoneB = new SeatingZone('Zone B');
    zoneB.addSeat(new Seat(3));
    zoneB.addSeat(new Seat(4));

    config.addZone(zoneA);
    config.addZone(zoneB);

    // Display available seats
    console.log('Available Seats:', config.getAllAvailableSeats());
});
