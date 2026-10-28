// AdminLTE 4 + Bootstrap 5 Entry Point
// Only loaded in AdminLTE layout

import 'bootstrap';
import 'admin-lte';
import 'bootstrap-icons/font/bootstrap-icons.css';

// Initialize AdminLTE sidebar toggle
document.addEventListener('DOMContentLoaded', () => {
    // Sidebar toggle button
    const sidebarToggle = document.querySelector('[data-widget="pushmenu"]');
    const appWrapper = document.querySelector('.app-wrapper');
    
    if (sidebarToggle && appWrapper) {
        sidebarToggle.addEventListener('click', () => {
            appWrapper.classList.toggle('sidebar-collapse');
            appWrapper.classList.toggle('sidebar-open');
        });
    }
    
    // Mobile sidebar overlay close
    const sidebarOverlay = document.querySelector('.sidebar-overlay');
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', () => {
            appWrapper?.classList.remove('sidebar-open');
        });
    }
    
    // Dropdown auto-close on click outside (Bootstrap handles this)
    // Additional: make sure only one dropdown open at a time
    document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
        toggle.addEventListener('click', (e) => {
            // Let Bootstrap handle the dropdown
        });
    });
    
    // Focus visible for keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Tab') {
            document.body.classList.add('keyboard-nav');
        }
    });
    
    document.addEventListener('mousedown', () => {
        document.body.classList.remove('keyboard-nav');
    });
});

// Toast notification helper (if needed)
window.showToast = (message, type = 'success') => {
    const toastContainer = document.getElementById('toast-container') || (() => {
        const div = document.createElement('div');
        div.id = 'toast-container';
        div.className = 'toast-container position-fixed bottom-0 end-0 p-3';
        document.body.appendChild(div);
        return div;
    })();
    
    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-bg-${type} border-0`;
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">${message}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    `;
    
    toastContainer.appendChild(toast);
    const bsToast = new bootstrap.Toast(toast);
    bsToast.show();
    
    toast.addEventListener('hidden.bs.toast', () => toast.remove());
};