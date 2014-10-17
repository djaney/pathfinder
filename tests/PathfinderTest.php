<?php
use Djaney\Pathfinder\Pathfinder;
use Djaney\Pathfinder\Node;
use Djaney\Pathfinder\Transit;
use Djaney\Pathfinder\Segment;
use Djaney\Pathfinder\Route;
class PathfinderTest extends TestCase {



	public function testOneRouteOneSegment()
	{
		$p = new Pathfinder;

		$p->addNode('n1','Station 1')
			->addNode('n2','Station 2')
			->addTransit('t1','Jeep 1');

		$p->addSegment('t1','n1','n2',array('distance'=>1));
		
		$r = $p->findRoute('n1','n2','distance');
		$steps = $r->getSteps();
		// first step
		$this->assertEquals('Station 1',$steps[0]->node->name);
		$this->assertEquals('Jeep 1',$steps[0]->segment->transit->name);
		$this->assertEquals('n2',$steps[0]->segment->getTo()->getId());

		// second step
		$this->assertEquals('Station 2',$steps[1]->node->name);
		$this->assertEquals(NULL,$steps[1]->segment);

		$this->assertEquals(1,$r->metricTotal('distance'));
	}

	# no such metric
	# no such id
}