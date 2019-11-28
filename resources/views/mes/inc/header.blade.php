<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<link href="{{ asset('css/mes.css') }}" rel="stylesheet">
<link href="/1_smt/node_modules/bootstrap4-toggle/css/bootstrap4-toggle.css" rel="stylesheet" type="text/css">
<script src="/1_smt/node_modules/bootstrap4-toggle/js/bootstrap4-toggle.js" defer></script>

<link href="/1_smt/node_modules/select2/dist/css/select2.css" rel="stylesheet">
<script src="/1_smt/node_modules/select2/dist/js/select2.js" defer></script>

<script src="{{ asset('js/mes/app.js') }}"></script>
<script src="{{ asset('js/mes/app2.js') }}"></script>
<script src="{{ asset('js/mes/fl.js') }}" defer></script>
<script src="{{ asset('js/mes/cl.js') }}" defer></script>
<script src="{{ asset('js/mes/ml.js') }}" defer></script>
<script src="{{ asset('js/mes/ls.js') }}" defer></script>
<script src="{{ asset('js/mes/el.js') }}" defer></script>
<script src="{{ asset('js/mes/ln.js') }}" defer></script>
<script src="{{ asset('js/mes/modl.js') }}" defer></script>

{{-- Process --}}
<script src="{{ asset('js/mes2/process.js') }}" defer></script>
{{-- Defect Type --}}
<script src="{{ asset('js/mes2/defect.js') }}" defer></script>
{{-- QC --}}
<script src="{{ asset('js/mes2/qc.js') }}" defer></script>