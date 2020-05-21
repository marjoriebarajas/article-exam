@if(session('success_alert'))
    <script type="text/javascript">
        $(function(){
            swal({
                title:  'Success!',
                text:   "{{ session('success_alert') }}",
                type:   'success'
            });
        })
    </script>
@endif

@if(session('error_alert'))
    <script type="text/javascript">
        $(function(){
            swal({
                title:  'Error!',
                text:   "{{ session('error_alert') }}",
                type:   'error'
            });
        })
    </script>
@endif

@if(session('warning_alert'))
    <script type="text/javascript">
        $(function(){
            swal({
                title:  'Notice!',
                text:   "{{ session('warning_alert') }}",
                type:   'warning'
            });
        })
    </script>
@endif