<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240325053637 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fiftydeg_scripts_script (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, template_event VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fiftydeg_scripts_script_channel (channel_id INT NOT NULL, script_id INT NOT NULL, INDEX IDX_2805E3E172F5A1AA (channel_id), INDEX IDX_2805E3E1A1C01850 (script_id), PRIMARY KEY(channel_id, script_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fiftydeg_scripts_script_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT NOT NULL, content VARCHAR(255) DEFAULT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_29029F4A2C2AC5D3 (translatable_id), UNIQUE INDEX fiftydeg_scripts_script_translation_uniq_trans (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fiftydeg_scripts_script_channel ADD CONSTRAINT FK_2805E3E172F5A1AA FOREIGN KEY (channel_id) REFERENCES fiftydeg_scripts_script (id)');
        $this->addSql('ALTER TABLE fiftydeg_scripts_script_channel ADD CONSTRAINT FK_2805E3E1A1C01850 FOREIGN KEY (script_id) REFERENCES sylius_channel (id)');
        $this->addSql('ALTER TABLE fiftydeg_scripts_script_translation ADD CONSTRAINT FK_29029F4A2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES fiftydeg_scripts_script (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fiftydeg_scripts_script_channel DROP FOREIGN KEY FK_2805E3E172F5A1AA');
        $this->addSql('ALTER TABLE fiftydeg_scripts_script_channel DROP FOREIGN KEY FK_2805E3E1A1C01850');
        $this->addSql('ALTER TABLE fiftydeg_scripts_script_translation DROP FOREIGN KEY FK_29029F4A2C2AC5D3');
        $this->addSql('DROP TABLE fiftydeg_scripts_script');
        $this->addSql('DROP TABLE fiftydeg_scripts_script_channel');
        $this->addSql('DROP TABLE fiftydeg_scripts_script_translation');
    }
}
