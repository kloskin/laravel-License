document.addEventListener('DOMContentLoaded', function() {
    var categorySelect = document.getElementById('categorySelect');
    var tableRows = document.querySelectorAll('table tbody tr');

    // Sprawdź, czy element categorySelect istnieje
    if (categorySelect) {
        categorySelect.addEventListener('change', function() {
            var selectedCategory = this.value;
            tableRows.forEach(function(row) {
                if (selectedCategory == '0' || row.getAttribute('data-category') === selectedCategory) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

});
$('.dropdown').on('show.bs.dropdown', function () {
    $(this).find('.dropdown-menu').first().stop(true, true).fadeIn(300);
});

$('.dropdown').on('hide.bs.dropdown', function () {
    $(this).find('.dropdown-menu').first().stop(true, true).fadeOut(300);
});