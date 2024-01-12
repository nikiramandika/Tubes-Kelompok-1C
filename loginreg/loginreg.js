const container = document.getElementById('container');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');
const regisBtn = document.getElementById('regis');

registerBtn.addEventListener('click', () => {
    container.classList.add("active");
});

loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
});

document.getElementById('register').addEventListener('click', function () {
    document.getElementById('container').classList.add('right-panel-active');
 });

 document.getElementById('login').addEventListener('click', function () {
    document.getElementById('container').classList.remove('right-panel-active');
 });

function logout() {
    window.location.href = 'error.php';

}



 