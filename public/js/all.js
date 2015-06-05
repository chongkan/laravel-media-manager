$(document).ready(function () {

    var formAction = '';

    $('.daterange-btn').daterangepicker({
            inline: true,
            format: 'MM-DD-YYYY h:mm A',
            startDate: '06-01-2015',
            endDate: '06-01-2015',
            timePicker: true,
            timePickerIncrement: 1,
            timePicker12Hour: true,
            timePickerSeconds: false
        },
        function (start, end) {
            $('.start_date_field').val(start.format('YYYY-MM-DD h:mm A'));
            $('.end_date_field').val(end.format('YYYY-MM-DD h:mm A'));
        });

    //--------------
    $('#editModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);// Button that triggered the modal
        var caption = button.data('caption');// Extract info from data-* attributes
        var modal = $(this);
        var form = modal.find('form');
        var recordId = button.data('record-id');
        modal.find('.modal-body textarea').val(caption);
        var url = form.attr('action');
        formAction = url;
        form.attr('action', url + '/' + recordId);
    }).on('hide.bs.modal', function (event) {
        var modal = $(this);
        var form = modal.find('form');
        form.attr('action', formAction);
    });

    //--------------
    $('#deleteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);// Button that triggered the modal
        var caption = button.data('caption');// Extract info from data-* attributes
        var modal = $(this);
        var form = modal.find('form');
        var recordId = button.data('record-id');
        modal.find('h3').html('\"' + caption + '\"');
        var url = form.attr('action');
        formAction = url;
        form.attr('action', url + '/' + recordId);
    }).on('hide.bs.modal', function (event) {
        var modal = $(this);
        var form = modal.find('form');
        form.attr('action', formAction);
    });


});
