<?php namespace Djaney\Pathfinder;

class Transit{
	protected $id;
	public $name;

	public function __construct($id,$name){
		$this->id = $id;
		$this->name = $name;
	}

	public function getId(){
		return $this->id;
	}
}