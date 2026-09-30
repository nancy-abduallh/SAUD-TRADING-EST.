/**
 * SAUD-TRADING-EST Admin Dashboard JavaScript
 * Complete implementation for UI interactions, Charts, AJAX CRUD, and Utilities.
 */

document.addEventListener('DOMContentLoaded', () => {
    // 1. Sidebar functionality
    initSidebar();
    
    // 2. Charts Initialization (if canvas exists)
    if (document.getElementById('monthlyChart')) {
        initDashboardCharts();
    }
    
    // 3. Modals and UI Elements
    window.modalManager = new ModalManager();
    window.toastManager = new ToastManager();
    
    // 4. Header Dropdowns
    initDropdowns();
    
    // 5. KPI Animations
    animateCounters();
    
    // 6. Tabs if present
    initTabs();
});

// ==========================================
// 1. Sidebar
// ==========================================
function initSidebar() {
    const sidebar = document.querySelector('.sidebar');
    const collapseBtn = document.querySelector('.sidebar-collapse-btn');
    const mobileToggle = document.querySelector('.mobile-toggle');
    const layout = document.querySelector('.dashboard-layout');

    if (collapseBtn && sidebar && layout) {
        collapseBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            layout.classList.toggle('collapsed');
        });
    }

    if (mobileToggle && layout) {
        mobileToggle.addEventListener('click', () => {
            layout.classList.toggle('mobile-open');
        });
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(e.target) && !mobileToggle.contains(e.target) && layout.classList.contains('mobile-open')) {
                    layout.classList.remove('mobile-open');
                }
            }
        });
    }

    // Set active link based on current URL
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.sidebar-link');
    navLinks.forEach(link => {
        if (link.getAttribute('href') && currentPath.includes(link.getAttribute('href'))) {
            navLinks.forEach(l => l.classList.remove('active'));
            link.classList.add('active');
        }
    });
}

