<?php if (user()->hasFlash('save_adcode_result')):?>
<div class="alert alert-success fade in">
    <a href="javascript:void(0);" data-dismiss="alert" class="close">&times;</a>
    <?php echo user()->getFlash('save_adcode_result');?>
</div>
<?php endif;?>

<?php echo CHtml::form('', 'post', array('class'=>'form-horizontal', 'enctype'=>'multipart/form-data'));?>
<fieldset>
    <legend><?php echo $this->adminTitle;?></legend>
    <div class="control-group bottom10px <?php if ($model->hasErrors('intro')) echo 'error';?>">
        <label class="control-label"><?php echo CHtml::activeLabel($model, 'intro');?></label>
        <div class="controls">
            <?php echo CHtml::activeTextArea($model, 'intro', array('class'=>'span5', 'rows'=>3));?>
            <?php if ($model->hasErrors('intro')):?><p class="help-block"><?php echo $model->getError('intro');?></p><?php endif;?>
        </div>
    </div>
    <div class="control-group bottom10px <?php if ($model->hasErrors('adcode')) echo 'error';?>">
        <label class="control-label"><?php echo CHtml::activeLabel($model, 'adcode');?></label>
        <div class="controls">
            <?php echo CHtml::activeTextArea($model, 'adcode', array('class'=>'span7', 'rows'=>10));?>
            <?php if ($model->hasErrors('adcode')):?><p class="help-block"><?php echo $model->getError('adcode');?></p><?php endif;?>
        </div>
    </div>
    <div class="control-group <?php if($model->hasErrors('state')) echo 'error';?>">
        <?php echo CHtml::activeLabel($model, 'state', array('class'=>'control-label'));?>
        <div class="controls">
            <label class="checkbox inline">
                <?php echo CHtml::activeCheckBox($model, 'state');?><?php echo t('adcode_enabled', 'admin');?>
            </label>
            <?php if($model->hasErrors('state')):?><p class="help-block"><?php echo $model->getError('state');?></p><?php endif;?>
        </div>
    </div>
    <div class="form-actions">
        <input type="submit" value="<?php echo t('submit', 'admin');?>" class="btn btn-primary" />
        <a class="btn" href="<?php echo url('admin/adcode/list', array('adid'=>$model->ad_id));?>"><?php echo t('return_list_page', 'admin');?></a>
    </div>
</fieldset>
<?php echo CHtml::endForm();?>
