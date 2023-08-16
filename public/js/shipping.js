let table;
$(function() {
    $("#brandForm").validate({
        rules: {
            type: "required",
        },
    });
    console.log("naganda");
    table = $("#shippingTable").DataTable({
        ajax: {
            url: "/api/shipping",
            dataSrc: "",
            contentType: "application/json",
        },
        responsive: true,
        autoWidth: false,
        // dom: "Bfrtip",
        columns: [{
                data: null,
                render: function(data) {
                    return `<img src="${data.media[0]?.original_url}" style="width: 50px; height:50px;"/>`
                }
            },
            {
                data: "id",
            },
            {
                data: "type",
            },

            {
                data: null,
                render: function(data) {
                    return `<div class="action-buttons"><button type="button" data-toggle="modal" data-target="#modal" data-id="${data.id}" class="btn btn-primary edit">
                        Edit
                    </button>
                    <button type="button" data-id="${data.id}" class="btn btn-danger btn-delete delete">
                        Delete
                    </button>
                </div>`;
                },
            },
        ],
    });

    $(
        `<button class="btn btn-primary" role="button" aria-disabled="true" id="create" data-toggle="modal" data-target="#modal">Add Shipping Methods</button>`
    ).insertAfter("#shippingTable_wrapper");
});

$(document).on("click", "#create", function(e) {
    $("#shippingForm").trigger("reset");
    $("#update").hide();
    $("#save").show();
});

$("#save").on("click", function(e) {
    if ($("#shippingForm").valid()) {
        let formData = new FormData($("#shippingForm")[0]);
        for (var pair of formData.entries()) {
            console.log(pair[0] + ", " + pair[1]);
        }
        $.ajax({
            url: "/api/shipping/add",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            dataType: "json",
            success: function(data) {
                $("#close").trigger("click");
                table.ajax.reload();
                alert("Shipping Method Added")
            },
            error: function(error) {},
        });
    }
});

$(document).on("click", ".edit", function(e) {
    let id = $(this).attr("data-id");
    $("#shippingForm").trigger("reset");
    $("#update").show();
    $("#update").attr({
        "data-id": id
    });
    $("#save").hide();

    $.ajax({
        url: `/api/shipping/${id}/edit`,
        type: "get",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function(data) {
            $("#type").val(data.type);

            console.log(data.gender);
        },
        error: function(error) {
            alert(error);
        },
    });
});

$("#update").on('click', function() {
    let id = $(this).attr("data-id");
    let formData = new FormData($('#shippingForm')[0]);
    for (var pair of formData.entries()) {
        console.log(pair[0] + ', ' + pair[1]);
    }
    formData.append('_method', 'PUT');
    $.ajax({
        url: `/api/shipping/${id}`,
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "json",
        success: function(data) {
            table.ajax.reload();
            $("#close").trigger("click")
        },
        error: function(error) {
            alert("Teka may error sir!");
        },
    })
});

$(document).on("click", ".delete", function(e) {
    let id = $(this).attr("data-id");
    alert("Are you sure you want to delete this?")
    $.ajax({
        url: `/api/shipping/delete/${id}`,
        type: "delete",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function(data) {
            table.ajax.reload();
        },
        error: function(error) {
            alert("Teka may error sir!");
        },

    });
});