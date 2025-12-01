-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 01 déc. 2025 à 11:25
-- Version du serveur : 10.4.22-MariaDB
-- Version de PHP : 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `caramba`
--

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

CREATE TABLE `avis` (
  `id` int(11) NOT NULL,
  `conducteur_id` int(11) NOT NULL,
  `passager_id` int(11) NOT NULL,
  `trajet_id` int(11) NOT NULL,
  `note` tinyint(4) NOT NULL,
  `commentaire` text DEFAULT NULL,
  `date_avis` datetime DEFAULT current_timestamp(),
  `auteur_role` enum('conducteur','passager') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`id`, `conducteur_id`, `passager_id`, `trajet_id`, `note`, `commentaire`, `date_avis`, `auteur_role`) VALUES
(25, 15, 16, 11, 5, 'Parfait du début à la fin.', '2025-11-23 18:05:18', 'passager'),
(27, 15, 20, 11, 5, 'Passager très sympa et ponctuel, la discussion était agréable.', '2025-11-23 18:06:33', 'conducteur'),
(28, 15, 16, 9, 5, 'Conducteur très pro, conduite douce et rassurante. Je recommande à 100% !', '2025-11-23 18:08:23', 'passager'),
(29, 15, 16, 9, 5, 'Rien à redire, parfait.', '2025-11-23 18:09:33', 'conducteur'),
(31, 15, 16, 11, 5, 'Très bonne communication avant et pendant le trajet.', '2025-11-23 19:09:06', 'conducteur'),
(33, 15, 20, 14, 5, 'Très bonne ambiance dans la voiture, conducteur ponctuel et arrangeant.', '2025-11-25 09:07:54', 'passager');

-- --------------------------------------------------------

--
-- Structure de la table `faq`
--

