///////////////////// LATEST TRIPS ///////////////////

// Select the div by its ID
let myDiv = document.getElementById("latest-trips");

// Creating an array of dictionaries (objects)
let data = [
    { "month": 9, "year": 2024, "place": "Leh, Ladakh", "description": "Leh &rarr; Zanskar Valley &rarr; Tso Pangong &rarr; Tso Moriri", "image-source": "images/travel/leh/shanti_stupa_8.jpg", "image-caption": "View from Tsemo Maitrey temple", "link": "blog.html?a=leh"},
    { "month": 8, "year": 2024, "place": "Nepal", "description": "Dang &rarr; Lumbini", "image-source": "images/travel/nepal/tulsipur.jpg", "image-caption": "View point near Tulsipur", "link": "blog.html?a=nepal"},
    { "month": 5, "year": 2024, "place": "National Parks and National Monuments, USA", "description": "Death valley &rarr; Zion &rarr; Bryce canyon &rarr; Grand staircase &rarr; Glen canyon &rarr; Horseshoe bend &rarr; Grand canyon &rarr; Yosemite &rarr; Sequoia &rarr; Muir woods &rarr; Yellowstone &rarr; Grand Teton &rarr; Arches &rarr; Canyonlands", "image-source": "images/travel/usa/bryce-canyon.jpg", "image-caption": "Bryce Canyon", "link": "blog.html?a=national_parks"},
    { "month": 2, "year": 2024, "place": "North America", "description": "Portland, Maine &rarr; Quebec city &rarr; Montreal", "image-source": "images/travel/canada/quebec-1.jpg", "image-caption": "Quebec city", "link": "#"},
    { "month": 10, "year": 2023, "place": "Alberta & British Columbia, Canada", "description": "Calgary &rarr; Banff National Park &rarr; Yoho National Park", "image-source": "images/travel/canada/alberta.jpg", "image-caption": "Banff national park", "link": "#"},
    { "month": 9, "year": 2023, "place": "Vietnam", "description": "Sapa &rarr; Hai Phong &rarr; Cat Ba &rarr; Phu Quoc", "image-source": "images/travel/destination/vietnam.jpg", "image-caption": "Ha Long bay", "link": "#"},
    { "month": 9, "year": 2023, "place": "Georgia", "description": "Tbilisi &rarr; Kazbegi &rarr; Sighnagi &rarr; Mtskheta", "image-source": "images/travel/georgia/kazbegi.jpg", "image-caption": "Kazbegi", "link": "#"},
    { "month": 8, "year": 2023, "place": "Lonavala", "description": "Kataldhar waterfall", "image-source": "images/travel/kataldhar_waterfall/1.jpg", "image-caption": "Kataldhar waterfall", "link": "#"},
    { "month": 1, "year": 2023, "place": "Thailand", "description": "Krabi &rarr; Koh Tao &rarr; Chiang Mai &rarr; Pai &rarr; Chiang Rai", "image-source": "images/travel/thailand/krabi-1.jpg", "image-caption": "Krabi", "link": "#"},
    { "month": 12, "year": 2022, "place": "Malaysia", "description": "Kuala Lumpur &rarr; Melacca &rarr; Georgetown &rarr; Langkavi", "image-source": "images/travel/malaysia/georgetown-1.jpg", "image-caption": "Georgetown", "link": "#"},
    { "month": 11, "year": 2022, "place": "Indonesia", "description": "Bali &rarr; Nusa Lembongan &rarr; Ubud &rarr; Banyuwangi &rarr; Bandung &rarr; Yogyakarta &rarr; Jakarta", "image-source": "images/travel/destination/indonesia.jpg", "image-caption": "Mount Bromo", "link": "#"},
    { "month": 10, "year": 2022, "place": "India", "description": "Kochi &rarr; Varkala &rarr; Allepey &rarr; Munnar &rarr; Coimbatore &rarr; Ahmedabad &rarr; Manali &rarr; Agra &rarr; Dharamshala &rarr; Mcleodganj", "image-source": "images/travel/destination/india.jpg", "image-caption": "Taj Mahal", "link": "#"},
    { "month": 9, "year": 2022, "place": "Vietnam", "description": "Hanoi &rarr; Ha Giang &rarr; Halong bay &rarr; Ninh Binh &rarr; Dalat &rarr; Hue &rarr; Hoi An &rarr; Ho Chi Minh", "image-source": "images/travel/destination/vietnam.jpg", "image-caption": "Ha Long bay", "link": "#"},
    { "month": 8, "year": 2022, "place": "Laos", "description": "Vientiane &rarr; Vang Vieng &rarr; Luang Prabang &rarr; Nong Khiaw", "image-source": "images/travel/laos/vangviang-1.jpg", "image-caption": "Vang Viang", "link": "#"},
    { "month": 8, "year": 2022, "place": "Thailand", "description": "Bangkok &rarr; Koh Samui &rarr; Koh Phangan", "image-source": "images/travel/thailand/krabi-1.jpg", "image-caption": "Krabi", "link": "#"},
    { "month": 4, "year": 2022, "place": "USA", "description": "San Francisco &rarr; Los Angeles &rarr; San Diego &rarr; Las Vegas &rarr; Grand Canyon, Arizona &rarr; Denver &rarr; New Orleans &rarr; Chicago &rarr; Washington &rarr; Philadelphia &rarr; Atlantic city &rarr; New York", "image-source": "images/travel/usa/philadelphia-1.jpg", "image-caption": "Philadelphia", "link": "#"},
];

