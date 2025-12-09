# Caramba
### PROJET : PLATEFORME DE COVOITURAGE « CARAMBA » 

### DOCUMENT DE SPÉCIFICATIONS FONCTIONNELLES

Membres (G2A) :
> ALVES Alexandre  
> BAUVOIS Baptiste  
> BOUALI Douae  
> BOUSLAH Sid-Ahmed   
> RODRIGUEZ Alheli  
> JIANG Léon 



 
Table des matières :	
1.	Rappel du contexte et des besoins

	1.1	Contexte
  		
	1.2	Besoins identifiés	
2.	Périmètre du projet

	2.1	Fonctionnalités à réaliser


	2.2	Hors périmètre	
3.	Spécifications générales et détaillées	


	3.1	Modélisation des fonctionnalités (UML)
  	
	3.2	Charte graphique  
  		3.2.1	Logo  
		3.2.2	Palette de couleurs 
  	
	3.3	Maquettes du site (interfaces graphiques)  
		3.3.1	Page d’accueil  
		3.3.2	Page d’inscription  
		3.3.3	Page de connexion  
		3.3.4	Page « Mon compte »  
		3.3.5	Page de « Recherche / Résultats » et « Réserver un voyage »  
		3.3.6	Page « Publier un trajet »  
		3.3.7	Page de contact  
		3.3.8	Page FAQ  
		3.3.9	Page expliquant la sécurité des utilisateurs  
		3.3.10	Page Backoffice (admin)  


	3.4	Schéma de navigation	

 
Table des figures :  
Figure 1: Modélisation UML  
Figure 2: Logo Caramba  
Figure 3: Charte graphique  
Figure 4: Page d'accueil site web Caramba  
Figure 5: Page d'inscription Caramba  
Figure 6: Page de connexion Caramba  
Figure 7: Page Mon compte (section)  
Figure 8: Page Mon compte (section Mes trajets)  
Figure 9: Page Mon compte (section Paiements et factures)  
Figure 10: Page Mon compte (section Paramètres du compte)  
Figure 11: Page Mon compte (section Avis)  
Figure 12: Page recherche  
Figure 13: Filtre de la page recherche  
Figure 14: Réservation d'un trajet  
Figure 15: Page contact  
Figure 16: Page FAQ  
Figure 17: Page à propos de la sécurité de nos utilisateurs  
Figure 18: Zoom sur la section "Votre sécurité avant tout"  
Figure 19: Schémas de navigation  

Table des Tableaux :  
Tableau 1: Périmètre du projet  

  
1.	Rappel du contexte et des besoins  
	1.1	Contexte
	
Le covoiturage est devenu un moyen de transport à la fois économique et plus respectueux de l’environnement, et on voit bien qu’il prend de plus en plus d’importance aujourd’hui. Beaucoup de gens continuent pourtant à se déplacer seuls en voiture, ce qui augmente les coûts et la pollution.

Avec ce projet, on veut proposer une solution numérique simple pour mettre en contact les conducteurs et les passagers qui souhaitent partager un trajet, que ce soit pour les trajets du quotidien comme le domicile-travail ou pour des déplacements plus ponctuels.

Le site aura pour but de rendre ces échanges plus faciles tout en gardant 3 priorités : la sécurité, la confiance et la simplicité d’utilisation.  

	1.2	Besoins identifiés  


Le projet répond à plusieurs besoins concrets :  
•	Faciliter la recherche et la mise en relation entre conducteurs et passagers.  
•	Réduire les coûts de transport en partageant les frais.  
•	Encourager la mobilité durable, en limitant le nombre de véhicules individuels.  
•	Offrir une expérience simple et fluide grâce à une interface claire.  
•	Assurer la fiabilité des utilisateurs, via l’inscription obligatoire et un système de gestion des comptes.  

Ce site s’adresse avant tout aux conducteurs qui ont une voiture et qui souhaitent proposer leurs trajets pour partager les frais mais aussi aux passagers qui n’ont pas de moyen de transport ou qui préfèrent une option plus écologique et économique.  

Plus largement, il concerne toutes les personnes attentives aux questions environnementales ou qui cherchent simplement à mieux organiser leurs déplacements du quotidien.  

L’idée ici est de rendre les échanges entre utilisateurs plus simples et aussi plus fluides, grâce à une plateforme qui est claire, fiable et facile à utiliser, tout en encourageant une mobilité partagée et plus responsable.  

3.	Périmètre du projet

