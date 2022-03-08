-- -----------------------------------------------------------------------------
--                          Jeu de donnees
-- -----------------------------------------------------------------------------
--      Nom de la base : pecm
--      Projet : PECM CHIC
--      Auteures : Sarah GROS, Salome CHEVAILLER, Seraphie MAURY
--      Date de derniere modification : 10/02/2022
-- -----------------------------------------------------------------------------

-- INSERTING into DEPARTEMENT

INSERT INTO DEPARTEMENT(NOM, RISQUE) VALUES ('Urgences', 1);
INSERT INTO DEPARTEMENT(NOM, RISQUE) VALUES ('Cardiologie', 0);
INSERT INTO DEPARTEMENT(NOM, RISQUE) VALUES ('C.P.E.F.', 0);
INSERT INTO DEPARTEMENT(NOM, RISQUE) VALUES ('Chirurgie orthopedique traumatologique', 0);
INSERT INTO DEPARTEMENT(NOM, RISQUE) VALUES ('Chirurgie vasculaire', 0);
INSERT INTO DEPARTEMENT(NOM, RISQUE) VALUES ('Chirurgie viscerale', 0);
INSERT INTO DEPARTEMENT(NOM, RISQUE) VALUES ('Dermatologie', 0);
INSERT INTO DEPARTEMENT(NOM, RISQUE) VALUES ('Diabetologie', 0);
INSERT INTO DEPARTEMENT(NOM, RISQUE) VALUES ('Gastro-enterologie', 0);
INSERT INTO DEPARTEMENT(NOM, RISQUE) VALUES ('Geriatrie', 1);
INSERT INTO DEPARTEMENT(NOM, RISQUE) VALUES ('Gynecologie', 0);
INSERT INTO DEPARTEMENT(NOM, RISQUE) VALUES ('Medecine interne', 0);
INSERT INTO DEPARTEMENT(NOM, RISQUE) VALUES ('Medecine vasculaire', 0);
INSERT INTO DEPARTEMENT(NOM, RISQUE) VALUES ('Nephrologie', 0);
INSERT INTO DEPARTEMENT(NOM, RISQUE) VALUES ('Neurologie', 0);
INSERT INTO DEPARTEMENT(NOM, RISQUE) VALUES ('Oncologie', 0);
INSERT INTO DEPARTEMENT(NOM, RISQUE) VALUES ('Ophtalmologie', 0);
INSERT INTO DEPARTEMENT(NOM, RISQUE) VALUES ('O.R.L.', 0);
INSERT INTO DEPARTEMENT(NOM, RISQUE) VALUES ('Pediatrie', 1);
INSERT INTO DEPARTEMENT(NOM, RISQUE) VALUES ('Pneumologie', 0);
INSERT INTO DEPARTEMENT(NOM, RISQUE) VALUES ('Radiologie', 0);
INSERT INTO DEPARTEMENT(NOM, RISQUE) VALUES ('Rhumatologie', 0);
INSERT INTO DEPARTEMENT(NOM, RISQUE) VALUES ('Soins palliatifs', 0);
INSERT INTO DEPARTEMENT(NOM, RISQUE) VALUES ('Addictologie', 0);
INSERT INTO DEPARTEMENT(NOM, RISQUE) VALUES ('Urologie', 0);

-- INSERTING into NEVEREVENT

INSERT INTO NEVEREVENT(NOM) VALUES ('NE1');
INSERT INTO NEVEREVENT(NOM) VALUES ('NE2');
INSERT INTO NEVEREVENT(NOM) VALUES ('NE3');
INSERT INTO NEVEREVENT(NOM) VALUES ('NE4');
INSERT INTO NEVEREVENT(NOM) VALUES ('NE5');
INSERT INTO NEVEREVENT(NOM) VALUES ('NE6');
INSERT INTO NEVEREVENT(NOM) VALUES ('NE7');
INSERT INTO NEVEREVENT(NOM) VALUES ('NE8');
INSERT INTO NEVEREVENT(NOM) VALUES ('NE9');
INSERT INTO NEVEREVENT(NOM) VALUES ('NE10');
INSERT INTO NEVEREVENT(NOM) VALUES ('NE11');
INSERT INTO NEVEREVENT(NOM) VALUES ('NE12');

