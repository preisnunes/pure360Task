<?php

namespace pureTask\Command;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Exception\LogicException;
use pureTask\Mysql;
use pureTask\CountryIpCsv;
use pureTask\CountryIpData;

class PopulateCountriesIp extends Command
{

    protected function configure()
    {
        $this->setName('populate');
        $this->setDescription('Populates the database with maxmind countries ip data');

        $this->addArgument('url', InputArgument::OPTIONAL, 'Url path to download the csv');
        $this->addArgument('structure', InputArgument::IS_ARRAY | InputArgument::OPTIONAL, 'Csv structure: columns order');
        $this->addOption('force', 'f', InputOption::VALUE_OPTIONAL, 'Force the table populate', 'false');
    }

    /**
     * This function contains all the logic to the command that populates the countries ip data
     * 1. If force is true, drop the table and back to populate it
     * 2. If force is false, checks if the table is empty, if so back to populate it
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $url = $input->getArgument('url');
        $structure = $input->getArgument('structure');
        $force = $input->getOption('force') == 'true' ? true: false;
        $table = CountryIpData::$tableName;

        try {

            if (!$force) {

                $query = Mysql::getInstance()->prepare("SELECT COUNT(*) as count FROM $table");
                $query->execute();
                $count = $query->fetch(\PDO::FETCH_OBJ);

                if ( !empty( $count->count) ){
                    throw new LogicException('The table is already populates');
                }

            }
            else{
                $query = Mysql::getInstance()->prepare("DELETE FROM $table");
                if( !$query->execute() ){
                    throw new Exception("Error on dropping $table table");
                }

                $output->writeln("Dropping $table table is finished");

            }

            $archivePath = downloadFile($url);
            $csvPath = unzipFile($archivePath);

            $csv = new CountryIpCsv($csvPath,CountryIpData::getClassName(), $structure);
            $csv->loop();
            $output->writeln("$table table is populated");

        }
        catch( Exception $e ){
            $output->writeln($e->getMessage());
        }

    }
}