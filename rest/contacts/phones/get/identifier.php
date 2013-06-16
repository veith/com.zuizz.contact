<?php

try {


    $contact_phone = ORM::for_table('contact_phone')->table_alias('c');
    $contact_phone->where('contact_id',$this->values['parent_identifier'][0]);
    $this->REST_fields($contact_phone);
    $contact_phone = $contact_phone->find_one($this->values['identifier']);

    if ($contact_phone) {
        $this->data = $contact_phone->as_array();

    } else {

        throw new Exception('no object with id ' . $this->values['identifier']);
    }

} catch (Exception $e) {
    ZU::header(404);
    $this->data['message'] = $e->getMessage();
}


header('Content-type: application/json');
$this->contentbuffer = json_encode($this->data);
