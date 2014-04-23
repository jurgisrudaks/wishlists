var tweet = function(url, text) {
	window.open( "http://twitter.com/share?url=" + 
	encodeURIComponent(url) + "&text=" + 
	encodeURIComponent(text) + "&count=none/", 
	"tweet", "height=300,width=550,resizable=1" )
}
var postToFb = function(url) {
	window.open( "http://www.facebook.com/sharer.php?u=" + 
	encodeURIComponent(url),
	"post", "height=300,width=550,resizable=1" )
}
var shareOnGp = function(url) {
	window.open( "https://plus.google.com/share?url=" + 
	encodeURIComponent(url),
	"post", "height=300,width=550,resizable=1" )
}