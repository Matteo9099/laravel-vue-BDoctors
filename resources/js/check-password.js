// Validazione Password (Register)
function checkPass() {
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('password-confirm').value;
    if (password == confirmPassword) {
        document.getElementById('message').style.color = 'green';
        document.getElementById('message').innerHTML = 'Le password corrispondono';
    } else {
        document.getElementById('message').style.color = 'red';
        document.getElementById('message').innerHTML = 'Le password non corrispondono';
    }
}
