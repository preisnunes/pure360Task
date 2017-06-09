<?php

use Phinx\Migration\AbstractMigration;

class CreateIpCountryTable extends AbstractMigration
{

    protected $tableName = 'ipcountry';

    public function up()
    {

        if( $this->hasTable($this->tableName) ) {
            return;
        }

        $createSql = "CREATE TABLE IF NOT EXISTS `$this->tableName` (
                  `id` INT(1) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, -- the id just for numeric
                  `ip_start`   VARCHAR(50) COLLATE UTF8_GENERAL_CI NOT NULL, -- the ip start from maxmind data
                  `ip_end`     VARCHAR(50) COLLATE UTF8_GENERAL_CI NOT NULL, -- the ip end of maxmind data
                  `ip_int_start`   INT(1) UNSIGNED ZEROFILL NOT NULL, -- the start of maxmind  ip integer id 
                  `ip_int_end`     INT(1) UNSIGNED ZEROFILL NOT NULL, -- the end of maxmind ip id
                  `country_code`  VARCHAR(4) COLLATE UTF8_GENERAL_CI NOT NULL, -- the country code
                  `country`   VARCHAR(100) COLLATE UTF8_GENERAL_CI NOT NULL, -- the country name
                  PRIMARY KEY( `id`,`ip_start`,`ip_end`)
                ) DEFAULT CHARSET=UTF8 COLLATE=UTF8_GENERAL_CI AUTO_INCREMENT=1 ;";

        $this->execute( $createSql );

    }

    public function down(){

        if( !$this->hasTable($this->tableName) ) {
            return;
        }

        $this->execute( "DROP table $this->tableName" );

    }
}
