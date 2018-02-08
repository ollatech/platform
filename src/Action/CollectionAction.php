<?php

namespace Olla\Platform\Action;

use Olla\Flow\Repository;
use Olla\Flow\Theme;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CollectionAction
{
	protected $repo;
	protected $theme;
	public function __construct(Repository $repo, Theme $theme) {
		$this->repo = $repo;
		$this->theme = $theme;
	}
	public function __invoke(Request $request) {
		print_r($request);
	}
	public function invoke(Request $request) {
		$this->collection->getCollection($resourceClass, $args);
	}
}
