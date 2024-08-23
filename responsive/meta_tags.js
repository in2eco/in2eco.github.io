const title = document.title;
const path = window.location.pathname;
// Array of meta tag data
const metaTags = [
    { name: 'description', content: title},
    { name: 'author', content: 'Anurag Gupta' },
    { name: 'viewport', content: 'width=device-width, initial-scale=1.0' },
    { property: 'og:title', content: title},
    { property: 'og:type', content: 'article'},
    { property: 'og:description', content: title},
    { property: 'og:url', content: 'in2eco.com'+path},
    { property: 'og:url', content: 'images/in2eco-logo.png'},
    { property: 'og:site_name', content: '@in2eco'},
    { name: 'twitter:card', content: 'summary_large_image' },
    { name: 'twitter:image"', content: 'images/in2eco-logo.png' },
    { name: 'twitter:title', content: title},
    { name: 'twitter:description', content: title},
    { name: 'twitter:site', content: '@in_2_eco' },
];
// Loop over the array and create each meta tag
metaTags.forEach(tagData => {
    const metaTag = document.createElement('meta');

    // Check if it's a name or property attribute
    if (tagData.name) {
        metaTag.name = tagData.name;
    } else if (tagData.property) {
        metaTag.setAttribute('property', tagData.property);
    }

    // Set the content attribute
    metaTag.content = tagData.content;

    // Append the meta tag to the head
    document.head.appendChild(metaTag);
});
