<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180802063038 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE File ADD dispositionMimeType VARCHAR(255) NOT NULL, ADD dispositionFilename VARCHAR(255) NOT NULL, DROP mimeType, DROP extension, DROP data, DROP filename, ADD filename VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE File ADD mimeType VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD extension VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD data LONGBLOB NOT NULL, DROP dispositionMimeType, DROP dispositionFilename, DROP filename, ADD filename VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
