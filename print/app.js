const API_URL = 'get_printers.php';

// Pricing data (example)
const pricingData = {
    color: {
        A4: { standard: 0.15, premium: 0.25 },
        A3: { standard: 0.25, premium: 0.35 }
    },
    bw: {
        A4: { standard: 0.10, premium: 0.20 },
        A3: { standard: 0.20, premium: 0.30 }
    }
};

window.onload = () => {
    // Check the current URL and show the corresponding step
    const step = getStepFromUrl();
    showStep(step, false);
    window.onpopstate = handlePopState;
};

function fetchPrinters() {
    const pages = document.getElementById('pages').value;
    const color = document.getElementById('color').value;
    const paperSize = document.getElementById('paper-size').value;
    const paperQuality = document.getElementById('paper-quality').value;

    fetch(`${API_URL}?pages=${pages}&color=${color}&paperSize=${paperSize}&paperQuality=${paperQuality}`)
        .then(response => response.json())
        .then(data => {
            displayPrinters(data);
            showStep(2); // Show printers list after fetching
        })
        .catch(error => console.error('Error:', error));
}

function displayPrinters(printers) {
    const printerList = document.getElementById('printer-list');
    printerList.innerHTML = '';

    printers.forEach(printer => {
        const div = document.createElement('div');
        div.className = 'printer';
        div.innerHTML = `
            <h3>${printer.name}</h3>
            <p>Location: ${printer.location}</p>
            <p>Color Options: ${printer.colorOptions.join(', ')}</p>
            <p>Paper Sizes: ${printer.paperSizes.join(', ')}</p>
            <p>Paper Quality: ${printer.paperQuality.join(', ')}</p>
            <p>Available Time Slots: ${printer.availableTimeSlots.join(', ')}</p>
            <p>Price: $${printer.price}</p>
            <button type="button" onclick="showPrinterDetails(${printer.id}, '${printer.location}', '${printer.availableTimeSlots.join(', ')}', ${printer.price})">Select</button>
        `;
        printerList.appendChild(div);
    });
}

function showPrinterDetails(printerId, location, timeSlots, price) {
    document.getElementById('printer-location').textContent = `Location: ${location}`;
    document.getElementById('printer-available-time').textContent = `Available Time Slots: ${timeSlots}`;
    document.getElementById('total-price').textContent = price.toFixed(2);

    window.selectedPrinterId = printerId;

    showStep(3); // Show printer details step
}

function submitPrintJob() {
    const printerId = window.selectedPrinterId;
    const pages = document.getElementById('pages').value;
    const file = document.getElementById('file').files[0];

    const formData = new FormData();
    formData.append('printerId', printerId);
    formData.append('pages', pages);
    formData.append('file', file);

    fetch('submit_print_job.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert(`Print job submitted! Total price: $${data.price}`);
        showStep(1); // Optionally return to the first step
    })
    .catch(error => console.error('Error:', error));
}

function showStep(stepNumber, pushState = true) {
    document.querySelectorAll('.step').forEach(step => {
        step.style.display = 'none';
    });
    document.getElementById(`step${stepNumber}`).style.display = 'block';

    if (pushState) {
        const url = `?step=${stepNumber}`;
        history.pushState({ step: stepNumber }, `Step ${stepNumber}`, url);
    }
}

function getStepFromUrl() {
    const urlParams = new URLSearchParams(window.location.search);
    return parseInt(urlParams.get('step')) || 1;
}

function handlePopState(event) {
    if (event.state && event.state.step) {
        showStep(event.state.step, false);
    } else {
        showStep(1, false);
    }
}
