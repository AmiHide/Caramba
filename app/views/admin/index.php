<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Administration - Caramba</title>
    <link rel="icon" type="png" href="/Caramba/public/img/Caramba-logo.png">
    <link rel="stylesheet" href="/Caramba/public/css/style.css">
    <link rel="stylesheet" href="/Caramba/public/css/responsive.css">
</head>
<body>

<?php include __DIR__ . '/../navbar.php'; ?>

<main class="admin-main">
    <h1 class="admin-title">Panneau d'administration</h1>

    <div class="admin-toolbar">
        <a href="index.php?page=admin_faq" class="admin-btn">Gérer la FAQ</a>
        <a href="index.php?page=admin_legal" class="admin-btn">Gérer CGU & Mentions légales</a>
    </div>

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


    <!-- demande pour être conducteur -->
    <section class="admin-section">
        <h2>Demandes de conducteur en attente</h2>

        <?php if (empty($demandesConducteurs)): ?>
            <p>Aucune demande en attente pour l’instant.</p>
        <?php else: ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Permis</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($demandesConducteurs as $u): ?>
                    <tr>
                    <td>
                        <a href="index.php?page=profil&id=<?= $u['id'] ?>" class="admin-link">
                            <?= $u['id'] ?>
                        </a>
                    </td>
                    <td>
                        <a href="index.php?page=profil&id=<?= $u['id'] ?>" class="admin-link">
                            <?= htmlspecialchars($u['nom']) ?>
                        </a>
                    </td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td>
                            <?php if (!empty($u['permis'])): ?>
                            <a href="<?= htmlspecialchars($u['permis']) ?>" 
                               class="admin-icon" target="_blank" title="Voir le permis">
                                <svg width="20" height="20" fill="none" stroke="#333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="9" cy="9" r="7"></circle>
                                    <line x1="14" y1="14" x2="19" y2="19"></line>
                                </svg>
                            </a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                        </td>
                        <td>
                            <a href="index.php?page=admin&action=validate_conducteur&id=<?= $u['id'] ?>" 
                               class="btn-admin-success">
                                Valider
                            </a>
                            <a href="index.php?page=admin&action=refuse_conducteur&id=<?= $u['id'] ?>" 
                               class="btn-admin-danger"
                               onclick="return confirm('Refuser cette demande ?');">
                                Refuser
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>


    <!-- users -->
    <section class="admin-section">
        <h2>Utilisateurs inscrits</h2>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $u): ?>
                <tr>
<td>
    <a href="index.php?page=profil&id=<?= $u['id'] ?>" class="admin-link">
        <?= $u['id'] ?>
    </a>
</td>
<td>
    <a href="index.php?page=profil&id=<?= $u['id'] ?>" class="admin-link">
        <?= htmlspecialchars($u['nom']) ?>
    </a>
