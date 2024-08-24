// Function to load external head content
function loadHeadContent() {
   fetch('header_article.html')
       .then(response => response.text())
       .then(data => {
           document.head.innerHTML += data;
       })
       .catch(error => console.error('Error loading head content:', error));
}

// Load the head content when the document is ready
document.addEventListener('DOMContentLoaded', loadHeadContent);
