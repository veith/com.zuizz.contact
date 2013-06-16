<?php

try {
    $Contacts = ORM::for_table('contact')->table_alias('c');
    $Contacts->where('is_company',0);
    $Contacts->where('company_id',$this->values['parent_identifier'][0]);
    $this->REST_scope($Contacts);
    $Contacts->where_like('name', '%' . $this->values['q'] . '%');

    $count = clone($Contacts);

    $this->REST_fields($Contacts);

    $Contacts_array = $Contacts->page($this->values['page'], $this->values['limit'])->find_array();

    if ($Contacts_array) {
        $this->REST_clean_types($Contacts_array);
        $this->data['metadata'] = $this->REST_pagination($count->count(),count($Contacts_array));

        $this->data['data'] =  ($Contacts_array);
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



