<?php

namespace Prescreen\ApiResourceBundle\Application\Enum;

class FieldType
{
    public const string BOOL = 'bool_field';
    public const string DATE = 'date_field';
    public const string EMAIL = 'email_field';
    public const string FLOAT = 'float_field';
    public const string ID_COLLECTION = 'id_collection_field';
    public const string ID = 'id_field';
    public const string HTML = 'html_field';
    public const string INT = 'int_field';
    public const string JSON = 'json_field';
    public const string RESOURCE = 'resource_field';
    public const string RESOURCE_COLLECTION = 'resource_collection_field';
    public const string STRING = 'string_field';
    public const string URL = 'url_field';
}
