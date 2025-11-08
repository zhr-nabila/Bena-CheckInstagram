// Premium Animation Manager
class PremiumAnimationManager {
  constructor() {
    this.init();
  }

  init() {
    this.bindScrollEvents();
    this.observeElements();
    this.initParticleEffect();
  }

  bindScrollEvents() {
    // Smooth scroll with offset
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', (e) => {
        e.preventDefault();
        const target = document.querySelector(anchor.getAttribute('href'));
        if (target) {
          const offset = 80;
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
          
          // Stagger animation for child elements
          if (entry.target.classList.contains('stats-grid')) {
            this.animateStats(entry.target);
          }
        }
      });
    }, observerOptions);

    // Observe elements for animation
    document.querySelectorAll('.upload-card, .results-card, .stats-grid').forEach(el => {
      observer.observe(el);
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
    // Simple particle effect for hero section
    const hero = document.querySelector('.hero');
    if (!hero) return;

    const particleCount = 15;
    for (let i = 0; i < particleCount; i++) {
      this.createParticle(hero);
    }
  }

  createParticle(container) {
    const particle = document.createElement('div');
    particle.style.cssText = `
      position: absolute;
      width: 4px;
      height: 4px;
      background: rgba(255, 255, 255, 0.5);
      border-radius: 50%;
      pointer-events: none;
    `;
    
    // Random position
    particle.style.left = `${Math.random() * 100}%`;
    particle.style.top = `${Math.random() * 100}%`;
    
    container.appendChild(particle);
    
    // Animate particle
    this.animateParticle(particle);
  }

  animateParticle(particle) {
    const duration = 3 + Math.random() * 2;
    const delay = Math.random() * 2;
    
    particle.animate([
      { 
        transform: 'translateY(0px) scale(1)',
        opacity: 0 
      },
      { 
        transform: `translateY(${-20 - Math.random() * 30}px) scale(0)`,
        opacity: 0.8 
      }
    ], {
      duration: duration * 1000,
      delay: delay * 1000,
      easing: 'cubic-bezier(0.4, 0, 0.2, 1)',
      fill: 'both'
    }).onfinish = () => {
      particle.remove();
      this.createParticle(particle.parentElement);
    };
  }
}

// Enhanced Theme Manager
class PremiumThemeManager {
  constructor() {
    this.theme = localStorage.getItem('bena-theme') || 'light';
    this.init();
  }

  init() {
    this.applyTheme(this.theme);
    this.bindEvents();
  }

  applyTheme(theme) {
    document.body.classList.toggle('dark', theme === 'dark');
    this.updateThemeIcon(theme);
    localStorage.setItem('bena-theme', theme);
    
    // Update meta theme color
    this.updateMetaThemeColor(theme);
  }

  updateThemeIcon(theme) {
    const themeIcon = document.querySelector('.theme-icon');
    if (themeIcon) {
      // Using SVG icons instead of emoji
      themeIcon.innerHTML = theme === 'dark' ? 
        '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12,7c-2.76,0-5,2.24-5,5s2.24,5,5,5s5-2.24,5-5S14.76,7,12,7L12,7z M2,13l2,0c0.55,0,1-0.45,1-1s-0.45-1-1-1l-2,0 c-0.55,0-1,0.45-1,1S1.45,13,2,13z M20,13l2,0c0.55,0,1-0.45,1-1s-0.45-1-1-1l-2,0c-0.55,0-1,0.45-1,1S19.45,13,20,13z M11,2v2 c0,0.55,0.45,1,1,1s1-0.45,1-1V2c0-0.55-0.45-1-1-1S11,1.45,11,2z M11,20v2c0,0.55,0.45,1,1,1s1-0.45,1-1v-2c0-0.55-0.45-1-1-1 S11,19.45,11,20z M6.34,7.34l-1.41,1.41c-0.39,0.39-0.39,1.02,0,1.41c0.39,0.39,1.02,0.39,1.41,0l1.41-1.41 c0.39-0.39,0.39-1.02,0-1.41C7.36,6.95,6.73,6.95,6.34,7.34z M17.66,17.66l-1.41,1.41c-0.39,0.39-0.39,1.02,0,1.41 c0.39,0.39,1.02,0.39,1.41,0l1.41-1.41c0.39-0.39,0.39-1.02,0-1.41C18.68,17.27,18.05,17.27,17.66,17.66z"/></svg>' :
        '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M9.37,5.51C9.19,6.15,9.1,6.82,9.1,7.5c0,4.08,3.32,7.4,7.4,7.4c0.68,0,1.35-0.09,1.99-0.27C17.45,17.19,14.93,19,12,19 c-3.86,0-7-3.14-7-7C5,9.07,6.81,6.55,9.37,5.51z M12,3c-4.97,0-9,4.03-9,9s4.03,9,9,9s9-4.03,9-9c0-0.46-0.04-0.92-0.1-1.36 c-0.98,1.37-2.58,2.26-4.4,2.26c-2.98,0-5.4-2.42-5.4-5.4c0-1.81,0.89-3.42,2.26-4.4C12.92,3.04,12.46,3,12,3L12,3z"/></svg>';
    }
  }

