let trajetDeleteUrl = null;

document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', e => {
        e.preventDefault();
        trajetDeleteUrl = btn.getAttribute('href');
        document.getElementById('trajetConfirmModal').style.display = 'flex';
    });
});

document.getElementById('trajetConfirmYes').addEventListener('click', () => {
    if (trajetDeleteUrl) {
        window.location.href = trajetDeleteUrl;
    }
});

document.getElementById('trajetConfirmNo').addEventListener('click', () => {
    document.getElementById('trajetConfirmModal').style.display = 'none';
    trajetDeleteUrl = null;
});
