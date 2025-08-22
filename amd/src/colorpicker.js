// This file is part of Moodle: https://moodle.org/
//
// @module block_category_courses/colorpicker

import $ from 'jquery';

/**
 * Initialize color picker for category color field
 */
export const init = () => {
  // Add color picker to category color fields
  $('input[name*="categorycolor"]').each(function() {
    const $input = $(this);
    // Create color picker wrapper
    const $wrapper = $('<div class="color-picker-wrapper"></div>');
    const $colorInput = $('<input type="color" class="color-picker-input">');
    // Set initial value
    $colorInput.val($input.val() || '#667eea');
    // Update text input when color changes
    $colorInput.on('change', function() {
      $input.val($(this).val());
    });
    // Update color picker when text input changes
    $input.on('change', function() {
      const value = $(this).val();
      if (/^#[0-9A-F]{6}$/i.test(value)) {
        $colorInput.val(value);
      }
    });
    // Insert color picker after text input
    $wrapper.append($colorInput);
    $input.after($wrapper);
    // Add some styling
    $input.css('width', '80px');
    $colorInput.css({
      width: '40px',
      height: '30px',
      border: 'none',
      'margin-left': '10px',
      cursor: 'pointer',
    });
  });
};
