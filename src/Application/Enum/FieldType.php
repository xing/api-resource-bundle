<?php

namespace Prescreen\ApiResourceBundle\Application\Enum;

enum FieldType: string
{
    case BOOL = 'bool_field';
    case DATE = 'date_field';
    case EMAIL = 'email_field';
    case FLOAT = 'float_field';
    case GENERIC = 'generic_field';
    case ID_COLLECTION = 'id_collection_field';
    case ID = 'id_field';
    case INT = 'int_field';
    case JSON = 'json_field';
    case RESOURCE = 'resource_field';
    case RESOURCE_COLLECTION = 'resource_collection_field';
    case STRING = 'string_field';
    case URL = 'url_field';
}