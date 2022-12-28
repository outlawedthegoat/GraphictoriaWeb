@extends('layouts.app')

@section('title', 'Games')

@section('page-specific')
<script src="{{ mix('js/Games.js') }}"></script>
@endsection

@section('content')
<div id="vb-games-main" class="container-sm my-2 d-flex flex-column">
	<h4 class="my-auto">Games</h4>
	<x-loader />
</div>
@endsection