// ==========================================
// 2. Charts (Chart.js)
// ==========================================
function initDashboardCharts() {
    if (typeof Chart === 'undefined') {
        console.warn('Chart.js not loaded');
        return;
    }

    // Global Defaults for Dark Theme
    Chart.defaults.color = '#8a8fb5';
    Chart.defaults.borderColor = 'rgba(255, 255, 255, 0.05)';
    Chart.defaults.font.family = "'Inter', sans-serif";
    
    const commonOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                labels: { color: '#e8eaf6' }
            },
            tooltip: {
                backgroundColor: 'rgba(18, 21, 42, 0.9)',
                titleColor: '#fff',
                bodyColor: '#e8eaf6',
                borderColor: 'rgba(79, 195, 247, 0.2)',
                borderWidth: 1,
                padding: 10,
                displayColors: true
            }
        }
    };

    // Monthly Line Chart
    const monthlyCtx = document.getElementById('monthlyChart');
    if (monthlyCtx) {
        const gradient = monthlyCtx.getContext('2d').createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(79, 195, 247, 0.5)');
        gradient.addColorStop(1, 'rgba(79, 195, 247, 0.0)');

        new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                datasets: [{
                    label: 'Messages',
                    data: [65, 59, 80, 81, 56, 55, 40],
                    borderColor: '#4fc3f7',
                    backgroundColor: gradient,
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#12152a',
                    pointBorderColor: '#4fc3f7',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                ...commonOptions,
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(255, 255, 255, 0.05)' } },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    // Doughnut Chart
    const distCtx = document.getElementById('distributionChart');
    if (distCtx) {
        new Chart(distCtx, {
            type: 'doughnut',
            data: {
                labels: ['Products', 'Services', 'Projects'],
                datasets: [{
                    data: [300, 50, 100],
                    backgroundColor: ['#4fc3f7', '#00e5ff', '#7c4dff'],
                    borderColor: '#12152a',
                    borderWidth: 2,
                    hoverOffset: 4
                }]
            },
            options: {
                ...commonOptions,
                cutout: '75%',
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    }

    // Bar Chart
    const visitorsCtx = document.getElementById('visitorsChart');
    if (visitorsCtx) {
        new Chart(visitorsCtx, {
            type: 'bar',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Unique Visitors',
                    data: [120, 190, 300, 250, 200, 150, 100],
                    backgroundColor: 'rgba(0, 229, 255, 0.7)',
                    borderRadius: 4,
                    hoverBackgroundColor: '#00e5ff'
                }]
            },
            options: {
                ...commonOptions,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }
}

// ==========================================
// 3. AJAX CRUD API
// ==========================================
class DashboardAPI {
    constructor() {
        // Find CSRF token if it exists in meta tag
        const csrfMeta = document.querySelector('meta[name="csrf-token"]');
        this.csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';
        this.baseUrl = '/admin/api/';
    }

    async request(endpoint, method = 'GET', data = null) {
        const url = `${this.baseUrl}${endpoint}`;
        const options = {
            method,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        };

        if (this.csrfToken) {
            options.headers['X-CSRF-TOKEN'] = this.csrfToken;
        }

        if (data) {
            if (data instanceof FormData) {
                options.body = data;
                // Don't set Content-Type for FormData, browser does it with boundary
            } else {
                options.headers['Content-Type'] = 'application/json';
                options.body = JSON.stringify(data);
            }
        }

        try {
            const response = await fetch(url, options);
            const result = await response.json();
            
            if (!response.ok) {
                throw new Error(result.message || 'API request failed');
            }
            
            return result;
        } catch (error) {
            console.error(`API Error (${method} ${endpoint}):`, error);
            if (window.toastManager) {
                window.toastManager.error(error.message || 'A network error occurred.');
            }
            throw error;
        }
    }

    async getAll(entity) {
        return this.request(`${entity}/list.php`);
    }

    async create(entity, data) {
        return this.request(`${entity}/create.php`, 'POST', data);
    }

    async update(entity, id, data) {
        // Append ID to FormData if using FormData, or add to object
        if (data instanceof FormData) {
            data.append('id', id);
            return this.request(`${entity}/update.php`, 'POST', data);
        } else {
            data.id = id;
            return this.request(`${entity}/update.php`, 'POST', data);
        }
    }

    async delete(entity, id) {
        const formData = new FormData();
        formData.append('id', id);
        return this.request(`${entity}/delete.php`, 'POST', formData);
    }
    
    async uploadImage(file) {
        const formData = new FormData();
        formData.append('image', file);
        return this.request(`upload.php`, 'POST', formData);
    }
}
window.api = new DashboardAPI();

// ==========================================
// 4. Modal Manager
// ==========================================
class ModalManager {
    constructor() {
        this.modals = {};
        this.overlay = document.createElement('div');
        this.overlay.className = 'modal-overlay';
        document.body.appendChild(this.overlay);
        
        this.overlay.addEventListener('click', (e) => {
            if (e.target === this.overlay) {
                this.closeAll();
            }
        });
        
        // Setup initial modals in DOM
        document.querySelectorAll('.modal').forEach(modal => {
            const id = modal.id;
            if (id) {
                this.modals[id] = modal;
                modal.remove(); // Remove from DOM to put inside overlay later
                
                // Add close button listener
                const closeBtn = modal.querySelector('.modal-close');
                if (closeBtn) {
                    closeBtn.addEventListener('click', () => this.close(id));
                }
            }
        });
    }

    open(id) {
        const modal = this.modals[id];
        if (!modal) return;
        
        this.overlay.innerHTML = '';
        this.overlay.appendChild(modal);
        this.overlay.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    close(id) {
        this.overlay.classList.remove('show');
        document.body.style.overflow = '';
        setTimeout(() => {
            this.overlay.innerHTML = '';
        }, 300); // match transition
    }
    
    closeAll() {
        this.overlay.classList.remove('show');
        document.body.style.overflow = '';
        setTimeout(() => {
            this.overlay.innerHTML = '';
        }, 300);
    }

    confirm(title, message, onConfirm) {
        if (!this.modals['confirmModal']) {
            this._createConfirmModal();
        }
        
        const modal = this.modals['confirmModal'];
        modal.querySelector('.modal-title').textContent = title;
        modal.querySelector('.modal-body').textContent = message;
        
        const confirmBtn = modal.querySelector('#confirmBtn');
        
        // Remove old listeners
        const newConfirmBtn = confirmBtn.cloneNode(true);
        confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);
        
        newConfirmBtn.addEventListener('click', () => {
            onConfirm();
            this.close('confirmModal');
        });
        
        this.open('confirmModal');
    }
    
    _createConfirmModal() {
        const modalHtml = `
            <div class="modal" id="confirmModal">
                <div class="modal-header">
                    <h3 class="modal-title">Confirm</h3>
                    <button class="modal-close"><i class="fas fa-times"></i></button>
                </div>
                <div class="modal-body">Are you sure?</div>
                <div class="modal-footer">
                    <button class="btn btn-ghost" onclick="modalManager.close('confirmModal')">Cancel</button>
                    <button class="btn btn-danger" id="confirmBtn">Confirm</button>
                </div>
            </div>
        `;
        const temp = document.createElement('div');
        temp.innerHTML = modalHtml;
        const modal = temp.firstElementChild;
        
        modal.querySelector('.modal-close').addEventListener('click', () => this.close('confirmModal'));
        this.modals['confirmModal'] = modal;
    }
}

// ==========================================
// 5. Toast System
// ==========================================
class ToastManager {
    constructor() {
        this.container = document.createElement('div');
        this.container.className = 'toast-container';
        document.body.appendChild(this.container);
    }

    show(message, type = 'info', duration = 3000) {
        const toast = document.createElement('div');
        toast.className = `toast toast--${type}`;
        
        let icon = 'info-circle';
        if (type === 'success') icon = 'check-circle';
        if (type === 'error') icon = 'exclamation-circle';

        toast.innerHTML = `
            <div class="toast-icon"><i class="fas fa-${icon}"></i></div>
            <div class="toast-content">
                <div class="toast-title">${type.charAt(0).toUpperCase() + type.slice(1)}</div>
                <div class="toast-message">${message}</div>
            </div>
            <button class="toast-close"><i class="fas fa-times"></i></button>
            <div class="toast-progress"><div class="toast-progress-bar"></div></div>
        `;

        this.container.appendChild(toast);
        
        // Progress bar animation
        const progressBar = toast.querySelector('.toast-progress-bar');
        progressBar.style.transition = `transform ${duration}ms linear`;
        
        // Force reflow
        void toast.offsetWidth;
        progressBar.style.transform = 'scaleX(0)';

        // Close button
        toast.querySelector('.toast-close').addEventListener('click', () => {
            this._removeToast(toast);
        });

        // Auto remove
        setTimeout(() => {
            if (this.container.contains(toast)) {
                this._removeToast(toast);
            }
        }, duration);
    }

    _removeToast(toast) {
        toast.classList.add('hiding');
        setTimeout(() => {
            if (this.container.contains(toast)) {
                toast.remove();
            }
        }, 300);
    }

    success(msg) { this.show(msg, 'success'); }
    error(msg) { this.show(msg, 'error', 5000); }
    info(msg) { this.show(msg, 'info'); }
}

// ==========================================
// 6. DataTable
// ==========================================
class DataTable {
    constructor(tableId, options = {}) {
        this.table = document.getElementById(tableId);
        if (!this.table) return;
        
        this.tbody = this.table.querySelector('tbody');
        this.searchInput = document.querySelector(options.searchId || '.table-search input');
        
        this.rows = Array.from(this.tbody.querySelectorAll('tr'));
        this.sortCol = -1;
        this.sortAsc = true;
        
        this._initEvents();
    }
    
    _initEvents() {
        // Search
        if (this.searchInput) {
            this.searchInput.addEventListener('input', (e) => this.filter(e.target.value));
        }
        
        // Sort
        const headers = this.table.querySelectorAll('th.sortable');
        headers.forEach((th, index) => {
            th.addEventListener('click', () => this.sort(index));
        });
    }
    
    filter(query) {
        const term = query.toLowerCase();
        this.rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(term) ? '' : 'none';
        });
    }
    
    sort(columnIndex) {
        if (this.sortCol === columnIndex) {
            this.sortAsc = !this.sortAsc;
        } else {
            this.sortCol = columnIndex;
            this.sortAsc = true;
        }
        
        // Update header UI
        const headers = this.table.querySelectorAll('th');
        headers.forEach(th => {
            const icon = th.querySelector('i');
            if(icon) {
                if (th === headers[columnIndex]) {
                    icon.className = this.sortAsc ? 'fas fa-sort-up' : 'fas fa-sort-down';
                    icon.style.opacity = '1';
                } else {
                    icon.className = 'fas fa-sort';
                    icon.style.opacity = '0.5';
                }
            }
        });
        
        // Sort rows
        const sortedRows = this.rows.sort((a, b) => {
            let valA = a.children[columnIndex].textContent.trim();
            let valB = b.children[columnIndex].textContent.trim();
            
            // Try numeric sort
            if (!isNaN(valA) && !isNaN(valB)) {
                return this.sortAsc ? valA - valB : valB - valA;
            }
            
            // String sort
            return this.sortAsc ? valA.localeCompare(valB) : valB.localeCompare(valA);
        });
        
        // Re-append
        this.tbody.innerHTML = '';
        sortedRows.forEach(row => this.tbody.appendChild(row));
    }
}

// Initialize tables
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.data-table').forEach(table => {
        if(table.id) new DataTable(table.id);
    });
});

