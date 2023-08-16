let table;
$(function() {
    $("#brandForm").validate({
        rules: {
            name: "required",
            slug: "required",
            description: "required",
        },
    });
    console.log("naganda");
    table = $("#brandTable").DataTable({
        ajax: {
            url: "/api/brand",
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
                data: "name",
            },
            {
                data: "slug",
            },
            {
                data: "description",
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
        `<button class="btn btn-primary" role="button" aria-disabled="true" id="create" data-toggle="modal" data-target="#modal">Add Brand</button>`
    ).insertAfter("#brandTable_wrapper");
});

$(document).on("click", "#create", function(e) {
    $("#brandForm").trigger("reset");
    $("#update").hide();
    $("#save").show();
});

$("#save").on("click", function(e) {
    if ($("#brandForm").valid()) {
        let formData = new FormData($("#brandForm")[0]);
        for (var pair of formData.entries()) {
            console.log(pair[0] + ", " + pair[1]);
        }
        $.ajax({
            url: "/api/brand/add",
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
                alert("Brand Added")
            },
            error: function(error) {},
        });
    }
});

$(document).on("click", ".edit", function(e) {
    let id = $(this).attr("data-id");
    $("#brandForm").trigger("reset");
    $("#update").show();
    $("#update").attr({
        "data-id": id
    });
    $("#save").hide();

    $.ajax({
        url: `/api/brand/${id}/edit`,
        type: "get",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function(data) {
            $("#name").val(data.name);
            $("#slug").val(data.slug);
            $("#description").val(data.description);
            console.log(data.gender);
        },
        error: function(error) {
            alert(error);
        },
    });
});

$("#update").on('click', function() {
    let id = $(this).attr("data-id");
    let formData = new FormData($('#brandForm')[0]);
    for (var pair of formData.entries()) {
        console.log(pair[0] + ', ' + pair[1]);
    }
    formData.append('_method', 'PUT');
    $.ajax({
        url: `/api/brand/${id}`,
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
            alert("Antok na Developer");
        },
    })
});

$(document).on("click", ".delete", function(e) {
    let id = $(this).attr("data-id");
    alert("Are you sure you want to delete this?")
    $.ajax({
        url: `/api/brand/delete/${id}`,
        type: "delete",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function(data) {
            table.ajax.reload();
        },
        error: function(error) {
            alert("Antok na Developer");
        },

    });
});