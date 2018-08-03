<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180803182223 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE File (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, checksum_crc32 VARCHAR(255) NOT NULL, createdAt DATETIME NOT NULL, size INT NOT NULL, mediaType VARCHAR(255) NOT NULL, originalFilename VARCHAR(255) NOT NULL, filename VARCHAR(255) NOT NULL, INDEX IDX_2CAD992E7E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Measureset (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, siteName LONGTEXT NOT NULL, clientName LONGTEXT NOT NULL, createdAt DATE NOT NULL, INDEX IDX_92AB9E3CF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE User (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(50) NOT NULL, password VARCHAR(90) NOT NULL, fullName LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_2DA17977F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Measure (id INT AUTO_INCREMENT NOT NULL, measureset_id INT DEFAULT NULL, sequenceNumber INT NOT NULL, latitude VARCHAR(255) NOT NULL, longitude VARCHAR(255) NOT NULL, siCode VARCHAR(255) DEFAULT NULL, guCode VARCHAR(255) DEFAULT NULL, dongCode VARCHAR(255) DEFAULT NULL, plateName LONGTEXT DEFAULT NULL, treeNumber LONGTEXT DEFAULT NULL, isInstalled TINYINT(1) NOT NULL, points LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', rootImage_id INT DEFAULT NULL, INDEX IDX_4FBA20B95CDAEE8C (rootImage_id), INDEX IDX_4FBA20B956884F57 (measureset_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE File ADD CONSTRAINT FK_2CAD992E7E3C61F9 FOREIGN KEY (owner_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE Measureset ADD CONSTRAINT FK_92AB9E3CF675F31B FOREIGN KEY (author_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE Measure ADD CONSTRAINT FK_4FBA20B95CDAEE8C FOREIGN KEY (rootImage_id) REFERENCES File (id)');
        $this->addSql('ALTER TABLE Measure ADD CONSTRAINT FK_4FBA20B956884F57 FOREIGN KEY (measureset_id) REFERENCES Measureset (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Measure DROP FOREIGN KEY FK_4FBA20B95CDAEE8C');
        $this->addSql('ALTER TABLE Measure DROP FOREIGN KEY FK_4FBA20B956884F57');
        $this->addSql('ALTER TABLE File DROP FOREIGN KEY FK_2CAD992E7E3C61F9');
        $this->addSql('ALTER TABLE Measureset DROP FOREIGN KEY FK_92AB9E3CF675F31B');
        $this->addSql('DROP TABLE File');
        $this->addSql('DROP TABLE Measureset');
        $this->addSql('DROP TABLE User');
        $this->addSql('DROP TABLE Measure');
    }
}
