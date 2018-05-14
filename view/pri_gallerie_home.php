<?php
$lblClass = "col-md-2";
$eltClass = "col-md-4";
$btnClass = "btn btn-success";
$form = new Form($GLOBALS['appurl']."/gallerie/createGallerie");
$button = new ButtonBuilder();
echo $form->input()->label('Name')->name('name')->type('text')->lblClass($lblClass)->eltClass($eltClass);
echo $form->input()->label('Description')->name('description')->type('text')->lblClass($lblClass)->eltClass($eltClass);
echo $button->start($lblClass, $eltClass);
echo $button->label('Create')->name('send')->type('submit')->class('btn-success');
echo $button->end();
echo $form->end();
?>
