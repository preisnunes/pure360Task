<?php

use Predis\Client as RedisClient;


$structure = ['ipStart', 'ipEnd', 'longitudeId', 'latitudeId', 'countryCode', 'country'];
$csv = new CountryIpCsv('/Users/pedronunes/Documents/Sites/pure360Task/data/GeoIPCountryWhois.csv',$structure,'CountryIpData' );
$csv->loop();


class CountryIpCsv{

    private $csvPath;

    private $structure;

    private $register;

    private $propertiesOrder;

    public function __construct($csvPath, array $structure, $register){

        $this->csvPath = $csvPath;
        $this->structure = $structure;
        $this->register = $register;
        $registerReflection = new ReflectionMethod($register, '__construct');

        foreach( $registerReflection->getParameters() as $parameter ){
            $this->propertiesOrder[] = $parameter->getName();
        }

        var_dump($this->propertiesOrder);


    }

    public function loop(){

        $row = 1;

        if (($handle = fopen($this->csvPath, 'r')) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {

                $csvOrder = array_combine($this->structure, $data);
                $parameters = [];
                foreach( $this->propertiesOrder as $property ){
                    $parameters[] = $csvOrder[$property];
                }

                $entity = (new ReflectionClass( $this->register ))->newInstanceArgs($parameters);

                $entity->insert();

                ++$row;

            }
            fclose($handle);
        }
    }

}




class CountryIpData{

    protected $ipStart;

    protected $ipEnd;

    protected $longitudeId;

    protected $latitudeId;

    protected $countryCode;

    protected $country;

    public function setIpStart($ipStart){
        $this->ipStart = (string)$ipStart;
    }

    public function getIpStart(){
        return $this->ipStart;
    }

    public function setIpEnd($ipEnd){
        $this->ipEnd = (string)$ipEnd;
    }

    public function getIpEnd(){
        return $this->ipEnd;
    }

    public function setLongitudeId($longitudeId){
        $this->longitudeId = (int)$longitudeId;
    }

    public function getLongitudeId(){
        return $this->longitudeId;
    }

    public function setLatitudeId($latitudeId){
        $this->latitudeId = (int)$latitudeId;
    }

    public function getLatitudeId(){
        return $this->latitudeId;
    }

    public function setCountryCode($countryCode){
        $this->countryCode = (string)$countryCode;
    }

    public function getCountryCode(){
        return $this->countryCode;
    }

    public function setCountry($country){
        $this->country = (string)$country;
    }

    public function getCountry(){
        return $this->country;
    }

    public function __construct($ipStart, $ipEnd, $longitudeId, $latitudeId, $countryCode, $country){

        $this->setIpStart($ipStart);
        $this->setIpEnd($ipEnd);
        $this->setLongitudeId($longitudeId);
        $this->setLatitudeId($latitudeId);
        $this->setCountryCode($countryCode);
        $this->setCountry($country);


    }

    public function getColumns(){

        return [
            'ip_start' => $this->getIpStart(),
            'ip_end' => $this->getIpEnd(),
            'longitude_id' => $this->getLongitudeId(),
            'latitude_id' => $this->getLatitudeId(),
            'country_code' => $this->getCountryCode(),
            'country' => $this->getCountry()
        ];
    }

    public function insert(){

        $registerToInsert = $this->getColumns();
        $sql = "INSERT INTO ipcountry (" . implode(',', array_keys($registerToInsert)) . ")
                VALUES( " . implode(',', array_values($registerToInsert)) . " )";
        var_dump($sql);
    }




}