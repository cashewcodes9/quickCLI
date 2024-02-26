<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use SimpleXMLElement;
use Tests\TestCase;


class XmlParserCommandTest extends TestCase
{
    use DatabaseMigrations;
    private $emptyXmlFile = 'empty.xml';

    private $exampleXmlFile = 'example.xml';

    private $testXmlFile = 'test.xml';
    private $testXmlContent =
    '<?xml version="1.0" encoding="utf-8"?>
        <catalog>
            <item>
                <entity_id>340</entity_id>
                <CategoryName><![CDATA[Green Mountain Ground Coffee]]></CategoryName>
                <sku>20</sku>
                <name><![CDATA[Green Mountain Coffee French Roast Ground Coffee 24 2.2oz Bag]]></name>
                <description></description>
                <shortdesc><![CDATA[Green Mountain Coffee French Roast Ground Coffee 24 2.2oz Bag steeps cup after cup of smoky-sweet, complex dark roast coffee from Green Mountain Ground Coffee.]]></shortdesc>
                <price>41.6000</price>
                <link>http://www.coffeeforless.com/green-mountain-coffee-french-roast-ground-coffee-24-2-2oz-bag.html</link>
                <image>http://mcdn.coffeeforless.com/media/catalog/product/images/uploads/intro/frac_box.jpg</image>
                <Brand><![CDATA[Green Mountain Coffee]]></Brand>
                <Rating>0</Rating>
                <CaffeineType>Caffeinated</CaffeineType>
                <Count>24</Count>
                <Flavored>No</Flavored>
                <Seasonal>No</Seasonal>
                <Instock>Yes</Instock>
                <Facebook>1</Facebook>
                <IsKCup>0</IsKCup>
            </item>
        </catalog>';

    //private $xmlPath = '/tests/temp/';
    public function __construct(string $name)
    {
        parent::__construct($name);
    }

    /**
     * @throws \Exception
     */
    protected function setUp(): void
    {
        parent::setUp();
        shell_exec("touch " . $this->emptyXmlFile);
        shell_exec("touch " . $this->exampleXmlFile);
        shell_exec("touch " . $this->testXmlFile);
        $testXmlFile = new SimpleXMLElement($this->testXmlContent);
        $testXmlFile->asXML($this->testXmlFile);
    }

    /**
     * Tear down the test environment.
     * @return void
     */
    protected function tearDown(): void
    {
        parent::tearDown();
        shell_exec("rm " . $this->emptyXmlFile);
        shell_exec("rm " . $this->exampleXmlFile);
        shell_exec("rm " . $this->testXmlFile);
    }

    /**
     * Text the xml parser command with a non-existing xml file.
     *
     * @return void
     */
    public function testXmlParserCommandWithNonExistingXmlFile()
    {
        $this->artisan('parse:xml nonexistent.xml --db=sqlite')
            ->expectsOutput('Welcome to the XML Parser Command')
            ->expectsOutputToContain("failed to load external entity \"nonexistent.xml\"")
            ->expectsOutput('Please check the error log for more details and try again.');
    }

    /**
     * Test the xml parser command with an empty xml file.
     *
     * @return void
     */
    public function testXmlParserCommandWithEmptyXmlFile()
    {
        $this->artisan('parse:xml empty.xml --db=sqlite')
            ->expectsOutput('Welcome to the XML Parser Command')
            ->expectsOutputToContain('simplexml_load_file(): empty.xml:1: parser error : Document is empty')
            ->expectsOutput('Please check the error log for more details and try again.');
    }

    // Test that the xml file is invalid (structure, etc.)

    // Test that the database type is invalid.
    public function testTheDatabaseTypeIsInvalid()
    {
        $this->artisan('parse:xml example.xml --db=mongodb')
            ->expectsOutput('Welcome to the XML Parser Command')
            ->expectsOutput('Checking database type...')
            ->expectsOutputToContain('Invalid database type. Please use --db option to specify a valid database type.')
            ->expectsOutput('Please check the error log for more details and try again.');
    }

    // Test with a valid example xml file.

    public function testWithValidExampleXmlFile()
    {
        $this->artisan('parse:xml test.xml --db=sqlite')
            ->expectsOutput('Welcome to the XML Parser Command')
            ->expectsOutputToContain('You are about to parse the following xml file: test.xml')
            ->expectsOutputToContain('Checking database type...')
            ->expectsOutputToContain('Valid database type. Database type')
            ->expectsOutputToContain('The parsing of your data is about to start. Please wait...')
            ->expectsOutputToContain('Data parsing is complete. Saving data to database...')
            ->expectsOutputToContain('Congratulations. Data has been successfully saved to the database.');

        $testProductArray = [
            'id' => 340,
            'category' => 'Green Mountain Ground Coffee',
            'sku' => 20,
            'name' => 'Green Mountain Coffee French Roast Ground Coffee 24 2.2oz Bag',
            'description' => '',
            'short_description' => 'Green Mountain Coffee French Roast Ground Coffee 24 2.2oz Bag steeps cup after cup of smoky-sweet, complex dark roast coffee from Green Mountain Ground Coffee.',
            'price' => 41.6000,
            'link' => 'http://www.coffeeforless.com/green-mountain-coffee-french-roast-ground-coffee-24-2-2oz-bag.html',
            'image' => 'http://mcdn.coffeeforless.com/media/catalog/product/images/uploads/intro/frac_box.jpg',
            'brand' => 'Green Mountain Coffee',
            'rating' => 0,
            'caffeine_type' => 'Caffeinated',
            'count' => 24,
            'flavored' => 'No',
            'seasonal' => 'No',
            'in_stock' => 'Yes',
            'facebook' => 1,
            'is_k_cup' => 0,
        ];

        //$testProduct = DB::table('products')->where('id', 340)->first();
        //$this->assertEquals(Arr::get($testProduct, 'id'), Arr::get($testProductArray, 'id'));
    }
}
