// Enhanced Premium Animation Manager
class PremiumAnimationManager {
  constructor() {
    this.init();
  }

  init() {
    this.bindScrollEvents();
    this.observeElements();
    this.initParticleEffect();
    this.initLogoAnimation();
  }

  bindScrollEvents() {
    // Enhanced smooth scroll with momentum
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', (e) => {
        e.preventDefault();
        const target = document.querySelector(anchor.getAttribute('href'));
        if (target) {
          const offset = 100;
          const targetPosition = target.offsetTop - offset;
          
          window.scrollTo({
            top: targetPosition,
            behavior: 'smooth'
          });
        }
      });
    });
  }

  observeElements() {
    const observerOptions = {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          
          // Stagger animation for features grid
          if (entry.target.classList.contains('features-grid')) {
            this.animateFeatures(entry.target);
          }
          
          // Animate stats
          if (entry.target.classList.contains('stats-grid')) {
            this.animateStats(entry.target);
          }
        }
      });
    }, observerOptions);

    // Observe all animatable elements
    document.querySelectorAll('.upload-card, .results-card, .features-grid, .stats-grid, .premium-features').forEach(el => {
      observer.observe(el);
    });
  }

  animateFeatures(featuresGrid) {
    const featureCards = featuresGrid.querySelectorAll('.feature-card');
    featureCards.forEach((card, index) => {
      card.style.animationDelay = `${index * 0.15}s`;
      card.classList.add('animate-in');
    });
  }

  animateStats(statsGrid) {
    const statCards = statsGrid.querySelectorAll('.stat-card');
    statCards.forEach((card, index) => {
      card.style.animationDelay = `${index * 0.1}s`;
      card.classList.add('animate-in');
    });
  }

  initParticleEffect() {
    const hero = document.querySelector('.hero');
    if (!hero) return;

    // Create more sophisticated particles
    this.createParticles(hero, 25);
  }

  createParticles(container, count) {
    for (let i = 0; i < count; i++) {
      setTimeout(() => {
        this.createParticle(container);
      }, i * 200);
    }
  }

  createParticle(container) {
    const particle = document.createElement('div');
    const size = 2 + Math.random() * 4;
    const colors = [
      'rgba(106, 17, 203, 0.6)',
      'rgba(37, 117, 252, 0.6)', 
      'rgba(255, 107, 107, 0.6)',
      'rgba(246, 211, 101, 0.6)'
    ];
    
    particle.style.cssText = `
      position: absolute;
      width: ${size}px;
      height: ${size}px;
      background: ${colors[Math.floor(Math.random() * colors.length)]};
      border-radius: 50%;
      pointer-events: none;
      z-index: 2;
    `;
    
    // Random position
    particle.style.left = `${Math.random() * 100}%`;
    particle.style.top = `${Math.random() * 100}%`;
    
    container.appendChild(particle);
    this.animateParticle(particle);
  }

  animateParticle(particle) {
    const duration = 4 + Math.random() * 3;
    const delay = Math.random() * 2;
    
    const animation = particle.animate([
      { 
        transform: 'translateY(0px) scale(1)',
        opacity: 0 
      },
      { 
        transform: `translateY(${-100 - Math.random() * 200}px) translateX(${Math.random() * 100 - 50}px) scale(0)`,
        opacity: 0.8 
      }
    ], {
      duration: duration * 1000,
      delay: delay * 1000,
      easing: 'cubic-bezier(0.4, 0, 0.2, 1)',
      fill: 'both'
    });

    animation.onfinish = () => {
      particle.remove();
      this.createParticle(particle.parentElement);
    };
  }

  initLogoAnimation() {
    const logo = document.querySelector('.logo');
    if (logo) {
      // Add floating animation
      logo.style.animation = 'float 6s ease-in-out infinite';
      
      // Add periodic glow effect
      setInterval(() => {
        logo.style.animation = 'none';
        setTimeout(() => {
          logo.style.animation = 'float 6s ease-in-out infinite, glow 3s ease-in-out';
        }, 10);
      }, 8000);
    }
  }
}

// Enhanced File Upload Manager dengan PDF Download Fix
class PremiumFileUploadManager {
  constructor() {
    this.files = {
      followers: null,
      following: null
    };
    this.init();
  }

  init() {
    this.bindEvents();
    this.setupDragAndDrop();
  }

  // ... (methods lainnya tetap sama)

  handleFormSubmit(e) {
    if (!this.files.followers || !this.files.following) {
      e.preventDefault();
      this.showError('Please upload both followers and following files');
      return;
    }

    const loading = document.getElementById('loading');
    if (loading) {
      loading.style.display = 'block';
    }
  }

  // Fix PDF Download tanpa IDM
  setupPDFDownload() {
    const pdfForms = document.querySelectorAll('form[action*="download-pdf"]');
    pdfForms.forEach(form => {
      form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const button = form.querySelector('button');
        const originalContent = button.innerHTML;
        
        // Show loading state
        button.innerHTML = `
          <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="loading-icon">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z" opacity=".3"/>
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"/>
          </svg>
          <span>Generating Report...</span>
        `;
        button.disabled = true;

        try {
          // Submit form secara normal untuk trigger download
          const formData = new FormData(form);
          const response = await fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
              'X-Requested-With': 'XMLHttpRequest'
            }
          });

          if (response.ok) {
            const blob = await response.blob();
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.style.display = 'none';
            a.href = url;
            a.download = 'instagram_unfollowers_report.pdf';
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);
            
            this.showSuccess('PDF downloaded successfully!');
          } else {
            throw new Error('Download failed');
          }
        } catch (error) {
          console.error('Download error:', error);
          this.showError('Failed to download PDF. Please try again.');
        } finally {
          // Reset button state
          button.innerHTML = originalContent;
          button.disabled = false;
        }
      });
    });
  }

  showSuccess(message) {
    this.showNotification(message, 'success');
  }

  showError(message) {
    this.showNotification(message, 'error');
  }

  showNotification(message, type) {
    const notification = document.createElement('div');
    const bgColor = type === 'success' ? 
      'linear-gradient(135deg, #48bb78, #38a169)' : 
      'linear-gradient(135deg, #f56565, #e53e3e)';
    
    notification.style.cssText = `
      position: fixed;
      top: 30px;
      right: 30px;
      background: ${bgColor};
      color: white;
      padding: 1.2rem 1.8rem;
      border-radius: 16px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
      z-index: 10000;
      transform: translateX(400px);
      transition: transform 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
      font-weight: 600;
      max-width: 300px;
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.2);
    `;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
      notification.style.transform = 'translateX(0)';
    }, 100);
    
    setTimeout(() => {
      notification.style.transform = 'translateX(400px)';
      setTimeout(() => notification.remove(), 400);
    }, 4000);
  }
}

// Initialize everything when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
  new PremiumThemeManager();
  new PremiumFileUploadManager();
  new PremiumAnimationManager();
  new PremiumResultsManager();

  // Enhanced logo animation
  const logo = document.querySelector('.logo');
  if (logo) {
    // Add interactive effects
    logo.addEventListener('mouseenter', () => {
      logo.style.transform = 'scale(1.05)';
    });
    
    logo.addEventListener('mouseleave', () => {
      logo.style.transform = 'scale(1)';
    });
  }

  // Add scroll progress indicator
  window.addEventListener('scroll', () => {
    const scrolled = (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100;
    document.documentElement.style.setProperty('--scroll-progress', `${scrolled}%`);
  });
});