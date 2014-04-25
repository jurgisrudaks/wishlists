@extends('layouts.profile')

@section('content')
<div class="jumbotron jumbotron-sm">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <h1 class="h1 pull-right">Vēlmju saraksti</h1>
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
	
	<div class="well well-sm">
		<div class="row">
			<div class="col-xs-6 col-sm-9 col-md-10">
				<strong>Vēlmju saraksti</strong> 
			</div>
			<div class="col-xs-6 col-sm-3 col-md-2">
				@if ($loggedIn && ($user->slug == $profile->slug))
					<a id="addWishListBtn" class="btn btn-primary pull-right" data-toggle="modal" data-target="#addWishlistModal" href="/wishlists/create" title="Pievienot"><span class="glyphicon glyphicon-plus"></span>Pievienot jaunu</a>
				@endif
			</div>
		</div>
	</div>
	@if (count($profile->wishlists) > 0)
		<?php $counter = 0; ?>
		@foreach ($profile->wishlists as $wishlist)
		<?php
			if($counter == 0) {
				echo '<div class="row list-group">';
			}
		?>
		<div class="item col-xs-12 col-sm-4 col-md-4 col-lg-4 wishlist">
			<div class="thumbnail">
				@if ($loggedIn && ($user->slug == $profile->slug))
					<a id="editWishlistImgBtn" data-toggle="modal" data-target="#editImgModal" href="/changeWishlistImage/{{ $wishlist->id }}" title="Mainīt bildi"><span class="glyphicon glyphicon-picture"></span></a>
				@endif	
				@if ($wishlist->image)
					<img class="group list-group-image" src="{{ Image::resize($wishlist->image, 400, 250, true) }}" alt="" />
				@else
					<img class="group list-group-image" src="/img/no_image.jpg" alt="" />
				@endif
				<div class="caption">
					<h4 class="group inner list-group-item-heading">{{{ $wishlist->title }}}</h4>
					<p class="group inner list-group-item-text">{{{ $wishlist->description }}}</p>
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<a class="btn btn-success" href="/{{ $profile->slug }}/{{ $wishlist->slug }}">Skatīt</a>
							@if ($loggedIn && ($user->slug == $profile->slug))
							<div class="actions pull-right" style="line-height: 35px;">
								<span class="share">
		                            <a href="javascript:void(0);" class="trigger"><span id="shareBtn" title="Kopīgot" class="glyphicon glyphicon-link"></span></a>
		                            <div class="head hide">
		                                Dalies ar saraksta saiti
		                                <a href="javascript:void(0);" class="pull-right" onclick="$('.share > .trigger').popover(&quot;hide&quot;);">&times;</a>
		                            </div>
		                            <div class="content hide">
		                                <center>
		                                    Saite uz sarakstu:
		                                    <input class="form-control" type="text" value="{{ Request::url() }}/{{ $wishlist->slug }}">
		                                    <br/>
		                                    <a href="javascript:void(0);" onclick="tweet('{{ Request::url() }}/{{ $wishlist->slug }}','Mans vēlmju saraksts')" class="btn btn-social-icon btn-twitter"><i class="fa fa-twitter"></i></a>
		                                    <a href="javascript:void(0);" onclick="postToFb('{{ Request::url() }}/{{ $wishlist->slug }}')" class="btn btn-social-icon btn-facebook"><i class="fa fa-facebook"></i></a>
		                                    <a href="javascript:void(0);" onclick="shareOnGp('{{ Request::url() }}/{{ $wishlist->slug }}')" class="btn btn-social-icon btn-google-plus"><i class="fa fa-google-plus"></i></a>
		                                </center>
		                            </div>
	                        	</span>
								<a id="editWishlistBtn" data-toggle="modal" data-target="#editWishlistModal" href="{{ URL::route('wishlists.edit', $wishlist->id) }}" title="Rediģēt"><span class="glyphicon glyphicon-edit"></span></a>
								<a id="deleteWishlistBtn" href="{{ URL::route('wishlists.destroy', $wishlist->id) }}" title="Dzēst" class="js-delete"><span class="glyphicon glyphicon-remove"></span></a>
							</div>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
			$counter++;
			if($counter == 3) {
				echo '</div>';
				$counter = 0;
			}
		?>
		@endforeach
@else
	<center>
		<h1>Te nekā nav :(</h1>
		<small>{{{ $profile->first_name }}} {{{ $profile->last_name }}} vēl nav izveidojis nevienu vēlmju sarakstu</small>
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

<div class="modal fade" id="editImgModal" tabindex="-1" role="dialog" aria-labelledby="editImgModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		</div>
	</div>
</div>

<div class="modal fade" id="editWishlistModal" tabindex="-1" role="dialog" aria-labelledby="editWishlistModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		</div>
	</div>
</div>

<div class="modal fade" id="addWishlistModal" tabindex="-1" role="dialog" aria-labelledby="addWishlistModal" aria-hidden="true">
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
				 $(this).deleteModel('vēlmju sarakstu', true, '.wishlist');
			});
			$('#editWishlistBtn, #deleteWishlistBtn, #shareBtn, #editWishlistImgBtn').tooltip()
		});
	</script>
@stop