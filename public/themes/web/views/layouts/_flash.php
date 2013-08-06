<?php if (Yii::app()->user->hasFlash('success') || Yii::app()->user->hasFlash('error')):?>
    <?php if (Yii::app()->user->hasFlash('success')):?>
        <div class="alert alert-success">
            <a class="close" data-dismiss="alert">×</a>
            <?=Yii::app()->user->getFlash('success');?>
        </div>
    <?php endif?>
    <?php if (Yii::app()->user->hasFlash('error')):?>
        <div class="alert alert-error">
            <a class="close" data-dismiss="alert">×</a>
            <?=Yii::app()->user->getFlash('error');?>
        </div>
    <?php endif?>
<?php endif?>
