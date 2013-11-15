<?php
/* 
 * Update contact data
 * Please describe the restlet
 *
 *
 * @author 
 * @package com.zuizz.contact
 * @subpackage contacts.addresses.put.doc.json 
 *
 *
 *
 * Permissions / Roles 
 * User => Authentifizierte Benutzer können...
 * Administrator => Rolle Administrator kann...
 *
 *
 *
 * States 
 *
 * State 422  => Nicht verarbeitbare Daten
 * Die Daten konnten nicht verarbeitet werden. Allfällige Detail sind im response body.
 *
 * State 202  => OK
 * Objekt wurde aktualisiert.
 * Allfällige Details sind im response body.
 *
 * State 404  => Nicht vorhanden
 * Objekt mit Identifier nicht gefunden oder nicht vorhanden
 *
 *
 *
 * Available variables 
 *
 * Identifier field
 * varname:identifier (numeric), always available:0
 *
 * Street
 * varname:street (string), always available:0
 *
 * street_no
 * varname:street_no (string), always available:0
 *
 * city
 * varname:city (string), always available:0
 *
 * postal_code
 * varname:postal_code (string), always available:0
 *
 * 
 * varname:country (int), always available:0
 *
 * label_id
 * varname:label_id (int), always available:0
 *
 *
 *
 */

try {
    $DB = ORM::for_table('contact_address')->where('contact_id', $this->values['parent_identifier'][0])->find_one($this->values['identifier']);

    if ($DB) {
        $update_fields = $this->values;
        unset($update_fields['parent_identifier']);
        unset($update_fields['identifier']);

        foreach ($update_fields as $key => $value) {
            if ($value != null) {
                $DB->$key = $value;
            }
        }

        $DB->set('m_date', ZU_NOW);

        $DB->save();

        $this->data['message'] = "record saved";

        ZU::header(202);


    } else {
        throw new Exception('message');
    }
    ZU::header(202);

} catch (Exception $e) {
    ZU::header(404);
    $this->data['message'] = $e->getMessage();
}


/* 
 * Mimetype json 
 * Returns:
 * Details zum Vorgang als json Objekt.
*/

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
        $xml = Array2XML::createXML('auth', $this->data);
        $this->contentbuffer = $xml->saveXML();
        break;
}