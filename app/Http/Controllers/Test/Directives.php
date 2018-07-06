<?php


namespace App\Http\Controllers\Test;


use App\Http\Controllers\Controller;

class Directives extends Controller
{

	/**
	 * getIndex
	 *
	 * 
	 * @return void
	 * @access  public
	 **/
	public function getIndex()
	{
		return view('test.directives.index');
	}
	
	/**
	 * getHelloWorld
	 *
	 * 
	 * @return void
	 * @access  public
	 **/
	public function getHelloWorld()
	{
		return view('test.directives.hello-world');
	}

	public function getSelectToAgent()
	{
		return view('test.directives.select-to-agent');
	}

	public function getSelectFromAgent()
	{
		return view('test.directives.select-from-agent');
	}

	public function getSystemInfo()
	{
		return view('test.directives.system-info');
	}

	public function getSimpleTable()
	{
		return view('test.directives.simple-table');
	}

	public function getSelectParent()
	{
		return view('test.directives.select-parent');
	}

	public function getSelectLimit()
	{
		return view('test.directives.select-limit');
	}

	public function getSelectLanguage()
	{
		return view('test.directives.select-language');
	}

	public function getSelectGsp()
	{
		return view('test.directives.select-gsp');
	}

	public function getSelectCurrency()
	{
		return view('test.directives.select-currency');
	}

	public function getSelectAgent()
	{
		return view('test.directives.select-agent');
	}

	public function getPageTop()
	{
		return view('test.directives.page-top');
	}

	public function getMenu()
	{
		return view('test.directives.menu');
	}

	public function getLogAs()
	{
		return view('test.directives.log-as');
	}

	public function getLabelStatus()
	{
		return view('test.directives.label-status');
	}

	public function getHelpModal()
	{
		return view('test.directives.help-modal');
	}

	public function getDateSelector()
	{
		return view('test.directives.date-selector');
	}

	public function getBreadcrumbs()
	{
		return view('test.directives.breadcrumbs');
	}

	public function getAgentHierarchy()
	{
		return view('test.directives.agent-hierarchy');
	}

	public function getAdvanceTable()
	{
		return view('test.directives.advance-table');
	}

	public function getTooltip()
	{
		return view('test.directives.tooltip');
	}


}