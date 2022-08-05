@extends('layouts.app')

@section('title', $title)

@section('page-specific')
<script src="{{ mix('js/Item.js') }}"></script>
@endsection

@section('quick-admin')
<li class="nav-item">
	{{-- TODO: XlXi: Make this use route() --}}
	<a href="{{ url('/admin/moderate?id=' . $asset->id . '&type=asset') }}" class="nav-link py-0">Moderate Asset</a>
</li>
@endsection

@section('content')
<div class="container mx-auto py-5">
	@if(!$asset->approved)
		<div class="alert alert-danger text-center"><strong>This asset is pending approval.</strong> It will not appear in-game and cannot be voted on or purchased at this time.</div>
	@endif
	<div id="gt-item" class="graphictoria-item-page"
		@auth
			data-asset-id="{{ $asset->id }}"
			data-asset-name="{{ $asset->name }}"
			data-asset-creator="{{ $asset->user->username }}"
			data-asset-type="{{ $asset->typeString() }}"
			data-asset-on-sale="{{ $asset->onSale }}"
			@if ($asset->onSale)
				data-asset-price="{{ $asset->priceInTokens }}"
				data-user-currency="{{ Auth::user()->tokens }}"
				data-can-afford="{{ $asset->priceInTokens <= Auth::user()->tokens }}"
			@endif
		@endauth
	>
		<div class="card shadow-sm">
			<div class="card-body">
				<div class="d-flex">
					<div class="pe-4">
						<div class="border-1 position-relative">
							<img src={{ asset('images/testing/hat.png') }} alt="{{ $asset->name }}" class="border img-fluid" />
							<div id="gt-thumbnail-toolbar"></div>
							<div class="d-flex position-absolute bottom-0 end-0 pb-2 pe-2">
								<button class="btn btn-secondary me-2">Try On</button>
								<button class="btn btn-secondary">3D</button>
							</div>
						</div>
					</div>
					<div class="flex-fill">
						<h3 class="mb-0">{{ $asset->name }}</h3>
						<p>By <a class="text-decoration-none fw-normal" href="{{ $asset->user->getProfileUrl() }}">{{ $asset->user->username }}</a></p>
						<hr />
						{{-- TODO: XlXi: limiteds/trading --}}
						<div class="row mt-2">
							<div class="col-3 fw-bold">
								<p>Price</p>
							</div>
							<div class="col-9 d-flex">
								@if( $asset->onSale )
									<h4 class="my-auto" style="color:#e59800!important;font-weight:bold">
										<img src="{{ asset('images/symbols/token.svg') }}" height="32" width="32" class="img-fluid me-1" style="margin-top:-1px" />{{ number_format($asset->priceInTokens) }}</h4>
									</h4>
								@endif
								@auth
									<div id="gt-purchase-button" class="ms-auto">
										<button class="px-5 btn btn-lg btn-success" disabled>Buy</button>
									</div>
								@endauth
							</div>
						</div>
						<div class="row mt-2">
							<div class="col-3 fw-bold">
								<p>Type</p>
							</div>
							<div class="col-9">
								<p>{{ $asset->typeString() }}</p>
							</div>
						</div>
						<div class="row mt-2">
							<div class="col-3 fw-bold">
								<p>Created</p>
							</div>
							<div class="col-9">
								<p>{{ $asset->getCreated() }}</p>
							</div>
						</div>
						@if( $asset->getUpdated() != $asset->getCreated() )
							<div class="row mt-2">
								<div class="col-3 fw-bold">
									<p>Updated</p>
								</div>
								<div class="col-9">
									<p>{{ $asset->getUpdated() }}</p>
								</div>
							</div>
						@endif
						<div class="row mt-2">
							<div class="col-3 fw-bold">
								<p>Description</p>
							</div>
							<div class="col-9">
								@if ( $asset->description )
									<p>{{ $asset->description }}</p>
								@else
									<p class="text-muted">This item has no description.</p>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="gt-comments"
			data-can-comment="{{ intval(Auth::check()) }}"
			data-asset-id="{{ $asset->id }}"
		></div>
	</div>
</div>
@endsection