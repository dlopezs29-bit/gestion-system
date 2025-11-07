(function(){
const passwordError = document.getElementById('passwordError');
const status = document.getElementById('form-status');
const toggle = document.getElementById('togglePassword');
const remember = document.getElementById('remember');


function showError(inputEl, errorEl, msg){
errorEl.textContent = msg;
inputEl.classList.add('input-error');
inputEl.classList.remove('input-success');
}


function clearError(inputEl, errorEl){
errorEl.textContent = '';
inputEl.classList.remove('input-error');
inputEl.classList.add('input-success');
}


function validateUsername(){
const val = username.value.trim();
if(!val){ showError(username, usernameError, 'El usuario es obligatorio'); return false; }
if(val.length < 3){ showError(username, usernameError, 'Debe tener al menos 3 caracteres'); return false; }
clearError(username, usernameError); return true;
}


function validatePassword(){
const val = password.value.trim();
if(!val){ showError(password, passwordError, 'La contraseña es obligatoria'); return false; }
if(val.length < 8){ showError(password, passwordError, 'Debe tener mínimo 8 caracteres'); return false; }
clearError(password, passwordError); return true;
}


toggle.addEventListener('click', ()=>{
const isPwd = password.getAttribute('type') === 'password';
password.setAttribute('type', isPwd ? 'text' : 'password');
toggle.textContent = isPwd ? '🙈' : '👁️';
});


username.addEventListener('input', validateUsername);
password.addEventListener('input', validatePassword);


document.addEventListener('DOMContentLoaded', ()=>{
const remembered = localStorage.getItem('remembered_user');
if(remembered){
username.value = remembered;
remember.checked = true;
}
});


form.addEventListener('submit', e => {
e.preventDefault();


const uok = validateUsername();
const pok = validatePassword();
if(!uok || !pok){
status.hidden = false;
status.textContent = 'Corrige los errores antes de continuar.';
status.className = 'status error';
return;
}


if(remember.checked){
localStorage.setItem('remembered_user', username.value.trim());
} else {
localStorage.removeItem('remembered_user');
}


status.hidden = false;
status.textContent = 'Inicio de sesión exitoso, redirigiendo...';
status.className = 'status success';


setTimeout(()=>{
status.textContent = 'Bienvenido, ' + username.value + '! (Simulación)';
}, 1000);
});
})();