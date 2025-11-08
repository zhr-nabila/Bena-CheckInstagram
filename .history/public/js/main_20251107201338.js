const form = document.getElementById('checkForm');
const loading = document.getElementById('loading');

if(form){
    form.addEventListener('submit', function(){
        loading.style.display = 'block';
    });
}

function toggleDarkMode() {
    document.body.classList.toggle('dark');
}
