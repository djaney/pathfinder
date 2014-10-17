<?php namespace Djaney\Pathfinder;

class Step{
	public $node;
	public $segment;
	public function __construct($node,$segment){
		$this->node = $node;
		$this->segment = $segment;
	}

}