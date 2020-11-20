<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201118140731 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE match_maker (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, player1 VARCHAR(255) NOT NULL, player2 VARCHAR(255) NOT NULL, winner VARCHAR(255) DEFAULT NULL, score_player1 INTEGER DEFAULT NULL, score_player2 INTEGER DEFAULT NULL, status VARCHAR(255) NOT NULL, encounter_date DATE DEFAULT NULL)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE match_maker');
    }
}