function numberToMonth(monthNumber) {
    // Array of abbreviated month names
    const months = [
        "Jan", "Feb", "Mar", "Apr", "May", "Jun",
        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
    ];

    // Ensure the month number is within the valid range (1-12)
    if (monthNumber < 1 || monthNumber > 12) {
        console.log("Invalid month number");
    }

    // Return the corresponding abbreviated month name
    return months[monthNumber - 1];
}

// Using a for loop to iterate through the array
let content = ``;
for (let i = 0; i < data.length; i++) {
  let month = numberToMonth(data[i]["month"]);
  let year = data[i]["year"];
  let place = data[i]["place"];
  let description = data[i]["description"];
  let image_source = data[i]["image-source"];
  let image_caption = data[i]["image-caption"];
  let link = data[i]["link"];
  content = content+`<div class="col-lg-4 col-md-6 mb-4 pb-2">
      <div class="blog-item" >
          <div class="position-relative">
              <img class="img-fluid w-100" src="${image_source}" alt="${image_caption}">
              <div class="blog-date">
                  <h6 class="font-weight-bold mb-n1">${month}</h6>
                  <small class="text-white text-uppercase">${year}</small>
              </div>
          </div>
          <div class="bg-white p-4">
              <div class="d-flex mb-2">
                  <a class="text-primary text-uppercase text-decoration-none" href="${link}" >${place}</a>
              </div>
              <a class="h5 m-0 text-decoration-none" href="${link}" >${description}</a>
          </div>
      </div>
  </div>`;
}
myDiv.innerHTML = content;

function searchInDataArray(query) {
  let indices = [];

  content = ``;
  data.forEach((dict, index) => {
      // Check if any value in the dictionary contains the query
      if (Object.values(dict).some(value => value.toString().toLowerCase().includes(query.toLowerCase()))) {
          indices.push(index);
          month = numberToMonth(data[index]["month"]);
          year = data[index]["year"];
          place = data[index]["place"];
          description = data[index]["description"];
          image_source = data[index]["image-source"];
          image_caption = data[index]["image-caption"];
          link = data[index]["link"];
          content = content+`<div class="col-lg-4 col-md-6 mb-4 pb-2">
              <div class="blog-item" >
                  <div class="position-relative">
                      <img class="img-fluid w-100" src="${image_source}" alt="${image_caption}">
                      <div class="blog-date">
                          <h6 class="font-weight-bold mb-n1">${month}</h6>
                          <small class="text-white text-uppercase">${year}</small>
                      </div>
                  </div>
                  <div class="bg-white p-4">
                      <div class="d-flex mb-2">
                          <a class="text-primary text-uppercase text-decoration-none" href="${link}" >${place}</a>
                      </div>
                      <a class="h5 m-0 text-decoration-none" href="${link}" >${description}</a>
                  </div>
              </div>
          </div>`;
      }
  });

  myDiv.innerHTML = content;
}

