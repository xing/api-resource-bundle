<?php

namespace Prescreen\ApiResourceBundle\Application\Enum;

class FieldType
{
    const string BOOL = 'bool_field';
    const string DATE = 'date_field';
    const string EMAIL = 'email_field';
    const string FLOAT = 'float_field';
    const string ID_COLLECTION = 'id_collection_field';
    const string ID = 'id_field';
    const string HTML = 'html_field';
    const string INT = 'int_field';
    const string JSON = 'json_field';
    const string RESOURCE = 'resource_field';
    const string RESOURCE_COLLECTION = 'resource_collection_field';
    const string STRING = 'string_field';
    const string URL = 'url_field';
}