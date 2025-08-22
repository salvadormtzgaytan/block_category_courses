<?php
namespace block_category_courses\output;

use renderable;
use templatable;
use renderer_base;
use block_myoverview\output\main as overview_main;

/**
 * Wrapper around block_myoverview course overview data.
 */
class main implements renderable, templatable {
    /** @var int User id */
    protected $userid;
    /** @var \stdClass|null Block configuration */
    protected $config;

    public function __construct($userid, $config = null) {
        $this->userid = $userid;
        $this->config = $config;
    }

    public function export_for_template(renderer_base $output) {
        $overview = new overview_main($this->userid, $this->config);
        return $overview->export_for_template($output);
    }
}
