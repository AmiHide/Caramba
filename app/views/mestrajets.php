<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes trajets - Caramba</title>
    <link rel="icon" type="png" href="/Caramba/public/img/Caramba-logo.png">
    <link rel="stylesheet" href="/Caramba/public/css/style.css">
    <link rel="stylesheet" href="/Caramba/public/css/responsive.css">
</head>

<body>

<?php include __DIR__ . "/navbar.php"; ?>

<main class="trajets-container">

    <h1>Mes trajets</h1>

    <?php if (!empty($_SESSION["flash_success"])): ?>
        <div class="flash-success flash-msg">
            <?= $_SESSION["flash_success"]; unset($_SESSION["flash_success"]); ?>
            <span class="close-flash">&times;</span>
        </div>
    <?php endif; ?>

    <?php if (!empty($_SESSION["flash_error"])): ?>
        <div class="flash-error flash-msg">
            <?= $_SESSION["flash_error"]; unset($_SESSION["flash_error"]); ?>
            <span class="close-flash">&times;</span>
        </div>
    <?php endif; ?>


    <!-- Onglets -->

    <div class="tabs">
        <button class="tab active" data-target="reservations">
            Mes réservations
        </button>

        <?php if ($user_role === "conducteur"): ?>
            <button class="tab" data-target="conducteur">
                Mes trajets (conducteur)
            </button>
        <?php else: ?>
            <button class="tab disabled" disabled>
                Mes trajets (conducteur)
            </button>
        <?php endif; ?>

        <button class="tab" data-target="avenir">Trajets à venir</button>
        <button class="tab" data-target="realises">Trajets réalisés</button>
    </div>




    <!-- onglet : MES RÉSERVATIONS -->
    <section id="reservations" class="tab-content active">

        <?php if (empty($reservations)): ?>

            <p>Aucune réservation trouvée.</p>

        <?php else: ?>
            <?php foreach ($reservations as $r): ?>
                
                <div class="trajet-card">

                    <div class="left">

                        <a href="index.php?page=voirprofil&id=<?= $r['conducteur_id'] ?>" class="driver-link vertical">
                            <img src="/Caramba/public/uploads/avatars/<?= htmlspecialchars($r['conducteur_avatar']) ?>" class="trajet-avatar">

                            <?php
                                $prenom_conducteur = explode(' ', trim($r['conducteur_nom']))[0];
                                $prenom_conducteur = ucfirst(strtolower($prenom_conducteur));
                            ?>
                            <strong class="driver-name"><?= htmlspecialchars($prenom_conducteur) ?></strong>
                        </a>

                        <small class="driver-date">
                            <?= htmlspecialchars($r['date_depart']) ?> — <?= htmlspecialchars($r['heure_depart']) ?>
                        </small>
                    </div>

                    <div class="center">
                        <h3>
                            <span class="trajet-id-badge">#<?= isset($r['trajet_id']) ? $r['trajet_id'] : $r['id'] ?></span>
                            <?= htmlspecialchars($r['depart']) ?> → <?= htmlspecialchars($r['arrivee']) ?>
                        </h3>
                        <p><?= htmlspecialchars($r['description']) ?></p>
                    </div>

                    <div class="right">
                        <strong><?= number_format($r['prix'], 2) ?> €</strong><br>
                        <small><?= $r['places_reservees'] ?> place(s)</small><br><br>

                        <?php if ($r['statut'] == "en_attente"): ?>
                            <span class="status pending">🟡 En attente</span>
                        <?php elseif ($r['statut'] == "acceptee"): ?>
                            <span class="status ok">🟢 Acceptée</span>
                        <?php else: ?>
                            <span class="status no">🔴 Refusée</span>
                        <?php endif; ?>

                        <?php
                            $departObj = new DateTime($r['date_depart'] . ' ' . $r['heure_depart']);
                            $nowObj = new DateTime();
                            $diff = $nowObj->diff($departObj);
                            
                            // Logique : annulable si le trajet est futur ET (plus de 24h avant OU encore en attente)
                            $isCancelable = false;
                            if ($departObj > $nowObj) {
                                if ($r['statut'] === 'en_attente') {
                                    $isCancelable = true;
                                } elseif ($diff->days >= 1) { 
                                    // S'il reste plus d'un jour (24h)
                                    $isCancelable = true;
                                }
                            }
                        ?>

                        <?php if ($isCancelable && $r['statut'] !== 'refusee'): ?>
                            <br><br>
                            <form action="index.php?page=annuler_reservation" method="POST" onsubmit="return confirm('Voulez-vous vraiment annuler cette réservation ?');">
                                <input type="hidden" name="id" value="<?= $r['id'] ?>">
                                <button type="submit" class="btn-refuse" style="cursor:pointer; font-size:0.8em; padding:5px 10px;">
                                    Annuler
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>

                </div>

            <?php endforeach; ?>
        <?php endif; ?>

    </section>



    <!-- onglet : MES TRAJETS CONDUCTEUR -->
    <section id="conducteur" class="tab-content">

        <?php if ($user_role !== 'conducteur'): ?>

            <p class="not-conducteur">Vous n'êtes pas conducteur vérifié.</p>

        <?php else: ?>

            <?php if (empty($trajets_conducteur)): ?>

                <p>Vous n'avez publié aucun trajet.</p>

            <?php else: ?>
                <?php foreach ($trajets_conducteur as $t): ?>

                    <div class="trajet-card-conducteur">

                        <div class="trajet-header">
                            <h3>
                                <span class="trajet-id-badge">#<?= $t['id'] ?></span>
                                <?= htmlspecialchars($t['depart']) ?> → <?= htmlspecialchars($t['arrivee']) ?>
                            </h3>

                            <a href="index.php?page=supprimer_trajet&id=<?= $t['id'] ?>"
                            class="delete-btn"
                            title="Supprimer ce trajet">
                            <svg width="20" height="20" fill="#333" viewBox="0 0 24 24">
                                <path d="M9 3V4H4V6H20V4H15V3H9ZM6 7V20C6 21.1046 6.89543 22 8 22H16C17.1046 22 18 21.1046 18 20V7H6Z" />
                            </svg>
                            </a>
                        </div>

                        <p class="trajet-info">
                            <strong>Date :</strong> <?= $t['date_depart'] ?> — <?= $t['heure_depart'] ?><br>
                            <strong>Places restantes :</strong> <?= $t['places_disponibles'] ?>
                        </p>

                        <!-- passagers en attente -->
                        <hr class="separator">
                        <h4 class="passenger-title">Passager(s) en attente :</h4>

                        <?php
                            $attente = $passagers_attente[$t['id']] ?? [];
                        ?>

                        <?php if (empty($attente)): ?>

                            <p class="no-passengers">Aucun passager en attente.</p>

                        <?php else: ?>

                            <?php foreach ($attente as $p): ?>

                                <div class="passenger-card">

                                    <div class="passenger-left">

                                    <a href="index.php?page=voirprofil&id=<?= $p['passager_id'] ?>" class="driver-link">
                                            <img src="/Caramba/public/uploads/avatars/<?= htmlspecialchars($p['avatar']) ?>" class="passenger-avatar">

                                            <div class="passenger-info">
                                                <?php
                                                    $prenom = explode(' ', trim($p['nom']))[0];
                                                    $prenom = ucfirst(strtolower($prenom));
                                                ?>
                                                <strong><?= htmlspecialchars($prenom) ?></strong>
                                            </div>
                                        </a>
                                        <p class="passenger-places"><?= $p['places_reservees'] ?> place(s)</p>
                                    </div>

                                    <div class="passenger-actions">

                                        <form action="index.php?page=reponse_reservation" method="POST" class="inline-form">
                                            <input type="hidden" name="reservation_id" value="<?= $p['id'] ?>">
                                            <input type="hidden" name="trajet_id" value="<?= $t['id'] ?>">
                                            <input type="hidden" name="action" value="accepter">

                                            <button class="btn-accept">Accepter</button>
                                        </form>

                                        <form action="index.php?page=reponse_reservation" method="POST" class="inline-form">
                                            <input type="hidden" name="reservation_id" value="<?= $p['id'] ?>">
                                            <input type="hidden" name="trajet_id" value="<?= $t['id'] ?>">
                                            <input type="hidden" name="action" value="refuser">

                                            <button class="btn-refuse">Refuser</button>
                                        </form>

                                        <?php
                                            $expire = new DateTime($p['expire_at']);
                                            $now    = new DateTime();
                                            $diff   = $now->diff($expire);
                                            $remaining = ($expire > $now)
                                                ? $diff->format("%H:%I:%S")
                                                : "Expirée";
                                        ?>

                                        <?php if ($expire > $now): ?>
                                            <span class="reservation-timer" data-expire="<?= htmlspecialchars($p['expire_at']) ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                                    width="20" height="20" style="vertical-align: middle; margin-right: 6px;">
                                                    <path fill="currentColor"
                                                        d="M256,48C141.12,48,48,141.12,48,256s93.12,208,208,208,208-93.12,208-208S370.88,48,256,48Zm0,384C159,432,80,353.05,80,256a174.55,174.55,0,0,1,53.87-126.72L279,233l-19,30L135,172c-13,23-26.7,46-26.7,84,0,81.44,66.26,147.7,147.7,147.7S403.7,337.44,403.7,256c0-76.67-58.72-139.88-133.55-147V164h-28.3V79.89c4.24.07,8.94.11,14.15.11C353.05,80,432,159,432,256S353.05,432,256,432Z"/>
                                                </svg>
                                                <span class="timer-text">Expire dans : <?= $remaining ?></span>
                                            </span>
                                            <?php else: ?>
                                                <span class="reservation-expired">❌ Expirée</span>
                                            <?php endif; ?>

                                    </div>

                                </div>

                            <?php endforeach; ?>

                        <?php endif; ?>

                    </div>

                <?php endforeach; ?>
            <?php endif; ?>

        <?php endif; ?>

    </section>

    <!-- onglet : TRAJETS À VENIR -->