// ==========================================
// 7. Image Upload Preview
// ==========================================
function setupImageUpload(inputId, previewContainerId) {
    const input = document.getElementById(inputId);
    const container = document.getElementById(previewContainerId);
    if (!input || !container) return;
    
    const wrapper = input.closest('.image-upload');
    
    // Drag & Drop
    if (wrapper) {
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            wrapper.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            wrapper.addEventListener(eventName, () => wrapper.classList.add('dragover'), false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            wrapper.addEventListener(eventName, () => wrapper.classList.remove('dragover'), false);
        });
        
        wrapper.addEventListener('drop', (e) => {
            let dt = e.dataTransfer;
            let files = dt.files;
            input.files = files;
            handleFiles(files);
        });
    }

    input.addEventListener('change', function() {
        handleFiles(this.files);
    });
    
    function handleFiles(files) {
        container.innerHTML = '';
        if (files && files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.createElement('div');
                preview.className = 'image-preview-container';
                preview.innerHTML = `
                    <img src="${e.target.result}" alt="Preview">
                    <div class="image-preview-remove" onclick="removeImagePreview('${inputId}', '${previewContainerId}')"><i class="fas fa-times"></i></div>
                `;
                container.appendChild(preview);
                if (wrapper) wrapper.querySelector('.upload-prompt').style.display = 'none';
            }
            reader.readAsDataURL(files[0]);
        }
    }
}

