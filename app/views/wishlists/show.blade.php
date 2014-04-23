@extends('layouts.profile')

@section('content')
<div class="jumbotron jumbotron-sm">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <h1 class="h1 pull-right">
					Vēlmju saraksts <small>/ {{ $wishlist->title }}</small></h1>
            </div>
        </div>
    </div>
</div>
<div class="container">
	@if ($loggedIn)
	<div class="row">
		<div class="col-md-12">
			@if(Session::has('message'))
				<div id="success-message" class="alert alert-success alert-dismissable">
				  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				  {{ Session::get('message') }}
				</div>
			@endif
		</div>
	</div>
	@endif
	<div class="well well-md">
		<strong><a href="/{{ $profile->slug }}">Vēlmju saraksts</a> / {{ $wishlist->title }}</strong> 
		@if ($loggedIn && ($user->slug == $profile->slug))
			<a id="addWishBtn" class="btn btn-primary pull-right" data-toggle="modal" data-target="#addWishModal" href="/wishes/create/{{ $wishlist->id }}" title="Pievienot"><span class="glyphicon glyphicon-plus"></span>Pievienot jaunu</a>
		@endif
	</div>
	@if (count($wishlist->wishes) > 0)
	<?php $counter = 0; ?>
	@foreach ($wishlist->wishes as $wish)
		<?php
			if($counter == 0) {
				echo '<div class="row">';
			}
		?>
		<div class="col-md-6 wish">
			<div class="well well-sm">
				<div class="row">
					<div class="col-xs-3 col-md-3 text-center">
						@if ($wish->image)
							<img src="{{ Image::resize($wish->image, 400, 250, true) }}" class="img-rounded img-responsive" />
						@else
							<img src="/img/no_image.jpg" class="img-rounded img-responsive" />
						@endif
					</div>
					<div class="col-xs-9 col-md-9 section-box">
						<h2>
							{{ $wish->title }}
							@if($wish->link)
								<a id="wishLinkBtn" title="Saite" href="{{ $wish->link }}" target="_blank"><span class="glyphicon glyphicon-new-window">
							@endif
						</span></a>
					</h2>
					<p>
						{{ $wish->description }}</p>
						<hr />
                        <div class="row rating-desc">
                            <div class="col-md-12">
                            @if ($loggedIn && ($user->slug == $profile->slug))
                            	<div class="actions pull-right">
	                                <a id="editWishBtn" data-toggle="modal" data-target="#editWishModal" href="{{ URL::route('wishes.edit', $wish->id) }}" title="Rediģēt"><span class="glyphicon glyphicon-edit"></span></a>
									<a id="editWishImgBtn" data-toggle="modal" data-target="#editImgModal" href="/changeWishImage/{{ $wish->id }}" title="Mainīt bildi"><span class="glyphicon glyphicon-picture"></span></a>
	                                <a id="deleteWishBtn" href="{{ URL::route('wishes.destroy', $wish->id) }}" title="Dzēst" class="js-delete"><span class="glyphicon glyphicon-remove"></span></a>
                                </div>
                            @endif
                            </div>
                        </div>
					</div>
				</div>
			</div>
		</div>
		<?php
			$counter++;
			if($counter == 2) {
				echo '</div>';
				$counter = 0;
			}
		?>
		@endforeach
		@else
			<center>
				<h1>Te nekā nav :(</h1>
				<small>{{ $profile->first_name }} {{ $profile->last_name }} vēl nav pievienojis nevienu vēlmi šim srakstam</small>
			</center>
		@endif

</div>

<div class="modal modal-static fade" id="processing" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <img src="/img/loading.gif" class="icon" />
                    <h4>Dzēšu...</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addWishModal" tabindex="-1" role="dialog" aria-labelledby="addWishModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		</div> <!-- /.modal-content -->
	</div> <!-- /.modal-dialog -->
</div> <!-- /.modal -->

<div class="modal fade" id="editWishModal" tabindex="-1" role="dialog" aria-labelledby="editWishModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		</div> <!-- /.modal-content -->
	</div> <!-- /.modal-dialog -->
</div> <!-- /.modal -->

<div class="modal fade" id="editImgModal" tabindex="-1" role="dialog" aria-labelledby="editImgModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		</div>
	</div>
</div>
@stop

@section('scripts')
	<script type="text/javascript">
		$(document).ready(function() {
			
			$('a.js-delete').click(function(event){
				 event.preventDefault();
				 $(this).deleteModel('vēlmi', true, '.wish');
			});
			
			$('#wishLinkBtn, #editWishBtn, #deleteWishBtn, #editWishImgBtn').tooltip()
		});
	</script>
@stop