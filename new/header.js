// Load the template from the external HTML file
fetch('header.html')
    .then(response => response.text())
    .then(templateContent => {
        const template = document.createElement('template');
        template.innerHTML = templateContent;

        class HeaderComponent extends HTMLElement {
            constructor() {
                super();
                const shadowRoot = this.attachShadow({ mode: 'open' });
                shadowRoot.appendChild(template.content.cloneNode(true));
            }
        }

        // Define the custom element
        customElements.define('header-component', HeaderComponent);
    });
