<div class="beta-content beta-post-show beta-radius3px">
    <div class="beta-post-detail">
        <h1><?php echo $post->title;?></h1>
        <div class="beta-post-extra"><span>
            <?php echo $post->showExtraInfo;?>&nbsp;&nbsp;
            <?php if ($post->category) echo $post->categoryLink;?>
            <?php if ($post->topic) echo $post->topicLink;?>
        </span></div>
        <?php if ($post->contributor):?><div class="beta-thank"><?php echo t('thanks_contribute', 'main', array('{contributor}'=>$post->contributorLink));?></div><?php endif;?>
        <div class="beta-post-content"><?php echo $post->filterContent;?></div>
        
        <div class="beta-post-share">
            <a id="beta-digg-button" class="beta-digg-button" href="javascript:void(0);" data-url="<?php echo aurl('post/digg');?>" rel="nofollow" title="Like" data-id="<?php echo $post->id;?>">
                <span class="digg-plus">+</span><span class="digg-count"><?php echo $post->digg_nums;?></span>
            </a>
        </div>
        
        <?php if ($post->tags):?>
        <div class="beta-post-tags"><?php echo t('tag_label');?><?php echo $post->tagLinks;?></div>
        <?php endif;?>
        <?php if ($post->source):?>
        <div class="beta-post-source"><?php echo t('source_label');?><?php echo $post->sourceLink;?></div>
        <?php endif;?>
    </div>
    <div class="beta-mini-title"><?php echo t('post_comment');?></div>
    <?php if ($post->disable_comment):?>
        <div class="disable_comment"><?php echo t('this_post_is_disable_comment');?></div>
    <?php else:?>
        <div class="beta-create-form"><?php $this->renderPartial('/comment/_create_form', array('comment'=>$comment));?></div>
    <?php endif;?>
    <?php $this->renderPartial('/comment/list', array('comments'=>$comments, 'post'=>$post));?>
</div>
<div class="beta-sidebar">
    <div class="beta-block beta-hot-comment beta-radius3px">
        <?php $this->renderPartial('/comment/_hot_list', array('comments'=>$hotComments, 'post'=>$post));?>
    </div>
    <?php $this->widget('BetaAdvert', array('solt'=>'post_detail_sidebar_ad_01'));?>
    <?php $this->widget('BetaLatestPosts', array('title'=>t('relate_posts'), 'tid'=>$post->topic_id));?>
</div>
<div class="clear"></div>

<div class="hide ajax-jsstr">
    <span class="ajax-send"><?php echo t('ajax_send');?></span>
    <span class="ajax-fail"><?php echo t('ajax_fail');?></span>
    <span class="ajax-rules-invalid"><?php echo t('ajax_comment_rules_invalid');?></span>
    <span class="ajax-has-joined"><?php echo t('you_have_joined');?></span>
</div>

<script type="text/javascript">
$(function(){
	<?php if ($post->getContainCode()) echo 'prettyPrint();';?>
	BetaPost.increaseVisitNums(<?php echo $post->id;?>, '<?php echo aurl('post/visit');?>');
	$(document).one('click', '#beta-digg-button', BetaPost.digg);
	$(document).on('click', '.beta-comment-rating', BetaComment.rating);
	$(document).on('click', '.beta-comment-reply', BetaComment.reply);
});
</script>

<?php cs()->registerCoreScript('cookie');?>
<?php cs()->registerScriptFile(sbu('libs/json.js'), CClientScript::POS_END);?>

