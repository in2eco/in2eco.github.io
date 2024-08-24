// Add opening divs at the top of the body
document.body.innerHTML = '<div class="wrapper"><div class="docs-content">' + document.body.innerHTML;

// Create a closing HTML snippet
const closingHTML = '</div></div>';

// Find all script tags
const scripts = document.body.getElementsByTagName('script');
const lastScript = scripts.length ? scripts[scripts.length - 1] : null;

// Insert closing divs before the last script tag
if (lastScript) {
    // Insert closingHTML before the last script tag
    lastScript.insertAdjacentHTML('beforebegin', closingHTML);
} else {
    // If no script tags are present, append at the end
    document.body.innerHTML += closingHTML;
}

//////////////////////// START: META TAGS ////////////////////////

const title = document.title;
const path = window.location.pathname;
// Function to fetch the content of a meta tag with a specific name or property
function getMetaTagContent(nameOrProperty) {
    const metaTag = document.querySelector(`meta[name="${nameOrProperty}"], meta[property="${nameOrProperty}"]`);
    return metaTag ? metaTag.content : null;
}
// Fetch the description meta tag content
const descriptionContent = getMetaTagContent("description");

// Array of meta tag data
const metaTags = [
    { name: 'description', content: (descriptionContent ? descriptionContent : title)},
    { name: 'author', content: 'Anurag Gupta' },
    { name: 'viewport', content: 'width=device-width, initial-scale=1.0' },
    { property: 'og:title', content: title},
    { property: 'og:type', content: 'article'},
    { property: 'og:description', content: (descriptionContent ? descriptionContent : title)},
    { property: 'og:url', content: 'in2eco.com'+path},
    { property: 'og:url', content: 'images/in2eco-logo.png'},
    { property: 'og:site_name', content: '@in2eco'},
    { name: 'twitter:card', content: 'summary_large_image' },
    { name: 'twitter:image', content: 'images/in2eco-logo.png' },
    { name: 'twitter:title', content: title},
    { name: 'twitter:description', content: (descriptionContent ? descriptionContent : title)},
    { name: 'twitter:site', content: '@in_2_eco' },
];
// Function to check if a meta tag with a specific name or property exists
function metaTagExists(nameOrProperty, value) {
    return document.head.querySelector(`meta[${nameOrProperty}="${value}"]`) !== null;
}
// Loop over the array and create each meta tag
metaTags.forEach(tagData => {
    const attr = tagData.name ? 'name' : 'property';
    const value = tagData[attr];
    if (!metaTagExists(attr, value)) {
      // Create a new meta tag
      const meta = document.createElement('meta');
      meta.setAttribute(attr, value);
      meta.content = tagData.content;

      // Append it to the head
      document.head.appendChild(meta);
    }
});

//////////////////////// START: AUTHOR DETAILS ////////////////////////
// Function to add author details in the appropriate div
function addAuthorDetails(authorDetails) {
  // console.log(authorDetails.name)
    // First, check if there is a div with id 'author-details'
    const authorDetailsDiv = document.getElementById('author-details');

    if (authorDetailsDiv) {
        // If the div with id 'author-details' exists, add the author details there
        // Create an <hr> element
        var hr = document.createElement('hr');
        // Append it to the body or any other element
        authorDetailsDiv.appendChild(hr);
        // Create an h2 element for the heading
        const heading = document.createElement('h3');
        heading.textContent = 'Author'; // Set the heading text
        textContent = authorDetails; // Set the heading text
        // Append the heading to the target div
        authorDetailsDiv.appendChild(heading);

        // Add the text before the link
        // authorDetailsDiv.appendChild(document.createTextNode(textBeforeLink));

        // Create the anchor element for the link
        const link = document.createElement('a');
        link.textContent = authorDetails.name; // Set the link text
        link.href = authorDetails.link; // Set the href attribute

        // Append the link to the target div
        authorDetailsDiv.appendChild(link);

        // Add the text after the link
        authorDetailsDiv.appendChild(document.createTextNode(' '+authorDetails.description));

    }
    else {
      console.log("'author-details' div not found.");
    }
}

