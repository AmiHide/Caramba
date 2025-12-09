window.addEventListener("pageshow", function (event) {
    const nav = performance.getEntriesByType("navigation")[0];

    if (event.persisted || (nav && nav.type === "back_forward")) {
        window.location.reload();
    }
});
