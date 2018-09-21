<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180921061136 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Measure ADD attachment_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Measure ADD CONSTRAINT FK_4FBA20B9464E68B FOREIGN KEY (attachment_id) REFERENCES File (id)');
        $this->addSql('CREATE INDEX IDX_4FBA20B9464E68B ON Measure (attachment_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Measure DROP FOREIGN KEY FK_4FBA20B9464E68B');
        $this->addSql('DROP INDEX IDX_4FBA20B9464E68B ON Measure');
        $this->addSql('ALTER TABLE Measure DROP attachment_id');
    }
}
