<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140826124335 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $table = $schema->createTable('weather_town');
        $table->addColumn('id', 'integer', array('autoincrement' => true));
        $table->addColumn('town', 'string', array('notnull' => true));
        $table->setPrimaryKey(array('id'));

        $table = $schema->createTable('weather_forecast_history');
        $table->addColumn('id', 'integer', array('autoincrement' => true));
        $table->addColumn('town_id', 'integer');
        $table->addColumn('duration', 'integer', array('notnull' => true));
        $table->addColumn('comment', 'text', array('length' => 10000, 'notnull' => false));
        $table->addColumn('date', 'datetime', array('notnull' => true));
        $table->setPrimaryKey(array('id'));

        $schema->getTable('weather_forecast_history')
            ->addForeignKeyConstraint('weather_town', array('town_id'), array('id'));
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('weather_town');
        $schema->dropTable('weather_forecast_history');
    }
}
