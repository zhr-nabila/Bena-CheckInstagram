const form = document.getElementById('checkForm');
const loading = document.getElementById('loading');
const darkToggle = document.querySelector('.dark-mode-toggle');

form.addEventListener('submit', function(){
    loading.style.display = 'block';
});

// Dark Mode Toggle
darkToggle.addEventListener('click', () => {
    document.body.classList.toggle('dark');
});

// Smooth scroll for anchor
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e){
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({ behavior:'smooth' });
    });
});
