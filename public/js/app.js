$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function updateTask(id) {
    $('#modal').modal('toggle');
    $('#mtitle').text('Update Task');
    $.get("/updatetask?id=" + id, function (data) {
        $("#tasktitle").val(data[0]['task_title']);
        $("#description").val(data[0]['task_description']);
        $("#targetdate").val(data[0]['target_date']);
        $("#hid").val(data[0]['id']);
        $('#save').hide();
        $('#update').show();
    });

}

function deleteTask(id) {
    bootbox.confirm({
        message: "Delete this Task?",
        size: 'small',
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn-success'
            },
            cancel: {
                label: 'No',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
            if (result) {
                $.ajax({
                    type: "POST",
                    url: "delete",
                    dataType: 'JSON',
                    data: {
                        id: id
                    },
                    cache: false,
                    success: function (data) {
                        if (data == 1) {
                            $("#tr_" + id).css({
                                "display": "none"
                            });
                            alert("Task Successfuly Deleted");
                        }

                    }
                });
            } else {
                console.log("no");
            }
        }
    });

}


function doneTask(id) {

    bootbox.confirm({
        message: "Done with this Task?",
        size: 'small',
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn-success'
            },
            cancel: {
                label: 'No',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
            if (result) {
                $.ajax({
                    type: "POST",
                    url: "donetask",
                    dataType: 'JSON',
                    data: {
                        id: id
                    },
                    cache: false,
                    success: function (data) {
                        if (data == 1) {
                            $("#tl_" + id).css({
                                "text-decoration": "line-through"
                            });
                            $("#td_" + id).css({
                                "text-decoration": "line-through"
                            });
                            $("#tt_" + id).css({
                                "text-decoration": "line-through"
                            });
                            $("#ck_" + id).prop('disabled', true);
                            $("#up_" + id).prop('disabled', true);
                        }

                    }
                });
            } else {
                $("#ck_" + id).prop('checked', false);
            }
        }
    });

}

function addmodal() {
    $('#modal').modal('toggle');
    $('#mtitle').text('Add New Task');
    $("#tasktitle").val("");
    $("#description").val("");
    $("#targetdate").val("");
    $('#save').show();
    $('#update').hide();
}

function upTask() {
    var id = $("#hid").val();
    var title = $("#tasktitle").val();
    var description = $("#description").val();
    var targetdate = $("#targetdate").val();

    $.ajax({
        type: "POST",
        url: "uptask",
        dataType: 'JSON',
        data: {
            id: id,
            title: title,
            description: description,
            targetdate: targetdate
        },
        cache: false,
        success: function (data) {
            if (data == 1) {
                location.reload();

            }

        }
    });

}
