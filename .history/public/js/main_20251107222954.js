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

// Smooth scroll
document.querySelectorAll('a.scroll-btn').forEach(anchor => {
    anchor.addEventListener('click', function(e){
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({ behavior: 'smooth' });
    });
});
