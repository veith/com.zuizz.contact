<?php

try {


    $contact_email = ORM::for_table('contact_email')->table_alias('c');
    $contact_email->where('contact_id',$this->values['parent_identifier'][0]);
    $this->REST_fields($contact_email);
    $contact_email = $contact_email->find_one($this->values['identifier']);

    if ($contact_email) {
        $this->data = $contact_email->as_array();

    } else {

        throw new Exception('no object with id ' . $this->values['identifier']);
    }

} catch (Exception $e) {
    ZU::header(404);
    $this->data['message'] = $e->getMessage();
}


header('Content-type: application/json');
$this->contentbuffer = json_encode($this->data);
