<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210909103732 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE artist_artist_tag (artist_id INT NOT NULL, artist_tag_id INT NOT NULL, INDEX IDX_38F3ED4BB7970CF8 (artist_id), INDEX IDX_38F3ED4B48D06F6F (artist_tag_id), PRIMARY KEY(artist_id, artist_tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artist_tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, created_on DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE artist_artist_tag ADD CONSTRAINT FK_38F3ED4BB7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE artist_artist_tag ADD CONSTRAINT FK_38F3ED4B48D06F6F FOREIGN KEY (artist_tag_id) REFERENCES artist_tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE artist ADD CONSTRAINT FK_1599687F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('CREATE INDEX IDX_1599687F92F3E70 ON artist (country_id)');
        $this->addSql('ALTER TABLE country CHANGE iso iso VARCHAR(2) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artist_artist_tag DROP FOREIGN KEY FK_38F3ED4B48D06F6F');
        $this->addSql('DROP TABLE artist_artist_tag');
        $this->addSql('DROP TABLE artist_tag');
        $this->addSql('ALTER TABLE artist DROP FOREIGN KEY FK_1599687F92F3E70');
        $this->addSql('DROP INDEX IDX_1599687F92F3E70 ON artist');
        $this->addSql('ALTER TABLE country CHANGE iso iso VARCHAR(2) CHARACTER SET utf8mb4 DEFAULT \'\' NOT NULL COLLATE `utf8mb4_general_ci`');
    }
}
