<div class="row">
	<div class="col-md-12">
		<div class="form-group">
            <label class="control-label col-md-3"><i class="asterisk" style="color:red;">*</i> Title :</label>
            <div class="col-md-7">
				{!! Form::text('title', null , ['class'=>'form-control', 'placeholder'=>'Enter Title', 'autocomplete'=>'off']) !!}
			</div>
		</div>
		<div class="form-group">
            <label class="control-label col-md-3"><i class="asterisk" style="color:red;">*</i> Content :</label>
            <div class="col-md-7">
                {!! Form::textarea('content', null , ['class'=>'form-control', 'id'=>'content', 'rows'=>'7', 'autocomplete'=>'off']) !!}
            </div>
        </div>
        <div class="form-group">
			<label class="control-label col-md-3"><i class="asterisk" style="color:red;">*</i> Status :</label>
			<div class="col-md-7">
				{!! Form::select('status', $status, null, ['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=> '-- Select --']) !!}
			</div>
		</div>
		<div class="form-group">
            <label class="control-label col-md-3"><i class="asterisk" style="color:red;">*</i> Publish Date :</label>
            <div class="col-md-7">
                <div class="input-group date">
                    {!! Form::text('published_date', null , ['class'=>'form-control input-datepicker', 'id' => 'published_date', 'data-mask']) !!}
                    <div class="input-group-addon">
                    	<span class="fa fa-calendar"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"> Expiring Date :<br><a href="javscript:void(0)" class="small" id="clear_expiring_at"><u class="text-warning">Clear date</u></a></label>
            <div class="col-md-7">
                <div class="input-group date">
                	{!! Form::text('expired_date', null, ['class' => 'form-control input-datepicker', 'id' => 'expired_date', 'data-mask'] ) !!}
                    <div class="input-group-addon">
                    	<span class="fa fa-calendar"></span>
                    </div>
                </div>
                <p class="help-block small"><span class="text-aqua">Leave it blank if no expiring date.</span></p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"> Thumbnail :<br><a href="javscript:void(0)" class="small" id="remove_image"><u class="text-warning">Remove Image</u></a></label>
            <div class="col-md-7">
                {{ Form::file('thumbnail', ['id' => 'thumbnail', 'class' => 'form-control']) }}
                <p class="help-block small"><span class="text-red">Max File size is 10MB</span></p>
                {!! Form::hidden('old_image', null, ['id' => 'old_image'] ) !!}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3"></label>
            <div class="col-md-7">
                <img src="{{ !empty($article->thumbnail) ? get_article_thumbnail_path($article->thumbnail) : '' }}" id="image-preview" alt="Uploaded Thumbnail Preview" class="img-responsive" style="{{ empty($article->thumbnail) ? 'display: none;' : ''  }}">
            </div>
        </div>
	</div>
</div>