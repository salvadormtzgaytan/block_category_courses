<?php
namespace block_category_courses\privacy;

use core_privacy\local\metadata\null_provider;

/**
 * Privacy provider for block_category_courses.
 *
 * @package    block_category_courses
 * @copyright  2023
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class provider implements null_provider {

    /**
     * Get the language string identifier with the component's language
     * file to explain why this plugin stores no data.
     *
     * @return  string
     */
    public static function get_reason() : string {
        return 'privacy:metadata';
    }
}