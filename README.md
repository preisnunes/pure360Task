# Pure360 Task

This project has the objective to build a simple api that returns the country of a given ip. 
In order to obtain it this app must download a csv from this resource:

http://geolite.maxmind.com/download/geoip/database/GeoIPCountryCSV.zip

The resource that allows the user to get the ip of a country is:
locationByIP?IP=2.17.252.0

### Prerequisites



```
php > 5.6
composer
mysql
```

### Installing

1. composer install
2. Create a mysql database
3. Fill the configs.ini file and phinx.yml with database credentials 
4. vendor/bin/phinx init.
5. vendor/bin/phinx migrate ( create ipcountry table )

From the public directory run the command:
php -S localhost:8080

To pupulate ipcountry table run the following command:

php populateData.php populate url structure -force

This command download from the url a csv file with a certain structure. By default it is used 
path = http://geolite.maxmind.com/download/geoip/database/GeoIPCountryCSV.zip 
structure = ipStart, ipEnd, longitudeId, latitudeId, countryCode, country
force = if true, delete all the registers from the table and populate it again.. If not, only populate if the table is empty.

Example:

php populateData.php populate - default options

## Running the tests

To run the automated test:

The api test checks if an ip from germany returns the expected result 

1. Edit test/api.suite.yml with the server url
2. vendor/bin/codecept bootstrap
3 .vendor/bin/codecept run

## Authors

* **Pedro Nunes**


