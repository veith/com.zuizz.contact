<?php

try {
    $contact_email = ORM::for_table('contact_email')->table_alias('c');
    $contact_email->where('contact_id',$this->values['parent_identifier'][0]);
    $this->REST_scope($contact_email);
    $contact_email->where_like('email', '%' . $this->values['q'] . '%');

    $count = clone($contact_email);

    $this->REST_fields($contact_email);

    $contact_email_array = $contact_email->page($this->values['page'], $this->values['limit'])->find_array();

    if ($contact_email_array) {
        $this->REST_clean_types($contact_email_array);
        $this->data['metadata'] = $this->REST_pagination($count->count(),count($contact_email_array));

        $this->data['data'] =  ($contact_email_array);
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



