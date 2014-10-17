<?php namespace Djaney\Pathfinder;

class Segment{
	
	protected $to = NULL;
	public $metrics = array();
	public $transit;

	public function __construct(Transit &$trans,Node &$to,$metrics){
		$this->to = &$to;
		$this->transit = &$trans;
		$this->metrics = $metrics;
	}
	public function getTo(){
		return $this->to;
	}

}