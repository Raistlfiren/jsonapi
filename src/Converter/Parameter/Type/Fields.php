<?php

namespace Bolt\Extension\Bolt\JsonApi\Converter\Parameter\Type;

/**
 * Class Fields
 *
 * @package Bolt\Extension\Bolt\JsonApi\Converter\Parameter\Type
 */
class Fields extends AbstractParameter
{
    /** @var array $fields */
    protected $fields;

    /**
     * Parameter example: fields[pages]=title,teaser
     *
     * @return $this
     */
    public function convertRequest()
    {
        $this->fields = [];

        if ($this->config->getAllowedFields($this->contentType)) {
            $allowedFields = $this->config->getAllowedFields($this->contentType);
        } else {
            $allowedFields = array_keys($this->getAllFieldNames());
        }

        if (isset($this->values[$this->contentType])) {
            $values = explode(',', $this->values[$this->contentType]);
            foreach ($values as $v) {
                if (in_array($v, $allowedFields)) {
                    $this->fields[] = $v;
                }
            }
        }

        // Default on the default/fallback fields defined in the config.
        if (empty($this->fields)) {
            $this->fields = $allowedFields;
            if ($this->config->getListFields($this->contentType)) {
                $this->fields = $this->config->getListFields(($this->contentType));
                // todo: do we need to filter these through 'allowed-fields'?
            }
        }

        return $this;
    }

    public function findConfigValues()
    {
    }

    /**
     * @return array
     */
    public function getParameter()
    {
        return $this->getFields();
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param array $fields
     *
     * @return Fields
     */
    public function setFields($fields)
    {
        $this->fields = $fields;

        return $this;
    }
}