window.removeImagePreview = function(inputId, previewContainerId) {
    document.getElementById(inputId).value = '';
    document.getElementById(previewContainerId).innerHTML = '';
    const wrapper = document.getElementById(inputId).closest('.image-upload');
    if (wrapper) wrapper.querySelector('.upload-prompt').style.display = 'block';
}

// ==========================================
// 8. KPI Counter Animation
// ==========================================
function animateCounters() {
    const counters = document.querySelectorAll('.kpi-value[data-target]');
    const speed = 200;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                const target = +counter.getAttribute('data-target');
                const isCurrency = counter.getAttribute('data-currency') === 'true';
                
                const updateCount = () => {
                    const current = +counter.innerText.replace(/[^0-9.-]+/g,"");
                    const inc = target / speed;

                    if (current < target) {
                        let val = Math.ceil(current + inc);
                        if (isCurrency) {
                            counter.innerText = '$' + val.toLocaleString();
                        } else {
                            counter.innerText = val;
                        }
                        setTimeout(updateCount, 10);
                    } else {
                        if (isCurrency) {
                            counter.innerText = '$' + target.toLocaleString();
                        } else {
                            counter.innerText = target;
                        }
                    }
                };

                updateCount();
                observer.unobserve(counter);
            }
        });
    });

    counters.forEach(counter => {
        counter.innerText = '0';
        observer.observe(counter);
    });
}

// ==========================================
// 9. Utility Functions
// ==========================================
window.confirmDelete = function(entity, id, name) {
    if (window.modalManager) {
        window.modalManager.confirm(
            'Delete Record',
            `Are you sure you want to delete "${name}"? This action cannot be undone.`,
            async () => {
                try {
                    await window.api.delete(entity, id);
                    window.toastManager.success(`${name} deleted successfully`);
                    // Reload page or remove row
                    setTimeout(() => window.location.reload(), 1000);
                } catch (e) {
                    // Error handled by API
                }
            }
        );
    } else {
        if(confirm(`Are you sure you want to delete "${name}"?`)) {
            // Fallback sync submit
        }
    }
};

window.toggleStatus = async function(entity, id, currentStatus) {
    try {
        const newStatus = currentStatus == 1 ? 0 : 1;
        const formData = new FormData();
        formData.append('status', newStatus);
        
        await window.api.update(entity, id, formData);
        window.toastManager.success('Status updated successfully');
        setTimeout(() => window.location.reload(), 500);
    } catch(e) {
        // Error handled
    }
};

// Tabs initialization
function initTabs() {
    const tabs = document.querySelectorAll('.tab-btn');
    if(tabs.length === 0) return;
    
    tabs.forEach(tab => {
        tab.addEventListener('click', (e) => {
            const targetId = tab.getAttribute('data-target');
            
            // Remove active classes
            document.querySelectorAll('.tab-btn').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
            
            // Add active class
            tab.classList.add('active');
            document.getElementById(targetId).classList.add('active');
        });
    });
}

// Dropdowns
function initDropdowns() {
    // Basic dropdown toggle logic if needed for header profile
    const profileDropdown = document.querySelector('.profile-dropdown');
    if(profileDropdown) {
        // Just an example, normally would toggle a sub-menu
        profileDropdown.addEventListener('click', () => {
            // toggle logic
        });
    }
}
