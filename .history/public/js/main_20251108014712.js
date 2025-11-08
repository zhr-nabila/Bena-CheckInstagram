// Simple Language Manager
class LanguageManager {
    constructor() {
        this.currentLang = localStorage.getItem('bena-lang') || 'en';
        this.translations = {
            en: {
                // Hero Section
                heroTitle: "Discover Your True Instagram Circle",
                heroSubtitle: "Uncover who's not following you back with our sophisticated analytics platform. Private, secure, and designed for those who appreciate premium experiences.",
                startAnalysis: "Start Analysis",
                
                // Features
                feature1Title: "Accurate Analysis",
                feature1Desc: "Precise detection of non-reciprocal followers with advanced algorithms",
                feature2Title: "Premium Reports", 
                feature2Desc: "Beautifully designed PDF reports with comprehensive insights",
                feature3Title: "Secure & Private",
                feature3Desc: "Your data never leaves your browser. Complete privacy guaranteed",
                
                // Upload Section
                uploadTitle: "Upload Your Instagram Data",
                uploadSubtitle: "Select your followers.json and following.json files exported from Instagram to begin premium analysis",
                chooseFiles: "Choose Files",
                dragDrop: "Drag & drop files or click to browse",
                uploadBothFiles: "Upload Both Files to Continue",
                analyzeData: "Analyze Instagram Data",
                analyzing: "Analyzing your Instagram network with premium algorithms...",
                
                // Results Section
                resultsTitle: "Premium Analysis Complete",
                resultsSubtitle: "Your comprehensive Instagram engagement insights:",
                totalFollowers: "Total Followers",
                totalFollowing: "Total Following", 
                notFollowingBack: "Not Following Back",
                notFollowingBackList: "Accounts Not Following Back",
                perfectBalance: "Perfect Engagement Balance",
                perfectBalanceDesc: "Your Instagram network shows exceptional mutual engagement across all connections.",
                downloadReport: "Download Premium Report",
                newAnalysis: "New Analysis",
                
                // Credit Section
                craftedBy: "Crafted with precision by"
            },
            id: {
                // Hero Section
                heroTitle: "Temukan Lingkaran Instagram Anda",
                heroSubtitle: "Ungkap siapa yang tidak follow balik dengan platform analisis canggih kami. Pribadi, aman, dan dirancang untuk pengalaman premium.",
                startAnalysis: "Mulai Analisis",
                
                // Features
                feature1Title: "Analisis Akurat",
                feature1Desc: "Deteksi presisi pengikut tidak timbal balik dengan algoritma canggih",
                feature2Title: "Laporan Premium",
                feature2Desc: "Laporan PDF yang dirancang indah dengan wawasan komprehensif",
                feature3Title: "Aman & Pribadi", 
                feature3Desc: "Data Anda tidak pernah meninggalkan browser. Privasi lengkap terjamin",
                
                // Upload Section
                uploadTitle: "Unggah Data Instagram Anda",
                uploadSubtitle: "Pilih file followers.json dan following.json yang diekspor dari Instagram untuk memulai analisis premium",
                chooseFiles: "Pilih File",
                dragDrop: "Seret & lepas file atau klik untuk menjelajah",
                uploadBothFiles: "Unggah Kedua File untuk Melanjutkan",
                analyzeData: "Analisis Data Instagram", 
                analyzing: "Menganalisis jaringan Instagram Anda dengan algoritma premium...",
                
                // Results Section
                resultsTitle: "Analisis Premium Selesai",
                resultsSubtitle: "Wawasan komprehensif keterlibatan Instagram Anda:",
                totalFollowers: "Total Pengikut",
                totalFollowing: "Total Mengikuti",
                notFollowingBack: "Tidak Follow Balik",
                notFollowingBackList: "Akun yang Tidak Follow Balik",
                perfectBalance: "Keseimbangan Engagement Sempurna",
                perfectBalanceDesc: "Jaringan Instagram Anda menunjukkan keterlibatan timbal balik yang luar biasa di semua koneksi.",
                downloadReport: "Unduh Laporan Premium",
                newAnalysis: "Analisis Baru",
                
                // Credit Section
                craftedBy: "Dibuat dengan presisi oleh"
            }
        };
        this.init();
    }

