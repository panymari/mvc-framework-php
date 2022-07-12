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

//confirmation check

const confirmPassword = document.getElementById("confirmPassword");
const password = document.getElementById("password");

confirmPassword.onkeyup = () => {
    if(password.value !== confirmPassword.value) {
        confirmPassword.classList.add("is-invalid");
    } else {
        confirmPassword.classList.remove("is-invalid");
        confirmPassword.classList.add("is-valid");
    }
}
