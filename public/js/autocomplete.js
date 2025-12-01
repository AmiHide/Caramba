document.addEventListener("DOMContentLoaded", function () {


    const villes = window.autocompleteVilles || [];

    function setupAutocomplete(inputId, listId) {
        const input = document.getElementById(inputId);
        const list  = document.getElementById(listId);

        if (!input || !list) return; 

        input.addEventListener("input", function () {
            const val = this.value.toLowerCase();
            list.innerHTML = "";

            if (val === "") {
                list.style.display = "none";
                return;
            }

            const matches = villes.filter(v => v.toLowerCase().includes(val));

            if (matches.length === 0) {
                list.style.display = "none";
                return;
            }

            matches.forEach(v => {
                const item = document.createElement("div");
                item.textContent = v;
                item.classList.add("autocomplete-item");

                item.addEventListener("click", () => {
                    input.value = v;
                    list.style.display = "none";
                });

                list.appendChild(item);
            });

            list.style.display = "block";
        });

        document.addEventListener("click", function (e) {
            if (!list.contains(e.target) && e.target !== input) {
                list.style.display = "none";
            }
        });
    }

    setupAutocomplete("departInput", "departList");
    setupAutocomplete("arriveeInput", "arriveeList");
});
