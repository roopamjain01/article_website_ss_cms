<?php
/**
 * Created by PhpStorm.
 * User: roopam
 * Date: 21-12-2015
 * Time: 12:08 PM
 */

class ArticleComment extends DataObject {

    private static $db = array (
        'Name' => 'Varchar',
        'Email' => 'Varchar',
        'Comment' => 'Text'
    );

    private static $has_one = array (
        'Article' => 'Article'
    );
}