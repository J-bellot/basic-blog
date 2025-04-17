<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250417164757 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE dislike (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, post_id INT NOT NULL, INDEX IDX_FE3BECAAA76ED395 (user_id), INDEX IDX_FE3BECAA4B89032C (post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE dislike ADD CONSTRAINT FK_FE3BECAAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE dislike ADD CONSTRAINT FK_FE3BECAA4B89032C FOREIGN KEY (post_id) REFERENCES post (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE dislike DROP FOREIGN KEY FK_FE3BECAAA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE dislike DROP FOREIGN KEY FK_FE3BECAA4B89032C
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE dislike
        SQL);
    }
}
