<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240112123730 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE console_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE developer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE publisher_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE video_game_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE console (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE developer (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE publisher (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE video_game (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE video_game_console (video_game_id INT NOT NULL, console_id INT NOT NULL, PRIMARY KEY(video_game_id, console_id))');
        $this->addSql('CREATE INDEX IDX_232A15616230A8 ON video_game_console (video_game_id)');
        $this->addSql('CREATE INDEX IDX_232A15672F9DD9F ON video_game_console (console_id)');
        $this->addSql('CREATE TABLE video_game_developer (video_game_id INT NOT NULL, developer_id INT NOT NULL, PRIMARY KEY(video_game_id, developer_id))');
        $this->addSql('CREATE INDEX IDX_918F001816230A8 ON video_game_developer (video_game_id)');
        $this->addSql('CREATE INDEX IDX_918F001864DD9267 ON video_game_developer (developer_id)');
        $this->addSql('CREATE TABLE video_game_publisher (video_game_id INT NOT NULL, publisher_id INT NOT NULL, PRIMARY KEY(video_game_id, publisher_id))');
        $this->addSql('CREATE INDEX IDX_689C5EC416230A8 ON video_game_publisher (video_game_id)');
        $this->addSql('CREATE INDEX IDX_689C5EC440C86FCE ON video_game_publisher (publisher_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE video_game_console ADD CONSTRAINT FK_232A15616230A8 FOREIGN KEY (video_game_id) REFERENCES video_game (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE video_game_console ADD CONSTRAINT FK_232A15672F9DD9F FOREIGN KEY (console_id) REFERENCES console (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE video_game_developer ADD CONSTRAINT FK_918F001816230A8 FOREIGN KEY (video_game_id) REFERENCES video_game (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE video_game_developer ADD CONSTRAINT FK_918F001864DD9267 FOREIGN KEY (developer_id) REFERENCES developer (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE video_game_publisher ADD CONSTRAINT FK_689C5EC416230A8 FOREIGN KEY (video_game_id) REFERENCES video_game (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE video_game_publisher ADD CONSTRAINT FK_689C5EC440C86FCE FOREIGN KEY (publisher_id) REFERENCES publisher (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE console_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE developer_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE publisher_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE video_game_id_seq CASCADE');
        $this->addSql('ALTER TABLE video_game_console DROP CONSTRAINT FK_232A15616230A8');
        $this->addSql('ALTER TABLE video_game_console DROP CONSTRAINT FK_232A15672F9DD9F');
        $this->addSql('ALTER TABLE video_game_developer DROP CONSTRAINT FK_918F001816230A8');
        $this->addSql('ALTER TABLE video_game_developer DROP CONSTRAINT FK_918F001864DD9267');
        $this->addSql('ALTER TABLE video_game_publisher DROP CONSTRAINT FK_689C5EC416230A8');
        $this->addSql('ALTER TABLE video_game_publisher DROP CONSTRAINT FK_689C5EC440C86FCE');
        $this->addSql('DROP TABLE console');
        $this->addSql('DROP TABLE developer');
        $this->addSql('DROP TABLE publisher');
        $this->addSql('DROP TABLE video_game');
        $this->addSql('DROP TABLE video_game_console');
        $this->addSql('DROP TABLE video_game_developer');
        $this->addSql('DROP TABLE video_game_publisher');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
