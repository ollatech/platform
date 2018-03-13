<?php

namespace Olla\Platform\Api;

use Olla\Core\Operation\ApiOperation;
use Symfony\Component\HttpFoundation\Request;

final class CollectionOperation extends ApiOperation
{
	public function http(Request $request) {
		return $this->output(['test' => 'lallal']);
	}
}
