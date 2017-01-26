<?php namespace PHRETS\Parsers\GetMetadata;

use PHRETS\Http\Response;
use Illuminate\Support\Collection;
use PHRETS\Session;

class Object extends Base
{
    public function parse(Session $rets, Response $response)
    {
        $xml = $response->xml();

        $collection = new Collection;

        if ($xml->METADATA and !empty($xml->METADATA) {
            foreach ($xml->METADATA->{'METADATA-OBJECT'}->Object as $key => $value) {
                $metadata = new \PHRETS\Models\Metadata\Object;
                $metadata->setSession($rets);
                /** @var \PHRETS\Models\Metadata\Object $obj */
                $obj = $this->loadFromXml($metadata, $value, $xml->METADATA->{'METADATA-OBJECT'});
                $collection->put($obj->getObjectType(), $obj);
            }
        }

        return $collection;
    }
}
