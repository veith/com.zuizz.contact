<?php
/* 
 * Update contact data
 * Please describe the restlet
 *
 *
 * @author 
 * @package com.zuizz.contact
 * @subpackage contacts.put.doc.json 
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
 * Name of Company or Person
 * varname:name (string), always available:0
 *
 * Firstname
 * varname:first_name (string), always available:0
 *
 * is_company
 * varname:is_company (Boolean), always available:0
 *
 * company_id
 * varname:company_id (int), always available:0
 *
 * gender
0 unknown, 1 male, 2 female
 * varname:gender (int), always available:0
 *
 * timestamp
 * varname:birth_date (int), always available:0
 *
 * birth_day as day of year
 * varname:birth_day (int), always available:0
 *
 * Title
 * varname:title (string), always available:0
 *
 *
 *
 */



try {

    $DB = ORM::for_table('contact')->find_one($this->values['identifier']);
    if ($DB) {
        $update_fields = $this->values;
        unset($update_fields['identifier']);

        foreach($update_fields as $key => $value){
            if($value != null){
                $DB->$key = $value;
            }
        }
        $DB->set('m_date',ZU_NOW);
        $DB->save();
        $this->data['message'] = "record saved";
        ZU::header(202);
    } else {
        throw new Exception('entity #' . $this->values['identifier'] . ' not found' );

    }




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