CREATE TABLE `faq` (
  `id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `reponse` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `faq`
--

INSERT INTO `faq` (`id`, `question`, `reponse`) VALUES
(6, 'Comment puis-je réserver un trajet ?', 'Pour réserver un trajet, il suffit d’entrer votre ville de départ et votre destination sur la page d’accueil, puis de cliquer sur “Rechercher\". Vous pourrez alors sélectionner le trajet de votre choix et finaliser la réservation.'),
(7, 'Dois-je créer un compte pour utiliser le site ?', 'Oui, la création d’un compte est nécessaire pour réserver ou proposer un trajet. Elle permet d’assurer la sécurité des utilisateurs et de suivre vos réservations.'),
(8, 'Comment devenir conducteur sur la plateforme ?', 'Lors de votre inscription, vous pouvez choisir le rôle “Conducteur”. Vous devrez fournir certaines informations, comme un permis de conduire valide.'),
(9, 'Combien de passagers puis-je accepter ?', 'Le conducteur choisit le nombre de places qu’il souhaite proposer au moment de publier un trajet. Une fois toutes les places réservées, le trajet n\'est plus disponible.'),
(10, 'Comment contacter un conducteur ou un passager ?', 'Pour des raisons de sécurité, la messagerie directe n’est pas encore disponible. Toutefois, les coordonnées sont partagées automatiquement après la confirmation d’une réservation entre les deux parties.');

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `pages_legales`
--

CREATE TABLE `pages_legales` (
  `id` int(11) NOT NULL,
  `section` enum('cgu','mentions') NOT NULL,
  `titre` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `date_modif` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `pages_legales`
--

INSERT INTO `pages_legales` (`id`, `section`, `titre`, `contenu`, `date_modif`, `updated_at`) VALUES
(1, 'cgu', '1. Objet du site', 'Caramba est une plateforme de covoiturage permettant la mise en relation entre conducteurs et passagers pour des trajets en France. \r\nLes présentes Conditions Générales d’Utilisation (CGU) définissent les modalités d’accès et d’utilisation du service. L’accès et l’utilisation du site impliquent l’acceptation pleine et entière des présentes CGU.', '2025-11-30 16:13:08', '2025-11-30 17:13:08'),
(2, 'cgu', '2. Conditions d’inscription', 'L’inscription sur la plateforme Caramba est réservée aux personnes âgées de 18 ans ou plus. Toute inscription d’un mineur est strictement interdite. En validant votre inscription, vous attestez de votre majorité et de la véracité des informations transmises. L’utilisateur s’engage à fournir des informations exactes et à jour.', '2025-11-28 13:45:41', NULL),
(3, 'cgu', '3. Création de compte', 'Lors de la création d’un compte, l’utilisateur s’engage à : \r\n• Fournir des informations exactes, complètes et à jour. \r\n• Ne pas créer plusieurs comptes. \r\n• Ne pas usurper l’identité d’un tiers. \r\n• Préserver la confidentialité de son mot de passe. \r\nTout manquement à ces obligations peut entraîner la suspension ou la suppression du compte.', '2025-11-28 13:48:01', NULL),
(4, 'cgu', '4. Validation conducteur', 'Pour devenir conducteur, l’utilisateur doit fournir un permis de conduire valide. Celui-ci sera vérifié par un administrateur avant validation du statut. Le permis est valable sept jours à compter de sa validation, puis doit être renouvelé. Le conducteur déclare être titulaire d’un permis conforme à la législation et d’un véhicule assuré. Caramba n’est pas responsable en cas de fausse déclaration ou de défaut d’assurance.', '2025-11-28 13:45:57', NULL),
(5, 'cgu', '5. Réservations et trajets', 'Les passagers peuvent réserver un trajet proposé par un conducteur. Le nombre de places disponibles est précisé sur chaque trajet. Toute réservation confirmée engage moralement les deux parties à respecter le trajet prévu. En cas d’annulation, les utilisateurs doivent prévenir au plus tôt. Caramba n’intervient pas dans les transactions financières entre les membres.', '2025-11-28 13:46:11', NULL),
(6, 'cgu', '6. Vérification des informations', 'Caramba se réserve le droit de demander une vérification d’identité (pièce d’identité, permis, ou numéro de téléphone) dans le but de garantir la confiance entre les utilisateurs. Toute information vérifiée n’exonère pas l’utilisateur de sa responsabilité. Les mentions « vérifié » n’impliquent pas la garantie de véracité absolue.', '2025-11-28 13:46:19', NULL),
(7, 'cgu', '7. Responsabilité de l’utilisateur', 'L’utilisateur est seul responsable de la véracité des informations transmises, de son comportement lors des trajets et de la conformité de son véhicule et de ses documents. Caramba ne saurait être tenu responsable des litiges, retards, pertes d’objets ou incidents survenant durant un trajet.', '2025-11-28 13:46:33', NULL),
(8, 'cgu', '8. Suspension ou suppression du compte', 'Caramba se réserve le droit de suspendre ou de supprimer tout compte utilisateur en cas de non-respect des CGU, de fraude, d’abus ou d’utilisation inappropriée du service.', '2025-11-28 13:14:27', NULL),
(9, 'cgu', '9. Données personnelles (RGPD)', 'Les données collectées sont strictement nécessaires à la gestion du service (profils, trajets, documents). Elles ne sont ni revendues ni partagées à des tiers à des fins commerciales. Conformément au Règlement Général sur la Protection des Données (RGPD), chaque utilisateur peut demander la suppression de ses données via son profil ou par mail.', '2025-11-28 13:46:42', NULL),
(10, 'cgu', '10. Propriété intellectuelle', 'Le contenu, les textes, le code et le logo Caramba sont la propriété exclusive du site. Toute reproduction totale ou partielle sans autorisation est strictement interdite.', '2025-11-28 13:46:47', NULL),
(11, 'cgu', '11. Droit applicable', 'Les présentes CGU sont régies par le droit français. Tout litige relatif à leur interprétation ou à leur exécution sera soumis au tribunal compétent de Paris.', '2025-11-28 13:46:55', NULL),
(12, 'cgu', '12. Modification des CGU', 'Caramba se réserve le droit de modifier les présentes Conditions Générales d’Utilisation à tout moment. Les utilisateurs seront informés en cas de changement significatif.', '2025-11-28 13:47:05', NULL),
(13, 'mentions', '1. Éditeur du site', 'Le site Caramba est édité par Specialinks dans le cadre d’un projet universitaire de développement web et situé à Paris, France.\r\nResponsable de publication : Équipe Caramba.', '2025-11-30 16:13:10', '2025-11-30 17:13:10'),
(14, 'mentions', '2. Hébergement', 'Le site est hébergé sur ...', '2025-11-28 13:18:01', NULL),
(15, 'mentions', '3. Données personnelles', 'Les informations collectées (nom, prénom, email, documents, préférences) sont utilisées exclusivement pour le bon fonctionnement du service de covoiturage. \r\nConformément au RGPD, tout utilisateur dispose d’un droit d’accès, de rectification et de suppression de ses données.', '2025-11-28 13:14:27', NULL),
(16, 'mentions', '4. Propriété intellectuelle', 'L’ensemble des éléments graphiques, logos, textes et visuels du site Caramba appartiennent à leurs auteurs et ne peuvent être reproduits sans autorisation préalable.', '2025-11-28 13:14:27', NULL),
(17, 'mentions', '5. Responsabilité', 'Le site Caramba agit comme un intermédiaire technique entre les utilisateurs.  Il ne garantit pas la réalisation effective des trajets ni la conformité des véhicules. En cas de désaccord ou incident, les utilisateurs sont invités à régler leur litige à l’amiable.', '2025-11-28 13:19:37', NULL),
(18, 'mentions', '6. Contact', 'Nous sommes là pour vous aider si vous en avez besoin. Pour obtenir une réponse à vos questions, nous vous encourageons à consultez le Centre d\'aide et nous contacter. Vous pouvez aussi contacter l\'assistance clientèle directement par e-mail à l\'adresse : caramba.assistance@gmail.com', '2025-11-28 14:10:42', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `trajet_id` int(11) NOT NULL,
  `passager_id` int(11) NOT NULL,
  `places_reservees` int(11) NOT NULL DEFAULT 1,
  `date_reservation` datetime DEFAULT current_timestamp(),
  `statut` enum('en_attente','acceptee','refusee') NOT NULL DEFAULT 'en_attente',
  `expire_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id`, `trajet_id`, `passager_id`, `places_reservees`, `date_reservation`, `statut`, `expire_at`) VALUES
(24, 9, 16, 1, '2025-11-21 21:31:31', 'acceptee', '2025-11-22 21:31:31'),
(25, 11, 16, 1, '2025-11-22 11:00:36', 'acceptee', '2025-11-23 11:00:36'),
(26, 11, 20, 1, '2025-11-22 20:47:42', 'acceptee', '2025-11-23 20:47:42'),
(30, 12, 16, 1, '2025-11-23 15:58:38', 'acceptee', '2025-11-24 15:58:38'),
(31, 12, 20, 1, '2025-11-23 18:18:51', 'acceptee', '2025-11-24 18:18:51'),
(35, 14, 16, 1, '2025-11-24 19:30:13', 'acceptee', '2025-11-25 19:30:13'),
(37, 14, 20, 1, '2025-11-24 20:05:48', 'acceptee', '2025-11-25 20:05:48'),
(44, 18, 20, 1, '2025-11-27 17:51:45', 'acceptee', '2025-11-28 17:51:45');

-- --------------------------------------------------------

--
-- Structure de la table `trajets`
--

CREATE TABLE `trajets` (
  `id` int(11) NOT NULL,
  `conducteur_id` int(11) NOT NULL,
  `depart` varchar(100) NOT NULL,
  `arrivee` varchar(100) NOT NULL,
  `date_depart` date NOT NULL,
  `heure_depart` time NOT NULL,
  `prix` decimal(5,2) NOT NULL,
  `places_disponibles` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `date_publication` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `trajets`
--

INSERT INTO `trajets` (`id`, `conducteur_id`, `depart`, `arrivee`, `date_depart`, `heure_depart`, `prix`, `places_disponibles`, `description`, `date_publication`) VALUES
(9, 15, 'Aix-en-Provence', 'Ajaccio', '2025-11-20', '15:00:00', '25.00', 1, 'peu de place dans le coffre (1 valise max)', '2025-11-20 13:59:49'),
(11, 15, 'Paris', 'Lyon', '2025-11-23', '13:00:00', '45.00', 0, '', '2025-11-22 10:59:57'),
(12, 15, 'Vitry-sur-Seine', 'Reims', '2025-11-24', '11:00:00', '40.00', 1, '', '2025-11-23 12:02:03'),
(14, 15, 'Alfortville', 'Besançon', '2025-11-25', '00:17:00', '20.00', 0, '', '2025-11-24 19:11:58'),
(18, 15, 'Paris', 'Brest', '2025-11-28', '12:00:00', '40.00', 1, '', '2025-11-27 17:50:43');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `date_inscription` datetime NOT NULL DEFAULT current_timestamp(),
  `avatar` varchar(255) NOT NULL DEFAULT 'user-icon.png',
  `sexe` varchar(10) DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `region` varchar(100) DEFAULT NULL,
  `musique` tinyint(1) NOT NULL DEFAULT 1,
  `fumeur` tinyint(1) NOT NULL DEFAULT 0,
  `animaux` tinyint(1) NOT NULL DEFAULT 0,
  `voiture_modele` varchar(100) DEFAULT NULL,
  `voiture_couleur` varchar(50) DEFAULT NULL,
  `preuve_identite` varchar(255) DEFAULT NULL,
  `permis` varchar(255) DEFAULT NULL,
  `permis_upload_at` datetime DEFAULT NULL,
  `pseudo` varchar(50) NOT NULL,
  `conducteur_demande` tinyint(1) DEFAULT 0,
  `conducteur_valide` tinyint(1) DEFAULT 0,
  `role` enum('passager','conducteur','admin') NOT NULL DEFAULT 'passager',
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_expire` datetime DEFAULT NULL,
  `description` text DEFAULT NULL,
  `numero_verifie` tinyint(1) NOT NULL DEFAULT 0,
  `code_tel` varchar(6) DEFAULT NULL,
  `code_expire` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `email`, `mot_de_passe`, `date_inscription`, `avatar`, `sexe`, `date_naissance`, `telephone`, `region`, `musique`, `fumeur`, `animaux`, `voiture_modele`, `voiture_couleur`, `preuve_identite`, `permis`, `permis_upload_at`, `pseudo`, `conducteur_demande`, `conducteur_valide`, `role`, `reset_token`, `reset_expire`, `description`, `numero_verifie`, `code_tel`, `code_expire`) VALUES
