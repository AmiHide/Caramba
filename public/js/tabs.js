document.querySelectorAll(".tab").forEach(tab => {
    if (tab.classList.contains("disabled")) return;

    tab.addEventListener("click", () => {

        document.querySelectorAll(".tab").forEach(t => t.classList.remove("active"));
        tab.classList.add("active");

        let target = tab.getAttribute("data-target");

        document.querySelectorAll(".tab-content").forEach(c => {
            c.classList.remove("active");
        });

        document.getElementById(target).classList.add("active");
    });
});
