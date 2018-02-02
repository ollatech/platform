<?php

namespace Olla\Platform\Action;

use Olla\Platform\Service\ServiceInterface;
use Olla\Flow\Operation\AbstractOperation;

final class CreateAction  extends AbstractOperation
{
	protected $queryService;
	public function __construct(ServiceInterface $queryService) {
		$this->queryService = $queryService;
	}
	public function execute(string $resourceClass, array $dataRequest, array $option = []) {
		$query = $this->queryService
		->resource($resourceClass)
		->database('orm')
		->select()
		->format('json')
		->evaluate()
		->collection($dataRequest)
		->result();
		return $query;
	}
}