  updateMetaThemeColor(theme) {
    let metaThemeColor = document.querySelector('meta[name="theme-color"]');
    if (!metaThemeColor) {
      metaThemeColor = document.createElement('meta');
      metaThemeColor.name = 'theme-color';
      document.head.appendChild(metaThemeColor);
    }
    metaThemeColor.content = theme === 'dark' ? '#0f1419' : '#f8fafc';
  }

  toggleTheme() {
    this.theme = this.theme === 'light' ? 'dark' : 'light';
    this.applyTheme(this.theme);
  }

  bindEvents() {
    const themeToggle = document.querySelector('.theme-toggle');
    if (themeToggle) {
      themeToggle.addEventListener('click', () => this.toggleTheme());
    }
  }
}

// Enhanced File Upload Manager
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

  bindEvents() {
    const fileInputs = document.querySelectorAll('.file-input');
    const uploadArea = document.querySelector('.upload-area');
    const uploadBtn = document.querySelector('.upload-btn');

    fileInputs.forEach(input => {
      input.addEventListener('change', (e) => this.handleFileSelect(e));
    });

    if (uploadBtn) {
      uploadBtn.addEventListener('click', () => this.triggerFileInput());
    }

    // Form submission
    const form = document.getElementById('checkForm');
    if (form) {
      form.addEventListener('submit', (e) => this.handleFormSubmit(e));
    }
  }

  setupDragAndDrop() {
    const uploadArea = document.querySelector('.upload-area');
    
    if (!uploadArea) return;

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
      uploadArea.addEventListener(eventName, this.preventDefaults, false);
    });

    ['dragenter', 'dragover'].forEach(eventName => {
      uploadArea.addEventListener(eventName, () => this.highlight(), false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
      uploadArea.addEventListener(eventName, () => this.unhighlight(), false);
    });

    uploadArea.addEventListener('drop', (e) => this.handleDrop(e), false);
  }

  preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
  }

  highlight() {
    const uploadArea = document.querySelector('.upload-area');
    uploadArea.classList.add('drag-over');
  }

  unhighlight() {
    const uploadArea = document.querySelector('.upload-area');
    uploadArea.classList.remove('drag-over');
  }

  handleDrop(e) {
    const dt = e.dataTransfer;
    const files = dt.files;
    this.processFiles(files);
  }

  triggerFileInput() {
    const fileInput = document.querySelector('.file-input');
    fileInput?.click();
  }

  handleFileSelect(e) {
    const files = e.target.files;
    this.processFiles(files);
  }

  processFiles(files) {
    if (!files.length) return;

    Array.from(files).forEach(file => {
      if (file.type === 'application/json' || file.name.endsWith('.json')) {
        this.addFile(file);
      } else {
        this.showError('Please upload only JSON files');
      }
    });
  }

  addFile(file) {
    const fileType = file.name.toLowerCase().includes('followers') ? 'followers' : 'following';
    this.files[fileType] = file;
    this.updateFileList(fileType, file);
    this.checkFilesReady();
  }

  updateFileList(fileType, file) {
    const fileList = document.querySelector('.file-list');
    if (!fileList) return;

    const existingItem = document.querySelector(`[data-file-type="${fileType}"]`);
    if (existingItem) {
      existingItem.remove();
    }

    const fileItem = this.createFileItem(fileType, file);
    fileList.appendChild(fileItem);
    
    // Animate file item
    setTimeout(() => {
      fileItem.classList.add('uploaded');
    }, 100);
  }

  createFileItem(fileType, file) {
    const div = document.createElement('div');
    div.className = 'file-item';
    div.setAttribute('data-file-type', fileType);
    
    const fileSize = this.formatFileSize(file.size);
    const iconSvg = fileType === 'followers' ? 
      '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M16 4c0-1.11.89-2 2-2s2 .89 2 2-.89 2-2 2-2-.89-2-2zm4 18v-6h2.5l-2.54-7.63A2.01 2.01 0 0 0 18.06 7h-.12a2 2 0 0 0-1.9 1.37l-.86 2.58c1.08.6 1.82 1.73 1.82 3.05v8h3zm-7.5-10.5c.83 0 1.5-.67 1.5-1.5s-.67-1.5-1.5-1.5S11 9.17 11 10s.67 1.5 1.5 1.5zM5.5 6c1.11 0 2-.89 2-2s-.89-2-2-2-2 .89-2 2 .89 2 2 2zm2 16v-7H9V9c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v6h1.5v7h4zm6.5 0v-4h1v-4c0-.82-.68-1.5-1.5-1.5h-2c-.82 0-1.5.68-1.5 1.5v4h1v4h3z"/></svg>' :
      '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12 5.5c-3.79 0-7.17 2.13-8.82 5.5 1.65 3.37 5.02 5.5 8.82 5.5s7.17-2.13 8.82-5.5C19.17 7.63 15.79 5.5 12 5.5m0 10c-2.48 0-4.5-2.02-4.5-4.5S9.52 6.5 12 6.5s4.5 2.02 4.5 4.5-2.02 4.5-4.5 4.5m0-7c-1.38 0-2.5 1.12-2.5 2.5s1.12 2.5 2.5 2.5 2.5-1.12 2.5-2.5-1.12-2.5-2.5-2.5z"/></svg>';
    
    div.innerHTML = `
      <div class="file-icon">${iconSvg}</div>
      <div class="file-info">
        <div class="file-name">${file.name}</div>
        <div class="file-size">${fileSize}</div>
      </div>
    `;
    
    return div;
  }

  formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
  }

  checkFilesReady() {
    const hasFollowers = this.files.followers !== null;
    const hasFollowing = this.files.following !== null;
    
    if (hasFollowers && hasFollowing) {
      this.enableSubmit();
    }
  }

  enableSubmit() {
    const submitBtn = document.querySelector('button[type="submit"]');
    if (submitBtn) {
      submitBtn.disabled = false;
      submitBtn.innerHTML = '<span>Analyze Instagram Data</span>';
      
      // Update form inputs
      this.updateFormInputs();
    }
  }

  updateFormInputs() {
    // Create new FormData and update file inputs
    const followersInput = document.querySelector('input[name="followers"]');
    const followingInput = document.querySelector('input[name="following"]');
    
    // Note: In a real implementation, you would need to handle file upload properly
    // This is a simplified version for the UI
  }

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

  showError(message) {
    // Create elegant error notification
    const notification = document.createElement('div');
    notification.style.cssText = `
      position: fixed;
      top: 20px;
      right: 20px;
      background: #f5576c;
      color: white;
      padding: 1rem 1.5rem;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(245, 87, 108, 0.3);
      z-index: 10000;
      transform: translateX(100%);
      transition: transform 0.3s ease;
    `;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
      notification.style.transform = 'translateX(0)';
    }, 100);
    
    setTimeout(() => {
      notification.style.transform = 'translateX(100%)';
      setTimeout(() => notification.remove(), 300);
    }, 4000);
  }
}

// Enhanced Results Manager
class PremiumResultsManager {
  constructor() {
    this.init();
  }

  init() {
    this.bindDownloadEvents();
  }

  bindDownloadEvents() {
    // PDF download functionality with enhanced UX
    const pdfForms = document.querySelectorAll('form[action*="download-pdf"]');
    pdfForms.forEach(form => {
      form.addEventListener('submit', (e) => {
        const button = form.querySelector('button');
        const originalContent = button.innerHTML;
        
        // Add loading state
        button.innerHTML = `
          <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="loading-icon">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z" opacity=".3"/>
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"/>
          </svg>
          <span>Generating Report...</span>
        `;
        button.disabled = true;

        // Reset after delay (in real app, this would be after actual PDF generation)
        setTimeout(() => {
          button.innerHTML = originalContent;
          button.disabled = false;
        }, 2000);
      });
    });
  }
}

// Initialize everything when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
  new PremiumThemeManager();
  new PremiumFileUploadManager();
  new PremiumAnimationManager();
  new PremiumResultsManager();

  // Add floating animation to logo
  const logo = document.querySelector('.logo');
  if (logo) {
    logo.style.animation = 'float 6s ease-in-out infinite';
  }
});