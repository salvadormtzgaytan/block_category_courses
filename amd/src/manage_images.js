// This file is part of Moodle: https://moodle.org/
//
// @module block_category_courses/manage_images

import Ajax from 'core/ajax';
import Notification from 'core/notification';
import $ from 'jquery';

export const init = () => {
  $('.save-category').on('click', function() {
    const $item = $(this).closest('.category-item');
    const categoryid = $(this).data('categoryid');
    const imageurl = $item.find('.image-url').val();
    const bgcolor = $item.find('.bg-color').val();
    Ajax.call([
      {
        methodname: 'block_category_courses_save_image',
        args: {
          categoryid: categoryid,
          imageurl: imageurl,
          bgcolor: bgcolor,
        },
      },
    ])[0]
      .done(function(response) {
        if (response.success) {
          Notification.addNotification({
            message: 'Category updated successfully',
            type: 'success',
          });
        }
      })
      .fail(function(error) {
        Notification.exception(error);
      });
  });
};
