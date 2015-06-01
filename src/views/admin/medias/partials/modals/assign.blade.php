
<div id="assignModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="assignModal"
     aria-hidden="true">
    {{ Form::open(array('route' => 'admin.medias.save')) }}
    <input id="fileName" name="fileName" type="hidden"/>
    <input id="operation" name="operation" type="hidden" value="--"/>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-orange color-palette">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Assign Media to URL</h4>
            </div>
            <div class="modal-body">
                <!-- /.box-header -->
                <div class="box-body">
                    <!-- Challenge Name -->
                    <div class="row">
                        <div class="col-md-4">
                            <label class="control-label" id="mediaFileName"></label>
                            <a href="#" class="thumbnail media-thumbnail" data-toggle="modal"
                               data-target="#assignModal">
                                <img id="subjectMediaImg" src=""/>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <div class="control-group select ">
                                <label class="select optional control-label">Assign to the following URLs</label>

                                <div class="controls">
                                    <select name="pathSelect" id="pathSelect" class="select btn-default" size="6">
                                        <option value="none" selected>None</option>
                                        <option disabled>──────────</option>
                                        @foreach ($data->paths as $value)
                                            <option value="{{ $value }}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Date Range:</label>
                                <div class="input-group">
                                    <button class="btn btn-default pull-right daterange-btn">
                                        <i class="fa fa-calendar"></i> Pick a Date Range
                                        <i class="fa fa-caret-down"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="control-group">
                            <label>Start Date</label>
                            <input type="text" id="start_date" name="start_date"
                                   class="form-control start_date_field"
                                   placeholder="Not Selected" value="--"/>
                            </div>
                            <div class="control-group">
                                <label>End Date</label>
                                <input type="text" id="end_date" name="end_date"
                                       class="form-control end_date_field"
                                       placeholder="Not Selected" value="--"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="control-group">
                                <label>Position:</label>
                                <input type="text" id="positionTxt" name="positionTxt" class="form-control"
                                       placeholder="e.g. homepageBanner"/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="control-group">
                                <label>ID Attribute:</label>
                                <input type="text" id="attr_idTxt" name="attr_idTxt" class="form-control"
                                       placeholder="e.g. myCSSid"/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="control-group">
                                <label>Class Attribute:</label>
                                <input type="text" id="attr_classTxt" name="attr_classTxt" class="form-control"
                                       placeholder="e.g. myCSSclass"/>
                             </div>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="control-group">


                                <label>Other Attributes:</label>
                                <input type="text" id="other_attsTxt" name="other_attsTxt" class="form-control"
                                       placeholder='e.g. width="100%"'/>


                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="control-group">


                                <label>Order:</label>
                                <input type="text" id="orderTxt" name="orderTxt" class="form-control"
                                       placeholder='e.g. 1, 2, 3, etc'/>


                            </div>
                        </div>
                    </div>
                </div>



            </div>

            <div class="modal-footer">
                <button type="button" class="btn bg-navy btn-flat margin pull-left" data-dismiss="modal">
                    Cancel
                </button>
                <button id="deleteFileBtn" type="button" class="btn bg-red btn-flat margin">Delete File</button>
                <button id="clearAssignmentsBtn" type="button" class="btn bg-orange btn-flat margin">Clear Assignments</button>
                <button id="saveAssignmetsBtn" type="submit" class="btn bg-green btn-flat margin">Save</button>
            </div>
        </div>
    </div>
    {{ Form::close(); }}
</div>

