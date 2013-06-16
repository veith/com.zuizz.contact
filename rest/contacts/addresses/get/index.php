<?php

$this->fields = array(
    'id' => array('int','c.id'),
    'contact_id' => array("int",'c.contact_id'),
    'street' => array("string",'c.street'),
    'street_no' => array("string",'c.street_no'),
    'city' => array("string",'c.city'),
    'postal_code' => array("string",'c.postal_code'),
    'country' => array("int",'c.country'),
    'label_id' => array("int",'c.label_id')
);





if ($this->values['identifier'] != NULL) {
    include("identifier.php");
} elseif ($this->values['q'] != NULL) {
    include("search.php");
} elseif ($this->values['identifier'] == NULL && $this->values['q'] == NULL) {
    include("list.php");
}

