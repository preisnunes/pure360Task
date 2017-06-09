<?php

namespace pureTask;

use Predis\Client as RedisClient;
use \pureTask\Mysql as Mysql;

class CountryIpData{

    /**
     * Start ip string
     * @var string
     */
    protected $ipStart;

    /**
     * End ip string
     * @var string
     */
    protected $ipEnd;

    /**
     * Longitude id
     * @var int
     */
    protected $ipIntStart;

    /**
     * Latitude Id
     * @int
     */
    protected $ipIntEnd;

    /**
     * Country Code
     * @var string
     */
    protected $countryCode;

    /**
     * Country name
     * @var string
     */
    protected $country;

    /**
     * Table name that keep countries ip data
     * @var string
     */
    public static $tableName = 'ipcountry';

    /**
     * Table columns order
     * @var array
     */
    protected static $columns = ['ip_start', 'ip_end', 'ip_int_start', 'ip_int_end', 'country_code','country' ];

    /**
     * Set ipStart
     * @param $ipStart
     */
    public function setIpStart($ipStart){
        $this->ipStart = (string)$ipStart;
    }

    /**
     * Get ipStart
     * @return string
     */
    public function getIpStart(){
        return $this->ipStart;
    }

    /**
     * Set ipEnd
     * @param string $ipEnd
     */
    public function setIpEnd($ipEnd){
        $this->ipEnd = (string)$ipEnd;
    }

    /**
     * Get ip end
     * @return string
     */
    public function getIpEnd(){
        return $this->ipEnd;
    }

    /**
     * Set ip start representation as int
     * @param int $longitudeId
     */
    public function setIpIntStart($ipIntStart){
        $this->ipIntStart = (int)$ipIntStart;
    }

    /**
     * Get ip start representation as int
     * @return int
     */
    public function getIpIntStart(){
        return $this->ipIntStart;
    }

    /**
     * Set latitude id
     * @param int $latitudeId
     */
    public function setIpIntEnd($ipIntEnd){
        $this->ipIntEnd = (int)$ipIntEnd;
    }

    /**
     * Get latitude id
     * @return int
     */
    public function getIpIntEnd(){
        return $this->ipIntEnd;
    }

    /**
     * Set country code
     * @param $countryCode
     */
    public function setCountryCode($countryCode){
        $this->countryCode = (string)$countryCode;
    }

    /**
     * Get country code
     * @return string
     */
    public function getCountryCode(){
        return $this->countryCode;
    }

    /**
     * Set country
     * @param $country
     */
    public function setCountry($country){
        $this->country = (string)$country;
    }

    /**
     * Get country
     * @return string
     */
    public function getCountry(){
        return $this->country;
    }

    public function __construct($ipStart, $ipEnd, $ipIntStart, $ipIntEnd, $countryCode, $country){

        $this->setIpStart($ipStart);
        $this->setIpEnd($ipEnd);
        $this->setIpIntStart($ipIntStart);
        $this->setIpIntEnd($ipIntEnd);
        $this->setCountryCode($countryCode);
        $this->setCountry($country);
    }

    /**
     * Get array with columns and its values combined
     * @return array
     */
    public function getColumns(){

        $values = [
            $this->getIpStart(),
            $this->getIpEnd(),
            $this->getIpIntStart(),
            $this->getIpIntEnd(),
            $this->getCountryCode(),
            $this->getCountry()
        ];

        return array_combine(static::$columns, $values);
    }

    /**
     * Returns class name to be used on csv imports for instance
     * @return string
     */
    public static function getClassName(){
        return __CLASS__;
    }

    /**
     * Insert Country ip into table
     */
    public function insert(){

        $registerToInsert = $this->getColumns();

        $insert = Mysql::getInstance()->insert(array_keys($registerToInsert))
                            ->into(static::$tableName)
                            ->values(array_values($registerToInsert));

        $insert->execute();

    }




}