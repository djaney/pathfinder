<?php
use Djaney\Pathfinder\Pathfinder;
use Djaney\Pathfinder\Route;
use Djaney\Pathfinder\Node;
use Djaney\Pathfinder\Segment;
use Djaney\Pathfinder\Path;
class PathfinderTest extends TestCase {



	public function testSimpleOnePath()
	{
		$p = new Pathfinder;
		$r->addRoute('Jeep 1');
		$n1 = $r->addNode('Station 1');
		$n2 = $r->addNode('Station 2');
		$r->connectNodes($n1,$n2,array('distance'=>1,'fare'=>2));

		$pa = $p->findPath($n1,$n2,'distance');

		

		$this->assertEquals($pa->nodes[0]->name,'Station 1');
		$this->assertEquals($pa->nodes[2]->name,'Station 2');
		$this->assertEquals($pa->metricTotal('distance'),1);
		$this->assertEquals($pa->metricTotal('fare'),2);
	}
}