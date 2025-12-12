document.addEventListener("click", e => {
    const btn = e.target.closest(".edit-btn");
    if (!btn) return;

    const form = btn.closest("form");
    const input = form.querySelector(".editable-title");

    if (input.readOnly) {
        input.readOnly = false;
        input.focus();
        input.style.borderBottom = "1px solid #aaa";
    } else {
        input.readOnly = true;
        input.style.borderBottom = "none";
        form.submit();
    }
});
