<?php
namespace Library\GitHubClient\Client;

class GitHubObject {

    /**
     *
     * @param array $json            
     */
    public static function fromArray(array $json, $type) {
        $array = array();
        foreach ($json as $jsonObject) {
            $objectName = "Library\GitHubClient\Client\Objects\\$type";
            $object = new $objectName($jsonObject);
            if (method_exists($object, 'getId')) {
                $array[$object->getId()] = $object;
            } else {
                $array[] = $object;
            }
        }
        
        return $array;
    }

    /**
     *
     * @param stdClass $json            
     */
    public function __construct(\stdClass $json) {
        $attributes = $this->getAttributes();
        
        foreach ($attributes as $attributeName => $attributeType) {
            if (!isset($json->$attributeName))
                continue;
            
            switch ($attributeType) {
                case 'string':
                    $this->$attributeName = $json->$attributeName;
                    break;
                
                case 'int':
                    $this->$attributeName = intval($json->$attributeName);
                    break;
                
                case 'boolean':
                    $this->$attributeName = (bool) $json->$attributeName;
                    break;
                
                default:
                    $matches = null;
                    if (preg_match('/^array<([^>]+)>$/', $attributeType, $matches)) {
                        $attributeType = $matches[1];
                        $array = array();
                        if (is_array($json->$attributeName)) {
                            foreach ($json->$attributeName as $value) {
                                $attributeTypeName = "Library\GitHubClient\Client\Objects\\$attributeType";
                                $array[] = new $attributeTypeName($value);
                            }
                        }
                        $this->$attributeName = $array;
                    } else {
                        $attributeTypeName = "Library\GitHubClient\Client\Objects\\$attributeType";
                        if (!class_exists($attributeTypeName))
                            throw new GitHubClientException("Github type [$attributeType] not found", GitHubClientException::CLASS_NOT_FOUND);
                        
                        $this->$attributeName = new $attributeTypeName($json->$attributeName);
                    }
                    break;
            }
        }
    }

    /**
     *
     * @return array
     */
    protected function getAttributes() {
        return array();
    }
}