</td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td>
                        <?php if ($u['role'] === 'admin'): ?>
                            <span class="badge badge-admin">Admin</span>
                        <?php elseif ($u['role'] === 'conducteur'): ?>
                            <span class="badge badge-conducteur">Conducteur</span>
                        <?php else: ?>
                            <span class="badge badge-passager">Passager</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($u['role'] !== 'admin'): ?>
                            <div class="admin-actions-col">
                                <?php if ($u['role'] === 'passager'): ?>
                                    <a href="index.php?page=admin&action=change_role_conducteur&id=<?= $u['id'] ?>"
                                       class="btn-admin-success">Promouvoir conducteur</a>
                                <?php elseif ($u['role'] === 'conducteur'): ?>
                                    <a href="index.php?page=admin&action=change_role_passager&id=<?= $u['id'] ?>"
                                       class="btn-admin-danger" style="background:#e67e22;">Rétrograder passager</a>
                                <?php endif; ?>
                                <a href="index.php?page=admin&action=delete_user&id=<?= $u['id'] ?>"
                                class="btn-admin-danger btn-delete-user">
                                Supprimer
                                </a>
                            </div>
                        <?php else: ?>
                            —
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <!-- réservation -->
    <section class="admin-section">
        <h2>Toutes les Réservations</h2>

        <?php if (empty($reservations)): ?>
            <p>Aucune réservation trouvée.</p>
        <?php else: ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th> <th>Passager</th>
                        <th>Trajet</th>
                        <th>Places</th>
                        <th>Statut</th>
                        <th>Date Trajet</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($reservations as $res): ?>
                    <tr>
                        <td><strong>#<?= $res['id'] ?></strong></td>
                        
                        <td>
                            <?= htmlspecialchars($res['passager_nom']) ?>
                            <br>
                            <small><?= htmlspecialchars($res['passager_email']) ?></small>
                        </td>
                        <td>
                            <?= htmlspecialchars($res['depart']) ?> &rarr; <?= htmlspecialchars($res['arrivee']) ?>
                        </td>
                        <td><?= $res['places_reservees'] ?></td>
                        <td>
                            <?php if($res['statut'] == 'acceptee'): ?>
                                <span class="badge badge-conducteur" style="background:green;">Acceptée</span>
                            <?php elseif($res['statut'] == 'en_attente'): ?>
                                <span class="badge badge-passager" style="background:orange;">En attente</span>
                            <?php elseif($res['statut'] == 'refusee'): ?>
                                <span class="badge badge-admin" style="background:red;">Refusée</span>
                            <?php else: ?>
                                <?= htmlspecialchars($res['statut']) ?>
                            <?php endif; ?>
                        </td>
                         <td><?= htmlspecialchars($res['date_depart']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>



    <!-- trajets -->
    <section class="admin-section">
        <h2>Trajets publiés</h2>

        <?php if (empty($trajets)): ?>
            <p>Aucun trajet publié pour le moment.</p>
        <?php else: ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Conducteur</th>
                        <th>Trajet</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($trajets as $t): ?>
                    <tr>
                        <td><?= $t['id'] ?></td>
                        <td><?= htmlspecialchars($t['conducteur_nom']) ?></td>
                        <td><?= htmlspecialchars($t['depart']) ?> → <?= htmlspecialchars($t['arrivee']) ?></td>
                        <td><?= htmlspecialchars($t['date_depart']) . ' — ' . htmlspecialchars(substr($t['heure_depart'],0,5)) ?></td>
                        <td>
                        <a href="index.php?page=admin&action=delete_trajet&id=<?= $t['id'] ?>"
                        class="btn-admin-danger btn-delete-trajet">
                        Supprimer
                        </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>
</main>

<div id="deleteUserModal" class="confirm-modal">
  <div class="confirm-content">
    <h3>Supprimer l'utilisateur</h3>
    <p>Souhaitez-vous vraiment supprimer cet utilisateur ?</p>

    <div class="confirm-actions">
      <button id="confirmDeleteUserYes" class="btn-confirm-yes">Oui, supprimer</button>
      <button id="confirmDeleteUserNo" class="btn-confirm-no">Annuler</button>
    </div>
  </div>
</div>

<div id="deleteTrajetModal" class="confirm-modal">
  <div class="confirm-content">
    <h3>Supprimer le trajet</h3>
    <p>Souhaitez-vous vraiment supprimer ce trajet publié ?</p>

    <div class="confirm-actions">
      <button id="confirmDeleteTrajetYes" class="btn-confirm-yes">Oui, supprimer</button>
      <button id="confirmDeleteTrajetNo" class="btn-confirm-no">Annuler</button>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
<script src="/Caramba/public/js/flashMessages.js"></script>
<script src="/Caramba/public/js/preventCache.js"></script>
<script src="/Caramba/public/js/deleteUserModal.js"></script>
<script src="/Caramba/public/js/deleteTrajetModal.js"></script>

</body>
</html>