<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180905013539 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Measureset ADD salespersonName LONGTEXT NOT NULL, ADD deliveryTarget LONGTEXT NOT NULL, ADD deliveryDate DATE NOT NULL, ADD differenceValue INT NOT NULL');
        $this->addSql('ALTER TABLE Measure ADD treeLocation VARCHAR(255) DEFAULT NULL, ADD memo VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Measure DROP treeLocation, DROP memo');
        $this->addSql('ALTER TABLE Measureset DROP salespersonName, DROP deliveryTarget, DROP deliveryDate, DROP differenceValue');
    }
}
