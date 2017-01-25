<?php
/**
 * @package     Joomla.UnitTest
 * @subpackage  Table
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Test class for JTableLanguage.
 * Generated by PHPUnit on 2011-12-06 at 03:29:18.
 *
 * @package     Joomla.UnitTest
 * @subpackage  Table
 * @since       11.1
 */
class JTableLanguageTest extends TestCaseDatabase
{
	/**
	 * @var  JTableLanguage
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @return void
	 */
	protected function setUp()
	{
		parent::setUp();

		// Get the mocks
		$this->saveFactoryState();

		JFactory::$session = $this->getMockSession();

		$this->object = new JTableLanguage(self::$driver);
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 *
	 * @return void
	 */
	protected function tearDown()
	{
		$this->restoreFactoryState();
		unset($this->object);
		parent::tearDown();
	}

	/**
	 * Gets the data set to be loaded into the database during setup
	 *
	 * @return  PHPUnit_Extensions_Database_DataSet_CsvDataSet
	 *
	 * @since   12.1
	 */
	protected function getDataSet()
	{
		$dataSet = new PHPUnit_Extensions_Database_DataSet_CsvDataSet(',', "'", '\\');

		$dataSet->addTable('jos_languages', JPATH_TEST_DATABASE . '/jos_languages.csv');

		return $dataSet;
	}

	/**
	 * Tests JTableLanguage::check
	 *
	 * @return  void
	 *
	 * @since   12.1
	 */
	public function testCheck()
	{
		$table = $this->object;

		$this->assertThat(
			$table->check(),
			$this->isFalse(),
			'Line: ' . __LINE__ . ' Checking an empty table should fail.'
		);

		$table->title = 'English (en-GB)';
		$this->assertThat(
			$table->check(),
			$this->isTrue(),
			'Line: ' . __LINE__ . ' The check function should complete without issue.'
		);
	}

	/**
	 * Tests JTableLanguage::store
	 *
	 * @return  void
	 *
	 * @since   12.1
	 */
	public function testStore()
	{
		$table = $this->object;

		// Store a new language
		$table->lang_id      = null;
		$table->title        = 'English (en-US)';
		$table->title_native = 'English (United States)';
		$table->sef          = 'en';
		$this->assertFalse($table->store(), 'Line: ' . __LINE__ . ' Table store should fail due to a duplicated sef field.');
		$table->sef   = 'us';
		$table->image = 'en_gb';
		$this->assertFalse($table->store(), 'Line: ' . __LINE__ . ' Table store should fail due to a duplicated image field.');
		$table->image     = 'en_us';
		$table->lang_code = 'en-GB';
		$this->assertFalse($table->store(), 'Line: ' . __LINE__ . ' Table store should fail due to a duplicated lang_code field.');
		$table->lang_code = 'en-US';
		$this->assertTrue($table->store(), 'Line: ' . __LINE__ . ' Table store should successfully insert a record for English (en-US).');
	}

}