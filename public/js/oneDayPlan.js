$(function () {

    // DRAG & DROP SORT 
    $("#sortable").sortable({
        axis: "y",
        handle: ".plan-left",
        update: function () {
            updateOrderNumbers();
            saveOrderToServer();
        }
    });

    // UPDATE ORDER NUMBERS  
    function updateOrderNumbers() {
        $("#sortable .plan-row").each(function (i) {
            $(this).find(".order-num").text(i + 1);
        });
    }

    // SAVE NEW ORDER TO DB  
    function saveOrderToServer() {
        let items = [];

        $("#sortable .plan-row").each(function (i) {
            items.push({
                id: $(this).data("id"),
                visit_order: i + 1
            });
        });

        $.ajax({
            url: "/plan/update-order",
            method: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
                items: items
            },
            success: function (res) {
                console.log("Order saved to DB:", res);
            },
            error: function (err) {
                console.error("Failed to save order:", err);
            }
        });
    }

    // SAVE ROUTE SESSION & REDIRECT 
    $("#saveRouteBtn").on("click", function () {
 
        let items = [];

        $("#sortable .plan-row").each(function (i) {
            items.push({
                id:            $(this).data("id"),           
                attraction_id: $(this).data("attraction-id")   
            });
        });

        console.log("Saving route session with:", items);

        $.ajax({
            url: "/plan/save-route-session",
            method: "POST",
            contentType: "application/json",
            data: JSON.stringify({
                _token: $('meta[name="csrf-token"]').attr("content"),
                items: items
            }),
            success: function (res) {
                console.log("Session saved:", res); 
                window.location.href = "/plan/route";
            },
            error: function (err) {
                console.error("Failed to save route session:", err);
                alert("Something went wrong saving your route. Please try again.");
            }
        });
    });

});
