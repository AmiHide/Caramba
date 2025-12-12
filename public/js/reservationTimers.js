document.addEventListener("DOMContentLoaded", () => {
    function updateTimers() {
        const timers = document.querySelectorAll(".reservation-timer");

        timers.forEach(timer => {
            const expireAt = new Date(timer.dataset.expire).getTime();
            const now = Date.now();
            const diff = expireAt - now;

            if (diff <= 0) {
                timer.outerHTML = "<span class='reservation-expired'>❌ Expirée</span>";
                return;
            }

            let hours = Math.floor(diff / (1000 * 60 * 60));
            let minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((diff % (1000 * 60)) / 1000);

            hours = String(hours).padStart(2, "0");
            minutes = String(minutes).padStart(2, "0");
            seconds = String(seconds).padStart(2, "0");

            let textSpan = timer.querySelector(".timer-text");
            if (!textSpan) {
                textSpan = document.createElement("span");
                textSpan.classList.add("timer-text");
                timer.appendChild(textSpan);
            }

            textSpan.textContent = `Expire dans : ${hours}:${minutes}:${seconds}`;
        });
    }

    setInterval(updateTimers, 1000);
    updateTimers();
});
