/**
 * App.js: Interaktivitas Utama UI Smart Clinic ERP
 * Mendukung Modal Dialog, Konfirmasi Delete, dan Toggling Sidebar Mobile
 */

document.addEventListener('DOMContentLoaded', () => {
  // 1. Toggling Sidebar Responsive
  const toggleBtn = document.querySelector('.btn-toggle-sidebar');
  const sidebar = document.querySelector('.sidebar');
  const backdrop = document.querySelector('.sidebar-backdrop');

  if (toggleBtn && sidebar) {
    toggleBtn.addEventListener('click', () => {
      sidebar.classList.toggle('active');
      if (backdrop) backdrop.classList.toggle('active');
    });
  }

  if (backdrop) {
    backdrop.addEventListener('click', () => {
      sidebar.classList.remove('active');
      backdrop.classList.remove('active');
    });
  }

  // 2. Konfirmasi Hapus Data Aman
  const deleteButtons = document.querySelectorAll('.btn-confirm-delete');
  deleteButtons.forEach(btn => {
    btn.addEventListener('click', (e) => {
      const msg = btn.getAttribute('data-msg') || 'Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.';
      if (!confirm(msg)) {
        e.preventDefault();
      }
    });
  });

  // 3. Modal Toggling
  const modalTriggers = document.querySelectorAll('[data-toggle="modal"]');
  modalTriggers.forEach(trigger => {
    trigger.addEventListener('click', (e) => {
      e.preventDefault();
      const targetId = trigger.getAttribute('data-target');
      const targetModal = document.querySelector(targetId);
      if (targetModal) {
        targetModal.style.display = 'flex';
      }
    });
  });

  const modalCloses = document.querySelectorAll('.modal-close, .btn-modal-cancel');
  modalCloses.forEach(closeBtn => {
    closeBtn.addEventListener('click', () => {
      const modal = closeBtn.closest('.modal-overlay');
      if (modal) modal.style.display = 'none';
    });
  });
});

