/**
 * form-validator.js: Validasi Formulir di Sisi Klien (Vanilla JS)
 */

document.addEventListener('DOMContentLoaded', () => {
  const forms = document.querySelectorAll('form[data-validate="true"]');
  forms.forEach(form => {
    form.addEventListener('submit', (e) => {
      let isValid = true;
      const requiredInputs = form.querySelectorAll('[required]');

      requiredInputs.forEach(input => {
        if (!input.value.trim()) {
          isValid = false;
          input.style.borderColor = '#EF4444';
          input.classList.add('is-invalid');
        } else {
          input.style.borderColor = '#E2E8F0';
          input.classList.remove('is-invalid');
        }
      });

      if (!isValid) {
        e.preventDefault();
        alert('Mohon lengkapi seluruh kolom formulir yang wajib diisi bertanda bintang (*)!');
      }
    });
  });
});

