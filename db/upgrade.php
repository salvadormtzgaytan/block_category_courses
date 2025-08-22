<?php
defined('MOODLE_INTERNAL') || die();

function xmldb_block_category_courses_upgrade($oldversion) {
    global $DB;
    $dbman = $DB->get_manager();

    if ($oldversion < 2025073006) {
        // Define table block_catcourse_images to be created.
        $table = new xmldb_table('block_catcourse_images');

        // Adding fields to table.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('categoryid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('imageurl', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('bgcolor', XMLDB_TYPE_CHAR, '7', null, null, null, '#667eea');
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);

        // Adding keys to table.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_key('categoryid', XMLDB_KEY_UNIQUE, ['categoryid']);

        // Conditionally launch create table.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        upgrade_block_savepoint(true, 2025073006, 'category_courses');
    }

    return true;
}