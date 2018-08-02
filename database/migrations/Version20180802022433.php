<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180802022433 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Measure DROP FOREIGN KEY FK_4FBA20B95CDAEE8C');
        $this->addSql('CREATE TABLE File (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, hash_crc32 VARCHAR(255) NOT NULL, createdAt DATETIME NOT NULL, size INT NOT NULL, mimeType VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, filename VARCHAR(255) DEFAULT NULL, data LONGBLOB NOT NULL, INDEX IDX_2CAD992E7E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE File ADD CONSTRAINT FK_2CAD992E7E3C61F9 FOREIGN KEY (owner_id) REFERENCES User (id)');
        $this->addSql('DROP TABLE RootImage');
        $this->addSql('ALTER TABLE Measure ADD CONSTRAINT FK_4FBA20B95CDAEE8C FOREIGN KEY (rootImage_id) REFERENCES File (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Measure DROP FOREIGN KEY FK_4FBA20B95CDAEE8C');
        $this->addSql('CREATE TABLE RootImage (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, hash_crc32 VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, createdAt DATETIME NOT NULL, size INT NOT NULL, data LONGBLOB NOT NULL, INDEX IDX_9CF560D4F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE RootImage ADD CONSTRAINT FK_9CF560D4F675F31B FOREIGN KEY (author_id) REFERENCES User (id)');
        $this->addSql('DROP TABLE File');
        $this->addSql('ALTER TABLE Measure ADD CONSTRAINT FK_4FBA20B95CDAEE8C FOREIGN KEY (rootImage_id) REFERENCES RootImage (id)');
    }
}
