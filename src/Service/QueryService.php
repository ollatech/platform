<?php
namespace Olla\Platform\Service;

use Olla\Platform\Flow\QueryFlow;

final class QueryService extends QueryFlow implements ServiceInterface {

	/**
	 * get collection
	 * @param  array  $args [description]
	 * @return [type]       [description]
	 */
	public function collection(array $args = []) {
		$this->result = $this->repository->get($args);
		return $this;
	}
}