(6, 'Administrateur', 'admin@gmail.com', '$2y$10$JBYVeRdwGxIpxt2oJNc3z.IS6iOOPqz71w9x6JA0.KJmTsvz8ZxV6', '2025-11-19 22:50:46', 'user-icon.png', 'Homme', '1995-05-25', '0651457251', 'Ile-de-France', 1, 0, 0, NULL, NULL, 'uploads/id_691e3bb5f0959.png', NULL, NULL, 'Admin', 0, 1, 'admin', NULL, NULL, NULL, 0, NULL, NULL),
(15, 'jean petit', 'jean@gmail.com', '$2y$10$Q4DtRU1bfXfdHjEPsVdjuuTm6qcoD8auln8s.5Y9FIYXPgNL/Tx5G', '2025-11-20 13:56:53', 'avatar_15_692a14d1cb90b.jpg', NULL, '1995-05-05', '0651457254', 'Ile-de-France', 1, 0, 0, 'Peugeot 208', 'Noir', 'uploads/identite/id_691f1015d97fa.PNG', 'uploads/permis/permis_691f1015d9935.png', '2025-11-24 22:07:46', '', 0, 1, 'conducteur', NULL, NULL, 'Conducteur fiable et ponctuel, j’aime partager la route dans la bonne humeur. Habitué au covoiturage, trajet agréable garanti, j\'aime parler aussi.', 1, NULL, NULL),
(16, 'lucie dupont', 'lucie@gmail.com', '$2y$10$SdZCCfRbVlYMwFynJwksneBfdeJVQXl0L.oMp6.AowlWlPh5yfX1e', '2025-11-20 13:57:33', 'avatar_16_1763852399.jpg', 'Femme', '1997-12-14', '0678134157', 'Ile-de-France', 1, 0, 0, '', '', 'uploads/identite/id_691f103d01fc7.png', '', '2025-11-24 21:26:24', 'lucie5', 0, 0, 'passager', NULL, NULL, 'Passager calme et ponctuel, habitué au covoiturage. J’aime les trajets simples et respectueux, toujours partant pour partager la route en bonne humeur.', 0, NULL, NULL),
(20, 'thomas dupuis', 'thomas@gmail.com', '$2y$10$rd7T.nzwy6hnW35Q2oyJAOqeM1/NvB7SQRoF/Uiy1s3fNkS9AU03u', '2025-11-22 14:15:11', 'avatar_20_692a28e873040.jpg', 'Homme', '2000-04-30', '0651454241', 'Ile-de-France', 0, 0, 1, NULL, NULL, 'uploads/identite/id_6921b75f500a5.png', '', NULL, 'thomas87', 0, 0, 'passager', NULL, NULL, 'Passager calme, ponctuel et toujours de bonne humeur. J’aime les trajets détendus, discuter si le feeling passe ou laisser chacun tranquille. Respect et convivialité au rendez-vous.', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `villes`
--

CREATE TABLE `villes` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `villes`
--

INSERT INTO `villes` (`id`, `nom`) VALUES
(1, 'Paris'),
(2, 'Marseille'),
(3, 'Lyon'),
(4, 'Toulouse'),
(5, 'Nice'),
(6, 'Nantes'),
(7, 'Strasbourg'),
(8, 'Montpellier'),
(9, 'Bordeaux'),
(10, 'Lille'),
(11, 'Rennes'),
(12, 'Reims'),
(13, 'Le Havre'),
(14, 'Saint-Étienne'),
(15, 'Toulon'),
(16, 'Grenoble'),
(17, 'Dijon'),
(18, 'Angers'),
(19, 'Nîmes'),
(20, 'Villeurbanne'),
(21, 'Clermont-Ferrand'),
(22, 'Le Mans'),
(23, 'Aix-en-Provence'),
(24, 'Brest'),
(25, 'Tours'),
(26, 'Amiens'),
(27, 'Limoges'),
(28, 'Annecy'),
(29, 'Perpignan'),
(30, 'Metz'),
(31, 'Besançon'),
(32, 'Orléans'),
(33, 'Mulhouse'),
(34, 'Rouen'),
(35, 'Caen'),
(36, 'Boulogne-Billancourt'),
(37, 'Nancy'),
(38, 'Argenteuil'),
(39, 'Montreuil'),
(40, 'Roubaix'),
(41, 'Dunkerque'),
(42, 'Tourcoing'),
(43, 'Nanterre'),
(44, 'Poitiers'),
(45, 'Avignon'),
(46, 'Créteil'),
(47, 'Fort-de-France'),
(48, 'Pau'),
(49, 'Versailles'),
(50, 'Colombes'),
(51, 'Courbevoie'),
(52, 'Vitry-sur-Seine'),
(53, 'Asnières-sur-Seine'),
(54, 'Saint-Denis'),
(55, 'Aulnay-sous-Bois'),
(56, 'Rueil-Malmaison'),
(57, 'Aubervilliers'),
(58, 'Champigny-sur-Marne'),
(59, 'La Rochelle'),
(60, 'Antibes'),
(61, 'Saint-Maur-des-Fossés'),
(62, 'Calais'),
(63, 'Cannes'),
(64, 'Béziers'),
(65, 'Mérignac'),
(66, 'Saint-Nazaire'),
(67, 'Drancy'),
(68, 'Colmar'),
(69, 'Ajaccio'),
(70, 'Issy-les-Moulineaux'),
(71, 'Levallois-Perret'),
(72, 'Noisy-le-Grand'),
(73, 'Quimper'),
(74, 'Vénissieux'),
(75, 'Cergy'),
(76, 'Troyes'),
(77, 'Cholet'),
(78, 'La Seyne-sur-Mer'),
(79, 'Neuilly-sur-Seine'),
(80, 'Sartrouville'),
(81, 'Niort'),
(82, 'Villejuif'),
(83, 'Saint-Quentin'),
(84, 'Lorient'),
(85, 'Pessac'),
(86, 'Ivry-sur-Seine'),
(87, 'Chambéry'),
(88, 'Cayenne'),
(89, 'Épinay-sur-Seine'),
(90, 'Pantin'),
(91, 'Chelles'),
(92, 'Saint-Herblain'),
(93, 'Montauban'),
(94, 'Aubagne'),
(95, 'Albi'),
(96, 'Brive-la-Gaillarde'),
(97, 'Tarbes'),
(98, 'Castres'),
(99, 'Belfort'),
(100, 'Saint-Priest'),
(101, 'Narbonne'),
(102, 'Évreux'),
(103, 'Bourg-en-Bresse'),
(104, 'Valence'),
(105, 'Cherbourg-en-Cotentin'),
(106, 'Vannes'),
(107, 'Meaux'),
(108, 'Suresnes'),
(109, 'Martigues'),
(110, 'Saint-Malo'),
(111, 'Saint-Brieuc'),
(112, 'Rouen'),
(113, 'Melun'),
(114, 'Bourges'),
(115, 'Carcassonne'),
(116, 'Bayonne'),
(117, 'Arles'),
(118, 'Garges-lès-Gonesse'),
(119, 'Sevran'),
(120, 'Sète'),
(121, 'Villefranche-sur-Saône'),
(122, 'Choisy-le-Roi'),
(123, 'Massy'),
(124, 'Chalon-sur-Saône'),
(125, 'Clamart'),
(126, 'Gennevilliers'),
(127, 'Le Blanc-Mesnil'),
(128, 'Bobigny'),
(129, 'Saint-Ouen-sur-Seine'),
(130, 'Bondy'),
(131, 'Livry-Gargan'),
(132, 'Saint-Germain-en-Laye'),
(133, 'Taverny'),
(134, 'Fréjus'),
(135, 'Draguignan'),
(136, 'Orange'),
(137, 'Gap'),
(138, 'Beauvais'),
(139, 'Échirolles'),
(140, 'Blois'),
(141, 'Mont-de-Marsan'),
(142, 'Mâcon'),
(143, 'Forbach'),
(144, 'Pontoise'),
(145, 'Alès'),
(146, 'La Roche-sur-Yon'),
(147, 'Saint-Martin-d’Hères'),
(148, 'Salon-de-Provence'),
(149, 'Bron'),
(150, 'Le Cannet'),
(151, 'Menton'),
(152, 'Hyères'),
(153, 'Vitrolles'),
(154, 'Talence'),
(155, 'Douai'),
(156, 'Thionville'),
(157, 'Arras'),
(158, 'Lens'),
(159, 'Cambrai'),
(160, 'Soissons'),
(161, 'Charleville-Mézières'),
(162, 'Nevers'),
(163, 'Roanne'),
(164, 'Bastia'),
(165, 'Morlaix'),
(166, 'Laval'),
(167, 'Angoulême'),
(168, 'La Ciotat'),
(169, 'Vichy'),
(170, 'Montbéliard'),
(171, 'Dax'),
(172, 'Saintes'),
(173, 'Sarlat-la-Canéda'),
(174, 'Châteauroux'),
(175, 'Aurillac'),
(176, 'Tarascon'),
(177, 'Montluçon'),
(178, 'Dieppe'),
(179, 'Saint-Raphaël'),
(180, 'Brignoles'),
(181, 'Alençon'),
(182, 'Vernon'),
(183, 'Vienne'),
(184, 'Poissy'),
(185, 'Sens'),
(186, 'Cagnes-sur-Mer'),
(187, 'Saint-Chamond'),
(188, 'Montélimar'),
(189, 'Saint-Laurent-du-Var'),
(190, 'Biarritz'),
(191, 'Puteaux'),
(192, 'Alfortville'),
(193, 'Chambly'),
(194, 'Saint-Médard-en-Jalles'),
(195, 'Houilles'),
(196, 'Bezons'),
(197, 'Gagny'),
(198, 'Villeneuve-Saint-Georges'),
(199, 'Le Perreux-sur-Marne'),
(200, 'Bois-Colombes'),
(201, 'La Garenne-Colombes'),
(202, 'Saint-Fons'),
(203, 'Trappes'),
(204, 'Montigny-le-Bretonneux'),
(205, 'Guyancourt'),
(206, 'Les Mureaux'),
(207, 'Mantes-la-Jolie'),
(208, 'Sarcelles'),
(209, 'Maisons-Alfort'),
(210, 'Villeneuve-la-Garenne'),
(211, 'Bagnols-sur-Cèze'),
(212, 'Wattrelos'),
(213, 'Wasquehal'),
(214, 'Croix'),
(215, 'Saint-André-lez-Lille'),
(216, 'Marcq-en-Barœul'),
(217, 'Arradon'),
(218, 'Gradignan'),
(219, 'Lormont'),
(220, 'Bègles'),
(221, 'Saint-Sébastien-sur-Loire'),
(222, 'Rezé'),
(223, 'Saint-Orens-de-Gameville'),
(224, 'Castelnau-le-Lez'),
(225, 'Lattes'),
(226, 'Frontignan'),
(227, 'Agde'),
(228, 'Six-Fours-les-Plages'),
(229, 'La Garde'),
(230, 'Oullins'),
(231, 'Saint-Genis-Laval'),
(232, 'Givors'),
(233, 'Vaulx-Milieu'),
(234, 'Montgeron'),
(235, 'Savigny-sur-Orge'),
(236, 'Saint-Mandé'),
(237, 'Vincennes'),
(238, 'Fontenay-sous-Bois'),
(239, 'Nogent-sur-Marne'),
(240, 'Le Kremlin-Bicêtre'),
(241, 'Gentilly'),
(242, 'Bagneux'),
(243, 'Montrouge'),
(244, 'Châtillon'),
(245, 'Malakoff'),
(246, 'Vanves'),
(247, 'Meudon'),
(248, 'Châtenay-Malabry'),
(249, 'Sèvres'),
(250, 'Ville-d’Avray'),
(251, 'Garches'),
(252, 'Saint-Cloud'),
(253, 'Le Raincy'),
(254, 'Le Bourget'),
(255, 'Pierrefitte-sur-Seine'),
(256, 'Villetaneuse'),
(257, 'Stains'),
(258, 'Gonesse'),
(259, 'Goussainville'),
(260, 'Arnouville'),
(261, 'Deuil-la-Barre'),
(262, 'Montmorency'),
(263, 'Enghien-les-Bains'),
(264, 'Éragny-sur-Oise'),
(265, 'Saint-Gratien'),
(266, 'Eaubonne'),
(267, 'Beauchamp'),
(268, 'Sannois'),
(269, 'Franconville'),
(270, 'Cormeilles-en-Parisis'),
(271, 'Herblay-sur-Seine'),
(272, 'Le Pecq'),
(273, 'Plaisir'),
(274, 'Les Clayes-sous-Bois'),
(275, 'La Verrière'),
(276, 'Gif-sur-Yvette'),
(277, 'Orsay'),
(278, 'Bures-sur-Yvette'),
(279, 'Les Ulis'),
(280, 'Étampes'),
(281, 'Dourdan'),
(282, 'Saint-Michel-sur-Orge'),
(283, 'Brétigny-sur-Orge'),
(284, 'Grigny'),
(285, 'Ris-Orangis'),
(286, 'Évry-Courcouronnes'),
(287, 'Vierzon'),
(288, 'Montargis'),
(289, 'Romorantin-Lanthenay'),
(290, 'Le Puy-en-Velay'),
(291, 'Brioude'),
(292, 'Thiers'),
(293, 'L’Haÿ-les-Roses'),
(294, 'Thiais'),
(295, 'Orly'),
(296, 'Fresnes'),
(297, 'Sucy-en-Brie'),
(298, 'Villiers-sur-Marne'),
(299, 'Bry-sur-Marne'),
(300, 'Saint-Maurice'),
(301, 'Limeil-Brévannes'),
(302, 'Boissy-Saint-Léger'),
(303, 'Mandres-les-Roses'),
(304, 'Noiseau'),
(305, 'La Queue-en-Brie'),
(306, 'Chennevières-sur-Marne'),
(307, 'Valenton'),
(308, 'Le Plessis-Trévise'),
(309, 'Ablon-sur-Seine'),
(310, 'Santeny'),
(311, 'Rosny-sous-Bois'),
(312, 'Noisy-le-Sec'),
(313, 'Le Pré-Saint-Gervais'),
(314, 'Les Lilas'),
(315, 'Villemomble'),
(316, 'Gournay-sur-Marne'),
(317, 'Vaujours'),
(318, 'Neuilly-Plaisance'),
(319, 'Neuilly-sur-Marne'),
(320, 'Romainville'),
(321, 'Dugny'),
(322, 'Coubron'),
(323, 'Tremblay-en-France'),
(324, 'Antony'),
(325, 'Fontenay-aux-Roses'),
(326, 'Bourg-la-Reine'),
(327, 'Sceaux'),
(328, 'Le Plessis-Robinson'),
(329, 'Issy-les-Moulineaux'),
(330, 'Courbevoie'),
(331, 'Colombes'),
(332, 'Asnières-sur-Seine'),
(333, 'Clichy'),
(334, 'La Défense'),
(335, 'Palaiseau'),
(336, 'Massy'),
(337, 'Longjumeau'),
(338, 'Athis-Mons'),
(339, 'Paray-Vieille-Poste'),
(340, 'Viry-Châtillon'),
(341, 'Gravelines'),
(342, 'Juvisy-sur-Orge'),
(343, 'Savigny-sur-Orge'),
(344, 'Epinay-sur-Orge'),
(345, 'Arpajon'),
(346, 'Saint-Germain-lès-Arpajon'),
(347, 'Sainte-Geneviève-des-Bois'),
(348, 'Morangis'),
(349, 'Ris-Orangis'),
(350, 'Bondoufle'),
(351, 'Tigery'),
(352, 'Épinay-sur-Orge'),
(353, 'Villabé'),
(354, 'Fleury-Mérogis'),
(355, 'Yerres'),
(356, 'Brunoy'),
(357, 'Montgeron'),
(358, 'Vigneux-sur-Seine'),
(359, 'Draveil'),
(360, 'Soisy-sur-Seine'),
(361, 'Étiolles'),
(362, 'Corbeil-Essonnes'),
(363, 'Évry'),
(364, 'Lieusaint'),
(365, 'Savigny-le-Temple'),
(366, 'Moissy-Cramayel'),
(367, 'Combs-la-Ville'),
(368, 'Cesson'),
(369, 'Vert-Saint-Denis'),
(370, 'Melun'),
(371, 'Dammarie-les-Lys'),
(372, 'La Rochette'),
(373, 'Le Mée-sur-Seine'),
(374, 'Fontainebleau'),
(375, 'Avon'),
(376, 'Moret-sur-Loing'),
(377, 'Nemours'),
(378, 'Montereau-Fault-Yonne'),
(379, 'Coulommiers'),
(380, 'Provins'),
(381, 'Torcy'),
(382, 'Lognes'),
(383, 'Noisiel'),
(384, 'Champs-sur-Marne'),
(385, 'Bussy-Saint-Georges'),
(386, 'Bussy-Saint-Martin'),
(387, 'Pontault-Combault'),
(388, 'Roissy-en-Brie'),
(389, 'Gretz-Armainvilliers'),
(390, 'Ozoir-la-Ferrière');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `avis`
--
ALTER TABLE `avis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conducteur_id` (`conducteur_id`),
  ADD KEY `passager_id` (`passager_id`),
  ADD KEY `trajet_id` (`trajet_id`);

--
-- Index pour la table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `pages_legales`
--
ALTER TABLE `pages_legales`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `passager_id` (`passager_id`),
  ADD KEY `reservations_ibfk_1` (`trajet_id`);

--
-- Index pour la table `trajets`
--
ALTER TABLE `trajets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trajets_ibfk_1` (`conducteur_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_unique` (`email`);

--
-- Index pour la table `villes`
--
ALTER TABLE `villes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `avis`
--
ALTER TABLE `avis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT pour la table `faq`
--
ALTER TABLE `faq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `pages_legales`
--
ALTER TABLE `pages_legales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT pour la table `trajets`
--
ALTER TABLE `trajets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT pour la table `villes`
--
ALTER TABLE `villes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=391;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `avis`
--
ALTER TABLE `avis`
  ADD CONSTRAINT `avis_ibfk_1` FOREIGN KEY (`conducteur_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `avis_ibfk_2` FOREIGN KEY (`passager_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `avis_ibfk_3` FOREIGN KEY (`trajet_id`) REFERENCES `trajets` (`id`);

--
-- Contraintes pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`trajet_id`) REFERENCES `trajets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`passager_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `trajets`
--
ALTER TABLE `trajets`
  ADD CONSTRAINT `trajets_ibfk_1` FOREIGN KEY (`conducteur_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
