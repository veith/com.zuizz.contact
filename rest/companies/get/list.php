<?php

try {
    ORM::configure('logging', true);
    $Contacts = ORM::for_table('contact')->table_alias('c');
    $Contacts->where('is_company',1);

    $this->REST_scope($Contacts);
    $count = clone($Contacts);

    $this->REST_fields($Contacts);


    $this->REST_sortorder($Contacts);

    $Contacts_array = $Contacts->page($this->values['page'], $this->values['limit'])->find_array();



    if ($Contacts_array) {
        $this->REST_clean_types($Contacts_array);
        $this->data['metadata'] = $this->REST_pagination($count->count(), count($Contacts_array));
        $this->data['data'] = $Contacts_array;
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

