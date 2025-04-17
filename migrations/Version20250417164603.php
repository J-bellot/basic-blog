<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250417164603 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B379F37AE5
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B39514AA5C
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_AC6340B379F37AE5 ON `like`
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_AC6340B39514AA5C ON `like`
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `like` ADD user_id INT NOT NULL, ADD post_id INT NOT NULL, DROP id_user_id, DROP id_post_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B34B89032C FOREIGN KEY (post_id) REFERENCES post (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_AC6340B3A76ED395 ON `like` (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_AC6340B34B89032C ON `like` (post_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B3A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B34B89032C
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_AC6340B3A76ED395 ON `like`
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_AC6340B34B89032C ON `like`
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `like` ADD id_user_id INT NOT NULL, ADD id_post_id INT NOT NULL, DROP user_id, DROP post_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B379F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B39514AA5C FOREIGN KEY (id_post_id) REFERENCES post (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_AC6340B379F37AE5 ON `like` (id_user_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_AC6340B39514AA5C ON `like` (id_post_id)
        SQL);
    }
}
