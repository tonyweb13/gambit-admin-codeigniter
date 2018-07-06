<?php

namespace App\Events;

abstract class EventActivity extends Event
{
	/**
	 * getActivityCode
	 *
	 *
	 * @return void
	 * @access  public
	 **/
	abstract public function getActivityCode();

	/**
	 * getActivityShortDescription
	 *
	 *
	 * @return void
	 * @access  public
	 **/
	abstract public function getActivityShortDescription();

	/**
	 * getActivityLongDescription
	 *
	 *
	 * @return void
	 * @access  public
	 **/
	abstract public function getActivityLongDescription();
}
