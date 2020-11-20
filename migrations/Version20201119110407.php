<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201119110407 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE player (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, ratio DOUBLE PRECISION NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_98197A65F85E0677 ON player (username)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__match_maker AS SELECT id, status, encounter_date FROM match_maker');
        $this->addSql('DROP TABLE match_maker');
        $this->addSql('CREATE TABLE match_maker (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, player_a_id INTEGER DEFAULT NULL, player_b_id INTEGER DEFAULT NULL, status VARCHAR(255) NOT NULL COLLATE BINARY, encounter_date DATE DEFAULT NULL, score_player_a DOUBLE PRECISION DEFAULT NULL, score_player_b DOUBLE PRECISION DEFAULT NULL, CONSTRAINT FK_7873001599C4036B FOREIGN KEY (player_a_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_787300158B71AC85 FOREIGN KEY (player_b_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO match_maker (id, status, encounter_date) SELECT id, status, encounter_date FROM __temp__match_maker');
        $this->addSql('DROP TABLE __temp__match_maker');
        $this->addSql('CREATE INDEX IDX_7873001599C4036B ON match_maker (player_a_id)');
        $this->addSql('CREATE INDEX IDX_787300158B71AC85 ON match_maker (player_b_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE player');
        $this->addSql('DROP INDEX IDX_7873001599C4036B');
        $this->addSql('DROP INDEX IDX_787300158B71AC85');
        $this->addSql('CREATE TEMPORARY TABLE __temp__match_maker AS SELECT id, status, encounter_date FROM match_maker');
        $this->addSql('DROP TABLE match_maker');
        $this->addSql('CREATE TABLE match_maker (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, status VARCHAR(255) NOT NULL, encounter_date DATE DEFAULT NULL, player1 VARCHAR(255) NOT NULL COLLATE BINARY, player2 VARCHAR(255) NOT NULL COLLATE BINARY, winner VARCHAR(255) DEFAULT NULL COLLATE BINARY, score_player1 INTEGER DEFAULT NULL, score_player2 INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO match_maker (id, status, encounter_date) SELECT id, status, encounter_date FROM __temp__match_maker');
        $this->addSql('DROP TABLE __temp__match_maker');
    }
}
