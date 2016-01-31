<?php
class ArticleCategory extends DataObject {

    private static $db = array (
        'Title' => 'Varchar',
    );

    private static $has_one = array (
     'ArticleHolder' => 'ArticleHolder'
    );

    public function getCMSFields() {
     return FieldList::create(
        TextField::create('Title')
     );
    }
}