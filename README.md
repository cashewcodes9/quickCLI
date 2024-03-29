
![quick-cli-xml-parser.png](quick-cli-xml-parser.png)

<h2><center> Quick-cli xml parser</center></h2>
<h4> <center> A simple command line tool to parse xml files and save into a database of your choice (sqlite, mysql, postgres, mongodb). </center></h4>

## Documentation

You can follow these steps to get started with the project.

#### Clone the repository
    
    git clone git@github.com:cashewcodes9/quickCLI.git

#### Install the dependencies

        composer install

#### Create a `.env` file

        cp .env.example .env

#### Run migrations

        php artisan migrate

#### Run the command
<p> The first argument of the command is path to the xml file. There is an option to select the database you want to save your xml data in. The default database is <b>sqlite</b> </p>

        php quick-cli parse:xml <path-to-xml-file> --db=<database-name>
<p> If you are using <b>sqlite</b> database, you can run</p>

        php quick-cli parse:xml <path-to-xml-file>

#### Run the tests
<p>A php testing framework <b>Pest</b> is being used to test the application. To run the tests, run the following command: </p>

        ./vendor/bin/phpunit

#### PhpStan static analysis
<p> PhpStan is a static analysis tool that helps to find bugs in the code. To run the static analysis, run the following command: </p>

        vendor/bin/phpstan analyse app config database tests --memory-limit 500M


## Help
<p> You can list all the available commands with: </p>
    
            php quick-cli list

## Screenshots

#### Run command to save feed.xml into sqlite database

![quick-cli-demo.png](storage%2Fimages%2Fquick-cli-demo.png)

#### Database overview
![database-screenshot.png](storage%2Fimages%2Fdatabase-screenshot.png)

## License

Laravel Zero is an open-source software licensed under the MIT license.
