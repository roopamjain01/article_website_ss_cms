<?php
class ArticleSubCategory extends DataObject {

    private static $db = array (
        'Title' => 'Varchar',
    );

    private static $has_one = array (
       // 'Category' => 'ArticleCategory',
        'ArticleHolder' => 'ArticleHolder'
    );

    private static $summary_fields = array (
        'Title' => 'Title',
       // 'Category' => 'Category'
    );

    public function getCMSFields() {
         return FieldList::create(
             /*DropdownField::create('CategoryID','Category')
                 ->setSource(ArticleCategory::get()->map('ID','Title')),*/
             TextField::create('Title')
         );
    }
}