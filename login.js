document.addEventListener('DOMContentLoaded', function () {
    const userForm = document.getElementById('userForm');
    const adminForm = document.getElementById('adminForm');
    const userTab = document.getElementById('userTab');
    const adminTab = document.getElementById('adminTab');

    // Show user tab on click
    userTab.addEventListener('click', function () {
        userForm.style.display = 'block';
        adminForm.style.display = 'none';
        userTab.classList.add('active');
        adminTab.classList.remove('active');
    });

    // Show admin tab on click
    adminTab.addEventListener('click', function () {
        userForm.style.display = 'none';
        adminForm.style.display = 'block';
        userTab.classList.remove('active');
        adminTab.classList.add('active');
    });
});