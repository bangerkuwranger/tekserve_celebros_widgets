//Creates AJAX requests to populate content in widget structure
var $j = jQuery;
var loader = '<div class="tekserve_celebros_loading">\
   	<img src="' + qwiserData.loader + '" />\
   </div>';

$j(window).bind('load', function() {
	//finds each instance of widget on page, defines behavior based on second class of instance
	$j('.tekserve-celebros-related-items').each(function() {
	
		if ($j(this).hasClass('related-product')) {

			var profile = 'SiteDefault';
			var pageSize = parseInt(qwiserData.numProductsToDisplay, 10);

		} //end if ($j(this).hasClass('related-product'))
		
		if ($j(this).hasClass('related-content')) {

			var profile = 'Content';
			var pageSize = parseInt(qwiserData.numContentsToDisplay, 10);

		} //end if ($j(this).hasClass('related-content'))
		
		//get query for each section in widget stored in qwiserquery of div, perform query and return results via AJAX, then format and insert as html in $target
		$j(this).find('.tekserve-celebros-related-items-section').each(function() {

			var query = $j(this).attr('qwiserquery');
			var $target = $j(this).find('.tekserve-celebros-related-items-section-content');
			load_items($target, query, pageSize, profile);
// 			$target.html(loader + 'type: ' + profile + '<br/>query: ' + query + '<br/>pagesize: ' + pageSize);

		}); //end $j(this).find('.tekserve-celebros-related-items-section').each(function()

	}); //end $j('.tekserve-celebros-related-items').each(function() {

}); //end $j(window).bind('load', function()

function load_items($target, query, pageSize, profile){
	$j.ajax({
		type		: "GET",
		data		: {Query: query, PageSize: pageSize, Profile: profile},
		dataType	: "html",
		timeout		: 10000,
		url			: qwiserData.pluginUrl + "tekserve-celebros-jsapi.php",
		beforeSend	: function(){
			$target.append(loader);
			$loader = $target.find('.tekserve_celebros_loading');
			$loader.slideDown(25);
		},
		success    : function(data){
			$data = $j(data);
			$loader = $target.find('.tekserve_celebros_loading');
			if($data.length){
				$target.append($data);
				$loader.slideUp(25);
				$data.slideDown(500);
			}
			else {
				$loader.fadeOut(250);
			}
		},
		error     : function(jqXHR, textStatus, errorThrown) {
			$loader = $target.find('.tekserve_celebros_loading');
			$loader.fadeOut(250);
			alert(jqXHR + " :: " + textStatus + " :: " + errorThrown);
		}
	});
}