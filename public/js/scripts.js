$(document).ready(function() {
	$(".alert").alert();
	$('.tooltip-overlay').tooltip({
		selector: "a[data-toggle=tooltip]"
	});
	$('noscript').remove();
});