Le tableau ci-dessous montre le périmètre fonctionnel du projet Caramba. Il fait la différence entre les fonctionnalités prévues et celles mises de côté (hors du cadre du projet).  

Tableau 1: Périmètre du projet  

|Fonctionnalités à réaliser	|	Hors périmètre  |
|	:---:	|	:---:	|
|Inscription 	| 	Connexion	Paiement en ligne  |	
|Gestions des profils (Mon compte)	|	Messagerie interne  |
|Mot de passe oublié	|	Carte interactive / géolocalisation  |
|Publier / supprimer un trajet	|	Application mobile  |
|Gérer les demandes de réservation (accepter / refuser)  |
|Recherche de trajets  |	|
|Réserver un trajet  |		|
|Avis / Notation entre utilisateurs  |		|
|FAQ  |		|
|Page Contact (centre d’aide)  |	|
|Page CGU / Mentions légales  |		|
|Page À propos  |	|
|Backoffice administrateur (gestion utilisateur, FAQ, CGU, Mentions légales)  |		|

 
	2.1	Fonctionnalités à réaliser  

Le site Caramba s’appuie sur plusieurs fonctionnalités essentielles liées au covoiturage.  
Un conducteur peut publier un trajet en précisant le lieu de départ, la destination, la date, l’heure et le nombre de places disponibles.  
Les passagers peuvent ensuite chercher un trajet qui correspond à leurs critères et envoyer une demande de réservation au conducteur. Il aura 24h pour accepter ou refuser, après ce délai la demande expire automatiquement.  
Le système empêche aussi qu’un passager réserve deux trajets sur le même créneau, pour éviter les doublons. Une fois le trajet terminé, un système d’avis et de notes permettra d’évaluer les utilisateurs et de renforcer la confiance entre membres.  
Des pages complémentaires viennent compléter le tout : FAQ, Contact, CGU, Mentions légales, À propos, ainsi qu’un espace administrateur (backoffice) pour gérer les comptes et le contenu.  
Ces fonctionnalités représentent le cœur du projet. Elles couvrent les besoins essentiels du covoiturage, tout en restant simples à comprendre et à mettre en place. 

	2.2	Hors périmètre 
	
Certaines fonctionnalités jugées intéressantes mais non réalisables dans cette version ont été mises de côté :  
•	Paiement en ligne : les transactions se feront directement entre conducteurs et passagers, sans passer par la plateforme.  
•	Messagerie interne : une fois la réservation validée, les utilisateurs auront accès aux coordonnées (numéro ou e-mail) pour échanger directement, donc pas besoin de messagerie intégrée pour cette version.  
•	Carte interactive / géolocalisation : afficher les trajets sur une carte demanderait une API externe et un développement trop lourd pour le projet actuel.  
•	Application mobile : le projet reste pour l’instant centré sur une version web responsive, accessible depuis n’importe quel navigateur.  

3.	Spécifications générales et détaillées

Cette partie présente la modélisation des principales fonctionnalités du site ainsi que les éléments visuels qui aident à comprendre le fonctionnement global de l’application. On y trouve le diagramme UML, la charte graphique, le schéma de navigation et les maquettes graphiques, qui montrent le parcours de l’utilisateur et la manière dont les pages s’enchaînent les unes avec les autres.  

	3.1	Modélisation des fonctionnalités (UML)
	
Le diagramme ci-dessous montre les principaux cas d’utilisation de notre site de covoiturage.  
Il met en avant les rôles des utilisateurs et les actions possibles pour chacun, pour mieux visualiser les différentes fonctionnalités du site.  
 
Figure 1: Modélisation UML  

	3.2	Charte graphique  

La charte graphique de notre site Caramba a été conçue pour refléter les valeurs principales de notre projet : simplicité, convivialité et écoresponsabilité.  
L’objectif ici est d’offrir une interface qui est à la fois claire, moderne et accueillante, afin de rendre la navigation agréable pour tous les utilisateurs.  

	3.2.1	Logo  
 
Figure 2: Logo Caramba   

Le logo montre une route ouverte vers un horizon, un symbole qui évoque à la fois le voyage et le partage. Et le cercle autour vient renforcer cette idée de communauté et d’un espace accueillant pour tous. 

	3.2.2	Palette de couleurs  
 
Figure 3: Charte graphique  

Les couleurs qu’on a choisies pour notre site sont douces et naturelles, elles rappellent la détente, la confiance pour les tons roses et la dimension écologique du projet pour le vert.  
 
	3.3	Maquettes du site (interfaces graphiques)  

