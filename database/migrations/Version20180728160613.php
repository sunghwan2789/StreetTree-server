<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180728160613 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Measure (id INT AUTO_INCREMENT NOT NULL, metadata_id INT DEFAULT NULL, sequenceNumber INT NOT NULL, latitude VARCHAR(255) NOT NULL, longitude VARCHAR(255) NOT NULL, plateName LONGTEXT DEFAULT NULL, treeNumber LONGTEXT DEFAULT NULL, isInstalled TINYINT(1) NOT NULL, points LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', picture LONGBLOB DEFAULT NULL, INDEX IDX_4FBA20B9DC9EE959 (metadata_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE MeasureMetadata (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, siteRegionCode VARCHAR(50) DEFAULT NULL, siteName LONGTEXT NOT NULL, clientName LONGTEXT NOT NULL, createdAt DATE NOT NULL, authorFullName LONGTEXT NOT NULL, INDEX IDX_D1945DD9F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE User (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(50) NOT NULL, password VARCHAR(90) NOT NULL, fullName LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_2DA17977F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Measure ADD CONSTRAINT FK_4FBA20B9DC9EE959 FOREIGN KEY (metadata_id) REFERENCES MeasureMetadata (id)');
        $this->addSql('ALTER TABLE MeasureMetadata ADD CONSTRAINT FK_D1945DD9F675F31B FOREIGN KEY (author_id) REFERENCES User (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Measure DROP FOREIGN KEY FK_4FBA20B9DC9EE959');
        $this->addSql('ALTER TABLE MeasureMetadata DROP FOREIGN KEY FK_D1945DD9F675F31B');
        $this->addSql('DROP TABLE Measure');
        $this->addSql('DROP TABLE MeasureMetadata');
        $this->addSql('DROP TABLE User');
    }
}
