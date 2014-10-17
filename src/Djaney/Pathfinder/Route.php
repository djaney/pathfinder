<?php namespace Djaney\Pathfinder;

class Route{
	private $steps = array();
	public $metricTotal = array();

	public function addStep($node,$segment){
		$this->steps[] = new Step($node,$segment);
	}

	public function getSteps(){
		return $this->steps;
	}

	public function addMetrics($m){
		foreach($m as $k=>$v){
			if(isset($this->metricTotal[$k])){
				$this->metricTotal[$k]+=$v;
			}else{
				$this->metricTotal[$k] = $v;
			}
		}
	}

	public function metricTotal($m){
		if(isset($this->metricTotal[$m])){
			return $this->metricTotal[$m];
		}else{
			return 0;
		}
	}

}