Les maquettes ci-dessous ont été faites sur Figma. Elles montrent les pages principales du site et donnent une première idée de son apparence. Le but, c’était surtout de visualiser la structure et l’ergonomie prévue pour l’utilisateur avant de passer au développement.  
Elles nous ont aussi servi à garder une cohérence dans la charte graphique et à vérifier que tout restait harmonieux entre les pages.  
		
3.3.1	Page d’accueil  
 
Figure 4: Page d'accueil site web Caramba  

L’utilisateur peut effectuer une recherche de trajet dès son arrivée sur le site et accéder rapidement aux pages « Démarrer un covoiturage », « FAQ », « Connexion » et cliquer directement sur son profil une fois connecté via la barre de navigation.  



3.3.2	Page d’inscription  
 
Figure 5: Page d'inscription Caramba  

L’utilisateur peut créer un compte en entrant ses informations personnelles, puis choisir son rôle, conducteur ou passager. Pour les conducteurs, un permis de conduire est bien sûr requis.  

		3.3.3	Page de connexion  
 
Figure 6: Page de connexion Caramba  

L’utilisateur peut se connecter à son compte en entrant son adresse e-mail ou son nom d’utilisateur, ainsi que son mot de passe.  
 
		3.3.4	Page « Mon compte »  
		
La page « Mon compte » permet de référencer toutes les informations les plus pertinentes pour l’utilisateurs. Vous pouvez trouver ci-dessous les différentes sections relatives à cette page.  
		3.3.4.1	A propos :  
 
Figure 7: Page Mon compte (section)  

Dans la partie « A propos » l’utilisateur pourra mettre toutes ces informations comme une description, si oui ou non la personne dispose d’un permis et de son type, le type de voiture, ainsi que les préférences de voyage (musique, sujet de discussion, ect). Toutes ces informations seront visibles publiquement (uniquement pour les utilisateurs de Caramba).  
 
		3.3.4.2	Mes trajets  
 
Figure 8: Page Mon compte (section Mes trajets)  

Dans la section « Mes trajets » nous pourrons retrouver tous les cours/trajets effectués ou prochainement réalisés (la couleur verte représentant les voyages terminés et en rose les prochain départ). Cette partie permettra de faire un mini bilan de tous les trajets que la personne a pu faire (cette section sera privée).  
		3.3.4.3	Paiement et facture :  
 
Figure 9: Page Mon compte (section Paiements et factures)  

Ici, le consommateur pourra retrouver le montant de tous ces trajets réalisés (Ces informations resteront privées).  

		3.3.4.4	Paramètres du compte  
 
Figure 10: Page Mon compte (section Paramètres du compte)  

Les personnes utilisant le site (Caramba) pourra changer à tout moment leurs identifiants (adresse mail ainsi que numéro de téléphone) et changer son mot de passe (Ces informations resteront privées).  
 
		3.3.4.5	Avis :  
 
Figure 11: Page Mon compte (section Avis)  

L’utilisateur pourra émettre des avis sur les différents voyages qu’il a pu réaliser. Ces avis seront répertoriés dans la section « Avis » de la page « Mon Compte » (Ces informations resteront privées).  

		3.3.5	Page de « Recherche / Résultats » et « Réserver un voyage »  
 
Figure 12: Page recherche  

Cette page permettra aux consommateurs de réaliser une rechercher sur 4 points (Lieu de départ et d’arriver, la date ainsi que le nombre de passagers). En plus cette rechercher les utilisateurs pourront filtrer les résultats grâce ce cette section.  
 
Figure 13: Filtre de la page recherche  

Via ce tableau ils auront la possible d’affiner les résultats via ces différents filtre (heure de départ, heure d’arriver, le plus court, le moins cher etc.) afin d’avoir le covoiturage le plus optimale pour le consommateur.  
Après avoir filtré les résultats nous nous retrouvons avec une liste comme ci-dessous où il sera répertorié les différents trajets, les conducteurs avec la note (représenté par des étoiles) ainsi que le nombre de place disponible. Afin de réserver un voyage le consommateur n’aura qu’à cliquer sur le bouton prévu à cet effet.  
 
Figure 14: Réservation d'un trajet  

		3.3.6	Page « Publier un trajet »  
		
Ici l’utilisateur pourra Publier un trajet et de fixer lui-même le prix du voyage ainsi que le nombre de place disponible.  

		3.3.7	Page de contact  
 