///////////////////// TRAVEL TIPS ///////////////////

// Select the div by its ID
myDiv2 = document.getElementById("travel-tips");

// Creating an array of dictionaries (objects)
data2 = [
    {"title" :"USA Tourist/Business Visa", "subtitle" : "Interview-waiver" , "image-source" : "images/travel/usa/flag.jpg", "image-caption" : "USA flag", "link": "blog.html?a=usa_visa"},
    {"title" :"FTI-TTP", "subtitle" : "Trusted traveler program", "image-source" : "images/travel/ttp_logo.png", "image-caption" : "FTI-TTP logo", "link": "blog.html?a=ftittp"},
    {"title" :"Visa-Free Travel", "subtitle" : "First world countries' visa", "image-source" : "images/travel/usa/flag.jpg", "image-caption" : "USA flag", "link": "https://visalist.io/visa/travel/us-visa"},
    {"title" :"Global Entry", "subtitle": "Trusted traveler program", "image-source" : "images/gep/logo.jpg", "image-caption" : "GEP logo", "link": "blog.html?a=gep"},
    {"title" :"Canada Tourist Visa", "subtitle" : "Application timeline", "image-source" : "images/travel/canada/flag.jpg", "image-caption" : "Canada flag", "link": "blog.html?a=canada_visa"},
    {"title" :"Camping", "subtitle": "Checklist", "image-source" : "images/travel/camping.jpg", "image-caption" : "Camping", "link": "#"},
];

// Using a for loop to iterate through the array
content = ``;
for (let i = 0; i < data2.length; i++) {
  let title = data2[i]["title"];
  let subtitle = data2[i]["subtitle"];
  let image_source = data2[i]["image-source"];
  let image_caption = data2[i]["image-caption"];
  let link = data2[i]["link"];
  content = content+`<div class="col-lg-4 col-md-6 mb-4">
                  <div class="destination-item position-relative overflow-hidden mb-2">
                      <img class="img-fluid" src="${image_source}" alt="${image_caption}">
                      <a class="destination-overlay text-white text-decoration-none" href="${link}">
                          <h5 class="text-white">${title}</h5>
                          <span>${subtitle}</span>
                      </a>
                  </div>
              </div>`;
}
myDiv2.innerHTML = content;

function searchInDataArray2(query) {
  let indices = [];

  content = ``;
  data2.forEach((dict, index) => {
      // Check if any value in the dictionary contains the query
      if (Object.values(dict).some(value => value.toString().toLowerCase().includes(query.toLowerCase()))) {
          indices.push(index);
          title = data2[index]["title"];
          subtitle = data2[index]["subtitle"];
          image_source = data2[index]["image-source"];
          image_caption = data2[index]["image-caption"];
          link = data2[index]["link"];
          content = content+`<div class="col-lg-4 col-md-6 mb-4">
                          <div class="destination-item position-relative overflow-hidden mb-2">
                              <img class="img-fluid" src="${image_source}" alt="${image_caption}">
                              <a class="destination-overlay text-white text-decoration-none" href="${link}">
                                  <h5 class="text-white">${title}</h5>
                                  <span>${subtitle}</span>
                              </a>
                          </div>
                      </div>`;
      }
  });

  myDiv2.innerHTML = content;
}
