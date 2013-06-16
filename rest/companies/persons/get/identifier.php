<?php



try {


    $Contact = ORM::for_table('contact')->table_alias('c');
    $Contact->where('is_company',0);
    $Contact->where('company_id',$this->values['parent_identifier'][0]);
    $this->REST_fields($Contact);
    $Contact = $Contact->find_one($this->values['identifier']);


    if ($Contact) {

        $this->data['data'] = $Contact->as_array();

        //email
        if ($this->fieldgroups['email']) {
            $this->data['data']['email'] = ORM::for_table('contact_email')->where('contact_id', $this->values['identifier'])->find_array();
        }
        //phone
        if ($this->fieldgroups['phone']) {
            $this->data['data']['phone'] = ORM::for_table('contact_phone')->where('contact_id', $this->values['identifier'])->find_array();
        }

        //data
        if ($this->fieldgroups['data']) {
            $this->data['data']['data'] = ORM::for_table('contact_data')->where('contact_id', $this->values['identifier'])->find_array();
        }

        //addresses
        if ($this->fieldgroups['address']) {
            $this->data['data']['address'] = ORM::for_table('contact_address')->where('contact_id', $this->values['identifier'])->find_array();
        }


    } else {

        throw new Exception('no object with id ' . $this->values['identifier']);
    }

} catch (Exception $e) {
    ZU::header(404);
    $this->data['message'] = $e->getMessage();
}


header('Content-type: application/json');
$this->contentbuffer = json_encode($this->data);
