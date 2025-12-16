document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    // Correction 1 : Majuscule à "Caramba" pour éviter les erreurs 404
    fetch('/Caramba/index.php?page=contact_send', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(result => {
        // Correction 2 : On vérifie ce que répond le PHP
        console.log("Réponse serveur :", result); // Regardez la console (F12) !

        if (result.trim() === 'SUCCESS') {
            showToast("✔ Votre message a été envoyé !");
            document.getElementById('contactForm').reset();
        } else {
            // Affiche l'erreur réelle si ce n'est pas SUCCESS
            showToast("❌ Erreur : " + result, true);
        }
    })
    .catch(error => {
        console.error(error);
        showToast("❌ Erreur technique (voir console)", true);
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
    }, 5000); // J'ai augmenté un peu le temps pour lire l'erreur
}