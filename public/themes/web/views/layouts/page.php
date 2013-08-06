<? $this->beginContent('//layouts/main') ?>

<?if(!$this->hideBreadcrumbs):?>
<div class="breadcrumbs">
    <ul class="breadcrumb">
        <li class="parent"><?=$this->pageTitle?></li>
    </ul>
</div>
<?endif?>

    <?=$content?>

<? $this->endContent() ?>
