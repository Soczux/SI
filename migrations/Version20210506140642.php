<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210506140642 extends AbstractMigration
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
        $this->addSql('CREATE TABLE album_reaction (album_id INT NOT NULL, user_id INT NOT NULL, reaction_id INT NOT NULL, INDEX IDX_573BA1E21137ABCF (album_id), INDEX IDX_573BA1E2A76ED395 (user_id), INDEX IDX_573BA1E2813C7171 (reaction_id), PRIMARY KEY(album_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artist (id INT AUTO_INCREMENT NOT NULL, country_id INT NOT NULL, name VARCHAR(100) NOT NULL, INDEX IDX_1599687F92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artist_comment (id INT AUTO_INCREMENT NOT NULL, artist_id INT NOT NULL, user_id INT DEFAULT NULL, content VARCHAR(1000) NOT NULL, commented_on DATETIME NOT NULL, INDEX IDX_233B0C5BB7970CF8 (artist_id), INDEX IDX_233B0C5BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artist_reaction (artist_id INT NOT NULL, user_id INT NOT NULL, reaction_id INT NOT NULL, INDEX IDX_1CDDEDA6B7970CF8 (artist_id), INDEX IDX_1CDDEDA6A76ED395 (user_id), INDEX IDX_1CDDEDA6813C7171 (reaction_id), PRIMARY KEY(artist_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(80) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE playlist (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, INDEX IDX_D782112DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE playlist_song (playlist_id INT NOT NULL, song_id INT NOT NULL, INDEX IDX_93F4D9C36BBD148 (playlist_id), INDEX IDX_93F4D9C3A0BDB2F3 (song_id), PRIMARY KEY(playlist_id, song_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reaction (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE song (id INT AUTO_INCREMENT NOT NULL, artist_id INT NOT NULL, title VARCHAR(100) NOT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_33EDEEA1B7970CF8 (artist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE song_comment (id INT AUTO_INCREMENT NOT NULL, song_id INT NOT NULL, user_id INT DEFAULT NULL, content VARCHAR(1000) NOT NULL, commented_on DATETIME NOT NULL, INDEX IDX_991F4343A0BDB2F3 (song_id), INDEX IDX_991F4343A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE song_reaction (song_id INT NOT NULL, user_id INT NOT NULL, reaction_id INT NOT NULL, INDEX IDX_F0B51BFA0BDB2F3 (song_id), INDEX IDX_F0B51BFA76ED395 (user_id), INDEX IDX_F0B51BF813C7171 (reaction_id), PRIMARY KEY(song_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, country_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, email VARCHAR(320) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), INDEX IDX_8D93D649F92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE album ADD CONSTRAINT FK_39986E43B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id)');
        $this->addSql('ALTER TABLE album_comment ADD CONSTRAINT FK_C1A30F7E1137ABCF FOREIGN KEY (album_id) REFERENCES album (id)');
        $this->addSql('ALTER TABLE album_comment ADD CONSTRAINT FK_C1A30F7EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE album_reaction ADD CONSTRAINT FK_573BA1E21137ABCF FOREIGN KEY (album_id) REFERENCES album (id)');
        $this->addSql('ALTER TABLE album_reaction ADD CONSTRAINT FK_573BA1E2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE album_reaction ADD CONSTRAINT FK_573BA1E2813C7171 FOREIGN KEY (reaction_id) REFERENCES reaction (id)');
        $this->addSql('ALTER TABLE artist ADD CONSTRAINT FK_1599687F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE artist_comment ADD CONSTRAINT FK_233B0C5BB7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id)');
        $this->addSql('ALTER TABLE artist_comment ADD CONSTRAINT FK_233B0C5BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE artist_reaction ADD CONSTRAINT FK_1CDDEDA6B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id)');
        $this->addSql('ALTER TABLE artist_reaction ADD CONSTRAINT FK_1CDDEDA6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE artist_reaction ADD CONSTRAINT FK_1CDDEDA6813C7171 FOREIGN KEY (reaction_id) REFERENCES reaction (id)');
        $this->addSql('ALTER TABLE playlist ADD CONSTRAINT FK_D782112DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE playlist_song ADD CONSTRAINT FK_93F4D9C36BBD148 FOREIGN KEY (playlist_id) REFERENCES playlist (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE playlist_song ADD CONSTRAINT FK_93F4D9C3A0BDB2F3 FOREIGN KEY (song_id) REFERENCES song (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE song ADD CONSTRAINT FK_33EDEEA1B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id)');
        $this->addSql('ALTER TABLE song_comment ADD CONSTRAINT FK_991F4343A0BDB2F3 FOREIGN KEY (song_id) REFERENCES song (id)');
        $this->addSql('ALTER TABLE song_comment ADD CONSTRAINT FK_991F4343A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE song_reaction ADD CONSTRAINT FK_F0B51BFA0BDB2F3 FOREIGN KEY (song_id) REFERENCES song (id)');
        $this->addSql('ALTER TABLE song_reaction ADD CONSTRAINT FK_F0B51BFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE song_reaction ADD CONSTRAINT FK_F0B51BF813C7171 FOREIGN KEY (reaction_id) REFERENCES reaction (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE album_comment DROP FOREIGN KEY FK_C1A30F7E1137ABCF');
        $this->addSql('ALTER TABLE album_reaction DROP FOREIGN KEY FK_573BA1E21137ABCF');
        $this->addSql('ALTER TABLE album DROP FOREIGN KEY FK_39986E43B7970CF8');
        $this->addSql('ALTER TABLE artist_comment DROP FOREIGN KEY FK_233B0C5BB7970CF8');
        $this->addSql('ALTER TABLE artist_reaction DROP FOREIGN KEY FK_1CDDEDA6B7970CF8');
        $this->addSql('ALTER TABLE song DROP FOREIGN KEY FK_33EDEEA1B7970CF8');
        $this->addSql('ALTER TABLE artist DROP FOREIGN KEY FK_1599687F92F3E70');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F92F3E70');
        $this->addSql('ALTER TABLE playlist_song DROP FOREIGN KEY FK_93F4D9C36BBD148');
        $this->addSql('ALTER TABLE album_reaction DROP FOREIGN KEY FK_573BA1E2813C7171');
        $this->addSql('ALTER TABLE artist_reaction DROP FOREIGN KEY FK_1CDDEDA6813C7171');
        $this->addSql('ALTER TABLE song_reaction DROP FOREIGN KEY FK_F0B51BF813C7171');
        $this->addSql('ALTER TABLE playlist_song DROP FOREIGN KEY FK_93F4D9C3A0BDB2F3');
        $this->addSql('ALTER TABLE song_comment DROP FOREIGN KEY FK_991F4343A0BDB2F3');
        $this->addSql('ALTER TABLE song_reaction DROP FOREIGN KEY FK_F0B51BFA0BDB2F3');
        $this->addSql('ALTER TABLE album_comment DROP FOREIGN KEY FK_C1A30F7EA76ED395');
        $this->addSql('ALTER TABLE album_reaction DROP FOREIGN KEY FK_573BA1E2A76ED395');
        $this->addSql('ALTER TABLE artist_comment DROP FOREIGN KEY FK_233B0C5BA76ED395');
        $this->addSql('ALTER TABLE artist_reaction DROP FOREIGN KEY FK_1CDDEDA6A76ED395');
        $this->addSql('ALTER TABLE playlist DROP FOREIGN KEY FK_D782112DA76ED395');
        $this->addSql('ALTER TABLE song_comment DROP FOREIGN KEY FK_991F4343A76ED395');
        $this->addSql('ALTER TABLE song_reaction DROP FOREIGN KEY FK_F0B51BFA76ED395');
        $this->addSql('DROP TABLE album');
        $this->addSql('DROP TABLE album_comment');
        $this->addSql('DROP TABLE album_reaction');
        $this->addSql('DROP TABLE artist');
        $this->addSql('DROP TABLE artist_comment');
        $this->addSql('DROP TABLE artist_reaction');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE playlist');
        $this->addSql('DROP TABLE playlist_song');
        $this->addSql('DROP TABLE reaction');
        $this->addSql('DROP TABLE song');
        $this->addSql('DROP TABLE song_comment');
        $this->addSql('DROP TABLE song_reaction');
        $this->addSql('DROP TABLE user');
    }
}
