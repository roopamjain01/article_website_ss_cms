<?php
class ArticleHolder extends Page {

   private static $has_many = array (
        'Categories' => 'ArticleCategory',
        'SubCategories' => 'ArticleSubCategory',
        'Articles' => 'Article'
    );

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Categories', GridField::create(
            'Categories',
            'Article categories',
            $this->Categories(),
            GridFieldConfig_RecordEditor::create()
        ));

        $fields->addFieldToTab('Root.SubCategories', GridField::create(
            'SubCategories',
            'Article SubCategories',
            $this->SubCategories(),
            GridFieldConfig_RecordEditor::create()
        ));

        $fields->addFieldToTab('Root.Article', GridField::create(
            'Articles',
            'Articles on this page',
            $this->Articles(),
            GridFieldConfig_RecordEditor::create()
        ));

        return $fields;
    }


}

class ArticleHolder_Controller extends Page_Controller {

   public $article_ID = '';

   private static $allowed_actions = array (
        'show',
        'CommentForm'
    );

    public function show(SS_HTTPRequest $request) {
        $article_ID = $request->param('ID');
        $article = Article::get()->byID($article_ID);

        if(!$article) {
            return $this->httpError(404,'That article could not be found');
        }

        return array (
            'Article' => $article,
            'Title' => $article->Title
        );
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
        $comment->ArticlePageID = $article_ID;
        $form->saveInto($comment);
        $comment->write();

       /* Session::clear("FormData.{$form->getName()}.data");
        $form->sessionMessage('Thanks for your comment','good');*/

        //return $this->redirectBack();
    }


}