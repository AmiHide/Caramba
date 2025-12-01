document.addEventListener("DOMContentLoaded", () => {
    const questions = document.querySelectorAll(".faq-question");

    questions.forEach(btn => {
        btn.addEventListener("click", () => {
            const answer = btn.nextElementSibling;
            const isOpen = btn.classList.contains("active");

            questions.forEach(b => {
                b.classList.remove("active");
                if (b.nextElementSibling) {
                    b.nextElementSibling.style.maxHeight = null;
                }
            });

            if (!isOpen) {
                btn.classList.add("active");
                answer.style.maxHeight = answer.scrollHeight + "px";
            }
        });
    });
});
