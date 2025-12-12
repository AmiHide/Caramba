document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('/caramba/public/index.php?page=contact_send', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(result => {
        showToast("✔ Votre message a été envoyé !");
        document.getElementById('contactForm').reset();
    })
    .catch(error => {
        showToast("❌ Une erreur est survenue", true);
    });
});

function showToast(message, isError = false) {
    const toast = document.getElementById('toast');

    toast.classList.remove('hidden');
    toast.classList.add('show');
    toast.classList.toggle('error', isError);
    toast.classList.toggle('success', !isError);

    toast.textContent = message;

    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.classList.add('hidden'), 400);
    }, 3000);
}
