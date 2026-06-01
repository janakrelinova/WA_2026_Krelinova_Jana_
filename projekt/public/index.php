<?php
// public/index.php

// 1. Spuštění session a načtení databáze (to už máš)
session_start();
require_once '../app/models/Database.php';

// 2. Načtení ovladačů (Zkontroluj, zda tu máš CommentController!)
require_once '../app/controllers/AuthController.php';
require_once '../app/controllers/TripController.php';
require_once '../app/controllers/CommentController.php'; // <--- TADY

$database = new Database();
$db = $database->getConnection();

// 3. Inicializace ovladačů (Zkontroluj, zda předáváš $db!)
$authController = new AuthController($db);
$tripController = new TripController($db);
$commentController = new CommentController($db); // <--- TADY

// Načtení akce z adresy
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

// 4. ROZCESTNÍK (Zkontroluj velká a malá písmena v názvech akcí)
if ($action == 'index') {
    $tripController->index();

} elseif ($action == 'register') {
    $authController->register();

} elseif ($action == 'login') {
    $authController->login();

} elseif ($action == 'authenticate') {
    $authController->authenticate();

} elseif ($action == 'logout') {
    $authController->logout();

} elseif ($action == 'create') {
    $tripController->create();

} elseif ($action == 'show' && $id) {
    $tripController->show($id);

} elseif ($action == 'edit' && $id) {
    $tripController->edit($id);

} elseif ($action == 'delete' && $id) {
    $tripController->delete($id);

} elseif ($action == 'addComment') { 
    $commentController->create();

} elseif ($action == 'deleteComment' && $id) {
    $commentController->delete($id);

} elseif ($action == 'editComment' && $id) { 
    $commentController->edit($id);

} elseif ($action == 'profile') {
    $authController->profile();

} elseif ($action == 'deleteUser' && $id) {
    $authController->deleteUser($id);

} else {
    // Sem web skočí, když akci addComment nerozpozná – proto tě to hází domů!
    $tripController->index(); 
}