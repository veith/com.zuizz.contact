<?php

try {

    $contact_address = ORM::for_table('contact_address')->table_alias('c');
    $contact_address->where('contact_id',$this->values['parent_identifier'][0]);
    
    
    $this->REST_scope($contact_address);
    $count = clone($contact_address);

    $this->REST_fields($contact_address);


    $this->REST_sortorder($contact_address);

    $contact_address_array = $contact_address->page($this->values['page'], $this->values['limit'])->find_array();



    if ($contact_address_array) {
        $this->REST_clean_types($contact_address_array);
        $this->data['metadata'] = $this->REST_pagination($count->count(), count($contact_address_array));
        $this->data['data'] = $contact_address_array;
    } else {
        throw new Exception('no data');
    }
    ZU::header(200);
} catch (Exception $e) {
    ZU::header(404);
    $this->data['message'] = $e->getMessage();
}


header('Content-type: application/json');
$this->contentbuffer = json_encode($this->data);

