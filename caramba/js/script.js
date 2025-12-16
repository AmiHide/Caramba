function openModal(field) {
    document.getElementById('editModal').style.display = 'flex';
    document.getElementById('editField').value = field;
    
    const titles = {
        'nom': 'Modifier le nom',
        'description': 'Modifier la description',
        'type_permis': 'Modifier le type de permis',
        'anciennete_compte': 'Modifier l\'ancienneté',
        'type_voiture': 'Modifier le type de voiture'
    };
    
    document.getElementById('modalTitle').textContent = titles[field] || 'Modifier';
}

function closeModal() {
    document.getElementById('editModal').style.display = 'none';
    document.getElementById('editValue').value = '';
}

function saveField() {
    const field = document.getElementById('editField').value;
    const value = document.getElementById('editValue').value;
    
    if (!value) {
        alert('Veuillez entrer une valeur');
        return;
    }
    
    updateField(field, value);
    closeModal();
}

function updateField(field, value) {
    fetch('update_profile.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `field=${field}&value=${encodeURIComponent(value)}&user_id=1`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Erreur lors de la mise à jour');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Erreur de connexion');
    });
}