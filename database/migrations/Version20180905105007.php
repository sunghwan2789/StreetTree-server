<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180905105007 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Plate (id VARCHAR(255) NOT NULL, frame_id VARCHAR(255) DEFAULT NULL, width INT NOT NULL, length INT NOT NULL, innerDiameter INT DEFAULT NULL, height INT NOT NULL, INDEX IDX_B05FF85F3FA3C347 (frame_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Frame (id VARCHAR(255) NOT NULL, width INT NOT NULL, length INT NOT NULL, height INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Plate ADD CONSTRAINT FK_B05FF85F3FA3C347 FOREIGN KEY (frame_id) REFERENCES Frame (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Plate DROP FOREIGN KEY FK_B05FF85F3FA3C347');
        $this->addSql('DROP TABLE Plate');
        $this->addSql('DROP TABLE Frame');
    }
}
