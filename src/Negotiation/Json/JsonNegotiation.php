<?php
namespace Olla\Platform\Negotiation\Json;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

final class JsonNegotiation {
    
	protected $serializer;
    protected $format = 'json';

    public function __construct(SerializerInterface $serializer) {
        $this->serializer = $serializer;
    }

    public function supports(string $format)
    {
        if($format === $this->format) {
            return true;
        }
    }

    public function output(string $format, array $data, array  $options = []) {
        $response = [];
        if(is_array($data)) {
            foreach ($data as $key => $object) {
                $serialized = $this->serializer->serialize($object, $format, $options);
                $response[] = $this->serializer->decode($serialized, $format);
            }
        } else {
            $response = $this->serializer->serialize($data, $format, $options);
        }
        return new JsonResponse($response);
    }
}