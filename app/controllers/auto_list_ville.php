<script>
    const villes = [
        <?php foreach($villes as $v): ?>
            "<?= addslashes($v['nom']) ?>",
        <?php endforeach; ?>
    ];

    
    function setupAutocomplete(inputId, boxId) {
        const input = document.getElementById(inputId);
        const box = document.getElementById(boxId);

        input.addEventListener("input", () => {
            const search = input.value.toLowerCase();
            box.innerHTML = "";

            if (search.length === 0) {
                box.style.display = "none";
                return;
            }

            const results = villes
                .filter(v => v.toLowerCase().startsWith(search))
                .slice(0, 8);

            results.forEach(city => {
                const item = document.createElement("div");
                item.className = "suggestion-item";
                item.textContent = city;

                item.onclick = () => {
                    input.value = city;
                    box.style.display = "none";
                };

                box.appendChild(item);
            });

            box.style.display = results.length ? "block" : "none";
        });

        document.addEventListener("click", e => {
            if (!box.contains(e.target) && e.target !== input) {
                box.style.display = "none";
            }
        });
    }

    setupAutocomplete("ville-depart", "suggestions-depart");
    setupAutocomplete("ville-arrivee", "suggestions-arrivee");
</script>