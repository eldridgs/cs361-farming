<?php

    /* Turn on error reporting */
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    /* test driver */
    require_once(dirname(__FILE__) . '/../simpletest/autorun.php');

    /* web page test driver */
    require_once(dirname(__FILE__) . '/../simpletest/web_tester.php');
    require_once(dirname(__FILE__) . '/../simpletest/reporter.php');

    class TestAvas extends WebTestCase{

        /* optional constructor to name the test */
		function __construct() {
			//parent::__construct('Testing ...');
		}

        /* optional test setup */
		function setUp() {
			//set precondition
			$this->get('http://web.engr.oregonstate.edu/~ratlifri/farming/test/avas.php');
			/* $this->showRequest(); */
			/* $this->showHeaders(); */
			/* $this->showSource(); */
		}

        /* optional test clean up */
		function tearDown() {
			//delete temp file
		}

        /* optional helper method - name must NOT start with test */
		function getSomething() {
			//things for tests
		}

        /* one or more test functions - name must start with test */
		function testSomething() {
			$this->assertResponse(200);
			$this->assertNoText('<table>');
			$this->assertText('Plant Data');
			$this->assertText('Plant ID');
			$this->assertText('Plant Name');
			$this->assertText('Sun level');
		}

	}

$test = new TestAvas();
$test->run(new HtmlReporter());

?>
