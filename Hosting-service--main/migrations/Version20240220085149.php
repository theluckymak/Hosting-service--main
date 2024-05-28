<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240220085149 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE pricing_plan_benefit_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE pricing_plan_feature_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE pricing_plans_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE pricing_plan_benefit (id INT NOT NULL, pricing_plans_id INT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E6A62C5FC05A9E03 ON pricing_plan_benefit (pricing_plans_id)');
        $this->addSql('CREATE TABLE pricing_plan_feature (id INT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE pricing_plans (id INT NOT NULL, name VARCHAR(50) NOT NULL, price INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE pricing_plans_pricing_plan_feature (pricing_plans_id INT NOT NULL, pricing_plan_feature_id INT NOT NULL, PRIMARY KEY(pricing_plans_id, pricing_plan_feature_id))');
        $this->addSql('CREATE INDEX IDX_2681093EC05A9E03 ON pricing_plans_pricing_plan_feature (pricing_plans_id)');
        $this->addSql('CREATE INDEX IDX_2681093E6C9002D8 ON pricing_plans_pricing_plan_feature (pricing_plan_feature_id)');
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
        $this->addSql('ALTER TABLE pricing_plan_benefit ADD CONSTRAINT FK_E6A62C5FC05A9E03 FOREIGN KEY (pricing_plans_id) REFERENCES pricing_plans (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE pricing_plans_pricing_plan_feature ADD CONSTRAINT FK_2681093EC05A9E03 FOREIGN KEY (pricing_plans_id) REFERENCES pricing_plans (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE pricing_plans_pricing_plan_feature ADD CONSTRAINT FK_2681093E6C9002D8 FOREIGN KEY (pricing_plan_feature_id) REFERENCES pricing_plan_feature (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');

        $this->addSql("INSERT INTO pricing_plans VALUES(nextval('pricing_plans_id_seq'), 'Free', 0)");
        $this->addSql("INSERT INTO pricing_plans VALUES(nextval('pricing_plans_id_seq'), 'pro', 15)");
        $this->addSql("INSERT INTO pricing_plans VALUES(nextval('pricing_plans_id_seq'), 'Enterprise', 29)");

        $this->addSql("INSERT INTO pricing_plan_benefit VALUES(nextval('pricing_plan_benefit_id_seq'),1, '1 users included')");
        $this->addSql("INSERT INTO pricing_plan_benefit VALUES(nextval('pricing_plan_benefit_id_seq'),1, '2 gb of storage')");
        $this->addSql("INSERT INTO pricing_plan_benefit VALUES(nextval('pricing_plan_benefit_id_seq'),1, ' email support')");
        $this->addSql("INSERT INTO pricing_plan_benefit VALUES(nextval('pricing_plan_benefit_id_seq'),1, 'help center')");

        $this->addSql("INSERT INTO pricing_plan_benefit VALUES(nextval('pricing_plan_benefit_id_seq'),2, '20 users included')");
        $this->addSql("INSERT INTO pricing_plan_benefit VALUES(nextval('pricing_plan_benefit_id_seq'),2, '10 gb of storage')");
        $this->addSql("INSERT INTO pricing_plan_benefit VALUES(nextval('pricing_plan_benefit_id_seq'),2, 'priority email support')");
        $this->addSql("INSERT INTO pricing_plan_benefit VALUES(nextval('pricing_plan_benefit_id_seq'),2, 'help center access')");

        $this->addSql("INSERT INTO pricing_plan_benefit VALUES(nextval('pricing_plan_benefit_id_seq'),3, '30 users included')");
        $this->addSql("INSERT INTO pricing_plan_benefit VALUES(nextval('pricing_plan_benefit_id_seq'),3, '15 gb of storage')");
        $this->addSql("INSERT INTO pricing_plan_benefit VALUES(nextval('pricing_plan_benefit_id_seq'),3, 'phone & email support')");
        $this->addSql("INSERT INTO pricing_plan_benefit VALUES(nextval('pricing_plan_benefit_id_seq'),3, 'help center access')");


        $this->addSql("INSERT INTO pricing_plan_feature VALUES(nextval('pricing_plan_feature_id_seq'), 'Public')");
        $this->addSql("INSERT INTO pricing_plan_feature VALUES(nextval('pricing_plan_feature_id_seq'), 'Private')");
        $this->addSql("INSERT INTO pricing_plan_feature VALUES(nextval('pricing_plan_feature_id_seq'), 'Permissions')");
        $this->addSql("INSERT INTO pricing_plan_feature VALUES(nextval('pricing_plan_feature_id_seq'), 'Sharing')");
        $this->addSql("INSERT INTO pricing_plan_feature VALUES(nextval('pricing_plan_feature_id_seq'), 'Unlimited members')");
        $this->addSql("INSERT INTO pricing_plan_feature VALUES(nextval('pricing_plan_feature_id_seq'), 'Extra security')");

        $this->addSql("INSERT INTO pricing_plans_pricing_plan_feature VALUES(1, 1)");
        $this->addSql("INSERT INTO pricing_plans_pricing_plan_feature VALUES(1, 3)");

        $this->addSql("INSERT INTO pricing_plans_pricing_plan_feature VALUES(2, 1)");
        $this->addSql("INSERT INTO pricing_plans_pricing_plan_feature VALUES(2, 2)");
        $this->addSql("INSERT INTO pricing_plans_pricing_plan_feature VALUES(2, 3)");
        $this->addSql("INSERT INTO pricing_plans_pricing_plan_feature VALUES(2, 4)");
        $this->addSql("INSERT INTO pricing_plans_pricing_plan_feature VALUES(2, 5)");

        $this->addSql("INSERT INTO pricing_plans_pricing_plan_feature VALUES(3, 1)");
        $this->addSql("INSERT INTO pricing_plans_pricing_plan_feature VALUES(3, 2)");
        $this->addSql("INSERT INTO pricing_plans_pricing_plan_feature VALUES(3, 3)");
        $this->addSql("INSERT INTO pricing_plans_pricing_plan_feature VALUES(3, 4)");
        $this->addSql("INSERT INTO pricing_plans_pricing_plan_feature VALUES(3, 5)");
        $this->addSql("INSERT INTO pricing_plans_pricing_plan_feature VALUES(3, 6)");


    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('DROP SEQUENCE pricing_plan_benefit_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE pricing_plan_feature_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE pricing_plans_id_seq CASCADE');
        $this->addSql('ALTER TABLE pricing_plan_benefit DROP CONSTRAINT FK_E6A62C5FC05A9E03');
        $this->addSql('ALTER TABLE pricing_plans_pricing_plan_feature DROP CONSTRAINT FK_2681093EC05A9E03');
        $this->addSql('ALTER TABLE pricing_plans_pricing_plan_feature DROP CONSTRAINT FK_2681093E6C9002D8');
        $this->addSql('DROP TABLE pricing_plan_benefit');
        $this->addSql('DROP TABLE pricing_plan_feature');
        $this->addSql('DROP TABLE pricing_plans');
        $this->addSql('DROP TABLE pricing_plans_pricing_plan_feature');
        $this->addSql('DROP TABLE messenger_messages');


    }
}
