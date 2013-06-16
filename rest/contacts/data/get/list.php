<?php

try {

    $contact_data = ORM::for_table('contact_data')->table_alias('c');
    $contact_data->where('contact_id',$this->values['parent_identifier'][0]);
    
    
    $this->REST_scope($contact_data);
    $count = clone($contact_data);

    $this->REST_fields($contact_data);


    $this->REST_sortorder($contact_data);

    $contact_data_array = $contact_data->page($this->values['page'], $this->values['limit'])->find_array();



    if ($contact_data_array) {
        $this->REST_clean_types($contact_data_array);
        $this->data['metadata'] = $this->REST_pagination($count->count(), count($contact_data_array));
        $this->data['data'] = $contact_data_array;
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