    init() {
        this.applyLanguage(this.currentLang);
        this.bindEvents();
    }

    applyLanguage(lang) {
        this.currentLang = lang;
        localStorage.setItem('bena-lang', lang);
        this.updateAllTexts();
        this.updateLanguageToggle();
    }

    updateAllTexts() {
        const t = this.translations[this.currentLang];
        
        // Hero Section
        this.updateText('.hero h1', t.heroTitle);
        this.updateText('.hero p', t.heroSubtitle);
        this.updateText('.scroll-indicator', t.startAnalysis);
        
        // Features
        this.updateText('.feature-card:nth-child(1) h4', t.feature1Title);
        this.updateText('.feature-card:nth-child(1) p', t.feature1Desc);
        this.updateText('.feature-card:nth-child(2) h4', t.feature2Title);
        this.updateText('.feature-card:nth-child(2) p', t.feature2Desc);
        this.updateText('.feature-card:nth-child(3) h4', t.feature3Title);
        this.updateText('.feature-card:nth-child(3) p', t.feature3Desc);
        
        // Upload Section
        this.updateText('.upload-text h3', t.uploadTitle);
        this.updateText('.upload-text p', t.uploadSubtitle);
        this.updateText('.upload-btn', t.chooseFiles);
        this.updateText('.upload-hint', t.dragDrop);
        
        // Update submit button
        const submitBtn = document.querySelector('button[type="submit"]');
        if (submitBtn) {
            const span = submitBtn.querySelector('span');
            if (span) {
                span.textContent = submitBtn.disabled ? t.uploadBothFiles : t.analyzeData;
            }
        }
        
        this.updateText('#loading p', t.analyzing);
        
        // Results Section (if exists)
        this.updateResultsText(t);
        
        // Credit Section
        this.updateText('.credit-text', t.craftedBy);
    }

    updateResultsText(t) {
        const resultsCard = document.querySelector('.results-card');
        if (!resultsCard) return;

        this.updateText('.results-card h2', t.resultsTitle);
        this.updateText('.results-card > p', t.resultsSubtitle);
        this.updateText('.stat-card:nth-child(1) .stat-label', t.totalFollowers);
        this.updateText('.stat-card:nth-child(2) .stat-label', t.totalFollowing);
        this.updateText('.stat-card:nth-child(3) .stat-label', t.notFollowingBack);
        
        const unfollowersSection = document.querySelector('.unfollowers-section');
        if (unfollowersSection) {
            this.updateText('.unfollowers-section h3', t.notFollowingBackList);
        }
        
        const successState = document.querySelector('.success-state');
        if (successState) {
            this.updateText('.success-state h3', t.perfectBalance);
            this.updateText('.success-state p', t.perfectBalanceDesc);
        }
        
        const downloadBtn = document.querySelector('.btn-primary span');
        if (downloadBtn) {
            downloadBtn.textContent = t.downloadReport;
        }
        
        const newAnalysisBtn = document.querySelector('.btn-secondary span');
        if (newAnalysisBtn) {
            newAnalysisBtn.textContent = t.newAnalysis;
        }
    }

    updateText(selector, text) {
        const element = document.querySelector(selector);
        if (element) {
            element.textContent = text;
        }
    }

    updateLanguageToggle() {
        const toggle = document.querySelector('.language-toggle');
        if (toggle) {
            toggle.textContent = this.currentLang === 'en' ? 'ID' : 'EN';
        }
    }

    toggleLanguage() {
        const newLang = this.currentLang === 'en' ? 'id' : 'en';
        this.applyLanguage(newLang);
    }

    bindEvents() {
        const toggle = document.querySelector('.language-toggle');
        if (toggle) {
            toggle.addEventListener('click', () => this.toggleLanguage());
        }
    }
}