Figure 15: Page contact  

L’utilisateur peut contacter l’équipe Caramba en remplissant un petit formulaire avec son nom, son e-mail et son message, pour demander de l’aide ou obtenir plus d’informations.  

		3.3.8	Page FAQ  
 
Figure 16: Page FAQ  

Cette page rassemble les questions les plus fréquentes des utilisateurs sur le site, la réservation de trajets ou l’inscription, pour apporter des réponses simples et rapides.  

		3.3.9	Page expliquant la sécurité des utilisateurs  

Figure 17: Page à propos de la sécurité de nos utilisateurs  

Tout utilisateur ou visiteur de la plateforme peut accéder à cette page depuis la page d’accueil en appuyant sur “en savoir plus” dans la partie “Votre sécurité avant tout” :  
 
Figure 18: Zoom sur la section "Votre sécurité avant tout"  

Nous avons décidé de faire cette page afin de rassurer toutes personnes souhaitant ou étant inscrite. Les visiteurs peuvent donc accéder à cette page sans créer un compte et comprendre notre fonctionnement de vérification et de sécurité afin d’apporter sérénité et harmonie.  Comme vous pouvez le lire sur la figure 17 ci-dessus, nous vérifions minutieusement chaque utilisateur.  Voici le contenu de cette maquette :  
La sécurité passe avant tout par la confiance. Chaque utilisateur, conducteur ou passager, doit vérifier son identité avant de pouvoir proposer ou réserver un trajet. La validation de l’adresse e-mail, du numéro de téléphone, l’ajout d’une photo de profil réelle ainsi que d’une adresse afin d’envoyer un code de vérification à cette dernière permettent d’assurer que chaque membre est bien une personne authentique. Ces vérifications simples garantissent une communauté fiable, où chacun peut voyager sereinement avec des personnes identifiées et de confiance.  

Après chaque trajet, conducteurs et passagers peuvent s’évaluer mutuellement (1 à 5 étoiles) et laisser un commentaire sur la ponctualité, la courtoisie, la propreté et le respect des règles. Les évaluations ne peuvent être faites qu’une heure après la fin du trajet, afin que les utilisateurs ne soient plus ensemble et puissent donner un avis sincère et impartial. Seuls les participants au trajet peuvent laisser un avis. Les profils affichent la note moyenne, le nombre de trajets évalués et, le cas échéant, un badge de confiance pour les utilisateurs fiables.  

Ce système encourage un comportement responsable et permet de détecter les comportements problématiques, renforçant ainsi la sécurité pour tous. Le taux d’annulation indique la fréquence à laquelle un conducteur ou un passager annule ses trajets. Un suivi précis permet de repérer les utilisateurs peu fiables et de protéger les autres participants.  Chaque annulation est enregistrée dans le profil, et des limites ou pénalités peuvent être appliquées en cas d’abus. Les profils affichent le taux d’annulation, ce qui aide les voyageurs à choisir des partenaires fiables et encourage un comportement responsable, garantissant des trajets plus sûrs et prévisibles pour tous.  

Cette maquette n’est pas encore finalisée, les espaces blancs et le vide à certains endroits montrent un manque de professionnalisme. Ce n’est pas agréable à lire. Notre but est que notre site soit ergonomiquement séduisant.  
Nous voulions récupérer quelques documents personnels comme un document d’identité ainsi que le permis de conduire (si l’utilisateur souhaite être conducteur) via France Connect avec les API. Cependant nous avons appris que ces API étaient privées et que l’on devait avoir une habilitation. Nous avons donc choisi de faire tout nous-même : l’utilisateur rentras sa pièce d’identité ou passeport ainsi que son permis de conduire (facultatif) en prenant en photos ses documents. Il ne pourra pas les télécharger via son appareil électronique pour vérifier qu’il les a bien sur lui et éviter au maximum les documents trafiqués.  
De plus via France connect nous aurions pu savoir si l’utilisateur est toujours autorisé à conduire. Nous aurions pu savoir si son permis avait été suspendu ou enlever en cas de problèmes sur la route. Nous avons donc décidé de mettre en place un dispositif ou toutes les semaines le conducteur doit rentrer manuellement son permis de conduire (photo recto et verso). De nouveau, les photos ne pourront pas être déposé depuis sa galerie, il devra reprendre en photo son document et accepter les risques qu’il encoure en cas de fraude.

		3.3.10	Page Condition Général d’Utilisation  

