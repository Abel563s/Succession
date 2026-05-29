import './bootstrap';

if (typeof document !== 'undefined') {
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('form').forEach((form) => {
            form.setAttribute('autocomplete', 'off');
            form.setAttribute('data-form-type', 'other');
        });

        document.querySelectorAll('form input, form select, form textarea').forEach((field) => {
            if (!field.hasAttribute('autocomplete')) {
                field.setAttribute('autocomplete', 'off');
            }
            if (!field.hasAttribute('autocapitalize')) {
                field.setAttribute('autocapitalize', 'off');
            }
            if (!field.hasAttribute('spellcheck')) {
                field.setAttribute('spellcheck', 'false');
            }
        });
    });
}
