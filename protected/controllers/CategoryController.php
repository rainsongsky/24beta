<?php
class CategoryController extends Controller
{
    public function actionPosts($id)
    {
        $id = (int)$id;
        $category = Category::model()->findByPk($id);
        if ($category === null)
            throw new CHttpException(403, t('category_is_not_found'));
        
        $data = self::fetchCategoryPosts($id);
        
        $this->setSiteTitle(t('category_posts', 'main', array('{name}'=>$category->name)));
        $this->setPageKeyWords($category->name);
        $this->setPageDescription(t('category_posts_page_description', 'main', array('{name}' => $category->name)));
        
        $this->channel = $id;
        cs()->registerMetaTag('all', 'robots');
        
        $listType = param('post_list_type');
        $view = ($listType == POST_LIST_TYPE_SUMMARY) ? '/post/_summary_list' : '/post/_title_list';
        $data['blockTitle'] = t('category_posts', 'main', array('{name}'=>$category->name));
        $postListHtml = $this->renderPartial($view, $data, true);
        
        $feedTitle = $category->name . t('category_feed');
        cs()->registerLinkTag('alternate', 'application/rss+xml', aurl('feed/category', array('id'=>$id)), null, array('title'=>$feedTitle));
        
        $this->render('posts', array(
            'category' => $category,
            'postListHtml' => $postListHtml,
        ));
    }
    
    private static function fetchCategoryPosts($id)
    {
        $criteria = new CDbCriteria();
        if (param('post_list_type') == POST_LIST_TYPE_TITLE)
            $criteria->select = array('t.id', 't.title', 't.visit_nums', 't.comment_nums', 't.create_time');
        $criteria->order = 't.istop, t.create_time desc, t.id desc';
        $criteria->addColumnCondition(array('category_id' => $id))
            ->addCondition('t.state = :state');
        $criteria->params += array(':state'=>POST_STATE_ENABLED);
    
        $count = Post::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->setPageSize(param('postCountOfTitleListPage'));
        $pages->applyLimit($criteria);
        $posts = Post::model()->findAll($criteria);
    
        return array(
            'posts' => $posts,
            'pages' => $pages,
        );
    }
}