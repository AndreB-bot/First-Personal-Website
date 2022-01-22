<?php
session_start();

if ($_SESSION['session_id'] === session_id()) {
include '../scripts/nav.php';
include '../html/meetings.html';
include '../scripts/footer.php';
}