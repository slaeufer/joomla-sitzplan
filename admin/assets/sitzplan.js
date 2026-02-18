// Seating Planner Application Logic

class SeatingPlanner {
    constructor(seatingChart) {
        this.seatingChart = seatingChart;
        this.seatedGuests = {};
    }

    seatGuest(guestName, seatNumber) {
        if (this.seatedGuests[guestName]) {
            console.log(`${guestName} is already seated.`);
            return false;
        }
        if (this.seatingChart[seatNumber]) {
            console.log(`${guestName} has been seated at ${seatNumber}.`);
            this.seatedGuests[guestName] = seatNumber;
            return true;
        } else {
            console.log(`Seat ${seatNumber} is not available.`);
            return false;
        }
    }

    removeGuest(guestName) {
        if (this.seatedGuests[guestName]) {
            const seatNumber = this.seatedGuests[guestName];
            delete this.seatedGuests[guestName];
            console.log(`${guestName} has been removed from seat ${seatNumber}.`);
            return true;
        } else {
            console.log(`${guestName} is not seated.`);
            return false;
        }
    }

    displaySeatedGuests() {
        console.log("Seated Guests:");
        for (let guest in this.seatedGuests) {
            console.log(`${guest}: ${this.seatedGuests[guest]}`);
        }
    }
}

// Example usage:
const seatingChart = {
    'A1': true,
    'A2': true,
    'B1': true,
    'B2': true
};

const planner = new SeatingPlanner(seatingChart);
planner.seatGuest('John Doe', 'A1');
planner.seatGuest('Jane Smith', 'A2');
planner.displaySeatedGuests();
planner.removeGuest('John Doe');
planner.displaySeatedGuests();