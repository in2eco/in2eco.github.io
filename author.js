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
