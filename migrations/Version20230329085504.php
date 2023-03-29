<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230329085504 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pdf DROP FOREIGN KEY FK_EF0DB8CA4AEAFEA');
        $this->addSql('DROP INDEX IDX_EF0DB8CA4AEAFEA ON pdf');
        $this->addSql('ALTER TABLE pdf DROP entreprise_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pdf ADD entreprise_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pdf ADD CONSTRAINT FK_EF0DB8CA4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_EF0DB8CA4AEAFEA ON pdf (entreprise_id)');
    }
}
