// const title = document.title;
// const path = window.location.pathname;
// // Array of meta tag data
// const metaTags = [
//     { name: 'description', content: title},
//     { name: 'author', content: 'Anurag Gupta' },
//     { name: 'viewport', content: 'width=device-width, initial-scale=1.0' },
//     { property: 'og:title', content: title},
//     { property: 'og:type', content: 'article'},
//     { property: 'og:description', content: title},
//     { property: 'og:url', content: 'in2eco.com'+path},
//     { property: 'og:url', content: 'images/in2eco-logo.png'},
//     { property: 'og:site_name', content: '@in2eco'},
//     { name: 'twitter:card', content: 'summary_large_image' },
//     { name: 'twitter:image"', content: 'images/in2eco-logo.png' },
//     { name: 'twitter:title', content: title},
//     { name: 'twitter:description', content: title},
//     { name: 'twitter:site', content: '@in_2_eco' },
// ];
// // Function to check if a meta tag with a specific name or property exists
// function metaTagExists(nameOrProperty, value) {
//     console.log(document.head.querySelector(`meta[${nameOrProperty}="${value}"]`));
//     return document.head.querySelector(`meta[${nameOrProperty}="${value}"]`) !== null;
// }
// // Loop over the array and create each meta tag
// metaTags.forEach(tagData => {
//     const attr = tagData.name ? 'name' : 'property';
//     const value = tagData[attr];
//     if (!metaTagExists(attr, value)) {
//       // Create a new meta tag
//       const meta = document.createElement('meta');
//       meta.setAttribute(attr, value);
//       meta.content = tag.content;
//
//       // Append it to the head
//       document.head.appendChild(meta);
//     }
// });
