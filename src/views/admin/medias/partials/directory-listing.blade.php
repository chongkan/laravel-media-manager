<?php

$contents = array_reverse(array_diff(scandir('media/'), array('..', '.')));

?>
<div class="row directory-listing">
    @foreach($contents as $asset)
        @if(count(explode('.', $asset)) > 1)
            <div class="col-xs-6 col-md-2">
                <a href="#" class="thumbnail media-thumbnail" data-toggle="modal"
                   data-target="#assignModal" data-file="{{$asset}}">

                    {{ '<img src="' . asset('media/'. $asset) . '"/>' }}

                    <!--  '<i class="fa fa-folder"></i> ' . $asset  . '<br>' -->

                </a>
            </div>
        @endif
    @endforeach
</div>