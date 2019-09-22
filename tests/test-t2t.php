<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class T2tTest extends WP_UnitTestCase {

	/**
	 * A single example test.
	 */
	public function test_print_section_info() {

		$a = new Class_Options_Page();
		$str = $a->print_section_info2();

		$this->assertEquals('Enter your settings below', $str);

		// Replace this with some actual testing code.
//		$this->assertTrue( true );
	}
}
