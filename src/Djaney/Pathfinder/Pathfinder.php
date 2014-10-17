<?php namespace Djaney\Pathfinder;

class Pathfinder{
	
	protected $nodes = array();
	protected $transits = array();


	public function addNode($id,$name){
		$node = new Node($id,$name);
		$this->nodes[$node->getId()] = &$node;
		return $this;
	}

	public function addTransit($id,$name){
		$trans = new Transit($id,$name);
		$this->transits[$trans->getId()] = &$trans;
		return $this;
	}

	public function addSegment($trans,$from,$to,$metrics){

		$this->nodes[$from]->addSegment(new Segment($this->transits[$trans],$this->nodes[$to],$metrics));
	}

	public function findRoute($from,$to,$m){

		$nodes = array();
		$list = array();
		$current = NULL;
		$trail = array();
		$isDone = false;
		// #1 put all nodes in a cost dictionary with key=node-id and key to -1 (meaning infinity), origin is 0 and set as current adn add to list
		foreach($this->nodes as $n){
				$w = ($from==$n->getId())?0:-1;
				$nodes[$n->getId()] = $w;
				if($w==0){
					$current = $n->getId();
				}
		}
		$trail[] = $current;
		$list[] = $current;	
		// #2 get all available nodes and update them according to current + destination, if no more go back to prev and try again, if prev has nothing then stop
		while(!$isDone){
			$nSuccess = false;

			while(!$nSuccess && !$isDone){
				// get all available
				foreach($this->nodes[$current]->getSegments() as $s){
					if(!in_array($s->getTo()->getId(),$list)){
						$nodes[$s->getTo()->getId()] = $nodes[$current] + $s->metrics[$m];
						$nSuccess = true;

					}
				}


				// if not then set current to previous
				if(!$nSuccess){

					unset($trail[count($trail)-1]);
					
					if(count($trail)-1>0){

						$current = $trail[count($trail-1)];
					}else{
						$isDone = true;
					}

					
				}

			}


			if(!$isDone){
				// #3 add current to list
				
				// #4 set current to lowest and not infinity

				$min = NULL;
				foreach($nodes as $k=>$v){
					if(in_array($k,$list)) continue;
					if($min===NULL || $nodes[$min] ){
						$min = $k;

					}
				}
				if($min===NULL){
					$isDone = true;
				}else{
					$current = $min;
					$trail[] = $current;
					$list[] = $current;

					if($current==$to) $isDone = true;

				}
			}

			if(count($nodes)<=count($list)){
				$isDone = true;
			}

			// #jump to #2
		}
	

		// now reverse trace
		$isFirst = true;
		$final = array();
		
		while(count($nodes)!=0){
			$max = -1;
			foreach($nodes as $k=>$v){
				if($max==-1){
					$max = $k;
				}
				if($v>$nodes[$max]){
					$max = $k;
				}
			}
			

			if($isFirst && $max==$to){
				if($max==$from){
					break;
				}
			}
			$isFirst = false;

			$final[] = $max;
			if(isset($nodes[$max])) unset($nodes[$max]);
		}
		$final = array_reverse($final);
		$route = new Route;

		foreach($final as $k=>$n){
		
			if(isset($final[$k+1])){
				$seg = $this->nodes[$n]->getSegmentTo($final[$k+1]);
				$route->addStep($this->nodes[$n],$seg);
				$route->addMetrics($seg->metrics);
			}else{
				$route->addStep($this->nodes[$n],NULL);
			}
			
		}

		return $route;

	}
}