Cette page a pour objectif de définir les conditions dans lesquelles les utilisateurs peuvent accéder et utiliser la plateforme Caramba. Elle apparaitra en bas de chaque page sous forme de lien sous le nom de “CGU” :  
 Le site peut modifier les présentes CGU à tout moment. Les utilisateurs seront informés des changements et devront accepter la nouvelle version pour continuer à utiliser le service.  
Sur cette page nous avons informé l’utilisateur :  
-	Des conditions d’inscriptions : L’utilisation de cette plateforme est réservée aux personnes étant âgées de 18 ans ou plus. Toute inscription par une personne mineure est strictement interdite. En vous inscrivant sur cette plateforme, vous déclarer donc et garantissez avoir 18 ans ou plus.  

-	Des informations nécessaires pour créer un compte : Lors de la création de votre compte, vous vous engagez à fournir des informations et documents personnels exactes et conformes à la réalité et à les mettre à jour via votre profil. Vous ne devez en aucun cas partager votre identifiant AVEC votre mot de passe à une tiers personne. Vous vous engagez à ne pas créer ou utiliser, sous votre propre identité ou celle d’un tiers, d’autres Comptes que celui initialement créé. Lors de la création du compte, vous avez le choix de choisir ou pas l’option de conducteur. Ainsi le permis de conduire n’est pas obligatoire pour les passagers. Cependant toutes personnes voulant covoiturer et conduire doit fournir son permis de conduire valide. Si l’utilisateur ne fournit pas son permis de conduire, il ne pourra donc pas proposer de covoiturer en tant que conducteur.  

-	Des vérifications de compte :  Caramba peut, à des fins de transparence, d’amélioration de la confiance, ou de prévention ou détection des fraudes, mettre en place un système de vérification de certaines des informations que vous fournissez sur votre profil. C’est notamment le cas lorsque vous renseignez votre numéro de téléphone ou nous fournissez une pièce d’identité. Vous reconnaissez et acceptez que toute référence sur la Plateforme ou les Services à des informations dites « vérifiées » ou tout terme similaire, signifie uniquement qu’un Membre a réussi avec succès la procédure de vérification existante sur la Plateforme ou les Services afin de vous fournir davantage d’informations sur le Membre avec lequel vous envisagez de voyager. Caramba ne garantit ni la véracité, ni la fiabilité, ni la validité de l’information ayant fait l’objet de la procédure de vérification.  

-	Des droits applicables et juridiction compétente : Les présentes CGU sont soumises au droit français.  En cas de litige, les tribunaux compétents seront ceux du ressort du siège social de Caramba, sauf disposition légale contraire.  








 
		3.3.11	Page Backoffice (admin)  
		
Cette page aura pour rôle de permettre aux responsables du site Caramba de gérer le contenu et les utilisateurs de la plateforme. Il s’agit d’un espace réservé et accessible uniquement aux personnes ayant un rôle administrateur, afin d’assurer la modération, la sécurité et la mise à jour des informations présentes sur le site.  Les administrateurs auront comme droit :  
•	La possibilité de gérer tous les comptes (passager et conducteur)  
•	Modifier la partie CGU, FAQ et les mentions légales  
•	La possibilité de désactiver ou bannir un compte utilisateur  
•	La modération du contenu publié  
En plus de ces droits, les comptes administrateurs pourront bénéficier de la page Backoffice leur permettant d’utiliser des fonctionnalités uniques comme :  
•	La gestion des comptes utilisateurs  
o	Affichage de la liste des utilisateurs  
o	 Gestion des activations et désactivations des comptes  
o	 La suppression et bannissement des utilisateurs signalés  
•	Les statistiques générales :  
o	Affichage du nombre de trajets publiés, réservations, comptes actifs et la note moyenne des utilisateurs  
•	Gestion de la sécurité  
o	 Consultation des documents officiels  
o	Validation des documents si nécessaire  
o	Suivi des signalements  
•	Gestion de la messagerie  
o	Accès aux messages envoyés depuis la page « Contact » et la possibilité d’y répondre  
La maquette du backoffice n’a pas encore été finalisée sur Figma par manque de temps, cependant son développement est prévu dans les futures versions du projet. L’objectif est de créer une page claire, simple et cohérente avec notre charte graphique.  

	3.4	 Schéma de navigation  
	
Le schéma ci-dessous montre l’enchaînement logique des pages du site. Il aide à visualiser la façon dont les utilisateurs naviguent entre les différentes interfaces.  
 
Figure 19: Schémas de navigation  



