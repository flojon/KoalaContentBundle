<?php
namespace Koala\ContentBundle;
	
class LayoutsProvider
{
    var $layouts;

    public function __construct($layouts)
    {
        $this->layouts = $layouts;
    }

    public function getChoices()
    {
        $get_name = function($row) {
            return $row['name'];
        };

        return array_map($get_name, $this->layouts);
    }
	
	public function getTemplate($layout)
	{
		return $this->layouts[$layout]['template'];
	}
}