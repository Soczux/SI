<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210909230824 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE album (id INT AUTO_INCREMENT NOT NULL, artist_id INT NOT NULL, name VARCHAR(100) NOT NULL, logo_url VARCHAR(255) NOT NULL, INDEX IDX_39986E43B7970CF8 (artist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE album_comment (id INT AUTO_INCREMENT NOT NULL, album_id INT NOT NULL, user_id INT DEFAULT NULL, content VARCHAR(1000) NOT NULL, commented_on DATETIME NOT NULL, INDEX IDX_C1A30F7E1137ABCF (album_id), INDEX IDX_C1A30F7EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artist (id INT AUTO_INCREMENT NOT NULL, country_id INT NOT NULL, name VARCHAR(100) NOT NULL, INDEX IDX_1599687F92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artist_artist_tag (artist_id INT NOT NULL, artist_tag_id INT NOT NULL, INDEX IDX_38F3ED4BB7970CF8 (artist_id), INDEX IDX_38F3ED4B48D06F6F (artist_tag_id), PRIMARY KEY(artist_id, artist_tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artist_comment (id INT AUTO_INCREMENT NOT NULL, artist_id INT NOT NULL, user_id INT DEFAULT NULL, content VARCHAR(1000) NOT NULL, commented_on DATETIME NOT NULL, INDEX IDX_233B0C5BB7970CF8 (artist_id), INDEX IDX_233B0C5BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artist_tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, created_on DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(80) NOT NULL, iso VARCHAR(2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE song (id INT AUTO_INCREMENT NOT NULL, artist_id INT NOT NULL, title VARCHAR(100) NOT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_33EDEEA1B7970CF8 (artist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE song_comment (id INT AUTO_INCREMENT NOT NULL, song_id INT NOT NULL, user_id INT DEFAULT NULL, content VARCHAR(1000) NOT NULL, commented_on DATETIME NOT NULL, INDEX IDX_991F4343A0BDB2F3 (song_id), INDEX IDX_991F4343A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, country_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, email VARCHAR(320) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), INDEX IDX_8D93D649F92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE album ADD CONSTRAINT FK_39986E43B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id)');
        $this->addSql('ALTER TABLE album_comment ADD CONSTRAINT FK_C1A30F7E1137ABCF FOREIGN KEY (album_id) REFERENCES album (id)');
        $this->addSql('ALTER TABLE album_comment ADD CONSTRAINT FK_C1A30F7EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE artist ADD CONSTRAINT FK_1599687F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE artist_artist_tag ADD CONSTRAINT FK_38F3ED4BB7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE artist_artist_tag ADD CONSTRAINT FK_38F3ED4B48D06F6F FOREIGN KEY (artist_tag_id) REFERENCES artist_tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE artist_comment ADD CONSTRAINT FK_233B0C5BB7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id)');
        $this->addSql('ALTER TABLE artist_comment ADD CONSTRAINT FK_233B0C5BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE song ADD CONSTRAINT FK_33EDEEA1B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id)');
        $this->addSql('ALTER TABLE song_comment ADD CONSTRAINT FK_991F4343A0BDB2F3 FOREIGN KEY (song_id) REFERENCES song (id)');
        $this->addSql('ALTER TABLE song_comment ADD CONSTRAINT FK_991F4343A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE album_comment DROP FOREIGN KEY FK_C1A30F7E1137ABCF');
        $this->addSql('ALTER TABLE album DROP FOREIGN KEY FK_39986E43B7970CF8');
        $this->addSql('ALTER TABLE artist_artist_tag DROP FOREIGN KEY FK_38F3ED4BB7970CF8');
        $this->addSql('ALTER TABLE artist_comment DROP FOREIGN KEY FK_233B0C5BB7970CF8');
        $this->addSql('ALTER TABLE song DROP FOREIGN KEY FK_33EDEEA1B7970CF8');
        $this->addSql('ALTER TABLE artist_artist_tag DROP FOREIGN KEY FK_38F3ED4B48D06F6F');
        $this->addSql('ALTER TABLE artist DROP FOREIGN KEY FK_1599687F92F3E70');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F92F3E70');
        $this->addSql('ALTER TABLE song_comment DROP FOREIGN KEY FK_991F4343A0BDB2F3');
        $this->addSql('ALTER TABLE album_comment DROP FOREIGN KEY FK_C1A30F7EA76ED395');
        $this->addSql('ALTER TABLE artist_comment DROP FOREIGN KEY FK_233B0C5BA76ED395');
        $this->addSql('ALTER TABLE song_comment DROP FOREIGN KEY FK_991F4343A76ED395');
        $this->addSql('DROP TABLE album');
        $this->addSql('DROP TABLE album_comment');
        $this->addSql('DROP TABLE artist');
        $this->addSql('DROP TABLE artist_artist_tag');
        $this->addSql('DROP TABLE artist_comment');
        $this->addSql('DROP TABLE artist_tag');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE song');
        $this->addSql('DROP TABLE song_comment');
        $this->addSql('DROP TABLE user');
    }
}