<section id="avenir" class="tab-content">
    <h2>Mes réservations à venir</h2>

    <?php
    $now = new DateTime();
    $found = false;

    $trajets_futurs = $trajets_futurs ?? [];
    foreach ($trajets_futurs as $r):
        $dt = new DateTime($r['date_depart'] . ' ' . $r['heure_depart']);
        if ($r['statut'] !== 'acceptee' || $dt <= $now) continue;
        $found = true;
    ?>
        <div class="trajet-card-2">
            <div class="trajet-top">
                <div class="left">
                    <a href="index.php?page=voirprofil&id=<?= $r['conducteur_id'] ?>" class="driver-link vertical">
                        <img src="/Caramba/public/uploads/avatars/<?= htmlspecialchars($r['conducteur_avatar']) ?>" class="trajet-avatar">
                        
                        <?php
                            $parts = explode(' ', trim($r['conducteur_nom']));
                            $prenom = ucfirst(strtolower($parts[0]));
                        ?>
                        <strong><?= htmlspecialchars($prenom) ?></strong>
                    </a>

                    <small><?= htmlspecialchars($r['date_depart']) ?> — <?= htmlspecialchars($r['heure_depart']) ?></small>

                    <hr class="driver-phone-separator">

                    <?php
                    $phone = preg_replace('/\D/', '', $r['conducteur_telephone'] ?? '');
                    $formattedPhone = strlen($phone) === 10 ? implode(' ', str_split($phone, 2)) : ($r['conducteur_telephone'] ?? '');
                    ?>
                    <div class="driver-phone-block">
                        <button class="btn-show-driver-phone" onclick="showDriverPhone(this)">Voir le numéro</button>
                        <div class="driver-phone-number hidden">
                            <span class="driver-phone-text"><?= htmlspecialchars($formattedPhone) ?></span>
                        </div>
                    </div>
                </div>

                <div class="center">
                        <h3>
                            <span class="trajet-id-badge">#<?= isset($r['trajet_id']) ? $r['trajet_id'] : $r['id'] ?></span>
                            <?= htmlspecialchars($r['depart']) ?> → <?= htmlspecialchars($r['arrivee']) ?>
                        </h3>
                    </div>

                    <div class="right">
                        <strong><?= htmlspecialchars($r['prix']) ?> €</strong>
                </div>
            </div>

                <hr class="separator">
                <div class="passager-section-title">Passagers :</div>
                <div class="passager-list">
                    <?php
                    $passagers = Reservation::getAcceptedPassengers($r['trajet_id']);
                    foreach ($passagers as $p):
                        $fullName = trim($p['nom']);
                        $parts    = preg_split('/\s+/', $fullName);
                        $prenom   = ucfirst(strtolower(array_shift($parts)));
                    ?>
                        <div class="passager-box">
                            <img src="/Caramba/public/uploads/avatars/<?= htmlspecialchars($p['avatar']) ?>" class="passager-avatar">
                            <span class="passager-name"><?= htmlspecialchars($prenom) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <?php if (!$found): ?>
            <p>Aucun trajet futur réservé.</p>
         <?php endif; ?>


    <?php if ($user_role === "conducteur"): ?>
            <h2>Mes trajets (conducteur) à venir</h2>
            <?php
            $found2 = false;
            foreach ($trajets_conducteur as $t):
                $dt = new DateTime($t['date_depart'] . ' ' . $t['heure_depart']);
                if ($dt <= $now) continue;

                $passagers = Reservation::getAcceptedPassengers($t['id']);
                if (empty($passagers)) continue;
                $found2 = true;
            ?>
                <div class="trajet-card-conducteur">
                    <div class="trajet-header">
                        <h3>
                            <span class="trajet-id-badge">#<?= $t['id'] ?></span>
                            <?= htmlspecialchars($t['depart']) ?> → <?= htmlspecialchars($t['arrivee']) ?>
                        </h3>
                    </div>
                    <p class="trajet-info">
                        <strong>Date :</strong> <?= $t['date_depart'] ?> — <?= $t['heure_depart'] ?><br>
                        <strong>Places restantes :</strong> <?= $t['places_disponibles'] ?>
                    </p>

                    <hr class="separator">
                    <h4 class="passager-section-title">Passagers :</h4>
                    <div class="accepted-passengers">
                        <?php foreach ($passagers as $p): ?>
                            <div class="mini-passenger">
                                <a href="index.php?page=voirprofil&id=<?= $p['id'] ?>" class="driver-link vertical">
                                    <img src="/Caramba/public/uploads/avatars/<?= htmlspecialchars($p['avatar']) ?>" class="mini-passenger-avatar">
                                    <?php
                                        $parts = explode(' ', trim($p['nom']));
                                        $prenom = ucfirst(strtolower($parts[0]));
                                    ?>
                                    <strong><?= htmlspecialchars($prenom) ?></strong>
                                </a>
                                <hr class="phone-separator">
                                <?php
                                    $phone = preg_replace('/\D/', '', $p['telephone'] ?? '');
                                    $formattedPhone = strlen($phone) === 10 ? implode(' ', str_split($phone, 2)) : ($p['telephone'] ?? '');
                                ?>
                                <div class="phone-reveal">
                                    <button class="btn-show-phone" onclick="showPhone(this)">Voir le numéro</button>
                                    <div class="phone-number hidden">
                                        <span class="phone-text"><?= htmlspecialchars($formattedPhone) ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php if (!$found2): ?>
                <p>Aucun futur trajet publié.</p>
            <?php endif; ?>
        <?php endif; ?>
    </section>



        <!-- onglet : TRAJETS RÉALISÉS -->
        <section id="realises" class="tab-content">
        <?php
        $now = new DateTime();
        $foundPassager = false;
        ?>

        <h2>Mes réservations réalisées</h2>

        <?php foreach ($trajets_realises_passager as $r): ?>
            <?php
                $dt = new DateTime($r['date_depart'] . ' ' . $r['heure_depart']);
                if ($dt > $now) continue;

                $foundPassager = true;

                // Nom conducteur formaté
                $fullC   = trim($r['conducteur_nom']);
                $partsC  = preg_split('/\s+/', $fullC);
                $prenomC = ucfirst(strtolower(array_shift($partsC)));
                $nomC    = strtoupper(implode(' ', $partsC));
                $displayConducteur = trim($prenomC . ' ' . $nomC);
            ?>

            <div class="trajet-card trajet-passe">

                <div class="left">
                    <a href="index.php?page=voirprofil&id=<?= $r['conducteur_id'] ?>" class="driver-link vertical">
                        <img src="/Caramba/public/uploads/avatars/<?= htmlspecialchars($r['conducteur_avatar']) ?>" class="trajet-avatar">
                        <strong><?= htmlspecialchars($displayConducteur) ?></strong>
                    </a>
                    <small><?= htmlspecialchars($r['date_depart']) ?> — <?= htmlspecialchars($r['heure_depart']) ?></small>
                </div>

                <div class="center">
                    <h3>
                        <span class="trajet-id-badge">#<?= isset($r['trajet_id']) ? $r['trajet_id'] : $r['id'] ?></span>
                        <?= htmlspecialchars($r['depart']) ?> → <?= htmlspecialchars($r['arrivee']) ?>
                    </h3>
                </div>

                <div class="right avis-right">
                    <a href="index.php?page=laisser_avis&trajet_id=<?= $r['trajet_id'] ?>&mode=passager" class="link-avis">
                        Laisser un avis
                    </a>
                </div>

                <hr class="separator">

                <div class="passengers-section">
                    <strong>Passagers :</strong>
                    <div class="passenger-list">
                        <?php
                        $pax = Reservation::getAcceptedPassengers($r['trajet_id']);
                        foreach ($pax as $p):
                            $full   = trim($p['nom']);
                            $parts  = preg_split('/\s+/', $full);
                            $prenom = ucfirst(strtolower(array_shift($parts)));
                            $nom    = strtoupper(implode(' ', $parts));
                            $display = trim($prenom . ' ' . $nom);
                        ?>
                            <div class="mini-passenger">
                                <a href="index.php?page=voirprofil&id=<?= $p['id'] ?>" class="driver-link vertical">
                                    <img src="/Caramba/public/uploads/avatars/<?= htmlspecialchars($p['avatar']) ?>" class="mini-avatar">
                                    <span><?= htmlspecialchars($display) ?></span>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>
        <?php endforeach; ?>

        <?php if (!$foundPassager): ?>
            <p>Aucune réservation réalisée.</p>
        <?php endif; ?>


        <?php if ($user_role === 'conducteur'): ?>
            <h2>Mes trajets (conducteur) réalisés</h2>

            <?php
            $foundConducteur = false;
            foreach ($trajets_realises_conducteur as $t):
                $dt = new DateTime($t['date_depart'] . ' ' . $t['heure_depart']);
                if ($dt > $now) continue;

                $foundConducteur = true;
                $rp = Reservation::getAcceptedPassengers($t['id']);
                $placesReservees = count($rp);
            ?>
                <div class="trajet-card-conducteur trajet-passe">
                    <div class="trajet-header">
                        <h3>
                            <span class="trajet-id-badge">#<?= $t['id'] ?></span>
                            <?= htmlspecialchars($t['depart']) ?> → <?= htmlspecialchars($t['arrivee']) ?>
                        </h3>
                        <a href="index.php?page=laisser_avis&trajet_id=<?= $t['id'] ?>&mode=conducteur" class="link-avis">
                            Laisser un avis
                        </a>
                    </div>

                    <p class="trajet-info">
                        <strong>Date :</strong> <?= htmlspecialchars($t['date_depart']) ?> — <?= htmlspecialchars($t['heure_depart']) ?><br>
                        <strong>Places réservées :</strong> <?= $placesReservees ?>
                    </p>

                    <hr class="separator">

                    <?php if (!$rp): ?>
                        <p style="color:#777;font-style:italic;">Aucun passager n'a participé.</p>
                    <?php else: ?>
                        <h4 class="passenger-title">Passagers :</h4>
                        <div class="passenger-list">
                            <?php foreach ($rp as $p): ?>
                                <?php
                                    $full   = trim($p['nom']);
                                    $parts  = preg_split('/\s+/', $full);
                                    $prenom = ucfirst(strtolower(array_shift($parts)));
                                    $nom    = strtoupper(implode(' ', $parts));
                                    $display = trim($prenom . ' ' . $nom);
                                ?>
                                <div class="mini-passenger">
                                    <a href="index.php?page=voirprofil&id=<?= $p['id'] ?>" class="driver-link vertical">
                                        <img src="/Caramba/public/uploads/avatars/<?= htmlspecialchars($p['avatar']) ?>" class="mini-avatar">
                                        <span><?= htmlspecialchars($display) ?></span>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

            <?php if (!$foundConducteur): ?>
                <p>Aucun trajet réalisé en tant que conducteur.</p>
            <?php endif; ?>
        <?php endif; ?>
    </section>
    
</main>

<div id="trajetConfirmModal" class="confirm-modal">
  <div class="confirm-content">
    <h3>Supprimer le trajet</h3>
    <p>Souhaitez-vous vraiment supprimer ce trajet de votre liste&nbsp;?</p>
    <div class="confirm-actions">
      <button id="trajetConfirmYes" class="btn-confirm-yes">Oui, supprimer</button>
      <button id="trajetConfirmNo" class="btn-confirm-no">Annuler</button>
    </div>
  </div>
</div>

<script src="/Caramba/public/js/trajetDeleteConfirm.js"></script>
<script src="/Caramba/public/js/tabs.js"></script>
<script src="/Caramba/public/js/tabsUnderline.js"></script>
<script src="/Caramba/public/js/reservationTimers.js"></script>
<script src="/Caramba/public/js/showPhone.js"></script>
<script src="/Caramba/public/js/showDriverPhone.js"></script>
<script src="/Caramba/public/js/flashMessages.js"></script>
<script src="/Caramba/public/js/preventCache.js"></script>

<?php include __DIR__ . '/footer.php'; ?>

</body>
</html>

