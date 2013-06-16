<?php

try {


    $contact_data = ORM::for_table('contact_data')->table_alias('c');
    $contact_data->where('contact_id',$this->values['parent_identifier'][0]);
    $this->REST_fields($contact_data);
    $contact_data = $contact_data->find_one($this->values['identifier']);

    if ($contact_data) {
        $this->data = $contact_data->as_array();

    } else {

        throw new Exception('no object with id ' . $this->values['identifier']);
    }

} catch (Exception $e) {
    ZU::header(404);
    $this->data['message'] = $e->getMessage();
}


header('Content-type: application/json');
$this->contentbuffer = json_encode($this->data);
