document.addEventListener('DOMContentLoaded', function () {
    const showIcon = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><path d="M1 12C2.73 7.61 7 4.5 12 4.5s9.27 3.11 11 7.5c-1.73 4.39-6 7.5-11 7.5S2.73 16.39 1 12z"/><circle cx="12" cy="12" r="3"/></svg>';
    const hideIcon = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8 1.73-4.39 6-7.5 11-7.5 2.13 0 4.12.64 5.8 1.76"/><path d="M1 1l22 22"/><path d="M9.53 9.53a3.5 3.5 0 0 1 4.95 4.95"/></svg>';

    function setIcon(button, visible) {
        button.innerHTML = visible ? showIcon : hideIcon;
        button.setAttribute('aria-label', visible ? 'Hide password' : 'Show password');
    }

    function toggleVisibility(button, show) {
        button.style.display = show ? 'flex' : 'none';
    }

    document.querySelectorAll('.password-toggle').forEach(function (button) {
        // Initially hide the toggle button
        toggleVisibility(button, false);
        setIcon(button, false);

        // Find the associated input
        var wrapper = button.closest('.password-field');
        if (!wrapper) {
            return;
        }

        var input = wrapper.querySelector('input[type="password"], input[type="text"]');
        if (!input) {
            return;
        }

        // Show/hide toggle based on input content
        input.addEventListener('input', function () {
            toggleVisibility(button, input.value.length > 0);
        });

        // Toggle functionality
        button.addEventListener('click', function () {
            if (input.type === 'password') {
                input.type = 'text';
                setIcon(button, true);
            } else {
                input.type = 'password';
                setIcon(button, false);
            }
        });
    });
});