// Function to get the content of the meta tag with name 'author'
function getAuthorFromMeta() {
    const authorMetaTag = document.querySelector('meta[name="author"]');
    return authorMetaTag ? authorMetaTag.content : null;
}

const authorName = getAuthorFromMeta();
if (authorName=='Anurag Gupta'){
  addAuthorDetails({"name": "Anurag Gupta", "link":"http://www.anuragg.in", "description": "is a passionate traveller and an advocate of eco-tourism and sustainable living. He helps local businesses in promoting their visibility and accessibility. Anurag Gupta is also an educator and a technology consultant. He is an M.S. graduate in Electrical and Computer Engineering from Cornell University. He also holds an M.Tech degree in Systems and Control Engineering and a B.Tech degree in Electrical Engineering from the Indian Institute of Technology, Bombay."});
}

//////////////////////// START: TABLE OF CONTENT ////////////////////////

document.addEventListener("DOMContentLoaded", function() {
    // Get the container where the list will be added
    var wrapper = document.querySelector('.wrapper');

    // Create a new list element
    var list = document.createElement('ul');
    list.className = 'docs-nav';

    // Create the "Home" list item
    var homeListItem = document.createElement('li');
    var homeAnchor = document.createElement('a');
    homeAnchor.href = 'http://www.in2eco.com';
    homeAnchor.innerHTML = '<strong>Home</strong>';
    homeListItem.appendChild(homeAnchor);
    list.appendChild(homeListItem);

    // Select all h3 tags within the docs-content class
    var headers = document.querySelectorAll('.docs-content h3');
    function generateIdFromTitle(title) {
        return title
            .toLowerCase()               // Convert to lowercase
            .trim()                      // Remove leading and trailing whitespace
            .replace(/[^\w\s-]/g, '')    // Remove all non-word characters (except spaces and hyphens)
            .replace(/\s+/g, '-')        // Replace spaces with hyphens
            .replace(/-+/g, '-');        // Replace multiple hyphens with a single hyphen
    }
    headers.forEach(function(header, index) {
        // Get the title attribute of the h3 tag, if available
        var title = header.getAttribute('title') || header.textContent;

        // Generate a unique ID for the h3 tag if it doesn't already have one
        if (!header.id) {
            header.id = generateIdFromTitle(title)
        }

        // Create a new list item for the h3 tag
        var listItem = document.createElement('li');

        // Create a new anchor element for the h3 tag
        var anchor = document.createElement('a');
        anchor.href = '#' + header.id;
        anchor.textContent = title;

        // Append the anchor to the list item
        listItem.appendChild(anchor);

        // // Create a sublist for h4 tags
        // var sublist = document.createElement('ul');
        //
        // // Find h4 tags that are siblings of the current h3 tag
        // var nextElement = header.nextElementSibling;
        // while (nextElement && (nextElement.tagName === 'H4')) {
        //     if (nextElement.tagName === 'H4') {
        //         if (!nextElement.id) {
        //             nextElement.id = 'header-' + index + '-' + Array.from(header.parentNode.children).indexOf(nextElement);
        //         }
        //         var sublistItem = document.createElement('li');
        //         var subAnchor = document.createElement('a');
        //         subAnchor.href = '#' + nextElement.id;
        //         subAnchor.textContent = nextElement.textContent;
        //         sublistItem.appendChild(subAnchor);
        //         sublist.appendChild(sublistItem);
        //     }
        //     nextElement = nextElement.nextElementSibling;
        // }
        //
        // // Append the sublist to the h3 list item
        // if (sublist.hasChildNodes()) {
        //     listItem.appendChild(sublist);
        // }

        // Append the list item to the main list
        list.appendChild(listItem);
    });

    // Insert the list at the top of the wrapper
    wrapper.insertBefore(list, wrapper.firstChild);
});
