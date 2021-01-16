<?
@$datain = date('Y-m-d H:i:s');
$a=<<<MARKER
<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE yml_catalog SYSTEM "shops.dtd">
<yml_catalog date="$datain">
<shop>
<name>$firmName</name>
<currencies>
        <currency id="UAH" rate="1"/>
</currencies>
<catalog>

MARKER;
?>