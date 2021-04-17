<?php
use phpformbuilder\Form;

/* =============================================
    start session and include form class
============================================= */

session_start();
include_once rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/phpformbuilder/Form.php';

/* =============================================
    validation if posted
============================================= */

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // check which form has been posted

    if (isset($_POST['search-form-1']) && Form::testToken('search-form-1') === true) {
        if ($_POST['search-input-1'] == '') {
            $search_result = '<p class="alert alert-danger">No result found</p>' . "\n";
        } else {
            $search_result = '<div class="alert alert-success"><ul><strong>1 result found</strong> : <li>' . addslashes($_POST['search-input-1']) . '</li></ul></div>' . "\n";
        }
        Form::clear('search-form-1');
    } elseif (isset($_POST['search-form-2']) && Form::testToken('search-form-2') === true) {
        if ($_POST['search-input-2'] == '') {
            $search_result = '<p class="alert alert-danger">No result found</p>' . "\n";
        } else {
            $search_result = '<div class="alert alert-success"><ul><strong>1 result found</strong> : <li>' . addslashes($_POST['search-input-2']) . '</li></ul></div>' . "\n";
        }
        Form::clear('search-form-2');
    }
}

/* ==================================================
    The Form
================================================== */

$form = new Form('search-form-1', 'vertical', 'novalidate', 'foundation');
// $form->setMode('development');

/* =============================================
    <div class="input-group">
      <input class="input-group-field" type="number">
      <div class="input-group-button">
        <input type="submit" class="button" value="Submit">
      </div>
    </div>
============================================= */

$options = array(
    'elementsWrapper' => '<div class="input-group"></div>',
    'verticalLabelClass' => '',
    'horizontalElementCol' => 'input-group-button'
);
$form->setOptions($options);
$form->startFieldset('1<sup>st</sup> Search Form - search in json list');

$addon = '<button class="success button ladda-button" data-style="zoom-in" type="submit"><span class="fi fi-magnifying-glass"></span></button>';
$form->addAddon('search-input-1', $addon, 'after');
$form->addHelper('Type for example "A"', 'search-input-1');
$form->addInput('text', 'search-input-1', '', 'Search something:', 'placeholder=Search here ...');

$form->endFieldset();
$complete_list = [
    '%availableTags%' =>
    '
    "ActionScript",
    "AppleScript",
    "Asp",
    "BASIC",
    "C",
    "C++",
    "Clojure",
    "COBOL",
    "ColdFusion",
    "Erlang",
    "Fortran",
    "Groovy",
    "Haskell",
    "Java",
    "JavaScript",
    "Lisp",
    "Perl",
    "PHP",
    "Python",
    "Ruby",
    "Scala",
    "Scheme"
    '
];
$form->addPlugin('autocomplete', '#search-input-1', 'default', $complete_list);

/* 2nd form (Ajax search) */

$form_2 = new Form('search-form-2', 'vertical', 'novalidate', 'foundation');
$form_2->setMode('development');

$form_2->startFieldset('2<sup>nd</sup> Search Form - search with ajax request');

$addon = '<button class="success button ladda-button" data-style="zoom-in" type="submit"><span class="fi fi-magnifying-glass"></span></button>';
$form_2->addAddon('search-input-2', $addon, 'after');
$form_2->addHelper('Type at lease 2 characters', 'search-input-2');
$form_2->addInput('text', 'search-input-2', '', 'First name:', 'placeholder=Search here ...');

$form_2->endFieldset();
$replacements = [
    '%remote%' => 'search-form-autocomplete/complete.php',
    '%minLength%' => '2'
];
$form_2->addPlugin('autocomplete', '#search-input-2', 'remote', $replacements);

/* 3rd form (Ajax search with select multiple & tags) */

$form_3 = new Form('search-form-3', 'vertical', 'novalidate', 'foundation');
$form_3->setMode('development');

$form_3->startFieldset('3<sup>rd</sup> Search Form - Ajax search with multiple tags results');

$addon = '<button class="success button ladda-button" data-style="zoom-in" type="submit"><span class="fi fi-magnifying-glass"></span></button>';
$form_3->addAddon('search-input-3', $addon, 'after');
$form_3->addHelper('Type at lease 2 characters', 'search-input-3');
$form_3->addInput('text', 'search-input-3', '', 'First name:', 'data-placeholder=Search here ...');

$form_3->endFieldset();

$replacements = [
    '%remote%' => 'search-form-autocomplete/complete.php',
    '%minLength%' => '2'
];
$form_3->addPlugin('autocomplete', '#search-input-3', 'remote-tags', $replacements);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Foundation Autocomplete Search Form - How to create PHP forms easily</title>
    <meta name="description" content="Foundation Form Generator - how to create an autocompleting Search Form with Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/foundation-forms/search-form.php" />

    <!-- Foundation CSS -->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.5.0/css/foundation.min.css" rel="stylesheet">

    <!-- foundation icons -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundicons/3.0.0/foundation-icons.min.css">
    <?php

        /* =============================================
            CODE PREVIEW - REMOVE THIS IN YOUR FORMS
        ============================================= */

        include_once '../assets/code-preview-head.php';
    ?>
    <?php
    $form->printIncludes('css');
    $form_3->printIncludes('css');
    ?>
</head>
<body>
    <h1 class="text-center">Php Form Builder - Search Form<br><small>with JSON or Ajax  autocomplete</small></h1>
    <div class="grid-container">
        <div class="grid-x grid-padding-x">
            <div class="small-10 small-offset-1 medium-8 medium-offset-2 cell">
            <?php
            if (isset($search_result)) {
                echo $search_result;
            }
            $form->render();
            $form_2->render();
            $form_3->render();
            ?>
            </div>
        </div>
    </div>

    <!-- jQuery -->

    <script src="//code.jquery.com/jquery.min.js"></script>
    <?php
        $form->printIncludes('js');
        $form_3->printIncludes('js');
        $form->printJsCode();
        $form_2->printJsCode();
        $form_3->printJsCode();
    ?>
    <?php

        /* =============================================
            CODE PREVIEW - REMOVE THIS IN YOUR FORMS
        ============================================= */

        include_once '../assets/code-preview-body.php';
    ?>
</body>
</html>
