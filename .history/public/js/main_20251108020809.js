// Language Management
class LanguageManager {
    constructor() {
        this.currentLang = localStorage.getItem('preferred-language') || 'en';
        this.init();
    }

    init() {
        this.setupLanguageToggle();
        this.applyLanguage(this.currentLang);
        this.updatePDFLocale();
    }

    setupLanguageToggle() {
        const langButtons = document.querySelectorAll('.lang-btn');
        
        langButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const lang = btn.dataset.lang;
                this.switchLanguage(lang);
            });
        });
    }

    switchLanguage(lang) {
        this.currentLang = lang;
        localStorage.setItem('preferred-language', lang);
        this.applyLanguage(lang);
        this.updateActiveButton(lang);
        this.updatePDFLocale();
    }

    applyLanguage(lang) {
        // Update all elements with data attributes
        document.querySelectorAll('[data-en], [data-id]').forEach(element => {
            const text = element.getAttribute(`data-${lang}`);
            if (text) {
                if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') {
                    element.placeholder = text;
                } else {
                    element.textContent = text;
                }
            }
        });

        // Update HTML lang attribute
        document.documentElement.lang = lang;
    }

    updateActiveButton(lang) {
        document.querySelectorAll('.lang-btn').forEach(btn => {
            btn.classList.toggle('active', btn.dataset.lang === lang);
        });
    }

    updatePDFLocale() {
        const pdfLocaleInput = document.getElementById('pdfLocale');
        if (pdfLocaleInput) {
            pdfLocaleInput.value = this.currentLang;
        }
    }
}

// Theme Management
class ThemeManager {
    constructor() {
        this.currentTheme = localStorage.getItem('theme') || 'light';
        this.init();
    }

    init() {
        this.applyTheme(this.currentTheme);
        this.setupThemeToggle();
    }

    setupThemeToggle() {
        const themeToggle = document.querySelector('.theme-toggle');
        themeToggle?.addEventListener('click', () => {
            this.toggleTheme();
        });
    }

    toggleTheme() {
        this.currentTheme = this.currentTheme === 'light' ? 'dark' : 'light';
        localStorage.setItem('theme', this.currentTheme);
        this.applyTheme(this.currentTheme);
    }

    applyTheme(theme) {
        document.documentElement.setAttribute('data-theme', theme);
    }
}

// File Upload Management
class FileUploadManager {
    constructor() {
        this.uploadedFiles = {
            followers: null,
            following: null
        };
        this.init();
    }

    init() {
        this.setupFileUpload();
        this.setupFormSubmission();
    }

    setupFileUpload() {
        const uploadArea = document.getElementById('uploadArea');
        const fileInputs = document.querySelectorAll('.file-input');
        const uploadBtn = uploadArea?.querySelector('.upload-btn');
        const formSubmitBtn = document.getElementById('submitBtn');

        // Click to upload
        uploadBtn?.addEventListener('click', () => {
            fileInputs.forEach(input => input.click());
        });

        // File input change
        fileInputs.forEach(input => {
            input.addEventListener('change', (e) => {
                this.handleFileSelection(e.target.files);
            });
        });

        // Drag and drop
        uploadArea?.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('drag-over');
        });

        uploadArea?.addEventListener('dragleave', () => {
            uploadArea.classList.remove('drag-over');
        });

        uploadArea?.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('drag-over');
            this.handleFileSelection(e.dataTransfer.files);
        });
    }

    handleFileSelection(files) {
        const fileList = document.getElementById('fileList');
        fileList.innerHTML = '';

        Array.from(files).forEach(file => {
            if (file.name.includes('followers')) {
                this.uploadedFiles.followers = file;
            } else if (file.name.includes('following')) {
                this.uploadedFiles.following = file;
            }

            this.createFileListItem(file);
        });

        this.updateFormState();
    }

    createFileListItem(file) {
        const fileList = document.getElementById('fileList');
        const fileItem = document.createElement('div');
        fileItem.className = 'file-item';
        
        const isValid = this.validateFile(file);
        
        fileItem.innerHTML = `
            <div class="file-info">
                <div class="file-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6z"/>
                    </svg>
                </div>
                <div>
                    <div class="file-name">${file.name}</div>
                    <div class="file-status ${isValid ? 'valid' : 'invalid'}">
                        ${isValid ? '✓ Valid JSON file' : '✗ Invalid file'}
                    </div>
                </div>
            </div>
        `;
        
        fileList.appendChild(fileItem);
    }

    validateFile(file) {
        return file.name.endsWith('.json') && file.type.includes('json');
    }

    updateFormState() {
        const formSubmitBtn = document.getElementById('submitBtn');
        const hasBothFiles = this.uploadedFiles.followers && this.uploadedFiles.following;
        
        formSubmitBtn.disabled = !hasBothFiles;
    }

    setupFormSubmission() {
        const form = document.getElementById('checkForm');
        const loading = document.getElementById('loading');
        const uploadCard = document.querySelector('.upload-card');

        form?.addEventListener('submit', (e) => {
            if (!this.uploadedFiles.followers || !this.uploadedFiles.following) {
                e.preventDefault();
                return;
            }

            // Show loading state
            loading.style.display = 'block';
            uploadCard.style.opacity = '0.6';
        });
    }
}

// Initialize everything when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new LanguageManager();
    new ThemeManager();
    new FileUploadManager();
});

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});