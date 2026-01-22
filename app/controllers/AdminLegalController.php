<?php

class AdminLegalController
{
    public function index()
    {
        
        if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "admin") {
            header("Location: index.php?page=connexion");
            exit;
        }

        $cguSections = LegalPage::getBySection('cgu');
        $mentionSections = LegalPage::getBySection('mentions');

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_section') {
            $section = $_POST['section'] ?? null;
            $titre   = trim($_POST['titre'] ?? 'Nouvelle section');
            $contenu = trim($_POST['contenu'] ?? '');

            if ($section && in_array($section, ['cgu', 'mentions'])) {
                if (LegalPage::addSection($section, $titre, $contenu)) {
                    $_SESSION['flash_success'] = "Nouvelle section ajoutée avec succès.";
                } else {
                    $_SESSION['flash_error'] = "Erreur lors de l’ajout de la section.";
                }
            }

            header("Location: index.php?page=admin_legal");
            exit;
        }

        if (isset($_GET['action']) && $_GET['action'] === 'delete' && !empty($_GET['id'])) {
            $id = (int) $_GET['id'];
            if (LegalPage::deleteSection($id)) {
                $_SESSION['flash_success'] = "Section supprimée avec succès.";
            } else {
                $_SESSION['flash_error'] = "Erreur lors de la suppression.";
            }

            header("Location: index.php?page=admin_legal");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id      = (int) $_POST['id'];
            $titre   = trim($_POST['titre'] ?? '');
            $contenu = trim($_POST['contenu'] ?? '');

            if (LegalPage::updateSectionFull($id, $titre, $contenu)) {
                $_SESSION['flash_success'] = "Section mise à jour avec succès.";
            } else {
                $_SESSION['flash_error'] = "Erreur lors de la mise à jour.";
            }

            header("Location: index.php?page=admin_legal");
            exit;
        }

        require __DIR__ . '/../views/admin/legal.php';
    }
}

