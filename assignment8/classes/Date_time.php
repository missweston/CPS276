<?php
require_once 'classes/Pdo_methods.php';

class Date_time {

    /** Entry point — determines what to do based on which button was clicked */
    public function checkSubmit() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return '';
        }

        if (isset($_POST['addNote'])) {
            return $this->handleAddNote();
        }

        if (isset($_POST['getNotes'])) {
            return $this->handleGetNotes();
        }

        return '';
    }

    /** Handle adding a note to the database */
    private function handleAddNote() {
        // Check that all required inputs are filled
        if (empty($_POST['dateTime']) || !isset($_POST['note']) || trim($_POST['note']) === '') {
            return '<p> You need to enter a date, time, and note. </p>';
        }

        //Convert the datetime
        $ts = strtotime($_POST['dateTime']);
        if ($ts === false) {
            return '<p> Enter a valid date and time.</p>';
        }

        // Insert into your table (notes)
        $pdo = new Pdo_methods();
        $sql = "INSERT INTO notes (note_time, note_holder) VALUES (:note_time, :note_holder)";
        $bindings = [
            [':note_time', $ts, 'int'],
            [':note_holder', trim($_POST['note']), 'str'],
        ];



        $result = $pdo->otherBinded($sql, $bindings);
        return ($result === 'error') ? '<p> There was an error adding the note. </p>' : '<p> Note added.</p>';
    }

    /** Handle fetching notes between two date ranges */
    private function handleGetNotes() {
        // Both dates must be provided
        if (empty($_POST['begDate']) || empty($_POST['endDate'])) {
            return '<p> No notes found for the date range selected </p>';
        }

        // Convert to timestamps
        $begTs = strtotime($_POST['begDate'] . ' 00:00:00');
        $endTs = strtotime($_POST['endDate'] . ' 23:59:59');

        if ($begTs === false || $endTs === false) {
            return '<p> No notes found for the date range selected </p>';
        }

        // Swap if reversed
        if ($endTs < $begTs) {
            [$begTs, $endTs] = [$endTs, $begTs];
        }

        // Query between timestamps
        $pdo = new Pdo_methods();
        $sql = "SELECT note_time, note_holder
                FROM notes
                WHERE note_time BETWEEN :begDate AND :endDate
                ORDER BY note_time DESC";
        $bindings = [
            [':begDate', $begTs, 'int'],
            [':endDate', $endTs, 'int'],
        ];

        $rows = $pdo->selectBinded($sql, $bindings);
        if ($rows === 'error' || count($rows) === 0) {
            return '<p> No notes found for the date range selected </p>';
        }

        // Build a table of results
        $output = "<table class='table table-bordered table-striped'>";
        $output .= "<thead><tr><th>Date &amp; Time</th><th>Note</th></tr></thead><tbody>";

        foreach ($rows as $r) {
            // Convert timestamp back to readable date/time
            $prettyDate = date('m/d/Y h:i A', (int)$r['note_time']);
            $noteText   = (htmlspecialchars($r['note_holder']));
            $output .= "<tr><td>{$prettyDate}</td><td>{$noteText}</td></tr>";
        }

        $output .= "</tbody></table>";
        return $output;
    }
}
