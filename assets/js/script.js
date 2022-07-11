(function () {
    const forms = document.querySelectorAll('.needs-validation')

    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
})()

// $("#password").on("focusout", function () {
//     console.log("helo")
//     if ($(this).val() != $("#password2").val()) {
//         $("#password2").removeClass("valid").addClass("invalid");
//     } else {
//         $("#password2").removeClass("invalid").addClass("valid");
//     }
// });
//
// $("#password2").on("keyup", function () {
//     console.log("dgkkjdgn")
//     if ($("#password").val() != $(this).val()) {
//         $(this).classList.toggle('is-invalid');
//     }
// });

const confirmPassword = document.getElementById("password2");
const password = document.getElementById("password");

password.onfocusout

$("#password").on("focusout", function () {
    if ($(this).val() != $("#password2").val()) {
        $("#password2").removeClass("valid").addClass("invalid");
    } else {
        $("#password2").removeClass("invalid").addClass("valid");
    }
});

$("#password2").on("keyup", function () {
    if ($("#password").val() != $(this).val()) {
        $(this).removeClass("valid").addClass("invalid");
    } else {
        $(this).removeClass("invalid").addClass("valid");
    }
});
