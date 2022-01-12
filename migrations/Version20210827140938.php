<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210827140938 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE kanban_chapitre (id INT AUTO_INCREMENT NOT NULL, titre_chapitre VARCHAR(255) NOT NULL, id_manga INT NOT NULL, numero_chapitre INT NOT NULL, date_sortie_chapitre VARCHAR(255) NOT NULL, status_chapitre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE kanban_commentaire (id INT AUTO_INCREMENT NOT NULL, membre_id INT NOT NULL, manga_id INT NOT NULL, commentaire VARCHAR(255) NOT NULL, poste_at VARCHAR(255) NOT NULL, supprime_commentaire VARCHAR(255) NOT NULL, id_chapitre INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE kanban_info_culturelle (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, media VARCHAR(255) NOT NULL, post_at VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE kanban_like (id INT AUTO_INCREMENT NOT NULL, member_id INT NOT NULL, manga_id INT NOT NULL, status VARCHAR(255) NOT NULL, id_chapitre INT NOT NULL, like_chapitre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE kanban_manga (id_manga INT AUTO_INCREMENT NOT NULL, titre_manga VARCHAR(255) NOT NULL, manga_post_at VARCHAR(255) NOT NULL, status_manga VARCHAR(255) NOT NULL, type_manga VARCHAR(255) NOT NULL, auteur_manga VARCHAR(255) NOT NULL, PRIMARY KEY(id_manga)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE kanban_manga_genre (id INT AUTO_INCREMENT NOT NULL, id_manga INT NOT NULL, genre_manga VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE kanban_scan (id INT AUTO_INCREMENT NOT NULL, id_chapitre INT NOT NULL, scan_images VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE kanban_user (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, date_inscription VARCHAR(255) NOT NULL, token VARCHAR(255) NOT NULL, verifie_email VARCHAR(255) NOT NULL, avatar VARCHAR(255) NOT NULL, admin VARCHAR(255) NOT NULL, membre_banni VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sortie_chapitre (id INT AUTO_INCREMENT NOT NULL, id_manga INT NOT NULL, sortie_chapitre VARCHAR(255) NOT NULL, date_sortie_chapitre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE kanban_chapitre');
        $this->addSql('DROP TABLE kanban_commentaire');
        $this->addSql('DROP TABLE kanban_info_culturelle');
        $this->addSql('DROP TABLE kanban_like');
        $this->addSql('DROP TABLE kanban_manga');
        $this->addSql('DROP TABLE kanban_manga_genre');
        $this->addSql('DROP TABLE kanban_scan');
        $this->addSql('DROP TABLE kanban_user');
        $this->addSql('DROP TABLE sortie_chapitre');
    }
}
