$('#inputFile').bind('change', function(e) {
    let data = e.originalEvent.target.files[0];

    if(data.size === 0) {
        $("#myModal1").modal("show");
        $("#inputFile").val("");
    }

    if(data.size > 2097152) {
        $("#myModal2").modal("show");
        $("#inputFile").val("");
    }
});

