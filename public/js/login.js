document.addEventListener('DOMContentLoaded', function () {
    const userForm = document.getElementById('userForm');
    const adminForm = document.getElementById('adminForm');
    const userTab = document.getElementById('userTab');
    const adminTab = document.getElementById('adminTab');

    // SHOW USER TAB ON CLICK
    userTab.addEventListener('click', function () {
        userForm.style.display = 'block';
        adminForm.style.display = 'none';
        userTab.classList.add('active');
        adminTab.classList.remove('active');
    });

    // SHOW ADMIN TAB ON CLICK
    adminTab.addEventListener('click', function () {
        userForm.style.display = 'none';
        adminForm.style.display = 'block';
        userTab.classList.remove('active');
        adminTab.classList.add('active');
    });

    // SUCCESS TOAST MESSAGE - USER REGISTER
    var toastEl = document.getElementById('liveToast');
    if (toastEl) {
        var toast = new bootstrap.Toast(toastEl, {
            delay: 3000
        });
        toast.show();
    }
 
});