<?php $this->beginContent('//layouts/main'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="span3">
            <?php if (!empty($this->leftMenu)):?>
            <div class="well sidebar-nav">
                <?php $this->widget('application.widgets.backend.AdminMenuWidget', array(
                'items' => $this->leftMenu,
                'htmlOptions' => array('class' => 'nav'),
                'encodeLabel' => false,
            ));?>
            </div>
            <?php else:?>
            &nbsp;
            <?php endif?>

        </div><!--/span-->
        <div class="span8">
            <?php $this->renderPartial('//layouts/_flash') ?>

            <?php $this->widget('application.widgets.backend.AdminBreadcrumbs', array('links' => $this->breadcrumbs));?>

            <?=$content;?>
        </div><!--/span-->
    </div><!--/row-->
    <hr/>

    <footer> <p>&copy; <?=Y::app()->name?> <?=date('Y');?></p></footer>
</div>
<?php $this->endContent();?>
