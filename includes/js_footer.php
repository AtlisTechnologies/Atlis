    <!-- JAVASCRIPT: All JS at end for best perf & DOM ready -->
    <!-- Core Vendors -->
    <script src="<?php echo getURLDir(); ?>vendors/simplebar/simplebar.min.js"></script>
    <script src="<?php echo getURLDir(); ?>vendors/anchorjs/anchor.min.js"></script>
    <script src="<?php echo getURLDir(); ?>vendors/is/is.min.js"></script>
    <script src="<?php echo getURLDir(); ?>vendors/lodash/lodash.min.js"></script>
    <script src="<?php echo getURLDir(); ?>vendors/list.js/list.min.js"></script>
    <script src="<?php echo getURLDir(); ?>vendors/feather-icons/feather.min.js"></script>
    <script src="<?php echo getURLDir(); ?>vendors/dayjs/dayjs.min.js"></script>
    <script src="<?php echo getURLDir(); ?>vendors/sortablejs/Sortable.min.js"></script>
    <script src="<?php echo getURLDir(); ?>vendors/choices/choices.min.js"></script>
    <script src="<?php echo getURLDir(); ?>vendors/echarts/echarts.min.js"></script>
    <script src="<?php echo getURLDir(); ?>vendors/dropzone/dropzone-min.js"></script>
    <script src="<?php echo getURLDir(); ?>vendors/dhtmlx-gantt/dhtmlxgantt.js"></script>
    <script src="<?php echo getURLDir(); ?>vendors/flatpickr/flatpickr.min.js"></script>
    <script src="<?php echo getURLDir(); ?>vendors/glightbox/glightbox.min.js"></script>
    <?php if (!empty($loadFsLightbox)): ?>
      <script src="<?php echo getURLDir(); ?>vendors/fslightbox/fslightbox.js"></script>
      <script>
        document.addEventListener('DOMContentLoaded', function () {
          if (typeof refreshFsLightbox === 'function') {
            refreshFsLightbox();
          }
        });
      </script>
    <?php endif; ?>

    <!-- Phoenix Core & Config -->
    <script src="<?php echo getURLDir(); ?>assets/js/config.js"></script>
    <script src="<?php echo getURLDir(); ?>assets/js/phoenix.js"></script>
    <?php if (!empty($loadFileManagerJs)): ?>
      <!-- File manager -->
      <script src="<?php echo getURLDir(); ?>assets/js/file-manager.js"></script>
    <?php endif; ?>

    <!-- Project-specific JS (if any) -->
    <script src="<?php echo getURLDir(); ?>assets/js/projectmanagement-dashboard.js"></script>
    <script src="<?php echo getURLDir(); ?>assets/js/project-details.js"></script>

    <!-- FontAwesome (for dynamic icon loading) -->
    <script src="<?php echo getURLDir(); ?>vendors/fontawesome/all.min.js"></script>

  </body>
</html>
