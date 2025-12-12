document.querySelectorAll('.pref-buttons').forEach(group => {
    const labels = group.querySelectorAll('.pref-btn');

    labels.forEach(label => {
        label.addEventListener('click', () => {
            labels.forEach(l => l.classList.remove('active'));
            label.classList.add('active');
        });
    });
});
