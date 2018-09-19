<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180919020437 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Plate ADD attachment_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Plate ADD CONSTRAINT FK_B05FF85F464E68B FOREIGN KEY (attachment_id) REFERENCES File (id)');
        $this->addSql('CREATE INDEX IDX_B05FF85F464E68B ON Plate (attachment_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Plate DROP FOREIGN KEY FK_B05FF85F464E68B');
        $this->addSql('DROP INDEX IDX_B05FF85F464E68B ON Plate');
        $this->addSql('ALTER TABLE Plate DROP attachment_id');
    }
}
