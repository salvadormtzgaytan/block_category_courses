<?php
namespace block_category_courses\output;

use renderable;
use templatable;
use core_course_category;
use core_completion\progress;
use moodle_url;
use context_coursecat;
use context_system;
use cache;
use Exception;

/**
 * Renderable y Templatable para tarjetas de categorías.
 */
class main implements renderable, templatable {
    private $userid;
    private $config;

    public function __construct($userid, $config = null) {
        $this->userid = $userid;
        $this->config = $config;
    }

    public function export_for_template($output = null) {
        global $DB;

        $categories = $this->get_user_categories();
        $categories = $this->apply_sorting($categories);
        $categories = $this->apply_limits($categories);

        $data = [
            'categories' => $categories,
            'config' => $this->get_display_config()
        ];

        return $data;
    }

    private function get_user_categories() {
        global $DB;
        
        $categories = [];
        
        // Check if user is admin
        if (is_siteadmin()) {
            // Admins see ALL categories without restrictions
            $allcategories = core_course_category::get_all();
            foreach ($allcategories as $category) {
                $categories[$category->id] = $this->build_category_data($category);
                $categories[$category->id]['total_courses'] = $category->coursecount;
                $categories[$category->id]['completed_courses'] = 0;
                $categories[$category->id]['progress_percentage'] = 0;
            }
        } else {
            // Regular users see only enrolled courses
            $usercourses = enrol_get_my_courses(['summary' => true]);
            
            foreach ($usercourses as $course) {
                $catid = $course->category;
                
                if (!isset($categories[$catid])) {
                    $category = core_course_category::get($catid, IGNORE_MISSING);
                    if ($category) {
                        $categories[$catid] = $this->build_category_data($category);
                    }
                }
                
                if (isset($categories[$catid])) {
                    $this->add_course_to_category($categories[$catid], $course);
                }
            }
        }
        
        return array_values($categories);
    }
    
    private function build_category_data($category) {
        $image = $this->get_category_image($category);
        $color = $this->get_category_color($category);
        $textcolor = $this->get_text_color_for_background($color);
        
        return [
            'id' => $category->id,
            'name' => format_string($category->name),
            'description' => $this->get_category_description($category),
            'image' => $image,
            'color' => $color,
            'textcolor' => $textcolor,
            'clickbehavior' => $this->get_config_value('clickbehavior', 'category'),
            'url' => (new moodle_url('/course/index.php', ['categoryid' => $category->id]))->out(false),
            'courses' => [],
            'total_courses' => 0,
            'completed_courses' => 0,
            'progress_percentage' => 0
        ];
    }
    
    private function add_course_to_category(&$category, $course) {
        $progress = progress::get_course_progress_percentage($course, $this->userid);
        $iscompleted = ($progress === 100.0);
        
        $category['total_courses']++;
        if ($iscompleted) {
            $category['completed_courses']++;
        }
        
        $category['progress_percentage'] = $category['total_courses'] > 0 ? 
            round(($category['completed_courses'] / $category['total_courses']) * 100) : 0;
    }
    
    private function get_category_description($category) {
        if (!$this->get_config_value('showdescription', true)) {
            return '';
        }
        
        $limit = $this->get_config_value('descriptionlimit', 150);
        $description = strip_tags($category->description);
        
        if (strlen($description) > $limit) {
            $description = substr($description, 0, $limit) . '...';
        }
        
        return $description;
    }
    
