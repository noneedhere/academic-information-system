// ============================================================
// SIAKAD — App JavaScript
// ============================================================

// --- Real-time clock for dashboard ---
function initClock() {
    const el = document.getElementById('realtime-clock');
    if (!el) return;

    function update() {
        const now = new Date();
        el.textContent = now.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false,
        });
    }

    update();
    setInterval(update, 1000);
}

// --- Flash message auto-dismiss ---
function initFlashMessages() {
    document.querySelectorAll('[data-flash]').forEach((el) => {
        const delay = parseInt(el.dataset.flashDelay || '4000', 10);

        setTimeout(() => {
            el.classList.add('flash-dismiss');
            el.addEventListener('animationend', () => el.remove());
        }, delay);
    });
}

// --- Mobile sidebar toggle ---
function initSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    const openBtn = document.getElementById('sidebar-open');
    const closeBtn = document.getElementById('sidebar-close');

    if (!sidebar) return;

    function open() {
        sidebar.classList.remove('-translate-x-full');
        sidebar.classList.add('translate-x-0');
        if (overlay) {
            overlay.classList.remove('hidden', 'opacity-0');
            overlay.classList.add('opacity-100');
        }
        document.body.classList.add('overflow-hidden', 'lg:overflow-auto');
    }

    function close() {
        sidebar.classList.add('-translate-x-full');
        sidebar.classList.remove('translate-x-0');
        if (overlay) {
            overlay.classList.add('opacity-0');
            setTimeout(() => overlay.classList.add('hidden'), 300);
        }
        document.body.classList.remove('overflow-hidden', 'lg:overflow-auto');
    }

    if (openBtn) openBtn.addEventListener('click', open);
    if (closeBtn) closeBtn.addEventListener('click', close);
    if (overlay) overlay.addEventListener('click', close);

    // Close on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !sidebar.classList.contains('-translate-x-full')) {
            close();
        }
    });
}

// --- Profile photo preview ---
function initPhotoPreview() {
    const input = document.getElementById('profile-photo-input');
    const preview = document.getElementById('profile-photo-preview');

    if (!input || !preview) return;

    input.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (!file) return;

        // Validate type
        if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type)) {
            alert('Please select a JPEG, PNG, or WebP image.');
            input.value = '';
            return;
        }

        // Validate size (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('Image must be smaller than 2MB.');
            input.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = (ev) => {
            preview.src = ev.target.result;
        };
        reader.readAsDataURL(file);
    });
}

// --- Form loading states ---
function initFormLoading() {
    document.querySelectorAll('form[data-loading]').forEach((form) => {
        form.addEventListener('submit', () => {
            const btn = form.querySelector('button[type="submit"]');
            if (!btn || btn.disabled) return;

            btn.disabled = true;
            const originalText = btn.innerHTML;
            btn.dataset.originalText = originalText;
            btn.innerHTML = `<span class="spinner"></span> Processing...`;
        });
    });
}

// --- Modal ---
function initModals() {
    // Open modal
    document.querySelectorAll('[data-modal-target]').forEach((trigger) => {
        trigger.addEventListener('click', (e) => {
            e.preventDefault();
            const modalId = trigger.dataset.modalTarget;
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
        });
    });

    // Close modal
    document.querySelectorAll('[data-modal-close]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const modal = btn.closest('.modal-overlay');
            if (modal) {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        });
    });

    // Close on overlay click
    document.querySelectorAll('.modal-overlay').forEach((overlay) => {
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        });
    });

    // Close on Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-overlay:not(.hidden)').forEach((modal) => {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            });
        }
    });
}

// --- Confirm delete ---
function initConfirmDelete() {
    document.querySelectorAll('[data-confirm]').forEach((el) => {
        el.addEventListener('click', (e) => {
            const message = el.dataset.confirm || 'Are you sure?';
            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    });
}

// --- Initialize all on DOM ready ---
document.addEventListener('DOMContentLoaded', () => {
    initClock();
    initFlashMessages();
    initSidebar();
    initPhotoPreview();
    initFormLoading();
    initModals();
    initConfirmDelete();
});
