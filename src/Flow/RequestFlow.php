<?php
namespace Olla\Platform\Flow;

use Olla\Flow\Security\Gate\GateInterface;
use Olla\Prisma\MetadataInterface;
use Olla\Flow\Parser\ParserInterface;

abstract class RequestFlow
{
    
    protected $resource;
    protected $metadata;
    protected $parser;
    protected $broker;
    protected $gate;
    protected $operation;


    public function __construct(
        MetadataInterface $metadata, 
        GateInterface $guard,
        ParserInterface $parser
    ) {
        $this->metadata = $metadata;
        $this->guard = $guard;
        $this->database = $database;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    public function resource(string $resourceClass) {
        $this->resource_class = $resourceClass;
        $this->resource = $this->metadata->resource($resourceClass);
        $this->repository();
        return $this;
    }
    public function select(array $fields = []) {
        if(!$fields || empty($fields) || count($fields) < 1) {
            $fields = $this->resource->getProperties();
        }
        $readables = [];
        foreach ($fields as $name => $field) {
            if($this->guard->can('read', $this->resource_class, $name)) {
                $readables[$name] = $name;
            }
        }
        $this->select = $readables;
        return $this;
    }
    public function input(array $fields = []) {
        $writeables = [];
        foreach ($fields as $name => $value) {
            $type = null;
            if($this->guard->can('write', $this->resource_class, $name)) {
                $writeables[$name] = $field;
            }
        }
        $this->input = $fields;
        return $this;
    }

    public function format(string $format = 'json') {
        $this->format = $format;
        return $this;
    }
    public function database(string $engine = null) {
        $this->engine = $engine;
        $this->repository();
        return $this;
    }
    public function repository() {
        if(null !== $repository = $this->database->engine($this->engine)->getRepository($this->resource_class)) {
            $this->repository = $repository;
        } else {
            $this->errors['repository'] = 'Can"t find any repository related with this resource';
        }
        return $this;
    }
    public function skipGuard() {
        $this->skipGuard = true;
        return $this;
    }
    public function skipValidation() {
        $this->skipValidation = true;
        return $this;
    }
    public function evaluate() {
        if(null === $this->repository) {
            throw new \Exception('No repository');
        }
        return $this;
    }
    public function result() {
        return $this->response($this->result);
    }
    public function response(array $result = []) {
        $context = array_merge($this->context, ['select' => $this->select]);
        $status = count($this->errors) >=1 ? 'bad' : 'ok';
        $this->data = $this->serializer->normalize($this->result, $this->format, $context);
        return [
            'status' => $status,
            'data' => $this->data,
            'meta' => $this->meta,
            'errors' => $this->errors
        ];
    }
}