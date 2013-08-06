var _motorCache   = new ObjectCache(),
    _escCache     = new ObjectCache(),
    _batteryCache = new ObjectCache(),
    _propCache    = new ObjectCache();


<?foreach($escs as $id => $esc):?>
    _escCache.set(<?=$id?>, <?=json_encode($esc)?>);
<?endforeach?>

<?foreach($props as $id => $prop):?>
    _propCache.set(<?=$id?>, <?=json_encode($prop)?>);
<?endforeach?>

<?foreach($batts as $id => $batt):?>
    _batteryCache.set(<?=$id?>, <?=json_encode($batt)?>);
<?endforeach?>