// Theme Manager
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
        localStorage.setItem('bena-theme', theme);
        this.updateThemeIcon(theme);
    }

    updateThemeIcon(theme) {
        const themeIcon = document.querySelector('.theme-icon');
        if (themeIcon) {
            themeIcon.innerHTML = theme === 'dark' ? 
                '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12,7c-2.76,0-5,2.24-5,5s2.24,5,5,5s5-2.24,5-5S14.76,7,12,7L12,7z M2,13l2,0c0.55,0,1-0.45,1-1s-0.45-1-1-1l-2,0 c-0.55,0-1,0.45-1,1S1.45,13,2,13z M20,13l2,0c0.55,0,1-0.45,1-1s-0.45-1-1-1l-2,0c-0.55,0-1,0.45-1,1S19.45,13,20,13z M11,2v2 c0,0.55,0.45,1,1,1s1-0.45,1-1V2c0-0.55-0.45-1-1-1S11,1.45,11,2z M11,20v2c0,0.55,0.45,1,1,1s1-0.45,1-1v-2c0-0.55-0.45-1-1-1 S11,19.45,11,20z M6.34,7.34l-1.41,1.41c-0.39,0.39-0.39,1.02,0,1.41c0.39,0.39,1.02,0.39,1.41,0l1.41-1.41 c0.39-0.39,0.39-1.02,0-1.41C7.36,6.95,6.73,6.95,6.34,7.34z M17.66,17.66l-1.41,1.41c-0.39,0.39-0.39,1.02,0,1.41 c0.39,0.39,1.02,0.39,1.41,0l1.41-1.41c0.39-0.39,0.39-1.02,0-1.41C18.68,17.27,18.05,17.27,17.66,17.66z"/></svg>' :
                '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M9.37,5.51C9.19,6.15,9.1,6.82,9.1,7.5c0,4.08,3.32,7.4,7.4,7.4c0.68,0,1.35-0.09,1.99-0.27C17.45,17.19,14.93,19,12,19 c-3.86,0-7-3.14-7-7C5,9.07,6.81,6.55,9.37,5.51z M12,3c-4.97,0-9,4.03-9,9s4.03,9,9,9s9-4.03,9-9c0-0.46-0.04-0.92-0.1-1.36 c-0.98,1.37-2.58,2.26-4.4,2.26c-2.98,0-5.4-2.42-5.4-5.4c0-1.81,0.89-3.42,2.26-4.4C12.92,3.04,12.46,3,12,3L12,3z"/></svg>';
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
        const uploadBtn = document.querySelector('.upload-btn');
        const uploadArea = document.querySelector('.upload-area');
        const form = document.getElementById('checkForm');

        if (uploadBtn) {
            uploadBtn.addEventListener('click', () => this.triggerFileInput());
        }

        if (uploadArea) {
            uploadArea.addEventListener('click', () => this.triggerFileInput());
        }

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

    processFiles(files) {
        if (!files.length) return;

        Array.from(files).forEach(file => {
            if (file.type === 'application/json' || file.name.endsWith('.json')) {
                this.addFile(file);
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
        
        return prompt(`Is "${filename}" your followers or following file? Type "followers" or "following":`) === 'followers' ? 'followers' : 'following';
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
        
        const submitBtn = document.querySelector('button[type="submit"]');
        if (!submitBtn) return;
        
        if (hasFollowers && hasFollowing) {
            submitBtn.disabled = false;
            const langManager = window.languageManager;
            if (langManager) {
                const span = submitBtn.querySelector('span');
                if (span) {
                    span.textContent = langManager.translations[langManager.currentLang].analyzeData;
                }
            }
        } else {
            submitBtn.disabled = true;
        }
    }

    updateFormInputs() {
        const form = document.getElementById('checkForm');
        if (!form) return;

        // Update the actual file inputs
        const followersInput = form.querySelector('input[name="followers"]');
        const followingInput = form.querySelector('input[name="following"]');
        
        // Note: In a real implementation, you'd need to handle file assignment properly
        // This is simplified for the UI
    }

    handleFormSubmit(e) {
        if (!this.files.followers || !this.files.following) {
            e.preventDefault();
            alert('Please upload both followers and following files');
            return;
        }

        const loading = document.getElementById('loading');
        if (loading) {
            loading.style.display = 'block';
        }
    }
}

// Initialize everything when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new LanguageManager();
    new ThemeManager();
    new FileUploadManager();
});