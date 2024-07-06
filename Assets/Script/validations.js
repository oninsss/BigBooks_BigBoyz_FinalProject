function validateForm() {
    var password = document.forms["studentSignUp"]["password"].value;
    var confirm_pass = document.forms["studentSignUp"]["confirm_pass"].value;

    if (password !== confirm_pass) {
        alert("Passwords do not match.");
        return false;
    }
    return true;
}