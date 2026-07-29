let currentPlaceId = null;

document.addEventListener('DOMContentLoaded', function () {

    // SIDEBAR  
    const sidebar = document.getElementById('sidebar');
    const toggle = document.getElementById('sidebarToggle');
    const icon = document.getElementById('toggleIcon');

    if (toggle) {
        toggle.addEventListener('click', function () {
            sidebar.classList.toggle('collapsed');
            icon.textContent = sidebar.classList.contains('collapsed') ? '»' : '«';
        });
    }

    // PLACE CARD CLICK  
    document.addEventListener('click', function (e) {
        const card = e.target.closest('.place-card');
        if (!card) return;

        const place = {
            id: card.dataset.id, 
            name: card.dataset.name,
            image: card.dataset.image,
            category: card.dataset.category,
            description: card.dataset.description,
            opening_hours: card.dataset.opening_hours,
            closing_hours: card.dataset.closing_hours,
            entry_fee: card.dataset.entry_fee,
            contact_info: card.dataset.contact_info,
            location: card.dataset.location
        };

        openModal(place);
    });

    // ADD TO PLAN  
    const addBtn = document.getElementById('addToPlanBtn');

    if (addBtn) {
        addBtn.addEventListener('click', function () {

            if (!currentPlaceId) {
                alert('No place selected');
                return;
            }

            fetch('/user/save-plan', {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json', 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },

                body: JSON.stringify({
                place_id: currentPlaceId
                })
            })

            .then(res => res.json())
            .then(data => {

                if (data.status === 'exists') {
                    showToast('Already Added to Plan!', 'error');
                }   
                else if (data.status === 'success') {
                    showToast('Added to Plan Successfully!', 'success');
                } 
                else {
                    showToast('Something went wrong', 'error');
                }

            })

            .catch(err => {
                console.error(err);
            showToast('Request failed', 'error');
            });
        });
    }

});

    // SUCCESS TOAST MESSAGE
    function showToast(message, type = "success") {

        let toast = document.getElementById("toast");

        toast.innerText = message;

        toast.className = "toast"; // reset

        if (type === "error") {
            toast.classList.add("error");
        }

        toast.classList.add("show");

        setTimeout(() => {
            toast.classList.remove("show");
        }, 2500);
    }

    // OPEN MODAL  
    function openModal(place) {

        currentPlaceId = place.id; 

        document.getElementById('modalTitle').textContent = place.name;
        document.getElementById('modalImage').src = place.image;
        document.getElementById('modalCategory').textContent = 'Category: ' + (place.category ?? 'N/A');
        document.getElementById('modalDesc').textContent = place.description ?? '';
        document.getElementById('modalHours').textContent =
            (place.opening_hours ?? 'N/A') + ' - ' + (place.closing_hours ?? 'N/A');
        document.getElementById('modalFee').textContent =
            place.entry_fee ? 'LKR ' + place.entry_fee : 'Free';
        document.getElementById('modalContact').textContent =
            place.contact_info ?? 'Not available';
        document.getElementById('modalLocation').textContent =
            place.location ?? 'N/A';

    // RESET WHEN EACH TIME MODAL OPEN
    const addBtn = document.getElementById('addToPlanBtn');
    if (addBtn) {
        addBtn.textContent = 'Save Plan';
        addBtn.disabled = false;
    }

    document.getElementById('placeModal').classList.add('show');
    }


    // CLOSE MODAL  
    function closeModal() {
        document.getElementById('placeModal').classList.remove('show');
    } 


    // CATEGORY FILTER  
    function filterCategory(category, event) {
        let cards = document.querySelectorAll('.place-card');

        cards.forEach(card => {
            let cardCategory = card.getAttribute('data-category');
            card.style.display =
                (category === 'all' || cardCategory === category) ? 'block' : 'none';
        });

        document.querySelectorAll('.category-bar button')
            .forEach(btn => btn.classList.remove('active'));

        event.currentTarget.classList.add('active');
    }