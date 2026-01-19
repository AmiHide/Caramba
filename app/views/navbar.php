<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<header class="navbar">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600&display=swap" rel="stylesheet">
    <a href="index.php?page=home" class="logo-link">
        <div class="logo-section">
            <img src="/Caramba/public/img/Caramba-logo.png" alt="Logo" class="logo">
            <h1 class="site-title">Caramba</h1>
        </div>
    </a>

    <button class="burger" id="burgerBtn" aria-label="Ouvrir le menu" aria-expanded="false" type="button">
        <span></span>
        <span></span>
        <span></span>
    </button> 

    <nav class="nav-links" id="navLinks">
        <a href="index.php?page=home">Accueil</a>
        <a href="index.php?page=recherche">Rechercher un covoiturage</a>
        <a href="index.php?page=faq">FAQ</a>
    </nav>

    <div class="user-section">

        <?php if (isset($_SESSION['user'])): ?>

            <!-- user connecté -->
            <div class="user-info">

                <a href="index.php?page=logout" class="log-btn logout-left">Déconnexion</a>
                <?php
                $userId = $_SESSION['user']['id'];
                $notifications_count = Notification::getUnreadCount($userId);
                $userNotifications = Notification::getAllUnread($userId);
                ?>
                <div class="notif-wrapper">

                <button class="notif-btn" onclick="toggleNotifMenu()">
                    <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                    width="512.000000pt" height="512.000000pt" viewBox="0 0 512.000000 512.000000"
                    preserveAspectRatio="xMidYMid meet">

                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                    fill="#000000" stroke="none">
                    <path d="M2480 5104 c-19 -8 -48 -27 -63 -42 -55 -52 -62 -75 -67 -236 l-5
                    -149 -92 -18 c-176 -36 -367 -117 -533 -227 -117 -78 -318 -280 -399 -401
                    -106 -160 -182 -338 -224 -526 -17 -80 -20 -143 -27 -570 -8 -530 -13 -585
                    -75 -771 -76 -230 -190 -409 -378 -597 -164 -162 -182 -197 -182 -342 0 -89 3
                    -106 27 -156 53 -107 158 -186 277 -209 77 -14 3567 -14 3647 1 114 21 219
                    101 272 208 24 50 27 67 27 156 0 144 -20 182 -173 333 -130 128 -188 201
                    -258 319 -88 147 -147 308 -179 483 -15 77 -19 184 -25 575 -6 428 -9 490 -27
                    570 -67 298 -194 527 -412 746 -216 215 -463 351 -744 408 l-92 18 -5 149 c-5
                    161 -12 184 -67 236 -58 56 -151 73 -223 42z"/>
                    <path d="M1780 625 c0 -33 62 -182 104 -249 172 -274 506 -422 818 -362 219
                    42 402 164 526 351 44 66 111 220 112 258 0 16 -44 17 -780 17 -680 0 -780 -2
                    -780 -15z"/>
                    </g>
                    </svg>

                <?php if ($notifications_count > 0): ?>
                    <span class="notif-badge"><?= $notifications_count ?></span>
                <?php endif; ?>
            </button>

    <div class="notif-dropdown" id="notifDropdown">

        <?php if ($notifications_count == 0): ?>

            <div class="notif-empty">Aucune notification</div>

        <?php else: ?>

            <?php foreach ($userNotifications as $n): ?>
                <div class="notif-row" data-id="<?= $n['id'] ?>">
                    <a href="index.php?page=mestrajets#conducteur" class="notif-link">
                        <?= htmlspecialchars($n['message']) ?>
                    </a>
                </div>
            <?php endforeach; ?>

            <button class="notif-clear-btn" onclick="clearAllNotifications()">
                Effacer les notifications
            </button>

        <?php endif; ?>

    </div>

</div>

                <div class="profile-dropdown">
                    <div class="profile-header">

                        <img src="/Caramba/public/uploads/avatars/<?= htmlspecialchars($_SESSION['user']['avatar']) ?>"
                             alt="Avatar" class="avatar">

                        <div class="user-text">
                            <span class="user-name">
                                <?= htmlspecialchars($_SESSION['user']['nom']) ?>
                            </span>

                            <span class="user-id">
                                User#<?= str_pad($_SESSION['user']['id'], 4, "0", STR_PAD_LEFT) ?>
                            </span>
                        </div>

                        <span class="arrow">▾</span>
                    </div>

                    <div class="dropdown-menu">

                        <a href="index.php?page=profil&id=<?= $_SESSION['user']['id'] ?>">Mon compte</a>
                        <a href="index.php?page=mestrajets">Mes trajets</a>

                        <?php if ($_SESSION["user"]["role"] === "conducteur"): ?>
                            <a href="index.php?page=publier_trajet">Publier un trajet</a>
                        <?php endif; ?>

                        <?php if ($_SESSION["user"]["role"] === "admin"): ?>
                            <a href="index.php?page=admin">Administration</a>
                        <?php endif; ?>

                    </div>
                </div>

            </div>

        <?php else: ?>

            <!-- user déconnecté -->
            <a href="index.php?page=connexion" class="log-btn">Connexion</a>
            <a href="index.php?page=register" class="log-btn">Inscription</a>

        <?php endif; ?>

    </div>
</header>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const burger = document.getElementById("burgerBtn");
  const navLinks = document.getElementById("navLinks");
  const notifMenu = document.getElementById("notifDropdown");
  const profileDropdown = document.querySelector(".profile-dropdown");

  if (!burger || !navLinks) return;

  const closeMenu = () => {
    navLinks.classList.remove("open");
    burger.classList.remove("active");
    burger.setAttribute("aria-expanded", "false");
    burger.setAttribute("aria-label", "Ouvrir le menu");
  };

  const openMenu = () => {
    // ferme les autres menus si besoin
    if (notifMenu) notifMenu.classList.remove("show");
    if (profileDropdown) profileDropdown.classList.remove("active");

    navLinks.classList.add("open");
    burger.classList.add("active");
    burger.setAttribute("aria-expanded", "true");
    burger.setAttribute("aria-label", "Fermer le menu");
  };

  burger.addEventListener("click", (e) => {
    e.stopPropagation();
    const isOpen = navLinks.classList.contains("open");
    isOpen ? closeMenu() : openMenu();
  });

  navLinks.querySelectorAll("a").forEach(a => {
    a.addEventListener("click", closeMenu);
  });

  document.addEventListener("click", (e) => {
    if (!navLinks.classList.contains("open")) return;
    if (navLinks.contains(e.target) || burger.contains(e.target)) return;
    closeMenu();
  });

  window.addEventListener("resize", () => {
    if (window.innerWidth > 1050) closeMenu();  // ✅ 1050 et pas 1180
  });
});
</script>



<script>
function toggleNotifMenu() {
    const menu = document.getElementById("notifDropdown");
    const isVisible = menu.classList.contains("show");

    // ✅ Ferme le menu burger si ouvert
    document.getElementById("navLinks")?.classList.remove("open");
    document.getElementById("burgerBtn")?.classList.remove("active");

    menu.classList.toggle("show");

    if (!isVisible) {
        const badge = document.querySelector(".notif-badge");
        if (badge) badge.remove();
    }
}
</script>


<script>
document.addEventListener("DOMContentLoaded", () => {
    const dropdown = document.querySelector(".profile-dropdown");
    if (!dropdown) return;

    dropdown.addEventListener("click", () => {
        dropdown.classList.toggle("active");
    });

    document.addEventListener("click", e => {
        if (!dropdown.contains(e.target)) {
            dropdown.classList.remove("active");
        }
    });
});
</script>