    private function get_category_image($category) {
        global $DB;
        
        // 1. Try uploaded file first (if exists)
        try {
            if ($DB->get_manager()->table_exists('block_catcourse_images')) {
                $customdata = $DB->get_record('block_catcourse_images', ['categoryid' => $category->id]);
                if ($customdata && !empty($customdata->imageurl)) {
                    // Check if file actually exists
                    $context = context_system::instance();
                    $fs = get_file_storage();
                    $files = $fs->get_area_files($context->id, 'block_category_courses', 'categoryimage', $category->id, 'filename', false);
                    if (!empty($files)) {
                        $file = reset($files);
                        return moodle_url::make_pluginfile_url(
                            $context->id,
                            'block_category_courses',
                            'categoryimage',
                            $category->id,
                            '/',
                            $file->get_filename()
                        )->out();
                    }
                }
            }
        } catch (Exception $e) {
            // Table doesn't exist yet
        }
        
        // 2. Try to extract from description
        if (!empty($category->description)) {
            if (preg_match('/<img[^>]+src=["\']([^"\'>]+)["\'][^>]*>/i', $category->description, $matches)) {
                $imageurl = $matches[1];
                if ($this->is_valid_image_url($imageurl)) {
                    return $imageurl;
                }
            }
            if (preg_match('/pluginfile\.php\/[^\s"\'>]+\.(jpg|jpeg|png|gif|webp)/i', $category->description, $matches)) {
                return $matches[0];
            }
        }
        
        // 3. Fallback: generate initials with custom color
        $color = $this->get_category_color($category);
        return $this->generate_fallback_image($category->name, $color);
    }
    
    private function get_category_color($category) {
        global $DB;
        
        // Try custom table first (if exists)
        try {
            if ($DB->get_manager()->table_exists('block_catcourse_images')) {
                $customdata = $DB->get_record('block_catcourse_images', ['categoryid' => $category->id]);
                if ($customdata && !empty($customdata->bgcolor)) {
                    return $customdata->bgcolor;
                }
            }
        } catch (Exception $e) {
            // Table doesn't exist yet
        }
        
        // Fallback: generate color based on category name
        $colors = ['#667eea', '#764ba2', '#f093fb', '#f5576c', '#4facfe', '#43e97b', '#fa709a', '#ffecd2'];
        $index = abs(crc32($category->name)) % count($colors);
        return $colors[$index];
    }
    
    private function is_valid_image_url($url) {
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
        $extension = strtolower(pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION));
        return in_array($extension, $imageExtensions);
    }
    
    private function generate_fallback_image($name, $color = '#667eea') {
        $initials = '';
        $words = explode(' ', $name);
        foreach (array_slice($words, 0, 2) as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }
        return ['type' => 'initials', 'text' => $initials, 'color' => $color];
    }
    
    private function apply_sorting($categories) {
        $sortorder = $this->get_config_value('sortorder', 'core');
        
        switch ($sortorder) {
            case 'alphabetical':
                usort($categories, function($a, $b) {
                    return strcmp($a['name'], $b['name']);
                });
                break;
            case 'coursecount':
                usort($categories, function($a, $b) {
                    return $b['total_courses'] - $a['total_courses'];
                });
                break;
            case 'progress':
                usort($categories, function($a, $b) {
                    return $b['progress_percentage'] - $a['progress_percentage'];
                });
                break;
            // 'core' keeps original order
        }
        
        return $categories;
    }
    
    private function apply_limits($categories) {
        $maxcategories = $this->get_config_value('maxcategories', 12);
        return array_slice($categories, 0, $maxcategories);
    }
    
    private function get_display_config() {
        return [
            'showprogress' => $this->get_config_value('showprogress', true),
            'showdescription' => $this->get_config_value('showdescription', true),
            'showcoursecount' => $this->get_config_value('showcoursecount', true)
        ];
    }
    
    private function get_config_value($key, $default) {
        // Instance config takes precedence
        if (isset($this->config->$key)) {
            return $this->config->$key;
        }
        
        // Fall back to global config
        return get_config('block_category_courses', $key) ?? $default;
    }
    
    private function get_text_color_for_background($hexcolor) {
        // Remove # if present
        $hex = ltrim($hexcolor, '#');
        
        // Convert to RGB
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        
        // Calculate luminance using WCAG formula
        $luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;
        
        // Return white for dark backgrounds, dark for light backgrounds
        return $luminance > 0.5 ? '#1f2937' : '#ffffff';
    }
}
