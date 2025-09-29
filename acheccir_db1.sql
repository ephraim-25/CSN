-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : [DATE]
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `acheccir_db1`
--

-- --------------------------------------------------------
-- 1. TABLES DE BASE (Sans dépendances)

DROP TABLE IF EXISTS `provinces`;
CREATE TABLE IF NOT EXISTS `provinces` (
  `province_id` int NOT NULL AUTO_INCREMENT,
  `province_nom` varchar(100) NOT NULL,
  `province_abrev` varchar(10) NOT NULL,
  PRIMARY KEY (`province_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `newsletter_categories`;
CREATE TABLE IF NOT EXISTS `newsletter_categories` (
  `category_id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `description` text,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom_complet` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `role` enum('admin','moderateur','membre') NOT NULL DEFAULT 'membre',
  `derniere_connexion` datetime DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `centre_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `telephone` (`telephone`),
  KEY `centre_id` (`centre_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 2. TABLES AVEC DÉPENDANCES SIMPLES

DROP TABLE IF EXISTS `centres`;
CREATE TABLE IF NOT EXISTS `centres` (
  `centre_id` int NOT NULL AUTO_INCREMENT,
  `nom_centre` varchar(100) NOT NULL,
  `centre_abrev` varchar(10) NOT NULL,
  `niveau` enum('CENTRAL','PROVINCIALE','NATIONAL') NOT NULL,
  `adresse_contacts` varchar(255) NOT NULL,
  `ville` varchar(100) NOT NULL,
  `province_id` int NOT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `site_web` varchar(255) DEFAULT NULL,
  `logo_path` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`centre_id`),
  KEY `province_id` (`province_id`),
  FULLTEXT KEY `ft_nom_ville` (`nom_centre`, `ville`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 3. TABLES AVEC DÉPENDANCES COMPLEXES

DROP TABLE IF EXISTS `chercheurs`;
CREATE TABLE IF NOT EXISTS `chercheurs` (
  `chercheur_id` int NOT NULL AUTO_INCREMENT,
  `matricule` varchar(15) NOT NULL,
  `nom_complet` varchar(150) NOT NULL,
  `sexe` enum('Homme','Femme','Autre') NOT NULL,
  `date_naissance` date NOT NULL,
  `lieu_naissance` varchar(100) NOT NULL,
  `titre_academique` varchar(25) NOT NULL,
  `specialites` varchar(50) NOT NULL,
  `grade` varchar(50) NOT NULL,
  `fonction` enum('chercheur','chercheure','administratif','Autre') NOT NULL,
  `date_engagement` date NOT NULL,
  `province_id` int NOT NULL,
  `centre_id` int NOT NULL,
  `anciennete` int NOT NULL,
  `departement` varchar(250) NOT NULL,
  `champs_activites_recherche` varchar(255) NOT NULL,
  `contribution_service_public` varchar(255) NOT NULL,
  `societes_savantes` varchar(255) NOT NULL,
  `activites_scientifiques_animees` TEXT NOT NULL,
  `principaux_ouvrages_publications` TEXT NOT NULL,
  `adresse_contacts` varchar(150) NOT NULL,
  `email_personnel` varchar(255) DEFAULT NULL,
  `email_professionnel` varchar(255) NOT NULL,
  `email_pro_verifie` tinyint(1) DEFAULT 0,
  `date_verification_email` datetime DEFAULT NULL,
  `telephone` varchar(20) NOT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `orcid` varchar(19) DEFAULT NULL,
  `google_scholar_id` varchar(100) DEFAULT NULL,
  `scopus_id` varchar(100) DEFAULT NULL,
  `researchgate_url` varchar(255) DEFAULT NULL,
  `statut` enum('Actif','Retraité','Décédé') DEFAULT 'Actif',
  `numero_carte` varchar(20) DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`chercheur_id`),
  UNIQUE KEY `matricule` (`matricule`),
  UNIQUE KEY `orcid` (`orcid`),
  UNIQUE KEY `email_professionnel` (`email_professionnel`),
  UNIQUE KEY `numero_carte` (`numero_carte`),
  KEY `province_id` (`province_id`),
  KEY `centre_id` (`centre_id`),
  KEY `user_id` (`user_id`),
  KEY `idx_nom_complet` (`nom_complet`),
  FULLTEXT KEY `ft_recherche` (`nom_complet`, `grade`, `specialites`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `publications`;
CREATE TABLE IF NOT EXISTS `publications` (
  `pub_id` int NOT NULL AUTO_INCREMENT,
  `chercheur_id` int NOT NULL,
  `titre` varchar(255) NOT NULL,
  `auteurs` varchar(255) NOT NULL,
  `journal` varchar(100) DEFAULT NULL,
  `annee` year DEFAULT NULL,
  `doi` varchar(100) DEFAULT NULL,
  `lien` varchar(255) DEFAULT NULL,
  `citations` int DEFAULT 0,
  `impact_factor` decimal(5,2) DEFAULT NULL,
  `quartile` enum('Q1','Q2','Q3','Q4') DEFAULT NULL,
  `type` enum('Article','Livre','Chapitre','Conférence','Thèse','Rapport') DEFAULT 'Article',
  PRIMARY KEY (`pub_id`),
  KEY `chercheur_id` (`chercheur_id`),
  FULLTEXT KEY `ft_search` (`titre`, `auteurs`, `journal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `metrics_academiques`;
CREATE TABLE IF NOT EXISTS `metrics_academiques` (
  `metric_id` int NOT NULL AUTO_INCREMENT,
  `chercheur_id` int NOT NULL,
  `h_index` int DEFAULT 0 COMMENT 'Indice h calculé',
  `h_index_gs` int DEFAULT NULL COMMENT 'H-Index Google Scholar',
  `h_index_scopus` int DEFAULT NULL COMMENT 'H-Index Scopus',
  `h_index_wos` int DEFAULT NULL COMMENT 'H-Index Web of Science',
  `total_citations` int DEFAULT 0,
  `i10_index` int DEFAULT 0,
  `date_maj` date NOT NULL,
  `source` enum('Google Scholar','Scopus','Web of Science','ORCID','Calcul Interne') NOT NULL,
  `liens_verification` varchar(255) DEFAULT NULL,
  `last_calculated` timestamp NULL DEFAULT NULL COMMENT 'Date du dernier calcul',
  PRIMARY KEY (`metric_id`),
  UNIQUE KEY `unique_chercheur_source` (`chercheur_id`, `source`),
  CONSTRAINT `fk_metrics_chercheur` FOREIGN KEY (`chercheur_id`) 
    REFERENCES `chercheurs` (`chercheur_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `h_index_history`;
CREATE TABLE IF NOT EXISTS `h_index_history` (
  `history_id` int NOT NULL AUTO_INCREMENT,
  `chercheur_id` int NOT NULL,
  `h_index` int NOT NULL,
  `source` enum('Google Scholar','Scopus','Web of Science','Calcul Interne') NOT NULL,
  `date_recorded` date NOT NULL,
  `publications_count` int DEFAULT NULL,
  `citations_total` int DEFAULT NULL,
  PRIMARY KEY (`history_id`),
  KEY `chercheur_id` (`chercheur_id`),
  CONSTRAINT `fk_hindex_chercheur` FOREIGN KEY (`chercheur_id`) 
    REFERENCES `chercheurs` (`chercheur_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cartes_chercheurs`;
CREATE TABLE IF NOT EXISTS `cartes_chercheurs` (
  `carte_id` int NOT NULL AUTO_INCREMENT,
  `chercheur_id` int NOT NULL,
  `numero_carte` varchar(20) NOT NULL,
  `date_emission` date NOT NULL,
  `date_expiration` date NOT NULL,
  `qr_code_path` varchar(255) DEFAULT NULL,
  `statut` enum('active','expiree','revokee') DEFAULT 'active',
  PRIMARY KEY (`carte_id`),
  UNIQUE KEY `numero_carte` (`numero_carte`),
  KEY `chercheur_id` (`chercheur_id`),
  CONSTRAINT `fk_carte_chercheur` FOREIGN KEY (`chercheur_id`) REFERENCES `chercheurs` (`chercheur_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `chercheur_activity`;
CREATE TABLE IF NOT EXISTS `chercheur_activity` (
  `activity_id` int NOT NULL AUTO_INCREMENT,
  `chercheur_id` int NOT NULL,
  `last_publication` year DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `h_index_trend` decimal(5,2) DEFAULT NULL,
  `activity_score` int DEFAULT NULL,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`activity_id`),
  UNIQUE KEY `chercheur_id` (`chercheur_id`),
  CONSTRAINT `fk_activity_chercheur` FOREIGN KEY (`chercheur_id`) REFERENCES `chercheurs` (`chercheur_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `ai_publication_analysis`;
CREATE TABLE IF NOT EXISTS `ai_publication_analysis` (
  `analysis_id` int NOT NULL AUTO_INCREMENT,
  `pub_id` int NOT NULL,
  `keywords` json DEFAULT NULL,
  `similarity_score` decimal(5,2) DEFAULT NULL,
  `potential_collaborations` json DEFAULT NULL,
  `last_analyzed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`analysis_id`),
  UNIQUE KEY `pub_id` (`pub_id`),
  CONSTRAINT `fk_analysis_publication` FOREIGN KEY (`pub_id`) REFERENCES `publications` (`pub_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table pour les visites
DROP TABLE IF EXISTS `site_visits`;
CREATE TABLE IF NOT EXISTS `site_visits` (
  `visit_id` int NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `page_visited` varchar(255) NOT NULL,
  `referrer` varchar(255) DEFAULT NULL,
  `visit_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`visit_id`),
  KEY `visit_time` (`visit_time`),
  KEY `page_visited` (`page_visited`),
  CONSTRAINT `fk_visit_user` FOREIGN KEY (`user_id`) REFERENCES `utilisateurs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table pour les rapports générés
DROP TABLE IF EXISTS `generated_reports`;
CREATE TABLE IF NOT EXISTS `generated_reports` (
  `report_id` int NOT NULL AUTO_INCREMENT,
  `report_type` enum('chercheurs','centres','publications','metrics') NOT NULL,
  `format` enum('pdf','csv','excel') NOT NULL,
  `generated_by` int NOT NULL,
  `generation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `file_path` varchar(255) NOT NULL,
  `parameters` json DEFAULT NULL,
  `download_count` int DEFAULT '0',
  PRIMARY KEY (`report_id`),
  KEY `generated_by` (`generated_by`),
  CONSTRAINT `fk_report_user` FOREIGN KEY (`generated_by`) REFERENCES `utilisateurs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table pour les pages des centres
DROP TABLE IF EXISTS `centre_pages`;
CREATE TABLE IF NOT EXISTS `centre_pages` (
  `page_id` int NOT NULL AUTO_INCREMENT,
  `centre_id` int NOT NULL,
  `content` longtext NOT NULL,
  `history` json DEFAULT NULL COMMENT 'Historique des modifications',
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`page_id`),
  UNIQUE KEY `centre_id` (`centre_id`),
  CONSTRAINT `fk_centre_page` FOREIGN KEY (`centre_id`) REFERENCES `centres` (`centre_id`),
  CONSTRAINT `fk_centre_page_updater` FOREIGN KEY (`updated_by`) REFERENCES `utilisateurs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 4. TABLES DE GESTION DES EMAILS PROFESSIONNELS

DROP TABLE IF EXISTS `email_domaines_autorises`;
CREATE TABLE IF NOT EXISTS `email_domaines_autorises` (
  `id` int NOT NULL AUTO_INCREMENT,
  `centre_id` int NOT NULL,
  `domaine` varchar(100) NOT NULL COMMENT 'Ex: crsn-lwiro.org',
  `date_ajout` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_domaine_centre` (`centre_id`,`domaine`),
  CONSTRAINT `fk_domaine_centre` FOREIGN KEY (`centre_id`) REFERENCES `centres` (`centre_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `email_verifications`;
CREATE TABLE IF NOT EXISTS `email_verifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `chercheur_id` int NOT NULL,
  `token` varchar(64) NOT NULL,
  `email` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `chercheur_id` (`chercheur_id`),
  CONSTRAINT `fk_email_verif_chercheur` FOREIGN KEY (`chercheur_id`) REFERENCES `chercheurs` (`chercheur_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `email_historique`;
CREATE TABLE IF NOT EXISTS `email_historique` (
  `id` int NOT NULL AUTO_INCREMENT,
  `chercheur_id` int NOT NULL,
  `ancien_email` varchar(255) DEFAULT NULL,
  `nouvel_email` varchar(255) NOT NULL,
  `type` enum('personnel','professionnel') NOT NULL,
  `date_modification` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifie_par` int DEFAULT NULL COMMENT 'ID utilisateur ou système',
  PRIMARY KEY (`id`),
  KEY `chercheur_id` (`chercheur_id`),
  KEY `modifie_par` (`modifie_par`),
  CONSTRAINT `fk_email_hist_chercheur` FOREIGN KEY (`chercheur_id`) REFERENCES `chercheurs` (`chercheur_id`),
  CONSTRAINT `fk_email_hist_user` FOREIGN KEY (`modifie_par`) REFERENCES `utilisateurs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 5. TABLES DE GESTION UTILISATEURS ET NEWSLETTER

DROP TABLE IF EXISTS `newsletter_subscriptions`;
CREATE TABLE IF NOT EXISTS `newsletter_subscriptions` (
  `subscription_id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `category_id` int NOT NULL,
  `date_inscription` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `confirmation_token` varchar(64) DEFAULT NULL,
  `est_confirme` tinyint(1) DEFAULT 0,
  `langue_preferee` enum('fr','en') DEFAULT 'fr',
  PRIMARY KEY (`subscription_id`),
  UNIQUE KEY `unique_email_category` (`email`, `category_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `fk_subscription_category` FOREIGN KEY (`category_id`) 
    REFERENCES `newsletter_categories` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `newsletter_campaigns`;
CREATE TABLE IF NOT EXISTS `newsletter_campaigns` (
  `campaign_id` int NOT NULL AUTO_INCREMENT,
  `sujet` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `category_id` int DEFAULT NULL,
  `date_envoi` timestamp NULL DEFAULT NULL,
  `statut` enum('Brouillon','Planifié','Envoyé') DEFAULT 'Brouillon',
  `destinataires` int DEFAULT 0,
  PRIMARY KEY (`campaign_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `fk_campaign_category` FOREIGN KEY (`category_id`) 
    REFERENCES `newsletter_categories` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `audit_log`;
CREATE TABLE IF NOT EXISTS `audit_log` (
  `log_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `action` varchar(50) NOT NULL,
  `table_affected` varchar(50) NOT NULL,
  `record_id` int DEFAULT NULL,
  `old_values` json DEFAULT NULL,
  `new_values` json DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip_address` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`log_id`),
  KEY `user_id` (`user_id`),
  KEY `timestamp` (`timestamp`),
  KEY `table_affected` (`table_affected`),
  CONSTRAINT `fk_audit_user` FOREIGN KEY (`user_id`) REFERENCES `utilisateurs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Ajout de nouvelles tables pour améliorer le système
CREATE TABLE IF NOT EXISTS `centre_departements` (
  `departement_id` int NOT NULL AUTO_INCREMENT,
  `centre_id` int NOT NULL,
  `nom_departement` varchar(100) NOT NULL,
  `description` text,
  `responsable_id` int DEFAULT NULL,
  PRIMARY KEY (`departement_id`),
  KEY `centre_id` (`centre_id`),
  KEY `responsable_id` (`responsable_id`),
  CONSTRAINT `fk_departement_centre` FOREIGN KEY (`centre_id`) REFERENCES `centres` (`centre_id`),
  CONSTRAINT `fk_departement_responsable` FOREIGN KEY (`responsable_id`) REFERENCES `chercheurs` (`chercheur_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `centre_equipements` (
  `equipement_id` int NOT NULL AUTO_INCREMENT,
  `centre_id` int NOT NULL,
  `nom_equipement` varchar(100) NOT NULL,
  `description` text,
  `date_acquisition` date DEFAULT NULL,
  `etat` enum('neuf','bon','moyen','mauvais','hors_service') DEFAULT 'bon',
  PRIMARY KEY (`equipement_id`),
  KEY `centre_id` (`centre_id`),
  CONSTRAINT `fk_equipement_centre` FOREIGN KEY (`centre_id`) REFERENCES `centres` (`centre_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `report_templates` (
  `template_id` int NOT NULL AUTO_INCREMENT,
  `nom_template` varchar(100) NOT NULL,
  `description` text,
  `type_rapport` enum('chercheurs','centres','publications','metrics') NOT NULL,
  `filtres_disponibles` json DEFAULT NULL,
  `colonnes_par_defaut` json DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  PRIMARY KEY (`template_id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `fk_template_creator` FOREIGN KEY (`created_by`) REFERENCES `utilisateurs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `message` varchar(255) NOT NULL,
  `lien` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `fk_notification_user` FOREIGN KEY (`user_id`) REFERENCES `utilisateurs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table pour les collaborations
CREATE TABLE IF NOT EXISTS `collaborations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `chercheur1_id` int NOT NULL COMMENT 'Demandeur',
  `chercheur2_id` int NOT NULL COMMENT 'Receveur',
  `message` text,
  `statut` enum('pending','active','rejected','ended') NOT NULL DEFAULT 'pending',
  `date_demande` datetime NOT NULL,
  `date_reponse` datetime DEFAULT NULL,
  `date_fin` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `chercheur1_id` (`chercheur1_id`),
  KEY `chercheur2_id` (`chercheur2_id`),
  CONSTRAINT `fk_collab_chercheur1` FOREIGN KEY (`chercheur1_id`) REFERENCES `chercheurs` (`chercheur_id`),
  CONSTRAINT `fk_collab_chercheur2` FOREIGN KEY (`chercheur2_id`) REFERENCES `chercheurs` (`chercheur_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table pour les projets de recherche
CREATE TABLE IF NOT EXISTS `projets_recherche` (
  `projet_id` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `description` text,
  `date_debut` date NOT NULL,
  `date_fin` date DEFAULT NULL,
  `budget` decimal(12,2) DEFAULT NULL,
  `statut` enum('planifié','en_cours','terminé','annulé') NOT NULL DEFAULT 'planifié',
  `chef_projet_id` int NOT NULL,
  `centre_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`projet_id`),
  KEY `chef_projet_id` (`chef_projet_id`),
  KEY `centre_id` (`centre_id`),
  CONSTRAINT `fk_projet_centre` FOREIGN KEY (`centre_id`) REFERENCES `centres` (`centre_id`),
  CONSTRAINT `fk_projet_chef` FOREIGN KEY (`chef_projet_id`) REFERENCES `chercheurs` (`chercheur_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table de liaison chercheurs-projets
CREATE TABLE IF NOT EXISTS `chercheur_projets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `chercheur_id` int NOT NULL,
  `projet_id` int NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'participant',
  `date_ajout` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_chercheur_projet` (`chercheur_id`,`projet_id`),
  KEY `projet_id` (`projet_id`),
  CONSTRAINT `fk_cp_chercheur` FOREIGN KEY (`chercheur_id`) REFERENCES `chercheurs` (`chercheur_id`),
  CONSTRAINT `fk_cp_projet` FOREIGN KEY (`projet_id`) REFERENCES `projets_recherche` (`projet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
-- --------------------------------------------------------
-- 6. TABLES TECHNIQUES (Performance et IA)

DROP TABLE IF EXISTS `performance_metrics`;
CREATE TABLE IF NOT EXISTS `performance_metrics` (
  `metric_id` int NOT NULL AUTO_INCREMENT,
  `page` varchar(100) NOT NULL,
  `load_time` decimal(10,4) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`metric_id`),
  KEY `page` (`page`),
  KEY `timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `ai_maintenance_reports`;
CREATE TABLE IF NOT EXISTS `ai_maintenance_reports` (
  `report_id` int NOT NULL AUTO_INCREMENT,
  `report_type` enum('performance','content','security') NOT NULL,
  `findings` json NOT NULL,
  `recommendations` text NOT NULL,
  `priority` enum('low','medium','high') NOT NULL,
  `status` enum('pending','in_progress','resolved') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `resolved_at` datetime DEFAULT NULL,
  PRIMARY KEY (`report_id`),
  KEY `priority` (`priority`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 7. VUES

DROP VIEW IF EXISTS `chercheur_metrics_view`;
CREATE VIEW `chercheur_metrics_view` AS
SELECT 
    c.chercheur_id,
    c.nom_complet,
    c.grade,
    c.specialites,
    c.email_personnel,
    c.email_professionnel,
    c.email_pro_verifie,
    cen.nom_centre AS centre,
    p.province_nom AS province,
    m.h_index,
    m.h_index_gs,
    m.h_index_scopus,
    m.total_citations,
    m.i10_index,
    (SELECT COUNT(*) FROM publications p WHERE p.chercheur_id = c.chercheur_id) AS publications_count,
    m.date_maj
FROM 
    chercheurs c
LEFT JOIN 
    metrics_academiques m ON c.chercheur_id = m.chercheur_id AND m.source = 'Calcul Interne'
LEFT JOIN
    centres cen ON c.centre_id = cen.centre_id
LEFT JOIN
    provinces p ON c.province_id = p.province_id;

-- --------------------------------------------------------
-- 8. CONTRAINTES DE CLÉS ÉTRANGÈRES

ALTER TABLE `centres`
ADD CONSTRAINT `fk_centre_province` FOREIGN KEY (`province_id`) 
REFERENCES `provinces` (`province_id`);

ALTER TABLE `chercheurs`
ADD CONSTRAINT `fk_chercheur_province` FOREIGN KEY (`province_id`) 
REFERENCES `provinces` (`province_id`),
ADD CONSTRAINT `fk_chercheur_centre` FOREIGN KEY (`centre_id`) 
REFERENCES `centres` (`centre_id`),
ADD CONSTRAINT `fk_chercheur_user` FOREIGN KEY (`user_id`) 
REFERENCES `utilisateurs` (`id`);

ALTER TABLE `publications`
ADD CONSTRAINT `fk_pub_chercheur` FOREIGN KEY (`chercheur_id`) 
REFERENCES `chercheurs` (`chercheur_id`) ON DELETE CASCADE;

ALTER TABLE `utilisateurs`
ADD CONSTRAINT `fk_user_centre` FOREIGN KEY (`centre_id`) 
REFERENCES `centres` (`centre_id`);

ALTER TABLE `chercheurs` 
MODIFY COLUMN email_professionnel VARCHAR(255) NULL,
MODIFY COLUMN telephone VARCHAR(20) NULL,
ADD COLUMN user_id INT NULL AFTER numero_carte,
ADD CONSTRAINT fk_chercheur_user FOREIGN KEY (user_id) REFERENCES utilisateurs(id);
-- --------------------------------------------------------
-- 9. PROCÉDURES ET DÉCLENCHEURS

DELIMITER //
CREATE PROCEDURE `update_full_metrics`(IN p_chercheur_id INT)
BEGIN
    DECLARE v_h_index INT;
    DECLARE v_total_citations INT;
    DECLARE v_i10_index INT;
    DECLARE v_publications_count INT;
    
    -- Calcul du H-Index interne
    SELECT COUNT(*) INTO v_h_index
    FROM (
        SELECT p.citations, ROW_NUMBER() OVER (ORDER BY p.citations DESC) AS rang
        FROM publications p
        WHERE p.chercheur_id = p_chercheur_id AND p.citations > 0
    ) AS ranked
    WHERE citations >= rang;
    
    -- Total des citations
    SELECT IFNULL(SUM(citations), 0) INTO v_total_citations 
    FROM publications 
    WHERE chercheur_id = p_chercheur_id;
    
    -- I10-Index
    SELECT COUNT(*) INTO v_i10_index 
    FROM publications 
    WHERE chercheur_id = p_chercheur_id AND citations >= 10;
    
    -- Nombre total de publications
    SELECT COUNT(*) INTO v_publications_count
    FROM publications
    WHERE chercheur_id = p_chercheur_id;
    
    -- Mise à jour des metrics
    INSERT INTO metrics_academiques (
        chercheur_id, 
        h_index, 
        total_citations, 
        i10_index, 
        date_maj, 
        source,
        last_calculated
    )
    VALUES (
        p_chercheur_id, 
        v_h_index, 
        v_total_citations, 
        v_i10_index, 
        CURDATE(), 
        'Calcul Interne',
        NOW()
    )
    ON DUPLICATE KEY UPDATE 
        h_index = VALUES(h_index),
        total_citations = VALUES(total_citations),
        i10_index = VALUES(i10_index),
        date_maj = VALUES(date_maj),
        last_calculated = VALUES(last_calculated);
    
    -- Historisation
    INSERT INTO h_index_history (
        chercheur_id,
        h_index,
        source,
        date_recorded,
        publications_count,
        citations_total
    )
    VALUES (
        p_chercheur_id,
        v_h_index,
        'Calcul Interne',
        CURDATE(),
        v_publications_count,
        v_total_citations
    );
END//

DELIMITER //
CREATE PROCEDURE `verifier_email_professionnel`(IN p_chercheur_id INT)
BEGIN
    DECLARE v_email_pro VARCHAR(255);
    DECLARE v_domaine VARCHAR(100);
    DECLARE v_centre_id INT;
    DECLARE v_domaine_valide INT;
    
    -- Récupérer l'email pro et le centre du chercheur
    SELECT c.email_professionnel, c.centre_id 
    INTO v_email_pro, v_centre_id
    FROM chercheurs c 
    WHERE c.chercheur_id = p_chercheur_id;
    
    -- Extraire le domaine de l'email (partie après @)
    SET v_domaine = SUBSTRING(v_email_pro, LOCATE('@', v_email_pro) + 1);
    
    -- Vérifier si le domaine est autorisé pour ce centre
    SELECT COUNT(*) INTO v_domaine_valide
    FROM email_domaines_autorises
    WHERE centre_id = v_centre_id 
    AND domaine = v_domaine
    AND actif = 1;
    
    -- Mettre à jour le statut de vérification
    IF v_domaine_valide > 0 THEN
        UPDATE chercheurs 
        SET email_pro_verifie = 1, 
            date_verification_email = NOW()
        WHERE chercheur_id = p_chercheur_id;
        
        INSERT INTO email_historique
        (chercheur_id, nouvel_email, type, modifie_par)
        VALUES
        (p_chercheur_id, v_email_pro, 'professionnel', NULL);
    END IF;
END//

DELIMITER //
CREATE TRIGGER `after_publication_insert` AFTER INSERT ON `publications`
FOR EACH ROW
BEGIN
    CALL update_full_metrics(NEW.chercheur_id);
    INSERT INTO ai_publication_analysis (pub_id) VALUES (NEW.pub_id);
    CALL update_chercheur_activity(NEW.chercheur_id);
END//

DELIMITER //
CREATE TRIGGER `after_publication_update` AFTER UPDATE ON `publications`
FOR EACH ROW
BEGIN
    CALL update_full_metrics(NEW.chercheur_id);
END//

DELIMITER //
CREATE TRIGGER `after_publication_delete` AFTER DELETE ON `publications`
FOR EACH ROW
BEGIN
    CALL update_full_metrics(OLD.chercheur_id);
END//

DELIMITER //
CREATE TRIGGER `after_chercheur_email_update` AFTER UPDATE ON `chercheurs`
FOR EACH ROW
BEGIN
    IF NEW.email_professionnel != OLD.email_professionnel THEN
        CALL verifier_email_professionnel(NEW.chercheur_id);
    END IF;
END//

DELIMITER //
CREATE PROCEDURE `update_chercheur_activity`(IN p_chercheur_id INT)
BEGIN
    DECLARE v_last_pub YEAR;
    DECLARE v_h_trend DECIMAL(5,2);
    
    SELECT MAX(annee) INTO v_last_pub FROM publications WHERE chercheur_id = p_chercheur_id;
    
    -- Calcul de la tendance du h-index (simplifié)
    SELECT (MAX(h_index) - MIN(h_index)) / COUNT(*) INTO v_h_trend
    FROM metrics_academiques
    WHERE chercheur_id = p_chercheur_id
    AND date_maj > NOW() - INTERVAL 1 YEAR;
    
    INSERT INTO chercheur_activity (chercheur_id, last_publication, h_index_trend)
    VALUES (p_chercheur_id, v_last_pub, v_h_trend)
    ON DUPLICATE KEY UPDATE 
        last_publication = VALUES(last_publication),
        h_index_trend = VALUES(h_index_trend);
END//

DELIMITER ;

-- --------------------------------------------------------
-- 10. DONNÉES INITIALES

INSERT INTO `provinces` (`province_id`, `province_nom`, `province_abrev`) VALUES
(1, 'Kinshasa', 'KIN'),
(2, 'Kongo Central', 'KCE'),
(3, 'Kwango', 'KWG'),
(4, 'Kwilu', 'KWL'),
(5, 'Mai-Ndombe', 'MDB'),
(6, 'Équateur', 'EQT'),
(7, 'Mongala', 'MGL'),
(8, 'Nord-Ubangi', 'NUG'),
(9, 'Sud-Ubangi', 'SUG'),
(10, 'Tshuapa', 'TSP'),
(11, 'Bas-Uele', 'BSL'),
(12, 'Haut-Uele', 'HUL'),
(13, 'Ituri', 'ITR'),
(14, 'Tshopo', 'TSO'),
(15, 'Maniema', 'MNA'),
(16, 'Nord-Kivu', 'NKV'),
(17, 'Sud-Kivu', 'SKV'),
(18, 'Haut-Katanga', 'HKG'),
(19, 'Haut-Lomami', 'HLM'),
(20, 'Lualaba', 'LLB'),
(21, 'Tanganyika', 'TGK'),
(22, 'Kasaï-Oriental', 'KOT'),
(23, 'Lomami', 'LMI'),
(24, 'Sankuru', 'SKR'),
(25, 'Kasaï', 'KSI'),
(26, 'Kasaï Central', 'KSC');

INSERT INTO `centres` (`centre_id`, `nom_centre`, `centre_abrev`, `niveau`, `adresse_contacts`, `ville`, `province_id`, `latitude`, `longitude`, `site_web`) VALUES
(1, 'Institut de Recherche en Science de la Santé', 'IRSS', 'NATIONAL', '9, Av. Lukusa C/Gombe', 'Kinshasa', 1, -4.30591600, 15.31259700, 'http://www.irss-rdc.org'),
(2, 'Centre de Recherche en Sciences Naturelles', 'CRSN', 'NATIONAL', 'Avenue de la Science', 'Lwiro', 17, -2.24740000, 28.80890000, 'http://www.crsn-lwiro.org'),
(3, 'Institut Géographique du Congo', 'IGC', 'NATIONAL', '12, Av. des 3 Z', 'Kinshasa', 1, -4.33158300, 15.27183300, 'http://www.igc.cd');

INSERT INTO `email_domaines_autorises` (`centre_id`, `domaine`) VALUES
(1, 'irss-rdc.org'),
(2, 'crsn-lwiro.org'),
(3, 'igc.cd');

INSERT INTO `newsletter_categories` (`category_id`, `nom`, `description`) VALUES
(1, 'Actualités scientifiques', 'Nouvelles et avancées scientifiques'),
(2, 'Opportunités de recherche', 'Appels à projets et financements');

INSERT INTO `utilisateurs` (`id`, `nom_complet`, `email`, `telephone`, `mot_de_passe`, `role`, `centre_id`) VALUES
(1, 'Administrateur Système', 'admin@csn.cd', '+243810000001', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 1),
(2, 'Modérateur CRSN', 'mod@crsn.cd', '+243810000002', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'moderateur', 2);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;