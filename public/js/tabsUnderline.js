document.addEventListener("DOMContentLoaded", () => {
    const tabs = document.querySelectorAll(".tab:not(.disabled)");
    const tabsContainer = document.querySelector(".tabs");
    const underline = document.createElement("div");

    underline.classList.add("tab-underline");
    tabsContainer.appendChild(underline);

    function moveUnderline(activeTab) {
        const rect = activeTab.getBoundingClientRect();
        const containerRect = tabsContainer.getBoundingClientRect();

        underline.style.width = rect.width + "px";
        underline.style.left = (rect.left - containerRect.left) + "px";
    }

    const initialActive = document.querySelector(".tab.active");
    if (initialActive) moveUnderline(initialActive);

    tabs.forEach(tab => {
        tab.addEventListener("click", () => {
            tabs.forEach(t => t.classList.remove("active"));
            tab.classList.add("active");
            moveUnderline(tab);
        });
    });

    window.addEventListener("resize", () => {
        const activeTab = document.querySelector(".tab.active");
        if (activeTab) moveUnderline(activeTab);
    });
});
