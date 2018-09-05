<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180905114109 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Measure ADD plate_id VARCHAR(255) DEFAULT NULL, DROP plateName');
        $this->addSql('ALTER TABLE Measure ADD CONSTRAINT FK_4FBA20B9DF66E98B FOREIGN KEY (plate_id) REFERENCES Plate (id)');
        $this->addSql('CREATE INDEX IDX_4FBA20B9DF66E98B ON Measure (plate_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Measure DROP FOREIGN KEY FK_4FBA20B9DF66E98B');
        $this->addSql('DROP INDEX IDX_4FBA20B9DF66E98B ON Measure');
        $this->addSql('ALTER TABLE Measure ADD plateName LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, DROP plate_id');
    }
}
