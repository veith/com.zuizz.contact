<?php

try {

    $contact_email = ORM::for_table('contact_email')->table_alias('c');
    $contact_email->where('contact_id',$this->values['parent_identifier'][0]);
    
    
    $this->REST_scope($contact_email);
    $count = clone($contact_email);

    $this->REST_fields($contact_email);


    $this->REST_sortorder($contact_email);

    $contact_email_array = $contact_email->page($this->values['page'], $this->values['limit'])->find_array();



    if ($contact_email_array) {
        $this->REST_clean_types($contact_email_array);
        $this->data['metadata'] = $this->REST_pagination($count->count(), count($contact_email_array));
        $this->data['data'] = $contact_email_array;
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

