window.showToast = function (message, type = "success") {
    let toast = document.getElementById("toast");

    if (!toast) {
        toast = document.createElement("div");
        toast.id = "toast";
        toast.className = "toast";
        document.body.appendChild(toast);
    }
 
    toast.classList.remove("success", "error", "done");

    toast.innerText = message;
    toast.classList.add(type);

    setTimeout(() => toast.classList.add("show"), 100);
    setTimeout(() => toast.classList.remove("show"), 3000);
};
 
document.addEventListener("DOMContentLoaded", function () {
    if (window.LaravelToast) {
        showToast(window.LaravelToast.message, window.LaravelToast.type);
    }
});