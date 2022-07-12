$('#inputFile').bind('change', function(e) {
    let data = e.originalEvent.target.files[0];
    const maxFileSize = 2 * 1024 * 1024;

    if(data.size === 0) {
        $("#myModal1").modal("show");
        $("#inputFile").val("");
    }

    if(data.size > maxFileSize) {
        $("#myModal2").modal("show");
        $("#inputFile").val("");
    }
});

