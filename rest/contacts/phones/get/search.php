<?php

try {
    $contact_phone = ORM::for_table('contact_phone')->table_alias('c');
    $contact_phone->where('contact_id',$this->values['parent_identifier'][0]);
    $this->REST_scope($contact_phone);
    $contact_phone->where_like('phone_no', '%' . $this->values['q'] . '%');

    $count = clone($contact_phone);

    $this->REST_fields($contact_phone);

    $contact_phone_array = $contact_phone->page($this->values['page'], $this->values['limit'])->find_array();

    if ($contact_phone_array) {
        $this->REST_clean_types($contact_phone_array);
        $this->data['metadata'] = $this->REST_pagination($count->count(),count($contact_phone_array));

        $this->data['data'] =  ($contact_phone_array);
    } else {
        throw new Exception('no data');
    }

} catch (Exception $e) {
    ZU::header(404);
    $this->data['message'] = $e->getMessage();
}

// set default mimetype
if (!$this->mimetype) {
    $this->mimetype = 'json';
}

switch ($this->mimetype) {
    case "json":
        header('Content-type: application/json');
        $this->contentbuffer = json_encode($this->data);
        break;
    case "xml":
        header('Content-type: application/xml');
        ZU::load_class('lalit.array2xml', 'xml', true);
        $xml = Array2XML::createXML('machines', $this->data);
        $this->contentbuffer = $xml->saveXML();
        break;
}



