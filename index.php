<?php
require_once 'init.php';
$theme  = $ini['general']['theme'];
$class  = isset($_REQUEST['class']) ? $_REQUEST['class'] : '';
$public = in_array($class, $ini['permission']['public_classes']);

AdiantiCoreApplication::setRouter(array('AdiantiRouteTranslator', 'translate'));

new TSession;
ApplicationTranslator::setLanguage( TSession::getValue('user_language'), true );

$content = file_get_contents("app/templates/custom_layout.html");

$content = ApplicationTranslator::translateTemplate($content);
$content = AdiantiTemplateParser::parse($content);

echo $content;

AdiantiCoreApplication::loadPage('CharactersView', 'onReload', $_REQUEST);

