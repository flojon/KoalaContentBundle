<?php
namespace Koala\ContentBundle;

class LayoutsProvider
{
    var $layouts;

    public function __construct($layouts)
    {
        $this->layouts = $layouts;
    }

    public function getChoices($row = null)
    {
        if ($row == null)
            $row = $this->layouts;
        else if (isset($row['name']))
            return $row['name'];

        return array_map(array($this, 'getChoices'), $row);
    }

    public function getTemplate($layout)
    {
        if (isset($this->layouts[$layout]))
            return $this->layouts[$layout]['template'];

        foreach ($this->layouts as $sublayout)
        {
            if (isset($sublayout[$layout]))
                return $sublayout[$layout]['template'];
        }

        throw new \InvalidArgumentException("No template defined with name: $layout");
    }
}