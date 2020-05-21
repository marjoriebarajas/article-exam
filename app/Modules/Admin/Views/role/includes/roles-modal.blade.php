<div class="modal fade" id="roles-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        {!! Form::open(['url'=> '','method'=>'POST','role'=>'form','id'=>'role-form']) !!}
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-plus-circle"></i>  Add Role</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>        
            <div class="modal-body">
                {!! Form::hidden('_method', 'POST') !!}
                <div class="loader text-center">
                    <div>
                        <i class="fa fa-spinner fa-spin fa-3x text-primary"></i>
                        <br>
                        <span>Please Wait</span>
                    </div>
                </div>
                <div class="form-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label"><i class="asterisk" style="color:red;">*</i> Display Name</label>
                                <div class="col-md-8">
                                    {!! Form::text('name', '', ['class' => 'form-control', 'id' => 'role_name', 'autocomplete' => 'off'] ) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label"><i class="asterisk" style="color:red;">*</i> Description</label>
                                <div class="col-md-8">
                                    {!! Form::text('description', '', ['class' => 'form-control', 'id' => 'description', 'autocomplete' => 'off'] ) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button class="btn btn-primary btn-loading" id="role-save-btn" data-loading-text="<i class='fa fa-refresh fa-spin'> </i> Saving...">&nbsp;Save&nbsp;</button>
            </div>
        </div>
        {!! Form::close()!!}
    </div>
</div>