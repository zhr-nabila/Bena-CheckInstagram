const form = document.getElementById('checkForm');
const loading = document.getElementById('loading');
const resultCard = document.querySelector('.result');

if(form){
    form.addEventListener('submit', function(){
        loading.style.display = 'block';
        // scroll ke form saat klik submit
        form.scrollIntoView({ behavior: 'smooth' });
    });
}

// Tambah animasi fade-in untuk hasil
if(resultCard){
    window.addEventListener('load', () => {
        resultCard.classList.add('fade-in', 'show');
    });
}

function toggleDarkMode() {
    document.body.classList.toggle('dark');
}
