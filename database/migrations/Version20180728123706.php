<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180728123706 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '기본 테이블 생성';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE fields (field_seq INT AUTO_INCREMENT NOT NULL, user_seq INT DEFAULT NULL, region_code VARCHAR(50) DEFAULT NULL COMMENT \'지역코드\', field_name LONGTEXT NOT NULL COMMENT \'현장명\', client_name LONGTEXT NOT NULL COMMENT \'발주처\', survery_at LONGTEXT NOT NULL, user_name LONGTEXT DEFAULT NULL, INDEX user_seq (user_seq), PRIMARY KEY(field_seq)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE surveys (survey_seq INT AUTO_INCREMENT NOT NULL, field_seq INT DEFAULT NULL, survey_number INT NOT NULL, plate_name LONGTEXT DEFAULT NULL COMMENT \'보호판?\', tree_number LONGTEXT DEFAULT NULL COMMENT \'수목번호\', is_installed TINYINT(1) NOT NULL, points LONGTEXT NOT NULL, picture LONGBLOB DEFAULT NULL, latitude LONGTEXT NOT NULL, longitude LONGTEXT NOT NULL, INDEX field_seq (field_seq), PRIMARY KEY(survey_seq)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (user_seq INT AUTO_INCREMENT NOT NULL, id VARCHAR(50) NOT NULL, pw VARCHAR(90) NOT NULL, name LONGTEXT NOT NULL, UNIQUE INDEX id (id), PRIMARY KEY(user_seq)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fields ADD CONSTRAINT FK_7EE5E3887D68B0D8 FOREIGN KEY (user_seq) REFERENCES users (user_seq)');
        $this->addSql('ALTER TABLE surveys ADD CONSTRAINT FK_AFA82EA7368F3D4B FOREIGN KEY (field_seq) REFERENCES fields (field_seq)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE surveys DROP FOREIGN KEY FK_AFA82EA7368F3D4B');
        $this->addSql('ALTER TABLE fields DROP FOREIGN KEY FK_7EE5E3887D68B0D8');
        $this->addSql('DROP TABLE fields');
        $this->addSql('DROP TABLE surveys');
        $this->addSql('DROP TABLE users');
    }
}
