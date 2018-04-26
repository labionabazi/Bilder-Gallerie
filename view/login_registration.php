<?php

  /**
   * Registratons-Formular
   * Das Formular wird mithilfe des Formulargenerators erstellt.
   */

/**
 * Registratons-Formular
 * Das Formular wird mithilfe des Formulargenerators erstellt.
 */
/**
 * Registration-Formular
 * Das Formular wird mithilfe des Formulargenerators erstellt.
 */
$lblClass = "col-md-2";
$eltClass = "col-md-4";
$btnClass = "btn btn-success";
$form = new Form($GLOBALS['appurl'] . "/login/create");
$button = new ButtonBuilder();
echo $form->input()->label('Firstname')->name('firstname')->type('text')->lblClass($lblClass)->eltClass($eltClass);
echo $form->input()->label('Surename')->name('surename')->type('text')->lblClass($lblClass)->eltClass($eltClass);
echo $form->input()->label('E-Mail')->name('email')->type('text')->lblClass($lblClass)->eltClass($eltClass);
echo $form->input()->label('Passwort')->name('passwort')->type('text')->lblClass($lblClass)->eltClass($eltClass);
echo $button->start($lblClass, $eltClass);
echo $button->label('Register')->name('sendData')->type('submit')->class('btn-success');
echo $button->end();
echo $form->end();
?>
