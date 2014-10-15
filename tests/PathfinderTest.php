<?php
use Djaney\Pathfinder\Pathfinder;
use Djaney\Pathfinder\Transit;
use Djaney\Pathfinder\Node;
use Djaney\Pathfinder\Segment;
use Djaney\Pathfinder\Path;
class PathfinderTest extends TestCase {



	public function testOneRouteOneSegment()
	{
		$p = new Pathfinder;

		$n1 = $p->addNode('n1','Station 1');
		$n2 = $p->addNode('n2','Station 2');

		$t = $p->addTransit('r1','Jeep 1');
		$t->addSegment($n1,$n2,array('distance'=>1));

		$pa = $p->findPath($n1,$n2,'distance');

		// first step
		$this->assertEquals($pa->steps[0]->node->name,'Station 1');
		$this->assertEquals($pa->steps[0]->route->name,'Jeep 1');
		$this->assertEquals($pa->steps[0]->segment->id,'r1-n1-n2');

		// second step
		$this->assertEquals($pa->steps[2]->node->name,'Station 2');
		$this->assertEquals($pa->steps[2]->route->name,'Jeep 1');
		$this->assertEquals($pa->steps[2]->segment->id,NULL);

		$this->assertEquals($pa->metricTotal('distance'),1);
	}
}