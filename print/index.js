// Define the Options class
class Options {
  constructor(colorMode, paperSize, paperQuality) {
    this.colorMode = colorMode; // e.g., 'Black and White' or 'Colored'
    this.paperSize = paperSize; // e.g., 'A4', 'Letter'
    this.paperQuality = paperQuality; // e.g., 'Standard', 'Premium'
  }

  // Method to display options details
  displayOptions() {
    console.log(`Color Mode: ${this.colorMode}`);
    console.log(`Paper Size: ${this.paperSize}`);
    console.log(`Paper Quality: ${this.paperQuality}`);
  }
}

// Define the Print class
class Print {
  constructor(username, contact, address, options) {
    this.username = username;
    this.contact = contact;
    this.address = address;
    this.options = options; // an instance of Options class
  }

  // Method to display print job details
  displayPrintDetails() {
    console.log(`Username: ${this.username}`);
    console.log(`Contact: ${this.contact}`);
    console.log(`Address: ${this.address}`);
    console.log('Options:');
    this.options.displayOptions(); // Call method from Options class
  }
}

// Create an instance of Options
const printOptions = new Options('Colored', 'A4', 'Premium');

// Create an instance of Print with the Options instance
const printJob = new Print('John Doe', '123-456-7890', '123 Main St, Anytown', printOptions);

// Display the details of the print job
printJob.displayPrintDetails();
