@extends('laraboard::layouts.forum')

@section('content')
<div id="larauser">
    <h1>Profile</h1>
    {!! Form::open(['route' => 'larauser.update', 'files' => true]) !!}
        <?php /*<div class="form-group{{ ($errors->has('usermeta.username') ? ' has-error' : '') }}">
            {!! Form::label('usermeta[username]', 'Username*') !!}
            {!! Form::text('usermeta[username]', old('usermeta[username]', Auth::user()->usermeta->username), ['class' => 'form-control', 'required']) !!}
            {!! $errors->first('usermeta.username', '<p class="help-block">:message</p>') !!}
        </div>*/ ?>

        <div class="form-group image">
            <div class="row">
                <div class="col-sm-6" style="margin-bottom: 20px;">
                    <img id="mainImage" src="{{ ((Auth::user()->usermeta->avatar) ? Auth::user()->usermeta->avatar : '') }}">
                </div>

                <div class="col-sm-3">
                    <div class="docs-preview clearfix">
                        <div id="avatar" class="img-preview preview-lg">
                            <img src="" style="display: block; min-width: 0px !important; min-height: 0px !important; max-width: none !important; max-height: none !important; margin-left: -32.875px; margin-top: -18.4922px; transform: none;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="btn-group">
                <label class="btn btn-primary btn-file">
                    <span class="glyphicon glyphicon-picture"></span> Upload
                    <input type="file" accept="image/*" id="uploadImage" class="hide">
                    <input type="hidden" id="hiddenImage" name="usermeta[avatar]">
                </label>

                <button class="btn btn-default" id="rotateLeft" type="button" style="display: none;"><i class="fa fa-rotate-left"></i></button>
                <button class="btn btn-default" id="rotateRight" type="button" style="display: none;"><i class="fa fa-rotate-right"></i></button>
                <button class="btn btn-default" id="zoomIn" type="button" style="display: none;"><i class="fa fa-search-plus"></i></button>
                <button class="btn btn-default" id="zoomOut" type="button" style="display: none;"><i class="fa fa-search-minus"></i></button>
                <button class="btn btn-warning" id="reset" type="button" style="display: none;"><i class="fa fa-times"></i></button>
                <button class="btn btn-danger" id="remove" type="button"><i class="fa fa-trash"></i></button>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    {!! Form::close() !!}
</div>
@stop

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.4/cropper.min.js"></script>
<script>
jQuery(document).ready(function($) {
    // Loop through all instances of the image field
    $('.form-group.image').each(function(index){
        // Find DOM elements under this form-group element
        var $mainImage = $(this).find('#mainImage');
        var $uploadImage = $(this).find("#uploadImage");
        var $hiddenImage = $(this).find("#hiddenImage");
        var $rotateLeft = $(this).find("#rotateLeft")
        var $rotateRight = $(this).find("#rotateRight")
        var $zoomIn = $(this).find("#zoomIn")
        var $zoomOut = $(this).find("#zoomOut")
        var $reset = $(this).find("#reset")
        var $remove = $(this).find("#remove")
        // Options either global for all image type fields, or use 'data-*' elements for options passed in via the CRUD controller
        var options = {
            viewMode: 2,
            checkOrientation: false,
            autoCropArea: 1,
            responsive: true,
            preview : $(this).attr('data-preview'),
            aspectRatio : $(this).attr('data-aspectRatio')
        };
        var crop = $(this).attr('data-crop');

        // Hide 'Remove' button if there is no image saved
        if (!$mainImage.attr('src')){
            $remove.hide();
        }
        // Initialise hidden form input in case we submit with no change
        $hiddenImage.val($mainImage.attr('src'));


        // Only initialize cropper plugin if crop is set to true
        if(crop){

            $remove.click(function() {
                $mainImage.cropper("destroy");
                $mainImage.attr('src','');
                $hiddenImage.val('');
                $rotateLeft.hide();
                $rotateRight.hide();
                $zoomIn.hide();
                $zoomOut.hide();
                $reset.hide();
                $remove.hide();
            });
        } else {

            $(this).find("#remove").click(function() {
                $mainImage.attr('src','');
                $hiddenImage.val('');
                $remove.hide();
            });
        }

        $uploadImage.change(function() {
            var fileReader = new FileReader(),
                    files = this.files,
                    file;

            if (!files.length) {
                return;
            }
            file = files[0];

            if (/^image\/\w+$/.test(file.type)) {
                fileReader.readAsDataURL(file);
                fileReader.onload = function () {
                    $uploadImage.val("");
                    if(crop){
                        $mainImage.cropper(options).cropper("reset", true).cropper("replace", this.result);
                        // Override form submit to copy canvas to hidden input before submitting
                        $('form').submit(function() {
                            var imageURL = $mainImage.cropper('getCroppedCanvas').toDataURL();
                            $hiddenImage.val(imageURL);
                            return true; // return false to cancel form action
                        });
                        $rotateLeft.click(function() {
                            $mainImage.cropper("rotate", 90);
                        });
                        $rotateRight.click(function() {
                            $mainImage.cropper("rotate", -90);
                        });
                        $zoomIn.click(function() {
                            $mainImage.cropper("zoom", 0.1);
                        });
                        $zoomOut.click(function() {
                            $mainImage.cropper("zoom", -0.1);
                        });
                        $reset.click(function() {
                            $mainImage.cropper("reset");
                        });
                        $rotateLeft.show();
                        $rotateRight.show();
                        $zoomIn.show();
                        $zoomOut.show();
                        $reset.show();
                        $remove.show();

                    } else {
                        $mainImage.attr('src',this.result);
                        $hiddenImage.val(this.result);
                        $remove.show();
                    }
                };
            } else {
                alert("Please choose an image file.");
            }
        });

    });
});
</script>
@endpush
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.4/cropper.min.css">
@endpush