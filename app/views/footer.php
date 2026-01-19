<hr class="footer-separator">

<footer class="footer">
    <div class="footer-container">

        <div class="footer-col brand">
            <h3>Caramba</h3>
            <a href="https://www.instagram.com/caramba_officiel/" class="social-icon">
                <img src="/Caramba/public/img/insta.png" alt="Instagram">
            </a>
        </div>

        <div class="footer-col">
            <h4>Top des trajets :</h4>
            <ul>
                <?php
                // On récupère le top 5 dynamiquement
                // On vérifie si la classe Trajet est chargée (sécurité)
                if (class_exists('Trajet')) {
                    $topTrajets = Trajet::getTopTrajets(5);
                } else {
                    $topTrajets = [];
                }
                ?>

                <?php if (!empty($topTrajets)): ?>
                    <?php foreach ($topTrajets as $top): ?>
                        <li>
                            <a href="index.php?page=recherche&depart=<?= urlencode($top['depart']) ?>&arrivee=<?= urlencode($top['arrivee']) ?>&date=<?= date('Y-m-d') ?>&passagers=1">
                                <?= htmlspecialchars($top['depart']) ?> → <?= htmlspecialchars($top['arrivee']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>
                        <a href="index.php?page=recherche&depart=Paris&arrivee=Toulouse&date=<?= date('Y-m-d') ?>">
                            Paris → Toulouse
                        </a>
                    </li>
                    <li>
                        <a href="index.php?page=recherche&depart=Paris&arrivee=Reims&date=<?= date('Y-m-d') ?>">
                            Paris → Reims
                        </a>
                    </li>
                    <li>
                        <a href="index.php?page=recherche&depart=Paris&arrivee=Bordeaux&date=<?= date('Y-m-d') ?>">
                            Paris → Bordeaux
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>

        <div class="footer-col">
            <h4>En savoir plus :</h4>
            <ul>
                <li><a href="index.php?page=about">Qui sommes-nous ?</a></li>
                <li><a href="index.php?page=contact">Centre d'aide</a></li>
                <li><a href="index.php?page=cgu_mentions">CGU & Mentions légales</a></li>
            </ul>
        </div>

    </div>
</footer>
