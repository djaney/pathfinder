<?php namespace Djaney\Pathfinder;

class Node{
	protected $id;
	public $name;
	protected $segments = array();

	public function __construct($id,$name){
		$this->id = $id;
		$this->name = $name;
	}

	public function getId(){
		return $this->id;
	}

	public function addSegment(Segment &$seg){
		$this->segments[$seg->getTo()->id] = &$seg;
		return $this;
	}
	public function getSegments(){
		return $this->segments;
	}

	public function getSegmentTo($nodeId){
		if(isset($this->segments[$nodeId])){
			return $this->segments[$nodeId];
		}else{
			return null;
		}
	}
}