<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Category Courses block.
 *
 * @package    block_category_courses
 * @copyright  2023 Tu Nombre
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class block_category_courses extends block_base
{

    /**
     * Initialize the block.
     */
    public function init()
    {
        $this->title = get_string('pluginname', 'block_category_courses');
    }

    /**
     * Render the block.
     */

    public function get_content()
    {
        global $USER, $PAGE;
        if ($this->content !== null) {
            return $this->content;
        }
        $this->content = new stdClass();
        $this->content->text = '';
        $this->content->footer = '';

        if (!isloggedin() || isguestuser()) {
            $this->content = new stdClass();
            $this->content->text = get_string('notauth', 'block_category_courses');
            return $this->content;
        }

        // Check view capability
        $context = context_block::instance($this->instance->id);
        if (!has_capability('block/category_courses:view', $context)) {
            return $this->content;
        }

        $renderer = $PAGE->get_renderer('core');
        $outputdata = (new \block_category_courses\output\main($USER->id, $this->config))->export_for_template($renderer);
        $this->content->text = $renderer->render_from_template('block_category_courses/main', $outputdata);

        return $this->content;
    }
    /**
     * Load required JS.
     */
    public function get_required_javascript()
    {
        parent::get_required_javascript();
        $this->page->requires->js_call_amd('block_category_courses/dashboard', 'init');
    }

    /**
     * Where the block can be displayed.
     *
     * @return array
     */
    public function applicable_formats()
    {
        return [
            'site-index' => true,
            'course-view' => true,
            'my' => true,
            'my-index' => true
        ];
    }

    /**
     * The block should only be dockable when the title is not empty.
     *
     * @return bool
     */
    public function instance_can_be_docked()
    {
        return (!empty($this->config->title) && parent::instance_can_be_docked());
    }

    /**
     * The block has configuration.
     *
     * @return bool
     */
    public function has_config()
    {
        return true;
    }

    public function hide_header()
    {
        return true;
    }

    public function html_attributes()
    {
        // Get default values.
        $attributes = parent::html_attributes();
        // Append our class to class attribute.
        $attributes['class'] .= ' block_' . $this->name();
        return $attributes;
    }

    /**
     * Allow instance configuration.
     *
     * @return bool
     */
    public function instance_allow_config()
    {
        return true;
    }

    /**
     * Specialization for this block.
     */
    public function specialization()
    {
        if (isset($this->config->title)) {
            $this->title = format_string($this->config->title, true, ['context' => $this->context]);
        } else {
            $this->title = get_string('pluginname', 'block_category_courses');
        }
    }
}
