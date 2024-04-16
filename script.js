// script.js

document.addEventListener("DOMContentLoaded", function() {
  const form = document.getElementById('input-form');
  const resultTableBody = document.querySelector('#result-table tbody');

  form.addEventListener('submit', function(event) {
      event.preventDefault();
      
      const formData = new FormData(form);
      const nama = formData.get('nama');
      const jenis = formData.get('jenis');
      const hp = formData.get('hp');
      const komentar = formData.get('komentar');

      // Menambahkan data ke dalam tabel hasil
      const row = document.createElement('tr');
      row.innerHTML = `
          <td>${nama}</td>
          <td>${jenis}</td>
          <td>${hp || '-'}</td>
          <td>${komentar}</td>
      `;
      resultTableBody.appendChild(row);

      // Reset form setelah submit
      form.reset();
  });
});
