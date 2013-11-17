@if ($message = Session::get('success'))
<div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>{{trans('pages.flashsuccess')}}:</strong> {{ $message }}
</div>
{{ Session::forgeT('success') }}
@endif

@if ($message = Session::get('error'))
<div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>{{trans('pages.flasherror')}}:</strong> {{ $message }}
</div>
{{ Session::forgeT('error') }}
@endif

@if ($message = Session::get('warning'))
<div class="alert alert-warning alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>{{trans('pages.flashwarning')}}:</strong> {{ $message }}
</div>
{{ Session::forgeT('warning') }}
@endif

@if ($message = Session::get('info'))
<div class="alert alert-info alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>{{trans('pages.flashinfo')}}:</strong> {{ $message }}
</div>
{{ Session::forgeT('info') }}
@endif
