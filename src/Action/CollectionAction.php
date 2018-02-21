<?php

namespace Olla\Platform\Action;

use Olla\Resource\Collection;
use Symfony\Component\HttpFoundation\Request;

final class CollectionAction
{
	protected $collection;
	public function __construct(Collection $collection) {
		$this->collection = $collection;
	}
	public function __invoke($operation, Request $request) {
		if(null === $resourceId = $operation->getResource()) {

		};
		return $this->collection->get($resourceId, [], []);
	}
}
