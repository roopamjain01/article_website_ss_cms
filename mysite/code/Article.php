<?php
/**
 * Created by PhpStorm.
 * User: roopam
 * Date: 21-12-2015
 * Time: 03:37 PM
 */

class Article extends DataObject {

    private static $db = array (
        'Date' => 'Date',
        'Teaser' => 'Text',
        'Author' => 'Varchar',
        'Description'=> 'Text'
    );

    private static $has_one = array (
        'Photo' => 'Image',
        'Brochure' => 'File',
        'ArticleHolder' => 'ArticleHolder'
    );

    private static $has_many = array (
        'Comments' => 'ArticleComment'
    );

    private static $summary_fields = array (
        'GridThumbnail' => '',
        'Date' => 'Created Date',
        'Teaser' => 'Teaser',
        'Author' => 'Author',
        'Description'=> 'Description'
    );

    public function getGridThumbnail() {
        if($this->Photo()->exists()) {
            return $this->Photo()->SetWidth(100);
        }
        return "(no image)";
    }

    public function getCMSFields() {
        $fields = FieldList::create(
            TextField::create('Author'),
            TextareaField::create('Teaser'),
            TextareaField::create('Description'),
            DateField::create('Date','Date of article')
                ->setConfig('showcalendar', true)
                ->setConfig('dateformat', 'd MMMM yyyy'),
            $photo = UploadField::create('Photo'),
            $brochure = UploadField::create('Brochure','Travel brochure, optional (PDF only)')
        );

        $photo
            ->setFolderName('article-photos')
            ->getValidator()->setAllowedExtensions(array('gif','png','jpg','jpeg'));

        $brochure
            ->setFolderName('article-brochures')
            ->getValidator()->setAllowedExtensions(array('pdf'));
        return $fields;
    }

    public function Link() {
        return $this->ArticleHolder()->Link('show/'.$this->ID);
    }

    public function CommentForm() {
        $form = Form::create(
            $this,
            __FUNCTION__,
            FieldList::create(
                TextField::create('Name',''),
                EmailField::create('Email',''),
                TextareaField::create('Comment','')
            ),
            FieldList::create(
                FormAction::create('handleComment','Post Comment')
                    ->setUseButtonTag(true)
            ),
            RequiredFields::create('Name','Email','Comment')
        );

        foreach($form->Fields() as $field) {
            $field->setAttribute('placeholder', $field->getName().'*');
        }

        $data = Session::get("FormData.{$form->getName()}.data");

        return $data ? $form->loadDataFrom($data) : $form;
    }

    public function handleComment($data, $form) {
        var_dump($data);
        var_dump($form);
        /*Session::set("FormData.{$form->getName()}.data", $data);
        $existing = $this->Comments()->filter(array(
            'Comment' => $data['Comment']
        ));
        if($existing->exists() && strlen($data['Comment']) > 20) {
            $form->sessionMessage('That comment already exists! Spammer!','bad');

            //return $this->redirectBack();
        }*/
        $comment = ArticleComment::create();
        $comment->ArticlePageID = $this->ID;
        $form->saveInto($comment);
        $comment->write();

        /* Session::clear("FormData.{$form->getName()}.data");
         $form->sessionMessage('Thanks for your comment','good');*/

        //return $this->redirectBack();
    }
}
