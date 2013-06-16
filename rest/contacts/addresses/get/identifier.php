<?php

try {


    $contact_address = ORM::for_table('contact_address')->table_alias('c');
    $contact_address->where('contact_id',$this->values['parent_identifier'][0]);
    $this->REST_fields($contact_address);
    $contact_address = $contact_address->find_one($this->values['identifier']);

    if ($contact_address) {
        $this->data = $contact_address->as_array();

    } else {

        throw new Exception('no object with id ' . $this->values['identifier']);
    }

} catch (Exception $e) {
    ZU::header(404);
    $this->data['message'] = $e->getMessage();
}


header('Content-type: application/json');
$this->contentbuffer = json_encode($this->data);
