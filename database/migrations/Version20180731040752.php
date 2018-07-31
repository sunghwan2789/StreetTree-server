<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180731040752 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE RootImage (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, hash_crc32 VARCHAR(255) NOT NULL, createdAt DATETIME NOT NULL, size INT NOT NULL, data LONGBLOB NOT NULL, INDEX IDX_9CF560D4F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE RootImage ADD CONSTRAINT FK_9CF560D4F675F31B FOREIGN KEY (author_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE Measure ADD rootImage_id INT DEFAULT NULL, DROP picture');
        $this->addSql('ALTER TABLE Measure ADD CONSTRAINT FK_4FBA20B95CDAEE8C FOREIGN KEY (rootImage_id) REFERENCES RootImage (id)');
        $this->addSql('CREATE INDEX IDX_4FBA20B95CDAEE8C ON Measure (rootImage_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Measure DROP FOREIGN KEY FK_4FBA20B95CDAEE8C');
        $this->addSql('DROP TABLE RootImage');
        $this->addSql('DROP INDEX IDX_4FBA20B95CDAEE8C ON Measure');
        $this->addSql('ALTER TABLE Measure ADD picture LONGBLOB DEFAULT NULL, DROP rootImage_id');
    }
}
