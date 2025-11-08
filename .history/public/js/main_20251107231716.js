// Theme Management
class ThemeManager {
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
  }

  updateThemeIcon(theme) {
    const themeIcon = document.querySelector('.theme-icon');
    if (themeIcon) {
      themeIcon.textContent = theme === 'dark' ? '☀️' : '🌙';
    }
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

// File Upload Manager
class FileUploadManager {
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
  }

  createFileItem(fileType, file) {
    const div = document.createElement('div');
    div.className = 'file-item';
    div.setAttribute('data-file-type', fileType);
    
    const fileSize = this.formatFileSize(file.size);
    
    div.innerHTML = `
      <div class="file-icon">${fileType === 'followers' ? '👥' : '📋'}</div>
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
      submitBtn.textContent = 'Analyze Instagram Data';
    }
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
    // Implement error notification
    console.error(message);
  }
}

// Animation Manager
class AnimationManager {
  constructor() {
    this.init();
  }

  init() {
    this.bindScrollEvents();
    this.observeElements();
  }

  bindScrollEvents() {
    // Smooth scroll for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', (e) => {
        e.preventDefault();
        const target = document.querySelector(anchor.getAttribute('href'));
        if (target) {
          target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        }
      });
    });
  }

  observeElements() {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
        }
      });
    }, {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    });

    // Observe elements for animation
    document.querySelectorAll('.upload-card, .results-card').forEach(el => {
      observer.observe(el);
    });
  }
}

// Results Manager
class ResultsManager {
  constructor() {
    this.init();
  }

  init() {
    this.bindDownloadEvents();
  }

  bindDownloadEvents() {
    // PDF download functionality
    const pdfForms = document.querySelectorAll('form[action*="download-pdf"]');
    pdfForms.forEach(form => {
      form.addEventListener('submit', (e) => {
        // Add loading state
        const button = form.querySelector('button');
        const originalText = button.textContent;
        button.textContent = 'Generating PDF...';
        button.disabled = true;

        setTimeout(() => {
          button.textContent = originalText;
          button.disabled = false;
        }, 3000);
      });
    });
  }

  showResults(data) {
    // Animate results card into view
    const resultsCard = document.querySelector('.results-card');
    if (resultsCard) {
      resultsCard.classList.add('visible');
    }
  }
}

// Initialize everything when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
  new ThemeManager();
  new FileUploadManager();
  new AnimationManager();
  new ResultsManager();

  // Add floating animation to hero elements
  const logo = document.querySelector('.logo');
  if (logo) {
    logo.style.animation = 'float 6s ease-in-out infinite';
  }
});

// Utility function for file handling
function readFileAsText(file) {
  return new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.onload = e => resolve(e.target.result);
    reader.onerror = reject;
    reader.readAsText(file);
  });
}