-- INSERTING into FACTEUR
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Patient', 'L''état de santé du patient est-il complexe, grave ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Patient', 'L''EI est-il survenu dans un contexte de prise en charge en urgence ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Patient', 'L''expression du patient ou la communication étaient-elles difficiles ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Patient', 'La personnalité du patient est-elle particulière et peut-elle expliquer en partie le dysfonctionnement ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Patient', 'Existe-t-il des facteurs sociaux particuliers susceptibles d''expliquer tout ou une partie des dysfonctionnements ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Individuel','Y a-t-il un défaut de qualification des personnes chargées du soin/de l''acte ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Individuel','Y a-t-il un défaut de connaissances théoriques ou techniques des professionnels ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Individuel','Y a-t-il un défaut d''aptitude, de compétence des professionnels chargés du soin/de l''acte ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Individuel','Les professionnels chargés des soins/actes étaient-ils en mauvaise disposition physique et mentale ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Individuel','Y a-t-il eu une insuffisance d''échange d''information entre les professionnels de santé et le patient ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Individuel','Y a-t-il eu une insuffisance d''échange d''information entre les professionnels de santé et la famille du patient, ses proches ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Individuel','A-t-on relevé un défaut de qualité de la relation avec le patient et sa famille ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Equipe','La composition de l''équipe chargée du soin/acte était-elle mauvaise ou inadaptée ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Equipe','A-t-on relevé un défaut de communication interne orale et/ou écrite au sein de l''équipe ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Equipe','A-t-on relevé une collaboration insuffisante entre professionnels ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Equipe','Existe-t-il des conflits ou une mauvaise ambiance au sein de l''équipe / un défaut de cohésion ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Equipe','La supervision des reponsables et des autres personnels a-t-elle été inadéquate / Y a-t-il eu un défaut d''encadrement ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Equipe','Y a-t-il un manque ou un défaut de recherche d''aide, d''avis, de collaboration ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Tache','Le(s) protocole(s) ou procédure(s) étaient-ils absents ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Tache','Le(s) protocole(s), procédure(s) étaient-ils inadaptés ou peu compréhensibles ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Tache','Le(s) protocole(s), procédure(s) étaient-ils indisponibles au moment du survenue de l''événement ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Tache','Le(s) protocole(s), procédure(s) étaient-ils inutilisables ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Tache','Le(s) protocole(s), procédure(s) étaient-ils insuffisamment diffusés et/ou connus ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Tache','Y a-t-il retard dans la prestation ou la programmation des examens cliniques et paracliniques ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Tache', 'Y a-t-il eu défaut d''accessibilité, de disponibilité de l''information en temps voulu ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Tache','La recherche d''information auprès d''un autre professionnel a-t-elle été difficile ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Tache','La planification des tâches était-elle inadaptée ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Tache','Les soins/actes ne relevaient-ils pas du champ de compétence, d''activité du service ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Tache','Le(s) protocole(s), procédure(s) n''ont-ils pas été respectés ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Environnemental','Les locaux ou le matériel utilisé étaient-ils inadaptés ou indisponibles ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Environnemental','Les fournitures ou équipements étaient-ils défectueux, mal entretenus ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Environnemental','Les fournitures ou équipements étaient-ils inexistants ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Environnemental','Les fournitures ou équipements ont-ils été mal utilisés ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Environnemental','Les supports d''information, les notices d''utilisation de matériel étaient-ils non disponibles ou inadaptés ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Environnemental','La formation ou entraînement des professionnels étaient-ils inexistants, inadaptés, non réalisés ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Environnemental','Les conditions de travail étaient-elles inadaptées ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Environnemental','La charge de travail était-elle importante au moment de l''événement ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Organisationnel','Y a-t-il eu un changement récent d''organisation interne ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Organisationnel','Y a-t-il une limitation trop restrictive de la prise de décision des acteurs du terrain ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Organisationnel','Les responsabilités et les tâches étaient-elles non ou mal définies ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Organisationnel','Y a-t-il eu un défaut de coordination dans les services ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Organisationnel','Y a-t-il eu un défaut de coordination entre les services, les structures ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Organisationnel','Y a-t-il eu un défaut d''adaptation à une situation imprévue ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Organisationnel','La gestion des ressources humaines était-elle inadéquate ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Organisationnel','La procédure de sortie était-elle inadéquate ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Institutionnel','Les contraintes financières au niveau de l''établissement sont-elles à l''origine de l''événement ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Institutionnel','Les ressources sanitaires sont-elles insuffisantes, inadaptée ou défectueuses ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Institutionnel','Les échanges ou relations avec d''autres structures de soins sont-ils faibles ou difficiles ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Institutionnel','Peut-on relever une absence de stratégie politique/une absence de priorité/ou des stratégies contradictoires ou inadaptées ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Institutionnel','La sécurité et gestion des risques ne sont-elles pas perçues comme des objectifs importants ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Institutionnel','La culture du signalement des EI et de propositions de corrections est-elle inexistante ou défectueuse ?');
INSERT INTO FACTEUR(CATEGORIE,LIBELLE) VALUES ('Institutionnel','Le contexte social était-il difficile ?');
