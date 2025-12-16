let currentDeleteUrl = null;

document.querySelectorAll('.delete-btn').forEach(btn => {
  btn.addEventListener('click', e => {
    e.preventDefault();
    currentDeleteUrl = btn.getAttribute('href'); // stocke le lien à exécuter
    document.getElementById('confirmModal').style.display = 'flex';
  });
});

document.getElementById('confirmYes').addEventListener('click', () => {
  if (currentDeleteUrl) {
    window.location.href = currentDeleteUrl;
  }
});

document.getElementById('confirmNo').addEventListener('click', () => {
  document.getElementById('confirmModal').style.display = 'none';
  currentDeleteUrl = null;
});
