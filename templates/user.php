<?php namespace ProcessWire;

include("../../index.php");
$item = $users->get('admin');
$item->setOutputFormatting(false);
$item->name = $sanitizer->pageName("fedeb");
$users->save($item);

echo $item;

 ?>