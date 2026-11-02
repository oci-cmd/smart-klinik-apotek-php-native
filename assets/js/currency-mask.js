/**
 * currency-mask.js: Pemformatan Otomatis Mata Uang Rupiah (Live Masking)
 */

function formatRupiah(angka) {
  const numberString = angka.replace(/[^,\d]/g, '').toString();
  const split = numberString.split(',');
  const sisa = split[0].length % 3;
  let rupiah = split[0].substr(0, sisa);
  const ribuan = split[0].substr(sisa).match(/\d{3}/gi);

  if (ribuan) {
    const separator = sisa ? '.' : '';
    rupiah += separator + ribuan.join('.');
  }

  return split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
}

document.addEventListener('DOMContentLoaded', () => {
  const rupiahInputs = document.querySelectorAll('.input-rupiah');
  rupiahInputs.forEach(input => {
    input.addEventListener('keyup', (e) => {
      input.value = formatRupiah(input.value);
    });
  });
});

