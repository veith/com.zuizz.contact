<?php

$this->fields = array(
    'id' => array('int','c.id'),
    'contact_id' => array("int",'c.contact_id'),
    'phone_no' => array("string",'c.phone_no'),
    'label_id' => array("int",'c.label_id')
);





if ($this->values['identifier'] != NULL) {
    include("identifier.php");
} elseif ($this->values['q'] != NULL) {
    include("search.php");
} elseif ($this->values['identifier'] == NULL && $this->values['q'] == NULL) {
    include("list.php");
}

