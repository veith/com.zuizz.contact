<?php

$this->fields = array(
    'id' => array('int','c.id'),
    'title' => array("string",'c.title'),
    'name' => array("string",'c.name'),
    'first_name' => array("string",'c.first_name'),
    'is_company' => array("boolean",'c.is_company'),
    'company_id' => array("int",'c.company_id'),
    'gender' => array("int",'c.gender'),
    'birth_date' => array("timestamp",'c.birth_date'),
    'birth_day' => array("timestamp",'c.birth_day'),
    'c_date' => array("timestamp",'c.c_date'),
    'm_date' => array("timestamp",'c.m_date')
);

$this->fieldgroups['email'] = false;
$this->fieldgroups['address'] = false;
$this->fieldgroups['data'] = false;
$this->fieldgroups['phone'] = false;



if ($this->values['identifier'] != NULL) {
    include("identifier.php");
} elseif ($this->values['q'] != NULL) {
    include("search.php");
} elseif ($this->values['identifier'] == NULL && $this->values['q'] == NULL) {
    include("list.php");
}

