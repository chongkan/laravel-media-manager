@extends('admin::layouts.master')


@section('content-header')
    <h1>
        Media
        <small>
            All Media
        </small>
    </h1>
@stop
@section('style')
    @parent
    {{ mediaManager_style('css/dropzone.css') }}"
@stop
@section('content')
    @if(Session::has('message'))
        <div class="callout callout-warning">
            <h4><i class="icon fa fa-check"></i> {{ Session::get('message') }}</h4>

        </div>
    @endif
    @if ($errors->has())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif
    <div id="saveAlertContainer">

    </div>
    <div class="box box-warning">
        <div class="box-body">
            <div id="dropzone">
                <form action="/admin/medias/upload"
                      class="dropzone"
                      id="my-awesome-dropzone">
                    <div class="fallback">
                        <input name="file" type="file" multiple/>
                    </div>
                    <input type="hidden" id="folder" value=""/>
                </form>
            </div>

        </div>
    </div>
    <div id="directory-list-container" class="box clearfix">
        @include('media-manager::admin.medias.partials.directory-listing')
        <!-- /.box-body -->
    </div>
    <div>

    </div>
    @include('media-manager::admin.medias.partials.modals.assign', array('data' => $data))
@stop


@section('script')
    @parent
    <script src="{{ mediaManager_asset('js/dropzone.js') }}"></script>
    <script src="{{ mediaManager_asset('js/jquery.form.min.js') }}"></script>
    <script src="{{ mediaManager_asset('js/all.js') }}"></script>
    <script>
        Dropzone.autoDiscover = false;

        $(document).on('ready', function () {
            var myDropzone = new Dropzone("#my-awesome-dropzone");
            myDropzone.on("success", function(file, response) {
                /* Maybe display some more file information on your page */
                console.log(response);
                //reload directory
                $("#directory-list-container").load('{{ url('admin/medias/get-all') }}');
            });

            //--------------
            $('#assignModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) ;// Button that triggered the modal
                var file = button.data('file') ;// Extract info from data-* attributes
                var modal = $(this);
                $.ajax({
                    url: '{{ url('admin/medias/get-data') }}',
                    context: $('#assignModal'),
                    method: 'POST',
                    data : {
                        'file' : file
                    }
                }).done(function(response) {
                    var obj = $.parseJSON(response);
                    console.log(obj);
                    if (obj.length > 0) {
                        $('#positionTxt').val(obj[0].position);
                        $('#attr_idTxt').val(obj[0].attr_id);
                        $('#attr_classTxt').val(obj[0].attr_class);
                        $('#other_attsTxt').val(obj[0].other_atts);
                        $('#start_date').val(obj[0].start_date);
                        $('#end_date').val(obj[0].end_date);
                        $("#pathSelect").val(obj[0].url);
                        $('#orderTxt').val(obj[0].order);
                        $('#clearAssignmentsBtn').show();
                    }else{
                        $('#clearAssignmentsBtn').hide();
                    }

                });

                $('#assignModal #mediaFileName').html(file);
                $('#fileName').val(file);
                $('#assignModal #subjectMediaImg').attr('src', '/media/' + file);


            }).on('hide.bs.modal', function (event) {
                $('#positionTxt').val('');
                $('#attr_idTxt').val('');
                $('#attr_classTxt').val('');
                $('#other_attsTxt').val('');
                $("#pathSelect").val('none');
                $('#start_date').val('');
                $('#end_date').val('');
                $('#operation').val('--');
                $('#orderTxt').val('');
            });

            // -------------------------------------

            $('#assignModal form').ajaxForm(function(response) {
                console.log(response);
                $('#assignModal').modal('hide');
                var alert = '<div id="saveMessage" class="alert alert-info alert-dismissible" role="alert">';
                alert += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                alert += '<strong>Success!</strong> Media saved.';
                alert += '</div>';
                $('#saveAlertContainer').html(alert);
                $("#directory-list-container").load('{{ url('admin/medias/get-all') }}');
            });
            //--------------------------------------
            $('#clearAssignmentsBtn').click(function() {
                $('#positionTxt').val('');
                $('#attr_idTxt').val('');
                $('#attr_classTxt').val('');
                $('#other_attsTxt').val('');
                $("#pathSelect").val('none');
                $('#start_date').val('');
                $('#end_date').val('');
                $('#orderTxt').val('');
                $('#assignModal form').submit();
            });
            //---------------------------------------
            $('#deleteFileBtn').click(function() {
                $('#operation').val('delete');
                $('#positionTxt').val('');
                $('#attr_idTxt').val('');
                $('#attr_classTxt').val('');
                $('#other_attsTxt').val('');
                $("#pathSelect").val('none');
                $('#start_date').val('');
                $('#end_date').val('');
                $('#orderTxt').val('');
                $('#assignModal form').submit();
            });

        });
    </script>
@stop
