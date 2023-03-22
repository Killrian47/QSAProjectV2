<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230322113115 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE echantillon (id INT AUTO_INCREMENT NOT NULL, entreprise_id INT DEFAULT NULL, number_order_id INT DEFAULT NULL, product_name LONGTEXT DEFAULT NULL, number_lot VARCHAR(255) DEFAULT NULL, fournisseur VARCHAR(255) DEFAULT NULL, conditionnement VARCHAR(255) DEFAULT NULL, temp_product INT DEFAULT NULL, temp_enceinte INT DEFAULT NULL, date_of_manufacturing DATETIME DEFAULT NULL, dlc_dluo DATETIME DEFAULT NULL, date_prelevement DATETIME DEFAULT NULL, INDEX IDX_2C649BE7A4AEAFEA (entreprise_id), INDEX IDX_2C649BE7D8D98C7 (number_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE echantillon ADD CONSTRAINT FK_2C649BE7A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE echantillon ADD CONSTRAINT FK_2C649BE7D8D98C7 FOREIGN KEY (number_order_id) REFERENCES `order` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE echantillon DROP FOREIGN KEY FK_2C649BE7A4AEAFEA');
        $this->addSql('ALTER TABLE echantillon DROP FOREIGN KEY FK_2C649BE7D8D98C7');
        $this->addSql('DROP TABLE echantillon');
    }
}
