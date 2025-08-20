// Simple Image Input Component
(function() {
    'use strict';

    // Simple utility functions
    function findElement(element, selector) {
        if (typeof element === 'string') {
            element = document.querySelector(element);
        }
        return element ? element.querySelector(selector) : null;
    }

    function setStyle(element, property, value) {
        if (element) {
            element.style[property] = value;
        }
    }

    function addEvent(element, event, handler) {
        if (element) {
            element.addEventListener(event, handler);
        }
    }

    // Main Image Input Class
    function ImageInput(element) {
        if (!element) return;

        // Get elements
        var input = findElement(element, 'input[type="file"]');
        var wrapper = findElement(element, '.image-input-wrapper');
        var cancelBtn = findElement(element, '[data-kt-image-input-action="cancel"]');
        var removeBtn = findElement(element, '[data-kt-image-input-action="remove"]');
        var hiddenInput = findElement(element, 'input[type="hidden"]');

        // Store original background
        var originalBg = wrapper ? getComputedStyle(wrapper).backgroundImage : 'none';

        // Handle file change
        function handleChange(e) {
            var file = e.target.files[0];
            if (!file || !wrapper) return;

            var reader = new FileReader();
            reader.onload = function(e) {
                setStyle(wrapper, 'background-image', 'url(' + e.target.result + ')');
                element.classList.add('image-input-changed');
                element.classList.remove('image-input-empty');
            };
            reader.readAsDataURL(file);
        }

        // Handle cancel
        function handleCancel(e) {
            e.preventDefault();
            element.classList.remove('image-input-changed');
            element.classList.remove('image-input-empty');
            
            if (originalBg === 'none') {
                setStyle(wrapper, 'background-image', '');
                element.classList.add('image-input-empty');
            } else {
                setStyle(wrapper, 'background-image', originalBg);
            }
            
            if (input) input.value = '';
            if (hiddenInput) hiddenInput.value = '0';
        }

        // Handle remove
        function handleRemove(e) {
            e.preventDefault();
            element.classList.remove('image-input-changed');
            element.classList.add('image-input-empty');
            
            setStyle(wrapper, 'background-image', 'none');
            if (input) input.value = '';
            if (hiddenInput) hiddenInput.value = '1';
        }

        // Add event listeners
        if (input) addEvent(input, 'change', handleChange);
        if (cancelBtn) addEvent(cancelBtn, 'click', handleCancel);
        if (removeBtn) addEvent(removeBtn, 'click', handleRemove);

        // Mark as initialized
        element.setAttribute('data-kt-image-input-initialized', 'true');
    }

    // Initialize all image inputs
    function initImageInputs() {
        var imageInputs = document.querySelectorAll('[data-kt-image-input="true"]');
        imageInputs.forEach(function(element) {
            if (!element.hasAttribute('data-kt-image-input-initialized')) {
                ImageInput(element);
            }
        });
    }

    // Auto initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initImageInputs);
    } else {
        initImageInputs();
    }

    // Also initialize when window loads
    window.addEventListener('load', initImageInputs);

    // Make available globally
    window.ImageInput = ImageInput;
    window.initImageInputs = initImageInputs;

})();