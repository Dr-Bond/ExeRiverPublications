<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190415111143 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, payment_made_by_id INT NOT NULL, book_id INT NOT NULL, paid_on DATETIME NOT NULL, amount DOUBLE PRECISION NOT NULL, payment_type VARCHAR(255) NOT NULL, INDEX IDX_6D28840DA54F53BC (payment_made_by_id), INDEX IDX_6D28840D16A2B381 (book_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DA54F53BC FOREIGN KEY (payment_made_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D16A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE book DROP payment_amount, DROP paid_on');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE payment');
        $this->addSql('ALTER TABLE book ADD payment_amount DOUBLE PRECISION DEFAULT NULL, ADD paid_on DATETIME DEFAULT NULL');
    }
}
