document.addEventListener('DOMContentLoaded', function () {

    // CATEGORY EDIT 
    document.querySelectorAll('.edit-btn.category').forEach(button => {
        button.addEventListener('click', function () {

            let id = this.dataset.id;
            let name = this.dataset.name;
            let color = this.dataset.color;
            let status = this.dataset.status;

            document.getElementById('editName').value = name;
            document.getElementById('editColor').value = color;
            document.getElementById('editStatus').value = status;

            document.getElementById('editForm').action = "/admin/categories/" + id;
        });
    });


    // ATTRACTION EDIT 
document.querySelectorAll('.edit-btn.attraction').forEach(button => {
    button.addEventListener('click', function () {

        let id = this.dataset.id;

        document.getElementById('editName').value = this.dataset.name;
        document.getElementById('editCategory').value = this.dataset.category;
        document.getElementById('editLocation').value = this.dataset.location;
        document.getElementById('editStatus').value = this.dataset.status;

        document.getElementById('editDescription').value = this.dataset.description;
        document.getElementById('editLat').value = this.dataset.lat;
        document.getElementById('editLng').value = this.dataset.lng;
        document.getElementById('editOpening').value = this.dataset.opening;
        document.getElementById('editClosing').value = this.dataset.closing;
        document.getElementById('editFee').value = this.dataset.fee;
        document.getElementById('editContact').value = this.dataset.contact;

        document.getElementById('editForm').action = "/admin/attractions/" + id;
    });
});


    // TOAST - ADD / EDIT
    let message = document.body.dataset.toast;

    if (!message || message === "null") return;

    let messages = {
        added: 'Added Successfully!',
        updated: 'Updated Successfully!',
        deleted: 'Deleted Successfully!'
    };

    let toast = document.getElementById('successToast');
    let text = document.getElementById('toastMessage');

    text.innerText = messages[message] ?? message;

    // remove old colors
    toast.classList.remove('toast-success', 'toast-update', 'toast-delete');

    // add correct color
    if (message === 'added') {
        toast.classList.add('toast-success');
    }
    else if (message === 'updated') {
        toast.classList.add('toast-update');
    }
    else if (message === 'deleted') {
        toast.classList.add('toast-delete');
    }

    // show
    toast.classList.add('show');

    setTimeout(() => {
        toast.classList.remove('show');
    }, 3000);

});