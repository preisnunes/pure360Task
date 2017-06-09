<?php

namespace pureTask;

use pureTask\CountryIpData as CountryIpData;

class CountryIpCsv{

    /**
     * Csv filesystem path
     * @var
     */
    private $csvPath;

    /**
     * Csv structure
     * @var array
     */
    private $structure = [
        'ipStart',
        'ipEnd',
        'ipIntStart',
        'ipIntEnd',
        'countryCode',
        'country'
    ];

    /**
     * Register Instance
     * @CountryIpData
     */
    private $register;

    /**
     * Keeps the mysql table columns order
     * @var
     */
    private $propertiesOrder;

    /**
     * CountryIpCsv constructor. Takes from the register instance the mysql table columns order
     * @param $csvPath
     * @param array $structure
     * @param $register
     */
    public function __construct($csvPath, $register, array $structure = []){

        $this->csvPath = $csvPath;
        $this->setStructure($structure);
        $this->register = $register;

        $registerReflection = new \ReflectionMethod($register, '__construct');

        foreach( $registerReflection->getParameters() as $parameter ){
            $this->propertiesOrder[] = $parameter->getName();
        }

    }

    /**
     * Set csv structure. id the array passed to the constructor is empty assume that
     * structure initilized upper is the valid one
     * @param array $structure
     */
    public function setStructure( $structure = []){
        if( !empty($structure)){
            $this->structure = $structure;
        }
    }

    /**
     * Loops on csv. At the core combines the data of each row with the structure given at the constructor.
     * Then loops on propertiesOrder variable to creates an array with ordered parameters to create the entity class
     */
    public function loop(){

        $row = 1;

        if (($handle = fopen($this->csvPath, 'r')) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {

                $csvOrder = array_combine($this->structure, $data);
                $parameters = [];

                foreach( $this->propertiesOrder as $property ){
                    $parameters[] = $csvOrder[$property];
                }

                $entity = (new \ReflectionClass( $this->register ))->newInstanceArgs($parameters);
                $entity->insert();

                ++$row;

            }
            fclose($handle);
        }
    }

}