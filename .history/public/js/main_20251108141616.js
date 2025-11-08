// Simple Theme Manager
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
    metaThemeColor.content = theme === 'dark' ? '#0a0a0a' : '#f8fafc';
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
    this.setupPDFDownload();
  }

  bindEvents() {
    const fileInputs = document.querySelectorAll('.file-input');
    const uploadArea = document.querySelector('.upload-area');
    const uploadBtn = document.querySelector('.upload-btn');

    // Handle file input changes
    fileInputs.forEach(input => {
      input.addEventListener('change', (e) => this.handleFileSelect(e));
    });

    // Handle upload button click
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
    const fileInput = document.createElement('input');
    fileInput.type = 'file';
    fileInput.accept = '.json';
    fileInput.multiple = true;
    fileInput.style.display = 'none';
    
    fileInput.addEventListener('change', (e) => {
      this.processFiles(e.target.files);
      document.body.removeChild(fileInput);
    });
    
    document.body.appendChild(fileInput);
    fileInput.click();
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
    const fileType = this.determineFileType(file.name);
    this.files[fileType] = file;
    this.updateFileList(fileType, file);
    this.updateFormInputs();
    this.checkFilesReady();
  }

  determineFileType(filename) {
    const lowerName = filename.toLowerCase();
    if (lowerName.includes('followers')) return 'followers';
    if (lowerName.includes('following')) return 'following';
    
    const type = prompt(`Is "${filename}" your followers or following file? Type "followers" or "following":`);
    return type === 'followers' ? 'followers' : 'following';
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
      <button class="file-remove" data-file-type="${fileType}">×</button>
    `;
    
    const removeBtn = div.querySelector('.file-remove');
    removeBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      this.removeFile(fileType);
    });
    
    return div;
  }

  removeFile(fileType) {
    this.files[fileType] = null;
    const fileItem = document.querySelector(`[data-file-type="${fileType}"]`);
    if (fileItem) {
      fileItem.remove();
    }
    this.updateFormInputs();
    this.checkFilesReady();
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
    
    const submitBtn = document.querySelector('button[type="submit"]');
    if (!submitBtn) return;
    
    if (hasFollowers && hasFollowing) {
      submitBtn.disabled = false;
      submitBtn.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M21 11.01L3 11v2h18v-2zM3 16h12v2H3v-2zM21 6H3v2.01L21 8V6z"/></svg><span>Analyze Instagram Data</span>';
    } else {
      submitBtn.disabled = true;
      submitBtn.innerHTML = '<span>Upload Both Files to Continue</span>';
    }
  }

  updateFormInputs() {
    const form = document.getElementById('checkForm');
    if (!form) return;

    const existingFollowersInput = form.querySelector('input[name="followers"]');
    const existingFollowingInput = form.querySelector('input[name="following"]');
    
    if (existingFollowersInput) existingFollowersInput.remove();
    if (existingFollowingInput) existingFollowingInput.remove();

    if (this.files.followers) {
      const followersInput = document.createElement('input');
      followersInput.type = 'file';
      followersInput.name = 'followers';
      followersInput.style.display = 'none';
      
      const dt = new DataTransfer();
      dt.items.add(this.files.followers);
      followersInput.files = dt.files;
      
      form.appendChild(followersInput);
    }

    if (this.files.following) {
      const followingInput = document.createElement('input');
      followingInput.type = 'file';
      followingInput.name = 'following';
      followingInput.style.display = 'none';
      
      const dt = new DataTransfer();
      dt.items.add(this.files.following);
      followingInput.files = dt.files;
      
      form.appendChild(followingInput);
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

  setupPDFDownload() {
    const pdfForms = document.querySelectorAll('form[action*="download-pdf"]');
    pdfForms.forEach(form => {
      form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const button = form.querySelector('button');
        const originalContent = button.innerHTML;
        
        button.innerHTML = `
          <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="loading-icon">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z" opacity=".3"/>
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"/>
          </svg>
          <span>Generating Report...</span>
        `;
        button.disabled = true;

        try {
          const formData = new FormData(form);
          const response = await fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
              'X-Requested-With': 'XMLHttpRequest',
              'Accept': 'application/pdf',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
          });

          if (response.ok) {
            const blob = await response.blob();
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.style.display = 'none';
            a.href = url;
            a.download = 'bena_instagram_report.pdf';
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);
            
            this.showSuccess('Premium PDF report downloaded successfully!');
          } else {
            throw new Error('Download failed');
          }
        } catch (error) {
          console.error('Download error:', error);
          this.showError('Failed to download PDF. Please try again.');
        } finally {
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
    document.querySelectorAll('.upload-notification').forEach(notification => notification.remove());

    const notification = document.createElement('div');
    const bgColor = type === 'success' ? 
      'linear-gradient(135deg, #48bb78, #38a169)' : 
      'linear-gradient(135deg, #f56565, #e53e3e)';
    
    notification.className = 'upload-notification';
    notification.style.cssText = `
      position: fixed;
      top: 100px; /* Adjust for fixed header */
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

// Simple Animation Manager with Scroll Effect
class SimpleAnimationManager {
  constructor() {
    this.init();
  }

  init() {
    this.bindScrollEvents();
    this.observeElements();
    this.fixHeaderPosition();
    this.handleHeaderScroll();
  }

  bindScrollEvents() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', (e) => {
        e.preventDefault();
        const target = document.querySelector(anchor.getAttribute('href'));
        if (target) {
          const offset = 100; // Adjusted offset for slimmer header
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

    document.querySelectorAll('.upload-card, .results-card, .premium-features').forEach(el => {
      observer.observe(el);
    });
  }

  fixHeaderPosition() {
    // Ensure header stays at top
    const header = document.querySelector('.app-header');
    if (header) {
      header.style.position = 'fixed';
      header.style.top = '0';
      header.style.left = '0';
      header.style.right = '0';
      header.style.zIndex = '1000';
    }
  }

  handleHeaderScroll() {
    const header = document.querySelector('.app-header');
    const scrollThreshold = 30; // Reduced threshold for slimmer header

    window.addEventListener('scroll', () => {
      if (window.scrollY > scrollThreshold) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }
    });

    // Initial check
    if (window.scrollY > scrollThreshold) {
      header.classList.add('scrolled');
    }
  }
}

// Initialize everything when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
  new PremiumThemeManager();
  new PremiumFileUploadManager();
  new SimpleAnimationManager();

  // Logo interaction (simple - tanpa animasi mengganggu)
  const logo = document.querySelector('.logo');
  if (logo) {
    logo.addEventListener('mouseenter', () => {
      logo.style.transform = 'scale(1.02)';
    });
    
    logo.addEventListener('mouseleave', () => {
      logo.style.transform = 'scale(1)';
    });
  }
});

// Language switcher functionality
document.querySelectorAll('.lang-btn').forEach(button => {
  button.addEventListener('click', function() {
    const lang = this.getAttribute('data-lang');
    
    document.querySelectorAll('.lang-btn').forEach(btn => {
      btn.classList.remove('active');
    });
    this.classList.add('active');
    
    fetch('/switch-language/' + lang, {
      method: 'GET',
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      }
    })
    .then(response => {
      if (response.ok) {
        window.location.reload();
      }
    })
    .catch(error => {
      console.error('Error:', error);
      window.location.reload();
    });
  });
});